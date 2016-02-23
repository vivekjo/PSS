<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/NewarrivaldetailsVO.php';

	class NewarrivaldetailsDAO {
 

	function getAllNewarrivaldetailsVOs(){
		$newarrivaldetailsVOList =  new CU_Collection('NewarrivaldetailsVO');
		try{
			$newarrivaldetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_NEWARRIVALDETAILSS)) {
				$stmt->execute();
				$stmt->bind_result($newarrivalDetailsId,$newarrivalId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				while($stmt->fetch()){
					$newarrivaldetailsVO = new NewarrivaldetailsVO();
					$newarrivaldetailsVO->setNewarrivalDetailsId($newarrivalDetailsId);
					$newarrivaldetailsVO->setNewarrivalId($newarrivalId);
					$newarrivaldetailsVO->setGroupId($groupId);
					$newarrivaldetailsVO->setItemId($itemId);
					$newarrivaldetailsVO->setSubitemId($subitemId);
					$newarrivaldetailsVO->setGms($gms);
					$newarrivaldetailsVO->setPcs($pcs);
					$newarrivaldetailsVO->setSize($size);
					$newarrivaldetailsVO->setMc($mc);
					$newarrivaldetailsVO->setStone($stone);
					$newarrivaldetailsVO->setTotalAmount($totalAmount);
					$newarrivaldetailsVO->setDueDate($dueDate);
					$newarrivaldetailsVO->setNoOfDays($noOfDays);
					$newarrivaldetailsVO->setDescription($description);
					$newarrivaldetailsVOList->add($newarrivaldetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $newarrivaldetailsVOList;
	}

	function getNewarrivaldetailsVO($id){
		try{
			$newarrivaldetailsVOList =  new CU_Collection('NewarrivaldetailsVO');
			$newarrivaldetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_NEWARRIVALDETAILS_INFO)) {
				$stmt->bind_param('s',$id);
				$stmt->execute();
				$stmt->bind_result($newarrivalDetailsId,$newarrivalId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				while($stmt->fetch()){
					$newarrivaldetailsVO = new NewarrivaldetailsVO();
					$newarrivaldetailsVO->setNewarrivalDetailsId($newarrivalDetailsId);
					$newarrivaldetailsVO->setNewarrivalId($newarrivalId);
					$newarrivaldetailsVO->setGroupId($groupId);
					$newarrivaldetailsVO->setItemId($itemId);
					$newarrivaldetailsVO->setSubitemId($subitemId);
					$newarrivaldetailsVO->setGms($gms);
					$newarrivaldetailsVO->setPcs($pcs);
					$newarrivaldetailsVO->setSize($size);
					$newarrivaldetailsVO->setMc($mc);
					$newarrivaldetailsVO->setStone($stone);
					$newarrivaldetailsVO->setTotalAmount($totalAmount);
					$newarrivaldetailsVO->setDueDate($dueDate);
					$newarrivaldetailsVO->setNoOfDays($noOfDays);
					$newarrivaldetailsVO->setDescription($description);
					$newarrivaldetailsVOList->add($newarrivaldetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $newarrivaldetailsVOList;
	}

	function addNewarrivaldetailsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$newarrivalDetailsId = $newarrivaldetailsVO->getNewarrivalDetailsId();
			$newarrivalId = $newarrivaldetailsVO->getNewarrivalId();
			$groupId = $newarrivaldetailsVO->getGroupId();
			$itemId = $newarrivaldetailsVO->getItemId();
			$subitemId = $newarrivaldetailsVO->getSubitemId();
			$gms = $newarrivaldetailsVO->getGms();
			$pcs = $newarrivaldetailsVO->getPcs();
			$size = $newarrivaldetailsVO->getSize();
			$mc = $newarrivaldetailsVO->getMc();
			$stone = $newarrivaldetailsVO->getStone();
			$totalAmount = $newarrivaldetailsVO->getTotalAmount();
			$dueDate = $newarrivaldetailsVO->getDueDate();
			$noOfDays = $newarrivaldetailsVO->getNoOfDays();
			$description = $newarrivaldetailsVO->getDescription();
			if($stmt = $dbConnection->prepare(ADD_NEWARRIVALDETAILS_INFO)) {
				$stmt->bind_param('ssssssssssssss',$newarrivalDetailsId,$newarrivalId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	function addNewarrivaldetailsList($dbConnection,$date,$txnId,$newarrivalList){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(ADD_NEWARRIVALDETAILS_INFO)) {
				foreach($newarrivalList as $newarrivaldetailsVO){					
					$newarrivalId = $txnId;
					$groupId = $newarrivaldetailsVO->getGroupId();
					$itemId = $newarrivaldetailsVO->getItemId();
					$subitemId = $newarrivaldetailsVO->getSubitemId();
					$gms = $newarrivaldetailsVO->getGms();
					$pcs = $newarrivaldetailsVO->getPcs();
					$size = $newarrivaldetailsVO->getSize();
					$mc = $newarrivaldetailsVO->getMc();
					$stone = $newarrivaldetailsVO->getStone();
					$totalAmount = $newarrivaldetailsVO->getTotalAmount();
					$dueDate = $newarrivaldetailsVO->getDueDate();
					$noOfDays = $newarrivaldetailsVO->getNoOfDays();
					$dueDate = $this->getDueDate($date,$noOfDays);
					$description = $newarrivaldetailsVO->getDescription();
					$stmt->bind_param('sssssssssssss',$newarrivalId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
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
	function modifyNewarrivaldetailsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$newarrivalDetailsId = $newarrivaldetailsVO->getNewarrivalDetailsId();
			$newarrivalId = $newarrivaldetailsVO->getNewarrivalId();
			$groupId = $newarrivaldetailsVO->getGroupId();
			$itemId = $newarrivaldetailsVO->getItemId();
			$subitemId = $newarrivaldetailsVO->getSubitemId();
			$gms = $newarrivaldetailsVO->getGms();
			$pcs = $newarrivaldetailsVO->getPcs();
			$size = $newarrivaldetailsVO->getSize();
			$mc = $newarrivaldetailsVO->getMc();
			$stone = $newarrivaldetailsVO->getStone();
			$totalAmount = $newarrivaldetailsVO->getTotalAmount();
			$dueDate = $newarrivaldetailsVO->getDueDate();
			$noOfDays = $newarrivaldetailsVO->getNoOfDays();
			$description = $newarrivaldetailsVO->getDescription();
			if($stmt = $dbConnection->prepare(MODIFY_NEWARRIVALDETAILS_INFO)) {
				$stmt->bind_param('ssssssssssssss',$newarrivalDetailsId,$newarrivalId,$groupId,$itemId,$subitemId,$gms,$pcs,$size,$mc,$stone,$totalAmount,$dueDate,$noOfDays,$description);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteNewarrivaldetailsVO($dbConnection,$txnId){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(DELETE_NEWARRIVALDETAILS_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				$stmt->close();
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
/*	function deleteNewarrivaldetailsVO($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DELETE_NEWARRIVALDETAILS_INFO)) {
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