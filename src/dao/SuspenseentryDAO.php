<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/SuspenseentryVO.php';
	include_once '../vo/PaymentTypeVO.php';
	include_once '../dao/SuspensedetailsDAO.php';

	class SuspenseentryDAO {


	function getAllSuspenseentryVOs(){
		$suspenseentryVOList =  new CU_Collection('SuspenseentryVO');
		try{
			$suspenseentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_SUSPENSEENTRYS)) {
				$stmt->execute();
				$stmt->bind_result($suspenseId,$date,$issuerId,$bearerId,$receiverId,$locationId,$type,$mode,$refSuspenseId);
				while($stmt->fetch()){
					$suspenseentryVO = new SuspenseentryVO();
					$suspenseentryVO->setSuspenseId($suspenseId);
					$suspenseentryVO->setDate($date);
					$suspenseentryVO->setIssuerId($issuerId);
					$suspenseentryVO->setBearerId($bearerId);
					$suspenseentryVO->setReceiverId($receiverId);
					$suspenseentryVO->setLocationId($locationId);
					$suspenseentryVO->setType($type);
					$suspenseentryVO->setMode($mode);
					$suspenseentryVO->setRefSuspenseId($refSuspenseId);
					$suspenseentryVOList->add($suspenseentryVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $suspenseentryVOList;
	}
	
	function getAllSuspenseentryVOsByQueryString($queryString1,$queryString2){
		$suspenseentryVOList =  new CU_Collection('SuspenseentryVO');
		try{
			$suspenseentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($queryString1)) {
				$stmt->execute();
				$stmt->bind_result($suspenseId,$date,$issuerId,$bearerId,$receiverId,$locationId,$mode,$type,$refSuspenseId);
				while($stmt->fetch()){
					$suspenseentryVO = new SuspenseentryVO();
					$suspenseentryVO->setSuspenseId($suspenseId);
					$suspenseentryVO->setDate($date);
					$suspenseentryVO->setIssuerId($issuerId);
					$suspenseentryVO->setBearerId($bearerId);
					$suspenseentryVO->setReceiverId($receiverId);
					$suspenseentryVO->setLocationId($locationId);
					$suspenseentryVO->setType($type);
					$suspenseentryVO->setMode($mode);
					$suspenseentryVO->setRefSuspenseId($refSuspenseId);
					
					$suspensedetailsDAO = new SuspensedetailsDAO();
					$suspenseDetailList = $suspensedetailsDAO->getAllSuspensedetailsVOsByQuery($suspenseId,$queryString2);
					
					$suspenseentryVO->setSuspenseDetailList($suspenseDetailList);
					
					$suspenseentryVOList->add($suspenseentryVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $suspenseentryVOList;
	}

	function getSuspenseReturn($suspenseno){
		try{
			$suspenseentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_OUT_SUSPENSEENTRY)) {
				$stmt->bind_param('s',$suspenseno);
				$stmt->execute();
				$stmt->store_result();
				$num_rows= $stmt->num_rows; 
				if($num_rows > 0){
					$stmt->bind_result($suspenseId,$date,$issuerId,$bearerId,$receiverId,$locationId,$mode,$type,$refSuspenseId);
					if($stmt->fetch()){
						$suspenseentryVO = new SuspenseentryVO();
						$suspenseentryVO->setSuspenseId($suspenseId);
						$suspenseentryVO->setDate($date);
						$suspenseentryVO->setIssuerId($issuerId);
						$suspenseentryVO->setBearerId($bearerId);
						$suspenseentryVO->setReceiverId($receiverId);
						$suspenseentryVO->setLocationId($locationId);
						$suspenseentryVO->setType($type);
						$suspenseentryVO->setMode($mode);
						$suspenseentryVO->setRefSuspenseId($refSuspenseId);
						
						$suspensedetailsDAO = new SuspensedetailsDAO();
						$suspenseDetailList = $suspensedetailsDAO->getSuspensedetailsVO($suspenseId);
						
						$suspenseentryVO->setSuspenseDetailList($suspenseDetailList);
					}else{
						throw new DBException("Problems occured while getting suspense entry. " . $dbConnection->error);
					}
				}else{
					throw new DBException("Please check your voucher no. Only OUT entries can have a return suspense entry");
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(DBException $e){
			throw new DBException($e->getMessage());
		}
		return $suspenseentryVO;
	}
	function getSuspenseentry($suspenseno){
		try{
			$suspenseentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_SUSPENSEENTRY_INFO)) {
				$stmt->bind_param('s',$suspenseno);
				$stmt->execute();
				$stmt->bind_result($suspenseId,$date,$issuerId,$bearerId,$receiverId,$locationId,$mode,$type,$refSuspenseId);
				if($stmt->fetch()){
					$suspenseentryVO = new SuspenseentryVO();
					$suspenseentryVO->setSuspenseId($suspenseId);
					$suspenseentryVO->setDate($date);
					$suspenseentryVO->setIssuerId($issuerId);
					$suspenseentryVO->setBearerId($bearerId);
					$suspenseentryVO->setReceiverId($receiverId);
					$suspenseentryVO->setLocationId($locationId);
					$suspenseentryVO->setType($type);
					$suspenseentryVO->setMode($mode);
					$suspenseentryVO->setRefSuspenseId($refSuspenseId);
					
					$suspensedetailsDAO = new SuspensedetailsDAO();
					$suspenseDetailList = $suspensedetailsDAO->getSuspensedetailsVO($suspenseId);
					
					$suspenseentryVO->setSuspenseDetailList($suspenseDetailList);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $suspenseentryVO;
	}
	function hasReturn($suspenseno){
		$hasReturn = false;
		try{
			$suspenseentryVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_SUSPENSEENTRY_RETURN)) {
				$stmt->bind_param('s',$suspenseno);
				$stmt->execute();
				$stmt->bind_result($suspenseId,$date,$issuerId,$bearerId,$receiverId,$locationId,$mode,$type,$refSuspenseId);
				if($stmt->fetch()){
					$hasReturn = true;
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $hasReturn;
	}
	
	function closeSuspense(){
		$result = 0;
		$dbConnection = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_UNRETURNED_SUSPENSEENTRY_INFO)) {
				$stmt->execute();
				$stmt->bind_result($suspenseId,$date,$issuerId,$bearerId,$receiverId,$locationId,$mode,$type,$refSuspenseId);
				while($stmt->fetch()){
					$suspenseentryVO = new SuspenseentryVO();
					$suspenseentryVO->setIssuerId($issuerId);
					$suspenseentryVO->setBearerId($bearerId);
					$suspenseentryVO->setReceiverId($receiverId);
					$suspenseentryVO->setLocationId($locationId);
					$suspenseentryVO->setType("RETURN");
					$suspenseentryVO->setMode($mode);
					$suspenseentryVO->setRefSuspenseId($suspenseId);

					$suspensedetailsDAO = new SuspensedetailsDAO();
					$suspenseDetailList = $suspensedetailsDAO->getSuspensedetailsVO($suspenseId);
					
					foreach($suspenseDetailList as $suspensedetailvo){
						$suspensedetailvo->setGwt(0);
						$suspensedetailvo->setNwt(0);
						$suspensedetailvo->setCtpure(0);
						$suspensedetailvo->setAmount(0);
					}
					$suspenseentryVO->setSuspenseDetailList($suspenseDetailList);

					$this->addSuspenseentry($suspenseentryVO);
				}
			}
			$stmt->close();
			$dbConnection->close();
		}catch(DBException $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function addSuspenseentry($suspenseentryVO){
		$result = 0;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			$issuerId = $suspenseentryVO->getIssuerId();
			$bearerId = $suspenseentryVO->getBearerId();
			$receiverId = $suspenseentryVO->getReceiverId();
			$locationId = $suspenseentryVO->getLocationId();
			$type = $suspenseentryVO->getType();
			$mode = $suspenseentryVO->getMode();
			$hasReturn = false;
			
			if($type == 'OUT'){
				$refSuspenseId = 0;
			}else{
				$refSuspenseId = $suspenseentryVO->getRefSuspenseId();
				$hasReturn = $this->hasReturn($refSuspenseId);
			}
			
			if($hasReturn == false){
				if($stmt = $dbConnection->prepare(ADD_SUSPENSEENTRY_INFO)) {
					$stmt->bind_param('sssssss',$issuerId,$bearerId,$receiverId,$locationId,$mode,$type,$refSuspenseId);
					$result = $stmt->execute();
					if($result == 1){
						$txnId = $dbConnection->insert_id;
						$suspenseentryVO->setSuspenseId($txnId);
						$suspensedetailsDAO = new  SuspensedetailsDAO();					
						$suspensedetailsDAO->addSuspenseDetailsList($dbConnection,$txnId,$refSuspenseId,$suspenseentryVO->getSuspenseDetailList(),$type);
					}else{
						throw new DBException("Problems occured while adding suspense entry. " . $dbConnection->error);
					}
					$stmt->close();
				}
			}else{
				throw new DBException("This suspense entry has already been closed");
			}
			
			$dbConnection->commit();
			$dbConnection->close();
		}catch(Exception $e){
			$dbConnection->rollback();
			throw new DBException($e->getMessage());
		}
		return $suspenseentryVO;
	}

	function modifySuspenseentryVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$suspenseId = $suspenseentryVO->getSuspenseId();
			$date = $suspenseentryVO->getDate();
			$issuerId = $suspenseentryVO->getIssuerId();
			$bearerId = $suspenseentryVO->getBearerId();
			$receiverId = $suspenseentryVO->getReceiverId();
			$locationId = $suspenseentryVO->getLocationId();
			$type = $suspenseentryVO->getType();
			$mode = $suspenseentryVO->getMode();
			$refSuspenseId = $suspenseentryVO->getRefSuspenseId();
			if($stmt = $dbConnection->prepare(MODIFY_SUSPENSEENTRY_INFO)) {
				$stmt->bind_param('sssssssss',$suspenseId,$date,$issuerId,$bearerId,$receiverId,$locationId,$type,$mode,$refSuspenseId);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteSuspenseentry($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(DELETE_SUSPENSEENTRY_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				if($result == 1){
					$suspensedetailsDAO = new  SuspensedetailsDAO();
					$suspensedetailsDAO->deleteSuspensedetailsVO($dbConnection,$id);	
				}
				$stmt->close();
			}
			$dbConnection->commit();
			$dbConnection->close();
		}catch(Exception $e){
			$dbConnection->rollback();
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function getSuspenseBalance(){
		$paymentTypeVO = null;
		try{
			$paymentTypeVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_SUSPENSE_BALANCE)) {
				$fromdate = '2011/04/01';
				$stmt->bind_param('s',$fromdate);
				$stmt->execute();
				$stmt->bind_result($sum,$amount,$paymentmode);
				$paymentTypeVO = new PaymentTypeVO();
				while($stmt->fetch()){
					if($paymentmode == "pg"){
						$paymentTypeVO->setPg($sum);
					}else if($paymentmode == "lpg"){
						$paymentTypeVO->setLpg($sum);
					}else if($paymentmode == "silver"){
						$paymentTypeVO->setSilver($sum);
					}else if($paymentmode == "cash"){
						$paymentTypeVO->setCash($amount);
					} 
				}
				$stmt->close();
			}else{
				throw new DBException("SuspenseDAO :: getSuspenseBalance :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	}
?>