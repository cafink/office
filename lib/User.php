<?php

include_once __DIR__ . '/Record.php';

class User extends Record {

	protected static $table = 'users';

	static function checkPassword ($email, $password) {

		$user = self::find('email', $email, true);

		if (!empty($user) && $user->password == $password)
			return true;

		return false;
	}

}

?>
