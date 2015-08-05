<?php

include_once __DIR__ . '/Record.php';
include_once __DIR__ . '/Slot.php';

class Purchase extends Record {

	public static $table = 'purchases';

	function validate () {

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

		return $errors;
	}

	function quantities () {
		$sql = 'SELECT COUNT(*), `slot_id`
			FROM `purchases`
			GROUP BY `slot_id`';
		return self::query($sql);
	}

	function slot () {
		return Slot::get($this->slot_id);
	}
}

?>
