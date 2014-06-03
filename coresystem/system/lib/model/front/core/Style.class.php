<?php
namespace lib\model\front\core;

abstract class Style extends Module {

	protected $objectid;
	protected $themeid;
	protected $title;
	protected $description;

	function getObjectId() {
		return $this->objectid;
	}

	function getThemeId() {
		return $this->themeid;
	}

	function getTitle() {
		return $this->title;
	}

	function getDescription() {
		return $this->description;
	}

	function getId() {
		return 'S'.$this->siteid . " / T" .$this->themeid;
	}

	abstract function getHeadCode();

	abstract function getBodyCode();

	abstract function getCSS();

	abstract function getMenuAreas();

	abstract function getWidgetAreas();

	abstract function getPageCode(&$page);

}

?>