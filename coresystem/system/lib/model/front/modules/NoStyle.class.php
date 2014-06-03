<?php
namespace lib\model\front\modules;

use lib\model\front\core\Style;
use lib\model\front\core\MenuArea;
use lib\model\front\core\WidgetArea;
use lib\model\front\core\DefaultPageDisplay;
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

	function getPageCode(&$page) {
		$classname = $page->getConfigName();
		if (!is_file(get_include_path().'lib/model/front/modules/'.$classname.'.class.php')) {
			throw new ArtphoxException('ERR_CF_NOT_FOUND', $classname);
		}

		require_once 'lib/model/front/modules/'.$classname.'.class.php';

		//Möglichen Pfad von Klassennamen entfernen
		$index = strrpos($classname, '/');
		if ($index === false) $index = 0;
		else $index += 1;
		$classname = 'lib\\model\\front\\modules\\'.substr($classname, $index);

		if (!class_exists($classname)) {
			throw new ArtphoxException('ERR_CC_NOT_FOUND', $classname);
		}
		$display = new $classname();
		if (! ($display instanceof DefaultPageDisplay)) {
			throw new ArtphoxException('ERR_MODULE_WRONG_TYPE', array('DefaultPageDisplay', $classname));
		}
		return $display->printDefaultCode($page);
	}
}

?>