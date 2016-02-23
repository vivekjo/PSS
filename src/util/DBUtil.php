<?php
	include_once '../constants/DBConstants.php';
	
	error_reporting(E_ALL | E_STRICT);
	class DBUtil{
		static function getConnection(){
			$mysqli = mysqli_init();
			$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
			@$mysqli->real_connect(DATABASE_SERVER_NAME,MYSQL_USER_NAME,MYSQL_PASSWORD,DATABASE_NAME);
			if(mysqli_connect_errno()) {
		    	throw new DBException(mysqli_connect_error());
			}
			return $mysqli;
		}
		static function getTxnConnection(){
			$mysqli = mysqli_init();
			$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
			@$mysqli->real_connect(DATABASE_SERVER_NAME,MYSQL_USER_NAME,MYSQL_PASSWORD,DATABASE_NAME);
			if(mysqli_connect_errno()) {
		    	throw new DBException(mysqli_connect_error());
			}
			$mysqli->autocommit(FALSE);
			return $mysqli;
		}
	}
?>