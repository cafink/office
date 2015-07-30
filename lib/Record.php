<?php

include_once __DIR__ . '/config.php';

class RecordException extends Exception { }
class DatabaseException extends RecordException { }

abstract class Record {

	// The record's data as an associative array.
	protected $record;

	// The name of the database table.
	protected $table;

	function __construct ($record = null) {
		$this->record = (is_null($record) ? array() : $record);
		if (!is_array($this->record)) throw new RecordException('Record must be an array.');
	}

	// Create a record instance from an associative array.
	protected function instantiate ($data) {
		return new $this($data);
	}

	// Build a SQL query from field names & values
	protected function buildQuery ($fields = null, $values = null, $first = false) {
		$sql = "SELECT * FROM {$this->table}";

		if (!empty($fields)) {

			$sql .= ' WHERE ';

			if (!is_array($fields))
				$fields = array($fields);
			if (!is_array($values))
				$values = array($values);

			$conditions = array();
			foreach ($fields as $i => $field)
				$conditions[] = $field . " = '{$values[$i]}'";

			$sql .= implode(' AND ', $conditions);
		}

		if ($first)
			$sql .= ' LIMIT 0, 1';

		return $sql;
	}

	// Run a query; return results as array of records.
	public function query ($sql) {

		if (!isset($GLOBALS['config']['db']))
			throw new DatabaseException('Database connection information not provided.');

		$db = new mysqli(
			$GLOBALS['config']['db']['host'],
			$GLOBALS['config']['db']['username'],
			$GLOBALS['config']['db']['password'],
			$GLOBALS['config']['db']['dbname']
		);

		if ($db->connect_errno)
			throw new DatabaseException('Database connection failed: ' . $db->connect_error);

		$results = $db->query($sql);

		if (!$results) {
			$error = $db->error;
			$db->close();
			throw new DatabaseException($error);
		}

		$db->close();
		$results = $results->fetch_all(MYSQLI_ASSOC);
		return $results;
	}

	// Find records by field names & values.
	public function find ($fields = null, $values = null, $first = false) {

		$sql = $this->buildQuery($fields, $values, $first);
		$results = $this->query($sql);

		$instances = array();
		foreach ($results as $result)
			$instances[] = $this->instantiate($result);

		return $instances;
	}

	// Get a single record by id.
	public function get ($id) {
		return $this->find('id', $id, true);
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
