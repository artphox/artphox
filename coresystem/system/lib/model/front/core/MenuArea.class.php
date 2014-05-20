<?php
namespace lib\model\front\core;

use lib\universal\ArtphoxException;

class MenuArea {

	private $name;
	private $identifier;
	private $deepness;
	private $title;

	private $items;

	function __construct($name, $identifier, $deepness, $title=null) {
		$this->name = $name;
		$this->identifier = $identifier;
		$this->deepness = $deepness;
		$this->title = $title;
		$this->items = array();
	}

	function getName() {
		return $this->name;
	}

	function getIdentifier() {
		return $this->identifier;
	}

	function getDeepness() {
		return $this->deepness;
	}

	function addItem($item) {
		if (is_string($item)) {
			$this->items[] = $item;
		}
		else {
			$typ = gettype($item);
			if ($typ == 'object') {
				$typ = get_class($item);
			}
			throw new ArtphoxException('ERR_VAR_WRONG_TYPE', array('$item', 'string', $typ));
		}
	}

	function createSubMenu($title) {
		if ($this->deepness <= 1) {
			return null;
		}
		if (is_string($title)) {
			$new = new MenuArea($title, null, $this->deepness-1, $title);
			$this->items[] = $new;
			return $new;
		}
		else {
			$typ = gettype($title);
			if ($typ == 'object') {
				$typ = get_class($title);
			}
			throw new ArtphoxException('ERR_VAR_WRONG_TYPE', array('$title', 'string', $typ));
		}
	}

	function getCode() {
		if (isset($this->title)) $result = $this->title;
		else $result = '';
		$result .= '<ul>';
		foreach ($this->items as $item) {
			if (is_string($item)) {
				$result .= '<li>'.$item.'</li>';
			} else if ($item instanceof MenuArea) {
				$result .= '<li>';
				$result .= $item->getCode();
				$result .= '</li>';
			}
		}
		$result .= '</ul>';
		return $result;
	}
}

?>