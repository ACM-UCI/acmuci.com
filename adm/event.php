<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include APP_ROOT . '/mod/events/functions.php';

if (isset($_GET['id'])) {
	$query = 'SELECT event_id, event_name, event_desc, event_expired,
		event_datetime
		FROM events
		WHERE event_id = :event_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':event_id', $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();
	$event = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_GET['id']) && isset($_POST['delete'])) {
	$query = 'DELETE FROM events WHERE event_id = :event_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':event_id', $_GET['id']);
	$stmt->execute();
	
	header('Location: events.php');
	die();
}

if (isset($_GET['id']) && isset($_POST['expire'])) {
	$query = 'UPDATE events SET event_expired = 1
		WHERE event_id = :event_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':event_id', $_GET['id']);
	$stmt->execute();
}

if (isset($_GET['id']) && isset($_POST['facebook'])) {
	$start_time = new DateTime($event['datetime'], new DateTimeZone('UTC'));
	$result = $fb->api('/' . FB_GROUP_ID . '/events', 'POST',
		array(
			'access_token' => $fb->getAccessToken(),
			'name' => $event['event_name'],
			'start_time' => $start_time->format(DateTime::ISO8601),
			'description' => $event['event_desc'])
		);
	var_dump($result);
}

if (isset($_GET['id']) && isset($_POST['edit'])) {
	$event_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	header('Location: create_event.php?id=' . $event_id);
	die();
}

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<?php if (!isset($_GET['id']) || empty($event)): ?>
				<p>Invalid event ID.</p>
			<?php else: ?>
				<div class="three">
					<footer>
						<?= printDateTime($event['event_datetime']) ?>
					</footer>
					<h2><?= $event['event_name'] ?></h2>
					<p><?= $event['event_desc'] ?></p>
				</div>

				<form class="left" action="event.php?id=<?= $_GET['id'] ?>" method="POST">
					<p>
						<input type="submit" name="facebook" value="Create Facebook Event" />
					</p>
				</form>
			<?php endif;?>
		</div>
	</div>
</section>
<?php require APP_ROOT . 'footer.php'; ?>
