<?php

include_once __DIR__ . '/Record.php';
include_once __DIR__ . '/Slot.php';

class Purchase extends Record {

	public static $table = 'purchases';

	public function validate () {

		$errors = array();

		if (empty($this->user_id))
			$errors['user_id'] = 'User not specified.';

		if (empty($this->slot_id)) {
			$errors['slot_id'] = 'Slot not specified.';
		} else {
			$slot = $this->slot();
			if ($slot->numAvailable() < 1)
				$errors['slot_id'] = 'Slot not available.';
		}

		if ($this->alreadyBooked())
			$errors['slot_id'] = 'You have already purchased a slot at that time.';

		if ($this->inThePast())
			$errors['slot_id'] = 'You cannot purchase a slot in the past.';

		return $errors;
	}

	public function quantities () {
		$sql = 'SELECT COUNT(*), `slot_id`
			FROM `purchases`
			GROUP BY `slot_id`';
		return self::query($sql);
	}

	public function slot () {
		return Slot::get($this->slot_id);
	}

	public function time () {
		$slot = $this->slot();
		return $slot->time;
	}

	public function alreadyBooked () {
		$purchases = self::findByUserAndTime($this->user_id, $this->time());
		return count($purchases) > 0;
	}

	public function inThePast () {
		return $this->time() < date('Y-m-d H:i:s');
	}

	public static function findByUserAndTime ($user_id, $time) {
		$sql = 'SELECT p.*
			FROM `' . self::$table . '` p
			LEFT JOIN `' . Slot::$table . "` s ON s.id = p.slot_id
			WHERE p.user_id = {$user_id}
			AND s.time = '{$time}'";
		return self::queryInstantiate($sql);
	}

	public static function purchasesThisMonth () {
		$sql = 'SELECT *
			FROM `' . self::$table . "`
			WHERE DATE_FORMAT(purchased_at, '%Y-%m') = '" . date('Y-m') . "'";
		return self::queryInstantiate($sql);
	}
}

?>
