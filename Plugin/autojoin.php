<?php

namespace Brobot\Plugin;

class Autojoin extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		if ($this->isCommand('autojoin',$message->getMessage())) {
			$brobot = $this->getBot();
			$brobot->autoJoin();
		}
	}

	public function getHelp() {
		return 'autojoin - Join all channels in the autojoin config.';
	}
}

?>
