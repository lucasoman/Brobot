<?php

namespace Brobot\Plugin;

class Dude extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		if (strstr($message->getMessage(),'dude') !== FALSE) {
			$this->reply($message,'dude');
		}
	}
}

?>
