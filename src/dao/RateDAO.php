<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/RateVO.php';

	class RateDAO {


	function getAllRates(){
		$rateVOList =  new CU_Collection('RateVO');
		try{
			$rateVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_RATES)) {
				$stmt->execute();
				$stmt->bind_result($rateId,$metal,$rate);
				while($stmt->fetch()){
					$rateVO = new RateVO();
					$rateVO->setRateId($rateId);
					$rateVO->setMetal($metal);
					$rateVO->setRate($rate);
					$rateVOList->add($rateVO);
				}
				$stmt->close();
			}else{
				throw new DBException("RateDAO :: getAllRates :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $rateVOList;
	}

	function getRateByType($metal){
		try{
			$rateVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_RATE_BY_TYPE)) {
				$stmt->bind_param('s',$metal);
				$stmt->execute();
				$stmt->bind_result($rateId,$metal,$rate);
				if($stmt->fetch()){
					$rateVO = new RateVO();
					$rateVO->setRateId($rateId);
					$rateVO->setMetal($metal);
					$rateVO->setRate($rate);
				}
				$stmt->close();
			}else{
				throw new DBException("RateDAO :: getRateByType :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $rateVO;
	}
	
	function getRateByMetalType($metal){
		try{
			$rate = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_RATE_BY_TYPE)) {
				$stmt->bind_param('s',$metal);
				$stmt->execute();
				$stmt->bind_result($rateId,$metal,$rate);
				if($stmt->fetch()){
					/*$rateVO = new RateVO();
					$rateVO->setRateId($rateId);
					$rateVO->setMetal($metal);
					$rateVO->setRate($rate);*/
				}
				$stmt->close();
			}else{
				throw new DBException("RateDAO :: getRateByType :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $rate;
	}

	function addRateVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$rateId = $rateVO->getRateId();
			$metal = $rateVO->getMetal();
			$rate = $rateVO->getRate();
			if($stmt = $dbConnection->prepare(ADD_RATE_INFO)) {
				$stmt->bind_param('sss',$rateId,$metal,$rate);
				$result = $stmt->execute();
				$stmt->close();
			}else{
				throw new DBException("RateDAO :: addRateVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifyRate($metal,$value){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(MODIFY_RATE_INFO)) {
				$stmt->bind_param('ss',$value,$metal);
				$result = $stmt->execute();
				$stmt->close();
			}else{
				throw new DBException("RateDAO :: modifyRate :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteRateVO($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DELETE_RATE_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}else{
				throw new DBException("RateDAO :: deleteRateVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	}
?>