<?php

/*
Dieses Script wird beim direkten Aufruf einer Seite aufgerufen.
Weiterleitung durch .htaccess
*/

error_reporting(E_ALL);

require 'globalinit.php';


$slug = strtolower($_GET['slug']);
if (isset($slug) && strlen($slug) > 0) {
	//slug gegebenfalls um Slashes kürzen
	$newl = strlen($slug)-1;
	while ($slug[$newl] == '/') {
		$slug = substr($slug, 0, $newl);
		$newl = strlen($slug)-1;
	}
	//Doppelte Slashes entfernen
	while (strpos($slug, '//') !== false) {
		$slug = str_replace('//', '/', $slug);
	}
}

use lib\manager\FrontendManager;
use lib\universal\DataAccess;
use lib\universal\ArtphoxException;
//------------------------------------------------------------------------------------------------


function printError($ex) {
	$tplfile = ERROR_TPL_SITE;
	try {
		$smarty = FrontendManager::createSmarty();
		$smarty->assign('error', strval($ex));
		$smarty->display(ERROR_TPL_SITE);
	} catch (Exception $ex) {
		die($ex);
	}
}

try {
	FrontendManager::loadSite($slug);
	echo utf8_encode(FrontendManager::getSiteCode());
} catch (ArtphoxException $ex) {
	printError($ex);
} catch (Exception $ex) {
	$ce = new ArtphoxException('DEFAULT', array(get_class($ex), $ex->getMessage()));
	printError($ce);
}


?>