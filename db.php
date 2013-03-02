<?php

namespace Brobot;

class Db extends \Mysqli {
	const DBUSER = 'user';
	const DBPASS = 'password123';
	const DBHOST = '127.0.0.1';
	const DBPORT = 3306;
	const DBNAME = 'myDB';

	static $_instance;

	public function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new self(self::DBHOST,self::DBUSER,self::DBPASS,self::DBNAME,self::DBPORT);
		}
		return self::$_instance;
	}

	public function query($query) {
		$result = parent::query($query);
		if (!$result) {
			$this->ping();
			$result = parent::query($query);
		}
		return $result;
	}
}

?>
