<?php
	
	include_once '../core/InOutManager.php';
	include_once '../vo/InoutentryVO.php';
	include_once '../vo/InoutdetailsVO.php';
	include_once '../3putils/Collection.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$inOutManager = new InOutManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "add"){
		$issuerId = $_POST['issuerid'];
		$bearerId = $_POST['bearerid'];
		$receiverId = $_POST['receiverid'];
		$locationId = $_POST['locationid'];
		$type = $_POST['type'];
		
		$jsonProducts = $_POST['jsonProducts'];
		$decodedJson = json_decode($jsonProducts);
		$totalProducts = count($decodedJson->root->inout);
		$inoutProductsList = new CU_Collection('InoutdetailsVO');
				    
	    for($i=0; $i<$totalProducts; $i++){
	    	$inoutdetailsVO = new InoutdetailsVO();
	    	
	    	$inoutdetailsVO->setGroupId($decodedJson->root->inout[$i]->groupid);
	    	$inoutdetailsVO->setItemId($decodedJson->root->inout[$i]->itemid);
	    	$inoutdetailsVO->setSubItemId($decodedJson->root->inout[$i]->subitemid);
	    	$inoutdetailsVO->setPcs($decodedJson->root->inout[$i]->pcs);
	    	$inoutdetailsVO->setGwt($decodedJson->root->inout[$i]->gwt);
	    	$inoutdetailsVO->setNwt($decodedJson->root->inout[$i]->nwt);
	    	$inoutdetailsVO->setCtpure($decodedJson->root->inout[$i]->ct);
	    	$inoutdetailsVO->setAmount($decodedJson->root->inout[$i]->amount);
			$inoutProductsList->add($inoutdetailsVO);			 	
	    }
	    
		$inoutVO = new InoutentryVO();
		$inoutVO->setIssuerId($issuerId);
		$inoutVO->setBearerId($bearerId);
		$inoutVO->setReceiverId($receiverId);
		$inoutVO->setLocationId($locationId);
		$inoutVO->setType($type);
		$inoutVO->setInoutDetailsList($inoutProductsList);
		try{
			$inoutVO = $inOutManager->addInOut($inoutVO);
			$responseXML = $xmlBuilder->buildResponse("1");
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getInOut"){
		$inoutId = $_POST['inoutno'];
		try{
			$inoutVO = $inOutManager->getInout($inoutId);
			if($inoutVO != null){
				$responseXML = $xmlBuilder->getInoutVOAsXML($inoutVO);
			}else{
				$responseXML = $xmlBuilder->buildErrorXML("No Matching Inout Entry found.");
			}
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnId = $_POST['txnid'];
		try{
			$response = $inOutManager->deleteInout($txnId);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>