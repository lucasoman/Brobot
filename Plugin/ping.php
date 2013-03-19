<?php

namespace Brobot\Plugin;

use Brobot\Plugin\PlugintimeoutCheck;

class Ping extends \Brobot\Plugin {
	public function onPing($message) {
		$this->getBot()->send('PONG '.$message->getMessage());
		TimeoutCheck::setLastPing($this->getCurrentTime());
	}

	public function onPrivmsg($message) {
		TimeoutCheck::setLastPing($this->getCurrentTime());
	}
}

?>
