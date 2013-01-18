<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include APP_ROOT . '/mod/events/functions.php';

try {
	expirePastEvents($db);
	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
} catch (PDOException $e) {
	die($e->getMessage());
}

?>
