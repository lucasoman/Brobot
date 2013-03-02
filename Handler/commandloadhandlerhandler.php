<?php

namespace Brobot\Handler;

class CommandLoadHandlerHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && $this->isCommand('loadhandler',$parts[3])) {
			$brobot = $this->getBot();
			$classname = strtolower($parts[4]);
			if ($brobot->addHandler($classname)) {
				$this->reply($parts,'Loaded '.$classname.' handler.');
			} else {
				$this->reply($parts,'Unable to load '.$classname.' handler.');
			}
		} elseif ($parts[1] == 'PRIVMSG' && $this->isCommand('unloadhandler',$parts[3])) {
			$brobot = $this->getBot();
			$classname = strtolower($parts[4]);
			if ($brobot->delHandler($classname)) {
				$this->reply($parts,'Unloaded '.$classname.' handler.');
			} else {
				$this->reply($parts,'Unable to unload '.$classname.' handler.');
			}
		}
	}

	public function getHelp() {
		return '[un]loadhandler - Load or unload the given handler.';
	}
}

?>
