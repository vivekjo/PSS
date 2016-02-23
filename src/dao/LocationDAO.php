<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/LocationVO.php';

	class LocationDAO {


	function getAllLocations(){
		$locationVOList =  new CU_Collection('LocationVO');
		try{
			$locationVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_LOCATIONS)) {
				$stmt->execute();
				$stmt->bind_result($locationId,$locationName);
				while($stmt->fetch()){
					$locationVO = new LocationVO();
					$locationVO->setLocationId($locationId);
					$locationVO->setLocationName($locationName);
					$locationVOList->add($locationVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $locationVOList;
	}

	function getLocationVO($locationId){
		try{
			$locationVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_LOCATION_INFO)) {
				$stmt->bind_param('s',$locationId);
				$stmt->execute();
				$stmt->bind_result($locationId,$locationName);
				if($stmt->fetch()){

					$locationVO = new LocationVO();
					$locationVO->setLocationId($locationId);
					$locationVO->setLocationName($locationName);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $locationVO;
	}

	function addLocationVO($locationVO){
		$result = false;
		$dbConnection = null;
		try{
			$locationName = $locationVO->getLocationName();
			$isDuplicate = $this->doesLocationExists($locationName);
			if($isDuplicate != true){
				$dbConnection = DBUtil::getConnection();
				
				if($stmt = $dbConnection->prepare(ADD_LOCATION_INFO)) {
					$stmt->bind_param('s',$locationName);
					$result = $stmt->execute();
					$stmt->close();
				}
				$dbConnection->close();
			}else{
				throw new DBException("Location Name already exists. Please provide a different Location name.");
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifyLocationVO($locationVO){
		$result = false;
		try{
			$locationId = $locationVO->getLocationId();
			$locationName = $locationVO->getLocationName();
			$isDuplicate = $this->doesOtherLocationExists($locationName,$locationId);
			if($isDuplicate != true){
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(MODIFY_LOCATION_INFO)) {
					$stmt->bind_param('ss',$locationId,$locationName);
					$result = $stmt->execute();
					$stmt->close();
				}
				$dbConnection->close();
			}else{
				throw new DBException("Location Name already exists. Please provide a different Location name.");
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteLocationVO($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DELETE_LOCATION_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function doesLocationExists($locationName){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_LOCATION_EXISTS)) {
					$stmt->bind_param('s',$locationName);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("LocationDAO :: doesLocationExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
		
		function doesOtherLocationExists($locationName,$locationId){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_OTHER_LOCATION_EXISTS)) {
					$stmt->bind_param('ss',$locationName,$locationId);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("LocationDAO :: doesOtherLocationExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
}
?>