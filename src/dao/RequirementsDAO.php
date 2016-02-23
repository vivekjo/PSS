<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/RequirementsVO.php';
	include_once '../vo/RequirementdetailsVO.php';
	include_once '../dao/RequirementdetailsDAO.php';

	class RequirementsDAO {


	function getAllRequirementsVOs(){
		$requirementsVOList =  new CU_Collection('RequirementsVO');
		try{
			$requirementsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_REQUIREMENTSS)) {
				$stmt->execute();
				$stmt->bind_result($requirementsId,$date,$employeeId);
				while($stmt->fetch()){
					$requirementsVO = new RequirementsVO();
					$requirementsVO->setRequirementsId($requirementsId);
					$requirementsVO->setDate($date);
					$requirementsVO->setEmployeeId($employeeId);
					$requirementsVOList->add($requirementsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $requirementsVOList;
	}

	function getRequirementsVO($id){
		try{
			$requirementsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_REQUIREMENTS_INFO)) {
				$stmt->bind_param('s',$id);
				$stmt->execute();
				$stmt->bind_result($requirementsId,$date,$employeeId);
				if($stmt->fetch()){
					$requirementsVO = new RequirementsVO();
					$requirementsVO->setRequirementsId($requirementsId);
					$requirementsVO->setDate($date);
					$requirementsVO->setEmployeeId($employeeId);
					$requirementsDetailListVO = null;
					$requirementsdetailsDAO = new RequirementdetailsDAO();					
					$requirementsDetailListVO = $requirementsdetailsDAO->getrequirementsdetailsVO($requirementsVO->getrequirementsId());
					$requirementsVO->setrequirementsDetailsList($requirementsDetailListVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $requirementsVO;
	}

	function addRequirementsVO($requirementsVO){
		$result = 0;
		$dbConnection = null;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			$date = $requirementsVO->getDate();
			$employeeId = $requirementsVO->getEmployeeId();
			if($stmt = $dbConnection->prepare(ADD_REQUIREMENTS_INFO)) {
				$stmt->bind_param('ss',$date,$employeeId);
				$result = $stmt->execute();
				if($result == 1){
					$txnId = $dbConnection->insert_id;
					$requirementsVO->setRequirementsId($txnId);
					$requirementsdetailsDAO = new RequirementdetailsDAO();
					$requirementsdetailsDAO->addRequirementdetailsListVO($dbConnection,$date,$txnId,$requirementsVO->getRequirementsDetailsList());
				}else{
					throw new DBException("RequirementsDAO :: addRequirements :: " . $dbConnection->error);
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
			
		return $requirementsVO;
	}

	function modifyRequirementsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$requirementsId = $requirementsVO->getRequirementsId();
			$date = $requirementsVO->getDate();
			$employeeId = $requirementsVO->getEmployeeId();
			if($stmt = $dbConnection->prepare(MODIFY_REQUIREMENTS_INFO)) {
				$stmt->bind_param('sss',$requirementsId,$date,$employeeId);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteRequirementsVO($id){
		$result = 0;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(DELETE_REQUIREMENTS_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				if($result == 1){
					$requirementsdetailsDAO = new RequirementdetailsDAO();
					$requirementsdetailsDAO->deleteRequirementdetailsVO($dbConnection,$id);
				}else{
					throw new DBException("Problems occured while deleting requirements. " . $dbConnection->error);
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				throw new DBException("Problems occured while deleting requirements. " . $dbConnection->error);
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