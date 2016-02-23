<?php
	include_once '../dao/DaybookDAO.php';
	
	class DaybookManager{
		function getAccountsByDate($date){
			$accountsList = null;
			$daybookDAO = new DaybookDAO();
			$accountsList = $daybookDAO->getAccountsByDate($date);
			return $accountsList;
		}
		function getAccountsById($txnId){
			$accountVO = null;
			$daybookDAO = new DaybookDAO();
			$accountVO = $daybookDAO->getAccountsById($txnId);
			return $accountVO;
		}
		function addAccounts($accountsVO){
			$newAccountsVO = null;
			$daybookDAO = new DaybookDAO();
			$newAccountsVO = $daybookDAO->addAccounts($accountsVO);
			return $newAccountsVO;
		}
		function modifyAccounts($daybookVO){
			$newAccountsVO = null;
			$daybookDAO = new DaybookDAO();
			$newAccountsVO = $daybookDAO->modifyAccounts($daybookVO);
			return $newAccountsVO;
		}
		function deleteAccounts($daybookVO){
			$response = 0;
			$daybookDAO = new DaybookDAO();
			$response = $daybookDAO->deleteAccounts($daybookVO);
			return $response;
		}
		function getAccountsByQuery($query){
			$accountsList = null;
			$daybookDAO = new DaybookDAO();
			$accountsList = $daybookDAO->getAccountsByQuery($query);
			return $accountsList;
		}
	}
	
?>