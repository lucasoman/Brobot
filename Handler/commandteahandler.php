<?php

namespace Brobot\Handler;

class CommandTeaHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && $this->isCommand('tea',$parts[3])) {
			$this->reply($parts,'One lump or two?');
		}
	}

	public function getHelp() {
		return 'tea - Ask for a cup of tea.';
	}
}

?>

