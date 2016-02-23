<?php
	include_once '../core/DaybookManager.php';
	include_once '../vo/DaybookVO.php';
	include_once '../3putils/Collection.php'; 
	
	session_start();
	
	$queryString = $_POST['query'];
	
	$daybookManager = new DaybookManager();
	
	$accountsList = $daybookManager->getAccountsByQuery($queryString);
	
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$type = $_POST['type'];
	$channelId = $_POST['channel'];
	$accheadId = "ALL";
	if(isset($_POST['accounthead']))
		$accheadId = $_POST['accounthead'];
	
		$mode = $_POST['mode'];
	
	$reportDetails = array();
	$reportDetails['fromdate'] = $fromdate;
	$reportDetails['todate'] = $todate;
	$reportDetails['type'] = $type;
	$reportDetails['category'] = $channelId;
	$reportDetails['acchead'] = $accheadId;
	$reportDetails['mode'] = $mode;
	
	$_SESSION['accountsCriteriaList'] = $reportDetails;
	$_SESSION['accountsList'] = $accountsList;
	
	$redirectStr = "/PSS/ui/dailyacsreportdetails.php";
	
	header('Location:' . $redirectStr);
?>