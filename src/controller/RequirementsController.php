<?php

	include_once '../vo/RequirementsVO.php'; 
	include_once '../vo/RequirementdetailsVO.php'; 
	include_once '../core/RequirementsManager.php';
	include_once '../util/XMLBuilder.php';

	$action = $_POST['action'];

	$requirementsManager = new RequirementsManager();
	$xmlBuilder = new XMLBuilder();

	$responseXML = null;
	header('Content-Type: text/xml');
	
	
	if($action == "getAllRequirements"){
		$requirementsList = $requirementsManager->getAllRequirements();
		$responseXML = $xmlBuilder->getRequirementsListAsXML();
	}else if($action == "add"){
		//$requirementsId = $_POST['requirementsid'];
		$date = $_POST['date'];
		$employeeId = $_POST['employeeid'];
		$jsonProducts = $_POST['jsonProducts'];
		$decodedJson = json_decode($jsonProducts);
		$totalProducts = count($decodedJson->root->requirements);
		$requirementsProductsList = new CU_Collection('RequirementdetailsVO');
				    
	    for($i=0; $i<$totalProducts; $i++){
	    	$requirementsdetailsVO = new RequirementdetailsVO();
	    	
	    	$requirementsdetailsVO->setGroupId($decodedJson->root->requirements[$i]->groupid);
	    	$requirementsdetailsVO->setItemId($decodedJson->root->requirements[$i]->itemid);
	    	$requirementsdetailsVO->setSubItemId($decodedJson->root->requirements[$i]->subitemid);
	    	$requirementsdetailsVO->setGms($decodedJson->root->requirements[$i]->gms);
	    	$requirementsdetailsVO->setPcs($decodedJson->root->requirements[$i]->pcs);
	    	$requirementsdetailsVO->setSize($decodedJson->root->requirements[$i]->size);
	    	$requirementsdetailsVO->setMc($decodedJson->root->requirements[$i]->mc);
	    	$requirementsdetailsVO->setStone($decodedJson->root->requirements[$i]->stone);
	    	$requirementsdetailsVO->setTotalAmount($decodedJson->root->requirements[$i]->totalAmount);
	    	$requirementsdetailsVO->setNoOfDays($decodedJson->root->requirements[$i]->noOfDays);
	    	
	    	$requirementsdetailsVO->setDescription($decodedJson->root->requirements[$i]->description);
	    	
			$requirementsProductsList->add($requirementsdetailsVO);			 	
	    }
	    
		$requirementsVO = new RequirementsVO();
		$requirementsVO->setDate($date);
		$requirementsVO->setEmployeeId($employeeId);
		//$requirementsVO->setBillno($billno);
		$requirementsVO->setRequirementsDetailsList($requirementsProductsList);
		try{
			$returnRequirementsVO = null;
			$returnRequirementsVO = $requirementsManager->addrequirementsVO($requirementsVO);
			$responseXML = $xmlBuilder->getrequirementsVOAsXML($returnRequirementsVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "getRequirements"){
		$txnid = $_POST['txnid'];
		try{
			$requirementsVO = $requirementsManager->getRequirements($txnid);
			if($requirementsVO != null){
				$responseXML = $xmlBuilder->getRequirementsVOAsXML($requirementsVO);
			}else{
				$responseXML = $xmlBuilder->buildErrorXML("No Matching Requirements Entry found.");
			}
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnId = $_POST['txnid'];
		try{
			$response = $requirementsManager->deleteRequirementsVO($txnId);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	
	echo $responseXML;
	 
?>