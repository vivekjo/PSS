<?php
	
	include_once '../core/LocationManager.php';
	include_once '../vo/LocationVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$locationManager = new LocationManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetAllLocations"){
		$locationsList = $locationManager->getAllLocations();
		$responseXML = $xmlBuilder->getLocationsListAsXML($locationsList);
	}else if($action == "getlocationdetails"){
		$locationId = $_POST['locationid'];
		$locationVO = $locationManager->getLocationDetails($locationId);
		$responseXML = $xmlBuilder->getLocationVOAsXML($locationVO);
	}else if($action == "add"){
		$locationName = $_POST['locationname'];
		$locationVO = new LocationVO();
		$locationVO->setLocationName($locationName);
		try{
			$response = $locationManager->addLocation($locationVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$locationId = $_POST['locationid'];
		$locationName = $_POST['locationname'];
		
		$locationVO = new LocationVO();
		$locationVO->setLocationId($locationId);
		$locationVO->setLocationName($locationName);
		
		try{
			$response = $locationManager->modifyLocation($locationVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$locationId = $_POST['locationid'];
		$response = $locationManager->deleteLocation($locationId);
		$responseXML = $xmlBuilder->buildResponse($response);
	}
	
	echo $responseXML;
?>