<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/SupplierVO.php';

	class SupplierDAO {

		function getAllSuppliers(){
			$supplierVOList =  new CU_Collection('SupplierVO');
			try{
				$supplierVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ALL_SUPPLIERS)) {
					$stmt->execute();
					$stmt->bind_result($supplierId,$supplierName,$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash);
					while($stmt->fetch()){
						$supplierVO = new SupplierVO();
						$supplierVO->setSupplierId($supplierId);
						$supplierVO->setSupplierName($supplierName);
						$supplierVO->setOpPg($opPg);
						$supplierVO->setOpLpg($opLpg);
						$supplierVO->setOpSilver($opSilver);
						$supplierVO->setOpCash($opCash);
						$supplierVO->setClPg($clPg);
						$supplierVO->setClLpg($clLpg);
						$supplierVO->setClSilver($clSilver);
						$supplierVO->setClCash($clCash);
						$supplierVOList->add($supplierVO);
					}
					$stmt->close();
				}else{
					throw new DBException("SupplierDAO :: getAllSuppliers :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $supplierVOList;
		}
	
		function getSupplierVO($supplierId){
			try{
				$supplierVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_SUPPLIER_INFO)) {
					$stmt->bind_param('s',$supplierId);
					$stmt->execute();
					$stmt->bind_result($supplierId,$supplierName,$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash);
					if($stmt->fetch()){
						$supplierVO = new SupplierVO();
						$supplierVO->setSupplierId($supplierId);
						$supplierVO->setSupplierName($supplierName);
						$supplierVO->setOpPg($opPg);
						$supplierVO->setOpLpg($opLpg);
						$supplierVO->setOpSilver($opSilver);
						$supplierVO->setOpCash($opCash);
						$supplierVO->setClPg($clPg);
						$supplierVO->setClLpg($clLpg);
						$supplierVO->setClSilver($clSilver);
						$supplierVO->setClCash($clCash);
					}
					$stmt->close();
				}else{
					throw new DBException("SupplierDAO :: getSupplierVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $supplierVO;
		}
	
		function addSupplierVO($supplierVO){
			$result = false;
			try{
				$supplierName = $supplierVO->getSupplierName();
				$isDuplicate = $this->doesSupplierExists($supplierName);
				if($isDuplicate != true){
					$opPg = $supplierVO->getOpPg();
					$opLpg = $supplierVO->getOpLpg();
					$opSilver = $supplierVO->getOpSilver();
					$opCash = $supplierVO->getOpCash();
					$clPg = $supplierVO->getClPg();
					$clLpg = $supplierVO->getClLpg();
					$clSilver = $supplierVO->getClSilver();
					$clCash = $supplierVO->getClCash();
					
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(ADD_SUPPLIER_INFO)) {
						$stmt->bind_param('sssssssss',$supplierName,$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("SupplierDAO :: addSupplierVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Supplier Name already exists. Please provide a different supplier name.");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function modifySupplierVO($supplierVO){
			$result = false;
			try{
				$supplierId = $supplierVO->getSupplierId();
				$supplierName = $supplierVO->getSupplierName();
				$isDuplicate = $this->doesOtherSupplierExists($supplierName,$supplierId);
				if($isDuplicate != true){
					$opPg = $supplierVO->getOpPg();
					$opLpg = $supplierVO->getOpLpg();
					$opSilver = $supplierVO->getOpSilver();
					$opCash = $supplierVO->getOpCash();
					$clPg = $supplierVO->getClPg();
					$clLpg = $supplierVO->getClLpg();
					$clSilver = $supplierVO->getClSilver();
					$clCash = $supplierVO->getClCash();
					
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(MODIFY_SUPPLIER_INFO)) {
						$stmt->bind_param('ssssssssss',$supplierName,$opPg,$opLpg,$opSilver,$opCash,$clPg,$clLpg,$clSilver,$clCash,$supplierId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("SupplierDAO :: modifySupplierVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Supplier Name already exists. Please provide a different supplier name.");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function deleteSupplierVO($id){
			$result = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DELETE_SUPPLIER_INFO)) {
					$stmt->bind_param('s',$id);
					$result = $stmt->execute();
					$stmt->close();
				}else{
					throw new DBException("SupplierDAO :: deleteSupplierVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function doesSupplierExists($supplierName){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_SUPPLIER_EXISTS)) {
					$stmt->bind_param('s',$supplierName);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("SupplierDAO :: doesSupplierExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
		
		function doesOtherSupplierExists($supplierName,$supplierId){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_OTHER_SUPPLIER_EXISTS)) {
					$stmt->bind_param('ss',$supplierName,$supplierId);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("SupplierDAO :: doesOtherSupplierExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
		
	function updateSupplierAssets($dbConnection,$asset,$amount,$CrDr,$supplierId){
		$result = 0;
		try{
			$query = "update supplier set " . "cl_" . $asset . "=" . "cl_" . $asset . $CrDr . $amount . " where supplier_id=" . $supplierId;
			//echo $query;
			if($stmt = $dbConnection->prepare($query)) {
				$result = $stmt->execute();
				if($result != 1){
					throw new DBException("Updating supplier assets failed");
				}
				$stmt->close();
			}else{
				throw new DBException("SupplierDAO :: updateSupplierAssets :: " . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	function transferSupplierAssets($dbConnection,$fromType,$fromAmount,$toType,$toAmount,$supplierId,$mode){
		$result = 0;
		try{
			if($mode == "add"){
				$query = "update supplier set " . "cl_" . $fromType . "=" . "cl_" . $fromType . "-" . $fromAmount . ",cl_". $toType . "=" . "cl_" . $toType . "+" . $toAmount . "where supplier_id=" . $supplierId;
			}else if($mode == "delete"){
				$query = "update supplier set " . "cl_" . $fromType . "=" . "cl_" . $fromType . "+" . $fromAmount . ",cl_". $toType . "=" . "cl_" . $toType . "-" . $toAmount . "where supplier_id=" . $supplierId;
			}
			//echo $query;
			if($stmt = $dbConnection->prepare($query)) {
				$result = $stmt->execute();
				if($result != 1){
					throw new DBException("Transfering supplier assets failed");
				}
				$stmt->close();
			}else{
				throw new DBException("SupplierDAO :: transferSupplierAssets :: " . $dbConnection->error);
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
}
?>