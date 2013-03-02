<?php

namespace Brobot;

class Db extends \Mysqli {
	static protected $_dbUser;
	static protected $_dbPass;
	static protected $_dbHost;
	static protected $_dbPort;
	static protected $_dbName;

	static $_instance;

	static public function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new self(self::$_dbHost,self::$_dbUser,self::$_dbPass,self::$_dbName,self::$_dbPort);
		}
		return self::$_instance;
	}

	public function query($query) {
		$result = parent::query($query);
		if (!$result) {
			$this->ping();
			$result = parent::query($query);
		}
		return $result;
	}

	public function setConfig($options) {
		self::$_dbUser = $options['db_user'];
		self::$_dbPass = $options['db_pass'];
		self::$_dbHost = $options['db_ip'];
		self::$_dbPort = $options['db_port'];
		self::$_dbName = $options['db_name'];
	}
}

?>
