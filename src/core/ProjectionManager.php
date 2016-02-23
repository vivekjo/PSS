<?php

	include_once '../dao/ProjectionDAO.php';

	class ProjectionManager {

	function getProjectionByDate($date){
			$projectionList = null;
			$projectionDAO = new ProjectionDAO();
			$projectionList = $projectionDAO->getProjectionByDate($date);
			return $projectionList;
		}
		function getProjectionById($txnId){
			$accountVO = null;
			$projectionDAO = new ProjectionDAO();
			$accountVO = $projectionDAO->getProjectionById($txnId);
			return $accountVO;
		}
		function addProjection($projectionVO){
			$newProjectionVO = null;
			$projectionDAO = new ProjectionDAO();
			$newProjectionVO = $projectionDAO->addProjectionVO($projectionVO);
			return $newProjectionVO;
		}
		function modifyProjection($projectionVO){
			$newProjectionVO = null;
			$projectionDAO = new ProjectionDAO();
			$newProjectionVO = $projectionDAO->modifyProjectionVO($projectionVO);
			return $newProjectionVO;
		}
		function deleteProjection($txnId){
			$response = 0;
			$projectionDAO = new ProjectionDAO();
			$response = $projectionDAO->deleteProjectionVO($txnId);
			return $response;
		}
		function getProjectionByQuery($query){
			$projectionList = null;
			$projectionDAO = new ProjectionDAO();
			$projectionList = $projectionDAO->getProjectionByQuery($query);
			return $projectionList;
		}
		
		
		
		

	}
?>