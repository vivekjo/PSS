<?php

class DBException extends Exception {
	public function getErrorMessage(){
		//error message
		$errorMsg = $this->getMessage();
		return $errorMsg;
	}
}


/*
 * Sample Code for DBException's implementation

$email = "someone@@example.com";

try{
	if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE){
		throw new DBException("myMsg");
	}
}catch (DBException $e){
	echo $e->errorMessage();
}


*/
?> 