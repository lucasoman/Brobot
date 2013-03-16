<?php

namespace Brobot\Handler;

class CommandHelpHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && $this->isCommand('help',$parts[3])) {
			$this->sendHelp($parts);
		}
	}

	private function sendHelp($parts) {
		$handlers = $this->getBot()->getHandlers();
		foreach ($handlers as $h) {
			if (($msg = $h->getHelp()) !== NULL) {
				$this->reply($parts,$msg);
			}
		}
	}

	public function getHelp() {
		return 'help - Show this help.';
	}
}

?>
