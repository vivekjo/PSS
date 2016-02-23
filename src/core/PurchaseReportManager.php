<?php

	include_once '../dao/PurchaseDAO.php';
	class PurchaseReportManager{
		function getPurchaseReport($queryString1,$queryString2){
			$purchaseVOList = null;
			try{
				$purchaseDAO = new PurchaseDAO();
				$purchaseVOList = $purchaseDAO->getAllPurchaseVOsByQueryString($queryString1,$queryString2);
			}catch(DBException $e){
				throw $e;
			}
			return $purchaseVOList;
		}
		
	}
?>