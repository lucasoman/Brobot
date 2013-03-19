<?php

namespace Brobot;

class Plugin {
	protected $_bot;
	protected static $_currentTime;

	public function __construct($bot) {
		$this->_bot = $bot;
	}

	protected function getBot() {
		return $this->_bot;
	}

	public function execute() {
		return;
	}

	public function onConnect() {
		return;
	}

	public function onDisconnect() {
		return;
	}

	public function onPrivmsg($message) {
	}

	public function onNotice($message) {
	}

	public function onRaw($message) {
	}

	public function onPing($message) {
	}

	public function onJoin($message) {
	}

	public function onPart($message) {
	}

	public function onQuit($message) {
	}

	protected function isCommand($command,$string) {
		if (preg_match('/^:?'.$this->getBot()->getCommandChar().$command.'(\s.*)?$/',$string)) {
			return TRUE;
		}
		return FALSE;
	}

	protected function reply($message,$toSend) {
		if ($message->getDestinationType() == IrcMessage\Privmsg::DEST_TYPE_CHANNEL) {
			$this->getBot()->sendPrivateMessage($toSend,$message->getDestination());
		} else {
			$this->getBot()->sendPrivateMessage($toSend,$message->getSenderNick());
		}
	}

	public function getHelp() {
		return NULL;
	}

	public static function setCurrentTime($time) {
		self::$_currentTime = $time;
	}

	public function getCurrentTime() {
		return self::$_currentTime;
	}
}

?>
