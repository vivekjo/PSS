<?php

	include_once '../dao/SuspensedetailsManager.php';

	class SuspensedetailsManager {

		function getAllSuspensedetailss(){
			$suspensedetailsVO = null;
			try{
				$suspensedetailsDAO = new SuspensedetailsDAO();
				$suspensedetailsVO = $suspensedetailsDAO->getAllSuspensedetailss();
			}catch(Exception $e){
				throw $e;
			}
			return $suspensedetailsVO;
		}

		function getSuspensedetails($id){
			$suspensedetailsVO = null;
			try{
				$suspensedetailsDAO = new SuspensedetailsDAO();
				$suspensedetailsVO = $suspensedetailsDAO->getSuspensedetails($id);
			}catch(Exception $e){
				throw $e;
			}
			return $suspensedetailsVO;
		}

		function addSuspensedetailsVO($suspensedetailsVO){
			$suspensedetailsVO = null;
			try{
				$suspensedetailsDAO = new SuspensedetailsDAO();
				$suspensedetailsVO = $suspensedetailsDAO->addSuspensedetails($suspensedetailsVO);
			}catch(Exception $e){
				throw $e;
			}
			return $suspensedetailsVO;
		}

		function modifySuspensedetailsVO($suspensedetailsVO){
			$suspensedetailsVO = null;
			try{
				$suspensedetailsDAO = new SuspensedetailsDAO();
				$suspensedetailsVO = $suspensedetailsDAO->modifySuspensedetails($suspensedetailsVO);
			}catch(Exception $e){
				throw $e;
			}
			return $suspensedetailsVO;
		}

		function deleteSuspensedetailsVO($id){
			$suspensedetailsVO = null;
			try{
				$suspensedetailsDAO = new SuspensedetailsDAO();
				$suspensedetailsVO = $suspensedetailsDAO->deleteSuspensedetails($id);
			}catch(Exception $e){
				throw $e;
			}
			return $suspensedetailsVO;
		}

	}
?>