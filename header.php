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
<header id="page-header">
	<div class="inner">
		<div id="meta">
			<h1>
				<a href="index.php"><img src="images/logo.png" title="ACM" />
				<span id="chapter_tag">UC Irvine Chapter</span></a>
			</h1>
			<nav id="page-nav">
				<a href="index.php" title="Home">Home</a> 
				<a
				href="http://www.facebook.com/groups/228954137162541/events/"
				title="Facebook Events">Events</a> 
				<a href="projects.php" title="Projects">Projects</a> 
				<a href="about.php" title="About Us">About</a> 
				<a href="contact.php" title="Contact Us">Contact Us</a>
			</nav>
		</div>

		<div id="tagline">We compete in intercollegiate competitions and
		develop your ideas into projects</div>

		<p>Interested? There are no requirements to join; in fact, we encourage
		you to join if you have no experience. Consider attending one of our
		meetings that we hold once a week at <strong><?= ORG_ROOM ?></strong>
		at <strong><?= ORG_TIME ?></strong>.  Our chapter hosts a variety of
		events including workshops by UCI students to share knowledge and
		presentations by distinguished speakers about new ideas. <strong>We
		also love coffee.</strong></p>
		
		<a href="http://www.facebook.com/groups/228954137162541/"
		class="button">Join ACM</a>
	</div>
</header>

