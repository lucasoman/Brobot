<?php

namespace Brobot\Plugin;

class Connect extends \Brobot\Plugin {
	public function onRaw($message) {
		if ($message->getCode() == '001') {
			$brobot = $this->getBot();
			$brobot->pluginConnect();
			$brobot->autoJoin();
		}
	}
}

?>
