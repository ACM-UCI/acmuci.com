<?php

require 'Validatable.php';

class Event extends Validatable {
	const TABLE_NAME = 'events';

	private $event_id;
	private $event_name;
	private $event_datetime;
	private $event_desc;
	private $event_room_id;
	private $event_bldg_id;
	private $event_expired;

	public function __construct($event_name, $event_desc,
	$event_datetime, $event_room_id, $event_bldg_id, $event_expired = 0) {
		$this->event_name = $event_name;
		$this->event_desc = $event_desc;
		$this->event_datetime = $event_datetime;
		$this->event_room_id = $event_room_id;
		$this->event_bldg_id = $event_bldg_id;
		$this->event_expired = $event_expired;
	}

	public function validate() {
		$this->errors = array();
		if (empty($this->event_name))
			$this->addError('Event name cannot be empty');
		if (empty($this->event_desc))
			$this->addError('Event description cannot be empty');
		if (empty($this->event_datetime))
			$this->addError('Event must have a date and time');
		if (!filter_var($this->event_room_id, FILTER_VALIDATE_INT))
			$this->addError('Event room is invalid');
		if (!filter_var($this->event_bldg_id, FILTER_VALIDATE_INT))
			$this->addError('Event building ID is invalid');
		return empty($this->errors);
	}

	public function sanitize() {
		$this->event_name = filter_var($this->event_name,
		FILTER_SANITIZE_STRING);
		$this->event_desc = filter_var($this->event_desc,
		FILTER_SANITIZE_STRING);
		$this->event_datetime = filter_var($this->event_datetime,
		FILTER_SANITIZE_STRING);
		$this->event_room_id = filter_var($this->event_room_id,
		FILTER_SANITIZE_INT);
		$this->event_bldg_id = filter_var($this->event_bldg_id,
		FILTER_SANITIZE_INT);
	}

	public function create() {
		$this->sanitize();
		if (!$this->validate())
			return false;
		$query = 'INSERT INTO ' . self::TABLE_NAME . ' (event_name, event_desc,
		event_datetime, event_room_id, event_bldg_id, event_expired) VALUES
		(:event_name, :event_desc, :event_datetime, :event_room_id, :event_bldg_id,
		:event_expired)';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':event_name', $this->event_name);
		$stmt->bindParam(':event_desc', $this->event_desc);
		$stmt->bindParam(':event_datetime', $this->datetime);
		$stmt->bindParam(':event_room_id', $this->event_room_id);
		$stmt->bindParam(':event_bldg_id', $this->event_bldg_id);
		$stmt->bindParam(':event_expired', $this->event_expired);
		return $stmt->execute();
	}
}

?>
