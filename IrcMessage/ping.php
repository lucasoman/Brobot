<?php

namespace Brobot\IrcMessage;

class Ping extends \Brobot\IrcMessage { 
	protected $_message;

	public function __construct($msg) {
		preg_match('/^PING :?(.*)$/',$msg,$matches);
		$this->_message = $matches[1];
	}

	public function handle($plugin) {
		$plugin->onPing($this);
	}

	public function getMessage() {
		return $this->_message;
	}
}

?>
