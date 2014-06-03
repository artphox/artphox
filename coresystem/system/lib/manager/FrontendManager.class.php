<?php
namespace lib\manager;

use lib\model\front\core\Site;
use lib\model\front\core\Page;
use lib\model\front\core\Style;
use lib\model\front\core\Widget;
use lib\universal\DataAccess;
use lib\universal\ArtphoxException;

use \Smarty as Smarty;
use \PDO as PDO;
use \PDOException as PDOException;

/*
FrontendManager
Beinhaltet alle Daten des Frontends und alle möglichen Methoden um auf diese zuzugreifen.
Das ganze basiert auf einem simplen Caching-Konzept:
Inhalte (Seiten, Properties etc.) werden zunächst in den Manager geladen (load-Methoden),
bevor auf sie über die Get-Methoden zugegriffen werden kann.
Die Load-Methoden (außer LoadSite) werfen keine Exceptions, falls die übergebenen Werte nicht gefunden werden.
Das hat den Vorteil, dass die Inhalte nicht doppelt geladen werden, da immer überprüft wird, ob die Daten bereits geladen 
wurden.
Im Cache befinden sich die aktuelle Site inklusive Page und Style, alle geladenen Widgets, die System-Properties
und die Sprachelemente.
Zusätzlich besitzen alle Module-Klassen (Page, Style, Widget) jeweils eigene Property-Caches.
Möchte man Properties der Module laden, kann man FrontendManager::loadModuleProperties verwenden, und dabei das Objekt
übergeben.
*/
class FrontendManager extends Manager {

	private static $site = null;
	private static $widgets = array();

	//Liefert die gespeicherte Site
	static function getSite() {
		if (self::$site == null || !(self::$site instanceof Site)) {
			throw new ArtphoxException('ERR_SITE_NOT_LOADED');
		}
		return self::$site;
	}

	//Liefert die gespeicherte Page
	static function getPage() {
		$page = self::getSite()->getPage();
		if ($page == null || !($page instanceof Page)) {
			throw new ArtphoxException('ERR_PAGE_NOT_LOADED');
		}
		return $page;
	}

	//Liefert den gespeicherten Style
	static function getStyle() {
		$style = self::getSite()->getStyle();
		if ($style == null || !($style instanceof Style)) {
			throw new ArtphoxException('ERR_STYLE_NOT_LOADED');
		}
		return $style;
	}

	/*Liefert ein Smarty-Objekt.
	Der Parameter $functions gibt an, ob Smarty-Funktionen des SmartyConnectors eingebunden werden sollen.
	*/
	static function createSmarty($functions=true) {
		$smarty = new Smarty();
		$smarty->use_include_path = true;
		$smarty->setTemplateDir('tpl');
		$smarty->setCompileDir(get_include_path().'tpl_compile');
		if ($functions) {
			SmartyConnector::assignFunctions($smarty);
		}
		return $smarty;
	}

	/*Ladet eine Site in den Speicher inklusive zugehöriger Page und Style.
	Paramter $slug: Der angegebene Slug
	Parameter $ignoresite: Falls true gesetzt ist, werden die Attribute Adaption und Titel der Site nicht gesetzt (für ChangePageProcess)
	*/
	static function loadSite($slug, $ignoresite=false) {
		try {
			self::$site = FrontendLoader::loadSite($slug, $ignoresite);
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
	}

	/*Ladet Properties von einem Modul (Page, Style, Widget) in seinen Cache.
	Sollte das Property schon geladen sein, wird es nicht nochmal geladen.
	Parameter $object: Modul-Objekt
	Parameter $propertynames: Ein einzelner Propertyname oder ein Array von Propertynamen. Falls null übergeben wird, werden alle Properties geladen.
	*/
	static function loadModuleProperties(&$object, $propertynames=null) {
		try {
			$statement = FrontendLoader::loadModuleProperties($object, $propertynames);
			if ($statement !== false) {
				while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
					$object->addProperty($result['key'], $result['value']);
				}
			}
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
	}

	/*Ladet ein Widget in den Cache.
	Parameter $widgetid: Die ID des Widgets (surprise!)
	*/
	static function loadWidget($widgetid) {
		try {
			$widget = FrontendLoader::loadWidget($widgetid);
			self::$widgets[$widgetid] = $widget;
			return $widget;
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
	}

	/*Liefert den HTML-Code des Menüs, welches der angegebenen AreaId übergeben wurde.
	Code wird dabei einfach als <ul><li>-Baum ausgegeben. Links werden ebenfalls selbst geniert.
	Deal with it!
	Außerdem wird unterschieden zwischen automatischem Menü und manuell festgelgtem Menü.
	Beim automatisch werden einfach alle Pages durchgegangen und ausgegeben.
	*/
	static function getMenuCode($areaid) {
		$menuareas = self::getSite()->getStyle()->getMenuAreas();
		foreach ($menuareas as $menuarea) {
			if ($menuarea->getIdentifier() == $areaid) {
				try {
					$pdo = DataAccess::getPDO();
					$statement = $pdo->prepare('SELECT menu_id, menu_automatic FROM Menu WHERE menu_areanr = :id');
					$statement->execute(array(':id' => $areaid));
					$menuresult = $statement->fetch(PDO::FETCH_ASSOC);
					if ($menuresult == false) {
						throw new ArtphoxException('ERR_NO_MENU_FOUND', array($areaid));
					}
					if ($menuresult['menu_automatic'] == 1) {
						//Automatisches Menü erstellen

						//Rekursive Funktion:
						function createAutomaticMenu($pages, $area) {
							$pdo = DataAccess::getPDO();
							foreach ($pages as $page) {
								if ($area->getDeepness() > 1) {
									$statement = $pdo->prepare('SELECT sta_slug, p_id, p_displaytitle FROM State JOIN Page ON sta_page = p_id WHERE p_parent = :parentid ORDER BY p_order');
									$statement->execute(array(':parentid' => $page['p_id']));
									$results = $statement->fetchAll(PDO::FETCH_ASSOC);
									if (count($results) != 0) {
										$subarea = $area->createSubMenu($page['p_displaytitle']);
										createAutomaticMenu($results, $subarea);
										continue;
									}
								}
								$area->addItem('<a href="'.$page['sta_slug'].'" '.((FrontendManager::getSite()->usesAdaption())?('class="ajaxlink" '):'').'>'.$page['p_displaytitle'].'</a>');
							}
						}

						$statement = $pdo->prepare('SELECT sta_slug, p_id, p_displaytitle FROM State JOIN Page ON sta_page = p_id WHERE p_parent IS NULL ORDER BY p_order');
						$statement->execute();
						$results = $statement->fetchAll(PDO::FETCH_ASSOC);
						createAutomaticMenu($results, $menuarea);
					} 
					else {
						//Manuelles Menü auslesen

						//Rekursive Funktion
						function createManualMenu($menuitems, $area) {
							$pdo = DataAccess::getPDO();
							foreach ($menuitems as $menuitem) {
								if ($area->getDeepness() > 1 && $menuitem['meit_submenu'] != null) {
									$statement = $pdo->prepare('SELECT meit_url, meit_title, meit_ajaxlink, meit_submenu FROM MenuItem WHERE meit_menu = :menuid ORDER BY meit_order;');
									$statement->execute(array(':menuid' => $menuitem['meit_submenu']));
									$results = $statement->fetchAll(PDO::FETCH_ASSOC);
									if (count($results) != 0) {
										$subarea = $area->createSubMenu($menuitem['meit_title']);
										createManualMenu($results, $subarea);
										continue;
									}
								}
								$area->addItem('<a href="'.$menuitem['meit_url'].'" '.(($menuitem['meit_ajaxlink'] == '1' && FrontendManager::getSite()->usesAdaption())?('class="ajaxlink" '):'')
												.'>'.$menuitem['meit_title'].'</a>');
							}
						}

						$statement = $pdo->prepare('SELECT meit_url, meit_title, meit_ajaxlink, meit_submenu FROM MenuItem JOIN Menu ON menu_id = meit_menu WHERE menu_id = :menuid ORDER BY meit_order;');
						$statement->execute(array(':menuid' => $menuresult['menu_id']));
						$results = $statement->fetchAll(PDO::FETCH_ASSOC);
						createManualMenu($results, $menuarea);
					}
					return $menuarea->getCode();
				} catch (PDOException $e) {
					throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
				}
			}
		}
		throw new ArtphoxException('ERR_MENUAREA_NOT_FOUND', $areaid);
	}

	/*Gibt den Code für eine Widget-Collection in der angegebenen WidgetArea aus
	*/
	static function getWidgetCollectionCode($areaid) {

		$widgetareas = self::getSite()->getStyle()->getWidgetAreas();
		foreach($widgetareas as $widgetarea) {
			if ($widgetarea->getIdentifier() == $areaid) {
				try {
					$pdo = DataAccess::getPDO();
					$statement = $pdo->prepare('SELECT wc_id FROM WidgetCollection WHERE wc_areanr = :areanr;');
					$statement->execute(array(':areanr' => $areaid));
					$wcid = $statement->fetchColumn();
					if ($wcid == false) {
						throw new ArtphoxException('ERR_NO_WIDGETCOLLECTION_FOUND', $areaid);
					}

					$widgets = FrontendLoader::loadWidgetCollectionItems($wcid);
					foreach ($widgets as $id => $widget) {
						$widgetarea->addWidget($widget);
						self::$widgets[$id] = $widget;
					}

					return $widgetarea->getCode();
				} catch (PDOException $e) {
					throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
				}
			}
		}
		throw new ArtphoxException('ERR_WIDGETAREA_NOT_FOUND', $areaid);
	}

	static function getPageCode() {
		$page = self::getPage();
		$style = self::getStyle();
		return $style->getPageCode($page);
	}

	//Joa die restlichen Methoden müssten klar sein.
	//getSiteCode: Ist die Seite noch nicht geladen, wird es einen Fehler geben
	//Bei den anderen Methoden werden die fehlenden Daten geladen.
	//Property-Methoden sind jeweils nur für einen Key geeignet.

	static function getSiteCode() {

		return self::getSite()->getFrontendCode();
	}

	static function getWidgetCode($widgetid) {
		if (array_key_exists($widgetid, self::$widgets)) {
			return self::$widgets[$widgetid]->getFrontendCode();
		}
		return self::loadWidget($widgetid)->getFrontendCode();
	}

	static function getStyleProperty($key) {
		$style = self::getStyle();
		if (! $style->hasLoadedProperty($key)) {
			self::loadModuleProperties($style, $key);
		}
		return $style->getProperty($key);
	}

	static function getPageProperty($key) {
		if(($page = self::getPage()) == null || !($page instanceof Page)) {
			throw new ArtphoxException('ERR_PAGE_NOT_LOADED');
		}
		if (! $page->hasLoadedProperty($key)) {
			self::loadModuleProperties($page, $key);
		}
		return $page->getProperty($key);
	}

	static function getWidgetProperty($widgetid, $key) {
		if (array_key_exists($widgetid, self::$widgets)) {
			$widget = self::$widgets[$widgetid];
		}
		if ($widget == null || !($widget instanceof Widget)) {
			$widget = self::$loadWidget($widgetid);
		}
		if (! $widget->hasLoadedProperty($key)) {
			self::loadModuleProperties($widget, $key);
		}
		return $widget->getProperty($key);
	}
	
}

?>