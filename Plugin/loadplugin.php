<?php

namespace Brobot\Plugin;

class CommandLoadPluginHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && $this->isCommand('loadplugin',$parts[3])) {
			$brobot = $this->getBot();
			$classname = strtolower($parts[4]);
			if ($brobot->addPlugin($classname)) {
				$this->reply($parts,'Loaded '.$classname.' plugin.');
			} else {
				$this->reply($parts,'Unable to load '.$classname.' plugin.');
			}
		} elseif ($parts[1] == 'PRIVMSG' && $this->isCommand('unloadplugin',$parts[3])) {
			$brobot = $this->getBot();
			$classname = strtolower($parts[4]);
			if ($brobot->delPlugin($classname)) {
				$this->reply($parts,'Unloaded '.$classname.' plugin.');
			} else {
				$this->reply($parts,'Unable to unload '.$classname.' plugin.');
			}
		}
	}

	public function getHelp() {
		return '[un]loadplugin - Load or unload the given plugin.';
	}
}

?>
