<?php
namespace lib\model\front\modules;

use lib\model\front\core\Style;
use lib\model\front\core\MenuArea;
use lib\model\front\core\WidgetArea;
use lib\model\front\core\DefaultPageDisplay;
use lib\manager\FrontendManager;
use lib\universal\ArtphoxException;

/*
NoStyle ist eine sehr simple Form von Style, weil sie eigentlich garkeiner ist.
HeadCode und BodyCode werden einfach in der Datenbank gespeichert. Genauso CSS.
Es sind 5 MenuAreas und 5 WidgetAreas vorhanden.
*/
class NoStyle extends Style {

	protected $menuareas;
	protected $widgetareas;

	private $smarty;

	function getHeadCode() {
		FrontendManager::loadModuleProperties($this, array('head', 'body', 'useSmarty'));
		if ($this->getProperty('useSmarty') == '1') {
			if ($this->smarty == null) $this->smarty = FrontendManager::createSmarty();
			return $this->smarty->fetch('string:'.$this->getProperty('head'));
		}
		return $this->getProperty('head');
	}

	function getBodyCode() {
		FrontendManager::loadModuleProperties($this, array('head', 'body', 'useSmarty'));
		if ($this->getProperty('useSmarty') == '1') {
			if ($this->smarty == null) $this->smarty = FrontendManager::createSmarty();
			return $this->smarty->fetch('string:'.$this->getProperty('body'));
		}
		return $this->getProperty('body');
	}

	function getCSS() {
		FrontendManager::loadModuleProperties($this, 'css');
		return $this->getProperty('css');
	}

	function getMenuAreas() {
		if (isset($this->menuareas)) return $this->menuareas;
		$this->menuareas = array();
		for ($i = 1; $i <= 5; $i++) {
			$this->menuareas[] = new MenuArea("Menu $i", $i, 2);
		}
		return $this->menuareas;
	}

	function getWidgetAreas() {
		if (isset($this->widgetareas)) return $this->widgetareas;
		$this->widgetareas = array();
		for ($i = 1; $i <= 5; $i++) {
			$this->widgetareas[] = new WidgetArea("WidgetArea $i", $i);
		}
		return $this->widgetareas;
	}

	function getPageCode(&$page) {
		return $page->getDefaultCode();
	}
}

?>