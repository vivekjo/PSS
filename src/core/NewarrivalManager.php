<?php

	include_once '../dao/NewarrivalDAO.php';

	class NewarrivalManager {

		function getAllNewarrivals(){
			$newarrivalVO = null;
			try{
				$newarrivalDAO = new NewarrivalDAO();
				$newarrivalVO = $newarrivalDAO->getAllNewarrivals();
			}catch(Exception $e){
				throw $e;
			}
			return $newarrivalVO;
		}

		/*function getNewarrival($id){
			$newarrivalVO = null;
			try{
				$newarrivalDAO = new NewarrivalDAO();
				$newarrivalVO = $newarrivalDAO->getNewarrival($id);
			}catch(Exception $e){
				throw $e;
			}
			return $newarrivalVO;
		}*/
		function getNewarrival($id){
			$newarrivalVO = null;
			try{
				$newarrivalDAO = new NewarrivalDAO();
				$newarrivalVO = $newarrivalDAO->getNewarrivalVO($id);
			}catch(Exception $e){
				throw $e;
			}
			return $newarrivalVO;
		}

		
		
	 
		function addNewarrivalVO($newarrivalVO){
			try{
				$newarrivalDAO = new NewarrivalDAO();
				$newarrivalVO = $newarrivalDAO->addNewarrivalVO($newarrivalVO);
			}catch(Exception $e){
				throw $e;
			}
			return $newarrivalVO;
		}

		function modifyNewarrivalVO($newarrivalVO){
			$newarrivalVO = null;
			try{
				$newarrivalDAO = new NewarrivalDAO();
				$newarrivalVO = $newarrivalDAO->modifyNewarrival($newarrivalVO);
			}catch(Exception $e){
				throw $e;
			}
			return $newarrivalVO;
		}

		function deleteNewarrivalVO($id){
			$newarrivalVO = null;
			try{
				$newarrivalDAO = new NewarrivalDAO();
				$newarrivalVO = $newarrivalDAO->deleteNewarrivalVO($id);
			}catch(Exception $e){
				throw $e;
			}
			return $newarrivalVO;
		}

	}
?>