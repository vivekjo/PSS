<?php
	include_once '../core/RateManager.php';
	include_once '../vo/RateVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$rateManager = new RateManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetAllRates"){
		$ratesList = $rateManager->getAllRates();
		$responseXML = $xmlBuilder->getRatesListAsXML($ratesList);
	}else if($action == "getRateByType"){
		$metal = $_POST['metal'];
		$rateVO = $rateManager->getRateByType($metal);
		$responseXML = $xmlBuilder->getRateVOAsXML($rateVO);
	}else if($action == "modifyPG"){
		$pgValue = $_POST['pg'];
		$response = $rateManager->modifyRate("pure gold",$pgValue);
		$responseXML = $xmlBuilder->buildResponse($response);
	}else if($action == "modifyLPG"){
		$lpgValue = $_POST['lpg'];
		$response = $rateManager->modifyRate("less pure gold",$lpgValue);
		$responseXML = $xmlBuilder->buildResponse($response);
	}else if($action == "modifySilver"){
		$silverValue = $_POST['silver'];
		$response = $rateManager->modifyRate("silver",$silverValue);
		$responseXML = $xmlBuilder->buildResponse($response);
	}
	
	echo $responseXML;
?>