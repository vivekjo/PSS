<?php
	include_once '../vo/PaymentVO.php';
	include_once '../vo/PurchaseVO.php';
	include_once '../vo/PurchasedetailsVO.php';
	include_once '../vo/PaymentTypeVO.php';
	include_once '../vo/SupplierVO.php';
	
	include_once '../dao/PurchaseDAO.php';
	include_once '../dao/PurchasedetailsDAO.php';
	include_once '../dao/PaymentDAO.php';
	include_once '../dao/SupplierDAO.php';
	
	include_once '../util/XMLBuilder.php';
	
	class PaymentScheduleManager{
		
		function getPaymentSchedule($fromdate,$todate,$supplierid){
			
			$paymentDAO = new PaymentDAO();
			$paymentList = $paymentDAO->getPaymentDetailsByDateRange($fromdate,$todate,$supplierid);
			
			$purchaseDAO = new PurchaseDAO();
			$purchasesList = $purchaseDAO->getPurchaseDetailsByDateRange($fromdate,$todate,$supplierid);
			
			$xmlBuilder = new XMLBuilder();
			
			$purchasesAsXML = $xmlBuilder->getPurchaseListAsXML($purchasesList);
			$paymentAsXML = $xmlBuilder->getPaymentListAsXML($paymentList);
			
			$xmlContent = $purchasesAsXML . $paymentAsXML;
			
			$xmlContent = $xmlBuilder->encloseTag($xmlContent,"paymentschedule");
			
			return $xmlContent;
		}
		
		function getSupplierBalanceForDate($supplierId,$date){
			$xmlBuilder = new XMLBuilder();
			$purchasedetailsDAO = new PurchaseDetailsDAO();
			$fromdate = "2011/04/01";
			$todate = $date;
			
			$todate = $xmlBuilder->getFormattedDate($todate);
			$tmptodate = $xmlBuilder->getNextDate($todate);
			
			$prevPayments = $this->getPaymentsByDateRange($fromdate,$tmptodate,$supplierId);
			
			$prevPurchaseMetalValue = $purchasedetailsDAO->getMetalValueByDateRange($supplierId,$todate);
			$prevPurchaseMcValue = $purchasedetailsDAO->getMcValueByDateRange($supplierId,$todate);
			
			$currentPurchaseMetalValue = $purchasedetailsDAO->getCurrentMetalValueByDateRange($supplierId,$todate);
			$currentPurchaseMcValue = $purchasedetailsDAO->getCurrentMcValueByDateRange($supplierId,$todate);
			
			/*echo 'Payments' . $prevPayments->toString();
			echo 'PrevMetal' . $prevPurchaseMetalValue->toString();
			echo 'PrevMc' . $prevPurchaseMcValue->toString();
			echo 'currMetal' . $currentPurchaseMetalValue->toString();
			echo 'currMc' . $currentPurchaseMcValue->toString();*/
			
			$suppliersBalance = $this->getSuppliersBalance($prevPayments,$prevPurchaseMetalValue,$prevPurchaseMcValue,$currentPurchaseMetalValue,$currentPurchaseMcValue);
			
			$xmlContent = $xmlBuilder->getBalanceAsXML($suppliersBalance);
			
			return $xmlContent;
		}
		
		function getSupplierTransactionsForDate($supplierId,$fromdate,$todate){
			$xmlBuilder = new XMLBuilder();
			$purchasedetailsDAO = new PurchaseDetailsDAO();
			$tmpFromdate = "2011-04-01";
			
			$todate = $xmlBuilder->getFormattedDate($todate);
			$fromdate = $xmlBuilder->getFormattedDate($fromdate);
			
			$tmptodate = $fromdate;
			//$tmptodate = $xmlBuilder->getNextDate($todate);
			
			$prevPayments = $this->getPaymentsByDateRange($tmpFromdate,$tmptodate,$supplierId);
			
			$purchaseMetalValue = $purchasedetailsDAO->getCompleteMetalValueByDateRange($supplierId,$tmptodate);
			$purchaseMcValue = $purchasedetailsDAO->getCompleteMcValueByDateRange($supplierId,$tmptodate);
			
			$suppliersOpeningBalance = $this->getSuppliersOpeningBalance($prevPayments,$purchaseMetalValue,$purchaseMcValue);
			
			$paymentDAO = new PaymentDAO();
			$paymentList = $paymentDAO->getPaymentDetailsByDateRange($fromdate,$todate,$supplierId);
			
			$purchaseDAO = new PurchaseDAO();
			
			echo 'fromdate => ' . $fromdate;
			echo 'todate => ' . $todate;
			echo 'supplierid => ' . $supplierId;
			$purchasesList = $purchaseDAO->getCompletePurchaseDetailsByDateRange($fromdate,$todate,$supplierId);
			
			/* CLOSING */
			$tmptodate = $xmlBuilder->getNextDate($todate);
			
			$prevPayments = $this->getPaymentsByDateRange($tmpFromdate,$tmptodate,$supplierId);
			
			$purchaseMetalValue = $purchasedetailsDAO->getCompleteMetalValueByDateRange($supplierId,$todate);
			$purchaseMcValue = $purchasedetailsDAO->getCompleteMcValueByDateRange($supplierId,$todate);
			
			$suppliersClosingBalance = $this->getSuppliersOpeningBalance($prevPayments,$purchaseMetalValue,$purchaseMcValue);
			
			$_SESSION['openingbalance'] = $suppliersOpeningBalance;
			$_SESSION['closingbalance'] = $suppliersClosingBalance;
			//$_SESSION['paymentsList'] = $paymentList;
			//$_SESSION['purchasesList'] = $purchasesList;
			
			$tmptxnList = array();
			$txnList = array();
			$count = 0;
			foreach($paymentList as $paymentVO){
				$txnList['PY'.$count] = $paymentVO->getDate();
				$count++;
			}
			$count = 0;
			foreach($purchasesList as $purchaseVO){
				$txnList['PU'.$count] = $purchaseVO->getDate();
				$count++;
			}
			
			asort($txnList);
			
			foreach($txnList as $key=>$value){
				$type = substr($key,0,2);
				$indexPos = substr($key,2,strlen($key));
				echo 'Index : ' . $key . "=>" . $indexPos . '<br />';
				if($type == "PY"){
					$tmptxnList[] = $paymentList[$indexPos];
				}else if($type == "PU"){
					$tmptxnList[] = $purchasesList[$indexPos];
				}
			}
			$_SESSION['txnList'] = $tmptxnList;
		}
		
		function getAllSuppliersBalanceForDate($date){
			$xmlBuilder = new XMLBuilder();
			$supplierBalanceList = new CU_Collection('PaymentTypeVO');
			$purchasedetailsDAO = new PurchaseDetailsDAO();
			$supplierDAO = new SupplierDAO();
			$fromdate = "2011/04/01";
			$todate = $date;
			
			$tmptodate = $xmlBuilder->getNextDate($todate);
			$todate = $xmlBuilder->getFormattedDate($todate);
			
			$supplierList = $supplierDAO->getAllSuppliers();
			$supplierId = 0;
			foreach($supplierList as $supplierVO){
				
				$supplierId = $supplierVO->getSupplierId();
				
				$prevPayments = $this->getPaymentsByDateRange($fromdate,$tmptodate,$supplierId);
			
				$prevPurchaseMetalValue = $purchasedetailsDAO->getMetalValueByDateRange($supplierId,$todate);
				$prevPurchaseMcValue = $purchasedetailsDAO->getMcValueByDateRange($supplierId,$todate);
				
				$currentPurchaseMetalValue = $purchasedetailsDAO->getCurrentMetalValueByDateRange($supplierId,$todate);
				$currentPurchaseMcValue = $purchasedetailsDAO->getCurrentMcValueByDateRange($supplierId,$todate);
				
				$suppliersBalance = $this->getSuppliersBalance($prevPayments,$prevPurchaseMetalValue,$prevPurchaseMcValue,$currentPurchaseMetalValue,$currentPurchaseMcValue);
				$supplierBalanceList->add($suppliersBalance);
			}
			
			return $supplierBalanceList;
		}
		
		function getAllSuppliersPaymentForDate($date){
			$xmlBuilder = new XMLBuilder();
			$supplierBalanceList = new CU_Collection('PaymentTypeVO');
			$purchasedetailsDAO = new PurchaseDetailsDAO();
			$supplierDAO = new SupplierDAO();
			$fromdate = "2011/04/01";
			
			$date = $xmlBuilder->getFormattedDate($date);
			
			$supplierList = $supplierDAO->getAllSuppliers();
			$supplierId = 0;
			foreach($supplierList as $supplierVO){
				
				$supplierId = $supplierVO->getSupplierId();
			
				$currentPurchaseMetalValue = $purchasedetailsDAO->getCurrentMetalValueByDate($supplierId,$date);
				$currentPurchaseMcValue = $purchasedetailsDAO->getCurrentMcValueByDate($supplierId,$date);
				$suppliersBalance = $this->getSuppliersPayments($currentPurchaseMetalValue,$currentPurchaseMcValue);
				
				$supplierBalanceList->add($suppliersBalance);
			}
			
			return $supplierBalanceList;
		}
		function getSuppliersLastPaymentDates(){
			$xmlBuilder = new XMLBuilder();
			$supplierLastPaymentDateList = new CU_Collection('PurchasedetailsVO');
			$supplierDAO = new SupplierDAO();
			$fromdate = "2011/04/01";
			
			$date = $xmlBuilder->getFormattedDate($date);
			
			$supplierList = $supplierDAO->getAllSuppliers();
			$supplierId = 0;
			foreach($supplierList as $supplierVO){
				
				$supplierId = $supplierVO->getSupplierId();
			
				$supplierLastPaymentDate = $this->getSuppliersLastPaymentDates($supplierId);
				
				$supplierLastPaymentDateList->add($supplierLastPaymentList);
			}
			
			return $supplierLastPaymentDateList;
		}
		
		function getSuppliersLastPaymentDates($supplierId){
			$purchasedetailsDAO = new PurchaseDetailsDAO();
			$lastPaymentDate = "";
			$prevPayments = null;
			try{
				$paymentDAO = new PaymentDAO();
				$prevPayments = $paymentDAO->getSupplierPaymentsByDateRange($fromdate,$todate,$supplierId);
			}catch(DBException $e){
				throw $e;
			}
			return $prevPayments;
			return $paymentTypeVO;
		}
		
		
		
		/* 
		 * Used in Purchase Planner Report 
		 * Returns vendor payment amount for a particular date. 
		 * 
		 */
		
		
		
		function getAllSuppliersPaymentValueForDate($date){
			$xmlBuilder = new XMLBuilder();
			$purchasedetailsDAO = new PurchaseDetailsDAO();
			$supplierDAO = new SupplierDAO();
			$paymentDAO = new PaymentDAO();
			$totalBalance = new PaymentTypeVO();
			$date = $xmlBuilder->getFormattedDate($date);
			
			$supplierList = $supplierDAO->getAllSuppliers();
			$supplierId = 0;
			foreach($supplierList as $supplierVO){
				
				$supplierId = $supplierVO->getSupplierId();
			
				$currentPurchaseMetalValue = $purchasedetailsDAO->getCurrentMetalValueByDate($supplierId,$date);
				$currentPurchaseMcValue = $purchasedetailsDAO->getCurrentMcValueByDate($supplierId,$date);
				$suppliersBalance = $this->getSuppliersPayments($currentPurchaseMetalValue,$currentPurchaseMcValue);
				
				$totalBalance = $this->getSuppliersPayments($totalBalance,$suppliersBalance);
			}
			
			$pgCashValue = $paymentDAO->getMetalValue($totalBalance->getPg(),"pg","cash");
			$lpgCashValue = $paymentDAO->getMetalValue($totalBalance->getLpg(),"lpg","cash");
			$silverCashValue = $paymentDAO->getMetalValue($totalBalance->getSilver(),"silver","cash");
			
			$totalBalance->setPg($pgCashValue);
			$totalBalance->setLpg($lpgCashValue);
			$totalBalance->setSilver($silverCashValue);
			
			return $totalBalance;
		}
		
		function getPaymentsByDateRange($fromdate,$todate,$supplierId){
			$prevPayments = null;
			try{
				$paymentDAO = new PaymentDAO();
				$prevPayments = $paymentDAO->getSupplierPaymentsByDateRange($fromdate,$todate,$supplierId);
			}catch(DBException $e){
				throw $e;
			}
			return $prevPayments;
		}
		
		function getSuppliersPayments($currentPurchaseMetalValue,$currentPurchaseMcValue){
			$paymentTypeVO = new PaymentTypeVO();
			$pg = 0;
			$lpg = 0;
			$silver = 0;
			$cash = 0;
			
			$pg =  floatval($currentPurchaseMetalValue->getPg()) + floatval($currentPurchaseMcValue->getPg());
			$lpg = floatval($currentPurchaseMetalValue->getLpg()) + floatval($currentPurchaseMcValue->getLpg());
			$silver = floatval($currentPurchaseMetalValue->getSilver()) + floatval($currentPurchaseMcValue->getSilver());
			$cash = floatval($currentPurchaseMetalValue->getCash()) + floatval($currentPurchaseMcValue->getCash());
			
			$paymentTypeVO->setPg($pg);
			$paymentTypeVO->setLpg($lpg);
			$paymentTypeVO->setSilver($silver);
			$paymentTypeVO->setCash($cash);
			
			return $paymentTypeVO;
		}
		
		function getSuppliersBalance($prevPayments,$prevPurchaseMetalValue,$prevPurchaseMcValue,$currentPurchaseMetalValue,$currentPurchaseMcValue){
			$paymentTypeVO = new PaymentTypeVO();
			$pg = 0;
			$lpg = 0;
			$silver = 0;
			$cash = 0;
			
			$pg = $prevPurchaseMetalValue->getPg() + $prevPurchaseMcValue->getPg() + $currentPurchaseMetalValue->getPg() + $currentPurchaseMcValue->getPg() - $prevPayments->getPg();
			$lpg = $prevPurchaseMetalValue->getLpg() + $prevPurchaseMcValue->getLpg() + $currentPurchaseMetalValue->getLpg() + $currentPurchaseMcValue->getLpg() - $prevPayments->getLpg();
			$silver = $prevPurchaseMetalValue->getSilver() + $prevPurchaseMcValue->getSilver() + $currentPurchaseMetalValue->getSilver() + $currentPurchaseMcValue->getSilver() - $prevPayments->getSilver();
			$cash = $prevPurchaseMetalValue->getCash() + $prevPurchaseMcValue->getCash() + $currentPurchaseMetalValue->getCash() + $currentPurchaseMcValue->getCash() - $prevPayments->getCash();
			
			$paymentTypeVO->setPg($pg);
			$paymentTypeVO->setLpg($lpg);
			$paymentTypeVO->setSilver($silver);
			$paymentTypeVO->setCash($cash);
			
			return $paymentTypeVO;
		}
		
		function getSuppliersOpeningBalance($prevPayments,$prevPurchaseMetalValue,$prevPurchaseMcValue){
			$paymentTypeVO = new PaymentTypeVO();
			$pg = 0;
			$lpg = 0;
			$silver = 0;
			$cash = 0;
			
			$pg = $prevPurchaseMetalValue->getPg() + $prevPurchaseMcValue->getPg()  - $prevPayments->getPg();
			$lpg = $prevPurchaseMetalValue->getLpg() + $prevPurchaseMcValue->getLpg()  - $prevPayments->getLpg();
			$silver = $prevPurchaseMetalValue->getSilver() + $prevPurchaseMcValue->getSilver() - $prevPayments->getSilver();
			$cash = $prevPurchaseMetalValue->getCash() + $prevPurchaseMcValue->getCash() - $prevPayments->getCash();
			
			$paymentTypeVO->setPg($pg);
			$paymentTypeVO->setLpg($lpg);
			$paymentTypeVO->setSilver($silver);
			$paymentTypeVO->setCash($cash);
			
			return $paymentTypeVO;
		}
		
}
?>