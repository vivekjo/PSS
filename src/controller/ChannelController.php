<?php
	include_once '../core/AccountsManager.php';
	include_once '../vo/ChannelVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$accountsManager = new AccountsManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetChannelsByType"){
		$type = $_POST['type'];
		$channelsList = $accountsManager->getChannelsByType($type);
		$responseXML = $xmlBuilder->getChannelsListAsXML($channelsList);
	}else if($action == "GetAllChannels"){
		$channelsList = $accountsManager->getAllChannels();
		$responseXML = $xmlBuilder->getChannelsListAsXML($channelsList);
	}else if($action == "add"){
		$channelName = $_POST['channelname'];
		$channelType = $_POST['channeltype'];
	
		$channelVO = new ChannelVO();
		$channelVO->setChannelName($channelName);
		$channelVO->setChannelType($channelType);
		try{
			$response = $accountsManager->addChannelVO($channelVO); 
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$channelId = $_POST['channelid'];
		$channelName = $_POST['channelname'];
		$channelType = $_POST['channeltype'];
	
		$channelVO = new ChannelVO();
		$channelVO->setChannelId($channelId);
		$channelVO->setChannelName($channelName);
		$channelVO->setChannelType($channelType);
		try{
			$response = $accountsManager->modifyChannelVO($channelVO); 
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$channelId = $_POST['channelid'];
		try{
			$response = $accountsManager->deleteChannelVO($channelId); 
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(Exception $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}
	
	echo $responseXML;
?>