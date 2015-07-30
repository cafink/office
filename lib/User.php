<?php

include_once __DIR__ . '/Record.php';

class User extends Record {

	public static $table = 'users';

	function checkPassword ($password) {

		if ($this->password == $password)
			return true;

		return false;
	}

}

?>
