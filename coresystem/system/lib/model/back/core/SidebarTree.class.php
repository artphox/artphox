<?php
namespace lib\model\back\core;

class SidebarTree {

	private $types = array();
	private $elements = array();

	function addType($id, $deletable, $draggable, $renamable, $folder, $icon, $toggleon=null, $toggleoff=null) {
		$this->types[$id] = array('deletable' => $deletable, 'draggable' => $draggable, 'renamable' => $renamable, 'folder' => $folder, 'icon' => $icon, 'toggleon' => $toggleon, 'toggleoff' => $toggleoff);
	}

	function addElement($type, $id, $text, $parentid=null, $toggled=false) {
		if ($parentid == null) {
			$this->elements[] = array('type' => $type, 'id' => $id, 'text' => $text, 'toggled' => $toggled);
		}
		else {
			$val = $this->rekAddChild($this->elements, $type, $id, $text, $parentid, $toggled);
			//if val = false, log...
		}
	}

	//Rekursive Funktion zum Durchsuchen des Baumes nach dem Parent des hinzuzufügenden Elementes
	private function rekAddChild(&$arr, $type, $id, $text, $parentid, $toggled) {
		for ($i = 0; $i < count($arr); $i++) {
			if ($arr[$i]['id'] == $parentid) {
				if (!isset($arr[$i]['elementdata'])) {
					$arr[$i]['elementdata'] = array();
				}
				$arr[$i]['elementdata'][] = array('type' => $type, 'id' => $id, 'text' => $text, 'toggled' => $toggled);
				return true;
			}
			else if (isset($arr[$i]['elementdata'])) {
				if (rekAddChild($arr[$i]['elementdata'], $type, $id, $text, $parentid, $toggled) === true) {
					return true;
				}
			}
			return false;
		}
	}

	function getContent() {
		$str = '{ types: ';
		$str .= json_encode($this->types);
		$str .= ', elementdata: ';
		$str .= json_encode($this->elements);
		$str .= '}';
		return $str;
	}
}



?>