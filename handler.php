<?php

namespace Brobot;

class Handler {
	protected $_bot;

	public function __construct($bot) {
		$this->_bot = $bot;
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

	protected function getBot() {
		return $this->_bot;
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

	protected function getSenderParts($address) {
		//:lucas!~lucas@172.16.15.106 PRIVMSG brobot :!autojoin
		preg_match('/^:([^!]+)!([^@]+)@(.+)$/',$address,$matches);
		array_shift($matches);
		return $matches;
	}

	public function getHelp() {
		return NULL;
	}
}

?>
