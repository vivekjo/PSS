<?php

	session_start();
	
	include_once '../vo/UserVO.php';
	include_once '../core/UserManager.php';
	include_once '../dao/UserDAO.php';
	include_once '../util/XMLBuilder.php';

	$username = $_POST['username'];
	$password = $_POST['password'];
	$usertype = $_POST['usertype'];

	$userVO = new UserVO();
	$userVO->setUsername($username);
	$userVO->setPassword($password);
	$userVO->setUsertype($usertype);
	
	$userManager = new UserManager();
//	$xmlBuilder = new XMLBuilder();
	
	$newUserVO = $userManager->getUserVO($userVO);
	
	$redirectPath = '../../index.php';
	
	if($newUserVO != null){
		$_SESSION['userVO'] = $newUserVO;
		if($usertype == "operator"){
			$redirectPath = "../../ui/purchase.php";
		}else if($usertype == "administrator"){
			$redirectPath = "../../ui/product.php";
		}
	}
	
	header("Location: " . $redirectPath);
?>