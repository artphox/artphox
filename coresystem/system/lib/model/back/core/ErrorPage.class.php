<?php
namespace lib\model\back\core;

use lib\model\back\core\ACPPage;
use lib\manager\BackendManager;

class ErrorPage extends ACPPage {

	private $error = null;

	function __construct($error) {
		$this->error = $error;
	}

	function getCode() {
		try {
			$smarty = BackendManager::createSmarty();
			$smarty->assign('error', strval($this->error));
			return $smarty->fetch('acperror.tpl');
		} catch (Exception $ex) {
			return strval($ex);
		}
	}
}

?>