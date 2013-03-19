<?php

namespace Brobot\Plugin;

class LoadPlugin extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		$messageString = $message->getMessage();
		$parts = explode(' ',$messageString);
		if ($this->isCommand('loadplugin',$messageString)) {
			$brobot = $this->getBot();
			$classname = strtolower($parts[1]);
			if ($brobot->addPlugin($classname)) {
				$this->reply($message,'Loaded '.$classname.' plugin.');
			} else {
				$this->reply($message,'Unable to load '.$classname.' plugin.');
			}
		} elseif ($this->isCommand('unloadplugin',$messageString)) {
			$brobot = $this->getBot();
			$classname = strtolower($parts[1]);
			if ($brobot->delPlugin($classname)) {
				$this->reply($message,'Unloaded '.$classname.' plugin.');
			} else {
				$this->reply($message,'Unable to unload '.$classname.' plugin.');
			}
		}
	}

	public function getHelp() {
		return '[un]loadplugin - Load or unload the given plugin.';
	}
}

?>
