<?php
	include_once '../core/DaybookManager.php';
	include_once '../vo/DaybookVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$daybookManager = new DaybookManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "getAccountsByDate"){
		$date = $_POST['date'];
		$accountsList = $daybookManager->getAccountsByDate($date);
		$responseXML = $xmlBuilder->getAccountsListAsXML($accountsList,"DAYBOOKINFO");
	}else if($action == "getAccountsById"){
		$txnId = $_POST['txnid'];
		try{
			$accountVO = $daybookManager->getAccountsById($txnId);
			$responseXML = $xmlBuilder->getDaybookVOAsXML($accountVO);
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
	
		$daybookVO = new DaybookVO();
		$daybookVO->setDate($date);
		$daybookVO->setType($type);
		$daybookVO->setCategoryId($categoryId);
		$daybookVO->setAccheadId($accheadId);
		$daybookVO->setPg($pg);
		$daybookVO->setLpg($lpg);
		$daybookVO->setSilver($silver);
		$daybookVO->setCash($cash);
		$daybookVO->setDescription($description);
		try{
			$daybookVO = $daybookManager->addAccounts($daybookVO);
			$responseXML = $xmlBuilder->getDaybookVOAsXML($daybookVO);
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
	
		$daybookVO = new DaybookVO();
		$daybookVO->setTxnId($txnId);
		$daybookVO->setDate($date);
		$daybookVO->setType($type);
		$daybookVO->setCategoryId($categoryId);
		$daybookVO->setAccheadId($accheadId);
		$daybookVO->setPg($pg);
		$daybookVO->setLpg($lpg);
		$daybookVO->setSilver($silver);
		$daybookVO->setCash($cash);
		$daybookVO->setDescription($description);
		try{
			$daybookVO = $daybookManager->modifyAccounts($daybookVO);
			$responseXML = $xmlBuilder->getDaybookVOAsXML($daybookVO);
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
	
		$daybookVO = new DaybookVO();
		$daybookVO->setTxnId($txnId);
		$daybookVO->setType($type);
		$daybookVO->setPg($pg);
		$daybookVO->setLpg($lpg);
		$daybookVO->setSilver($silver);
		$daybookVO->setCash($cash);
		try{
			$response = $daybookManager->deleteAccounts($daybookVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>