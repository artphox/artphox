<?php 

error_reporting(E_ALL);

require 'globalinit.php';

//Slug muss auch hier abgefragt werden.
$slug = strtolower($_GET['slug']);

if (isset($slug)) {
	$slug = substr($slug, 6);
	if (strlen($slug) > 0) {
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
	} else {
		$slug = 'start';
	}
} else {
	$slug = 'start';
}

use lib\manager\BackendManager;

$need_navbar = true;
$need_sidebar = true;
$need_pages = true;
require 'data/AdminData.php';

try {
	$smarty = BackendManager::createSmarty();
	$navbar = BackendManager::getNavbarCode();
	$sidebardata = BackendManager::getSidebarData($slug);
	$sidebartabs = BackendManager::getSidebarTabCode();
	$stage = BackendManager::getStageCode($slug);
	$smarty->assign('navbar', $navbar);
	$smarty->assign('sidebardata', $sidebardata);
	$smarty->assign('sidebartabs', $sidebartabs);
	$smarty->assign('stage', $stage);
	$smarty->display('index.tpl');
} catch (Exception $ex) {
	die(strval($ex));
}



?>