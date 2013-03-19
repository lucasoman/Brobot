<?php

namespace Brobot\Plugin;

class Reload extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		if ($this->isCommand('reload',$message->getMessage())) {
			$brobot = $this->getBot();
			$brobot->loadConfig();
			$this->reply($message,'Reloaded config.');
		}
	}

	public function getHelp() {
		return 'reload - Reload the bot\'s config.';
	}
}

?>
