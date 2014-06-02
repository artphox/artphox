<?php
namespace lib\model\front\core;

class Page extends Module {

	protected $id;
	protected $displaytitle;
	protected $admintitle;
	protected $order;
	protected $configname;
	
	function getId() {
		return $this->id;
	}

	function getDisplayTitle() {
		return $this->displaytitle;
	}

	function getOrder() {
		return $this->order;
	}

	function getAdminTitle() {
		return $this->admintitle;
	}

	function getConfigName() {
		return $this->configname;
	}
}

?>