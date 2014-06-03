<?php 

error_reporting(E_ALL);

require 'globalinit.php';

if (!isset($slug)) {
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
}

use lib\manager\BackendManager;

$need_navbar = true;
$need_sidebar = true;
$need_pages = true;
require 'data/AdminData.php';

try {
	$smarty = BackendManager::createSmarty();
	$navbar = BackendManager::getNavbarCode();
	$sidebartabid = BackendManager::getSidebarTabId($slug);
	$sidebardata = BackendManager::getSidebarData($sidebartabid);
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