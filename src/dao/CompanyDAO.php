<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/CompanyVO.php';
	include_once '../vo/DaybookVO.php';

	class CompanyDAO {


	function getAllCompanyVOs(){
		$companyVOList =  new CU_Collection();
		try{
			$companyVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_COMPANYS)) {
				$stmt->execute();
				$stmt->bind_result($id,$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash);
				while($stmt->fetch()){
					$companyVO = new CompanyVO();
					$companyVO->setId($id);
					$companyVO->setOpPg($opPg);
					$companyVO->setOpLpg($opLpg);
					$companyVO->setOpSilver($opSilver);
					$companyVO->setOpCash($opCash);
					$companyVO->setClPg($clPg);
					$companyVO->setClLpg($clLpg);
					$companyVO->setClSilver($clSilver);
					$companyVO->setClCash($clCash);
					$companyVOList->add($companyVO);
				}
				$stmt->close();
			}else{
				throw new DBException("Company :: getAllCompanyVOs :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $companyVOList;
	}

	function getCompanyVO($companyId){
		try{
			$companyVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_COMPANY_INFO)) {
				$stmt->bind_param('s',$companyId);
				$stmt->execute();
				$stmt->bind_result($id,$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash);
				if($stmt->fetch()){
					$companyVO = new CompanyVO();
					$companyVO->setId($id);
					$companyVO->setOpPg($opPg);
					$companyVO->setOpLpg($opLpg);
					$companyVO->setOpSilver($opSilver);
					$companyVO->setOpCash($opCash);
					$companyVO->setClPg($clPg);
					$companyVO->setClLpg($clLpg);
					$companyVO->setClSilver($clSilver);
					$companyVO->setClCash($clCash);
				}
				$stmt->close();
			}else{
				throw new DBException("Company :: getCompanyVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $companyVO;
	}

	function addCompanyVO(){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$id = $companyVO->getId();
			$opPg = $companyVO->getOpPg();
			$opLpg = $companyVO->getOpLpg();
			$opSilver = $companyVO->getOpSilver();
			$opCash = $companyVO->getOpCash();
			$clPg = $companyVO->getClPg();
			$clLpg = $companyVO->getClLpg();
			$clSilver = $companyVO->getClSilver();
			$clCash = $companyVO->getClCash();
			if($stmt = $dbConnection->prepare(ADD_COMPANY_INFO)) {
				$stmt->bind_param('sssssssss',$id,$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash);
				$result = $stmt->execute();
				$stmt->close();
			}else{
				throw new DBException("Company :: addCompanyVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifyCompanyVO($companyVO){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			$id = $companyVO->getId();
			$opPg = $companyVO->getOpPg();
			$opLpg = $companyVO->getOpLpg();
			$opSilver = $companyVO->getOpSilver();
			$opCash = $companyVO->getOpCash();
			$clPg = $companyVO->getClPg();
			$clLpg = $companyVO->getClLpg();
			$clSilver = $companyVO->getClSilver();
			$clCash = $companyVO->getClCash();
			if($stmt = $dbConnection->prepare(MODIFY_COMPANY_INFO)) {
				$stmt->bind_param('sssssssss',$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash,$id);
				$result = $stmt->execute();
				$stmt->close();
			}else{
				throw new DBException("Company :: modifyCompanyVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteCompanyVO($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DELETE_COMPANY_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}else{
				throw new DBException("Company :: deleteCompanyVO :: " . $dbConnection->error);
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function updateCompanyAssets($dbConnection,$asset,$amount,$CrDr){
		$result = 0;
		try{
			$query = "update company set " . "cl_" . $asset . "=" . "cl_" . $asset . $CrDr . $amount;
			//echo $query;
			if($stmt = $dbConnection->prepare($query)) {
				$result = $stmt->execute();
				if($result != 1){
					throw new DBException("Updating company assets failed");
				}
				$stmt->close();
			}else{
				throw new DBException("Company :: updateCompanyAssets :: " . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	function updateAllCompanyAssets($dbConnection,$daybookVO,$CrDr){
		$result = 0;
		try{
			$pg = $daybookVO->getPg();
			$lpg = $daybookVO->getLpg();
			$silver = $daybookVO->getSilver();
			$cash = $daybookVO->getCash();
			$query = "update company set " . "cl_pg" . "=cl_pg " . $CrDr . $pg . ",cl_lpg=cl_lpg " . $CrDr . $lpg . ",cl_silver=cl_silver " . $CrDr . $silver . ",cl_cash=cl_cash " . $CrDr . $cash;
			//echo $query;
			if($stmt = $dbConnection->prepare($query)) {
				$result = $stmt->execute();
				if($result != 1){
					throw new DBException("Updating company assets failed");
				}
				$stmt->close();
			}else{
				throw new DBException("company :: updateAllCompanyAssets :: " . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	}
?>