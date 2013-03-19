<?php

namespace Brobot;

use Brobot\IrcMessage;

abstract class IrcMessage {
	protected $_fullAddress;
	protected $_senderNick;
	protected $_senderUser;
	protected $_senderAddress;

	abstract public function handle($plugin);

	public function getInstance($msg) {
		$parts = explode(' ',$msg);
		if ($parts[1] == 'PRIVMSG') {
			return new IrcMessage\Privmsg($msg);
		} elseif ($parts[0] == 'PING') {
			return new IrcMessage\Ping($msg);
		} elseif (is_numeric($parts[1])) {
			return new IrcMessage\Raw($msg);
		} else {
			return new IrcMessage\Unknown($msg);
		}
	}

	public function getSenderNick() {
		$this->populateSenderParts();
		return $this->_senderNick;
	}

	public function getSenderUser() {
		$this->populateSenderParts();
		return $this->_senderUser;
	}

	public function getSenderAddress() {
		$this->populateSenderParts();
		return $this->_senderAddress;
	}

	protected function populateSenderParts() {
		if (is_null($this->_senderNick)) {
			//:lucas!~lucas@172.16.15.106 PRIVMSG brobot :!autojoin
			preg_match('/^:([^!]+)!([^@]+)@(.+)$/',$this->_fullAddress,$matches);
			$this->_senderNick = $matches[1];
			$this->_senderUser = $matches[2];
			$this->_senderAddress = $matches[3];
		}
	}
}

?>
