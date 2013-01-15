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

$query = 'SELECT event_id, event_name, event_desc, event_week, event_day
	FROM events
	ORDER BY event_week, event_day ASC';
$events = $db->query($query);

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<?php if (!$logged_in): ?>
				<a href="<?= $login_url ?>">Login</a>
			<?php elseif (!$is_admin): ?>
				<p>You are not an administrator.</p>
			<?php else: ?>
				<div class="three left">
					<h2>Events List</h2>
					<a class="simple_button" href="create_event.php" title="Create Event">Create Event</a>

					<div id="adm-events">
						<?php foreach($events as $event): ?>
						<article>
							<footer>
								<?= sprintf(EVENT_DATE_FMT, 
									$event['event_week'], 
									getDay($event['event_day'])) ?>
							</footer>
							<h3><a href="event.php?id=<?= $event['event_id'] ?>"><?= $event['event_name'] ?></a></h3>
							<p><?= $event['event_desc'] ?></p>
						</article>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
</section>
<?php require APP_ROOT . 'footer.php'; ?>
