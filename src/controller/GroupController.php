<?php
	
	include_once '../core/ProductManager.php';
	include_once '../vo/ItemgroupVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$productManager = new ProductManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetAllGroups"){
		$groupsList = $productManager->getAllGroups();
		$responseXML = $xmlBuilder->getItemgroupListAsXML($groupsList);
	}else if($action == "getGroupByGroupId"){
		
	}else if($action == "add"){
		$groupName = $_POST['groupname'];
		$itemgroupVO = new ItemgroupVO();
		$itemgroupVO->setGroupName($groupName);
		try{
			$response = $productManager->addGroupVO($itemgroupVO);
			$responseXML = $xmlBuilder->buildResponse($responseXML);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$groupId = $_POST['groupid'];
		$groupName = $_POST['groupname'];
		$itemgroupVO = new ItemgroupVO();
		$itemgroupVO->setGroupId($groupId);
		$itemgroupVO->setGroupName($groupName);
		try{
			$response = $productManager->modifyGroupVO($itemgroupVO);
			$responseXML = $xmlBuilder->buildResponse($responseXML);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$groupId = $_POST['groupid'];
		try{
			$response = $productManager->deleteGroupVO($groupId);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>