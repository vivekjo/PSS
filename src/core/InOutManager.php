<?php

	include_once '../dao/InoutDAO.php';
	
	class InOutManager{
		
		function addInOut($inoutentryVO){
			$newinoutentryVO = null;
			$inoutDAO = new InoutentryDAO();
			try{
				$newinoutentryVO = $inoutDAO->addInout($inoutentryVO);
			}catch(DBException $e){
				throw $e;
			}
			return $newinoutentryVO;
		}
		
		function getInout($inoutId){
			$inoutVO = null;
			$inoutDAO = new InoutentryDAO();
			try{
				$inoutVO = $inoutDAO->getInout($inoutId);
			}catch(DBException $e){
				throw $e;
			}
			return $inoutVO;
		}
		function deleteInout($txnId){
			$response = 0;
			$inoutDAO = new InoutentryDAO();
			try{
				$response = $inoutDAO->deleteInout($txnId);
			}catch(DBException $e){
				throw $e;
			}
			return $response;
		}
		
	}