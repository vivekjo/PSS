<?php

	include_once '../vo/NewarrivalVO.php';
	include_once '../core/NewarrivalManager.php';
	include_once '../vo/NewarrivaldetailsVO.php';
	include_once '../util/XMLBuilder.php';

	$action = $_POST['action'];

	$newarrivalManager = new NewarrivalManager();
	$xmlBuilder = new XMLBuilder();

	$responseXML = null;
	header('Content-Type: text/xml');

	if($action == "getAllNewarrivals"){
		$newarrivalsList = $newarrivalManager->getAllNewarrivals();
		$responseXML = $xmlBuilder->getNewarrivalsListAsXML();
	}else if($action == "add"){
		//$newarrivalId = $_POST['newarrivalid'];
		$date = $_POST['date'];
		$supplierId = $_POST['supplierid'];
		$jsonProducts = $_POST['jsonProducts'];
		$decodedJson = json_decode($jsonProducts);
		$totalProducts = count($decodedJson->root->newarrival);
		$newarrivalProductsList = new CU_Collection('NewarrivaldetailsVO');
				    
	    for($i=0; $i<$totalProducts; $i++){
	    	$newarrivaldetailsVO = new NewarrivaldetailsVO();
	    	
	    	$newarrivaldetailsVO->setGroupId($decodedJson->root->newarrival[$i]->groupid);
	    	$newarrivaldetailsVO->setItemId($decodedJson->root->newarrival[$i]->itemid);
	    	$newarrivaldetailsVO->setSubItemId($decodedJson->root->newarrival[$i]->subitemid);
	    	$newarrivaldetailsVO->setGms($decodedJson->root->newarrival[$i]->gms);
	    	$newarrivaldetailsVO->setPcs($decodedJson->root->newarrival[$i]->pcs);
	    	$newarrivaldetailsVO->setSize($decodedJson->root->newarrival[$i]->size);
	    	$newarrivaldetailsVO->setMc($decodedJson->root->newarrival[$i]->mc);
	    	$newarrivaldetailsVO->setStone($decodedJson->root->newarrival[$i]->stone);
	    	$newarrivaldetailsVO->setTotalAmount($decodedJson->root->newarrival[$i]->totalAmount);
	    	$newarrivaldetailsVO->setNoOfDays($decodedJson->root->newarrival[$i]->noOfDays);
	    	
	    	$newarrivaldetailsVO->setDescription($decodedJson->root->newarrival[$i]->description);
	    	
			$newarrivalProductsList->add($newarrivaldetailsVO);			 	
	    }
	    
		$newarrivalVO = new newarrivalVO();
		$newarrivalVO->setDate($date);
		$newarrivalVO->setSupplierId($supplierId);
		//$newarrivalVO->setBillno($billno);
		$newarrivalVO->setnewarrivalDetailsList($newarrivalProductsList);
		try{
			$returnNewarrivalVO = null;
			$returnNewarrivalVO = $newarrivalManager->addnewarrivalVO($newarrivalVO);
			$responseXML = $xmlBuilder->getnewarrivalVOAsXML($returnNewarrivalVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getNewarrival"){
		$txnid = $_POST['txnid'];
		try{
			$newarrivalVO = $newarrivalManager->getNewarrival($txnid);
			if($newarrivalVO != null){
				$responseXML = $xmlBuilder->getNewarrivalVOAsXML($newarrivalVO);
			}else{
				$responseXML = $xmlBuilder->buildErrorXML("No Matching NewArrival Entry found.");
			}
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnId = $_POST['txnid'];
		try{
			$newarrivalVO = $newarrivalManager->deleteNewarrivalVO($txnId);
			$responseXML = $xmlBuilder->buildResponse($newarrivalVO);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	
	echo $responseXML;
	
	
	

	
?>