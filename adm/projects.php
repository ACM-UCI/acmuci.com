<?php

define('IN_SITE', true);
require_once 'adm_common.php';

$query = 'SELECT p.project_name, p.project_desc,
	m.member_name as project_contact_name
	FROM projects as p
	LEFT JOIN members as m
		ON p.project_contact_id = m.member_id
	WHERE project_status = 0';
$proposed_projects = $db->query($query);

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<h2>Proposed Projects</h2>
			<p>As an administrator, you have the power to approve of
			proposed projects.</p>
			<?php foreach ($proposed_projects as $proposed_project): ?>
			<div class="project">
				<h3><?= $proposed_project['project_name'] ?></h3>
				<footer>
					<dl>
						<dt>Contact Name</dt>
						<dd><?= $proposed_project['project_contact_name']
						?></dd>
					</dl>
				</footer>
				<p><?= $proposed_project['project_desc'] ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php require APP_ROOT . 'footer.php'; ?>
