<?php
	include_once '../core/PaymentScheduleManager.php';
	include_once '../vo/DaybookVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$paymentScheduleManager = new PaymentScheduleManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "getPaymentSchedule"){
		$fromdate = $_POST['fromdate'];
		$todate = $_POST['todate'];
		$supplierid = $_POST['supplierid'];
		$responseXML = $paymentScheduleManager->getPaymentSchedule($fromdate,$todate,$supplierid);
	}else if($action == "getSupplierBalance"){
		$date = $_POST['date'];
		$supplierId = $_POST['supplierid'];
		$responseXML = $paymentScheduleManager->getSupplierBalanceForDate($supplierId,$date);
	} 
	
	echo $responseXML;
?>