<?php

namespace Brobot\Plugin;

class Tea extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		if ($this->isCommand('tea',$message->getMessage())) {
			$this->reply($message,'One lump or two?');
		}
	}

	public function getHelp() {
		return 'tea - Ask for a cup of tea.';
	}
}

?>

