<?php
	
	include_once '../dao/UserDAO.php';
	
	class UserManager{
		function getUserVO($userVO){
			$newUserVO = null;
			$userDAO = new UserDAO();
			$newUserVO = $userDAO->getUserVO($userVO);
			return $newUserVO;
		}
	}
	
?>