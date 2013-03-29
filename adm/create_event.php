<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include_once APP_ROOT . 'mod/events/functions.php';
include_once APP_ROOT . 'models/Event.php';
include_once APP_ROOT . 'models/Location.php';

$locations = Location::getAll();

if (isset($_GET['id']))
	$event_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

if (isset($_POST['create']) || isset($_POST['update'])) {
	if (!empty($_POST['event_id']))
		$event_id = filter_var($_POST['event_id'], FILTER_SANITIZE_NUMBER_INT);

	if (!empty($_POST['facebook_id']))
		$facebook_id = filter_var($_POST['facebook_id'], FILTER_SANITIZE_NUMBER_INT);

	if (!empty($_POST['date']))
		$date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please select a date.</p>';

	if (!empty($_POST['time']))
		$time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please select a time.</p>';

	try {
		$datetime = $date . ' ' . $time;

		$new_event = new Event($_POST['name'], $_POST['description'], 
			$datetime, $_POST['room'], $_POST['bldg']);

		if (isset($_POST['update']) && !empty($event_id)) {
			$new_event->set_event_id($event_id);
			$new_event->set_event_facebook_id($facebook_id);
			$new_event->update();
		} else {
			$new_event->set_event_facebook_id($facebook_id);
			$new_event->create();
		}

		$success = true;
	} catch (PDOException $e) {
		$errors .= '<p>Database error: please inform the webmaster.</p>';
	}
}

if (!empty($event_id))
	$event = Event::get($event_id);

// Default values for form

if (!empty($errors) && isset($_POST['name']))
	$name_val = $name;
else if (!empty($event->event_name))
	$name_val = $event->event_name;

if (!empty($errors) && isset($_POST['description']))
	$desc_val = $description;
else if (!empty($event->event_desc))
	$desc_val = $event->event_desc;

if (!empty($errors) && isset($_POST['location']))
	$loc_val = $location;
else if (!empty($event->event_bldg_id))
	$loc_val = $event->event_bldg_id;
else
	$loc_val = 1;

if (!empty($errors) && isset($_POST['date']))
	$date_val = $date;
else if (!empty($event->event_date))
	$date_val = $event->event_date;
else
	$date_val = $now->format(EVENT_ISO_DATE_FMT);

if (!empty($errors) && isset($_POST['time']))
	$time_val = $time;
else if (!empty($event->event_time))
	$time_val = $event->event_time;
else
	$time_val = $now->format(EVENT_ISO_TIME_FMT);

if (!empty($errors) && isset($_POST['room']))
	$room_val = $room_id;
else if (!empty($event->event_room_id))
	$room_val = $event->event_room_id;

if (!empty($errors) && isset($_POST['facebook_id']))
	$facebook_id_val = $facebook_id_val;
else if (!empty($event->event_facebook_id))
	$facebook_id_val = $event->event_facebook_id;

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
					<label for="facebook_id">Facebook Event ID:</label><br />
					<input name="facebook_id" type="number" 
					value="<?= $facebook_id_val ?>" />
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
