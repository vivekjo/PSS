<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/NewarrivalVO.php';
	include_once '../vo/NewarrivaldetailsVO.php';
	include_once '../dao/NewarrivaldetailsDAO.php';
	

	class NewarrivalDAO {


	function getAllNewarrivalVOs(){
		$newarrivalVOList =  new CU_Collection('NewarrivalVO');
		try{
			$newarrivalVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_NEWARRIVALS)) {
				$stmt->execute();
				$stmt->bind_result($newarrivalId,$date,$supplierId);
				while($stmt->fetch()){
					$newarrivalVO = new NewarrivalVO();
					$newarrivalVO->setNewarrivalId($newarrivalId);
					$newarrivalVO->setDate($date);
					$newarrivalVO->setSupplierId($supplierId);
					$newarrivalVOList->add($newarrivalVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $newarrivalVOList;
	}

	function getNewarrivalVO($id){
		try{
			$newarrivalVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_NEWARRIVAL_INFO)) {
				$stmt->bind_param('s',$id);
				$stmt->execute();
				$stmt->bind_result($newarrivalId,$date,$supplierId);
				if($stmt->fetch()){
					$newarrivalVO = new NewarrivalVO();
					$newarrivalVO->setNewarrivalId($newarrivalId);
					$newarrivalVO->setDate($date);
					$newarrivalVO->setSupplierId($supplierId);
					$newarrivalDetailListVO = null;
					$newarrivaldetailsDAO = new NewarrivaldetailsDAO();					
					$newarrivalDetailListVO = $newarrivaldetailsDAO->getNewarrivaldetailsVO($newarrivalVO->getNewarrivalId());
					$newarrivalVO->setNewArrivalDetailsList($newarrivalDetailListVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $newarrivalVO;
	}
	/*function getNewarrivalVO($id){
		try{
			$newarrivalVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_NEWARRIVAL_INFO)) {
				$stmt->bind_param('s',$id);
				$stmt->execute();
				$stmt->bind_result($newarrivalId,$date,$supplierId);
				if($stmt->fetch()){
					$newarrivalVO = new NewarrivalVO();
					$newarrivalVO->setNewarrivalId($newarrivalId);
					$newarrivalVO->setDate($date);
					$newarrivalVO->setSupplierId($supplierId);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $newarrivalVO;
	}*/

	function addNewarrivalVO($newarrivalVO){
		$result = 0;
		$dbConnection = null;
		try{
			$dbConnection = DBUtil::getTxnConnection();
//			$newarrivalId = $newarrivalVO->getNewarrivalId();
			$date = $newarrivalVO->getDate();
			$supplierId = $newarrivalVO->getSupplierId();
			if($stmt = $dbConnection->prepare(ADD_NEWARRIVAL_INFO)) {
				$stmt->bind_param('ss',$date,$supplierId);
				$result = $stmt->execute();
				if($result == 1){
					$txnId = $dbConnection->insert_id;
					$newarrivalVO->setNewarrivalId($txnId);
					$newarrivaldetailsDAO = new NewarrivaldetailsDAO();
					$newarrivaldetailsDAO->addNewarrivaldetailsList($dbConnection,$date,$txnId,$newarrivalVO->getNewArrivalDetailsList());
				}else{
					throw new DBException("NewArrivalDAO :: addNewarrival :: " . $dbConnection->error);
				}
				$dbConnection->commit();
				$stmt->close();
			}
		}catch(DBException $e){
			if($dbConnection != null){
				$dbConnection->rollback();
			}
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null)
			$dbConnection->close();
			
		return $newarrivalVO;
	}

	function modifyNewarrivalVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$newarrivalId = $newarrivalVO->getNewarrivalId();
			$date = $newarrivalVO->getDate();
			$supplierId = $newarrivalVO->getSupplierId();
			if($stmt = $dbConnection->prepare(MODIFY_NEWARRIVAL_INFO)) {
				$stmt->bind_param('sss',$newarrivalId,$date,$supplierId);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteNewarrivalVO($id){
		$result = 0;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(DELETE_NEWARRIVAL_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				if($result == 1){
					$newarrivaldetailsDAO = new NewarrivaldetailsDAO();
					$newarrivaldetailsDAO->deleteNewarrivaldetailsVO($dbConnection,$id);
				}else{
					throw new DBException("Problems occured while deleting newarrival. " . $dbConnection->error);
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				throw new DBException("Problems occured while deleting newarrival. " . $dbConnection->error);
			}
		}catch(Exception $e){
			$dbConnection->rollback();
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null)
			$dbConnection->close();
			return $result;
	}
	}
	 
?>