<?php
	
	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/UserVO.php';

	class UserDAO {

		function getUserVO($userVO){
			$newUserVO = null;
			try{
				$username = $userVO->getUsername();
				$password = $userVO->getPassword();
				$usertype = $userVO->getUsertype();
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_USER_INFO)) {
					$stmt->bind_param('sss',$username,$password,$usertype);
					$stmt->execute();
					$stmt->bind_result($userId,$username,$password,$usertype);
					if($stmt->fetch()){
						$newUserVO = new UserVO();
						$newUserVO->setUserId($userId);
						$newUserVO->setUsername($username);
						$newUserVO->setPassword($password);
						$newUserVO->setUsertype($usertype);
					}
					$stmt->close();
				}else{
					throw new DBException("UserDAO :: getUserVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $newUserVO;
		}
	
		function addUserVO(){
			$result = false;
			try{
				$dbConnection = DBUtil::getConnection();
				$userId = $userVO->getUserId();
				$username = $userVO->getUsername();
				$password = $userVO->getPassword();
				$usertype = $userVO->getUsertype();
				if($stmt = $dbConnection->prepare(ADD_USER_INFO)) {
					$stmt->bind_param('ssss',$userId,$username,$password,$usertype);
					$result = $stmt->execute();
					$stmt->close();
				}else{
					throw new DBException("UserDAO :: addUserVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function modifyUserVO(){
			$result = false;
			try{
				$dbConnection = DBUtil::getConnection();
				$userId = $userVO->getUserId();
				$username = $userVO->getUsername();
				$password = $userVO->getPassword();
				$usertype = $userVO->getUsertype();
				if($stmt = $dbConnection->prepare(MODIFY_USER_INFO)) {
					$stmt->bind_param('ssss',$userId,$username,$password,$usertype);
					$result = $stmt->execute();
					$stmt->close();
				}else{
					throw new DBException("UserDAO :: modifyUserVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function deleteUserVO($id){
			$result = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DELETE_USER_INFO)) {
					$stmt->bind_param('s',$id);
					$result = $stmt->execute();
					$stmt->close();
				}else{
					throw new DBException("UserDAO :: deleteUserVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
	}
?>