<?php

	include_once '../vo/ProjectionVO.php';
	include_once '../core/ProjectionManager.php';
	include_once '../util/XMLBuilder.php';

	$action = $_POST['action'];

	$projectionManager = new ProjectionManager();
	$xmlBuilder = new XMLBuilder();

	$responseXML = null;
	header('Content-Type: text/xml');

	if($action == "getProjectionByDate"){
		$date = $_POST['date'];
		$projectionList = $projectionManager->getProjectionByDate($date);
		$responseXML = $xmlBuilder->getProjectionListAsXML($projectionList,"PROJECTIONINFO");
	}else if($action == "getProjectionById"){
		$txnId = $_POST['txnid'];
		try{
			$projectionVO = $projectionManager->getProjectionById($txnId);
			$responseXML = $xmlBuilder->getProjectionVOAsXML($projectionVO);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "add"){
		$date = $_POST['date'];
		$type = $_POST['type'];
		$categoryId = $_POST['categoryid'];
		$accheadId = $_POST['accheadid'];
		$pg = $_POST['pg'];
		$lpg = $_POST['lpg'];
		$silver = $_POST['silver'];
		$cash = $_POST['cash'];
		$description = $_POST['description'];
	
		$projectionVO = new ProjectionVO();
		$projectionVO->setDate($date);
		$projectionVO->setType($type);
		$projectionVO->setCategoryId($categoryId);
		$projectionVO->setAccheadId($accheadId);
		$projectionVO->setPg($pg);
		$projectionVO->setLpg($lpg);
		$projectionVO->setSilver($silver);
		$projectionVO->setCash($cash);
		$projectionVO->setDescription($description);
		try{
			$result = $projectionManager->addProjection($projectionVO);
			$responseXML = $xmlBuilder->getProjectionVOAsXML($projectionVO);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$txnId = $_POST['txnid'];
		$date = $_POST['date'];
		$type = $_POST['type'];
		$categoryId = $_POST['categoryid'];
		$accheadId = $_POST['accheadid'];
		$pg = $_POST['pg'];
		$lpg = $_POST['lpg'];
		$silver = $_POST['silver'];
		$cash = $_POST['cash'];
		$description = $_POST['description'];
	
		$projectionVO = new ProjectionVO();
		$projectionVO->setTxnId($txnId);
		$projectionVO->setDate($date);
		$projectionVO->setType($type);
		$projectionVO->setCategoryId($categoryId);
		$projectionVO->setAccheadId($accheadId);
		$projectionVO->setPg($pg);
		$projectionVO->setLpg($lpg);
		$projectionVO->setSilver($silver);
		$projectionVO->setCash($cash);
		$projectionVO->setDescription($description);
		try{
			$response = $projectionManager->modifyProjection($projectionVO);
			$responseXML = $xmlBuilder->getProjectionVOAsXML($projectionVO);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$txnId = $_POST['txnid'];
		$type = $_POST['type'];
		$pg = $_POST['pg'];
		$lpg = $_POST['lpg'];
		$silver = $_POST['silver'];
		$cash = $_POST['cash'];
	
		$projectionVO = new ProjectionVO();
		$projectionVO->setTxnId($txnId);
		$projectionVO->setType($type);
		$projectionVO->setPg($pg);
		$projectionVO->setLpg($lpg);
		$projectionVO->setSilver($silver);
		$projectionVO->setCash($cash);
		try{
			$response = $projectionManager->deleteProjection($txnId);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	echo $responseXML;
?>