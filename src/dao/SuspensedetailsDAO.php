<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../util/XMLBuilder.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/SuspensedetailsVO.php';
	include_once '../vo/AccountheadVO.php';
	include_once '../dao/PaymentDAO.php';
	include_once '../core/DaybookManager.php';
	include_once '../dao/AccountheadDAO.php';

	class SuspensedetailsDAO {


	function getAllSuspensedetailsVOs(){
		$suspensedetailsVOList =  new CU_Collection('SuspensedetailsVO');
		try{
			$suspensedetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_SUSPENSEDETAILSS)) {
				$stmt->execute();
				$stmt->bind_result($suspensedetailsId,$suspenseId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
				while($stmt->fetch()){
					$suspensedetailsVO = new SuspensedetailsVO();
					$suspensedetailsVO->setSuspensedetailsId($suspensedetailsId);
					$suspensedetailsVO->setSuspenseId($suspenseId);
					$suspensedetailsVO->setGroupId($groupId);
					$suspensedetailsVO->setItemId($itemId);
					$suspensedetailsVO->setSubitemId($subitemId);
					$suspensedetailsVO->setPcs($pcs);
					$suspensedetailsVO->setGwt($gwt);
					$suspensedetailsVO->setNwt($nwt);
					$suspensedetailsVO->setCtpure($ctpure);
					$suspensedetailsVO->setAmount($amount);
					$suspensedetailsVOList->add($suspensedetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $suspensedetailsVOList;
	}
	function getAllSuspensedetailsVOsByQuery($suspenseId,$queryString2){
		$suspensedetailsVOList =  new CU_Collection('SuspensedetailsVO');
		try{
			$suspensedetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($queryString2)) {
				$stmt->bind_param('s',$suspenseId);
				$stmt->execute();
				$stmt->bind_result($suspensedetailsId,$suspenseId,$groupId,$itemId,$subitemId,$pcs,$type,$gwt,$nwt,$ctpure,$amount);
				while($stmt->fetch()){
					$suspensedetailsVO = new SuspensedetailsVO();
					$suspensedetailsVO->setSuspensedetailsId($suspensedetailsId);
					$suspensedetailsVO->setSuspenseId($suspenseId);
					$suspensedetailsVO->setGroupId($groupId);
					$suspensedetailsVO->setItemId($itemId);
					$suspensedetailsVO->setSubitemId($subitemId);
					$suspensedetailsVO->setPcs($pcs);
					$suspensedetailsVO->setType($type);
					$suspensedetailsVO->setGwt($gwt);
					$suspensedetailsVO->setNwt($nwt);
					$suspensedetailsVO->setCtpure($ctpure);
					$suspensedetailsVO->setAmount($amount);
					$suspensedetailsVOList->add($suspensedetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $suspensedetailsVOList;
	}

	function getSuspensedetailsVO($suspenseId){
		try{
			$suspensedetailsVOList =  new CU_Collection('SuspensedetailsVO');
			$suspensedetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_SUSPENSEDETAILS_INFO)) {
				$stmt->bind_param('s',$suspenseId);
				$stmt->execute();
				$stmt->bind_result($suspensedetailsId,$suspenseId,$groupId,$itemId,$subitemId,$pcs,$type,$gwt,$nwt,$ctpure,$amount);
				while($stmt->fetch()){
					$suspensedetailsVO = new SuspensedetailsVO();
					$suspensedetailsVO->setSuspensedetailsId($suspensedetailsId);
					$suspensedetailsVO->setSuspenseId($suspenseId);
					$suspensedetailsVO->setGroupId($groupId);
					$suspensedetailsVO->setItemId($itemId);
					$suspensedetailsVO->setSubitemId($subitemId);
					$suspensedetailsVO->setPcs($pcs);
					$suspensedetailsVO->setType($type);
					$suspensedetailsVO->setGwt($gwt);
					$suspensedetailsVO->setNwt($nwt);
					$suspensedetailsVO->setCtpure($ctpure);
					$suspensedetailsVO->setAmount($amount);
					$suspensedetailsVOList->add($suspensedetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $suspensedetailsVOList;
	}

	function addSuspensedetailsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$suspensedetailsId = $suspensedetailsVO->getSuspensedetailsId();
			$suspenseId = $suspensedetailsVO->getSuspenseId();
			$groupId = $suspensedetailsVO->getGroupId();
			$itemId = $suspensedetailsVO->getItemId();
			$subitemId = $suspensedetailsVO->getSubitemId();
			$pcs = $suspensedetailsVO->getPcs();
			$gwt = $suspensedetailsVO->getGwt();
			$nwt = $suspensedetailsVO->getNwt();
			$ctpure = $suspensedetailsVO->getCtpure();
			$amount = $suspensedetailsVO->getAmount();
			if($stmt = $dbConnection->prepare(ADD_SUSPENSEDETAILS_INFO)) {
				$stmt->bind_param('ssssssssss',$suspensedetailsId,$suspenseId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifySuspensedetailsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$suspensedetailsId = $suspensedetailsVO->getSuspensedetailsId();
			$suspenseId = $suspensedetailsVO->getSuspenseId();
			$groupId = $suspensedetailsVO->getGroupId();
			$itemId = $suspensedetailsVO->getItemId();
			$subitemId = $suspensedetailsVO->getSubitemId();
			$pcs = $suspensedetailsVO->getPcs();
			$gwt = $suspensedetailsVO->getGwt();
			$nwt = $suspensedetailsVO->getNwt();
			$ctpure = $suspensedetailsVO->getCtpure();
			$amount = $suspensedetailsVO->getAmount();
			if($stmt = $dbConnection->prepare(MODIFY_SUSPENSEDETAILS_INFO)) {
				$stmt->bind_param('ssssssssss',$suspensedetailsId,$suspenseId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteSuspensedetailsVO($dbConnection,$id){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(DELETE_SUSPENSEDETAILS_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function addSuspenseDetailsList($dbConnection,$txnId,$refSuspenseId,$suspensedetailsList,$entryType){
		$xmlBuilder = new XMLBuilder();
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(ADD_SUSPENSEDETAILS_INFO)) {
				foreach($suspensedetailsList as $suspensedetailsVO){
					$suspenseId = $txnId;
					$groupId = $suspensedetailsVO->getGroupId();
					$itemId = $suspensedetailsVO->getItemId();
					$subitemId = $suspensedetailsVO->getSubitemId();
					$pcs = $suspensedetailsVO->getPcs();
					$type = $suspensedetailsVO->getType();
					$gwt = $suspensedetailsVO->getGwt();
					$nwt = $suspensedetailsVO->getNwt();
					$stoneloss = $suspensedetailsVO->getStoneLoss();
					$metalloss = $suspensedetailsVO->getMetalLoss();
					$ctpure = $suspensedetailsVO->getCtpure();
					$amount = $suspensedetailsVO->getAmount();					
					$stmt->bind_param('ssssssssss',$suspenseId,$groupId,$itemId,$subitemId,$pcs,$type,$gwt,$nwt,$ctpure,$amount);
					$result = $stmt->execute();
					if($result == 1 && $entryType == "RETURN"){
						if($refSuspenseId != 0 && $type != "cash"){
							//$shortage = $this->getShortage($dbConnection,$refSuspenseId,$subitemId,$type,$nwt,$amount);
							if($stoneloss != 0){
								$accheadDAO = new AccountheadDAO();
								$accheadVO = $accheadDAO->getAccountheadVO("stone loss");
								
								$daybookVO = new DaybookVO();
								$daybookVO->setDate($xmlBuilder->getTodaysDate());
								$daybookVO->setType("outgoing");
								$daybookVO->setCategoryId($accheadVO->getParentChannelId());
								$daybookVO->setAccheadId($accheadVO->getAccheadId());
								$daybookVO->setPg(0);
								$daybookVO->setLpg(0);
								$daybookVO->setSilver(0);
								$daybookVO->setCash(0);
								if($type == "pg"){
									$daybookVO->setPg($stoneloss);
								}else if ($type == "lpg"){
									$daybookVO->setLpg($stoneloss);
								}else if ($type == "silver"){
									$daybookVO->setSilver($stoneloss);
								}
								$daybookVO->setDescription("Stoneloss on Suspense Entry Id : " . $suspenseId);
								$daybookManager = new DaybookManager();
								$daybookVO = $daybookManager->addAccounts($daybookVO);
							}
							if($metalloss != 0){
								$accheadDAO = new AccountheadDAO();
								$accheadVO = $accheadDAO->getAccountheadVO("metal loss");
								
								$daybookVO = new DaybookVO();
								$daybookVO->setDate($xmlBuilder->getTodaysDate());
								$daybookVO->setType("outgoing");
								$daybookVO->setCategoryId($accheadVO->getParentChannelId());
								$daybookVO->setAccheadId($accheadVO->getAccheadId());
								$daybookVO->setPg(0);
								$daybookVO->setLpg(0);
								$daybookVO->setSilver(0);
								$daybookVO->setCash(0);
								if($type == "pg"){
									$daybookVO->setPg($metalloss);
								}else if ($type == "lpg"){
									$daybookVO->setLpg($metalloss);
								}else if ($type == "silver"){
									$daybookVO->setSilver($metalloss);
								}
								$daybookVO->setDescription("Metalloss on Suspense Entry Id : " . $suspenseId);
								$daybookManager = new DaybookManager();
								$daybookVO = $daybookManager->addAccounts($daybookVO);
							}
							
						}
					}
				}
			}else{
				throw new DBException("suspensedetails DAO " . " addsuspensedetails " . $dbConnection->error);
			}
			$stmt->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function getShortage($dbConnection,$refSuspenseId,$subitemId,$newType,$newNwt,$newAmount){
		$shortage = 0;
		try{
			if($stmt = $dbConnection->prepare(GET_SUSPENSEDETAILS_LINEITEM)) {
				$stmt->bind_param('ss',$refSuspenseId,$subitemId);
				$stmt->execute();
				$stmt->bind_result($suspensedetailsId,$suspenseId,$groupId,$itemId,$subitemId,$pcs,$type,$gwt,$nwt,$ctpure,$amount);
				if($stmt->fetch()){
					if($type == "pg" || $type == "lpg"){
						if($newType == $type){
							$shortage = $nwt - $newNwt;
						}else{
							$paymentDAO = new PaymentDAO();
							if($type == "pg"){
								$convertedValue = $paymentDAO->getMetalValue($nwt,"pg","lpg");
								$shortage = $convertedValue - $newNwt;
							}else if($type == "lpg"){
								$convertedValue = $paymentDAO->getMetalValue($nwt,"lpg","pg");
								$shortage = $convertedValue - $newNwt;
							}
						}
					}else if($type == "silver"){
						$shortage = $nwt - $newNwt;
					}
				}else{
					throw new DBException("suspensedetails DAO " . " getShortage " . $dbConnection->error);
				}
			}else{
				throw new DBException("suspensedetails DAO " . " getShortage " . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $shortage;
	}
		
	}
?>


