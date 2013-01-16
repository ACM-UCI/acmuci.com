<?php

// Note that libcurl3 and libcurl3-dev required
require_once __DIR__ . '/../../common.php';

try {
	//populate_members($db, $fb);
	//install_default_events($db);
	//install_default_locations($db);
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

function install_default_locations(&$db) {
	$query = 'INSERT INTO locations (bldg_id, location_full_name, location_short_name)
	VALUES (:bldg_id, :location_full_name, :location_short_name)';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':bldg_id', $bldg_id);
	$stmt->bindParam(':location_full_name', $location_full_name);
	$stmt->bindParam(':location_short_name', $location_short_name);

	$bldg_id = 113;
	$location_full_name = 'Courtyard Study Lounge';
	$location_short_name = 'CSL';
	$stmt->execute();
	
	$bldg_id = 314;
	$location_full_name = 'Donald Bren Hall';
	$location_short_name = 'DBH';
	$stmt->execute();

	$bldg_id = 302;
	$location_full_name = 'Information and Computer Sciences';
	$location_short_name = 'ICS';
	$stmt->execute();

	$bldg_id = 308;
	$location_full_name = 'Engineering Hall';
	$location_short_name = 'EH';
	$stmt->execute();

	$bldg_id = 321;
	$location_full_name = 'Engineering Gateway';
	$location_short_name = 'EG';
	$stmt->execute();
}

function install_default_events(&$db) {
	$query = 'INSERT INTO events (event_name, event_desc, event_datetime, event_room_id, event_bldg_id) 
		VALUES (:event_name, :event_desc, :event_datetime, :event_room_id, :event_bldg_id)';

	$stmt = $db->prepare($query);
	$stmt->bindParam(':event_name', $event_name);
	$stmt->bindParam(':event_desc', $event_desc);
	$stmt->bindParam(':event_datetime', $event_datetime);
	$stmt->bindParam(':event_room_id', $event_room_id, PDO::PARAM_INT);
	$stmt->bindParam(':event_bldg_id', $event_bldg_id, PDO::PARAM_INT);

	$event_room_id = 15;
	$event_bldg_id = 113;

	$event_name = 'Algorithm Practice 2A';
	$event_desc = 'Second set of competition practice sessions for HackerRank.';
	$event_datetime = '2013-1-14 19:00:00';
	$stmt->execute();
	
	$event_name = 'Algorithm Practice 2B';
	$event_desc = 'Second set of competition practice sessions for HackerRank.';
	$event_datetime = '2013-1-17 19:00:00';
	$stmt->execute();

	$event_week = 3;

	$event_name = 'Algorithm Practice 3A';
	$event_desc = 'Second set of competition practice sessions for HackerRank.';
	$event_datetime = '2013-1-21 19:00:00';
	$stmt->execute();

	$event_name = 'Algorithm Practice 3B';
	$event_desc = 'Second set of competition practice sessions for HackerRank.';
	$event_datetime = '2013-1-24 19:00:00';
	$stmt->execute();
}

?>
