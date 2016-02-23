<?php
	include_once '../src/vo/UserVO.php';
	
	session_start();
	
	$userType = null;
	$redirectPath = '/PSS/index.php';
	
	if(isset($_SESSION['userVO'])){
		$userVO = $_SESSION['userVO'];
		if($userVO!= null){
			$userType = $userVO->getUserType();
		}
	}else{
		header('Location:' . $redirectPath);
	}
	
?>