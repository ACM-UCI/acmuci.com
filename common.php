<?

define('APP_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_LIBS', APP_ROOT . 'libs' . DIRECTORY_SEPARATOR);
define('APP_MODELS', APP_ROOT . 'models' . DIRECTORY_SEPARATOR);

require_once APP_ROOT . 'config.php';

$dsn = sprintf('%s:%s', DB_ENGINE, APP_LIBS . 'db/' . DB_NAME);
$db = new PDO($dsn);

require_once APP_LIBS . 'facebook/facebook.php';

$fb = new Facebook(array(
	'appId' => FB_APP_ID,
	'secret' => FB_SECRET
));

if (!session_id())
	session_start();

$user = $fb->getUser();
$logged_in = false;

if (!$user) {
	$login_url = $fb->getLoginUrl(array(
		'scope' => 'create_event',
		'redirect_uri' => 'http://' . $_SERVER['HTTP_HOST'] . '/' .
		$_SERVER['REQUEST_URI']
	));
} else if (empty($_SESSION['user_info'])) {
	$logged_in = true;
	$user_info = $fb->api("/$user");

	$query = 'SELECT *
		FROM members
		WHERE member_fb_id = :user_id';
	$stmt = $db->prepare($query);
	$stmt->bindParam(':user_id', $user_info['id']);
	$stmt->execute();
	$member = $stmt->fetch();
	$user_info = array_merge($user_info, $member);
	$_SESSION['user_info'] = $user_info;
} else {
	$user_info = $_SESSION['user_info'];
}

?>
