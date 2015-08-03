<?php

include_once __DIR__ . '/Record.php';

class Purchase extends Record {

	public static $table = 'purchases';

	function quantities () {
		$sql = 'SELECT COUNT(*), `slot_id`
			FROM `purchases`
			GROUP BY `slot_id`';
		return self::query($sql);
	}
}

?>
