<?php

namespace Brobot\Plugin;

class TimeoutCheck extends \Brobot\Plugin {
	protected static $_lastPing = NULL;

	public function __construct() {
		parent::__construct($bot);
	}

	public static function setLastPing($time) {
		self::$_lastPing = $time;
	}

	public function onConnect() {
		self::setLastPing($this->getCurrentTime());
	}

	public function onDisconnect() {
		self::setLastPing(NULL);
	}

	public function execute() {
		if (self::$_lastPing !== NULL && ($this->getCurrentTime() - self::$_lastPing) >= $this->getOption('timeout')) {
			throw new \Brobot\ConnectionException('Ping timeout.');
		}
	}
}
