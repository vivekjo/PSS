<?php
	
	include_once '../core/SupplierManager.php';
	include_once '../vo/SupplierVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$supplierManager = new SupplierManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetAllSuppliers"){
		$suppliersList = $supplierManager->getAllSuppliers();
		$responseXML = $xmlBuilder->getSuppliersListAsXML($suppliersList);
	}else if($action == "getsupplierdetails"){
		$supplierId = $_POST['supplierid'];
		$supplierVO = $supplierManager->getSupplierDetails($supplierId);
		$responseXML = $xmlBuilder->getSupplierVOAsXML($supplierVO);
	}else if($action == "add"){
		$supplierName = $_POST['suppliername'];
		$opPg = $_POST['oppg'];
		$opLpg = $_POST['oplpg'];
		$opSilver = $_POST['opsilver'];
		$opCash = $_POST['opcash'];
		
		$supplierVO = new SupplierVO();
		$supplierVO->setSupplierName($supplierName);
		$supplierVO->setOpPg($opPg);
		$supplierVO->setOpLpg($opLpg);
		$supplierVO->setOpSilver($opSilver);
		$supplierVO->setOpCash($opCash);
		$supplierVO->setClPg($opPg);
		$supplierVO->setClLpg($opLpg);
		$supplierVO->setClSilver($opSilver);
		$supplierVO->setClCash($opCash);
		
		try{
			$response = $supplierManager->addSupplier($supplierVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "modify"){
		$supplierId = $_POST['supplierid'];
		$supplierName = $_POST['suppliername'];
		$opPg = $_POST['oppg'];
		$opLpg = $_POST['oplpg'];
		$opSilver = $_POST['opsilver'];
		$opCash = $_POST['opcash'];
		
		$supplierVO = new SupplierVO();
		$supplierVO->setSupplierId($supplierId);
		$supplierVO->setSupplierName($supplierName);
		$supplierVO->setOpPg($opPg);
		$supplierVO->setOpLpg($opLpg);
		$supplierVO->setOpSilver($opSilver);
		$supplierVO->setOpCash($opCash);
		$supplierVO->setClPg($opPg);
		$supplierVO->setClLpg($opLpg);
		$supplierVO->setClSilver($opSilver);
		$supplierVO->setClCash($opCash);
		try{
			$response = $supplierManager->modifySupplier($supplierVO);
			$responseXML = $xmlBuilder->buildResponse($response);
		}catch(DBException $e){
			$responseXML = $xmlBuilder->buildErrorXML($e->getMessage());
		}
	}else if($action == "delete"){
		$supplierId = $_POST['supplierid'];
		$response = $supplierManager->deleteSupplier($supplierId);
		$responseXML = $xmlBuilder->buildResponse($response);
	}
	
	echo $responseXML;
?>