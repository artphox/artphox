<?php
namespace lib\manager;

use lib\universal\ArtphoxException;

/*
SmartyConnector sorgt für die Funktionalität der Smarty-Funktionen
Es gibt folgende Smarty Funktionen:
{apx_menu areaid="int"} Gibt den Code eines Menüs aus
{apx_widgetcollection areaid="int"} Gibt den Code einer WidgetCollection.
{apx_page} Gibt den Code der geladenen Page aus
{apx_widget widgetid="int"} Gibt den Code des angegeben Widgets aus
{apx_systemproperty key="string"} Gibt ein SystemProperty aus
{apx_styleproperty key="string"} Gibt ein StyleProperty aus
{apx_pageproperty key="string"} Gibt ein Property der aktuellen Page aus
{apx_widgetproperty widgetid="int" key="string"} Gibt ein Property des angegebenen Widgets aus
{apx_configdata name="string"} Gibt eine Konstante aus der ConfigData aus
{apx_langtext key="string"} Gibt ein Sprachitem aus
*/
class SmartyConnector {

	static function assignFunctions($smarty) {
		$connector = new SmartyConnector();
		$smarty->registerPlugin('function', 'apx_menu', array($connector, 'apxMenu'));
		$smarty->registerPlugin('function', 'apx_widgetcollection', array($connector, 'apxWidgetCollection'));
		$smarty->registerPlugin('function', 'apx_page', array($connector, 'apxPage'));
		$smarty->registerPlugin('function', 'apx_widget', array($connector, 'apxWidget'));
		$smarty->registerPlugin('function', 'apx_systemproperty', array($connector, 'apxSystemProperty'));
		$smarty->registerPlugin('function', 'apx_styleproperty', array($connector, 'apxStyleProperty'));
		$smarty->registerPlugin('function', 'apx_pageproperty', array($connector, 'apxPageProperty'));
		$smarty->registerPlugin('function', 'apx_widgetproperty', array($connector, 'apxWidgetProperty'));
		$smarty->registerPlugin('function', 'apx_configdata', array($connector, 'apxConfigData'));
		$smarty->registerPlugin('function', 'apx_langtext', array($connector, 'apxLangText'));
		//Eventuell noch loadProperties?
	}

	private function __construct() {
	}

	//onerror: nothing, htmlcomment, jscomment, exception
	private function handleError($ex, $params) {
		if (isset($params['onerror'])) {
			if ($params['onerror'] == 'nothing') {
				return '';
			}
			if ($params['onerror'] == 'htmlcomment') {
				return '<!-- '.$ex.' -->';
			}
			if ($params['onerror'] == 'jscomment') {
				return '/* '.$ex.' */';
			}
		}
		throw $ex;
	}

	function apxMenu($params, $smarty) {
		try {
			if (!isset($params['areaid'])) {
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_menu', 'areaid'));
			}
			return FrontendManager::getMenuCode($params['areaid']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxWidgetCollection($params, $smarty) {
		try {
			if (!isset($params['areaid'])) {
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_widgetcollection', 'areaid'));
			}
			return FrontendManager::getWidgetCollectionCode($params['areaid']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxPage($params, $smarty) {
		try {
			return FrontendManager::getPageCode();
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxWidget($params, $smarty) {
		try {
			if (!isset($params['widgetid'])) {
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_widget', 'widgetid'));
			}
			return FrontendManager::getWidgetCode($params['widgetid']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxSystemProperty($params, $smarty) {
		try {
			if (!isset($params['key']))	{
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_systemproperty', 'key'));
			}
			return FrontendManager::getSystemProperty($params['key']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxStyleProperty($params, $smarty) {
		try {
			if (!isset($params['key']))	{
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_styleproperty', 'key'));
			}
			return FrontendManager::getStyleProperty($params['key']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxPageProperty($params, $smarty) {
		try {
			if (!isset($params['key']))	{
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_pageproperty', 'key'));
			}
			return FrontendManager::getPageProperty($params['key']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxWidgetProperty($params, $smarty) {
		try {
			if (!isset($params['widgetid']))	{
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_widgetproperty', 'widgetid'));
			}
			if (!isset($params['key']))	{
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_widgetproperty', 'key'));
			}
			return FrontendManager::getWidgetProperty($params['widgetid'], $params['key']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxConfigData($params, $smarty) {
		try {
			if (!isset($params['name'])) {
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_configdata', 'name'));
			}
			return FrontendManager::getConfigData($params['name']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}

	function apxLangText($params, $smarty) {
		try {
			if (!isset($params['key']))	{
				throw new ArtphoxException('ERR_MISSING_PARAMETER', array('apx_langtext', 'key'));
			}
			return FrontendManager::getLanguageText($params['key']);
		} catch (ArtphoxException $ex) {
			return $this->handleError($ex, $params);
		}
	}


};

?>