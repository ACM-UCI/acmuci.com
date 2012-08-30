<?php 

define('IN_SITE', true);
require 'common.php';
require 'header.php';

$success = false;
if (isset($_POST['send'])) {
	if (!empty($_POST['name']))
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please enter your name.</p>';

	if (!empty($_POST['email'])) {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$errors .= '<p>Invalid email.</p>';
	} else
		$errors .= '<p>Please enter your e-mail</p>';

	if (!empty($_POST['message']))
		$message = filter_var($_POST['message'],
		FILTER_SANITIZE_STRING);
	else
		$errors .= '<p>Please enter your message.</p>';

	if (!$errors) {
		$headers = "From: $name <$email>\n";
		$headers .= "X-Sender: <contact@acmuci.com>\n";
		$headers .= "X-Mailer: PHP\n";
		$headers .= "X-Priority: 1\n";

		if (mail(ORG_EMAIL, EMAIL_SUBJECT, $message, $headers))
			$success = true;
		else
			$errors .= '<p>Mail could not be sent.</p>';
	}
}
?>

<section id="content">
	<div class="inner">
		<div id="contact" class="content-block">
			<h2>Contact Us</h2>

			<form action="contact.php" method="POST">
				<p>
					<label for="name">Full Name:</label><br />
					<input type="text" name="name" value="<?php
					echo (!empty($errors) && isset($_POST['name'])) ?
					$name : ''; ?>" required />
				</p>
				<p>
					<label for="email">Email:</label><br />
					<input type="email" name="email" value="<?php
					echo (!empty($errors) && isset($_POST['email'])) ?
					$email : ''; ?>" placeholder="example@uci.edu" required />
				</p> 
				<p>
					<label for="message">Message:</label><br />
					<textarea name="message" required><?php echo (!empty($errors) && isset($_POST['message'])) ? $message : ''; ?></textarea>
				</p>
				<p>
					<input type="submit" name="send" val="Send"
					/>
				</p>

				<?php 
					echo (isset($errors)) ? '<div class="errors">' .
					$errors .  '</div>' : '';
				?>

				<?php if ($success): ?>
				<div class="success">
					<p>Successfully sent message!</p>
				</div>
				<?php endif; ?>
			</form>

			<div class="caption">
				<p>Need to get in contact with someone in
				specific? You could searching through our try our
				<a
				href="http://www.facebook.com/groups/228954137162541/">
				Facebook Group</a>.</p>

				<p>If you can't seem to get a hold of us, try
				attending one of our events or visiting the
				scheduled meeting places as shown at the bottom
				of this page.</p>
			</div>
		</div>
	</div>
</section>

<?php require 'footer.php'; ?>
