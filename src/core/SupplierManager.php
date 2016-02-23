<?php

	include_once '../dao/SupplierDAO.php';
	
	class SupplierManager{
		function getAllSuppliers(){
			$supplierList = null;
			$supplierDAO = new SupplierDAO();
			$supplierList = $supplierDAO->getAllSuppliers();
			return $supplierList;
		}
		
		function getSupplierDetails($supplierId){
			$supplierVO = null;
			$supplierDAO = new SupplierDAO();
			$supplierVO = $supplierDAO->getSupplierVO($supplierId);
			return $supplierVO;
		}
		
		function addSupplier($supplierVO){
			$result = false;
			try{
				$supplierDAO = new SupplierDAO();
				$result = $supplierDAO->addSupplierVO($supplierVO);
			}catch(DBException $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function modifySupplier($supplierVO){
			$result = false;
			try{
				$supplierDAO = new SupplierDAO();
				$result = $supplierDAO->modifySupplierVO($supplierVO);
			}catch(DBException $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function deleteSupplier($supplierId){
			$result = false;
			$supplierDAO = new SupplierDAO();
			$result = $supplierDAO->deleteSupplierVO($supplierId);
			return $result;
		}
		
	}
	
	
?>