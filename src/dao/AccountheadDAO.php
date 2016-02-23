<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../3putils/Collection.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/AccountheadVO.php';
	include_once '../dao/DaybookDAO.php';

	class AccountheadDAO {

	function getAllAccheads(){
		$accountheadVOList =  new CU_Collection('AccountheadVO');
		try{
			$accountheadVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_ACCOUNTHEADS)) {
				$stmt->execute();
				$stmt->bind_result($accheadId,$accheadName,$parentChannelId);
				while($stmt->fetch()){
					$accountheadVO = new AccountheadVO();
					$accountheadVO->setAccheadId($accheadId);
					$accountheadVO->setAccheadName($accheadName);
					$accountheadVO->setParentChannelId($parentChannelId);
					$accountheadVOList->add($accountheadVO);
				}
				$stmt->close();
			}else{
				throw new DBException("AccountheadDAO :: getAllAccheads :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $accountheadVOList;
	}
	
	function getAccHeadsByChannel($channelId){
		$accountheadVOList =  new CU_Collection('AccountheadVO');
		try{
			$accountheadVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ACCOUNTHEADS_BY_CHANNEL)) {
				$stmt->bind_param('s',$channelId);
				$stmt->execute();
				$stmt->bind_result($accheadId,$accheadName,$parentChannelId);
				while($stmt->fetch()){
					$accountheadVO = new AccountheadVO();
					$accountheadVO->setAccheadId($accheadId);
					$accountheadVO->setAccheadName($accheadName);
					$accountheadVO->setParentChannelId($parentChannelId);
					$accountheadVOList->add($accountheadVO);
				}
				$stmt->close();
			}else{
				throw new DBException("AccountheadDAO :: getAccHeadsByChannel :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $accountheadVOList;
	}

	function getAccountheadVO($accheadName){
		try{
			$accountheadVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ACCOUNTHEAD_BY_NAME)) {
				$stmt->bind_param('s',$accheadName);
				$stmt->execute();
				$stmt->bind_result($accheadId,$accheadName,$parentChannelId);
				if($stmt->fetch()){
					$accountheadVO = new AccountheadVO();
					$accountheadVO->setAccheadId($accheadId);
					$accountheadVO->setAccheadName($accheadName);
					$accountheadVO->setParentChannelId($parentChannelId);
				}
				$stmt->close();
			}else{
				throw new DBException("AccountheadDAO :: getAccountheadVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $accountheadVO;
	}

	function addAccountheadVO($accountheadVO){
		$result = false;
		try{
			$accheadName = $accountheadVO->getAccheadName();
			$parentChannelId = $accountheadVO->getParentChannelId();
			$isDuplicate = $this->doesAccountExist($accheadName, $parentChannelId);
			if($isDuplicate != true){
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(ADD_ACCOUNTHEAD_INFO)) {
					$stmt->bind_param('ss',$accheadName,$parentChannelId);
					$result = $stmt->execute();
					$stmt->close();
				}else{
					throw new DBException("AccountheadDAO :: addAccountheadVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}else{
				throw new DBException("Account head already exists for selected channel. Please provide a different name");
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifyAccountheadVO($accountheadVO){
		$result = false;
		try{
			$accheadId = $accountheadVO->getAccheadId();
			$accheadName = $accountheadVO->getAccheadName();
			$parentChannelId = $accountheadVO->getParentChannelId();
			$isDuplicate = $this->doesAccountExist($accheadName, $parentChannelId);
			if($isDuplicate != true){
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(MODIFY_ACCOUNTHEAD_INFO)) {
					$stmt->bind_param('ss',$accheadName,$accheadId);
					$result = $stmt->execute();
					$stmt->close();
				}else{
					throw new DBException("AccountheadDAO :: modifyAccountheadVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}else{
				throw new DBException("Account head already exists for selected channel. Please provide a different name");
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteAccountHeadVO($accheadId){
		$result = false;
		try{
			$daybookDAO = new DaybookDAO();
			$haTransaction = $daybookDAO->hasTransaction($accheadId);
			if($haTransaction == false){
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DELETE_ACCOUNTHEAD_INFO)) {
					$stmt->bind_param('s',$accheadId);
					$result = $stmt->execute();
					$stmt->close();
				}else{
					throw new DBException("AccountheadDAO :: deleteAccountheadVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}else{
				throw new DBException("The selected account head cannot be deleted. It is involved in daybook transactions.");
			}
			
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function doesAccountExist($accHeadName, $channelId){
		$isDuplicate= false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DOES_ACCOUNTHEAD_EXISTS)) {
				$stmt->bind_param('ss',$accHeadName, $channelId);
				$stmt->execute();
				$stmt->store_result();
				$num_rows= $stmt->num_rows; 
				if($num_rows > 0){
					$isDuplicate = true;
				}
				$stmt->close();
			}else{
				throw new DBException("AccountheadDAO :: doesAccountExist :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $isDuplicate;
	}
	
}
?>