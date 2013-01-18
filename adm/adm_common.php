<?php

require_once '../common.php';

$is_admin = false;

if ($user) {
	$logged_in = true;
	if ($user_info['member_role'] == 1)
		$is_admin = true;
}

?>

<?php if (!$logged_in || !$is_admin): ?>
<?php require APP_ROOT . 'adm/adm_header.php'; ?>
<section id="content">
	<div class="inner">
		<div class="content-block">
			<?php if (!$logged_in): ?>
				<a class="simple_button" href="<?= $login_url ?>">Facebook Login</a>
			<?php elseif (!$is_admin): ?>
				<p>You are not an administrator.</p>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php require APP_ROOT . 'footer.php'; ?>
<?php die(); ?>
<?php endif; ?>

