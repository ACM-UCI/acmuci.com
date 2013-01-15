<?php

define('IN_SITE', true);
require_once '../common.php';

$is_admin = false;

$query = 'SELECT * FROM locations';

$locations = $db->query($query);

if ($user) {
	$logged_in = true;
	if ($user_info['member_role'] == 1)
		$is_admin = true;
}

if ($is_admin && isset($_POST['create'])) {
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
			$query = 'INSERT INTO events (event_name, event_desc, event_week,
				event_day, event_room_id, event_bldg_id) VALUES (:event_name, 
				:event_desc, :event_week, :event_day, :event_room_id, 
				:event_bldg_id)';
			$stmt = $db->prepare($query);
			$stmt->bindParam(':event_name', $name);
			$stmt->bindParam(':event_desc', $desc);
			$stmt->bindParam(':event_week', $week);
			$stmt->bindParam(':event_day', $day);
			$stmt->bindParam(':event_room_id', $room);
			$stmt->bindParam(':event_bldg_id', $bldg);
			$stmt->execute();

			$success = true;
		} catch (PDOException $e) {
			$errors .= '<p>Database error: please inform the webmaster.</p>';
		}
	}
}

require APP_ROOT . 'header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<?php if (!$logged_in): ?>
				<a href="<?= $login_url ?>">Login</a>
			<?php elseif (!$is_admin): ?>
				<p>You are not an administrator.</p>
			<?php else: ?>
				<form action="events.php" method="POST">
					<p>
						<label for="name">Event Name:</label><br />
						<input type="text" name="name" value="<?php echo
						(!empty($errors) && isset($_POST['name'])) ? $name : ''; ?>" 
						required />
					</p>

					<p>
						<label for="description">Description:</label><br />
						<textarea name="description" style="height: 80px" required><?php echo 
							(!empty($errors) && isset($_POST['description'])) ?	$description : ''; ?></textarea>
					</p>

					<fieldset>
					<p>
						<label for="week">Week:</label><br />
						<input name="week" type="number" min="0" max="10" value="1" value="<?php
						echo (!empty($errors) && isset($_POST['week'])) ? $week : ''; ?>" 
						required />
					</p>

					<p>
						<label for="day">Day:</label><br />
						<select name="day">
							<option value="0">Sunday</option>
							<option value="1" selected>Monday</option>
							<option value="2">Tuesday</option>
							<option value="3">Wednesday</option>
							<option value="4">Thursday</option>
							<option value="5">Friday</option>
							<option value="6">Saturday</option>
						</select>
					</p>
					</fieldset>
					
					<fieldset>
					<p>
						<label for="bldg">Building:</label><br />
						<select name="bldg">
						<?php foreach($locations as $location): ?>
							<option value="<?= $location['bldg_id'] ?>">
								<?= $location['location_full_name'] ?>
							</option>
						<?php endforeach; ?>
						</select>
					</p>
					<p>
						<label for="room">Room Number:</label><br />
						<input name="room" type="number" value="<?php echo 
						(!empty($errors) && isset($_POST['room'])) ? $room : ''; ?>"
						required />
					</p>
					<p>
					</fieldset>

					<p>
						<input type="submit" name="create" value="Create Event" />
					</p>

					<?php 
						echo (isset($errors)) ? '<div class="errors">' .
						$errors .  '</div>' : '';
					?>

					<?php if ($success): ?>
					<div class="success">
						<p>Successfully created event!</p>
					</div>
					<?php endif; ?>
				</form>
			<?php endif;?>
		</div>
	</div>
</section>

<?php require APP_ROOT . 'footer.php'; ?>
