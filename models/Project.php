<?php

require 'Validatable.php';

class Project extends Validatable {
	public $project_id;
	public $project_status;
	public $project_name;
	public $project_desc;
	public $project_contact_id;

	public function __construct($project_status, $project_name, $project_desc,
	$project_contact_id) {
		$this->project_status = $project_status;
		$this->project_name = $project_name;
		$this->project_desc = $project_desc;
		$this->project_contact_id = $project_contact_id;
	}

	public function validate() {
		$this->errors = array();
		if (!filter_var($this->project_status, FILTER_VALIDATE_INT))
			$this->addError('Project status is invalid');
		if (empty($this->project_name))
			$this->addError('Project name cannot be empty');
		if (empty($this->project_desc))
			$this->addError('Project description cannot be empty');
		if (!filter_var($this->project_contact_id, FILTER_VALIDATE_INT))
			$this->addError('Project must have a contact');
		return empty($this->errors);
	}
}

?>
