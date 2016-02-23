<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/PaymentVO.php';
	include_once '../dao/CompanyDAO.php';
	include_once '../dao/SupplierDAO.php';
	include_once '../dao/RateDAO.php';

	class PaymentDAO {

	function getAllPaymentVOs(){
		$paymentVOList =  new CU_Collection();
		try{
			$paymentVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_PAYMENTS)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustAmount,$description);
				while($stmt->fetch()){
					$paymentVO = new PaymentVO();
					$paymentVO->setTxnId($txnId);
					$paymentVO->setDate($date);
					$paymentVO->setSupplierId($supplierId);
					$paymentVO->setVoucherNo($voucherNo);
					$paymentVO->setPaymentMode($paymentMode);
					$paymentVO->setAmount($amount);
					$paymentVO->setAdjustWith($adjustWith);
					$paymentVO->setAdjustAmount($adjustAmount);
					$paymentVO->setDescription($description);
					$paymentVOList->add($paymentVO);
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getAllPaymentVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentVOList;
	}
	
	function getAllPaymentVOsByQuery($queryString){
		$paymentVOList =  new CU_Collection('PaymentVO');
		try{
			$paymentVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($queryString)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustAmount,$description);
				while($stmt->fetch()){
					$paymentVO = new PaymentVO();
					$paymentVO->setTxnId($txnId);
					$paymentVO->setDate($date);
					$paymentVO->setSupplierId($supplierId);
					$paymentVO->setVoucherNo($voucherNo);
					$paymentVO->setPaymentMode($paymentMode);
					$paymentVO->setAmount($amount);
					$paymentVO->setAdjustWith($adjustWith);
					$paymentVO->setAdjustAmount($adjustAmount);
					$paymentVO->setDescription($description);
					$paymentVOList->add($paymentVO);
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getAllPaymentVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentVOList;
	}
	
	function getDaywisePayment($date){
		$paymentVOList =  new CU_Collection('PaymentVO');
		try{
			$paymentVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_DAYWISE_PAYMENTS)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustAmount,$description);
				while($stmt->fetch()){
					$paymentVO = new PaymentVO();
					$paymentVO->setTxnId($txnId);
					$paymentVO->setDate($date);
					$paymentVO->setSupplierId($supplierId);
					$paymentVO->setVoucherNo($voucherNo);
					$paymentVO->setPaymentMode($paymentMode);
					$paymentVO->setAmount($amount);
					$paymentVO->setAdjustWith($adjustWith);
					$paymentVO->setAdjustAmount($adjustAmount);
					$paymentVO->setDescription($description);
					$paymentVOList->add($paymentVO);
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getDaywisePayment :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentVOList;
	}
	
	function getPaymentDetailsByDateRange($fromdate,$todate,$supplierid){
		$paymentVOList =  new CU_Collection('PaymentVO');
		try{
			$paymentVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PAYMENT_DETAILS_BY_DATE_RANGE)) {
				$stmt->bind_param('sss',$supplierid,$fromdate,$todate);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustAmount,$description);
				while($stmt->fetch()){
					$paymentVO = new PaymentVO();
					$paymentVO->setTxnId($txnId);
					$paymentVO->setDate($date);
					$paymentVO->setSupplierId($supplierId);
					$paymentVO->setVoucherNo($voucherNo);
					$paymentVO->setPaymentMode($paymentMode);
					$paymentVO->setAmount($amount);
					$paymentVO->setAdjustWith($adjustWith);
					$paymentVO->setAdjustAmount($adjustAmount);
					$paymentVO->setDescription($description);
					$paymentVOList->add($paymentVO);
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getPaymentDetailsByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		
		return $paymentVOList;
	}
	
	function getPaymentsByDateRange($fromdate,$todate){
		$paymentTypeVO = null;
		try{
			$paymentTypeVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PAYMENTS_BY_DATE_RANGE)) {
				$stmt->bind_param('ss',$fromdate,$todate);
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
				throw new DBException("PaymentDAO :: getPaymentsByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getSupplierPaymentsByDateRange($fromdate,$todate,$supplierId){
		$paymentTypeVO = null;
		try{
			$paymentTypeVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_SUPPLIER_PAYMENTS_BY_DATE_RANGE)) {
				$stmt->bind_param('sss',$supplierId,$fromdate,$todate);
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
				throw new DBException("PaymentDAO :: getPaymentsByDateRange :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}

	function getPaymentVO(){
		try{
			$paymentVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PAYMENT_INFO)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustAmount,$description);
				if($stmt->fetch()){
					$paymentVO = new PaymentVO();
					$paymentVO->setTxnId($txnId);
					$paymentVO->setDate($date);
					$paymentVO->setSupplierId($supplierId);
					$paymentVO->setVoucherNo($voucherNo);
					$paymentVO->setPaymentMode($paymentMode);
					$paymentVO->setAmount($amount);
					$paymentVO->setAdjustWith($adjustWith);
					$paymentVO->setAdjustAmount($adjustAmount);
					$paymentVO->setDescription($description);
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getPaymentVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentVO;
	}
	
	function getPaymentById($txnId){
		try{
			$paymentVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PAYMENT_BY_ID)) {
				$stmt->bind_param('s',$txnId);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustAmount,$description);
				if($stmt->fetch()){
					$paymentVO = new PaymentVO();
					$paymentVO->setTxnId($txnId);
					$paymentVO->setDate($date);
					$paymentVO->setSupplierId($supplierId);
					$paymentVO->setVoucherNo($voucherNo);
					$paymentVO->setPaymentMode($paymentMode);
					$paymentVO->setAmount($amount);
					$paymentVO->setAdjustWith($adjustWith);
					$paymentVO->setAdjustAmount($adjustAmount);
					$paymentVO->setDescription($description);
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getPaymentById :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentVO;
	}

	function addPayment($paymentVO){
		$result = 0;
		$dbConnection = null;
		try{
			$date = $paymentVO->getDate();
			$supplierId = $paymentVO->getSupplierId();
			$voucherNo = "0";
			$paymentMode = $paymentVO->getPaymentMode();
			$amount = $paymentVO->getAmount();
			$adjustWith = $paymentVO->getAdjustWith();
			$description = $paymentVO->getDescription();
			
			$dbConnection = DBUtil::getTxnConnection();
			$adjustedValue = $this->getMetalValue($amount,$paymentMode,$adjustWith);
			if($stmt = $dbConnection->prepare(ADD_PAYMENT_INFO)) {
				$stmt->bind_param('ssssssss',$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustedValue,$description);
				$result = $stmt->execute();
				if($result == 1){
					$paymentVO->setTxnId($dbConnection->insert_id);
					if($stmt1 = $dbConnection->prepare("update payment set voucher_no = txn_id where txn_id=" . $dbConnection->insert_id)){
						$result = $stmt1->execute();
						if($result != 1){
							throw new DBException("PaymentDAO :: addPayment :: " . $dbConnection->error);
						}
					}
					if($paymentMode == "cheque"){
						$this->updateSupplierAssets($dbConnection,$adjustWith,$adjustedValue,$supplierId,'-');
					}else{
						$this->updateCompanyAssets($dbConnection,$paymentMode,$amount,'-');
						$this->updateSupplierAssets($dbConnection,$adjustWith,$adjustedValue,$supplierId,'-');
					}
				}
				$dbConnection->commit();
				$stmt->close();
				$stmt1->close();
			}else{
				throw new DBException("PaymentDAO :: addPayment :: " . $dbConnection->error);
			}
		}catch(DBException $e){
			if($dbConnection != null){
				$dbConnection->rollback();
			}
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null){
			$dbConnection->close();
		}
		return $paymentVO;
	}
	
	function modifyPayment($paymentVO){
		$result = 0;
		$dbConnection = null;
		$crDr = '-';
		$diffInAmount = 0;
		try{
			$txnId = $paymentVO->getTxnId();
			$date = $paymentVO->getDate();
			$supplierId = $paymentVO->getSupplierId();
			$voucherNo = $paymentVO->getVoucherNo();
			$paymentMode = $paymentVO->getPaymentMode();
			$amount = $paymentVO->getAmount();
			$adjustWith = $paymentVO->getAdjustWith();
			$description = $paymentVO->getDescription();
			
			$adjustedValue = $this->getMetalValue($amount,$paymentMode,$adjustWith);
			
			$currentAmount = $this->getCurrentAmount($txnId);
			
			$isDuplicate = $this->doesOtherVoucherNoExists($txnId,$supplierId,$voucherNo);
			if($isDuplicate == false){
				$dbConnection = DBUtil::getTxnConnection();
				if($stmt = $dbConnection->prepare(MODIFY_PAYMENT_INFO)) {
					$stmt->bind_param('sssssssss',$date,$supplierId,$voucherNo,$paymentMode,$amount,$adjustWith,$adjustedValue,$description,$txnId);
					$result = $stmt->execute();
					if($result == 1){
						//$paymentVO->setTxnId($dbConnection->insert_id);
						if(($currentAmount-$amount) == 0){
								// no need to update any suppliers and company info 
						}else {
							if(($currentAmount-$amount) > 0){
								$crDr = '+';
								$diffInAmount = ($currentAmount-$amount);
								$adjustedValue = $this->getMetalValue($diffInAmount,$paymentMode,$adjustWith);
							}else{
								$crDr = '-';
								$diffInAmount = -($currentAmount-$amount);
								$adjustedValue = $this->getMetalValue($diffInAmount,$paymentMode,$adjustWith);
							}
							
							if($paymentMode == "cheque"){
								$this->updateSupplierAssets($dbConnection,$adjustWith,$adjustedValue,$supplierId,$crDr);
							}else{
								$this->updateCompanyAssets($dbConnection,$paymentMode,$diffInAmount,$crDr);
								$this->updateSupplierAssets($dbConnection,$adjustWith,$adjustedValue ,$supplierId,$crDr);
							}
						}
					}
					$dbConnection->commit();
					$stmt->close();
				}else{
					throw new DBException("PaymentDAO :: addPayment :: " . $dbConnection->error);
				}
			}else{
				throw new DBException("Update Failed. Voucher no already exists for supplier");
			}
		}catch(DBException $e){
			if($dbConnection != null){
				$dbConnection->rollback();
			}
			throw new DBException($e->getMessage());
		}
		if($dbConnection != null)
			$dbConnection->close();
		return $paymentVO;
	}

	function deletePayment($paymentVO){
		$result = 0;
		try{
			$txnId = $paymentVO->getTxnId();
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(DELETE_PAYMENT_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				if($result == 1){
					$supplierId = $paymentVO->getSupplierId();
					$paymentMode = $paymentVO->getPaymentMode();
					$amount = $paymentVO->getAmount();
					$adjustWith = $paymentVO->getAdjustWith();
					$currentAdjustedAmount = $this->getCurrentAdjustedAmount($txnId);
					
					if($paymentMode == "cheque"){
						$this->updateSupplierAssets($dbConnection,$adjustWith,$currentAdjustedAmount,$supplierId,'+');
					}else{
						$this->updateCompanyAssets($dbConnection,$paymentMode,$amount,'+');
						echo 'current adjested amount ' . $currentAdjustedAmount . ' ' . $adjustWith;
						$this->updateSupplierAssets($dbConnection,$adjustWith,$currentAdjustedAmount,$supplierId,'+');
					}
				}else{
					throw new DBException($dbConnection->error);
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: deletePayment :: " . $dbConnection->error);
			}
		}catch(Exception $e){
			$dbConnection->rollback();
			throw new DBException($e->getMessage());
		}
		$dbConnection->close();
		return $result;
	}
	
	function getCurrentAmount($txnId){
		$currentAmount = 0;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_CURRENT_PAYMENT_AMOUNT)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				$stmt->bind_result($amount);
				if($stmt->fetch()){
					$currentAmount = $amount;
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getCurrentAmount :: " . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		$dbConnection->close();
		return $currentAmount;
	}
	
	function getCurrentAdjustedAmount($txnId){
		$currentAmount = 0;
		$dbConnection = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_CURRENT_ADJUSTED_AMOUNT)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				$stmt->store_result();
				$num_rows= $stmt->num_rows;
				$stmt->bind_result($amount);
				if($stmt->fetch()){
					$currentAmount = $amount;
				}else{
					echo 'UNABLE TO FETCH' . $dbConnection->error;
				}
				$stmt->close();
			}else{
				throw new DBException("PaymentDAO :: getCurrentAdjustedAmount :: " . $dbConnection->error);
			}
			if($dbConnection != null){
				$dbConnection->close();
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $currentAmount;
	}
	function updateCompanyAssets($dbConnection,$paymentMode,$amount,$crDr){
		$companyDAO = new CompanyDAO();
		try{
			$companyDAO->updateCompanyAssets($dbConnection,$paymentMode,$amount,$crDr);
		}catch(DBException $e){
			throw $e;
		}
	}
	
	function updateSupplierAssets($dbConnection,$paymentMode,$amount,$supplierId,$crDr){
		$supplierDAO = new SupplierDAO();
		try{
			$supplierDAO->updateSupplierAssets($dbConnection,$paymentMode,$amount,$crDr,$supplierId);
		}catch(DBException $e){
			throw $e;
		}
	}
	function doesVoucherNoExists($supplierId,$billNo){
		$isDuplicate= false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DOES_VOUCHERNO_EXISTS)) {
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
	
	function doesOtherVoucherNoExists($txnId,$supplierId,$billNo){
		$isDuplicate= false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DOES_OTHER_VOUCHERNO_EXISTS)) {
				$stmt->bind_param('sss',$txnId, $supplierId,$billNo);
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
	
	function getMetalValue($amount,$sourceMode,$convertMode){
		$value = 0;
		$rateDAO = new RateDAO();
		
		if($sourceMode == $convertMode){
			$value = $amount;
		}else if($sourceMode == "pg" && $convertMode == "lpg"){
			$value = ($amount / 0.916);
		}else if($sourceMode == "pg" && $convertMode == "cash"){
			$pgRate = $rateDAO->getRateByMetalType("pure gold");
			$pgRateg = $pgRate / 116.64;
			$value = $amount * $pgRateg;
		}else if($sourceMode == "pg" && $convertMode == "silver"){
			$pgRate = $rateDAO->getRateByMetalType("pure gold");
			$pgRateg = $pgRate / 116.64;
			$pgcashValue = $amount * $pgRateg;
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$silverkg = $pgcashValue/$silverRate;
			$value = $silverkg;
		}else if($sourceMode == "lpg" && $convertMode == "pg"){
			$value = ($amount * 0.916);
		}else if($sourceMode == "lpg" && $convertMode == "cash"){
			$lpgRate = $rateDAO->getRateByMetalType("less pure gold");
			$lpgRateg = $lpgRate / 116.64;
			$value = $amount * $lpgRateg;
		}else if($sourceMode == "lpg" && $convertMode == "silver"){
			$lpgRate = $rateDAO->getRateByMetalType("less pure gold");
			$lpgRateg = $lpgRate / 116.64;
			$lpgcashValue = $amount * $lpgRateg;
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$silverkg = $lpgcashValue/$silverRate;
			$value = $silverkg;
		}else if(($sourceMode == "cash" || $sourceMode == "cheque") && $convertMode == "pg"){
			$pgRate = $rateDAO->getRateByMetalType("pure gold");
			$pgRateg = $pgRate / 116.64;
			$value = $amount / $pgRateg;
		}else if(($sourceMode == "cash" || $sourceMode == "cheque") && $convertMode == "lpg"){
			$lpgRate = $rateDAO->getRateByMetalType("less pure gold");
			$lpgRateg = $lpgRate / 116.64;
			$value = $amount / $lpgRateg;
		}else if(($sourceMode == "cash" || $sourceMode == "cheque") && $convertMode == "silver"){
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$value = $amount / $silverRate;
		}else if(($sourceMode == "cash" || $sourceMode == "cheque") && $convertMode == "cash"){
			$value = $amount;
		}else if($sourceMode == "silver" && $convertMode == "cash"){
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$value = $amount * $silverRate;
		}else if($sourceMode == "silver" && $convertMode == "lpg"){
			$lpgRate = $rateDAO->getRateByMetalType("less pure gold");
			$lpgRateg = $lpgRate / 116.64;
			
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$silverCashValue = $amount * $silverCashValue;
			$lpg = $silverCashValue/$lpgRateg;
			$value = $lpg;
		}else if($sourceMode == "silver" && $convertMode == "pg"){
			$pgRate = $rateDAO->getRateByMetalType("pure gold");
			$pgRateg = $pgRate / 116.64;
			
			$silverRate = $rateDAO->getRateByMetalType("silver");
			$silverCashValue = $amount * $silverRate;
			$pg = $silverCashValue/$pgRateg;
			$value = $pg;
		}
		
		return $value;
	}
}
?>