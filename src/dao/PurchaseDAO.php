<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/PurchaseVO.php';
	include_once '../dao/PurchasedetailsDAO.php';

	class PurchaseDAO {


	function getAllPurchaseVOs(){
		$purchaseVOList =  new CU_Collection();
		try{
			$purchaseVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_PURCHASES)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$billno);
				while($stmt->fetch()){

					$purchaseVO = new PurchaseVO();
					$purchaseVO->setTxnId($txnId);
					$purchaseVO->setDate($date);
					$purchaseVO->setSupplierId($supplierId);
					$purchaseVO->setBillno($billno);
					$purchaseVOList->add($purchaseVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchaseVOList;
	}

	function getPurchase($supplierId,$billno){
		try{
			$purchaseVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PURCHASE_INFO)) {
				$stmt->bind_param('ss',$supplierId,$billno);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$billno);
				if($stmt->fetch()){
					$purchaseVO = new PurchaseVO();
					$purchaseVO->setTxnId($txnId);
					$purchaseVO->setDate($date);
					$purchaseVO->setSupplierId($supplierId);
					$purchaseVO->setBillno($billno);
					$purchasedetailsDAO = new PurchasedetailsDAO();
					$productslist = $purchasedetailsDAO->getPurchasedetailsVO($txnId);
					$purchaseVO->setPurchaseDetailsList($productslist);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchaseVO;
	}
	
	function getPurchaseDetailsByDateRange($fromdate,$todate,$supplierid){
		$purchaseVOList =  new CU_Collection('PurchaseVO');
		$purchaseDetailsList = null;
		try{
			$purchaseVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PURCHASEDETAILS_BY_DATE_RANGE)) {
				$stmt->bind_param('sss',$supplierid,$fromdate,$todate);
				$stmt->execute();
				$stmt->bind_result($date,$supplierId,$billno,$purchasedetailsId,$txnId,$groupId,$itemId,$subitemId,$gwt,$nwt,$ctpure,$maintainMetalAs,$maintainMetalValue,$mc,$maintainMcAs,$maintainMcValue,$paymentDays,$lastPaymentDate);
				while($stmt->fetch()){
					$purchaseVO = new PurchaseVO();
					$purchaseVO->setTxnId($txnId);
					$purchaseVO->setDate($date);
					$purchaseVO->setSupplierId($supplierId);
					$purchaseVO->setBillno($billno);
					
					$purchaseDetailsList = new CU_Collection('PurchasedetailsVO');
					$purchasedetailsVO = new PurchasedetailsVO();
					$purchasedetailsVO->setPurchasedetailsId($purchasedetailsId);
					$purchasedetailsVO->setTxnId($txnId);
					$purchasedetailsVO->setGroupId($groupId);
					$purchasedetailsVO->setItemId($itemId);
					$purchasedetailsVO->setSubitemId($subitemId);
					$purchasedetailsVO->setGwt($gwt);
					$purchasedetailsVO->setNwt($nwt);
					$purchasedetailsVO->setCtpure($ctpure);
					$purchasedetailsVO->setMaintainMetalAs($maintainMetalAs);
					$purchasedetailsVO->setMaintainMetalValue($maintainMetalValue);
					$purchasedetailsVO->setMc($mc);
					$purchasedetailsVO->setMaintainMcAs($maintainMcAs);
					$purchasedetailsVO->setMaintainMcValue($maintainMcValue);
					$purchasedetailsVO->setPaymentDays($paymentDays);
					$purchasedetailsVO->setLastPaymentDate($lastPaymentDate);
					$purchaseDetailsList->add($purchasedetailsVO);
					
					$purchaseVO->setPurchaseDetailsList($purchaseDetailsList);
					
					$purchaseVOList->add($purchaseVO);
				}
				$stmt->close();
			}else{
				throw new DBException("Problems occurred while fetching purchase details.");
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchaseVOList;
	}
	
	function getCompletePurchaseDetailsByDateRange($fromdate,$todate,$supplierid){
		$purchaseVOList =  new CU_Collection('PurchaseVO');
		$purchaseDetailsList = null;
		try{
			$purchaseVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_COMPLETE_PURCHASEDETAILS_BY_DATE_RANGE)) {
				$stmt->bind_param('sss',$supplierid,$fromdate,$todate);
				$stmt->execute();
				$stmt->bind_result($date,$supplierId,$billno,$purchaseDetailsId,$txnId,$groupId,$itemId,$subitemId,$gwt,$nwt,$ctpure,$maintainMetalAs,$maintainMetalValue,$mc,$maintainMcAs,$maintainMcValue,$paymentDays,$lastPaymentDate);
				while($stmt->fetch()){
					$purchaseVO = new PurchaseVO();
					$purchaseVO->setTxnId($txnId);
					$purchaseVO->setDate($date);
					$purchaseVO->setSupplierId($supplierId);
					$purchaseVO->setBillno($billno);
					
					$purchaseDetailsList = new CU_Collection('PurchasedetailsVO');
					$purchasedetailsVO = new PurchasedetailsVO();
					$purchasedetailsVO->setPurchaseDetailsId($purchaseDetailsId);
					$purchasedetailsVO->setTxnId($txnId);
					$purchasedetailsVO->setGroupId($groupId);
					$purchasedetailsVO->setItemId($itemId);
					$purchasedetailsVO->setSubitemId($subitemId);
					$purchasedetailsVO->setGwt($gwt);
					$purchasedetailsVO->setNwt($nwt);
					$purchasedetailsVO->setCtpure($ctpure);
					$purchasedetailsVO->setMaintainMetalAs($maintainMetalAs);
					$purchasedetailsVO->setMaintainMetalValue($maintainMetalValue);
					$purchasedetailsVO->setMc($mc);
					$purchasedetailsVO->setMaintainMcAs($maintainMcAs);
					$purchasedetailsVO->setMaintainMcValue($maintainMcValue);
					$purchasedetailsVO->setPaymentDays($paymentDays);
					$purchasedetailsVO->setLastPaymentDate($lastPaymentDate);
					$purchaseDetailsList->add($purchasedetailsVO);
					
					$purchaseVO->setPurchaseDetailsList($purchaseDetailsList);
					
					$purchaseVOList->add($purchaseVO);
				}
				$stmt->close();
			}else{
				throw new DBException("Problems occurred while fetching purchase details.");
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		
		return $purchaseVOList;
	}
	
	function addPurchase($purchaseVO){
		$result = 0;
		$dbConnection = null;
		try{
			$txnId = $purchaseVO->getTxnId();
			$date = $purchaseVO->getDate();
			$supplierId = $purchaseVO->getSupplierId();
			$billno = "0";
			
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(ADD_PURCHASE_INFO)) {
				$stmt->bind_param('sss',$date,$supplierId,$billno);
				$result = $stmt->execute();
				if($result == 1){
					$txnId = $dbConnection->insert_id;
					$purchaseVO->setTxnId($txnId);
					if($stmt1 = $dbConnection->prepare("update purchase set billno = txn_id where txn_id=" . $dbConnection->insert_id)){
						$result = $stmt1->execute();
						if($result != 1){
							throw new DBException("PurchaseDAO :: addPurchase :: " . $dbConnection->error);
						}
					}
					
					$purchasedetailsDAO = new PurchasedetailsDAO();
					$purchasedetailsDAO->addProductsList($dbConnection,$date, $supplierId,$txnId,$purchaseVO->getPurchaseDetailsList());
				}else{
					throw new DBException("Problems occured while adding purchase. " . $dbConnection->error);
				}
				$dbConnection->commit();
				$stmt->close();
				$stmt1->close();
			}			
		}catch(DBException $e){
			if($dbConnection != null){
				$dbConnection->rollback();
			}
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null)
			$dbConnection->close();
			
		return $purchaseVO;
	}

	function deletePurchase($supplierId,$txnId){
		$result = 0;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(DELETE_PURCHASE_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				if($result == 1){
					$purchasedetailsDAO = new PurchasedetailsDAO();
					$purchasedetailsDAO->deleteProductsList($dbConnection,$supplierId,$txnId);
				}else{
					throw new DBException("Problems occured while deleting purchase. " . $dbConnection->error);
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				throw new DBException("Problems occured while deleting purchase. " . $dbConnection->error);
			}
		}catch(Exception $e){
			$dbConnection->rollback();
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null)
			$dbConnection->close();
		return $result;
	}
	
	function doesBillNoExists($supplierId,$billNo){
		$isDuplicate= false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DOES_BILLNO_EXISTS)) {
				$stmt->bind_param('ss', $supplierId,$billNo);
				$stmt->execute();
				$stmt->store_result();
				$num_rows= $stmt->num_rows; 
				if($num_rows > 0){
					$isDuplicate = true;
				}
				$stmt->close();
			}else{
				throw new DBException("PurchaseDAO :: hasTransaction :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $isDuplicate;
	}
	
	function hasTransaction($subitemId){
		$isDuplicate= false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DOES_SUBITEM_HAS_TRANSACTION)) {
				$stmt->bind_param('s', $subitemId);
				$stmt->execute();
				$stmt->store_result();
				$num_rows= $stmt->num_rows; 
				if($num_rows > 0){
					$isDuplicate = true;
				}
				$stmt->close();
			}else{
				throw new DBException("PurchaseDAO :: hasTransaction :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $isDuplicate;
	}
	
	function getDatewisePurchase($date){
		$purchaseVOList =  new CU_Collection('PurchaseVO');
		try{
			$purchaseVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_DATEWISE_PURCHASE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$billno);
				while($stmt->fetch()){
					$purchaseVO = new PurchaseVO();
					$purchaseVO->setTxnId($txnId);
					$purchaseVO->setDate($date);
					$purchaseVO->setSupplierId($supplierId);
					$purchaseVO->setBillno($billno);
					$purchasedetailsDAO = new PurchasedetailsDAO();
					$productslist = $purchasedetailsDAO->getPurchasedetailsVO($txnId);
					$purchaseVO->setPurchaseDetailsList($productslist);
					$purchaseVOList->add($purchaseVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchaseVOList;
	}
	
	function getAllPurchaseVOsByQueryString($queryString1,$queryString2){
		$purchaseVOList =  new CU_Collection('PurchaseVO');
		try{
			$purchaseVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($queryString1)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$billno);
				while($stmt->fetch()){
					
					$purchaseVO = new PurchaseVO();
					$purchaseVO->setTxnId($txnId);
					$purchaseVO->setDate($date);
					$purchaseVO->setSupplierId($supplierId);
					$purchaseVO->setBillno($billno);
					
					$purchasedetailsDAO = new PurchasedetailsDAO();
					$productslist = $purchasedetailsDAO->getPurchasedetailsVOByQuery($txnId,$queryString2);
					
					$purchaseVO->setPurchaseDetailsList($productslist);
					$purchaseVOList->add($purchaseVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchaseVOList;
	}
	
}
?>