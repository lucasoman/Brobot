<?php

namespace Brobot;

class Plugin {
	protected $_bot;

	public function __construct($bot) {
		$this->_bot = $bot;
	}

	protected function getBot() {
		return $this->_bot;
	}

	public function execute() {
		return;
	}

	public function onConnect() {
		return;
	}

	public function onDisconnect() {
		return;
	}
}

?>
