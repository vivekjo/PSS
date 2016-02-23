<?php
	include_once '../core/PurchasePlannerManager.php';
	include_once '../vo/DaybookVO.php';
	include_once '../util/XMLBuilder.php';
	
	session_start();
	
	$action = $_POST['action'];
	$type = $_POST['type'];
	
	$purchasePlannerManager = new PurchasePlannerManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	
	if($action == "getPurchasePlanner"){
		$fromdate = $_POST['fromdate'];
		$todate = $_POST['todate'];
		$purchasePlannerManager->getPurchasePlanner($fromdate,$todate);
		
		$reportDetails = array();
		$reportDetails['fromdate'] = $xmlBuilder->getFormattedDate($fromdate);
		$reportDetails['todate'] = $xmlBuilder->getFormattedDate($todate);
		
		$_SESSION['reportDetails'] = $reportDetails;
	}
	
	if($type == "consolidated"){
		$redirectString = "../../ui/conspurchaseplannernew.php";
	}else if($type == "detailed"){
		$redirectString = "../../ui/detailedpurchaseplanner.php";
	}
	
	header('Location:' . $redirectString);
?>