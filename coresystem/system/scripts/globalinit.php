<?php
error_reporting(E_ALL);

set_include_path('../../system/');

require_once 'data/ConfigData.php';
require_once 'smarty/Smarty.class.php';


//spl_autoload_extensions('.class.php');
function apxAutoloader($str) {
	if (!@include $str.'.class.php') {
		smartyAutoload($str);
	}
}
spl_autoload_register('apxAutoloader');

if (defined(ERROR_REPORTING)) {
	error_reporting (ERROR_REPORTING);
}

?>