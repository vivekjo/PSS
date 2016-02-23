<?php
	include_once '../core/DaybookReportManager.php';
	include_once '../vo/DaybookVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$daybookManager = new DaybookReportManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "getDaybook"){
		$date = $_POST['date'];
		$responseXML = $daybookManager->getDaybook($date);
	}else if($action == "getDetailedDaybook"){
		$date = $_POST['date'];
		$responseXML = $daybookManager->getDetailedDaybook($date);
	}
	
	echo $responseXML;
?>