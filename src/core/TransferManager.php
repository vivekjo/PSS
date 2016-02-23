<?php
	include_once '../dao/TransferDAO.php';
	
	class TransferManager{
		function addTransfer($transferVO){
			$response = 0;
			$transferDAO = new TransferDAO();
			$response = $transferDAO->addTransfer($transferVO);
			return $response;
		}
		function deleteTransfers($transferVO){
			$response = 0;
			$transferDAO = new TransferDAO();
			$response = $transferDAO->deleteTransfers($transferVO);
			return $response;
		}
		function getAllTransfers(){
			$transfersList = null;
			$transferDAO = new TransferDAO();
			$transfersList = $transferDAO->getAllTransfers();
			return $transfersList;
		}
		function getDaywiseTransfers($date){
			$transfersList = null;
			$transferDAO = new TransferDAO();
			$transfersList = $transferDAO->getDaywiseTransfers($date);
			return $transfersList;
		}
		function getTransfersById($txnId){
			$transferVO = null;
			$transferDAO = new TransferDAO();
			$transferVO = $transferDAO->getTransfersById($txnId);
			return $transferVO;
		}
	}
?>