<?php
// Check the user agent
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$user_agent_checker = array(
  'iphone' => preg_match('/iPhone|iPod/', $user_agent),
  'android' => preg_match('/Android/', $user_agent),
);
?>

<!DOCTYPE html>
<html>
<head>
<title><?= SITE_NAME ?></title>
<meta name="description" content="<?= SITE_DESC ?>" />
<meta name="keywords" content="<?= SITE_KEYWORDS ?>" />

<?php if ($user_agent_checker['iphone'] || $user_agent_checker['android']): ?>
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, height=device-height,
user-scalable=no" />
<link rel="stylesheet" type="text/css" href="styles/mobi.css" media="all" />
<?php else: ?>
<link rel="stylesheet" type="text/css" href="styles/style.css" media="screen"
/>
<?php endif; ?>

</head>
<body>

<div id="ribbon">&nbsp;</div>
<header id="page-header" class="adm">
	<div class="inner">
		<div id="meta">
			<h1>
				<a href="index.php"><img src="../images/logo.png" title="ACM" />
				<span id="chapter_tag">UC Irvine Chapter</span></a>
			</h1>
			<nav id="page-nav">
				<a href="../index.php" title="Home">Back to Site</a> 
				<a href="events.php" title="Events">Events</a>
				<a href="projects.php" title="Projects">Projects</a> 
			</nav>
		</div>
	</div>
</header>

