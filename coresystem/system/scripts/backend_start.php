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

echo BackendManager::getNavbarCode();
echo BackendManager::getSidebarCode();
echo BackendManager::getStageCode($slug);

?>