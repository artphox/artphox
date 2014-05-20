<?php

abstract class SidebarController {

	//Should return a SideBar
	abstract function createSidebar();

	//Should return false or the new HTML-Code for the stage
	abstract function onClick($elementid);

	//0 = denie, 1 = ok, 2 = reload
	abstract function onDrag($elementid, $oldposition, $newposition);

	//0 = denie, 1 = ok, 2 = reload
	abstract function onRename($elementid, $oldtitle, $newtitle);

	//0 = denie, 1 = ok
	abstract function onToggleButtonClicked($elementid, $state);
}

?>