<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/ProjectionVO.php';

	class ProjectionDAO {


	function getAllProjectionVOs(){
		$projectionVOList =  new CU_Collection('ProjectionVO');
		try{
			$projectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_PROJECTIONS)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					$projectionVO->setPg($pg);
					$projectionVO->setLpg($lpg);
					$projectionVO->setSilver($silver);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
					$projectionVOList->add($projectionVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVOList;
	}

	function getProjectionVO($id){
		try{
			$projectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTION_INFO)) {
				$stmt->bind_param('s',$id);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				if($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					$projectionVO->setPg($pg);
					$projectionVO->setLpg($lpg);
					$projectionVO->setSilver($silver);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVO;
	}

	function addProjectionVO($projectionVO){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$date = $projectionVO->getDate();
			$type = $projectionVO->getType();
			$categoryId = $projectionVO->getCategoryId();
			$accheadId = $projectionVO->getAccheadId();
			$pg = $projectionVO->getPg();
			$lpg = $projectionVO->getLpg();
			$silver = $projectionVO->getSilver();
			$cash = $projectionVO->getCash();
			$description = $projectionVO->getDescription();
			if($stmt = $dbConnection->prepare(ADD_PROJECTION_INFO)) {
				$stmt->bind_param('sssssssss',$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifyProjectionVO($projectionVO){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$txnId = $projectionVO->getTxnId();
			$date = $projectionVO->getDate();
			$type = $projectionVO->getType();
			$categoryId = $projectionVO->getCategoryId();
			$accheadId = $projectionVO->getAccheadId();
			$pg = $projectionVO->getPg();
			$lpg = $projectionVO->getLpg();
			$silver = $projectionVO->getSilver();
			$cash = $projectionVO->getCash();
			$description = $projectionVO->getDescription();
			if($stmt = $dbConnection->prepare(MODIFY_PROJECTION_INFO)) {
				$stmt->bind_param('sssssss',$date,$pg,$lpg,$silver,$cash,$description,$txnId);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteProjectionVO($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DELETE_PROJECTION_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	function getIncomingByDate($date){
		$projectionVOList =  new CU_Collection('ProjectionVO');
		try{
			$ProjectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTION_INCOMING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					$projectionVO->setPg($pg);
					$projectionVO->setLpg($lpg);
					$projectionVO->setSilver($silver);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
					$projectionVOList->add($projectionVO);
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getIncomingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVOList;
	}
	function getOutgoingByDate($date){
		$projectionVOList =  new CU_Collection('ProjectionVO');
		try{
			$projectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTION_OUTGOING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					$projectionVO->setPg($pg);
					$projectionVO->setLpg($lpg);
					$projectionVO->setSilver($silver);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
					$projectionVOList->add($projectionVO);
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getOutgoingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVOList;
	}
	
	/* Returns incoming entries with Acchead Id as key */
	
	function getIncomingListByDate($date){
		$projectionVOList =  array();
		try{
			$projectionVO = null;
			$paymentDAO = new PaymentDAO();
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTION_INCOMING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					
					$pgCashValue = $paymentDAO->getMetalValue($pg,"pg","cash");
					$projectionVO->setPg($pgCashValue);
					$lpgCashValue = $paymentDAO->getMetalValue($lpg,"lpg","cash");
					$projectionVO->setLpg($lpgCashValue);
					$silverCashValue = $paymentDAO->getMetalValue($silver,"silver","cash");
					$projectionVO->setSilver($silverCashValue);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
					$projectionVOList[$accheadId] = $projectionVO;
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getIncomingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVOList;
	}
	
	/* Returns outgoing entries with Acchead Id as key */
	
	function getOutgoingListByDate($date){
		$projectionVOList =  array();
		try{
			$projectionVO = null;
			$paymentDAO = new PaymentDAO();
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTION_OUTGOING_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					
					$pgCashValue = $paymentDAO->getMetalValue($pg,"pg","cash");
					$projectionVO->setPg($pgCashValue);
					$lpgCashValue = $paymentDAO->getMetalValue($lpg,"lpg","cash");
					$projectionVO->setLpg($lpgCashValue);
					$silverCashValue = $paymentDAO->getMetalValue($silver,"silver","cash");
					$projectionVO->setSilver($silverCashValue);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
					$projectionVOList[$accheadId] = $projectionVO;
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getOutgoingByDate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVOList;
	}
	
	function getProjectionByDate($date){
		$projectionVOList =  new CU_Collection('ProjectionVO');
		try{
			$projectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTIONS_BY_DATE)) {
				$stmt->bind_param('s',$date);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					$projectionVO->setPg($pg);
					$projectionVO->setLpg($lpg);
					$projectionVO->setSilver($silver);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
					$projectionVOList->add($projectionVO);
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getAllProjectionVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVOList;
	}
	
	function getIncomingByDateRange($fromdate,$todate){
		$paymentTypeVO = null;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTION_INCOMING_BY_DATE_RANGE)) {
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
				throw new DBException("ProjectionDAO :: getAllProjectionVOs :: " . $dbConnection->error);
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
			if($stmt = $dbConnection->prepare(GET_PROJECTION_OUTGOING_BY_DATE_RANGE)) {
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
				throw new DBException("ProjectionDAO :: getAllProjectionVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $paymentTypeVO;
	}
	
	function getProjectionById($txnId){
		try{
			$projectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTIONS_BY_ID)) {
				$stmt->bind_param('s',$txnId);
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				if($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					$projectionVO->setPg($pg);
					$projectionVO->setLpg($lpg);
					$projectionVO->setSilver($silver);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getProjectionById :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVO;
	}
	function calculateModificationDetails($currentProjectionVO,$newProjectionVO){
		$updatedProjectionVO = new ProjectionVO();
		
		$mode = $currentProjectionVO->getType();
		
		$updatedProjectionVO->setType($mode);
		
		$current_pg = $currentProjectionVO->getPg();
		$current_lpg = $currentProjectionVO->getLpg();
		$current_silver = $currentProjectionVO->getSilver();
		$current_cash = $currentProjectionVO->getCash();
		
		$new_pg = $newProjectionVO->getPg();
		$new_lpg = $newProjectionVO->getLpg();
		$new_silver = $newProjectionVO->getSilver();
		$new_cash = $newProjectionVO->getCash();
		
		$updatedProjectionVO->setPg(-($current_pg-$new_pg));
		$updatedProjectionVO->setLpg(-($current_lpg-$new_lpg));
		$updatedProjectionVO->setSilver(-($current_silver-$new_silver));
		$updatedProjectionVO->setCash(-($current_cash-$new_cash));
		
		echo $updatedProjectionVO->toString();
		
		return $updatedProjectionVO;
	}
	
	function hasTransaction($accheadId){
		$hasTransaction = false;
		try{
			$projectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_PROJECTIONS_BY_ACCHEADID)) {
				$stmt->bind_param('s',$accheadId);
				$stmt->execute();
				$stmt->store_result();
				$num_rows= $stmt->num_rows; 
				if($num_rows > 0){
					$hasTransaction = true;
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getProjectionById :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $hasTransaction;
	}
	
	function getProjectionByQuery($query){
		$projectionVOList =  new CU_Collection('ProjectionVO');
		try{
			$projectionVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare($query)) {
				$stmt->execute();
				$stmt->bind_result($txnId,$date,$type,$categoryId,$accheadId,$pg,$lpg,$silver,$cash,$description);
				while($stmt->fetch()){
					$projectionVO = new ProjectionVO();
					$projectionVO->setTxnId($txnId);
					$projectionVO->setDate($date);
					$projectionVO->setType($type);
					$projectionVO->setCategoryId($categoryId);
					$projectionVO->setAccheadId($accheadId);
					$projectionVO->setPg($pg);
					$projectionVO->setLpg($lpg);
					$projectionVO->setSilver($silver);
					$projectionVO->setCash($cash);
					$projectionVO->setDescription($description);
					$projectionVOList->add($projectionVO);
				}
				$stmt->close();
			}else{
				throw new DBException("ProjectionDAO :: getProjectionByQuery :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $projectionVOList;
	}
	}
?>