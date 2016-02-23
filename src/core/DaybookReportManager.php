<?php
	
	include_once '../vo/DaybookVO.php';
	include_once '../vo/CompanyVO.php';
	include_once '../vo/PaymentVO.php';
	include_once '../vo/PurchaseVO.php';
	include_once '../vo/PurchasedetailsVO.php';
	include_once '../vo/TransferVO.php';
	
	include_once '../dao/CompanyDAO.php';
	include_once '../dao/DaybookDAO.php';
	include_once '../dao/PurchaseDAO.php';
	include_once '../dao/PurchasedetailsDAO.php';
	include_once '../dao/TransferDAO.php';
	include_once '../dao/PaymentDAO.php';
	include_once '../vo/PaymentTypeVO.php';

	include_once '../util/XMLBuilder.php';

	class DaybookReportManager{
	
		function getDaybook($date){
			
			$xmlBuilder = new XMLBuilder();
			$openingVO = $this->getOpening();
			$fromdate = "2011/04/01";
			$todate = $date;
			
			$prevPayments = $this->getPaymentsByDateRange($fromdate,$todate);
			$prevIncomings = $this->getIncomingByDateRange($fromdate,$todate);
			$prevOutgoings = $this->getOutgoingByDateRange($fromdate,$todate);
			$daysOpeningVO = $this->getDaysOpening($openingVO,$prevPayments,$prevIncomings,$prevOutgoings);
			
			$purchaseDAO = new PurchaseDAO();
			$purchaseList = $purchaseDAO->getDatewisePurchase($date);	
			
			$paymentDAO = new PaymentDAO();
			$paymentList = $paymentDAO->getDaywisePayment($date);
			
			$daybookDAO = new DaybookDAO();
			$accountsIncomingList = $daybookDAO->getIncomingByDate($date);		 
			$accountsOutgoingList = $daybookDAO->getOutgoingByDate($date);
			
			$transfersDAO = new TransferDAO();
			$transfersList = $transfersDAO->getDaywiseTransfers($date);
			
			$tmptodate = $xmlBuilder->getNextDate($todate);
			$fromdate = $todate;
			$todate = $tmptodate;
			
			$daysPayments = $this->getPaymentsByDateRange($fromdate,$todate);
			$daysIncomings = $this->getIncomingByDateRange($fromdate,$todate);
			$daysOutgoings = $this->getOutgoingByDateRange($fromdate,$todate);
			$daysClosingVO = $this->getDaysOpening($daysOpeningVO,$daysPayments,$daysIncomings,$daysOutgoings);
			
			$xmlContent = "";
			$openingAsXML = $xmlBuilder->getOpeningAsXML($daysOpeningVO);
			$paymentAsXML = $xmlBuilder->getPaymentListAsXML($paymentList);
			$incomingListAsXML = $xmlBuilder->getAccountsListAsXML($accountsIncomingList,"incoming");
			$outgoingListAsXML = $xmlBuilder->getAccountsListAsXML($accountsOutgoingList,"outgoing");
			
			$transfersAsXML = $xmlBuilder->getTransfersListAsXML($transfersList);
			$purchasesAsXML = $xmlBuilder->getPurchaseListAsXML($purchaseList);
			$closingAsXML = $xmlBuilder->getClosingAsXML($daysClosingVO);
			$xmlContent = $openingAsXML . $paymentAsXML . $incomingListAsXML . $outgoingListAsXML . $transfersAsXML . $purchasesAsXML . $closingAsXML;
			
			$xmlContent = $xmlBuilder->encloseTag($xmlContent,"daybookreport");
			
			return $xmlContent;
		}
		function getDetailedDaybook($date){
			
			$xmlBuilder = new XMLBuilder();
			$openingVO = $this->getOpening();
			$fromdate = "2011/04/01";
			$todate = $date;
			
			$prevPayments = $this->getPaymentsByDateRange($fromdate,$todate);
			$prevIncomings = $this->getIncomingByDateRange($fromdate,$todate);
			$prevOutgoings = $this->getOutgoingByDateRange($fromdate,$todate);
			$daysOpeningVO = $this->getDaysOpening($openingVO,$prevPayments,$prevIncomings,$prevOutgoings);
			
			$purchaseDAO = new PurchaseDAO();
			$purchaseList = $purchaseDAO->getDatewisePurchase($date);	
			
			$paymentDAO = new PaymentDAO();
			$paymentList = $paymentDAO->getDaywisePayment($date);
			
			$daybookDAO = new DaybookDAO();
			$accountsIncomingList = $daybookDAO->getDetailedIncomingByDate($date);		 
			$accountsOutgoingList = $daybookDAO->getDetailedOutgoingByDate($date);
			
			$transfersDAO = new TransferDAO();
			$transfersList = $transfersDAO->getDaywiseTransfers($date);
			
			$tmptodate = $xmlBuilder->getNextDate($todate);
			$fromdate = $todate;
			$todate = $tmptodate;
			
			$daysPayments = $this->getPaymentsByDateRange($fromdate,$todate);
			$daysIncomings = $this->getIncomingByDateRange($fromdate,$todate);
			$daysOutgoings = $this->getOutgoingByDateRange($fromdate,$todate);
			$daysClosingVO = $this->getDaysOpening($daysOpeningVO,$daysPayments,$daysIncomings,$daysOutgoings);
			
			$xmlContent = "";
			$openingAsXML = $xmlBuilder->getOpeningAsXML($daysOpeningVO);
			$paymentAsXML = $xmlBuilder->getPaymentListAsXML($paymentList);
			$incomingListAsXML = $xmlBuilder->getAccountsListAsXML($accountsIncomingList,"incoming");
			$outgoingListAsXML = $xmlBuilder->getAccountsListAsXML($accountsOutgoingList,"outgoing");
			
			$transfersAsXML = $xmlBuilder->getTransfersListAsXML($transfersList);
			$purchasesAsXML = $xmlBuilder->getPurchaseListAsXML($purchaseList);
			$closingAsXML = $xmlBuilder->getClosingAsXML($daysClosingVO);
			$xmlContent = $openingAsXML . $paymentAsXML . $incomingListAsXML . $outgoingListAsXML . $transfersAsXML . $purchasesAsXML . $closingAsXML;
			
			$xmlContent = $xmlBuilder->encloseTag($xmlContent,"daybookreport");
			
			return $xmlContent;
		}
		
		function getDaysOpening($openingVO,$prevPayments,$prevIncomings,$prevOutgoings){
			$paymentTypeVO = new PaymentTypeVO();
			$pg = 0;
			$lpg = 0;
			$silver = 0;
			$cash = 0;
			
			$pg = $openingVO->getPg() + $prevIncomings->getPg() - $prevOutgoings->getPg() - $prevPayments->getPg();
			$lpg = $openingVO->getLpg() + $prevIncomings->getLpg() - $prevOutgoings->getLpg() - $prevPayments->getLpg();
			$silver = $openingVO->getSilver() + $prevIncomings->getSilver() - $prevOutgoings->getSilver() - $prevPayments->getSilver();
			$cash = $openingVO->getCash() + $prevIncomings->getCash() - $prevOutgoings->getCash() - $prevPayments->getCash();
			
			$paymentTypeVO->setPg($pg);
			$paymentTypeVO->setLpg($lpg);
			$paymentTypeVO->setSilver($silver);
			$paymentTypeVO->setCash($cash);
			
			return $paymentTypeVO;
		}
		
		function getOpening(){
			$paymentTypeVO = new PaymentTypeVO();
			$openingVO = null;
			$companyDAO = new CompanyDAO();
			$openingVO = $companyDAO->getCompanyVO(1);
			$paymentTypeVO->setPg($openingVO->getOpPg());
			$paymentTypeVO->setLPg($openingVO->getOpLpg());
			$paymentTypeVO->setSilver($openingVO->getOpSilver());
			$paymentTypeVO->setCash($openingVO->getOpCash());
			return $paymentTypeVO;
		}
		
		function getPaymentsByDateRange($fromdate,$todate){
			$prevPayments = null;
			try{
				$paymentDAO = new PaymentDAO();
				$prevPayments = $paymentDAO->getPaymentsByDateRange($fromdate,$todate);
			}catch(DBException $e){
				throw $e;
			}
			return $prevPayments;
		}
		 
		function getIncomingByDateRange($fromdate,$todate){
			$accountsList = null;
			$daybookDAO = new DaybookDAO();
			$accountsList = $daybookDAO->getIncomingByDateRange($fromdate,$todate);
			return $accountsList;
		}
		function getOutgoingByDateRange($fromdate,$todate){
			$accountsList = null;
			$daybookDAO = new DaybookDAO();
			$accountsList = $daybookDAO->getOutgoingByDateRange($fromdate,$todate);
			return $accountsList;
		}
	}
?>