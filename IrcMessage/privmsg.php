<?php

namespace Brobot\IrcMessage;

class Privmsg extends \Brobot\IrcMessage {
	const DEST_TYPE_CHANNEL = 1;
	const DEST_TYPE_USER = 2;

	protected $_destinationType;
	protected $_destination;
	protected $_message;
	protected static $_channelChars = array(
			'#'=>TRUE,
			'&'=>TRUE,
			);

	public function __construct($msg) {
		// :lucas!lucas@pN-5i9.no9.lf9tsd.IP PRIVMSG #brobottest :!fistbump
		preg_match('/([^\s]*) PRIVMSG ([^\s]*) :?(.*)/',$msg,$matches);
		$this->_fullAddress = $matches[1];
		$this->_destination = $matches[2];
		$this->_message = $matches[3];
		$this->populateSenderParts();

		if (isset(self::$_channelChars[substr($this->_destination,0,1)])) {
			$this->_destinationType = self::DEST_TYPE_CHANNEL;
		} else {
			$this->_destinationType = self::DEST_TYPE_USER;
		}
	}

	public function handle($plugin) {
		$plugin->onPrivmsg($this);
	}

	public function getDestinationType() {
		return $this->_destinationType;
	}

	public function getDestination() {
		return $this->_destination;
	}

	public function getMessage() {
		return $this->_message;
	}
}

?>
