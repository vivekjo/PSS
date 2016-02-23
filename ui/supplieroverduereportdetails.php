<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
	include_once '../src/vo/SupplierVO.php'; 
	include_once '../src/vo/PaymentTypeVO.php'; 
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Supplier Payment Report :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/paymentreportdetails.css" />
		
		<script src="../js/reports/paymentreport.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script src="../js/util/validator.js"></script>
		
		<script type="text/javascript" src="../js/3putil/sortable.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery-1.4.2.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.core.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.datepicker.js"></script>
		
		<script type="text/javascript">
			
			function init(){
				sortables_init();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				date = document.getElementById("paymentdate1").innerHTML;
				document.getElementById("paymentdate1").innerHTML = getFormattedDate(date,'/');
				date = document.getElementById("paymentdate2").innerHTML;
				document.getElementById("paymentdate2").innerHTML = getFormattedDate(date,'/');
			}
		</script>		
    </head>
    <body onload="init()">
				<form method="POST" action="">
					<div id="paymentreportdetaildiv">
						<?php 
							$paymentReportDetailArray = null;
					 		if(isset($_SESSION['reportDetailsArray'])){
					 			$paymentReportDetailArray = $_SESSION['reportDetailsArray'];
					 		}				
						?>
						<table class="purchase-table" cellpadding="3px" style="border:0px">
							<tr style="border:0px">
								<td colspan="4" height="35px" align="center" style="font-size:13px;font-weight:bold">
									SUPPLIERS WITH PAYMENT OVERDUE AS ON 
									<span id="paymentdate1"><?php echo $paymentReportDetailArray['date']; ?></span>
								</td>
							</tr>
						</table>
						
					</div>										
					<div id="paymentreportdiv">
						<table class="purchase-table" class="sortable" cellpadding="3px" FRAME="box" RULES="all">
							<tr id="r_1" height="20px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
								<td rowspan="2">
									S.no
								</td>
								<td rowspan="2" align="center" width="190px">
									Supplier Name
								</td>
								<td colspan="4" align="center">
									Payment Due
								</td>
								<td rowspan="2" align="center">
									Due Date
								</td>
							</tr>
							<tr style="background-color: #e7edf6;color: #000000;font-weight: bold;">
								<td align="center" width="50px"> 
									PG (g)
								</td>
								<td align="center" width="50px">
									LPG (g)
								</td> 
								<td align="center" width="50px">
									Silver (kg)
								</td>
								<td align="center" width="50px">
									Cash
								</td>
							</tr>
							<?php  
								$suppliersList = null;
								$supplierBalanceList = null;
								
								$pg = 0;
								$lpg = 0;
								$silver = 0;
								$cash = 0;
								
								$ppg = 0;
								$plpg = 0;
								$psilver = 0;
								$pcash = 0;
								
								$totalPg = 0;
								$totalLpg = 0;
								$totalSilver = 0;
								$totalCash = 0;
								
								if(isset($_SESSION['suppliersList'])){
									$suppliersList = $_SESSION['suppliersList'];
									$supplierBalanceList = $_SESSION['supplierBalanceList'];
									$supplierPaymentList = $_SESSION['supplierPaymentList'];
									$supplierBalanceVO = null;
									$count = 1;
									$rowCount = 0;
									if(count($suppliersList)!=0){
										foreach($suppliersList as $supplierVO){	
											$supplierBalanceVO = $supplierBalanceList[($count-1)];														
											$supplierPaymentVO = $supplierPaymentList[($count-1)];	
									?>
									<?php 
										/*if($count == 1){
											$supplierPaymentVO->setPg(0);
										}*/													
									?>
									<?php  
											
											$duePg = number_format($supplierPaymentVO->getPg(),3);
											$dueLpg = number_format($supplierPaymentVO->getLpg(),3);
											$dueSilver = number_format($supplierPaymentVO->getSilver(),3);
											$dueCash = number_format($supplierPaymentVO->getCash(),2);		
											if($duePg == 0 && $dueLpg == 0 && $dueSilver == 0 && $dueCash == 0){
												$rowCount++;
												$totalPg = $totalPg + $supplierBalanceVO->getPg();
												$totalLpg = $totalLpg + $supplierBalanceVO->getLpg();
												$totalSilver = $totalSilver +$supplierBalanceVO->getSilver();
												$totalCash = $totalCash + $supplierBalanceVO->getCash();											
								?>
											<tr>
												<td align="right"><?php echo $rowCount;?></td>
												<td id="<?php echo 'date' . $count ?>" ><?php echo $supplierVO->getSupplierName();?></td>
												<td align="right"><?php echo number_format($supplierBalanceVO->getPg(),3);?></td>
												<td align="right"><?php echo  number_format($supplierBalanceVO->getLpg(),3);?></td>
												<td align="right"><?php echo  number_format($supplierBalanceVO->getSilver(),3);?></td>
												<td align="right"><?php echo  number_format($supplierBalanceVO->getCash(),2);?></td>
												<?php
													
													}											
												?>									
											</tr>
							<?php
										$count++;  	
										}
									}
										if($rowCount != 0){							?>
											<tr style="background-color: #e7edf6;color: #000000;font-weight: bold;">
												<td></td>
												<td align="left">TOTAL </td>
											<td align="right"><?php echo number_format($totalPg,3);?></td>
												<td align="right"><?php echo  number_format($totalLpg,3);?></td>
												<td align="right"><?php echo  number_format($totalSilver,3);?></td>
												<td align="right"><?php echo  number_format($totalCash,2);?></td>
											</tr>
							<?php 
									}else{
							?>
									<tr>
										<td height="30px" colspan="9" align="center" colspan="18">
											THERE ARE NO DUE ENTRIES.
										</td>
									</tr>
							<?php 			
									}
									}
							?>
								
								</table>
				</form>
    </body>
</html>
