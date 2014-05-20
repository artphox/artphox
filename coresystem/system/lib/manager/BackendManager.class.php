<?php
namespace lib\manager;

class BackendManager extends Manager {

	private static $navbar = array();
	private static $sidebar = array();

	static function createSmarty($functions=true) {
		$smarty = new Smarty();
		$smarty->use_include_path = true;
		$smarty->setTemplateDir('tpl/admin');
		$smarty->setCompileDir(get_include_path().'tpl_compile');
		if ($functions) {
			SmartyConnector::assignFunctions($smarty);
		}
		return $smarty;
	}

	static function addNavbarItem($text, $img, $link) {
		self::$navbar[] = array($text, $img, $link);
	}

	static function addSidebarTab($id, $text, $controller) {
		self::$sidebar[$id] = array($text, $controller);
	}

	static function addHiddenSidebarTab($id, $controller) {
		self::$sidebar[$id] = array(null, $controller);
	}

	static function getNavbarCode() {
		$navbar = self::translateNavbar();
		function printNavLayer($navlayer) {
			$str = '<ul>';
			foreach ($navlayer as $navitem) {
				$str .= '<li>';
				if (is_string($navitem[2])) {
					$str .= '<a href="'.$navitem[2].'">';
				}
				if (is_string($navitem[1])) {
					$str .= '<img src="'.$navitem[1].'" alt="">';
				}
				if (is_string($navitem[0])) {
					$str .= $navitem[0];
				}
				if (is_string($navitem[2])) {
					$str .= '</a>';
				}
				if (is_array($navitem[2])) {
					$str .= printNavLayer($navitem[2]);
				}
				$str .= '</li>';
			}
			$str .= '</ul>';
			return $str;
		}
		return printNavLayer($navbar);
	}

	private static function translateNavbar() {
		$codearray = array();
		function collectCodes($navarr, &$codearr) {
			foreach ($navarr as $navitem) {
				$codearr[] = $navitem[0];
				if (is_array($navitem[2])) {
					collectCodes($navitem[2], $codearr);
				}
			}
		}
		collectCodes(self::$navbar, $codearray);
		//Texte werden hier gleichzeitig geladen
		self::loadLanguageTexts($codearray);
		function translate(&$navarr) {
			foreach ($navarr as &$navitem) {
				$translation = Manager::getLanguageText($navitem[0]);
				if ($translation !== false) {
					$navitem[0] = $translation;
				}
				if (is_array($navitem[2])) {
					translate($navitem[2]);
				}
			}
		}
		$translation = self::$navbar;
		translate($translation);
		return $translation;
	}

	static function getSidebarCode() {
		$sidebar = self::translateSidebar();
		echo '<div id="sidebarhead">';
		foreach ($sidebar as $sideitem) {
			echo '<div class="sidebarbutton">'.$sideitem[0].'</div>';
		}
		echo '</div>';
	}

	private static function translateSidebar() {
		$codearray = array();
		foreach (self::$sidebar as $sideitem) {
			if ($sideitem[0] !== null) {
				$codearray[] = $sideitem[0];
			}
		}
		self::loadLanguageTexts($codearray);
		$translationarr = array();
		foreach (self::$sidebar as $sideitem) {
			if ($sideitem[0] !== null) {
				$translation = Manager::getLanguageText($sideitem[0]);
				if ($translation !== false) {
					$sideitem[0] = $translation;
				}
				$translationarr[] = $sideitem;
			}
		}
		return $translationarr;
	}

}

?>