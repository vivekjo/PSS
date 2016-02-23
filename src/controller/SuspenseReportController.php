<?php

	include_once '../core/SuspenseReportManager.php';
	include_once '../vo/SuspenseentryVO.php';
	include_once '../../src/3putils/Collection.php'; 
	

	session_start();
	
	$suspenseentryVOList = null;
	$queryString1 = $_POST['query1'];	
	$queryString2 = $_POST['query2'];	
	
	$suspenseReportManager = new SuspenseReportManager();
	$suspenseentryVOList =  $suspenseReportManager->getSuspenseReport($queryString1,$queryString2);
	 
// 	print_r($suspenseentryVOList);
	
 
	$issuerName = $_POST['hiddenIssuerName'];
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$bearerName = $_POST['hiddenBearerName'];
	$receiverName = $_POST['hiddenReceiverName'];
	$locationName = $_POST['hiddenLocationName'];
	$typeMode = $_POST['hiddenTypeMode'];
	$mode = $_POST['hiddenMode'];
	
	$reportDetails = array();
	$reportDetails['issuerName'] = $issuerName;
	$reportDetails['fromdate'] = $fromdate;
	$reportDetails['todate'] = $todate;
	$reportDetails['bearerName'] = $bearerName;
	$reportDetails['receiverName'] = $receiverName;
	$reportDetails['locationName'] = $locationName;
	$reportDetails['typeMode'] = $typeMode;
	$reportDetails['mode'] = $mode;
	
	$_SESSION['reportDetailsArray'] = $reportDetails;
	$_SESSION['suspenseentrylist'] = $suspenseentryVOList;
	
	$redirectString = "/PSS/ui/suspensereportdetails.php";
	
 	header('Location:' .$redirectString);
?>