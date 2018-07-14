<?php
if(!isset($_SESSION)){
	session_name('rcvicharan');
	session_start();
	$_SESSION['rcvicharan'] = session_id();
}

date_default_timezone_set("America/New_York");
setlocale(LC_MONETARY,'en_US');
mb_http_input("utf-8");
mb_http_output("utf-8");

ini_set('display_errors',1);
//error_reporting(E_ALL);
error_reporting(E_ALL & ~E_NOTICE | ~E_WARNING);

//ini_set('log_errors','On');

// Find out with site is running
if(preg_match("/\/home\/kishore\/public_html\/rcvicharan\/dev/i", dirname(__FILE__))){
	//ini_set('display_errors','Off');
	$site = 'dev';
	$site_url = 'http://kishore.na.baps.org/rcvicharan/dev/';
}else if(preg_match("/\/home\/kishore\/public_html\/rcvicharan/i", dirname(__FILE__))){
	//ini_set('display_errors','Off');
	$site = 'live';
	$site_url = 'http://kishore.na.baps.org/rcvicharan/';
}else{
	//ini_set('display_errors','On');
	$site = 'local';
	$site_url = 'http://localhost/rc-vicharan/';
}
// define the site
defined('SITE')           || define('SITE', $site);
// define the site title short
defined('SESSION_NAME')   || define('SESSION_NAME', 'rcvicharan');
// define the site title short
defined('SITE_TITLE')     || define('SITE_TITLE_SHORT', 'RC-Vicharan');
// define the site name
defined('SITE_NAME')      || define('SITE_NAME', 'RC-Vicharan');
// define the site slogan
defined('SITE_SLOGAN')    || define('SITE_SLOGAN', '');
// define the site url
defined('SITE_URL')       || define('SITE_URL', $site_url);
// define the directory reparator from php. window is \, mac & linix is /
defined('DS')             || define('DS', DIRECTORY_SEPARATOR);
// root path
defined('ROOT_PATH')      || define('ROOT_PATH', realpath(dirname(__FILE__).DS."..".DS));
// classes folder
defined('CLASS_DIR')      || define('CLASS_DIR', 'class');
// src folder
defined('SRC_DIR')        || define('SRC_DIR', 'src'.DS);
// src folder
defined('SRC_DEV_DIR')    || define('SRC_DEV_DIR', 'src_dev'.DS);
// logs folder
defined('LOGS_DIR')       || define('LOGS_DIR', 'logs');
// process folder
defined('PROCESS_DIR')    || define('PROCESS_DIR', 'process');
// pages folder
defined('PAGES_DIR')      || define('PAGES_DIR', 'pages');
// layout folder
defined('LAYOUT_DIR')     || define('LAYOUT_DIR', 'layout');
// image folder
defined('IMG_DIR')        || define('IMG_DIR', SRC_DIR.'img'.DS);
// plugin folder
defined('PLUGIN_DIR')     || define('PLUGIN_DIR', SRC_DIR.'plugin'.DS);
// plugin folder
defined('PLUGIN_DEV_DIR') || define('PLUGIN_DEV_DIR', SRC_DEV_DIR.'plugin'.DS);
// Database prefix
defined('DB_PREFIX')      || define('DB_PREFIX', '3_');
// Setup level
defined('SETUP')          || define('SETUP', 5);


// user_level
defined('UL_SITE_ADMIN') || define('UL_SITE_ADMIN',101);
defined('UL_NA_SANT')    || define('UL_NA_SANT',102);
defined('UL_NA_RC')      || define('UL_NA_RC',103);
defined('UL_RCL_SANT')   || define('UL_RCL_SANT',104);
defined('UL_RCL')        || define('UL_RCL',105);
defined('UL_RA')         || define('UL_RA',106);
defined('UL_RC_SANT')    || define('UL_RC_SANT',107);
defined('UL_RC')         || define('UL_RC',108);
defined('UL_SANCHALAK')  || define('UL_SANCHALAK',109);

// datetime
defined('DATETIME') || define('DATETIME', date('Y-m-d H:i:s'));
// IP
defined('IP')       || define('IP', $_SERVER['REMOTE_ADDR']);

// add all directory to include parth
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(ROOT_PATH.DS.CLASS_DIR),
	realpath(ROOT_PATH.DS.SRC_DIR),
	realpath(ROOT_PATH.DS.LOGS_DIR),
	realpath(ROOT_PATH.DS.PROCESS_DIR),
	realpath(ROOT_PATH.DS.PAGES_DIR),
	realpath(ROOT_PATH.DS.LAYOUT_DIR),
	get_include_path()
)));

// autoload the class
spl_autoload_register(function ($class_name){
	$classes = explode('_', $class_name);
	$path = implode('/', $classes).'.class.php';
	require_once $path;
});
?>