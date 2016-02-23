<?php
	include_once '../core/AccountsManager.php';
	include_once '../vo/AccountheadVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$accountsManager = new AccountsManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetAccHeadsByChannel"){
		$channelId = $_POST['channelid'];
		$accheadsList = $accountsManager->getAccHeadsByChannel($channelId);
		$responseXML = $xmlBuilder->getAccountheadsListAsXML($accheadsList);
	}else if($action == "GetAllAccheads"){
		$accheadsList = $accountsManager->getAllAccheads();
		$responseXML = $xmlBuilder->getAccountheadsListAsXML($accheadsList);
	}else if($action == "add"){
		$accheadName = $_POST['accheadname'];
		$parentChannelId = $_POST['parentchannelid'];
	
		$accountheadVO = new AccountheadVO();
		$accountheadVO->setAccheadName($accheadName);
		$accountheadVO->setParentChannelId($parentChannelId);
		try{
			$response = $accountsManager->addAccountHeadVO($accountheadVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$accheadId = $_POST['accheadid'];
		$accheadName = $_POST['accheadname'];
		$parentChannelId = $_POST['parentchannelid'];
	
		$accountheadVO = new AccountheadVO();
		$accountheadVO->setAccheadId($accheadId);
		$accountheadVO->setAccheadName($accheadName);
		$accountheadVO->setParentChannelId($parentChannelId);
		try{
			$response = $accountsManager->modifyAccountHeadVO($accountheadVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$accheadId = $_POST['accheadid'];
		try{
			$response = $accountsManager->deleteAccountHeadVO($accheadId);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>