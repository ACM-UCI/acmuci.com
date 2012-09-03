<?php

require 'Validatable.php';

class Project extends Validatable {
	const TABLE_NAME = 'projects';

	const STATUS_PROPOSE = 0;
	const STATUS_INCUBATE = 1;
	const STATUS_ACTIVE = 2;

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

	public function create() {
		if (!$this->validate())
			return false;
		try {
			$query = 'INSERT INTO ' . self::TABLE_NAME . ' (project_status,
			project_name, project_desc, project_contact_id) VALUES (\'' .
			self::STATUS_PROPOSE . '\', :project_name, :project_desc,
			:project_contact_id)';
			$stmt = $GLOBALS['db']->prepare($query);
			$stmt->bindParam(':project_name', $this->project_name);
			$stmt->bindParam(':project_desc', $this->project_desc);
			$stmt->bindParam(':project_contact_id', $this->project_contact_id,
			PDO::PARAM_INT);
			return $stmt->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function read($project_id) {
		$query = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE project_id =
		:project_id';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Project');
		return ($stmt->rowCount === 1) ? $stmt->fetch() : null;
	}
}

?>
