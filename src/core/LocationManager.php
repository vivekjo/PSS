<?php

	include_once '../dao/LocationDAO.php';
	
	class LocationManager{
		function getAllLocations(){
			$locationList = null;
			$locationDAO = new LocationDAO();
			$locationList = $locationDAO->getAllLocations();
			return $locationList;
		}
		
		function getLocationDetails($locationId){
			$locationVO = null;
			$locationDAO = new LocationDAO();
			$locationVO = $locationDAO->getLocationVO($locationId);
			return $locationVO;
		}
		
		function addLocation($locationVO){
			$result = false;
			try{
				$locationDAO = new LocationDAO();
				$result = $locationDAO->addLocationVO($locationVO);
			}catch(DBException $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function modifyLocation($locationVO){
			$result = false;
			try{
				$locationDAO = new LocationDAO();
				$result = $locationDAO->modifyLocationVO($locationVO);
			}catch(DBException $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function deleteLocation($locationId){
			$result = false;
			$locationDAO = new LocationDAO();
			$result = $locationDAO->deleteLocationVO($locationId);
			return $result;
		}
		
	}
	
	
?>