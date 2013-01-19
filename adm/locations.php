<?php

define('IN_SITE', true);
require_once 'adm_common.php';
include APP_ROOT . 'models/Location.php';

$locations = Location::getAll();

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<div class="two right">
				<h2>Locations List</h2>
				<p>Manage the locations frequently occupied by ACM.</p>
			</div>

			<div class="three">
				<a class="simple_button" href="create_location.php" title="Create Location">Create Location</a>
				<div id="adm-events">
					<?php foreach($locations as $location): ?>
					<article>
						<div class="button-set">
							<a class="small_button" href="create_location.php?id=<?= $location->bldg_id ?>">Edit</a>
							<a class="small_button" href="delete_location.php?id=<?= $location->bldg_id ?>">Delete</a>
						</div>
						<footer>
							<a href="http://www.uci.edu/campusmap/map.php?l=1&q=<?= $location->bldg_id ?>"
								target="_blank">
								@<?= $location->location_short_name ?><?= $location->location_room_id ?>
							</a>
						</footer>
						<h3>
							<?= $location->location_full_name ?>
						<h3>
					</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php require APP_ROOT . 'footer.php'; ?>
