<?php

namespace lib\manager;

use lib\universal\ArtphoxException;

class BackendController {

	static function sideBarItemClicked(&$xml, $tabid, $elementid) {
		try {
			$need_sidebar = true;
			require 'data/AdminData.php';
			$controller = BackendManager::getSidebarController($_POST['tabid']);
			$result = $controller->onClick($_POST['elid']);
			$xml->addChild($result[0], $result[1]);
		} catch (\Exception $ex) {
			$xml->addChild('error', strval($ex));
		}
	}

	static function sideBarTabChanged(&$xml, $tabid) {
		try {
			$need_sidebar = true;
			require 'data/AdminData.php';
			$data = BackendManager::getSidebarData($_POST['tabid']);
			$xml->addChild('sidebardata', $data);
		} catch (\Exception $ex) {
			$xml->addChild('error', strval($ex));
		}
	}

}


?>