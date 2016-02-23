<?php

	include_once '../vo/SuspensedetailsVO.php';
	include_once '../core/SuspensedetailsManager.php';
	include_once '../util/XMLBuilder.php';

	$action = $_POST['action'];

	$suspensedetailsManager = new SuspensedetailsManager();
	$xmlBuilder = new XMLBuilder();

	$responseXML = null;
	header('Content-Type: text/xml');

	if($action == "getAllSuspensedetailss"){
		$suspensedetailssList = $suspensedetailsManager->getAllSuspensedetailss();
		$responseXML = $xmlBuilder->getSuspensedetailssListAsXML();
	}else if($action == "getSuspensedetails"){
		$id = $_POST['id'];
		$suspensedetailsVO = $suspensedetailsManager->getSuspensedetailsVO($id);
		$responseXML = $xmlBuilder->getSuspensedetailsVOAsXML();
	}else if($action == "add"){
		$suspensedetailsId = $_POST['suspensedetailsid'];
		$suspenseId = $_POST['suspenseid'];
		$groupId = $_POST['groupid'];
		$itemId = $_POST['itemid'];
		$subitemId = $_POST['subitemid'];
		$pcs = $_POST['pcs'];
		$gwt = $_POST['gwt'];
		$nwt = $_POST['nwt'];
		$ctpure = $_POST['ctpure'];
		$amount = $_POST['amount'];
		$suspensedetailsVO = new SuspensedetailsVO();
		$suspensedetailsVO->setSuspensedetailsId($suspensedetailsId);
		$suspensedetailsVO->setSuspenseId($suspenseId);
		$suspensedetailsVO->setGroupId($groupId);
		$suspensedetailsVO->setItemId($itemId);
		$suspensedetailsVO->setSubitemId($subitemId);
		$suspensedetailsVO->setPcs($pcs);
		$suspensedetailsVO->setGwt($gwt);
		$suspensedetailsVO->setNwt($nwt);
		$suspensedetailsVO->setCtpure($ctpure);
		$suspensedetailsVO->setAmount($amount);
		try{
			$responseVO = $suspensedetailsManager->addSuspensedetailsVO($suspensedetailsVO);
			$responseXML = $xmlBuilder->getSuspensedetailsVOAsXML($suspensedetailsVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$suspensedetailsId = $_POST['suspensedetailsid'];
		$suspenseId = $_POST['suspenseid'];
		$groupId = $_POST['groupid'];
		$itemId = $_POST['itemid'];
		$subitemId = $_POST['subitemid'];
		$pcs = $_POST['pcs'];
		$gwt = $_POST['gwt'];
		$nwt = $_POST['nwt'];
		$ctpure = $_POST['ctpure'];
		$amount = $_POST['amount'];
		$suspensedetailsVO = new SuspensedetailsVO();
		$suspensedetailsVO->setSuspensedetailsId($suspensedetailsId);
		$suspensedetailsVO->setSuspenseId($suspenseId);
		$suspensedetailsVO->setGroupId($groupId);
		$suspensedetailsVO->setItemId($itemId);
		$suspensedetailsVO->setSubitemId($subitemId);
		$suspensedetailsVO->setPcs($pcs);
		$suspensedetailsVO->setGwt($gwt);
		$suspensedetailsVO->setNwt($nwt);
		$suspensedetailsVO->setCtpure($ctpure);
		$suspensedetailsVO->setAmount($amount);
		try{
			$responseVO = $suspensedetailsManager->modifySuspensedetailsVO($suspensedetailsVO);
			$responseXML = $xmlBuilder->getSuspensedetailsVOAsXML($suspensedetailsVO);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$id = $_POST['id'];
		try{
			$response = $suspensedetailsManager->deleteSuspensedetailsVO($id);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}

	echo $responseXML;
?>