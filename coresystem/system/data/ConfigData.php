<?php

define('DAS_TPL', 'core.defaultapxsite.tpl');

define('DAS_TITLE_PATTERN_NORMAL', '%site% - %page%');

define('DAS_TITLE_PATTERN_ERROR', '%site% - Error');

define('DAS_TITLE_PATTERN_SITEONLY', '%site%');

define('ADAPTION_FADE_DURATION', 400);

define('ADAPTION_FADE_EASING', 'swing');

define('DB_CONNECTION_STRING', 'mysql:host=127.0.0.1;dbname=ApxCore003');

define('DB_USER', 'root');

define('DB_PASS', '');

define('ERROR_DATABASE', '<b>Error:</b> Could not connect to Database<br>{all}');

define('ERROR_DEFAULT', '<b>Unknown Error:</b><br>Data: {all}');

define('ERROR_REPORTING', E_ALL);

define('ERROR_TPL_SITE', 'core.defaulterrorsite.tpl');

define('ERROR_TPL_PAGE', 'core.defaulterrorpage.tpl');

define('ACP_TPL_ERROR_PAGE', 'error.tpl');

class ObjectConfigData {

	const DB_OPTIONS = null;
}


?>