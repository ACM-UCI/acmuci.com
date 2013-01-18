<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include_once APP_ROOT . '/mod/events/functions.php';
include_once APP_ROOT . '/models/Location.php';

$locations = Location::getAll();

if (isset($_GET['id']))
	$event_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

if (isset($_POST['create']) || isset($_POST['update'])) {
	if (!empty($_POST['event_id']))
		$event_id = filter_var($_POST['event_id'], FILTER_SANITIZE_NUMBER_INT);

	if (!empty($_POST['name']))
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please enter an event name.</p>';

	if (!empty($_POST['description']))
		$desc = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please enter an event description.</p>';

	if (!empty($_POST['bldg']))
		$bldg = filter_var($_POST['bldg'], FILTER_SANITIZE_NUMBER_INT);
	else
		$errors .= '<p>Please select a building.</p>';

	if (!empty($_POST['date']))
		$date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please select a date.</p>';

	if (!empty($_POST['time']))
		$time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please select a time.</p>';

	if (!empty($_POST['room']))
		$room = filter_var($_POST['room'], FILTER_SANITIZE_NUMBER_INT);
	else
		$errors .= '<p>Please enter a room number.</p>';

	if (!$errors) {
		try {
			$datetime = $date . ' ' . $time;

			if (isset($_POST['update']) && !empty($event_id)) {
				$query = 'UPDATE events SET 
					event_name = :event_name, 
					event_desc = :event_desc, 
					event_datetime = :event_datetime,
					event_room_id = :event_room, 
					event_bldg_id = :event_bldg
					WHERE event_id = :event_id';
				$stmt = $db->prepare($query);
				$stmt->bindParam(':event_id', $event_id);
				$stmt->bindParam(':event_name', $name);
				$stmt->bindParam(':event_desc', $desc);
				$stmt->bindParam(':event_datetime', $datetime);
				$stmt->bindParam(':event_room', $room);
				$stmt->bindParam(':event_bldg', $bldg);
				$stmt->execute();
			} else {
				$query = 'INSERT INTO events (event_name, event_desc, event_datetime, 
					event_room_id, event_bldg_id) VALUES (:event_name, 
					:event_desc, :event_datetime, :event_room, :event_bldg)';
				$stmt = $db->prepare($query);
				$stmt->bindParam(':event_name', $name);
				$stmt->bindParam(':event_desc', $desc);
				$stmt->bindParam(':event_datetime', $datetime);
				$stmt->bindParam(':event_room', $room);
				$stmt->bindParam(':event_bldg', $bldg);
				$stmt->execute();
			}

			$success = true;
		} catch (PDOException $e) {
			$errors .= '<p>Database error: please inform the webmaster.</p>';
		}
	}
}

if (!empty($event_id)) {
	$query = 'SELECT event_name, event_desc, 
		event_datetime,
		event_room_id, event_bldg_id
		FROM events
		WHERE event_id = :event_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':event_id', $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();
	$event = $stmt->fetch(PDO::FETCH_ASSOC);
	$event_datetime = new DateTime($event['event_datetime']);
	$event['event_date'] = $event_datetime->format(EVENT_ISO_DATE_FMT);
	$event['event_time'] = $event_datetime->format(EVENT_ISO_TIME_FMT);
}

// Default values for form

if (!empty($errors) && isset($_POST['name']))
	$name_val = $name;
else if (!empty($event))
	$name_val = $event['event_name'];

if (!empty($errors) && isset($_POST['description']))
	$desc_val = $description;
else if (!empty($event))
	$desc_val = $event['event_desc'];

if (!empty($errors) && isset($_POST['location']))
	$loc_val = $location;
else if (!empty($event))
	$loc_val = $event['event_bldg_id'];
else
	$loc_val = 1;

if (!empty($errors) && isset($_POST['date']))
	$date_val = $date;
else if (!empty($event))
	$date_val = $event['event_date'];
else
	$date_val = $now->format(EEVENT_ISO_DATE_FMT);

if (!empty($errors) && isset($_POST['time']))
	$time_val = $time;
else if (!empty($event))
	$time_val = $event['event_time'];
else
	$time_val = $now->format(EVENT_ISO_TIME_FMT);

if (!empty($errors) && isset($_POST['room']))
	$room_val = $room_id;
else if (!empty($event))
	$room_val = $event['event_room_id'];

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<form action="create_event.php<?= !empty($event_id) ? '?id=' . $event_id : '' ?>" method="POST">
				<?php 
					echo (isset($errors)) ? '<div class="errors">' .
					$errors .  '</div>' : '';
				?>

				<?php if ($success): ?>
				<div class="success">
					<?php if (isset($_POST['update'])): ?>
						<p>Successfully updated event!</p>
					<?php else: ?>
						<p>Successfully created event!</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<p>
					<label for="name">Event Name:</label><br />
					<input type="text" name="name" value="<?= $name_val ?>" 
					required />
				</p>

				<p>
					<label for="description">Description:</label><br />
					<textarea name="description" style="height: 80px" required><?= $desc_val ?></textarea>
				</p>

				<fieldset>
				<p>
					<label for="date">Date:</label><br />
					<input name="date" type="date" value="<?= $date_val ?>" required />
				</p>

				<p>
					<label for="time">Time:</label><br />
					<input name="time" type="time" value="<?= $time_val ?>" required />
				</p>
				</fieldset>
				
				<fieldset>
				<p>
					<label for="bldg">Building:</label><br />
					<select name="bldg">
					<?php foreach($locations as $location): ?>
						<option value="<?= $location->bldg_id ?>"
							<?= ($loc_val == $location->bldg_id) ?
								'selected="true"' : '' ?>>
							<?= $location->location_full_name ?>
						</option>
					<?php endforeach; ?>
					</select>
				</p>
				<p>
					<label for="room">Room Number:</label><br />
					<input name="room" type="number" 
					value="<?= $room_val ?>" required />
				</p>
				<p>
				</fieldset>

				<p>
					<?php if (!empty($event_id)): ?>
					<input type="hidden" name="event_id" value="<?= $event_id ?>" />
					<input type="submit" name="update" value="Update Event" />
					<?php else: ?>
					<input type="submit" name="create" value="Create Event" />
					<?php endif; ?>
				</p>
			</form>
		</div>
	</div>
</section>

<?php require APP_ROOT . 'footer.php'; ?>
