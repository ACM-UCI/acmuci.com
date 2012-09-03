<?php

require 'Validatable.php';

class Event extends Validatable {
	public $event_id;
	public $event_name;
	public $event_desc;
	public $event_room_id;
	public $event_bldg_id;

	public function __construct($event_name, $event_desc, $event_room_id,
	$event_bldg_id) {
		$this->event_name = $event_name;
		$this->event_desc = $event_desc;
		$this->event_room_id = $event_room_id;
		$this->event_bldg_id = $event_bldg_id;
	}

	public function validate() {
		$this->errors = array();
		if (empty($this->event_name))
			$this->addError('Event name cannot be empty');
		if (empty($this->event_desc))
			$this->addError('Event description cannot be empty');
		if (!filter_var($this->event_room_id, FILTER_VALIDATE_INT))
			$this->addError('Event room is invalid');
		if (!filter_var($this->event_bldg_id, FILTER_VALIDATE_INT))
			$this->addError('Event building ID is invalid');
		return empty($this->errors);
	}
}

?>
