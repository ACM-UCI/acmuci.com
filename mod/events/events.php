<?php

$events = array();

$query = 'SELECT e.event_name, e.event_desc, 
	e.event_week, e.event_day,
	e.event_room_id,
	l.location_short_name,
	l.bldg_id
	FROM events AS e
	LEFT JOIN locations AS l
		ON e.event_bldg_id = l.bldg_id
	ORDER BY e.event_week, e.event_day ASC
	LIMIT 4';
$events = $db->query($query);

function getDay($day_code) {
	switch ($day_code) {
		case 0: return 'Sunday';
		case 1: return 'Monday';
		case 2: return 'Tuesday';
		case 3: return 'Wednesday';
		case 4: return 'Thursday';
		case 5: return 'Friday';
		case 6: return 'Saturday';
	}
}

define('EVENT_DATE_FMT', 'Week %d: %s');

?>

<h2>Events</h2>

<?php foreach($events as $event): ?>
<article>
	<footer>
		<?= sprintf(EVENT_DATE_FMT, 
			$event['event_week'], 
			getDay($event['event_day'])) ?>

		<a href="http://www.uci.edu/campusmap/map.php?l=1&q=<?= $event['bldg_id'] ?>"
			target="_blank">
			@<?= $event['location_short_name'] ?><?= $event['event_room_id'] ?>
		</a>
	</footer>
	<h3><?= $event['event_name'] ?></h3>
	<p><?= $event['event_desc'] ?></p>
</article>
<?php endforeach; ?>

