<?php

namespace Brobot\Plugin;

class TimeoutCheck extends \Brobot\Plugin {
	const TIMEOUT = 360;

	protected static $_lastPing = NULL;

	public function __construct() {
		parent::__construct($bot);
	}

	public static function setLastPing($time) {
		self::$_lastPing = $time;
	}

	public function onConnect() {
		self::setLastPing(time());
	}

	public function onDisconnect() {
		self::setLastPing(NULL);
	}

	public function execute() {
		if (self::$_lastPing !== NULL && (time() - self::$_lastPing) >= self::TIMEOUT) {
			throw new ConnectionException('Ping timeout.');
		}
	}
}
