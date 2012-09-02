<?

define('APP_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_LIBS', APP_ROOT . 'libs' . DIRECTORY_SEPARATOR);

require_once APP_ROOT . 'config.php';

$dsn = sprintf('%s:%s', DB_ENGINE, APP_LIBS . 'db/' . DB_NAME);
$db = new PDO($dsn);

require_once APP_LIBS . 'facebook/facebook.php';

$fb = new Facebook(array(
	'appId' => FB_APP_ID,
	'secret' => FB_SECRET
));

?>
