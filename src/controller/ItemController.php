<?php
	
	include_once '../core/ProductManager.php';
	include_once '../vo/ItemVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$productManager = new ProductManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetAllItems"){
		$itemsList = $productManager->getAllItems();
		$responseXML = $xmlBuilder->getItemListAsXML($itemsList);
	}else if($action == "GetItemsByGroup"){
		$groupId = $_POST['groupId'];
		$itemsList = $productManager->getItemsByGroup($groupId);
		$responseXML = $xmlBuilder->getItemListAsXML($itemsList);
	}else if($action == "add"){
		$itemName = $_POST['itemname'];
		$parentGroupId = $_POST['parentgroupid'];
	
		$itemVO = new ItemVO();
		$itemVO->setItemName($itemName);
		$itemVO->setParentGroupId($parentGroupId);
		try{
			$response = $productManager->addItemVO($itemVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$itemId = $_POST['itemid'];
		$itemName = $_POST['itemname'];
		$parentGroupId = $_POST['parentgroupid'];
	
		$itemVO = new ItemVO();
		$itemVO->setItemId($itemId);
		$itemVO->setItemName($itemName);
		$itemVO->setParentGroupId($parentGroupId);
		try{
			$response = $productManager->modifyItemVO($itemVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$itemId = $_POST['itemid'];
		try{
			$response = $productManager->deleteItemVO($itemId);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>