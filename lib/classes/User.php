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

	public static function purchasesByColor () {
		$sql = "SELECT
				color,
				GROUP_CONCAT(CONCAT(name, ' (', count, ')') ORDER BY count DESC SEPARATOR ', ') AS services
			FROM (
				SELECT
					u.color,
					IFNULL(COALESCE(s2.name, s3.name), 'Ping-Pong') AS name,
					COUNT(IFNULL(COALESCE(s2.name, s3.name), 'Ping-Pong')) AS count
				FROM `" . Purchase::$table . "` p
				LEFT JOIN `" . User::$table . "` u ON u.id = p.user_id
				LEFT JOIN `" . Slot::$table . "` s ON s.id = p.slot_id
				LEFT JOIN `" . PingPong::$table . "` s1 ON s.service = 'ping-pong' AND s1.id = s.service_id
				LEFT JOIN `" . Seat::$table . "` s2 ON s.service = 'seat' AND s2.id = s.service_id
				LEFT JOIN `" . Office::$table . "` s3 ON s.service = 'office' AND s3.id = s.service_id
				GROUP BY u.color, s.service, s.service_id
			) counts
			GROUP BY color";
		return self::query($sql);
	}

}

?>
