<?php

define('IN_SITE', true);
require_once '../common.php';

$is_admin = false;

$query = 'SELECT p.project_name, p.project_desc,
	m.member_name as project_contact_name
	FROM projects as p
	LEFT JOIN members as m
		ON p.project_contact_id = m.member_id
	WHERE project_status = 0';
$proposed_projects = $db->query($query);

if ($user) {
	$logged_in = true;
	if ($user_info['member_role'] == 1)
		$is_admin = true;
}

require APP_ROOT . 'adm/adm_header.php';

?>

<section id="content">
	<div class="inner">
		<div class="content-block">
			<?php if (!$logged_in): ?>
				<a class="simple_button" href="<?= $login_url ?>">Facebook Login</a>
			<?php elseif (!$is_admin): ?>
				<p>You are not an administrator.</p>
			<?php else: ?>
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
			<?php endif;?>
		</div>
	</div>
</section>

<?php require APP_ROOT . 'footer.php'; ?>
