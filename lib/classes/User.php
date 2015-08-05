<?php

include_once __DIR__ . '/Record.php';

class User extends Record {

	public static $table = 'users';

	public function checkPassword ($password) {

		if ($this->password == $password)
			return true;

		return false;
	}

	public static function withNoPurchases () {
		$sql = 'SELECT *
			FROM `' . self::$table . '`
			WHERE ' . self::$primary_key . ' NOT IN (
				SELECT DISTINCT(user_id)
				FROM purchases
			)';
		return self::queryInstantiate($sql);
	}

}

?>
