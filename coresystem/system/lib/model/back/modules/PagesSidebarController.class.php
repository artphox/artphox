<?php
namespace lib\model\back\modules;

use lib\model\back\core\SidebarController;
use lib\model\back\core\SidebarTree;
use lib\universal\DataAccess;
use \PDO as PDO;

class PagesSidebarController extends SidebarController {

	//Should return a SideBarTree
	function createSidebarTree() {
		$tree = new SidebarTree();
		$pdo = DataAccess::getPDO();
		$tree->addType('page', true, true, true, false, 'imgs/page.jpg');
		try {
			$stmt = $pdo->query('SELECT p_id, p_admintitle FROM page WHERE p_parent IS NULL ORDER BY p_order;');
			while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$tree->addElement('page', $result['p_id'], $result['p_admintitle']);
			}
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
		return $tree;
	}

	function onClick($elementid) {
		$pdo = DataAccess::getPDO();
		$str = '';
		try {
			$stmt = $pdo->prepare('SELECT p_admintitle, p_displaytitle, pt_title FROM Page JOIN PageType ON p_type = pt_id WHERE p_id = :id;');
			$stmt->execute(array(':id' => $elementid));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($result) {
				$str .= '<div><b>Admintitle: </b>'.$result['p_admintitle'].'</div><div><b>Displaytitle: </b>'.$result['p_displaytitle'].'</div><div><b>Typ: </b>'.$result['pt_title'].'</div>';
			}
			return array('stage', $str);
		} catch (PDOException $e) {
			throw new ArtphoxException('ERR_DB_PDO_EX', $e->getMessage());
		}
		return array('error', '--');
	}

	//0 = denie, 1 = ok, 2 = reload
	function onDrag($elementid, $oldposition, $newposition) {

	}

	//0 = denie, 1 = ok, 2 = reload
	function onRename($elementid, $oldtitle, $newtitle) {

	}

	//0 = denie, 1 = ok
	function onToggleButtonClicked($elementid, $state) {

	}

}


?>