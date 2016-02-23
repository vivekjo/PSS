<?php
	include_once '../core/CompanyManager.php';
	include_once '../vo/CompanyVO.php';
	include_once '../util/XMLBuilder.php';
	
	$action = $_POST['action'];
	
	$companyManager = new CompanyManager();
	$xmlBuilder = new XMLBuilder();
	
	$responseXML = null;
	header('Content-Type: text/xml');
	
	if($action == "GetOpening"){
		$openingVO = $companyManager->getOpening();
		$responseXML = $xmlBuilder->getCompanyVOAsXML($openingVO);
	}else if($action == "modify"){
		$opPg = $_POST['oppg'];
		$opLpg = $_POST['oplpg'];
		$opSilver = $_POST['opsilver'];
		$opCash = $_POST['opcash'];
	
		$companyVO = new CompanyVO();
		$companyVO->setId(1);
		$companyVO->setOpPg($opPg);
		$companyVO->setOpLpg($opLpg);
		$companyVO->setOpSilver($opSilver);
		$companyVO->setOpCash($opCash);
		$companyVO->setClPg($opPg);
		$companyVO->setClLpg($opLpg);
		$companyVO->setClSilver($opSilver);
		$companyVO->setClCash($opCash);
		
		$response = $companyManager->modifyOpening($companyVO);
		$responseXML = $xmlBuilder->buildResponse($response);
	}
	
	echo $responseXML;
?>