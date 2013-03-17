<?php

namespace Brobot;

class Plugin {
	protected $_bot;

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
		if (preg_match('/^:?'.$this->getBot()->getCommandChar().$command.'$/',$string)) {
			return TRUE;
		}
		return FALSE;
	}

	protected function reply($parts,$message) {
		if (substr($parts[2],0,1) == '#') {
			$this->getBot()->sendPrivateMessage($message,$parts[2]);
		} else {
			$addyParts = $this->getSenderParts($parts[0]);
			$nick = $addyParts[0];
			$this->getBot()->sendPrivateMessage($message,$nick);
		}
	}

	public function getHelp() {
		return NULL;
	}
}

?>
