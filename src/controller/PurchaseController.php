<?php
	include_once '../core/PurchaseManager.php';
	include_once '../vo/PurchaseVO.php';
	include_once '../vo/PurchasedetailsVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$purchaseManager = new PurchaseManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "add"){
		$date = $_POST['date'];
		$supplierId = $_POST['supplierid'];
		//$billno = $_POST['billno'];
		$jsonProducts = $_POST['jsonProducts'];
		$decodedJson = json_decode($jsonProducts);
		$totalProducts = count($decodedJson->root->purchase);
		$purchasedProductsList = new CU_Collection('PurchasedetailsVO');
				    
	    for($i=0; $i<$totalProducts; $i++){
	    	$purchasedetailsVO = new PurchasedetailsVO();
	    	
	    	$purchasedetailsVO->setGroupId($decodedJson->root->purchase[$i]->groupid);
	    	$purchasedetailsVO->setItemId($decodedJson->root->purchase[$i]->itemid);
	    	$purchasedetailsVO->setSubItemId($decodedJson->root->purchase[$i]->subitemid);
	    	$purchasedetailsVO->setGwt($decodedJson->root->purchase[$i]->gwt);
	    	$purchasedetailsVO->setNwt($decodedJson->root->purchase[$i]->nwt);
	    	$purchasedetailsVO->setCtpure($decodedJson->root->purchase[$i]->ct);
	    	$purchasedetailsVO->setMaintainMetalAs($decodedJson->root->purchase[$i]->maintainmetalas);
	    	$purchasedetailsVO->setMc($decodedJson->root->purchase[$i]->mc);
	    	$purchasedetailsVO->setMaintainMCAs($decodedJson->root->purchase[$i]->maintainmc);
	    	$purchasedetailsVO->setPaymentDays($decodedJson->root->purchase[$i]->paymentdays);
			$purchasedProductsList->add($purchasedetailsVO);			 	
	    }
	    
		$purchaseVO = new PurchaseVO();
		$purchaseVO->setDate($date);
		$purchaseVO->setSupplierId($supplierId);
		//$purchaseVO->setBillno($billno);
		$purchaseVO->setPurchaseDetailsList($purchasedProductsList);
		try{
			$purchaseVO = $purchaseManager->addPurchase($purchaseVO);
			$responseXML = $xmlBuilder->getPurchaseVOAsXML($purchaseVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getPurchase"){
		$supplierId = $_POST['supplierid'];
		$billno = $_POST['billno'];
		try{
			$purchaseVO = $purchaseManager->getPurchase($supplierId,$billno);
			if($purchaseVO != null){
				$responseXML = $xmlBuilder->getPurchaseVOAsXML($purchaseVO);
			}else{
				$responseXML = $xmlBuilder->buildErrorXML("No Matching Purchase Entry found.");
			}
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnId = $_POST['txnid'];
		$supplierId = $_POST['supplierid'];
		try{
			$response = $purchaseManager->deletePurchase($supplierId,$txnId);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "update"){
		$date = $_POST['date'];
		$jsonProducts = $_POST['jsonProductsforupdate'];
		$decodedJson = json_decode($jsonProducts);
		$totalProducts = count($decodedJson->root->purchase);
		$purchaseProductsList = new CU_Collection('PurchasedetailsVO');
				    
	    for($i=0; $i<$totalProducts; $i++){
	    	$purchasedetailsVO = new PurchasedetailsVO();
	    	
	    	$purchasedetailsVO->setPurchasedetailsId($decodedJson->root->purchase[$i]->purchasedetailsid);
	    	$purchasedetailsVO->setPaymentDays($decodedJson->root->purchase[$i]->paymentdays);
			$purchaseProductsList->add($purchasedetailsVO);			 	
	    }
	    
		//$purchaseVO = new PurchaseVO();
		//$purchaseVO->setPurchaseDetailsList($purchasedProductsList);
		
		try{
			$response = $purchaseManager->updatePurchaseDetailsByPurchaseDetailId($purchaseProductsList,$date);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>