<?php

error_reporting(E_ALL);

require 'globalinit.php';

header('Content-type: application/json');

$xml = new SimpleXmlElement('<response/>');
if (!isset($_POST['command'])) {
	$xml->addChild('error', 'No Command received!');
	echo json_encode($xml);
	return;
}

use lib\manager\BackendController;

$command = $_POST['command'];
if ($command == 'sidebaritemclicked') {
	if (!isset($_POST['tabid']) || !isset($_POST['elid'])) {
		$xml->addChild('error', 'Did not receive Parameters!');
		echo json_encode($xml);
		return;
	}
	BackendController::sideBarItemClicked($xml, $_POST['tabid'], $_POST['elid']);
}
elseif ($command == 'sidebartabchanged') {
	if (!isset($_POST['tabid'])) {
		$xml->addChild('error', 'Did not receive Parameters!');
		echo json_encode($xml);
		return;
	}
	BackendController::sideBarTabChanged($xml, $_POST['tabid']);
}
else {
	$xml->addChild('error', 'Invalid Command!');
}
echo json_encode($xml);
return;
?>