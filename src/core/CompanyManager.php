<?php
	include_once '../dao/CompanyDAO.php';
	
	class CompanyManager{
		function getOpening(){
			$openingVO = null;
			$companyDAO = new CompanyDAO();
			$openingVO = $companyDAO->getCompanyVO(1);
			return $openingVO;
		}
		function modifyOpening($companyVO){
			$result = 0;
			$companyDAO = new CompanyDAO();
			$result = $companyDAO->modifyCompanyVO($companyVO);
			return $result;
		}
	}
?>