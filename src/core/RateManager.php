<?php
	
	include_once '../dao/RateDAO.php';
	
	class RateManager{
		function getAllRates(){
			$ratesList = null;
			$rateDAO = new RateDAO();
			$ratesList = $rateDAO->getAllRates();
			return $ratesList;
		}
		
		function modifyRate($metal,$value){
			$response = false;
			$rateDAO = new RateDAO();
			$response = $rateDAO->modifyRate($metal,$value);
			return $response;
		}
		
		function getRateByType($metal){
			$rateVO = false;
			$rateDAO = new RateDAO();
			$rateVO = $rateDAO->getRateByType($metal);
			return $rateVO;
		}
		
	}
?>