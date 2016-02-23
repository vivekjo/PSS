<?php
	include_once '../vo/PaymentTypeVO.php';
	include_once '../vo/DaybookVO.php';
	
	include_once '../dao/DaybookDAO.php';
	include_once '../dao/ProjectionDAO.php';
	
	include_once '../core/PaymentScheduleManager.php';
	include_once '../core/AccountsManager.php';
	
	include_once '../util/XMLBuilder.php';
	include_once '../3putils/Collection.php';
	
	class PurchasePlannerManager{
		
		function getPurchasePlanner($fromdate,$todate){
			
			$xmlBuilder = new XMLBuilder();
			$daybookDAO = new DaybookDAO();
			$projectionDAO = new ProjectionDAO();
			$paymentScheduleManager = new PaymentScheduleManager();
			$accountsManager = new AccountsManager();
			
			$incomingsList = array();
			$incomingList = null;
			
			$outgoingsList = array();
			$outgoingList = null;
			
			$projectedIncomingsList = array();
			$projectedIncomingList = null;
			
			$projectedOutgoingsList = array();
			$projectedOutgoingList = null;	
			
			$vendorPaymentsList = array();
			$vendorPaymentVO = null;
			
			$fromdate = $xmlBuilder->getFormattedDate($fromdate);
			$todate = $xmlBuilder->getFormattedDate($todate);
			
			$tmpdate = $fromdate;
			while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
				
				$incomingList = $daybookDAO->getIncomingListByDate($tmpdate);
				$incomingsList[$tmpdate] = $incomingList;
				
				$outgoingList = $daybookDAO->getOutgoingListByDate($tmpdate);
				$outgoingsList[$tmpdate] = $outgoingList;
				
				$projectedIncomingList = $projectionDAO->getIncomingListByDate($tmpdate);
				$projectedIncomingsList[$tmpdate] = $projectedIncomingList;
				
				$projectedOutgoingList = $projectionDAO->getOutgoingListByDate($tmpdate);
				$projectedOutgoingsList[$tmpdate] = $projectedOutgoingList;
				
				$vendorPaymentVO = $paymentScheduleManager->getAllSuppliersPaymentValueForDate($tmpdate);
				$vendorPaymentsList[$tmpdate] = $vendorPaymentVO;
				
				$tmpdate = $xmlBuilder->getNextDate($tmpdate);
			}
			
			$incomingHeads = $accountsManager->getIncomingHeads();
			$outgoingHeads = $accountsManager->getOutgoingHeads();
			
			$_SESSION['incomingHeads'] = $incomingHeads;
			$_SESSION['outgoingHeads'] = $outgoingHeads;
			$_SESSION['incomingsList'] = $incomingsList;
			$_SESSION['outgoingsList'] = $outgoingsList;
			$_SESSION['projectedIncomingsList'] = $projectedIncomingsList;
			$_SESSION['projectedOutgoingsList'] = $projectedOutgoingsList;
			$_SESSION['vendorPaymentsList'] = $vendorPaymentsList;
			
		}
}
?>