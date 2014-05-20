<?php
namespace lib\model\front\core;

use lib\universal\ArtphoxException;

class WidgetArea {

	private $name;
	private $identifier;

	private $widgets;

	function __construct($name, $identifier) {
		$this->name = $name;
		$this->identifier = $identifier;
		$this->widgets = array();
	}

	function getName() {
		return $this->name;
	}

	function getIdentifier() {
		return $this->identifier;
	}

	function addWidget($widget) {
		if ($widget instanceof Widget) {
			$this->widgets[] = $widget;
		}
		else {
			$typ = gettype($widget);
			if ($typ == 'object') {
				$typ = get_class($widget);
			}
			throw new ArtphoxException('ERR_VAR_WRONG_TYPE', array('$widget', 'Widget', $typ));
		}
	}

	function getCode() {
		$result = '<div class="widgetarea" id="widgetarea-'.$this->identifier.'">';
		foreach ($this->widgets as $widget) {
			$result .= '<div class="widgetarea-item">'.$widget->getFrontendCode().'</div>';
		}
		$result .= '</div>';
		return $result;
	}
}

?>