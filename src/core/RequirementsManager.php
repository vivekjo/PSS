<?php

	include_once '../dao/RequirementsDAO.php';

	class RequirementsManager {

		/*function getAllRequirementss(){
			$requirementsVO = null;
			try{
				$requirementsDAO = new RequirementsDAO();
				$requirementsVO = $requirementsDAO->getAllRequirementss();
			}catch(Exception $e){
				throw $e;
			}
			return $requirementsVO;
		}*/

		function getRequirements($id){
			$requirementsVO = null;
			try{
				$requirementsDAO = new RequirementsDAO();
				$requirementsVO = $requirementsDAO->getRequirementsVO($id);
			}catch(Exception $e){
				throw $e;
			}
			return $requirementsVO;
		}

		function addRequirementsVO($requirementsVO){
			$newrequirementsVO = null;
			try{
				$requirementsDAO = new RequirementsDAO();
				$newrequirementsVO = $requirementsDAO->addRequirementsVO($requirementsVO);
			}catch(Exception $e){
				throw $e;
			}
			return $newrequirementsVO;
		}

		function modifyRequirementsVO($requirementsVO){
			$requirementsVO = null;
			try{
				$requirementsDAO = new RequirementsDAO();
				$requirementsVO = $requirementsDAO->modifyRequirements($requirementsVO);
			}catch(Exception $e){
				throw $e;
			}
			return $requirementsVO;
		}

		function deleteRequirementsVO($id){
			$newrequirementsVO = null;
			try{
				$requirementsDAO = new RequirementsDAO();
				$newrequirementsVO = $requirementsDAO->deleteRequirementsVO($id);
			}catch(Exception $e){
				throw $e;
			}
			return $newrequirementsVO;
		}

	}
?>