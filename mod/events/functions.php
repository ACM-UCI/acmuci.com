<?php

define('EVENT_ISO_DATE_FMT', 'Y-m-d');
define('EVENT_ISO_TIME_FMT', 'H:i:s');
define('EVENT_DATETIME_FMT', 'M. d, Y');

function printDateTime($event_datetime) {
	$datetime = new DateTime($event_datetime);
	echo $datetime->format(EVENT_DATETIME_FMT);
}

$now = new DateTime('now');

?>
