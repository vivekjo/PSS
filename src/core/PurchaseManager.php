<?php

	include_once '../dao/PurchaseDAO.php';
	include_once '../dao/PurchasedetailsDAO.php';
	
	class PurchaseManager{
		function addPurchase($purchaseVO){
			$newpurchaseVO = null;
			$purchaseDAO = new PurchaseDAO();
			try{
				$newpurchaseVO = $purchaseDAO->addPurchase($purchaseVO);
			}catch(DBException $e){
				throw $e;
			}
			return $newpurchaseVO;
		}
		function getPurchase($supplierId,$billno){
			$purchaseVO = null;
			$purchaseDAO = new PurchaseDAO();
			try{
				$purchaseVO = $purchaseDAO->getPurchase($supplierId,$billno);
			}catch(DBException $e){
				throw $e;
			}
			return $purchaseVO;
		}
		function deletePurchase($supplierId,$txnId){
			$response = 0;
			$purchaseDAO = new PurchaseDAO();
			try{
				$response = $purchaseDAO->deletePurchase($supplierId,$txnId);
			}catch(DBException $e){
				throw $e;
			}
			return $response;
		}
		function updatePurchaseDetailsByPurchaseDetailID($purchaseProductsList,$date){
			$response = 0;
			$purchaseDetailsDAO = new PurchasedetailsDAO();			
			try{
				$response = $purchaseDetailsDAO->updatePurchaseDetailsByPurchaseDetailID($purchaseProductsList,$date);
			}catch(DBException $e){
				throw $e;
			}
			return $response;
		}
		
	}