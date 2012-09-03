<?php

require_once __DIR__ . '/../common.php';

abstract class Validatable {
	private $errors;

	public abstract function validate();

	public function addError($message) {
		$this->errors[] = "<p>$message</p>";
	}

	public function getErrors() {
		return $this->errors;
	}
}

?>
