<?php

namespace Brobot\Plugin;

class Help extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		if ($this->isCommand('help',$message->getMessage())) {
			$this->sendHelp($message);
		}
	}

	private function sendHelp($message) {
		$plugins = $this->getBot()->getPlugins();
		foreach ($plugins as $p) {
			if (($msg = $p->getHelp()) !== NULL) {
				$this->reply($message,$msg);
			}
		}
	}

	public function getHelp() {
		return 'help - Show this help.';
	}
}

?>
