<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include APP_ROOT . 'mod/events/functions.php';
include APP_ROOT . 'mod/Location.php';

$query = 'SELECT event_id, event_name, event_expired,
	event_datetime
	FROM events
	ORDER BY julianday(event_datetime) DESC
	LIMIT 10';
$events = $db->query($query);

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<div class="two right">
				<h2>Events List</h2>
				<p>Manage the event queue on the home page of the website. Events can
				be created, updated and deleted. Note that events are automatically 
				ordered in terms of their week and day.</p>
				<p>Expired events will not appear in the event queue. Beware that
				you must expire events manually.</p>
			</div>

			<div class="three">
				<a class="simple_button" href="create_event.php" title="Create Event">Create Event</a>
				<a class="simple_button" href="expire_past_events.php" title="Expire Past Events">Expire Past Events</a>
				<div id="adm-events">
					<?php foreach($events as $event): ?>
					<article>
						<div class="button-set">
							<?php if (!$event['event_expired']): ?>
							<a class="small_button" href="expire_event.php?id=<?= $event['event_id'] ?>&expired=1">Expire</a>
							<?php else: ?>
							<a class="small_button" href="expire_event.php?id=<?= $event['event_id'] ?>&expired=0">Renew</a>
							<?php endif; ?>

							<a class="small_button" href="create_event.php?id=<?= $event['event_id'] ?>">Edit</a>
							<a class="small_button" href="delete_event.php?id=<?= $event['event_id'] ?>">Delete</a>
						</div>
						<footer>
							<?= printDateTime($event['event_datetime']) ?>
							<?= ($event['event_expired']) ? '<span class="expired">expired</span>' : '' ?>
						</footer>
						<h3><a href="event.php?id=<?= $event['event_id'] ?>"><?= $event['event_name'] ?></a></h3>
					</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php require APP_ROOT . 'footer.php'; ?>
