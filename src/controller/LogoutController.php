<?php
	
	session_start();

	session_destroy();
	session_unset();
	
	$redirectPath = "/PSS/index.php";
	header('Location:' . $redirectPath);
?>