<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../3putils/Collection.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/DaybookVO.php';
	include_once '../dao/CompanyDAO.php';
	include_once '../dao/PaymentDAO.php';

	class DaybookDAO {

	
	function getAllDaybookVOs(){
		$daybookVOList =  new CU_Collection();
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection('DaybookVO');
			if($stmt = $dbConnection->prepare(GET_ALL_DAYBOOKS)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList->add($daybookVO);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getAllDaybookVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	
	function getDetailedIncomingByDate($date){
		$daybookVOList =  new CU_Collection('DaybookVO');
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_DETAILED_INCOMING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList->add($daybookVO);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getIncomingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	function getIncomingByDate($date){
		$daybookVOList =  new CU_Collection('DaybookVO');
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_INCOMING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList->add($daybookVO);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getIncomingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	function getOutgoingByDate($date){
		$daybookVOList =  new CU_Collection('DaybookVO');
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_OUTGOING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList->add($daybookVO);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getOutgoingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	function getDetailedOutgoingByDate($date){
		$daybookVOList =  new CU_Collection('DaybookVO');
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_DETAILED_OUTGOING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList->add($daybookVO);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getOutgoingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	
	/* Returns incoming entries with Acchead Id as key */
	
	function getIncomingListByDate($date){
		$daybookVOList =  array();
		try{
			$daybookVO = null;
			$paymentDAO = new PaymentDAO();
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_INCOMING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					
					$pgCashValue = $paymentDAO->getMetalValue($pg,"pg","cash");
					$daybookVO->setPg($pgCashValue);
					$lpgCashValue = $paymentDAO->getMetalValue($lpg,"lpg","cash");
					$daybookVO->setLpg($lpgCashValue);
					$silverCashValue = $paymentDAO->getMetalValue($silver,"silver","cash");
					$daybookVO->setSilver($silverCashValue);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList[$accheadId] = $daybookVO;
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getIncomingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	
	/* Returns outgoing entries with Acchead Id as key */
	
	function getOutgoingListByDate($date){
		$daybookVOList =  array();
		try{
			$daybookVO = null;
			$paymentDAO = new PaymentDAO();
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_OUTGOING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					
					$pgCashValue = $paymentDAO->getMetalValue($pg,"pg","cash");
					$daybookVO->setPg($pgCashValue);
					$lpgCashValue = $paymentDAO->getMetalValue($lpg,"lpg","cash");
					$daybookVO->setLpg($lpgCashValue);
					$silverCashValue = $paymentDAO->getMetalValue($silver,"silver","cash");
					$daybookVO->setSilver($silverCashValue);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList[$accheadId] = $daybookVO;
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getOutgoingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	
	function getAccountsByDate($date){
		$daybookVOList =  new CU_Collection('DaybookVO');
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ACCOUNTS_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList->add($daybookVO);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getAllDaybookVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
	
	function getIncomingByDateRange($fromdate,$todate){
		$paymentTypeVO = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_INCOMING_BY_DATE_RANGE)) {
				$stmt->bind_param('ss',$fromdate,$todate);
				$stmt->execute();
				$stmt->bind_result($pg,$lpg,$silver,$cash);
				$paymentTypeVO = new PaymentTypeVO();
				if($stmt->fetch()){
					 $paymentTypeVO->setPg($pg);
					 $paymentTypeVO->setLpg($lpg);
					 $paymentTypeVO->setSilver($silver);
					 $paymentTypeVO->setCash($cash);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getAllDaybookVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	function getOutgoingByDateRange($fromdate,$todate){
		$paymentTypeVO = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_OUTGOING_BY_DATE_RANGE)) {
				$stmt->bind_param('ss',$fromdate,$todate);
				$stmt->execute();
				$stmt->bind_result($pg,$lpg,$silver,$cash);
				$paymentTypeVO = new PaymentTypeVO();
				if($stmt->fetch()){
					 $paymentTypeVO->setPg($pg);
					 $paymentTypeVO->setLpg($lpg);
					 $paymentTypeVO->setSilver($silver);
					 $paymentTypeVO->setCash($cash);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getAllDaybookVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getAccountsById($txnId){
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ACCOUNTS_BY_ID)) {
				$stmt->bind_param('s',$txnId);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				if($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getAccountsById :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVO;
	}

	function addAccounts($daybookVO){
		$result = 0;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			$date = $daybookVO->getDate();
			$type = $daybookVO->getType();
			$categoryId = $daybookVO->getCategoryId();
			$accheadId = $daybookVO->getAccheadId();
			$pg = $daybookVO->getPg();
			$lpg = $daybookVO->getLpg();
			$silver = $daybookVO->getSilver();
			$cash = $daybookVO->getCash();
			$description = $daybookVO->getDescription();
			if($stmt = $dbConnection->prepare(ADD_DAYBOOK_INFO)) {
				$stmt->bind_param('sssssssss',$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				$result = $stmt->execute();
				if($result == 1){
					$daybookVO->setTxnId($dbConnection->insert_id);
					$this->updateCompanyAssets($dbConnection,$daybookVO,"add");
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				$dbConnection->rollback();
				throw new DBException("DaybookDAO :: addAccounts :: " . $dbConnection->error);
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
		return $daybookVO;
	}

	function modifyAccounts($daybookVO){
		$result = 0;
		try{
			$txnId = $daybookVO->getTxnId();
			$date = $daybookVO->getDate();
			$type = $daybookVO->getType();
			$categoryId = $daybookVO->getCategoryId();
			$accheadId = $daybookVO->getAccheadId();
			$pg = $daybookVO->getPg();
			$lpg = $daybookVO->getLpg();
			$silver = $daybookVO->getSilver();
			$cash = $daybookVO->getCash();
			$description = $daybookVO->getDescription();
			
			$currentDaybookVO = $this->getAccountsById($txnId);
			
			$dbConnection = DBUtil::getTxnConnection();
			if($stmt = $dbConnection->prepare(MODIFY_DAYBOOK_INFO)) {
				$stmt->bind_param('sssssssss',$date,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description,$txnId);
				$result = $stmt->execute();
				if($result == 1){
					$updatedDaybookVO = $this->calculateModificationDetails($currentDaybookVO,$daybookVO);
					$this->updateCompanyAssets($dbConnection,$updatedDaybookVO,"add");
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				$dbConnection->rollback();
				throw new DBException("DaybookDAO :: addAccounts :: " . $dbConnection->error);
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
		return $daybookVO;
	}

	function deleteAccounts($daybookVO){
		$result = 0;
		try{
			$dbConnection = DBUtil::getTxnConnection();
			$txnId = $daybookVO->getTxnId();
			$pg = $daybookVO->getPg();
			$lpg = $daybookVO->getLpg();
			$silver = $daybookVO->getSilver();
			$cash = $daybookVO->getCash();
			if($stmt = $dbConnection->prepare(DELETE_DAYBOOK_INFO)) {
				$stmt->bind_param('s',$txnId);
				$result = $stmt->execute();
				if($result == 1){
					$this->updateCompanyAssets($dbConnection,$daybookVO,"delete");
				}
				$dbConnection->commit();
				$stmt->close();
			}else{
				$error = $dbConnection->error;
				$dbConnection->rollback();
				throw new DBException("DaybookDAO :: deleteAccounts :: " . $error);
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
	
	function updateCompanyAssets($dbConnection,$daybookVO,$mode){
		$companyDAO = new CompanyDAO();
		try{
			if($mode == "add" && $daybookVO->getType() == "incoming"){
				$companyDAO->updateAllCompanyAssets($dbConnection,$daybookVO,"+");
			}else if($mode == "delete" && $daybookVO->getType() == "incoming"){
				$companyDAO->updateAllCompanyAssets($dbConnection,$daybookVO,"-");
			}else if($mode == "add" && $daybookVO->getType() == "outgoing"){
				$companyDAO->updateAllCompanyAssets($dbConnection,$daybookVO,"-");
			}else if($mode == "delete" && $daybookVO->getType() == "outgoing"){
				$companyDAO->updateAllCompanyAssets($dbConnection,$daybookVO,"+");
			}
		}catch(DBException $e){
			throw $e;
		}
	}
	
	function calculateModificationDetails($currentDaybookVO,$newDaybookVO){
		$updatedDaybookVO = new DaybookVO();
		
		$mode = $currentDaybookVO->getType();
		
		$updatedDaybookVO->setType($mode);
		
		$current_pg = $currentDaybookVO->getPg();
		$current_lpg = $currentDaybookVO->getLpg();
		$current_silver = $currentDaybookVO->getSilver();
		$current_cash = $currentDaybookVO->getCash();
		
		$new_pg = $newDaybookVO->getPg();
		$new_lpg = $newDaybookVO->getLpg();
		$new_silver = $newDaybookVO->getSilver();
		$new_cash = $newDaybookVO->getCash();
		
		$updatedDaybookVO->setPg(-($current_pg-$new_pg));
		$updatedDaybookVO->setLpg(-($current_lpg-$new_lpg));
		$updatedDaybookVO->setSilver(-($current_silver-$new_silver));
		$updatedDaybookVO->setCash(-($current_cash-$new_cash));
		
		echo $updatedDaybookVO->toString();
		
		return $updatedDaybookVO;
	}
	
	function hasTransaction($accheadId){
		$hasTransaction = false;
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ACCOUNTS_BY_ACCHEADID)) {
				$stmt->bind_param('s',$accheadId);
				$stmt->execute();
				$stmt->store_result();
				$num_rows= $stmt->num_rows; 
				if($num_rows > 0){
					$hasTransaction = true;
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getAccountsById :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $hasTransaction;
	}
	
	function getAccountsByQuery($query){
		$daybookVOList =  new CU_Collection('DaybookVO');
		try{
			$daybookVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($query)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$daybookVO = new DaybookVO();
					$daybookVO->setTxnId($txnId);
					$daybookVO->setDate($date);
					$daybookVO->setType($type);
					$daybookVO->setCategoryId($categoryId);
					$daybookVO->setAccheadId($accheadId);
					$daybookVO->setPg($pg);
					$daybookVO->setLpg($lpg);
					$daybookVO->setSilver($silver);
					$daybookVO->setCash($cash);
					$daybookVO->setDescription($description);
					$daybookVOList->add($daybookVO);
				}
				$stmt->close();
			}else{
				throw new DBException("DaybookDAO :: getAccountsByQuery :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $daybookVOList;
	}
}
?>