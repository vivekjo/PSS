<?php
	include_once '../dao/PaymentDAO.php';
	
	class PaymentManager{
		function addPayment($paymentVO){
			$newPaymentVO = null;
			try{
				$paymentDAO = new PaymentDAO();
				$newPaymentVO = $paymentDAO->addPayment($paymentVO);
			}catch(DBException $e){
				throw $e;
			}
			return $newPaymentVO;
		}
		
		function modifyPayment($paymentVO){
			$newPaymentVO = null;
			try{
				$paymentDAO = new PaymentDAO();
				$newPaymentVO = $paymentDAO->modifyPayment($paymentVO);
			}catch(DBException $e){
				throw $e;
			}
			return $newPaymentVO;
		}
		
		function getDaywisePayment($date){
			$paymentList = null;
			try{
				$paymentDAO = new PaymentDAO();
				$paymentList = $paymentDAO->getDaywisePayment($date);
			}catch(DBException $e){
				throw $e;
			}
			return $paymentList;
		}
		
		function getPaymentById($txnId){
			$paymentVO = null;
			try{
				$paymentDAO = new PaymentDAO();
				$paymentVO = $paymentDAO->getPaymentById($txnId);
			}catch(DBException $e){
				throw $e;
			}
			return $paymentVO;
		}
		
		function deletePayment($paymentVO){
			$result = 0;
			try{
				$paymentDAO = new PaymentDAO();
				$result = $paymentDAO->deletePayment($paymentVO);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
		
		function convertMetalValue($amount,$transferFrom,$transferTo){
			$result = 0;
			try{
				$paymentDAO = new PaymentDAO();
				$result = $paymentDAO->getMetalValue($amount,$transferFrom,$transferTo);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
	}
?>