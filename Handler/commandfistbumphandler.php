<?php

namespace Brobot\Handler;

class CommandFistbumpHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && $this->isCommand('fistbump',$parts[3])) {
			$this->reply($parts,'Yeah man.');
		}
	}

	public function getHelp() {
		return 'fistbump - Fistbump the bot.';
	}
}

?>
