<?php

namespace Brobot\IrcCommand;

class IrcJoin extends \Brobot\IrcCommand {
	protected $_channel;

	public function __construct($channel) {
		$this->_channel = (string)$channel;
	}

	public function __toString() {
		return 'JOIN '.$this->_channel;
	}
}

?>
