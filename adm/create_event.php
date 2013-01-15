<?php

define('IN_SITE', true);
require_once '../common.php';
include_once APP_ROOT . '/mod/events/functions.php';

$is_admin = false;

$query = 'SELECT * FROM locations';
$locations = $db->query($query);

if ($user) {
	$logged_in = true;
	if ($user_info['member_role'] == 1)
		$is_admin = true;
}

if (isset($_GET['id']))
	$event_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

if ($is_admin && (isset($_POST['create']) || isset($_POST['update']))) {
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

	if (!empty($_POST['week']))
		$week = filter_var($_POST['week'], FILTER_SANITIZE_NUMBER_INT);
	else
		$errors .= '<p>Please select a week.</p>';

	if (!empty($_POST['day']))
		$day = filter_var($_POST['day'], FILTER_SANITIZE_NUMBER_INT);
	else
		$errors .= '<p>Please select a day of the week.</p>';

	if (!empty($_POST['bldg']))
		$bldg = filter_var($_POST['bldg'], FILTER_SANITIZE_NUMBER_INT);
	else
		$errors .= '<p>Please select a building.</p>';

	if (!empty($_POST['room']))
		$room = filter_var($_POST['room'], FILTER_SANITIZE_NUMBER_INT);
	else
		$errors .= '<p>Please enter a room number.</p>';

	if (!$errors) {
		try {
			if (isset($_POST['update']) && !empty($event_id)) {
				$query = 'UPDATE events SET 
					event_name = :event_name, 
					event_desc = :event_desc, 
					event_week = :event_week,
					event_day = :event_day, 
					event_room_id = :event_room, 
					event_bldg_id = :event_bldg
					WHERE event_id = :event_id';
				$stmt = $db->prepare($query);
				$stmt->bindParam(':event_id', $event_id);
				$stmt->bindParam(':event_name', $name);
				$stmt->bindParam(':event_desc', $desc);
				$stmt->bindParam(':event_week', $week);
				$stmt->bindParam(':event_day', $day);
				$stmt->bindParam(':event_room', $room);
				$stmt->bindParam(':event_bldg', $bldg);
				$stmt->execute();
			} else {
				$query = 'INSERT INTO events (event_name, event_desc, event_week,
					event_day, event_room_id, event_bldg_id) VALUES (:event_name, 
					:event_desc, :event_week, :event_day, :event_room, 
					:event_bldg)';
				$stmt = $db->prepare($query);
				$stmt->bindParam(':event_name', $name);
				$stmt->bindParam(':event_desc', $desc);
				$stmt->bindParam(':event_week', $week);
				$stmt->bindParam(':event_day', $day);
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

if ($is_admin && !empty($event_id)) {
	$query = 'SELECT event_name, event_desc, 
		event_week, event_day,
		event_room_id, event_bldg_id
		FROM events
		WHERE event_id = :event_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':event_id', $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();
	$event = $stmt->fetch(PDO::FETCH_ASSOC);
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

if (!empty($errors) && isset($_POST['week']))
	$week_val = $week;
else if (!empty($event))
	$week_val = $event['event_week'];
else
	$week_val = 1;

if (!empty($errors) && isset($_POST['day']))
	$day_val = $day;
else if (!empty($event))
	$day_val = $event['event_day'];
else
	$day_val = 1;

if (!empty($errors) && isset($_POST['location']))
	$loc_val = $location;
else if (!empty($event))
	$loc_val = $event['event_bldg_id'];
else
	$loc_val = 1;

if (!empty($errors) && isset($_POST['room']))
	$room_val = $room_id;
else if (!empty($event))
	$room_val = $event['event_room_id'];

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
						<label for="week">Week:</label><br />
						<input name="week" type="number" min="0" max="10" 
						value="<?= $week_val ?>" required />
					</p>

					<p>
						<label for="day">Day:</label><br />
						<select name="day">
						<?php foreach(range(0, 6) as $enum_val): ?>
							<option value="<?= $enum_val ?>" 
								<?= ($day_val == $enum_val) ?
									'selected="true"' : '' ?>><?= getDay($enum_val) ?></option>
						<?php endforeach; ?>
						</select>
					</p>
					</fieldset>
					
					<fieldset>
					<p>
						<label for="bldg">Building:</label><br />
						<select name="bldg">
						<?php foreach($locations as $location): ?>
							<option value="<?= $location['bldg_id'] ?>"
								<?= ($loc_val == $location['bldg_id']) ?
									'selected="true"' : '' ?>>
								<?= $location['location_full_name'] ?>
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
			<?php endif;?>
		</div>
	</div>
</section>

<?php require APP_ROOT . 'footer.php'; ?>
