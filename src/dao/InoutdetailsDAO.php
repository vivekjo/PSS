<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/InoutdetailsVO.php';

	class InoutdetailsDAO {

	function getAllInoutdetailsVOs(){
		$inoutdetailsVOList =  new CU_Collection();
		try{
			$inoutdetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_INOUTDETAILS)) {
				$stmt->execute();
				$stmt->bind_result($inoutdetailsId,$inoutId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
				while($stmt->fetch()){

					$inoutdetailsVO = new InoutdetailsVO();
					$inoutdetailsVO->setInoutdetailsId($inoutdetailsId);
					$inoutdetailsVO->setInoutId($inoutId);
					$inoutdetailsVO->setGroupId($groupId);
					$inoutdetailsVO->setItemId($itemId);
					$inoutdetailsVO->setSubitemId($subitemId);
					$inoutdetailsVO->setPcs($pcs);
					$inoutdetailsVO->setGwt($gwt);
					$inoutdetailsVO->setNwt($nwt);
					$inoutdetailsVO->setCtpure($ctpure);
					$inoutdetailsVO->setAmount($amount);
					$inoutdetailsVOList->add($inoutdetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutdetailsVOList;
	}

	function getInoutdetailsList($inoutId){
		try{
			$inoutdetailsList = new CU_Collection('InoutdetailsVO');
			$inoutdetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_INOUTDETAILS_INFO)) {
				$stmt->bind_param('s',$inoutId);
				$stmt->execute();
				$stmt->bind_result($inoutdetailsId,$inoutId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
				while($stmt->fetch()){
					$inoutdetailsVO = new InoutdetailsVO();
					$inoutdetailsVO->setInoutdetailsId($inoutdetailsId);
					$inoutdetailsVO->setInoutId($inoutId);
					$inoutdetailsVO->setGroupId($groupId);
					$inoutdetailsVO->setItemId($itemId);
					$inoutdetailsVO->setSubitemId($subitemId);
					$inoutdetailsVO->setPcs($pcs);
					$inoutdetailsVO->setGwt($gwt);
					$inoutdetailsVO->setNwt($nwt);
					$inoutdetailsVO->setCtpure($ctpure);
					$inoutdetailsVO->setAmount($amount);
					$inoutdetailsList->add($inoutdetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutdetailsList;
	}
	function getInoutdetailsVOByQuery($inoutId,$queryString2){
		try{
			$inoutdetailsVOList =  new CU_Collection('InoutdetailsVO');
			$inoutdetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($queryString2)) {
				$stmt->bind_param('s',$inoutId);
				$stmt->execute();
				$stmt->bind_result($inoutdetailsId,$inoutId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
				while($stmt->fetch()){

					$inoutdetailsVO = new InoutdetailsVO();
					$inoutdetailsVO->setInoutdetailsId($inoutdetailsId);
					$inoutdetailsVO->setInoutId($inoutId);
					$inoutdetailsVO->setGroupId($groupId);
					$inoutdetailsVO->setItemId($itemId);
					$inoutdetailsVO->setSubitemId($subitemId);
					$inoutdetailsVO->setPcs($pcs);
					$inoutdetailsVO->setGwt($gwt);
					$inoutdetailsVO->setNwt($nwt);
					$inoutdetailsVO->setCtpure($ctpure);
					$inoutdetailsVO->setAmount($amount);
					$inoutdetailsVOList->add($inoutdetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $inoutdetailsVOList;
	}

	function addInoutDetailsList($dbConnection,$txnId,$inoutdetailsList){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(ADD_INOUTDETAILS_INFO)) {
				foreach($inoutdetailsList as $inoutdetailsVO){
					$inoutId = $txnId;
					$groupId = $inoutdetailsVO->getGroupId();
					$itemId = $inoutdetailsVO->getItemId();
					$subitemId = $inoutdetailsVO->getSubitemId();
					$pcs = $inoutdetailsVO->getPcs();
					$gwt = $inoutdetailsVO->getGwt();
					$nwt = $inoutdetailsVO->getNwt();
					$ctpure = $inoutdetailsVO->getCtpure();
					$amount = $inoutdetailsVO->getAmount();
					
					$stmt->bind_param('sssssssss',$inoutId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
					$result = $stmt->execute();
				}
				$stmt->close();
			}else{
				throw new DBException("Inoutdetails DAO " . " addInoutdetails " . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifyInoutdetailsVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$inoutdetailsId = $inoutdetailsVO->getInoutdetailsId();
			$inoutId = $inoutdetailsVO->getInoutId();
			$groupId = $inoutdetailsVO->getGroupId();
			$itemId = $inoutdetailsVO->getItemId();
			$subitemId = $inoutdetailsVO->getSubitemId();
			$pcs = $inoutdetailsVO->getPcs();
			$gwt = $inoutdetailsVO->getGwt();
			$nwt = $inoutdetailsVO->getNwt();
			$ctpure = $inoutdetailsVO->getCtpure();
			$amount = $inoutdetailsVO->getAmount();
			if($stmt = $dbConnection->prepare(MODIFY_INOUTDETAILS_INFO)) {
				$stmt->bind_param('ssssssssss',$inoutdetailsId,$inoutId,$groupId,$itemId,$subitemId,$pcs,$gwt,$nwt,$ctpure,$amount);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteInoutDetailsList($dbConnection,$txnId){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(DELETE_INOUTDETAILS_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				$stmt->close();
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
}
?>