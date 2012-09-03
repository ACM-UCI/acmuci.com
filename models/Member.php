<?php

require 'Validatable.php';

class Member extends Validatable {
	public $member_id;
	public $member_name;
	public $member_fb_id;
	public $member_role;
	public $member_link;
	public $member_email;

	public function __construct($member_name, $member_fb_id, $member_role,
	$member_link, $member_email) {
		$this->member_name = $member_name;
		$this->member_fb_id = $member_fb_id;
		$this->member_role = $member_role;
		$this->member_link = $member_link;
		$this->member_email = $member_email;
	}
	
	public function validate() {
		$member_role_options = array(
			'options' => array(
				'min_range' => 0,
				'max_range' => 1
				));

		$this->errors = array();
		if (empty($this->member_name))
			$this->addError('Member name cannot be empty');
		if (!filter_var($this->member_fb_id, FILTER_VALIDATE_INT))
			$this->addError('Member Facebook ID must be valid');
		if (!filter_var($this->member_role, FILTER_VALIDATE_INT,
			$member_role_options))
			$this->addError('Member role is invald');
		if (!filter_var($this->member_link, FILTER_VALIDATE_URL))
			$this->addError('Member link must be a valid URL');
		if (!filter_var($this->member_email, FILTER_VALIDATE_EMAIL))
			$this->addError('Member email must be a valid email');
		return empty($this->errors);
	}
}

?>
