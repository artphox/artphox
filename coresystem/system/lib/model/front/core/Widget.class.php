<?php
namespace lib\model\front\core;

abstract class Widget extends Module {

	protected $id;

	function getId() {
		return $this->id;
	}

	abstract function getFrontendCode();

}

?>