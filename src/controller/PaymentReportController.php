<?php
	include_once '../core/PaymentReportManager.php';
	include_once '../vo/PaymentVO.php';
	
	session_start();
	$paymentVOList = null;
	$queryString = $_POST['query'];	
	
	$paymentReportManager = new PaymentReportManager();

	$paymentVOList = $paymentReportManager->getPaymentReport($queryString);	

	$suppliername = $_POST['hiddenSupplierName'];
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$paymentMode = $_POST['hiddenPaymentMode'];
	$fromvoucherno = $_POST['fromvoucherno'];
	$tovoucherno = $_POST['tovoucherno'];
	
	$reportDetails = array();
	$reportDetails['suppliername'] = $suppliername;
	$reportDetails['fromdate'] = $fromdate;
	$reportDetails['todate'] = $todate;
	$reportDetails['paymentMode'] = $paymentMode;
	$reportDetails['fromvoucherno'] = $fromvoucherno;
	$reportDetails['tovoucherno'] = $tovoucherno;
	
	$_SESSION['reportDetailsArray'] = $reportDetails;
	
	$_SESSION['paymentlist'] = $paymentVOList;
	
	$redirectString = "/PSS/ui/paymentreportdetails.php";
	header('Location:' .$redirectString);
 	
?>