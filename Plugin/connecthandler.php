<?php

namespace Brobot\Plugin;

class ConnectHandler extends \Brobot\Handler {
	public function handle($parts) {
		if ($parts[1] == '001') {
			$brobot = $this->getBot();
			$brobot->pluginConnect();
			$brobot->autoJoin();
		}
	}
}

?>
