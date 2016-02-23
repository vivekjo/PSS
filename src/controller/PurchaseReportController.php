<?php
	include_once '../core/PurchaseReportManager.php';
	include_once '../vo/PurchaseVO.php';
	include_once '../../src/3putils/Collection.php'; 

	session_start();
	
	$purchaseVOList = null;
	$queryString1 = $_POST['query1'];	
	$queryString2 = $_POST['query2'];	
	
	$purchaseReportManager = new PurchaseReportManager();
	$purchaseVOList = $purchaseReportManager->getPurchaseReport($queryString1,$queryString2);
	
	$suppliername = $_POST['hiddenSupplierName'];
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$fromvoucherno = $_POST['fromvoucherno'];
	$tovoucherno = $_POST['tovoucherno'];
	$group = $_POST['group'];
	$item = $_POST['item'];
	$subItem = $_POST['subItem'];
	
	$reportDetails = array();
	$reportDetails['suppliername'] = $suppliername;
	$reportDetails['fromdate'] = $fromdate;
	$reportDetails['todate'] = $todate;
	$reportDetails['fromvoucherno'] = $fromvoucherno;
	$reportDetails['tovoucherno'] = $tovoucherno;
	$reportDetails['group'] = $group;
	$reportDetails['item'] = $item;
	$reportDetails['subItem'] = $subItem;
	
	$_SESSION['reportDetailsArray'] = $reportDetails;
	$_SESSION['purchaselist'] = $purchaseVOList;
	
	$redirectString = "/PSS/ui/purchasereportdetails.php";
	
 	header('Location:' .$redirectString);
?>