<?php

// Note that libcurl3 and libcurl3-dev required
require_once __DIR__ . '/../../common.php';

try {
	//populate_members($db, $fb);
	//install_default_projects($db, $fb);

	echo "Success";
} catch (PDOException $e) {
	echo $e->getMessage();
}

function populate_members(&$db, &$fb) {
	$acm_group = $fb->api('/228954137162541?fields=members.fields(name,id,administrator,link,email)');
	
	$query = 'INSERT INTO members (member_fb_id, member_name, member_role,
	member_link, member_email) VALUES (:member_fb_id, :member_name,
	:member_role, :member_link, :member_email)';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':member_fb_id', $member_fb_id);
	$stmt->bindParam(':member_name', $member_name);
	$stmt->bindParam(':member_role', $member_role);
	$stmt->bindParam(':member_link', $member_link);
	$stmt->bindParam(':member_email', $member_email);

	foreach ($acm_group['members']['data'] as $member) {
		$member_fb_id = $member['id'];
		$member_name = $member['name'];
		$member_role = ($member['administrator']) ? 1 : 0;
		$member_link = (!empty($member['link'])) ? $member['link'] : '';
		$member_email = (!empty($member['email'])) ? $member['email'] : '';
		$stmt->execute();
	}
}

function install_default_projects(&$db, &$fb) {
	$query = 'INSERT INTO projects (project_status, project_name, project_desc,
	project_contact_id) VALUES (:project_status, :project_name, :project_desc,
	:project_contact_id)';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':project_status', $project_status, PDO::PARAM_INT);
	$stmt->bindParam(':project_name', $project_name);
	$stmt->bindParam(':project_desc', $project_desc);
	$stmt->bindParam(':project_contact_id', $project_contact_id,
	PDO::PARAM_INT);
	
	$project_status = 1;
	$project_name = 'Duracell Powermat';
	$project_desc = 'Develop a mobile application to that marks the nearest
	wireless charging location in UC Irvine.'; 
	$project_contact_id = 1;
	$stmt->execute();

	$project_status = 2;
	$project_name = 'acmuci.com Website';
	$project_desc = "Contribute to the development of this website! Each year,
	ACM\'s UC Irvine Chapter will participate in the ACM Student Chapter
	Excellence Awards to win the Outstanding Chapter Website award.";
	$project_contact_id = 65;
	$stmt->execute();

	$project_status = 2;
	$project_name = 'AllUnit';
	$project_desc = 'Develop a mobile application to that marks the nearest
	wireless charging location in UC Irvine.'; 
	$project_contact_id = 30;
	$stmt->execute();
}

?>
