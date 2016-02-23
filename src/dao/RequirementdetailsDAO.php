<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/RequirementdetailsVO.php';

	class RequirementdetailsDAO {


	function getAllRequirementdetailsVOs(){
		$requirementdetailsVOList =  new CU_Collection('RequirementdetailsVO');
		try{
			$requirementdetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_REQUIREMENTDETAILSS)) {
				$stmt->execute();
				$stmt->bind_result($requirementsDetailsId,$requirementsId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				while($stmt->fetch()){
					$requirementdetailsVO = new RequirementdetailsVO();
					$requirementdetailsVO->setRequirementsDetailsId($requirementsDetailsId);
					$requirementdetailsVO->setRequirementsId($requirementsId);
					$requirementdetailsVO->setGroupId($groupId);
					$requirementdetailsVO->setItemId($itemId);
					$requirementdetailsVO->setSubitemId($subitemId);
					$requirementdetailsVO->setGms($gms);
					$requirementdetailsVO->setPcs($pcs);
					$requirementdetailsVO->setSize($size);
					$requirementdetailsVO->setMc($mc);
					$requirementdetailsVO->setStone($stone);
					$requirementdetailsVO->setTotalAmount($totalAmount);
					$requirementdetailsVO->setDueDate($dueDate);
					$requirementdetailsVO->setNoOfDays($noOfDays);
					$requirementdetailsVO->setDescription($description);
					$requirementdetailsVOList->add($requirementdetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $requirementdetailsVOList;
	}

	function getRequirementsdetailsVO($id){
		try{
			$requirementdetailsVOList =  new CU_Collection('RequirementdetailsVO');
			$requirementdetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_REQUIREMENTDETAILS_INFO)) {
				$stmt->bind_param('s',$id);
				$stmt->execute();
				$stmt->bind_result($requirementsDetailsId,$requirementsId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				while($stmt->fetch()){
					$requirementdetailsVO = new RequirementdetailsVO();
					$requirementdetailsVO->setRequirementsDetailsId($requirementsDetailsId);
					$requirementdetailsVO->setRequirementsId($requirementsId);
					$requirementdetailsVO->setGroupId($groupId);
					$requirementdetailsVO->setItemId($itemId);
					$requirementdetailsVO->setSubitemId($subitemId);
					$requirementdetailsVO->setGms($gms);
					$requirementdetailsVO->setPcs($pcs);
					$requirementdetailsVO->setSize($size);
					$requirementdetailsVO->setMc($mc);
					$requirementdetailsVO->setStone($stone);
					$requirementdetailsVO->setTotalAmount($totalAmount);
					$requirementdetailsVO->setDueDate($dueDate);
					$requirementdetailsVO->setNoOfDays($noOfDays);
					$requirementdetailsVO->setDescription($description);
					$requirementdetailsVOList->add($requirementdetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $requirementdetailsVOList;
	}

	function addRequirementdetailsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$requirementsDetailsId = $requirementdetailsVO->getRequirementsDetailsId();
			$requirementsId = $requirementdetailsVO->getRequirementsId();
			$groupId = $requirementdetailsVO->getGroupId();
			$itemId = $requirementdetailsVO->getItemId();
			$subitemId = $requirementdetailsVO->getSubitemId();
			$gms = $requirementdetailsVO->getGms();
			$pcs = $requirementdetailsVO->getPcs();
			$size = $requirementdetailsVO->getSize();
			$mc = $requirementdetailsVO->getMc();
			$stone = $requirementdetailsVO->getStone();
			$totalAmount = $requirementdetailsVO->getTotalAmount();
			$dueDate = $requirementdetailsVO->getDueDate();
			$noOfDays = $requirementdetailsVO->getNoOfDays();
			$description = $requirementdetailsVO->getDescription();
			if($stmt = $dbConnection->prepare(ADD_REQUIREMENTDETAILS_INFO)) {
				$stmt->bind_param('ssssssssssssss',$requirementsDetailsId,$requirementsId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	function addRequirementdetailsListVO($dbConnection,$date,$txnId,$requirementsList){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(ADD_REQUIREMENTDETAILS_INFO)) {
				foreach($requirementsList as $requirementdetailsVO){			
					$requirementsId = $txnId;
					$groupId = $requirementdetailsVO->getGroupId();
					$itemId = $requirementdetailsVO->getItemId();
					$subitemId = $requirementdetailsVO->getSubitemId();
					$gms = $requirementdetailsVO->getGms();
					$pcs = $requirementdetailsVO->getPcs();
					$size = $requirementdetailsVO->getSize();
					$mc = $requirementdetailsVO->getMc();
					$stone = $requirementdetailsVO->getStone();
					$totalAmount = $requirementdetailsVO->getTotalAmount();
					$noOfDays = $requirementdetailsVO->getNoOfDays();
					$dueDate = $this->getDueDate($date,$noOfDays);
					$description = $requirementdetailsVO->getDescription();
					$stmt->bind_param('sssssssssssss',$requirementsId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
					$result = $stmt->execute();
					if ($result != 1){
							throw new DBException("Problems updating line items" . $dbConnection->error);
						} 
					}
					$stmt->close(); 
			}else{
				throw new DBException("Problems updating line items" . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function getDueDate($fromdate,$paymentDays){
		$date = new DateTime($fromdate);
		date_add($date, new DateInterval("P".$paymentDays."D"));
		return $date->format("Y-m-d");
	}

	function modifyRequirementdetailsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$requirementsDetailsId = $requirementdetailsVO->getRequirementsDetailsId();
			$requirementsId = $requirementdetailsVO->getRequirementsId();
			$groupId = $requirementdetailsVO->getGroupId();
			$itemId = $requirementdetailsVO->getItemId();
			$subitemId = $requirementdetailsVO->getSubitemId();
			$gms = $requirementdetailsVO->getGms();
			$pcs = $requirementdetailsVO->getPcs();
			$size = $requirementdetailsVO->getSize();
			$mc = $requirementdetailsVO->getMc();
			$stone = $requirementdetailsVO->getStone();
			$totalAmount = $requirementdetailsVO->getTotalAmount();
			$dueDate = $requirementdetailsVO->getDueDate();
			$noOfDays = $requirementdetailsVO->getNoOfDays();
			$description = $requirementdetailsVO->getDescription();
			if($stmt = $dbConnection->prepare(MODIFY_REQUIREMENTDETAILS_INFO)) {
				$stmt->bind_param('ssssssssssssss',$requirementsDetailsId,$requirementsId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteRequirementdetailsVO($dbConnection,$id){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(DELETE_REQUIREMENTDETAILS_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}
			
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
/*	function deleteRequirementdetailsVO($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DELETE_REQUIREMENTDETAILS_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}*/
	}
?>