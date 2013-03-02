<?php

namespace Brobot\IrcCommand;

class IrcPrivmsg extends \Brobot\IrcCommand {
	protected $_dest;
	protected $_message;

	public function __construct($dest,$message) {
		$this->_dest = (string)$dest;
		$this->_message = (string)$message;
	}

	public function __toString() {
		return 'PRIVMSG '.$this->_dest.' :'.$this->_message;
	}
}

?>
