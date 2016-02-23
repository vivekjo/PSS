<?php
	include_once '../core/TransferManager.php';
	include_once '../vo/TransferVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$transferManager = new TransferManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "add"){
		$date = $_POST['date'];
		$supplierId = $_POST['supplierid'];
		$fromType = $_POST['fromtype'];
		$fromAmount = $_POST['fromamount'];
		$toType = $_POST['totype'];
		$toAmount = $_POST['toamount'];
		$description = $_POST['description'];
	
		$transferVO = new TransferVO();
		$transferVO->setDate($date);
		$transferVO->setSupplierId($supplierId);
		$transferVO->setFromType($fromType);
		$transferVO->setFromAmount($fromAmount);
		$transferVO->setToType($toType);
		$transferVO->setToAmount($toAmount);
		$transferVO->setDescription($description);
		try{
			$response = $transferManager->addTransfer($transferVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "GetAllTransfers"){
		try{
			$transfersList = $transferManager->getAllTransfers();
			$responseXML = $xmlBuilder->getTransfersListAsXML($transfersList);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getTransfersById"){
		$txnId = $_POST['txnid'];
		try{
			$transferVO = $transferManager->getTransfersById($txnId);
			$responseXML = $xmlBuilder->getTransferVOAsXML($transferVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getDaywiseTransfers"){
		$date = $_POST['date'];
		try{
			$transfersList = $transferManager->getDaywiseTransfers($date);
			$responseXML = $xmlBuilder->getTransfersListAsXML($transfersList);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnId = $_POST['txnid'];
		$supplierId = $_POST['supplierid'];
		$fromType = $_POST['fromtype'];
		$fromAmount = $_POST['fromamount'];
		$toType = $_POST['totype'];
		$toAmount = $_POST['toamount'];
	
		$transferVO = new TransferVO();
		$transferVO->setTxnId($txnId);
		$transferVO->setSupplierId($supplierId);
		$transferVO->setFromType($fromType);
		$transferVO->setFromAmount($fromAmount);
		$transferVO->setToType($toType);
		$transferVO->setToAmount($toAmount);
		try{
			$response = $transferManager->deleteTransfers($transferVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>