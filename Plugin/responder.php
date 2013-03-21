<?php

namespace Brobot\Plugin;

class Responder extends \Brobot\Plugin {
	public function onPrivmsg($message) {
		$i = 0;
		while ($r = $this->getOption($i)) {
			$respond = FALSE;
			switch ($r['type']) {
				case 'command':
					if ($this->isCommand($r['match'],$message->getMessage())) {
						$respond = TRUE;
					}
					break;
				case 'has':
					if (strstr($message->getMessage(),$r['match']) !== FALSE) {
						$respond = TRUE;
					}
					break;
				case 'matches':
					if (preg_match($r['match'],$message->getMessage())) {
						$respond = TRUE;
					}
					break;
			}
			if ($respond) {
				$this->reply($message,$r['response']);
				break;
			}
			$i++;
		}
	}
}

?>
