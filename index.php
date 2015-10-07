<?php
 //print_r($_GET['url']);

/*
/ linux
\
*/

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__FILE__)).DS);
define("APP_PATH", ROOT."aplication".DS);

//echo ROOT;

require_once(APP_PATH . "config.php");
require_once(APP_PATH . "Request.php");
require_once(APP_PATH . "Bootstrap.php");
require_once(APP_PATH . "controller.php");
require_once(APP_PATH . "Model.php");
require_once(APP_PATH . "View.php");
require_once(APP_PATH . "database.php");

echo "<pre>"; print_r(get_required_files());
 