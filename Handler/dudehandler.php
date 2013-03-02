<?php

namespace Brobot\Handler;

class DudeHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == 'PRIVMSG' && strstr($parts[3],'dude')) {
			$this->reply($parts,'dude');
		}
	}
}

?>
