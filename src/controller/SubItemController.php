<?php
	
	include_once '../core/ProductManager.php';
	include_once '../vo/SubitemVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$productManager = new ProductManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "getAllSubitems"){
		$subitemsList = $productManager->getAllSubitems();
		$responseXML = $xmlBuilder->getSubitemListAsXML($subitemsList);
	}else if($action == "GetSubItems"){
		$itemId = $_POST['itemId'];
		$subitemsList = $productManager->getSubitemsByItemId($itemId);
		$responseXML = $xmlBuilder->getSubitemListAsXML($subitemsList);
	}else if($action == "add"){
		$subitemName = $_POST['subitemname'];
		$parentItemId = $_POST['parentitemid'];
	
		$subitemVO = new SubitemVO();
		$subitemVO->setSubitemName($subitemName);
		$subitemVO->setParentItemId($parentItemId);
		try{
			$response = $productManager->addSubitemVO($subitemVO);
			$responseXML = $xmlBuilder->buildResponse($responseXML);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$subitemId = $_POST['subitemid'];
		$subitemName = $_POST['subitemname'];
		$parentItemId = $_POST['parentitemid'];
	
		$subitemVO = new SubitemVO();
		$subitemVO->setSubitemId($subitemId);
		$subitemVO->setSubitemName($subitemName);
		$subitemVO->setParentItemId($parentItemId);
		try{
			$response = $productManager->modifySubitemVO($subitemVO);
			$responseXML = $xmlBuilder->buildResponse($responseXML);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$subitemId = $_POST['subitemid'];
		try{
			$response = $productManager->delteSubitemVO($subitemId);
			$responseXML = $xmlBuilder->buildResponse($responseXML);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>