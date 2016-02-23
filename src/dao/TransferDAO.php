<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/TransferVO.php';
	include_once '../dao/SupplierDAO.php';

	class TransferDAO {

	function getAllTransfers(){
		$transferVOList =  new CU_Collection('TransferVO');
		try{
			$transferVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_TRANSFERS)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$fromType,$fromAmount,$toType,$toAmount,$description);
				while($stmt->fetch()){
					$transferVO = new TransferVO();
					$transferVO->setTxnId($txnId);
					$transferVO->setDate($date);
					$transferVO->setSupplierId($supplierId);
					$transferVO->setFromType($fromType);
					$transferVO->setFromAmount($fromAmount);
					$transferVO->setToType($toType);
					$transferVO->setToAmount($toAmount);
					$transferVO->setDescription($description);
					$transferVOList->add($transferVO);
				}
				$stmt->close();
			}else{
				throw new DBException("TransferDAO :: getAllTransferVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $transferVOList;
	}
	
	function getDaywiseTransfers($date){
		$transferVOList =  new CU_Collection('TransferVO');
		try{
			$transferVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_TRANSFERS_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$fromType,$fromAmount,$toType,$toAmount,$description);
				while($stmt->fetch()){
					$transferVO = new TransferVO();
					$transferVO->setTxnId($txnId);
					$transferVO->setDate($date);
					$transferVO->setSupplierId($supplierId);
					$transferVO->setFromType($fromType);
					$transferVO->setFromAmount($fromAmount);
					$transferVO->setToType($toType);
					$transferVO->setToAmount($toAmount);
					$transferVO->setDescription($description);
					$transferVOList->add($transferVO);
				}
				$stmt->close();
			}else{
				throw new DBException("TransferDAO :: getDaywiseTransfers :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $transferVOList;
	}

	function getTransfersById($txnId){
		try{
			$transferVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_TRANSFER_BY_ID)) {
				$stmt->bind_param('s',$txnId);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$fromType,$fromAmount,$toType,$toAmount,$description);
				if($stmt->fetch()){
					$transferVO = new TransferVO();
					$transferVO->setTxnId($txnId);
					$transferVO->setDate($date);
					$transferVO->setSupplierId($supplierId);
					$transferVO->setFromType($fromType);
					$transferVO->setFromAmount($fromAmount);
					$transferVO->setToType($toType);
					$transferVO->setToAmount($toAmount);
					$transferVO->setDescription($description);
				}
				$stmt->close();
			}else{
				throw new DBException("TransferDAO :: getTransfersById :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $transferVO;
	}

	function addTransfer($transferVO){
		$result = 0;
		$dbConnection = null;
		try{
			$date = $transferVO->getDate();
			$supplierId = $transferVO->getSupplierId();
			$fromType = $transferVO->getFromType();
			$fromAmount = $transferVO->getFromAmount();
			$toType = $transferVO->getToType();
			$toAmount = $transferVO->getToAmount();
			$description = $transferVO->getDescription();
			
			$supplierDAO = new SupplierDAO();
			$supplierVO = $supplierDAO->getSupplierVO($supplierId);
		
			if($this->hasBalance($supplierVO,$fromType,$fromAmount) == true){
				$dbConnection = DBUtil::getTxnConnection();
				if($stmt = $dbConnection->prepare(ADD_TRANSFER_INFO)) {
					$stmt->bind_param('sssssss',$date,$supplierId,$fromType,$fromAmount,$toType,$toAmount,$description);
					$result = $stmt->execute();
					if($result == 1){
						$supplierDAO->transferSupplierAssets($dbConnection,$fromType,$fromAmount,$toType,$toAmount,$supplierId,"add");
					}
					$dbConnection->commit();
					$stmt->close();
				}else{
					throw new DBException("TransferDAO :: addTransferVO :: " . $dbConnection->error);
				}
			}else{
				if($dbConnection != null){
					$dbConnection->rollback();
				}
				throw new DBException("The From value specified is more than the current balance in supplier's account");
			}
			
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null){
			$dbConnection->close();
		}
		return $result;
	}

	function deleteTransfers($transferVO){
		$result = false;
		try{
			$txnId = $transferVO->getTxnId();
			$supplierId = $transferVO->getSupplierId();
			$fromType = $transferVO->getFromType();
			$fromAmount = $transferVO->getFromAmount();
			$toType = $transferVO->getToType();
			$toAmount = $transferVO->getToAmount();
			$description = $transferVO->getDescription();
			
			$dbConnection = DBUtil::getTxnConnection();
			$supplierDAO = new SupplierDAO();
			if($stmt = $dbConnection->prepare(DELETE_TRANSFER_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				if($result == 1){
					$supplierDAO->transferSupplierAssets($dbConnection,$fromType,$fromAmount,$toType,$toAmount,$supplierId,"delete");
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				throw new DBException("TransferDAO :: deleteTransferVO :: " . $dbConnection->error);
			}
		}catch(Exception $e){
			if($dbConnection != null){
				$dbConnection->rollback();
			}
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null){
			$dbConnection->close();
		}
		return $result;
	}
	
	function hasBalance($supplierVO,$convertType,$convertValue){
		$hasBalance = false;
		
		$currentClosing = 0;
		if($convertType == "pg"){
			$currentClosing = $supplierVO->getClPg();
		}else if($convertType == "lpg"){
			$currentClosing = $supplierVO->getClLpg();
		}else if($convertType == "silver"){
			$currentClosing = $supplierVO->getClSilver();
		}else if($convertType == "cash"){
			$currentClosing = $supplierVO->getClCash();
		}
		
		if($currentClosing >= $convertValue){
			$hasBalance = true;
		}
		
		return $hasBalance;
	}
	
}
?>