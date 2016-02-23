<?php

	include_once '../dao/SuspenseentryDAO.php';

	class SuspenseentryManager {

		function getAllSuspenseentrys(){
			$suspenseentryVO = null;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$suspenseentryVO = $suspenseentryDAO->getAllSuspenseentrys();
			}catch(Exception $e){
				throw $e;
			}
			return $suspenseentryVO;
		}

		function getSuspenseentryVO($suspenseno){
			$suspenseentryVO = null;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$suspenseentryVO = $suspenseentryDAO->getSuspenseentry($suspenseno);
			}catch(Exception $e){
				throw $e;
			}
			return $suspenseentryVO;
		}
		
		function getSuspenseReturn($suspenseno){
			$suspenseentryVO = null;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$suspenseentryVO = $suspenseentryDAO->getSuspenseReturn($suspenseno);
			}catch(Exception $e){
				throw $e;
			}
			return $suspenseentryVO;
		}
		
		function closeSuspense(){
			$response = 0;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$response = $suspenseentryDAO->closeSuspense();
			}catch(DBException $e){
				throw $e;
			}
			return $response;
		}

		function addSuspenseentryVO($suspenseentryVO){
			 $newsuspenseentryVO = null;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$newsuspenseentryVO = $suspenseentryDAO->addSuspenseentry($suspenseentryVO);
			}catch(Exception $e){
				throw $e;
			}
			return $newsuspenseentryVO;
		}

		function modifySuspenseentryVO($suspenseentryVO){
			$suspenseentryVO = null;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$suspenseentryVO = $suspenseentryDAO->modifySuspenseentry($suspenseentryVO);
			}catch(Exception $e){
				throw $e;
			}
			return $suspenseentryVO;
		}

		function deleteSuspenseentryVO($id){
			$result = 0;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$result = $suspenseentryDAO->deleteSuspenseentry($id);
			}catch(Exception $e){
				throw $e;
			}
			return $result;
		}
		
		function getSuspenseBalance(){
			$paymentTypeVO = null;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$paymentTypeVO = $suspenseentryDAO->getSuspenseBalance();
			}catch(Exception $e){
				throw $e;
			}
			return $paymentTypeVO;
		}
	}
?>