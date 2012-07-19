<?php
$ua = $_SERVER['HTTP_USER_AGENT'];
$checker = array(
  'iphone'=>preg_match('/iPhone|iPod/', $ua),
  'android'=>preg_match('/Android/', $ua),
);
?>

<!DOCTYPE html>
<html>
<head>
<title>ACM, UC Irvine Chapter</title>
<meta name="description" content="UC Irvine student chapter for
ACM for advancing computing as a science and profession." />
<meta name="keywords" content="UC Irvine, ACM, computing,
computer science, icpc, ieeextreme, programming competition" />
<?php if ($checker['iphone'] || $checker['android']): ?>
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" />
<link rel="stylesheet" type="text/css" href="styles/mobi.css"
media="all" />
<?php else: ?>
<link rel="stylesheet" type="text/css" href="styles/style.css"
media="screen" />
<?php endif; ?>

</head>
<body>

<div id="ribbon">&nbsp;</div>
<header id="page-header">
	<div class="inner">
		<div id="meta">
			<h1><a href="index.php"><img src="images/logo.png" title="ACM"
			/> <span id="chapter_tag">UC Irvine Chapter</span></a></h1>
			<nav id="page-nav">
				<a href="index.php" title="Home">Home</a> 
				<a
				href="http://www.facebook.com/groups/228954137162541/events/"
				title="Facebook Events">Events</a> 
				<a href="about.php" title="About Us">About</a> 
				<a href="contact.php" title="Contact Us">Contact Us</a>
			</nav>
		</div>

		<div id="tagline">We compete in intercollegiate
		competitions and develop your ideas into projects</div>
		<p>Interested? There are no requirements to join; in
		fact, we encourage you to join if you have no
		experience. Consider attending one of
		our meetings that we hold once a week at
		<strong>DBH 1300</strong> at <strong>7:30PM</strong>.
		Our chapter hosts a variety of events including
		workshops by UCI students to share knowledge and
		presentations by distinguished speakers about new
		ideas. <strong>We also love coffee.</strong></p>
		<a href="http://www.facebook.com/groups/228954137162541/" class="button">Join ACM</a>
	</div>
</header>

