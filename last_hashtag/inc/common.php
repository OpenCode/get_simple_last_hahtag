<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Common variables used by the GetSimple Last Hashtag.
 */

//error_reporting(E_ALL);ini_set('display_errors', '1');

# path definitions
define('LHTINCPATH', GSPLUGINPATH . 'last_hashtag/inc/');
define('LHTXMLFILE', GSDATAOTHERPATH .'LastHashTag.xml');

# includes
require_once(LHTINCPATH . 'sidebar.php');
require_once(LHTINCPATH . 'functions.php');

?>
