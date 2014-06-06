<?php
namespace lib\model\back\modules;

use lib\model\back\core\SidebarController;
use lib\model\back\core\SidebarTree;

class PagesSidebarController extends SidebarController {

	//Should return a SideBarTree
	function createSidebarTree() {
		$tree = new SidebarTree();
		$tree->addType('X', true, true, true, true, 'icons/img.png');
		$tree->addElement('X', 1, 'Test');
		return $tree;
	}

	//Should return false or the new HTML-Code for the stage
	function onClick($elementid) {
		return array('stage', $elementid);
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