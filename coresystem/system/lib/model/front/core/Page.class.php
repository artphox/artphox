<?php
namespace lib\model\front\core;

class Page extends Module {

	protected $id;
	protected $displaytitle;
	protected $admintitle;
	protected $order;
	protected $configname;
	protected $extra;
	
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

	function getExtraInfo() {
		return $this->extra;
	}

	function getDefaultCode() {
		$classname = $this->getConfigName();
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
		$display = new $classname();
		if (! ($display instanceof DefaultPageDisplay)) {
			throw new ArtphoxException('ERR_MODULE_WRONG_TYPE', array('DefaultPageDisplay', $classname));
		}
		return $display->printDefaultCode($this);
	}
}

?>