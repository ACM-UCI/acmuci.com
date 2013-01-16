<?php

$events = array();

$query = 'SELECT e.event_name, e.event_desc, 
	e.event_datetime,
	e.event_room_id,
	l.location_short_name,
	l.bldg_id
	FROM events AS e
	LEFT JOIN locations AS l
		ON e.event_bldg_id = l.bldg_id
	WHERE event_expired = 0
	ORDER BY event_datetime ASC
	LIMIT 4';
$events = $db->query($query);

define('EVENT_DATE_FMT', 'Week %d: %s');

?>

<h2>Events</h2>

<?php foreach($events as $event): ?>
<article>
	<footer>
		<?php $event_datetime = new DateTime($event['event_datetime']);
			echo $event_datetime->format('M. d, Y'); ?>
		<a href="http://www.uci.edu/campusmap/map.php?l=1&q=<?= $event['bldg_id'] ?>"
			target="_blank">
			@<?= $event['location_short_name'] ?><?= $event['event_room_id'] ?>
		</a>
	</footer>
	<h3><?= $event['event_name'] ?></h3>
	<p><?= $event['event_desc'] ?></p>
</article>
<?php endforeach; ?>

