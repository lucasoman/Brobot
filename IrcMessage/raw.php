<?php

namespace Brobot\IrcMessage;

class Raw extends \Brobot\IrcMessage {
	protected $_code;
	protected $_message;

	public function __construct($msg) {
		// :barjavel.freenode.net 001 brobot_test :Welcome to the freenode Internet Relay Chat Network brobot_test
		preg_match('/^:([^\s]+) ([\d]+) ([^\s]+) :(.*)/',$msg,$matches);
		$this->_fullAddress = $matches[1];
		$this->_code = $matches[2];
		$this->_message = $matches[4];
	}

	public function handle($plugin) {
		$plugin->onRaw($this);
	}

	public function getCode() {
		return $this->_code;
	}

	public function getMessage() {
		return $this->_message;
	}
}

?>
