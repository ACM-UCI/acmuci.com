<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include_once APP_ROOT . 'models/Location.php';

if (isset($_GET['id']))
	$bldg_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

if (isset($_POST['create']) || isset($_POST['update'])) {
	if (!empty($_POST['bldg_id']))
		$bldg_id = filter_var($_POST['bldg_id'], FILTER_SANITIZE_NUMBER_INT);

	try {
		$new_location = new Location($bldg_id, $_POST['full_name'], $_POST['short_name']); 
		$success = (isset($_POST['update'])) ? $new_location->update() : $new_location->create();
	} catch (PDOException $e) {
		$errors .= '<p>Database error: please inform the webmaster.</p>';
	}
}

if (!empty($bldg_id))
	$location = Location::get($bldg_id);

// Default values for form

if (!empty($errors) && isset($_POST['bldg_id']))
	$bldg_id_val = $bldg_id;
else if (!empty($location->bldg_id))
	$bldg_id_val = $location->bldg_id;
else
	$bldg_id_val = 1;

if (!empty($errors) && isset($_POST['short_name']))
	$short_name_val = $short_name;
else if (!empty($location->location_short_name))
	$short_name_val = $location->location_short_name;

if (!empty($errors) && isset($_POST['full_name']))
	$full_name_val = $full_name;
else if (!empty($location->location_full_name))
	$full_name_val = $location->location_full_name;

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<form action="create_location.php<?= !empty($bldg_id) ? '?id=' . $bldg_id : '' ?>" method="POST">
				<?php 
					echo (isset($errors)) ? '<div class="errors">' .
					$errors .  '</div>' : '';
				?>

				<?php if ($success): ?>
				<div class="success">
					<?php if (isset($_POST['update'])): ?>
						<p>Successfully updated location!</p>
					<?php else: ?>
						<p>Successfully created location!</p>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<p>
					<label for="bldg_id">Building ID:</label><br />
					<input name="bldg_id" type="number" value="<?= $bldg_id_val ?>" required />
				</p>

				<p>
					<label for="full_name">Full Name:</label><br />
					<input type="text" name="full_name" value="<?= $full_name_val ?>" 
					required />
				</p>

				<p>
					<label for="short_name">Short Name (Acronym):</label><br />
					<input type="text" name="short_name" value="<?= $short_name_val ?>" 
					required />
				</p>

				<p>
					<?php if (!empty($bldg_id)): ?>
					<input type="hidden" name="bldg_id" value="<?= $bldg_id ?>" />
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
