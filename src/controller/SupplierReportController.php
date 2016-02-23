<?php
	
	include_once '../vo/SupplierVO.php';	
	include_once '../vo/PaymentTypeVO.php';
	include_once '../3putils/Collection.php'; 
	include_once '../core/PaymentScheduleManager.php';
	include_once '../core/SupplierManager.php';
	
	session_start();
	
	$action = $_POST['action'];
	
	$supplierBalanceList = null;
	
	$paymentScheduleManager = new PaymentScheduleManager();
	$supplierManager = new SupplierManager();
	$redirectStr = null;
	
	if($action == "getAllSuppliersBalance"){
		$date = $_POST['paydate'];
		$suppliersList = $supplierManager->getAllSuppliers();
		$supplierBalanceList = $paymentScheduleManager->getAllSuppliersBalanceForDate($date);
		$supplierPaymentList = $paymentScheduleManager->getAllSuppliersPaymentForDate($date);
		
		$reportDetailsArray = Array();
		$reportDetailsArray['date'] = $date;
		$_SESSION['reportDetailsArray'] = $reportDetailsArray;
		$_SESSION['suppliersList'] = $suppliersList;
		$_SESSION['supplierBalanceList'] = $supplierBalanceList;
		$_SESSION['supplierPaymentList'] = $supplierPaymentList;
		$redirectStr = "/PSS/ui/supplierpaymentreportdetails.php";
	}else if($action == "getOverdueSuppliers"){
		$date = $_POST['paydate'];
		$suppliersList = $supplierManager->getAllSuppliers();
		$supplierBalanceList = $paymentScheduleManager->getAllSuppliersBalanceForDate($date);
		$supplierPaymentList = $paymentScheduleManager->getAllSuppliersPaymentForDate($date);
		$supplierLastPaymentDateList = $paymentScheduleManager->getSuppliersLastPaymentDates();
		
		$reportDetailsArray = Array();
		$reportDetailsArray['date'] = $date;
		$_SESSION['reportDetailsArray'] = $reportDetailsArray;
		$_SESSION['suppliersList'] = $suppliersList;
		$_SESSION['supplierBalanceList'] = $supplierBalanceList;
		$_SESSION['supplierPaymentList'] = $supplierPaymentList;
		$redirectStr = "/PSS/ui/supplieroverduereportdetails.php";
	}else if($action == "getSuppliersTransactions"){
		$fromdate = $_POST['txnfromdate'];
		$todate = $_POST['txntodate'];
		$supplierId = $_POST['supplierid'];
		
		$reportDetailsArray = Array();
		$reportDetailsArray['fromdate'] = $fromdate;
		$reportDetailsArray['todate'] = $todate;
		$reportDetailsArray['supplierid'] = $supplierId;
		$_SESSION['reportDetailsArray'] = $reportDetailsArray;
		
		$paymentScheduleManager->getSupplierTransactionsForDate($supplierId,$fromdate,$todate);
		
		$redirectStr = "/PSS/ui/suppliertxnreportdetails.php";
	}
	
	header('Location:' . $redirectStr);
?>