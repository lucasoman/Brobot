<?php

namespace Brobot\Plugin;

use Brobot;

class MsgQueue extends \Brobot\Plugin {
	private $_lastTime;

	public function __construct($bot) {
		parent::__construct($bot);
		$this->_lastTime = time();
	}

	public function execute() {
		$bot = $this->_bot;
		$now = $this->getCurrentTime();
		if ($this->_lastTime > ($now - $this->getOption('batch_seconds'))) {
			return;
		}
		$this->_lastTime = $now;
		$msgs = $this->getMessages();
		foreach ($msgs as $m) {
			$message = substr(str_replace("\n",' ',$m['command']),0,$this->getOption('command_max_len'));
			$bot->send($message);
		}
		$this->setSent($msgs);
	}

	protected function getMessages() {
		$msgs = array();
		if ($db = $this->getDb()) {
			$query = "
				select *
				from botCmdQueue
				where commandDate > CURRENT_TIMESTAMP - interval ".$this->getOption('minutes_back')." minute
				order by commandDate limit ".$this->getOption('batch_size')
				;
			$result = $db->query($query);
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$msgs[] = $row;
				}
			}
		}
		return $msgs;
	}

	protected function setSent($msgs) {
		if ($db = $this->getDb()) {
			$ids = array();
			foreach ($msgs as $m) {
				$ids[] = $m['id'];
			}
			if (!empty($ids)) {
				$query = "delete from botCmdQueue where id in (".implode(',',$ids).")";
				$db->query($query);
			}
		}
	}

	protected function getDb() {
		return Brobot\Db::getInstance();
	}

	public function queueMessage($message) {
		$db = Brobot\Db::getInstance();
		$query = "
			INSERT INTO botCmdQueue
			SET
				command='".$db->real_escape_string($message)."',
				commandDate=NOW()
			";
		$db->query($query);
		echo $db->error;
	}
}

?>
