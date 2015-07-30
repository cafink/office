<?php

class RecordException extends Exception { }

abstract class Record {

	// The record's data as an associative array.
	protected $record;

	function __construct ($record = null) {
		$this->record = (is_null($record) ? array() : $record);
		if (!is_array($this->record)) throw new RecordException('Record must be an array.');
	}

	// Create a record instance from an associative array.
	protected function instantiate ($data) {
		return new $this($data);
	}

	/* overloaded functions for getting/setting fields */

	public function __get ($field) {
		if (isset($this->record[$field]))
			return $this->record[$field];
	}

	public function __set ($field, $value) {
		$this->row[$field] = $value;
	}

}

?>
