<?php
	
	include_once '../core/EmployeeManager.php';
	include_once '../vo/EmployeeVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$employeeManager = new EmployeeManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetAllEmployees"){
		$employeesList = $employeeManager->getAllEmployees();
		$responseXML = $xmlBuilder->getEmployeesListAsXML($employeesList);
	}else if($action == "getemployeedetails"){
		$employeeId = $_POST['employeeid'];
		$employeeVO = $employeeManager->getEmployeeDetails($employeeId);
		$responseXML = $xmlBuilder->getEmployeeVOAsXML($employeeVO);
	}else if($action == "add"){
		$employeeName = $_POST['employeename'];
		$employeeVO = new EmployeeVO();
		$employeeVO->setEmployeeName($employeeName);
		try{
			$response = $employeeManager->addEmployee($employeeVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$employeeId = $_POST['employeeid'];
		$employeeName = $_POST['employeename'];
		
		$employeeVO = new EmployeeVO();
		$employeeVO->setEmployeeId($employeeId);
		$employeeVO->setEmployeeName($employeeName);
		
		try{
			$response = $employeeManager->modifyEmployee($employeeVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$employeeId = $_POST['employeeid'];
		$response = $employeeManager->deleteEmployee($employeeId);
		$responseXML = $xmlBuilder->buildResponse($response);
	}
	
	echo $responseXML;
?>