<?php

namespace Brobot\Plugin;

use Brobot\Plugin\PlugintimeoutCheck;

class PingHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[0] == 'PING') {
			array_shift($parts);
			$this->getBot()->send('PONG '.implode(' ',$parts));
			PluginTimeoutCheck::setLastPing(time());
			return TRUE;
		} else {
			PluginTimeoutCheck::setLastPing(time());
		}
		return FALSE;
	}
}

?>
