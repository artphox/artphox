<?php

namespace lib\model\front\modules;

use lib\model\front\core\DefaultPageDisplay;
use lib\manager\FrontendManager;

class CustomPage extends DefaultPageDisplay {

	function printDefaultCode(&$page) {
		FrontendManager::loadModuleProperties($page, array('html', 'smarty'));
		if ($page->getProperty('smarty') == '1') {
			$smarty = FrontendManager::createSmarty();
			return $smarty->fetch('string:'.$page->getProperty('html'));
		}
		return $page->getProperty('html');
	}

}

?>