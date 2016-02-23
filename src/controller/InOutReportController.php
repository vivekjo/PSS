<?php
	include_once '../core/InOutReportManager.php';
	include_once '../vo/InoutentryVO.php';
	include_once '../../src/3putils/Collection.php'; 
	include_once '../../src/util/XMLBuilder.php'; 

	session_start();
	
	$action = $_POST['action'];
	$inoutReportManager = new InOutReportManager();
	$xmlBuilder = new XMLBuilder();
	
	if($action == "inouttransactions"){
		$inoutentryVOList = null;
		$queryString1 = $_POST['query1'];	
		$queryString2 = $_POST['query2'];	
		
		$inoutentryVOList = $inoutReportManager->getinoutentryReport($queryString1,$queryString2);
		
		$issuerName = $_POST['hiddenIssuerName'];
		$fromdate = $_POST['fromdate'];
		$todate = $_POST['todate'];
		$bearerName = $_POST['hiddenBearerName'];
		$receiverName = $_POST['hiddenReceiverName'];
		$locationName = $_POST['hiddenLocationName'];
		$typeMode = $_POST['hiddenTypeMode'];
		
		$reportDetails = array();
		$reportDetails['issuerName'] = $issuerName;
		$reportDetails['fromdate'] = $fromdate;
		$reportDetails['todate'] = $todate;
		$reportDetails['bearerName'] = $bearerName;
		$reportDetails['receiverName'] = $receiverName;
		$reportDetails['locationName'] = $locationName;
		$reportDetails['typeMode'] = $typeMode;
		
		$_SESSION['reportDetailsArray'] = $reportDetails;
		$_SESSION['inoutentrylist'] = $inoutentryVOList;
		
		$redirectString = "/PSS/ui/inoutreportdetails.php";
	}else if($action == "inoutinventory"){
		$selecteddate = $_POST['selecteddate'];
		$inoutReportManager->getinoutInventoryReport($selecteddate);
		$reportDetails = array();
		$reportDetails['selecteddate'] = $xmlBuilder->getFormattedDateString($selecteddate,"d/m/Y");
		$_SESSION['reportDetailsArray'] = $reportDetails;
		$redirectString = "/PSS/ui/inoutinventoryreport.php";
	}
	
 	header('Location:' .$redirectString);
?>