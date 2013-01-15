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

if ($is_admin) {
	if (isset($_GET['id']) && isset($_POST['delete'])) {
		$query = 'DELETE FROM events WHERE event_id = :event_id';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':event_id', $_GET['id']);
		$stmt->execute();
		
		header('Location: events.php');
		die();
	}

	if (isset($_GET['id']) && isset($_POST['edit'])) {
		$event_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
		header('Location: create_event.php?id=' . $event_id);
		die();
	}

	if (isset($_GET['id'])) {
		$query = 'SELECT event_id, event_name, event_desc, event_week, event_day
			FROM events
			WHERE event_id = :event_id';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':event_id', $_GET['id'], PDO::PARAM_INT);
		$stmt->execute();
		$event = $stmt->fetch(PDO::FETCH_ASSOC);
	}

}

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<?php if (!$logged_in): ?>
				<a href="<?= $login_url ?>">Login</a>
			<?php elseif (!$is_admin): ?>
				<p>You are not an administrator.</p>
			<?php elseif (!isset($_GET['id']) || empty($event)): ?>
				<p>Invalid event ID.</p>
			<?php else: ?>
				<div class="three">
					<footer><?= sprintf(EVENT_DATE_FMT, $event['event_week'], 
							getDay($event['event_day'])) ?></footer>
					<h2><?= $event['event_name'] ?></h2>
					<p><?= $event['event_desc'] ?></p>
				</div>

				<form class="left" action="event.php?id=<?= $_GET['id'] ?>" method="POST">
					<p>
						<input type="submit" name="delete" value="Delete" />
						<input type="submit" name="edit" value="Edit" />
					</p>
				</form>
			<?php endif;?>
		</div>
	</div>
</section>
<?php require APP_ROOT . 'footer.php'; ?>
