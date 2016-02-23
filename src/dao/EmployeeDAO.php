<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/EmployeeVO.php';

	class EmployeeDAO {


	function getAllEmployees(){
		$employeeVOList =  new CU_Collection('EmployeeVO');
		try{
			$employeeVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_ALL_EMPLOYEES)) {
				$stmt->execute();
				$stmt->bind_result($employeeId,$employeeName);
				while($stmt->fetch()){
					$employeeVO = new EmployeeVO();
					$employeeVO->setEmployeeId($employeeId);
					$employeeVO->setEmployeeName($employeeName);
					$employeeVOList->add($employeeVO);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $employeeVOList;
	}

	function getEmployeeVO($employeeId){
		try{
			$employeeVO = null;
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(GET_EMPLOYEE_INFO)) {
				$stmt->bind_param('s',$employeeId);
				$stmt->execute();
				$stmt->bind_result($employeeId,$employeeName);
				if($stmt->fetch()){

					$employeeVO = new EmployeeVO();
					$employeeVO->setEmployeeId($employeeId);
					$employeeVO->setEmployeeName($employeeName);
				}
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $employeeVO;
	}

	function addEmployeeVO($employeeVO){
		$result = false;
		$dbConnection = null;
		try{
			$employeeName = $employeeVO->getEmployeeName();
			$isDuplicate = $this->doesEmployeeExists($employeeName);
			if($isDuplicate != true){
				$dbConnection = DBUtil::getConnection();
				
				if($stmt = $dbConnection->prepare(ADD_EMPLOYEE_INFO)) {
					$stmt->bind_param('s',$employeeName);
					$result = $stmt->execute();
					$stmt->close();
				}
				$dbConnection->close();
			}else{
				throw new DBException("Employee Name already exists. Please provide a different Employee name.");
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function modifyEmployeeVO($employeeVO){
		$result = false;
		try{
			$employeeId = $employeeVO->getEmployeeId();
			$employeeName = $employeeVO->getEmployeeName();
			$isDuplicate = $this->doesOtherEmployeeExists($employeeName,$employeeId);
			if($isDuplicate != true){
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(MODIFY_EMPLOYEE_INFO)) {
					$stmt->bind_param('ss',$employeeId,$employeeName);
					$result = $stmt->execute();
					$stmt->close();
				}
				$dbConnection->close();
			}else{
				throw new DBException("Employee Name already exists. Please provide a different Employee name.");
			}
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}

	function deleteEmployeeVO($id){
		$result = false;
		try{
			$dbConnection = DBUtil::getConnection();
			if($stmt = $dbConnection->prepare(DELETE_EMPLOYEE_INFO)) {
				$stmt->bind_param('s',$id);
				$result = $stmt->execute();
				$stmt->close();
			}
			$dbConnection->close();
		}catch(Exception $e){
			throw new DBException($e->getMessage());
		}
		return $result;
	}
	
	function doesEmployeeExists($employeeName){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_EMPLOYEE_EXISTS)) {
					$stmt->bind_param('s',$employeeName);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("EmployeeDAO :: doesEmployeeExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
		
		function doesOtherEmployeeExists($employeeName,$employeeId){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_OTHER_EMPLOYEE_EXISTS)) {
					$stmt->bind_param('ss',$employeeName,$employeeId);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("EmployeeDAO :: doesOtherEmployeeExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
}
?>