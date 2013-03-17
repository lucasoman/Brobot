<?php

namespace Brobot\Plugin;

class CommandReloadHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && $this->isCommand('reload',$parts[3])) {
			$brobot = $this->getBot();
			$brobot->loadConfig();
			$this->reply($parts,'Reloaded config.');
		}
	}

	public function getHelp() {
		return 'reload - Reload the bot\'s config.';
	}
}

?>
