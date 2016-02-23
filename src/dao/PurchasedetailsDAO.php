<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/PurchasedetailsVO.php';
	include_once '../dao/RateDAO.php';
	include_once '../dao/SupplierDAO.php';

	class PurchasedetailsDAO {


	function getAllPurchasedetailsVOs(){
		$purchasedetailsVOList =  new CU_Collection();
		try{
			$purchasedetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_PURCHASEDETAILSS)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$groupId,$itemId,$subitemId,$gwt,$nwt,$ctpure,$maintainMetalAs,$maintainMetalValue,$maintainMcAs,$maintainMcValue,$paymentDays,$lastPaymentDate);
				while($stmt->fetch()){
					$purchasedetailsVO = new PurchasedetailsVO();
					$purchasedetailsVO->setTxnId($txnId);
					$purchasedetailsVO->setGroupId($groupId);
					$purchasedetailsVO->setItemId($itemId);
					$purchasedetailsVO->setSubitemId($subitemId);
					$purchasedetailsVO->setGwt($gwt);
					$purchasedetailsVO->setNwt($nwt);
					$purchasedetailsVO->setCtpure($ctpure);
					$purchasedetailsVO->setMaintainMetalAs($maintainMetalAs);
					$purchasedetailsVO->setMaintainMetalValue($maintainMetalValue);
					$purchasedetailsVO->setMaintainMcAs($maintainMcAs);
					$purchasedetailsVO->setMaintainMcValue($maintainMcValue);
					$purchasedetailsVO->setPaymentDays($paymentDays);
					$purchasedetailsVO->setLastPaymentDate($lastPaymentDate);
					$purchasedetailsVOList->add($purchasedetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchasedetailsVOList;
	}

	function getPurchasedetailsVO($txnId){
		try{
			$purchasedetailsVOList =  new CU_Collection('PurchasedetailsVO');
			$purchasedetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PURCHASEDETAILS_INFO)) {
				$stmt->bind_param('s',$txnId);
				$stmt->execute();
				$stmt->bind_result($purchasedetailsid,$txnId,$groupId,$itemId,$subitemId,$gwt,$nwt,$ctpure,$maintainMetalAs,$maintainMetalValue,$mc,$maintainMcAs,$maintainMcValue,$paymentDays,$lastPaymentDate);
				while($stmt->fetch()){
					$purchasedetailsVO = new PurchasedetailsVO();
					$purchasedetailsVO->setPurchasedetailsId($purchasedetailsid);
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
					$purchasedetailsVOList->add($purchasedetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchasedetailsVOList;
	}
	
	function getPurchasedetailsVOByQuery($txnId,$queryString2){
		try{
			$purchasedetailsVOList =  new CU_Collection('PurchasedetailsVO');
			$purchasedetailsVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($queryString2)) {
				$stmt->bind_param('s',$txnId);
				$stmt->execute();
				$stmt->bind_result($purchaseDetailsId,$txnId,$groupId,$itemId,$subitemId,$gwt,$nwt,$ctpure,$maintainMetalAs,$maintainMetalValue,$mc,$maintainMcAs,$maintainMcValue,$paymentDays,$lastPaymentDate);
				while($stmt->fetch()){
					$purchasedetailsVO = new PurchasedetailsVO();
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
					$purchasedetailsVOList->add($purchasedetailsVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $purchasedetailsVOList;
	}
	
	function updatePurchaseDetailsByPurchaseDetailId($productsList,$date){
		$result = 0;
		$dbConnection = DBUtil::getTxnConnection();
		try{
			if($stmt = $dbConnection->prepare(MODIFY_PURCHASEDETAILS_BY_PURCHASEDETAILID)) {
				foreach($productsList as $purchasedetailsVO){
					$purchasedetailsId = $purchasedetailsVO->getPurchasedetailsId();
					$paymentDays = $purchasedetailsVO->getPaymentDays();
					$lastPaymentDate = $this->getLastPaymentDate($date,$paymentDays);
					$stmt->bind_param('sss',$paymentDays,$lastPaymentDate,$purchasedetailsId);
					$result = $stmt->execute();
					if($result != 1){
						throw new DBException("Problems updating detail line items" . $dbConnection->error);
					}else{
//						//$purchaseDetailsId = $dbConnection->insert_id;
//						//$purchasedetailsVO->setPurchasedetailsId($purchaseDetailsId);
//						$supplierDAO = new SupplierDAO();
//						$supplierDAO->updateSupplierAssets($dbConnection,$maintainMetalAs,$maintainMetalValue,"+",$supplierId);
//						$supplierDAO->updateSupplierAssets($dbConnection,$maintainMcAs,$maintainMcValue,"+",$supplierId);
					}
				}
				$stmt->close();
				$dbConnection->commit();
			}else{
				$dbConnection->rollback();
				throw new DBException("Problems updating line items" . $dbConnection->error);
			}
			
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		
		if($dbConnection != null){
			$dbConnection->close();
		}
		return $result;
	}
	function addProductsList($dbConnection,$date,$supplierId,$txnId,$productsList){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(ADD_PURCHASEDETAILS_INFO)) {
				foreach($productsList as $purchasedetailsVO){
					$groupId = $purchasedetailsVO->getGroupId();
					$itemId = $purchasedetailsVO->getItemId();
					$subitemId = $purchasedetailsVO->getSubitemId();
					$gwt = $purchasedetailsVO->getGwt();
					$nwt = $purchasedetailsVO->getNwt();
					$ctpure = $purchasedetailsVO->getCtpure();
					$maintainMetalAs = $purchasedetailsVO->getMaintainMetalAs();
					$maintainMetalValue = $purchasedetailsVO->getCtpure();
					$maintainMcAs = $purchasedetailsVO->getMaintainMcAs();
					$mc = $purchasedetailsVO->getMc();
					$paymentDays = $purchasedetailsVO->getPaymentDays();
					
					$lastPaymentDate = $this->getLastPaymentDate($date,$paymentDays);
					
					$maintainMetalValue = $this->getMetalValue($ctpure,$maintainMetalAs);
					$maintainMcValue = $this->getMCValue($mc,$maintainMcAs);
					
					$stmt->bind_param('ssssssssssssss',$txnId,$groupId,$itemId,$subitemId,$gwt,$nwt,$ctpure,$maintainMetalAs,$maintainMetalValue,$mc,$maintainMcAs,$maintainMcValue,$paymentDays,$lastPaymentDate);
					$result = $stmt->execute();
					if($result != 1){
						throw new DBException("Problems updating line items" . $dbConnection->error);
					}else{
						//$purchaseDetailsId = $dbConnection->insert_id;
						//$purchasedetailsVO->setPurchasedetailsId($purchaseDetailsId);
						$supplierDAO = new SupplierDAO();
						$supplierDAO->updateSupplierAssets($dbConnection,$maintainMetalAs,$maintainMetalValue,"+",$supplierId);
						$supplierDAO->updateSupplierAssets($dbConnection,$maintainMcAs,$maintainMcValue,"+",$supplierId);
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

	function deleteProductsList($dbConnection, $supplierId,$txnId){
		$supplierDAO = new SupplierDAO();
		try{
			$productsList = $this->getPurchasedetailsVO($txnId);
			foreach($productsList as $purchasedetailsVO){
				$maintainMetalAs = $purchasedetailsVO->getMaintainMetalAs();
				$maintainMetalValue = $purchasedetailsVO->getCtpure();
				$maintainMcAs = $purchasedetailsVO->getMaintainMcAs();
				$maintainMcValue = $purchasedetailsVO->getMaintainMcValue();
					$supplierDAO->updateSupplierAssets($dbConnection,$maintainMetalAs,$maintainMetalValue,"-",$supplierId);
					$supplierDAO->updateSupplierAssets($dbConnection,$maintainMcAs,$maintainMcValue,"-",$supplierId);
			}
			$this->deletePurchasedetailsVO($dbConnection,$txnId);
		}catch(DBException $e){
			throw $e;
		}
	}

	function deletePurchasedetailsVO($dbConnection,$txnId){
		$result = false;
		try{
			if($stmt = $dbConnection->prepare(DELETE_PURCHASEDETAILS_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				if($result != 1){
					throw new DBException("Problems occured deleting line items" . $dbConncetion->error);
				}
				$stmt->close();
			}else{
				throw new DBException("Problems occured deleting line items" . $dbConncetion->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function getLastPaymentDate($fromdate,$paymentDays){
		$date = new DateTime($fromdate);
		date_add($date, new DateInterval("P".$paymentDays."D"));
		return $date->format("Y-m-d");
	}
	
	function getMetalValue($ctpure,$maintainMetalAs){
		$value = 0;
		
		if($maintainMetalAs == "pg"){
			$value = $ctpure;
		}else if($maintainMetalAs == "lpg"){
			$value = ($ctpure * 0.916);
		}else if($maintainMetalAs == "cash"){
			$rateDAO = new RateDAO();
			$pgRate = $rateDAO->getRateByMetalType("pure gold");
			$pgRateg = $pgRate / 116.64;
			$value = $ctpure * $pgRateg;
		}else if($maintainMetalAs == "silver"){
			$rateDAO = new RateDAO();
			$pgRate = $rateDAO->getRateByMetalType("pure gold");
			$pgRateg = $pgRate / 116.64;
			$pgcashValue = $ctpure * $pgRateg;
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$silverkg = $pgcashValue/$silverRate;
			$value = $silverkg;
		}
		return $value;
	}
	function getMCValue($cash,$maintainMCAs){
		$value = 0;
		if($maintainMCAs == "cash"){
			$value = $cash;
		}else if($maintainMCAs == "lpg"){
			$rateDAO = new RateDAO();
			$lpgRate = $rateDAO->getRateByMetalType("less pure gold");
			$lpgRateg = $lpgRate / 116.64;
			$value = ($cash/$lpgRateg);
		}else if($maintainMCAs == "pg"){
			$rateDAO = new RateDAO();
			$pgRate = $rateDAO->getRateByMetalType("pure gold");
			$pgRateg = $pgRate / 116.64;
			$value = ($cash/$pgRateg);
		}else if($maintainMCAs == "silver"){
			$rateDAO = new RateDAO();
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$value = ($cash/$silverRate);
		}
		return $value;
	}
	
	function getMcValueByDateRange($supplierId,$todate){
		$paymentTypeVO = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PURCHASE_MC_VALUES_BY_DATE_RANGE)) {
				$stmt->bind_param('ss',$supplierId,$todate);
				$stmt->execute();
				$stmt->bind_result($sum,$paymentmode);
				$paymentTypeVO = new PaymentTypeVO();
				while($stmt->fetch()){
					if($paymentmode == "pg"){
						$paymentTypeVO->setPg($sum);
					}else if($paymentmode == "lpg"){
						$paymentTypeVO->setLpg($sum);
					}else if($paymentmode == "silver"){
						$paymentTypeVO->setSilver($sum);
					}else if($paymentmode == "cash"){
						$paymentTypeVO->setCash($sum);
					} 
				}
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getMcValueByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getMetalValueByDateRange($supplierId,$todate){
		$paymentTypeVO = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PURCHASE_METAL_VALUES_BY_DATE_RANGE)) {
				$stmt->bind_param('ss',$supplierId,$todate);
				$stmt->execute();
				$stmt->bind_result($sum,$paymentmode);
				$paymentTypeVO = new PaymentTypeVO();
				while($stmt->fetch()){
					if($paymentmode == "pg"){
						$paymentTypeVO->setPg($sum);
					}else if($paymentmode == "lpg"){
						$paymentTypeVO->setLpg($sum);
					}else if($paymentmode == "silver"){
						$paymentTypeVO->setSilver($sum);
					}else if($paymentmode == "cash"){
						$paymentTypeVO->setCash($sum);
					} 
				}
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getMcValueByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	function getCompleteMcValueByDateRange($supplierId,$todate){
		$paymentTypeVO = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_COMPLETE_PURCHASE_MC_VALUES_BY_DATE)) {
				$stmt->bind_param('ss',$supplierId,$todate);
				$stmt->execute();
				$stmt->bind_result($sum,$paymentmode);
				$paymentTypeVO = new PaymentTypeVO();
				while($stmt->fetch()){
					if($paymentmode == "pg"){
						$paymentTypeVO->setPg($sum);
					}else if($paymentmode == "lpg"){
						$paymentTypeVO->setLpg($sum);
					}else if($paymentmode == "silver"){
						$paymentTypeVO->setSilver($sum);
					}else if($paymentmode == "cash"){
						$paymentTypeVO->setCash($sum);
					} 
				}
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getMcValueByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getCompleteMetalValueByDateRange($supplierId,$todate){
		$paymentTypeVO = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_COMPLETE_PURCHASE_METAL_VALUES_BY_DATE)) {
				$stmt->bind_param('ss',$supplierId,$todate);
				$stmt->execute();
				$stmt->bind_result($sum,$paymentmode);
				$paymentTypeVO = new PaymentTypeVO();
				while($stmt->fetch()){
					if($paymentmode == "pg"){
						$paymentTypeVO->setPg($sum);
					}else if($paymentmode == "lpg"){
						$paymentTypeVO->setLpg($sum);
					}else if($paymentmode == "silver"){
						$paymentTypeVO->setSilver($sum);
					}else if($paymentmode == "cash"){
						$paymentTypeVO->setCash($sum);
					} 
				}
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getMcValueByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getCurrentMcValueByDateRange($supplierId,$todate){
		$paymentTypeVO = null;
		$pg=0;
		$lpg=0;
		$silver=0;
		$cash=0;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_CURRENT_PURCHASE_MC_VALUES_BY_DATE_RANGE)) {
				$stmt->bind_param('sss',$supplierId,$todate,$todate);
				$stmt->execute();
				$stmt->bind_result($date,$metalValue,$paymentmode,$noOfDays);
				$paymentTypeVO = new PaymentTypeVO();
				$valuePerDay = 0;
				$value = 0;
				while($stmt->fetch()){
					
					$valuePerDay = $metalValue / $noOfDays;
					//echo '$valuePerDay->' . $valuePerDay;
					$dateDiff = $this->dateDiff("-",$todate,$date);
					//echo '$dateDiff' . $dateDiff;
					$value = $valuePerDay * $dateDiff;
					//echo '$value' . $value;
					
					if($paymentmode == "pg"){
						$pg = $pg + $value;
					}else if($paymentmode == "lpg"){
						$lpg = $lpg + $value;
					}else if($paymentmode == "silver"){
						$silver = $silver + $value;
					}else if($paymentmode == "cash"){
						$cash = $cash + $value;
					} 
				}
				$paymentTypeVO->setPg($pg);
				$paymentTypeVO->setLpg($lpg);
				$paymentTypeVO->setSilver($silver);
				$paymentTypeVO->setCash($cash);
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getMcValueByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	function getCurrentMcValueByDate($supplierId,$date){
		$paymentTypeVO = null;
		$pg=0;
		$lpg=0;
		$silver=0;
		$cash=0;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_CURRENT_PURCHASE_MC_VALUES_BY_DATE)) {
				$stmt->bind_param('ss',$supplierId,$date);
				$stmt->execute();
				$stmt->bind_result($date,$metalValue,$paymentmode,$noOfDays);
				$paymentTypeVO = new PaymentTypeVO();
				$valuePerDay = 0;
				$value = 0;
				while($stmt->fetch()){
					
					$valuePerDay = $metalValue / $noOfDays;
					
					if($paymentmode == "pg"){
						$pg = $pg + $valuePerDay;
					}else if($paymentmode == "lpg"){
						$lpg = $lpg + $valuePerDay;
					}else if($paymentmode == "silver"){
						$silver = $silver + $valuePerDay;
					}else if($paymentmode == "cash"){
						$cash = $cash + $valuePerDay;
					} 
				}
				$paymentTypeVO->setPg($pg);
				$paymentTypeVO->setLpg($lpg);
				$paymentTypeVO->setSilver($silver);
				$paymentTypeVO->setCash($cash);
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getMcValueByDate:: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getCurrentMetalValueByDateRange($supplierId,$todate){
		$paymentTypeVO = null;
		$pg=0;
		$lpg=0;
		$silver=0;
		$cash=0;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_CURRENT_PURCHASE_METAL_VALUES_BY_DATE_RANGE)) {
				$stmt->bind_param('sss',$supplierId,$todate,$todate);
				$stmt->execute();
				$stmt->bind_result($date,$metalValue,$paymentmode,$noOfDays);
				$paymentTypeVO = new PaymentTypeVO();
				$valuePerDay = 0;
				$value = 0;
				while($stmt->fetch()){
					
					$valuePerDay = $metalValue / $noOfDays;
					//echo '$valuePerDay->' . $valuePerDay;
					$dateDiff = $this->dateDiff("-",$todate,$date);
					//echo '$dateDiff' . $dateDiff;
					$value = $valuePerDay * $dateDiff;
					//echo '$value' . $value;
					
					if($paymentmode == "pg"){
						$pg = $pg + $value;
					}else if($paymentmode == "lpg"){
						$lpg = $lpg + $value;
					}else if($paymentmode == "silver"){
						$silver = $silver + $value;
					}else if($paymentmode == "cash"){
						$cash = $cash + $value;
					} 
				}
				$paymentTypeVO->setPg($pg);
				$paymentTypeVO->setLpg($lpg);
				$paymentTypeVO->setSilver($silver);
				$paymentTypeVO->setCash($cash);
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getMcValueByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getCurrentMetalValueByDate($supplierId,$date){
		$paymentTypeVO = null;
		$pg=0;
		$lpg=0;
		$silver=0;
		$cash=0;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_CURRENT_PURCHASE_METAL_VALUES_BY_DATE)) {
				$stmt->bind_param('ss',$supplierId,$date);
				$stmt->execute();
				$stmt->bind_result($date,$metalValue,$paymentmode,$noOfDays);
				$paymentTypeVO = new PaymentTypeVO();
				$valuePerDay = 0;
				$value = 0;
				while($stmt->fetch()){
					
					$valuePerDay = $metalValue / $noOfDays;
					
					if($paymentmode == "pg"){
						$pg = $pg + $valuePerDay;
					}else if($paymentmode == "lpg"){
						$lpg = $lpg + $valuePerDay;
					}else if($paymentmode == "silver"){
						$silver = $silver + $valuePerDay;
					}else if($paymentmode == "cash"){
						$cash = $cash + $valuePerDay;
					} 
				}
				$paymentTypeVO->setPg($pg);
				$paymentTypeVO->setLpg($lpg);
				$paymentTypeVO->setSilver($silver);
				$paymentTypeVO->setCash($cash);
				$stmt->close();
			}else{
				throw new DBException("PurchaseDetailsDAO :: getCurrentMetalValueByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function dateDiff($dformat, $endDate, $beginDate){
		$date_parts1=explode($dformat, $beginDate);
	    $date_parts2=explode($dformat, $endDate);
	    $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
	    $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
	    return $end_date - $start_date;
	}
}

?>