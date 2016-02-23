<?php

	include_once '../dao/EmployeeDAO.php';
	
	class EmployeeManager{
		function getAllEmployees(){
			$employeeList = null;
			$employeeDAO = new EmployeeDAO();
			$employeeList = $employeeDAO->getAllEmployees();
			return $employeeList;
		}
		
		function getEmployeeDetails($employeeId){
			$employeeVO = null;
			$employeeDAO = new EmployeeDAO();
			$employeeVO = $employeeDAO->getEmployeeVO($employeeId);
			return $employeeVO;
		}
		
		function addEmployee($employeeVO){
			$result = false;
			try{
				$employeeDAO = new EmployeeDAO();
				$result = $employeeDAO->addEmployeeVO($employeeVO);
			}catch(DBException $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function modifyEmployee($employeeVO){
			$result = false;
			try{
				$employeeDAO = new EmployeeDAO();
				$result = $employeeDAO->modifyEmployeeVO($employeeVO);
			}catch(DBException $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function deleteEmployee($employeeId){
			$result = false;
			$employeeDAO = new EmployeeDAO();
			$result = $employeeDAO->deleteEmployeeVO($employeeId);
			return $result;
		}
		
	}
	
	
?>