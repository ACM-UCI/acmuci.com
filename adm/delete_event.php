<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include APP_ROOT . '/mod/events/functions.php';

if (!isset($_GET['id']))
	die('ERROR: Invalid parameters');

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
