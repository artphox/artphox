<?php
namespace lib\manager;

use lib\model\front\core\Site;
use lib\model\front\core\Page;
use lib\model\front\core\Style;
use lib\model\front\core\Widget;
use lib\universal\DataAccess;
use lib\universal\ArtphoxException;

use \PDO as PDO;

/*
This class is used as a helper for FrontendManager.
As FrontendManager.class.php got over 500 lines of code,
a part of it is outsourced into this class.
This class should be only used by FrontendManager.
*/
class FrontendLoader {

	static function loadSite($slug, $ignoresite) {
		$pdo = DataAccess::getPDO();
		$styleresult = null;

		//-----------------------
		//Siteeigenschaften herausfinden
		$properties = array('Language', 'CurrentStyle');
		if ($ignoresite === false) {
			$properties[] = 'Adaption';
			$properties[] = 'SiteTitle';
		}
		if ($slug == '') {
			$properties[] = 'DefaultPage';
		}
		FrontendManager::loadSystemProperties($properties);
		

		//Seite laden
		if ($slug == '' && ($defaultid = FrontendManager::getSystemProperty('DefaultPage')) !== false) {		
			//Frage Default-Site ab!
			$statement = $pdo->prepare('SELECT p_id, p_displaytitle, pt_configname FROM Page JOIN PageType ON p_type = pt_id WHERE p_id = :id');
			$statement->execute(array(':id' => $defaultid));
			$pageresult = $statement->fetch(PDO::FETCH_ASSOC);
			if ($pageresult == false) {
				throw new ArtphoxException('ERR_404', $slug.' (#'.$defaultid.')');
			}
			$pageresult['sta_extra'] = null;
		}

		//Ansonsten: Weitersuchen!
		else {

			//Nach einer Page suchen, die diesem Slug entspricht
			$statement = $pdo->prepare(
				   'SELECT p_id, p_displaytitle, pt_configname, sta_extra
					FROM Page 
					JOIN PageType ON p_type = pt_id
					JOIN State ON p_id = sta_page
					WHERE sta_slug = :slug');
			$statement->execute(array(':slug' => $slug));
			$pageresult = $statement->fetch(PDO::FETCH_ASSOC);

			if ($pageresult === false) {
				throw new ArtphoxException('ERR_404', $slug);
			}
		}
		$pageobject = new Page(array('id' => $pageresult['p_id'], 'displaytitle' => $pageresult['p_displaytitle'], 'configname' => $pageresult['pt_configname'], 'extra' => $pageresult['sta_extra']));
		if (!($pageobject instanceof Page)) {	throw new ArtphoxException('ERR_MODULE_WRONG_TYPE', array('Page', $pageresult['pt_classname'])); }

		//-----------------------
		//Nach Style suchen!
		//Nun holn wir uns die StyleTheme-Daten
		$styleid = FrontendManager::getSystemProperty('CurrentStyle');
		$statement = $pdo->prepare(
				'SELECT so_id, st_id, st_classname FROM StyleObject JOIN StyleTheme ON so_id = st_id WHERE so_id = :style;');
		$statement->execute(array(':style' => $styleid));
		$styleresult = $statement->fetch(PDO::FETCH_ASSOC);
		if ($styleresult == false) {
			throw new ArtphoxException('ERR_STYLE_LOADING_FAILED', $styleid);
		}

		//-----------------------
		//Objekte erzeugen!

		$styleobject = self::createModuleObject($styleresult['st_classname'], array('objectid' => $styleid, 'themeid' => $styleresult['st_id']));
		if (!($styleobject instanceof Style)) {	throw new ArtphoxException('ERR_MODULE_WRONG_TYPE', array('Style', $styleresult['st_classname']));	}

		if ($ignoresite === false) {
			$siteobject = new Site(array('displaytitle' => FrontendManager::getSystemProperty('SiteTitle'), 'slug' => $slug, 
																	'adaption' => FrontendManager::getSystemProperty('Adaption'), 'page' => $pageobject, 'style' => $styleobject));
		} else {
			$siteobject = new Site(array('slug' => $slug, 'page' => $pageobject, 'style' => $styleobject));
		}

		return $siteobject;
	}

	private static function createModuleObject ($classname, $params) {
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
		$object = new $classname($params);
		return $object;
	}

	static function loadModuleProperties(&$object, $propertynames) {
		//Object sollte vom Typ Module sein
		//Propertynames darf null, string, oder string-array sein

		//--------Building Basic Query Strings--------

		if ($object instanceof Page) {
			$querystring = 'SELECT pp_key as "key", pp_value as "value" FROM PageProperty WHERE pp_page = :id';
			$id = $object->getId();
			$keycolumn = 'pp_key';
		}
		elseif ($object instanceof Widget) {
			$querystring = 'SELECT wop_key as "key", wop_value as "value" FROM WidgetObjectProperty WHERE wop_object = :id';
			$id = $object->getId();
			$keycolumn = 'wop_key';
		}
		elseif ($object instanceof Style) {
			$querystring = 'SELECT stp_key as "key", stp_value as "value" FROM StyleProperty WHERE stp_object = :id';
			$id = $object->getObjectId();
			$keycolumn = 'stp_key';
		}
		else {
			$typ = gettype($object);
			if ($typ == 'object') {
				$typ = get_class($object);
			}
			throw new ArtphoxException('ERR_VAR_WRONG_TYPE', array('$object', 'Page/Widget/Style', $typ));
		}

		//--------Building Where Clauses--------

		if (isset($propertynames)) {
			if (!is_array($propertynames)) {
				$propertynames = array($propertynames);
			} else {
				if (count($propertynames) == 0) return false;
			}
			$querystring .= ' AND '.$keycolumn.' IN (';
			$firstloop = true;
			foreach ($propertynames as $propname) {
				//Propertynames, die keine Strings sind, werden ignoriert!
				if (is_string($propname) && !$object->hasLoadedProperty($propname)) {
					$querystring .= (($firstloop)?'':', ').'"'.$propname.'"';
					$firstloop = false;
				}
			}
			$querystring .= ');';
		}
		if ($firstloop) return false;

		//Executing
		$pdo = DataAccess::getPDO();
		$statement = $pdo->prepare($querystring);
		$statement->execute(array(':id' => $id));
		return $statement;
	}

	static function loadWidget($widgetid) {
		$pdo = DataAccess::getPDO();
		$statement = $pdo->prepare('SELECT wt_classname FROM WidgetObject JOIN WidgetType ON wop_type = wt_id WHERE wop_objectid = :widgetid;');
		$statement->execute(array(':widgetid' => $widgetid));
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		if ($result == false) {
			throw new ArtphoxException('ERR_WIDGET_NOT_FOUND', $widgetid);
		}
		$widget = self::createModuleObject ($result['wt_classname'], array('id' => $widgetid));
		if ($widget instanceof Widget) {
			return $widget;
		} else {
			throw new ArtphoxException('ERR_MODULE_WRONG_TYPE', array('Widget', $result['wt_classname']));
		}
	}

	static function loadSystemProperties($keys, &$systemproperties) {
		if (!is_array($keys)) {
			$keys = array($keys);
		}
		if (count($keys) == 0) return false;
		$pdo = DataAccess::getPDO();
		$sql = 'SELECT sp_key, sp_value FROM SystemProperty WHERE sp_key IN (';
		$keykeys = array();
		$itemcount = 0;
		foreach ($keys as $keykey => $keyvalue) {
			if (!array_key_exists($keykey, $systemproperties)) {
				$sql .= ':'.$keykey.', ';
				$keykeys[':'.$keykey] = $keyvalue;
				$itemcount++;
			}
		}
		if ($itemcount == 0) return false;
		$sql .= 'null);';
		$statement = $pdo->prepare($sql);
		$statement->execute($keykeys);
		return $statement;
	}

	static function loadLanguageTexts($keys, &$langitems) {
		$lang = FrontendManager::getSystemProperty('Language');
		if ($lang === false) {
			throw new ArtphoxException('ERR_NO_LANG');
		}
		$keykeys = array(':lang' => $lang);
		if (!is_array($keys)) {
			$keys = array($keys);
		}
		if (count($keys) == 0) return false;
		$sql = 'SELECT lait_code, lait_text FROM LangItem WHERE lait_lang = :lang AND lait_code IN (';
		$itemcount = 0;
		foreach ($keys as $keykey => $keyvalue) {
			if (!array_key_exists($keyvalue, $langitems)) {
				if ($itemcount != 0) {
					$sql .= ', ';
				}
				$temp = ':'.$keykey;
				$sql .= $temp;
				$keykeys[$temp] = $keyvalue;
				$itemcount++;
			}
		}
		if ($itemcount == 0) return false;
		$sql .= ');';
		$pdo = DataAccess::getPDO();
		$statement = $pdo->prepare($sql);
		$statement->execute($keykeys);
		return $statement;
	}

	static function loadWidgetCollectionItems($wcid) {
		//Items abfragen
		$widgets = array();
		$pdo = DataAccess::getPDO();
		$statement = $pdo->prepare(
		   'SELECT wop_objectid, wt_classname 
			FROM WidgetCollectionItem 
			JOIN WidgetObject ON wci_widgetid = wop_objectid 
			JOIN WidgetType ON wop_type = wt_id
			WHERE wci_collection = :collection;');
		$statement->execute(array(':collection' => $wcid));
		while ($widgetresult = $statement->fetch(PDO::FETCH_ASSOC)) {
			$widget = self::createModuleObject($widgetresult['wt_classname'], array('id' => $widgetresult['wop_objectid']));
			$widgets[$widget->getId()] = $widget;
		}
		return $widgets;
	}
}

?>