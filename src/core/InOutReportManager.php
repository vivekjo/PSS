<?php

	include_once '../dao/SubItemDAO.php';
	include_once '../dao/InoutDAO.php';
	include_once '../util/XMLBuilder.php';
	
	class InOutReportManager{
		function getInOutEntryReport($queryString1,$queryString2){
			$inoutentryVOList = null;
			try{
				$inoutentryDAO = new InoutentryDAO();
				$inoutentryVOList = $inoutentryDAO->getAllInoutentryVOsByQueryString($queryString1,$queryString2);
			}catch(DBException $e){
				throw $e;
			}
			return $inoutentryVOList;
		}
		
		function getinoutInventoryReport($selecteddate){
			$xmlBuilder = new XMLBuilder();
			$inoutentryVOList = null;
			try{
				$inoutentryDAO = new InoutentryDAO();
				
				$selecteddate = $xmlBuilder->getFormattedDate($selecteddate);
				$nextDate = $xmlBuilder->getNextDate($selecteddate);
				
				$opInList = $inoutentryDAO->getOpeningInoutInventory($selecteddate,"IN");
				$opOutList = $inoutentryDAO->getOpeningInoutInventory($selecteddate,"OUT");
				$selectedDaysOpeningInout = $this->getConsolidatedInOutList($opInList,$opOutList);
				
				$inList = $inoutentryDAO->getInoutInventory($selecteddate,"IN");
				$outList = $inoutentryDAO->getInoutInventory($selecteddate,"OUT");
				
				$clInList = $inoutentryDAO->getOpeningInoutInventory($nextDate,"IN");
				$clOutList = $inoutentryDAO->getOpeningInoutInventory($nextDate,"OUT");
				$selectedDaysClosingInout = $this->getConsolidatedInOutList($clInList,$clOutList);
				
				$subitemDAO = new SubItemDAO();
				$parentList = $subitemDAO->getAllSubitemsParents();
				
				$_SESSION['opinout'] = $selectedDaysOpeningInout;
				$_SESSION['inlist'] = $inList;
				$_SESSION['outlist'] = $outList;
				$_SESSION['clinout'] = $selectedDaysClosingInout;
				$_SESSION['parentGroup'] = $parentList[0];
				$_SESSION['parentItem'] = $parentList[1];
				
			}catch(DBException $e){
				throw $e;
			}
			return $inoutentryVOList;
		}
		
		function getConsolidatedInOutList($inList,$outList){
			$tmpList = array();
			foreach($inList as $subitemId=>$inpcs){
				if(isset($outList[$subitemId])){
					$outpcs = $outList[$subitemId];
					if(($inpcs - $outpcs) > 0){
						$tmpList[$subitemId] = $inpcs - $outpcs;
					}
					unset($outList[$subitemId]);
				}else{
					if($inpcs > 0)
						$tmpList[$subitemId] = $inpcs;
				}
			}
			foreach($outList as $subitemId=>$outpcs){
				if($outpcs > 0)
					$tmpList[$subitemId] = $outpcs * -1;
			}
			ksort($tmpList);
			return $tmpList;
		}
	}
?>