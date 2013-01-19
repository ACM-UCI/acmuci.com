<?php

require_once 'Validatable.php';

class Location extends Validatable {
	const TABLE_NAME = 'locations';

	private $bldg_id;
	private $location_full_name;
	private $location_short_name;

	public function __construct($bldg_id, $location_full_name,
	$location_short_name) {
		$this->bldg_id = $bldg_id;
		$this->location_full_name = $location_full_name;
		$this->location_short_name = $location_short_name;
	}

	public function validate() {
		$this->errors = array();
		if (!filter_var($this->bldg_id, FILTER_VALIDATE_INT))
			$this->addError('Building ID is invalid');
		if (empty($this->location_full_name))
			$this->addError('Full location name cannot be empty');
		if (empty($this->location_short_name))
			$this->addError('Short location name cannot be empty');
		if (!empty($this->location_full_name) &&
			!empty($this->location_short_name) &&
			sizeof($this->location_short_name) >
			sizeof($this->location_full_name)) {
			$this->addError('Short location name must be shorter than the long
			location name');
		}
		return empty($this->errors);
	}

	public function sanitize() {
		$this->bldg_id = filter_var($this->bldg_id, FILTER_SANITIZE_NUMBER_INT);
		$this->location_full_name = filter_var($this->location_full_name,
		FILTER_SANITIZE_STRING);
		$this->location_short_name = filter_var($this->location_short_name,
		FILTER_SANITIZE_STRING);
	}

	public function create() {
		$this->sanitize();
		if (!$this->validate())
			return false;
		$query = 'INSERT INTO ' . self::TABLE_NAME . ' (bldg_id,
		location_full_name, location_short_name) VALUES (:bldg_id,
		:location_full_name, :location_short_name)';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':bldg_id', $this->bldg_id, PDO::PARAM_INT);
		$stmt->bindParam(':location_full_name', $this->location_full_name);
		$stmt->bindParam(':location_short_name', $this->location_short_name);
		return $stmt->execute();
	}

	public function update() {
		$this->sanitize();
		if (!$this->validate())
			return false;
		$query = 'INSERT OR REPLACE INTO ' . self::TABLE_NAME . ' (bldg_id,
		location_full_name, location_short_name) VALUES (:bldg_id,
		:location_full_name, :location_short_name)';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':bldg_id', $this->bldg_id, PDO::PARAM_INT);
		$stmt->bindParam(':location_full_name', $this->location_full_name);
		$stmt->bindParam(':location_short_name', $this->location_short_name);
		return $stmt->execute();
	}

	public static function get($bldg_id) {
		$query = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE bldg_id = :bldg_id';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':bldg_id', $bldg_id, PDO::PARAM_INT);
		$stmt->setFetchMode(PDO::FETCH_OBJ);
		$stmt->execute();
		return $stmt->fetch();
	}

	public static function getAll() {
		$query = 'SELECT * FROM ' . self::TABLE_NAME;
		$stmt = $GLOBALS['db']->query($query);
		$stmt->setFetchMode(PDO::FETCH_OBJ);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}

?>
