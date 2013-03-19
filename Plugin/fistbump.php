<?php

namespace Brobot\Plugin;

class Fistbump extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		if ($this->isCommand('fistbump',$message->getMessage())) {
			$this->reply($message,'Yeah man.');
		}
	}

	public function getHelp() {
		return 'fistbump - Fistbump the bot.';
	}
}

?>
