<?php

	include_once '../dao/SuspenseentryDAO.php';
	class SuspenseReportManager{
		function getSuspenseReport($queryString1,$queryString2){
			$suspenseentryVOList = null;
			try{
				$suspenseentryDAO = new SuspenseentryDAO();
				$suspenseentryVOList = $suspenseentryDAO->getAllSuspenseentryVOsByQueryString($queryString1,$queryString2);
			}catch(DBException $e){
				throw $e;
			}
			return $suspenseentryVOList;
		}
		
	}
?>