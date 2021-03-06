<?php

include_once __DIR__ . '/Record.php';
include_once __DIR__ . '/Purchase.php';
include_once __DIR__ . '/PingPong.php';
include_once __DIR__ . '/Seat.php';
include_once __DIR__ . '/Office.php';

class Slot extends Record {

	public static $table = 'slots';

	public static function available ($service = null, $service_id = null) {

		$sql = 'SELECT s.*, COUNT(p.id) AS count
			FROM `' . self::$table . '` s
			LEFT JOIN `' . Purchase::$table . '` p ON p.slot_id = s.id
			WHERE s.time > NOW()';

		if (!is_null($service))
			$sql .= " AND s.service = '" . mysql_escape_string($service) . "'";
		if (!is_null($service_id))
			$sql .= " AND s.service_id = '" . mysql_escape_string($service_id) . "'";

		$sql .= ' GROUP BY s.id HAVING count < s.quantity';
		return self::queryInstantiate($sql);
	}

	public static function soldOut ($service = null, $service_id = null) {

		$sql = 'SELECT s.*, COUNT(p.id) AS count
			FROM `' . Purchase::$table . '` p
			LEFT JOIN `' . self::$table . '` s ON s.id = p.slot_id';

		if (!is_null($service))
			$sql .= " WHERE service = '" . mysql_escape_string($service) . "'";
		if (!is_null($service_id))
			$sql .= " AND service_id = '" . mysql_escape_string($service_id) . "'";

		$sql .= ' GROUP BY p.slot_id HAVING count >= s.quantity';
		return self::queryInstantiate($sql);
	}

	public static function availableServiceTypes () {

		$sql = 'SELECT DISTINCT(available.service)
			FROM (
				SELECT s.*, COUNT(p.id) AS count
				FROM `' . self::$table . '` s
				LEFT JOIN `' . Purchase::$table . '` p ON p.slot_id = s.id
				WHERE s.time > NOW()
				GROUP BY s.id
				HAVING count < s.quantity
			) as available';

		$results = self::query($sql);

		// We just want an array of service names,
		// rather than an array of associative arrays.
		$services = array();
		foreach ($results as $result)
			$services[] = $result['service'];

		return $services;
	}

	public static function availableServices ($type) {

		$service_class = self::className($type);
		$table = $service_class::$table;

		$sql = "SELECT DISTINCT (available.service_id), service.*
			FROM (
				SELECT s.*, COUNT(p.id) AS count
				FROM `" . self::$table . "` s
				LEFT JOIN `" . Purchase::$table . "` p ON p.slot_id = s.id
				WHERE s.service = '" . mysql_escape_string($type) . "'
				AND s.time > NOW()
				GROUP BY s.id
				HAVING count < s.quantity
			) as available
			LEFT JOIN `" . $service_class::$table . "` service ON service.id = available.service_id
			ORDER BY service.price DESC";

		return self::queryInstantiate($sql);
	}

	public function numSold () {
		return count(Purchase::find('slot_id', $this->id));
	}

	public function numAvailable () {
		return $this->quantity - $this->numSold();
	}
}

?>
