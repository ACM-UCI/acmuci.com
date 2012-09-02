<?

require 'config.php';

define('APP_ROOT', getcwd() . DIRECTORY_SEPARATOR);
define('APP_LIBS', APP_ROOT . 'libs' . DIRECTORY_SEPARATOR);
define('APP_STYLES', APP_ROOT . 'styles' . DIRECTORY_SEPARATOR);
define('APP_IMAGES', APP_ROOT . 'images' . DIRECTORY_SEPARATOR);

$dsn = sprintf('%s:%s', DB_ENGINE, APP_LIBS . 'db/' . DB_NAME);
$db = new PDO($dsn);

//require_once APP_LIBS . 'facebook/facebook.php';

//$facebook = new Facebook(array(
//	'appId' => FB_APP_ID,
//	'secret' => FB_SECRET
//));

?>
