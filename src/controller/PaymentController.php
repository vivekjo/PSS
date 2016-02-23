<?php
	include_once '../core/PaymentManager.php';
	include_once '../vo/PaymentVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$paymentManager = new PaymentManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "add"){
		$date = $_POST['date'];
		$supplierId = $_POST['supplierid'];
		//$voucherNo = $_POST['voucherno'];
		$paymentMode = $_POST['paymentmode'];
		$adjustWith = $_POST['adjustwith'];
		$amount = $_POST['amount'];
		$description = $_POST['description'];
	
		$paymentVO = new PaymentVO();
		$paymentVO->setDate($date);
		$paymentVO->setSupplierId($supplierId);
		//$paymentVO->setVoucherNo($voucherNo);
		$paymentVO->setPaymentMode($paymentMode);
		$paymentVO->setAdjustWith($adjustWith);
		$paymentVO->setAmount($amount);
		$paymentVO->setDescription($description);
		try{
			$paymentVO = $paymentManager->addPayment($paymentVO);
			$responseXML = $xmlBuilder->getPaymentVOAsXML($paymentVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$txnId = $_POST['txnid'];
		$date = $_POST['date'];
		$supplierId = $_POST['supplierid'];
		$voucherNo = $_POST['voucherno'];
		$paymentMode = $_POST['paymentmode'];
		$adjustWith = $_POST['adjustwith'];
		$amount = $_POST['amount'];
		$description = $_POST['description'];
	
		$paymentVO = new PaymentVO();
		$paymentVO->setTxnId($txnId);
		$paymentVO->setDate($date);
		$paymentVO->setSupplierId($supplierId);
		$paymentVO->setVoucherNo($voucherNo);
		$paymentVO->setPaymentMode($paymentMode);
		$paymentVO->setAdjustWith($adjustWith);
		$paymentVO->setAmount($amount);
		$paymentVO->setDescription($description);
		try{
			$paymentVO = $paymentManager->modifyPayment($paymentVO);
			$responseXML = $xmlBuilder->getPaymentVOAsXML($paymentVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getDaywisePayment"){
		$date = $_POST['date'];
		try{
			$paymentList = $paymentManager->getDaywisePayment($date);
			$responseXML = $xmlBuilder->getPaymentListAsXML($paymentList);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getPaymentById"){
		$txnId = $_POST['txnid'];
		try{
			$paymentVO = $paymentManager->getPaymentById($txnId);
			$responseXML = $xmlBuilder->getPaymentVOAsXML($paymentVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnId = $_POST['txnid'];
		$supplierId = $_POST['supplierid'];
		$paymentMode = $_POST['paymentmode'];
		$amount = $_POST['amount'];
		$adjustWith = $_POST['adjustwith'];
		
		$paymentVO = new PaymentVO();
		$paymentVO->setTxnId($txnId);
		$paymentVO->setSupplierId($supplierId);
		$paymentVO->setPaymentMode($paymentMode);
		$paymentVO->setAmount($amount);
		$paymentVO->setAdjustWith($adjustWith);
		try{
			$response = $paymentManager->deletePayment($paymentVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "convertMetal"){
		$transferFrom = $_POST['transferfrom'];
		$transferTo = $_POST['transferto'];
		$amount = $_POST['amount'];
		try{
			$response = $paymentManager->convertMetalValue($amount,$transferFrom,$transferTo);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>