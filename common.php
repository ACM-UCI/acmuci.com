<?

// Only execute script from a true page
// Prevents possible hacking attempts
if (!defined('IN_SITE'))
	exit;

require 'config.php';

$db = new PDO('sqlite:db/database.db3');

?>
