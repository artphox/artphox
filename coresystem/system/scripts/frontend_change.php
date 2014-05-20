<?php

error_reporting(E_ALL);

require 'globalinit.php';

use lib\manager\FrontendManager;
use lib\universal\ArtphoxException;


//XML oder JSON ???  ----------------------------------------------------

	$type = 'xml';
	if (isset($_POST['type']) && strtolower($_POST['type']) == 'json') {
		$type = 'json';
		header('Content-type: application/json');
	} else {
		header('Content-type: text/xml');
	}

	function printError($xml, $ce) {
		try {
			$smarty = FrontendManager::createSmarty();
			$smarty->assign('error', strval($ce));
			$xml->addChild('error', $smarty->fetch(ERROR_TPL_PAGE));
		} catch (Exception $ex2) {
			$xml->addChild('error', strval($ce));
		}
	}

//XML-Result abfragen  -----------------------------

	if (isset($_POST['state'])) {
		$slug = $_POST['state'];
		$xml = new SimpleXMLElement('<page></page>');
		try {
			FrontendManager::loadSite($slug);
			$page = FrontendManager::getPage();
			$xml->addChild('code', utf8_encode(FrontendManager::getPageCode()));
			$xml->addChild('title', utf8_encode($page->getDisplayTitle()));
		} catch (ArtphoxException $e) {
			printError($xml, $e);
		} catch (Exception $e) {
			$ce = new ArtphoxException('DEFAULT', array(get_class($e), $e->getMessage()));
			printError($xml, $ce);
		}
	}
	else {
		$xml = new SimpleXMLElement('<page></page>');
		$e = new ArtphoxException('ERR_SN_NOT_RECEIVED');
		printError($xml, $e);
	}


//Ausgeben	-------------------------------------------------------------

	if ($type == 'json') {
		echo json_encode($xml);
	}
	else {
		echo $xml->asXML();
	}


?>