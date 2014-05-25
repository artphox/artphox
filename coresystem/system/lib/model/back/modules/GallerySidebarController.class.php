<?php
namespace lib\model\back\modules;

use lib\model\back\core\SidebarController;
use lib\model\back\core\SidebarTree;

class GallerySidebarController extends SidebarController {

	//Should return a SideBarTree
	function createSidebarTree() {
		$tree = new SidebarTree();
		$tree->addType('0', true, true, true, true, '');
		$tree->addElement(0, 1, 'Hallo');
		$tree->addElement(0, 2, 'RekTest');
		$tree->addElement(0, 3, 'Sub', 1);
		$tree->addElement(0, 4, 'Sub', 1);
		$tree->addElement(0, 5, 'XX');
		return $tree;
	}

	//Should return false or the new HTML-Code for the stage
	function onClick($elementid) {

	}

	//0 = denie, 1 = ok, 2 = reload
	function onDrag($elementid, $oldposition, $newposition) {

	}

	//0 = denie, 1 = ok, 2 = reload
	function onRename($elementid, $oldtitle, $newtitle) {

	}

	//0 = denie, 1 = ok
	function onToggleButtonClicked($elementid, $state) {

	}

}


?>