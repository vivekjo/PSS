<?php

	include_once '../dao/PaymentDAO.php';
	class PaymentReportManager{
		function getPaymentReport($queryString){
			$paymentList = null;
			try{
				$paymentDAO = new PaymentDAO();
				$paymentList = $paymentDAO->getAllPaymentVOsByQuery($queryString);
			}catch(DBException $e){
				throw $e;
			}
			return $paymentList;
		}
		
	}
?>