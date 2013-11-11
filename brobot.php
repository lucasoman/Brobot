<?php

namespace Brobot;
use Brobot\Plugin;
use Brobot\IrcCommand;
use Brobot\IrcMessage;

require('db.php');
require('plugin.php');
require('irccommand.php');
require('ircmessage.php');
require('connectionexception.php');

class Brobot {
	const CONFIG_FILE = 'config.php';

	protected $_config;
	protected $_socket;
	protected $_plugins;
	protected $_index;

	// config stuff
	protected $_handlerDir;
	protected $_pluginDir;
	protected $_irccommandDir;
	protected $_commandChar;
	protected $_logFile;
	protected $_pluginConfig;

	public function __construct($index=0) {
		$this->_index = $index;
		$this->_plugins = array();

		$this->loadConfig();
		$this->loadAllPlugins();
		$this->loadAllIrcCommands();
		$this->loadAllIrcMessages();
	}

	public function loadConfig() {
		$config = require(self::CONFIG_FILE);
		$this->setConfig($config['servers'][$this->_index]);

		$this->_handlerDir = $config['runtime']['handler_dir'];
		$this->_pluginDir = $config['runtime']['plugin_dir'];
		$this->_irccommandDir = $config['runtime']['irccommand_dir'];
		$this->_ircmessageDir = $config['runtime']['ircmessage_dir'];

		$this->_commandChar = $config['runtime']['command_char'];
		$this->_logFile = $config['runtime']['log_file'];

		$this->_pluginConfig = $config['plugins'];

		foreach ($this->_plugins as $p) {
			$pName = explode('\\',strtolower(get_class($p)));
			$pName = $pName[count($pName) - 1];
			if (isset($config['plugins'][$pName])) {
				$p->setOptions($config['plugins'][$pName]);
			}
		}

		Db::setConfig($config['database']);
	}

	public function go() {
		// start connection loop
		while (1) {
			$this->connect();
			sleep(5);
		}
	}

	public function autoJoin() {
		foreach ($this->getConfig('channels') as $c) {
			$obj = new IrcCommand\IrcJoin($c);
			$this->queue((string)$obj);
		}
	}

	public function addPlugin($plugin) {
		$classFile = $this->_pluginDir.$plugin.'.php';
		$plugin = '\\Brobot\\Plugin\\'.$plugin;
		if (file_exists($classFile)) {
			include_once($classFile);
			if (class_exists($plugin)) {
				$p = new $plugin($this);
				$pName = explode('\\',strtolower(get_class($p)));
				$pName = $pName[count($pName) - 1];
				if (isset($this->_pluginConfig[$pName])) {
					$p->setOptions($this->_pluginConfig[$pName]);
				}
				$this->_plugins[] = $p;
				return TRUE;
			}
		}
		return FALSE;
	}

	public function delPlugin($name) {
		$name = strtolower($name);
		foreach ($this->_plugins as $i=>$p) {
			if (strtolower(get_class($p)) == $name) {
				unset($this->_plugins[$i]);
				return TRUE;
			}
		}
		return FALSE;
	}

	public function getPlugins() {
		return $this->_plugins;
	}

	public function send($msg) {
		$this->console('SEND: '.$msg."\n");
		fputs($this->_socket,$msg."\n");
	}

	public function queue($msg) {
		Plugin\MsgQueue::queueMessage($msg);
	}

	public function sendPrivateMessage($message,$nick) {
		$obj = new IrcCommand\IrcPrivmsg($nick,$message);
		$this->queue((string)$obj);
	}

	public function getChannel() {
		$chans = $this->getConfig('channels');
		return $chans[0];
	}

	public function getCommandChar() {
		return $this->_commandChar;
	}

	public function pluginConnect() {
		foreach ($this->_plugins as $p) {
			$p->onConnect();
		}
	}

	public function pluginDisconnect() {
		foreach ($this->_plugins as $p) {
			$p->onDisconnect();
		}
	}

	public function console($message) {
		$file = fopen($this->_logFile,'a');
		fwrite($file,'['.date('Y-m-d H:i:s').'] '.$message);
		fclose($file);
	}

	protected function connect() {
		$this->console("Attempting connect.\n");
		if (!$this->createSocket()) {
			$this->console("Failed to create socket.\n");
			return FALSE;
		}
		$this->introduction();
		return $this->processLoop();
	}

	protected function loadAllPlugins() {
		$this->loadAll($this->_pluginDir,function ($cn,$bot) { $bot->addPlugin($cn); });
	}

	protected function loadAllIrcCommands() {
		$this->loadAll($this->_irccommandDir);
	}

	protected function loadAllIrcMessages() {
		$this->loadAll($this->_ircmessageDir);
	}

	protected function loadAll($dir,$callBack=NULL) {
		$d = dir($dir);
		while ($file = $d->read()) {
			if (is_file($dir.$file) && preg_match("/\.php$/", $file) ) {
				require_once($dir.$file);
				$classname = preg_replace('/\.php$/','',$file);
				if (!is_null($callBack)) {
					$callBack($classname,$this);
				}
			}
		}
		$d->close();
	}

	protected function processLoop() {
		$this->console("Starting process loop.\n");
		$last = time();
		try {
			while (1) {
				usleep(200000);
				while ($data = fgets($this->_socket)) {
					$this->handle($data);
				}
				$meta = stream_get_meta_data($this->_socket);
				if ($meta['timed_out']) {
					throw new ConnectionException('Timed out.');
				}
				$now = time();
				if ($now > $last) { // execute plugins once per second
					$this->executePlugins();
					$last = $now;
				}
			}
		} catch (ConnectionException $e) {
			$this->console('Connection error: '.$e->getMessage()."\n");
		} catch (Exception $e) {
			$this->console('Error: '.$e->getMessage()."\n");
		}
		stream_socket_shutdown($this->_socket,STREAM_SHUT_RDWR);
		$this->_socket = NULL;
		$this->console("Process loop failed.\n");
		$this->pluginDisconnect();
		return FALSE;
	}

	protected function handle($message) {
		$this->console($message);
		$mObj = IrcMessage::getInstance($message);
		foreach ($this->_plugins as $plugin) {
			$mObj->handle($plugin);
		}
	}

	protected function createSocket() {
		$this->console("Creating socket.\n");
		if (!($this->_socket = stream_socket_client($this->getConfig('server').':'.$this->getConfig('port')))) {
			return FALSE;
		}
		stream_set_blocking($this->_socket,0);
		return TRUE;
	}

	protected function introduction() {
		$this->console("Sending introduction.\n");
		$pass = $this->getConfig('pass');
		if (!empty($pass)) {
			$this->send('PASS '.$pass);
		}
		$n = $this->getConfig('user');
		$this->send('USER '.$n.' '.$n.' '.$n.' '.$n.' :'.$n);
		$this->send('NICK '.$this->getConfig('nick'));
	}

	protected function setConfig($config) {
		$this->_config = $config;
	}

	protected function getConfig($name) {
		return isset($this->_config[$name]) ? $this->_config[$name] : NULL;
	}

	protected function executePlugins() {
		Plugin::setCurrentTime(time());
		foreach ($this->_plugins as $p) {
			$p->execute();
		}
	}
}

?>
