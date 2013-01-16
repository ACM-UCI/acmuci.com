<?php

define('IN_SITE', true);
require_once '../common.php';
include APP_ROOT . '/mod/events/functions.php';

$is_admin = false;

$query = 'SELECT * FROM locations';

$locations = $db->query($query);

if ($user) {
	$logged_in = true;
	if ($user_info['member_role'] == 1)
		$is_admin = true;
}

$query = 'SELECT event_id, event_name, event_expired,
	event_datetime
	FROM events
	ORDER BY event_datetime ASC';
$events = $db->query($query);

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<?php if (!$logged_in): ?>
				<a class="simple_button" href="<?= $login_url ?>">Facebook Login</a>
			<?php elseif (!$is_admin): ?>
				<p>You are not an administrator.</p>
			<?php else: ?>
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
								<?php $event_datetime = new DateTime($event['event_datetime']);
									echo $event_datetime->format('M. d, Y'); ?>
								<?= ($event['event_expired']) ? '<span class="expired">expired</span>' : '' ?>
							</footer>
							<h3><a href="event.php?id=<?= $event['event_id'] ?>"><?= $event['event_name'] ?></a></h3>
						</article>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
</section>
<?php require APP_ROOT . 'footer.php'; ?>
