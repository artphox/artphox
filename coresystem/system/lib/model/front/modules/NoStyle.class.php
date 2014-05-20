<?php
namespace lib\model\front\modules;

use lib\model\front\core\Style;
use lib\model\front\core\MenuArea;
use lib\model\front\core\WidgetArea;
use lib\manager\FrontendManager;
use lib\universal\ArtphoxException;

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

	function getPageCode($page) {
		if ($page->getConfigName() == 'custompage') {
			FrontendManager::loadModuleProperties($page, array('html', 'smarty'));
			if ($page->getProperty('smarty') == '1') {
				$smarty = FrontendManager::createSmarty();
				return $smarty->fetch('string:'.$page->getProperty('html'));
			}
			return $page->getProperty('html');
		}
		throw new ArtphoxException('ERR_PAGE_NOT_SUPPORTED', array($page->getConfigName(), 'NoStyle'));
	}
}

?>