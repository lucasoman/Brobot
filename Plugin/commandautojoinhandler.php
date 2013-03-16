<?php

namespace Brobot\Handler;

class CommandAutoJoinHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && $this->isCommand('autojoin',$parts[3])) {
			$brobot = $this->getBot();
			$brobot->autoJoin();
		}
	}

	public function getHelp() {
		return 'autojoin - Join all channels in the autojoin config.';
	}
}

?>
