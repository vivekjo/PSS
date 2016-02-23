<?php

	include_once '../vo/SuspenseentryVO.php';
	include_once '../core/SuspenseentryManager.php';
	include_once '../util/XMLBuilder.php';

	$action = $_POST['action'];

	$suspenseentryManager = new SuspenseentryManager();
	$xmlBuilder = new XMLBuilder();

	$responseXML = null;
	header('Content-Type: text/xml');

	if($action == "getAllSuspenseentrys"){
		$suspenseentrysList = $suspenseentryManager->getAllSuspenseentrys();
		$responseXML = $xmlBuilder->getSuspenseentrysListAsXML();
	}else if($action == "getSuspense"){
		$suspenseno = $_POST['suspenseno'];
		$suspenseentryVO = $suspenseentryManager->getSuspenseentryVO($suspenseno);
		if($suspenseentryVO != null){
			$responseXML = $xmlBuilder->getSuspenseVOAsXML($suspenseentryVO);
		}else{
			$responseXML = $xmlBuilder->buildErrorXML("No Matching Suspense Entry Found");
		}
		
	}else if($action == "getSuspenseReturn"){
		$suspenseno = $_POST['suspenseno'];
		try{
			$suspenseentryVO = $suspenseentryManager->getSuspenseReturn($suspenseno);
			if($suspenseentryVO != null){
				$responseXML = $xmlBuilder->getSuspenseVOAsXML($suspenseentryVO);
			}else{
				$responseXML = $xmlBuilder->buildErrorXML("No Matching Suspense Entry Found");
			}
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
		
	}else if($action == "closeSuspense"){
		try{
			$response = $suspenseentryManager->closeSuspense();
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
		
	}else if($action == "add"){
		date_default_timezone_set('Asia/Calcutta');
		
		$hour = date("H");
		$mins = date("i");
		
		if($hour > "21" || ($hour == "21" &&  $mins > "30")){
			$responseXML = $xmlBuilder->buildErrorXML("Suspense Entry has been closed for the day at 20:30 Hrs.");
		}else{
			$refSuspenseId = $_POST['refsuspenseid'];
			$issuerId = $_POST['issuerid'];
			$bearerId = $_POST['bearerid'];
			$receiverId = $_POST['receiverid'];
			$locationId = $_POST['locationid'];
			$type = $_POST['type'];
			$mode = $_POST['mode'];
			
			$jsonProducts = $_POST['jsonProducts'];
			$decodedJson = json_decode($jsonProducts);
			$totalProducts = count($decodedJson->root->suspense);
			$suspenseProductsList = new CU_Collection('SuspensedetailsVO');
					    
		    for($i=0; $i<$totalProducts; $i++){
		    	$suspensedetailsVO = new SuspensedetailsVO();
		    	
		    	$suspensedetailsVO->setGroupId($decodedJson->root->suspense[$i]->groupid);
		    	$suspensedetailsVO->setItemId($decodedJson->root->suspense[$i]->itemid);
		    	$suspensedetailsVO->setSubItemId($decodedJson->root->suspense[$i]->subitemid);
		    	$suspensedetailsVO->setPcs($decodedJson->root->suspense[$i]->pcs);
		    	$suspensedetailsVO->setType($decodedJson->root->suspense[$i]->type);
		    	
		    	$suspensedetailsVO->setGwt($decodedJson->root->suspense[$i]->gwt);
		    	$suspensedetailsVO->setNwt($decodedJson->root->suspense[$i]->nwt);
		    	$suspensedetailsVO->setStoneLoss($decodedJson->root->suspense[$i]->stone);
		    	$suspensedetailsVO->setMetalLoss($decodedJson->root->suspense[$i]->metal);
		    	$suspensedetailsVO->setCtpure($decodedJson->root->suspense[$i]->ct);
		    	$suspensedetailsVO->setAmount($decodedJson->root->suspense[$i]->amount);
				$suspenseProductsList->add($suspensedetailsVO);			 	
		    }
			
			$suspenseentryVO = new SuspenseentryVO();
			$suspenseentryVO->setIssuerId($issuerId);
			$suspenseentryVO->setBearerId($bearerId);
			$suspenseentryVO->setReceiverId($receiverId);
			$suspenseentryVO->setLocationId($locationId);
			$suspenseentryVO->setType($type);
			$suspenseentryVO->setMode($mode);
			$suspenseentryVO->setRefSuspenseId($refSuspenseId);
			$suspenseentryVO->setSuspenseDetailList($suspenseProductsList);
			
	//		print_r($suspenseentryVO);
			
			try{
				$suspenseentryVO = $suspenseentryManager->addSuspenseentryVO($suspenseentryVO);
				$responseXML = $xmlBuilder->buildResponse($suspenseentryVO->getSuspenseId());
			}catch(Exception $e){
				$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
			}
		}
	}else if($action == "modify"){
		$suspenseId = $_POST['suspenseid'];
		$date = $_POST['date'];
		$issuerId = $_POST['issuerid'];
		$bearerId = $_POST['bearerid'];
		$receiverId = $_POST['receiverid'];
		$locationId = $_POST['locationid'];
		$type = $_POST['type'];
		$mode = $_POST['mode'];
		$suspenseentryVO = new SuspenseentryVO();
		$suspenseentryVO->setSuspenseId($suspenseId);
		$suspenseentryVO->setDate($date);
		$suspenseentryVO->setIssuerId($issuerId);
		$suspenseentryVO->setBearerId($bearerId);
		$suspenseentryVO->setReceiverId($receiverId);
		$suspenseentryVO->setLocationId($locationId);
		$suspenseentryVO->setType($type);
		$suspenseentryVO->setMode($mode);
		try{
			$responseVO = $suspenseentryManager->modifySuspenseentryVO($suspenseentryVO);
			$responseXML = $xmlBuilder->getSuspenseentryVOAsXML($suspenseentryVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnid = $_POST['txnid'];
		try{
			$response = $suspenseentryManager->deleteSuspenseentryVO($txnid);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getSuspenseBalance"){
		try{
			$paymentTypeVO = $suspenseentryManager->getSuspenseBalance();
			$responseXML = $xmlBuilder->getBalanceAsXML($paymentTypeVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}

	echo $responseXML;
?>