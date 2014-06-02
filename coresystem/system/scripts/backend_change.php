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

use lib\manager\BackendManager;

$command = $_POST['command'];
if ($command == 'sidebaritemclicked') {
	if (!isset($_POST['tabid']) || !isset($_POST['elid'])) {
		$xml->addChild('error', 'Did not receive Parameters!');
		echo json_encode($xml);
		return;
	}
	$need_sidebar = true;
	require 'data/AdminData.php';
	$controller = BackendManager::getSidebarController($_POST['tabid']);
	$result = $controller->onClick($_POST['elid']);
	$xml->addChild($result[0], $result[1]);
	echo json_encode($xml);
	return;
}
$xml->addElement('error', 'Invalid Command!');
echo json_encode($xml);
return;
?>