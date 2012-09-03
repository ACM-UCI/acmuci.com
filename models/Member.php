<?php

require 'Validatable.php';

class Member extends Validatable {
	const TABLE_NAME = 'members';

	const ROLE_MEMBER = 0;
	const ROLE_ADMIN = 1;

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
		if (!empty($this->member_link) && !filter_var($this->member_link,
			FILTER_VALIDATE_URL))
			$this->addError('Member link must be a valid URL');
		if (!empty($this->member_email) && !filter_var($this->member_email,
			FILTER_VALIDATE_EMAIL))
			$this->addError('Member email must be a valid email');
		return empty($this->errors);
	}

	public function sanitize() {
		$this->member_name = filter_var($this->member_name,
		FILTER_SANITIZE_STRING);
		$this->member_fb_id = filter_var($this->member_fb_id,
		FILTER_SANITIZE_INT);
		$this->member_role = filter_var($this->member_role,
		FILTER_SANITIZE_INT);
		$this->member_link = filter_var($this->member_link,
		FILTER_SANITIZE_URL);
		$this->member_email = filter_var($this->member_email,
		FILTER_SANITIZE_EMAIL);
	}

	public function create() {
		$this->sanitize();
		if (!$this->validate())
			return false;
		$query = 'INSERT INTO ' . self::TABLE_NAME . ' (member_name,
		member_fb_id, member_role, member_link, member_email) VALUES
		(:member_name, :member_fb_id, :member_role, :member_link,
		:member_email)';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':member_name', $this->member_name);
		$stmt->bindParam(':member_fb_id', $this->member_fb_id);
		$stmt->bindParam(':member_role', $this->member_role);
		$stmt->bindParam(':member_link', $this->member_link);
		$stmt->bindParam(':member_email', $this->member_email);
		return $stmt->execute();
	}

	public static function read($member_id) {
		$query = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE member_id =
		:member_id';
		$stmt = $GLOBALS['db']->prepare($query);
		$stmt->bindParam(':member_id', $member_id, PDO::PARAM_INT);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_CLASS, 'Member');
		return ($stmt->rowCount === 1) ? $stmt->fetch() : null;
	}
}

?>
