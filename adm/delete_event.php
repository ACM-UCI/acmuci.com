<?php

define('IN_SITE', true);
require_once '../common.php';
include APP_ROOT . '/mod/events/functions.php';

$is_admin = false;

if ($user) {
	$logged_in = true;
	if ($user_info['member_role'] == 1)
		$is_admin = true;
}

if (!isset($_GET['id']))
	die('ERROR: Invalid parameters');

if (!$is_admin)
	die('ERROR: Insufficient permissions');

try {
	$query = 'DELETE FROM events
		WHERE event_id = :event_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':event_id', $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();

	header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch (PDOException $e) {
	die($e->getMessage());
}

?>
