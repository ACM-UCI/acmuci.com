<?php

require 'Validatable.php';

class Location extends Validatable {
	const TABLE_NAME = 'locations';

	public $room_id;
	public $bldg_id;
	public $location_full_name;
	public $location_short_name;

	public function __construct($room_id, $bldg_id, $location_full_name,
	$location_short_name) {
		$this->room_id = $room_id;
		$this->bldg_id = $bldg_id;
		$this->location_full_name = $location_full_name;
		$this->location_short_name = $location_short_name;
	}

	public function validate() {
		$this->errors = array();
		if (!filter_var($this->room_id, FILTER_VALIDATE_INT))
			$this->addError('Room is invalid');
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
		$this->room_id = filter_var($this->room_id, FILTER_SANITIZE_INT);
		$this->bldg_id = filter_var($this->bldg_id, FILTER_SANITIZE_INT);
		$this->location_full_name = filter_var($this->location_full_name,
		FILTER_SANITIZE_STRING);
		$this->location_short_name = filter_var($this->location_short_name,
		FILTER_SANITIZE_STRING);
	}

	public function create() {
		$this->sanitize();
		if (!$this->validate())
			return false;
		$query = 'INSERT INTO ' . self::TABLE_NAME . ' (room_id, bldg_id,
		location_full_name, location_short_name) VALUES (:room_id, :bldg_id,
		:location_full_name, :location_short_name)';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':room_id', $this->room_id, PDO::PARAM_INT);
		$stmt->bindParam(':bldg_id', $this->bldg_id, PDO::PARAM_INT);
		$stmt->bindParam(':location_full_name', $this->location_full_name);
		$stmt->bindParam(':location_short_name', $this->location_short_name);
		return $stmt->execute();
	}

	public static function read($room_id, $bldg_id) {
		$query = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE room_id =
		:room_id AND bldg_id = :bldg_id';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
		$stmt->bindParam(':bldg_id', $bldg_id, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Location');
		return ($stmt->rowCount === 1) ? $stmt->fetch() : null;
	}
}

?>
