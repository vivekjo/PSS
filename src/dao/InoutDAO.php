<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/InoutentryVO.php';
	include_once '../vo/InoutdetailsVO.php';
	include_once '../dao/InoutdetailsDAO.php';	

	class InoutentryDAO {

	function getAllInoutentryVOs(){
		$inoutentryVOList =  new CU_Collection();
		try{
			$inoutentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_INOUTENTRYS)) {
				$stmt->execute();
				$stmt->bind_result($inoutId,$date,$issuerId,$bearerId,$receiverId,$locationId,$type);
				while($stmt->fetch()){

					$inoutentryVO = new InoutentryVO();
					$inoutentryVO->setInoutId($inoutId);
					$inoutentryVO->setDate($date);
					$inoutentryVO->setIssuerId($issuerId);
					$inoutentryVO->setBearerId($bearerId);
					$inoutentryVO->setReceiverId($receiverId);
					$inoutentryVO->setLocationId($locationId);
					$inoutentryVO->setType($type);
					$inoutentryVOList->add($inoutentryVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutentryVOList;
	}
	
	function getOpeningInoutInventory($date,$type){
		$inoutentryVOList =  array();
		try{
			$fromdate = '2011/04/01';
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_OPENING_INOUT_INVENTORY)) {
				$stmt->bind_param('sss',$fromdate,$date,$type);
				$stmt->execute();
				$stmt->bind_result($subitemId,$pcs);
				while($stmt->fetch()){
					$inoutentryVOList[$subitemId] = $pcs;
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutentryVOList;
	}
	
	function getInoutInventory($date,$type){
		$inoutentryVOList =  array();
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_INOUT_INVENTORY)) {
				$stmt->bind_param('ss',$date,$type);
				$stmt->execute();
				$stmt->bind_result($subitemId,$pcs);
				while($stmt->fetch()){
					if($pcs > 0)
					$inoutentryVOList[$subitemId] = $pcs;
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutentryVOList;
	}
	function getAllInoutentryVOsByQueryString($queryString1,$queryString2){
		$inoutentryVOList =  new CU_Collection('InoutentryVO');
		try{
			$inoutentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($queryString1)) {
				$stmt->execute();
				$stmt->bind_result($inoutId,$date,$issuerId,$bearerId,$receiverId,$locationId,$type);
				while($stmt->fetch()){
					$inoutentryVO = new InoutentryVO();
					$inoutentryVO->setInoutId($inoutId);
					$inoutentryVO->setDate($date);
					$inoutentryVO->setIssuerId($issuerId);
					$inoutentryVO->setBearerId($bearerId);
					$inoutentryVO->setReceiverId($receiverId);
					$inoutentryVO->setLocationId($locationId);
					$inoutentryVO->setType($type);
					
					$inoutdetailsDAO = new InoutdetailsDAO();
					$inoutDetailsList = $inoutdetailsDAO->getInoutdetailsVOByQuery($inoutId,$queryString2);
					$inoutentryVO->setInoutDetailsList($inoutDetailsList);
					$inoutentryVOList->add($inoutentryVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutentryVOList;
	}

	function getInout($inoutId){
		try{
			$inoutentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_INOUTENTRY_INFO)) {
				$stmt->bind_param('s',$inoutId);
				$stmt->execute();
				$stmt->bind_result($inoutId,$date,$issuerId,$bearerId,$receiverId,$locationId,$type);
				if($stmt->fetch()){
					$inoutentryVO = new InoutentryVO();
					$inoutentryVO->setInoutId($inoutId);
					$inoutentryVO->setDate($date);
					$inoutentryVO->setIssuerId($issuerId);
					$inoutentryVO->setBearerId($bearerId);
					$inoutentryVO->setReceiverId($receiverId);
					$inoutentryVO->setLocationId($locationId);
					$inoutentryVO->setType($type);
					
					$inoutdetailsDAO = new InoutdetailsDAO();
					$inoutDetailsList = $inoutdetailsDAO->getInoutdetailsList($inoutId);
					$inoutentryVO->setInoutDetailsList($inoutDetailsList);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutentryVO;
	}

	function addInout($inoutentryVO){
		$result = false;
		$dbConnection = null;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			$issuerId = $inoutentryVO->getIssuerId();
			$bearerId = $inoutentryVO->getBearerId();
			$receiverId = $inoutentryVO->getReceiverId();
			$locationId = $inoutentryVO->getLocationId();
			$type = $inoutentryVO->getType();
			if($stmt = $dbConnection->prepare(ADD_INOUTENTRY_INFO)) {
				$stmt->bind_param('sssss',$issuerId,$bearerId,$receiverId,$locationId,$type);
				$result = $stmt->execute();
				if($result == 1){
					$txnId = $dbConnection->insert_id;
					$inoutentryVO->setInoutId($txnId);
					$inoutdetailsDAO = new InoutdetailsDAO();
					$inoutdetailsDAO->addInoutDetailsList($dbConnection,$txnId,$inoutentryVO->getInoutDetailsList());
				}else{
					throw new DBException("Problems occured while adding inout entry. " . $dbConnection->error);
				}
				$stmt->close();
				$dbConnection->commit();
			}else{
				throw new DBException("Inout DAO " . " addInoutVO " . $dbConnection->error);
			}
			
		}catch(Exception $e){
			$dbConnection->rollback();
			throw new DBException($e->getMessage());
		}
		
		if($dbConnection != null){
			$dbConnection->close();
		}
		return $result;
	}

	function modifyInoutentryVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$inoutId = $inoutentryVO->getInoutId();
			$date = $inoutentryVO->getDate();
			$issuerId = $inoutentryVO->getIssuerId();
			$bearerId = $inoutentryVO->getBearerId();
			$receiverId = $inoutentryVO->getReceiverId();
			$locationId = $inoutentryVO->getLocationId();
			$type = $inoutentryVO->getType();
			if($stmt = $dbConnection->prepare(MODIFY_INOUTENTRY_INFO)) {
				$stmt->bind_param('sssssss',$inoutId,$date,$issuerId,$bearerId,$receiverId,$locationId,$type);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteInout($txnId){
		$result = false;
		$dbConnection = null;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(DELETE_INOUTENTRY_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				if($result == 1){
					$inoutdetailsDAO = new InoutdetailsDAO();
					$inoutdetailsDAO->deleteInoutDetailsList($dbConnection,$txnId);
				}
				$stmt->close();
				$dbConnection->commit();
			}
			$dbConnection->close();
		}catch(Exception $e){
			$dbConnection->rollback();
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	}
?>