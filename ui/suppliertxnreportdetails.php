<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
	include_once '../src/vo/SupplierVO.php'; 
	include_once '../src/vo/PurchaseVO.php'; 
	include_once '../src/vo/PurchaseDetailsVO.php'; 
	include_once '../src/vo/PaymentVO.php'; 
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
		
		<script src="../js/reports/supplierreport.js"></script>
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
				getAllSuppliers();
				var tableObj = document.getElementById("purchasetable");
				//resortTable(1,tableObj,'up');
				//recalculate(tableObj);
			}

			function recalculate(tableObj){
				
			}
		</script>		
    </head>
    <body onload="init()">
				<form method="POST" action="">
					<div id="paymentreportdetaildiv">
						<?php
							$drPg = 0; 
							$drLpg = 0; 
							$drSilver = 0; 
							$drCash = 0; 
							
							$crPg = 0; 
							$crLpg = 0; 
							$crSilver = 0; 
							$crCash = 0; 
							
							
							$paymentReportDetailArray = null;
					 		if(isset($_SESSION['reportDetailsArray'])){
					 			$paymentReportDetailArray = $_SESSION['reportDetailsArray'];
					 		}				
						?>
						<table class="purchase-table" cellpadding="3px" style="border:0px">
							<tr style="border:0px">
								<td colspan="4" height="35px" align="center" style="font-size:13px;font-weight:bold">
									TRANSACTIONS OF
									<span id="suppliername"><?php echo $paymentReportDetailArray['supplierid']; ?></span>
									FROM 
									<span id="fromdate"><?php echo $paymentReportDetailArray['fromdate']; ?></span>
									TO
									<span id="todate"><?php echo $paymentReportDetailArray['todate']; ?></span>
								</td>
							</tr>
						</table>
					</div>										
					<div id="paymentreportdiv">
						<table id="purchasetable" class="purchase-table" cellpadding="3px" FRAME="box" RULES="all">
							<thead>
							<tr id="r_1" height="25px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
								<td rowspan="2">
									S.no
								</td>
								<td rowspan="2" align="center" width="60px">
									Date
								</td>
								<td rowspan="2" align="center" width="70px"> 
									Voucher No
								</td>
								<td rowspan="2" align="center" width="70px">
									Type
								</td> 
								<td rowspan="2" align="center" width="70px">
									Mode
								</td> 
								<td rowspan="2" align="center" width="70px">
									Value
								</td> 
								<td colspan="4" align="center" width="50px">
									Dr (Issue)
								</td>
								<td colspan="4" align="center" width="50px">
									Cr (Receipt)
								</td>
								<td colspan="4" align="center" width="50px">
									Balance
								</td>
							</tr>
							<tr style="background-color: #e7edf6;color: #000000;font-weight: bold;">
								<td align="center" width="50px">
									PG
								</td>
								<td align="center" width="50px">
									LPG
								</td>
								<td align="center" width="50px">
									Silver
								</td>
								<td align="center" width="50px">
									Cash
								</td>
								<td align="center" width="50px">
									PG
								</td>
								<td align="center" width="50px">
									LPG
								</td>
								<td align="center" width="50px">
									Silver
								</td>
								<td align="center" width="50px">
									Cash
								</td>
								<td align="center" width="50px">
									PG
								</td>
								<td align="center" width="50px">
									LPG
								</td>
								<td align="center" width="50px">
									Silver
								</td>
								<td align="center" width="50px">
									Cash
								</td>
							</tr>
							</thead>
							<?php  
								$count = 1;
								
								$pg = 0;
								$lpg = 0;
								$silver = 0;
								$cash = 0;
								
								if(isset($_SESSION['openingbalance'])){
									$openingVO = $_SESSION['openingbalance'];
									
									$pg = $openingVO->getPg();
									$lpg = $openingVO->getLpg();
									$silver = $openingVO->getSilver();
									$cash = $openingVO->getCash();
							?>
											<thead>
												<tr style="background-color: #EFEFEF;color: #000000;font-weight: bold;">
													<td colspan="14" align="left">BY OPENING BALANCE : </td>
													<td align="right"><?php echo number_format($openingVO->getPg(),3);?></td>
													<td align="right"><?php echo  number_format($openingVO->getLpg(),3);?></td>
													<td align="right"><?php echo  number_format($openingVO->getSilver(),3);?></td>
													<td align="right"><?php echo  number_format($openingVO->getCash(),2);?></td>
												</tr>
											</thead>
							<?php
								}
							?>
							<?php  
								$txnList = null;
								$paymentVO = null;
								$purchaseVO = null;	
								if(isset($_SESSION['txnList'])){
									$txnList = $_SESSION['txnList'];
									foreach($txnList as $value){
											$classType = get_class($value);
											if($classType == "PaymentVO"){
												$paymentVO = $value;
											
							?>
												<tr>
													<td align="right"><?php echo $count;?></td>
													<td align="center" id="<?php echo 'date' . $count ?>"><?php echo $paymentVO->getDate();?></td>
													<td align="center"><?php echo $paymentVO->getVoucherNo();?></td>
													<td align="center"><?php echo 'Payment';?></td>
													<td align="center"><?php echo $paymentVO->getPaymentMode();?></td>
													<td align="right"><?php echo number_format($paymentVO->getAmount(),3);?></td>
													<?php 
														if($paymentVO->getAdjustWith() == "pg"){
															$pg = $pg - $paymentVO->getAdjustAmount();
															$drPg = $drPg + $paymentVO->getAdjustAmount();
													?>
														<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($paymentVO->getAdjustWith() == "lpg"){
															$lpg = $lpg - $paymentVO->getAdjustAmount();
															$drLpg = $drLpg + $paymentVO->getAdjustAmount();
													?>
														<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($paymentVO->getAdjustWith() == "silver"){
															$silver = $silver - $paymentVO->getAdjustAmount();
															$drSilver = $drSilver + $paymentVO->getAdjustAmount();
													?>
														<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($paymentVO->getAdjustWith() == "cash"){
															$cash = $cash - $paymentVO->getAdjustAmount();
															$drCash = $drCash + $paymentVO->getAdjustAmount();
													?>
														<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),2);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													
													<td align="right"><?php echo number_format($pg,3)?></td>
													<td align="right"><?php echo number_format($lpg,3)?></td>
													<td align="right"><?php echo number_format($silver,3)?></td>
													<td align="right"><?php echo number_format($cash,2)?></td>
													
												</tr>
							<?php
										$count++;
										}else if($classType = "PurchaseVO"){
											$purchaseVO = $value;
											$purchaseDetailsList = $purchaseVO->getPurchaseDetailsList();
											foreach($purchaseDetailsList as $purchaseDetailsVO){
							?>
												<tr>
													<td align="right"><?php echo $count;?></td>
													<td align="center" id="<?php echo 'date' . $count ?>"><?php echo $purchaseVO->getDate();?></td>
													<td align="center"><?php echo $purchaseVO->getBillNo();?></td>
													<td align="center"><?php echo 'Purchase';?></td>
													<td align="center"><?php echo 'PG';?></td>
													<td align="right"><?php echo number_format($purchaseDetailsVO->getCtPure(),3);?></td>						
													
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "pg"){
															$pg = $pg + $purchaseDetailsVO->getMaintainMetalValue();
															$crPg = $crPg + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "lpg"){
															$lpg = $lpg + $purchaseDetailsVO->getMaintainMetalValue();
															$crLpg = $crLpg + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "silver"){
															$silver = $silver + $purchaseDetailsVO->getMaintainMetalValue();
															$crSilver = $crSilver + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "cash"){
															$cash = $cash + $purchaseDetailsVO->getMaintainMetalValue();
															$crCash = $crCash + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),2);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													
													
													<td align="right"><?php echo number_format($pg,3)?></td>
													<td align="right"><?php echo number_format($lpg,3)?></td>
													<td align="right"><?php echo number_format($silver,3)?></td>
													<td align="right"><?php echo number_format($cash,2)?></td>
												</tr>
												
												<?php $count++;?>
												<tr>
													<td align="right"><?php echo $count;?></td>
													<td align="center" id="<?php echo 'date' . $count ?>"><?php echo $purchaseVO->getDate();?></td>
													<td align="center"><?php echo $purchaseVO->getBillNo();?></td>
													<td align="center"><?php echo 'Purchase';?></td>
													<td align="center"><?php echo 'Cash';?></td>
													<td align="right"><?php echo number_format($purchaseDetailsVO->getMc(),3);?></td>						
													
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "pg"){
															$pg = $pg + $purchaseDetailsVO->getMaintainMcValue();
															$crPg = $crPg + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "lpg"){
															$lpg = $lpg + $purchaseDetailsVO->getMaintainMcValue();
															$crLpg = $crLpg + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "silver"){
															$silver = $silver + $purchaseDetailsVO->getMaintainMcValue();
															$crSilver = $crSilver + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "cash"){
															$cash = $cash + $purchaseDetailsVO->getMaintainMcValue();
															$crCash = $crCash + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),2);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													
													
													<td align="right"><?php echo number_format($pg,3)?></td>
													<td align="right"><?php echo number_format($lpg,3)?></td>
													<td align="right"><?php echo number_format($silver,3)?></td>
													<td align="right"><?php echo number_format($cash,2)?></td>
												</tr>
							<?php 
												$count++;
											}
										}
									}
								}else{
									echo 'no list in session';
								}
							?>
								<tr>
									<td colspan="6" align="left">TOTAL : </td>
									<td align="right"><?php echo number_format($drPg,3);?></td>
									<td align="right"><?php echo  number_format($drLpg,3);?></td>
									<td align="right"><?php echo  number_format($drSilver,3);?></td>
									<td align="right"><?php echo  number_format($drCash,2);?></td>
									<td align="right"><?php echo number_format($crPg,3);?></td>
									<td align="right"><?php echo  number_format($crLpg,3);?></td>
									<td align="right"><?php echo  number_format($crSilver,3);?></td>
									<td align="right"><?php echo  number_format($crCash,2);?></td>
									<td colspan="4" align="right"></td>
								</tr>
							
							<?php  
								if(isset($_SESSION['closingbalance'])){
									$closingVO = $_SESSION['closingbalance'];
							?>
											<tfoot>
												<tr style="background-color:#EFEFEF;font-weight:bold">
													<td colspan="14" align="left">BY CLOSING BALANCE : </td>
													<td align="right"><?php echo number_format($closingVO->getPg(),3);?></td>
													<td align="right"><?php echo  number_format($closingVO->getLpg(),3);?></td>
													<td align="right"><?php echo  number_format($closingVO->getSilver(),3);?></td>
													<td align="right"><?php echo  number_format($closingVO->getCash(),2);?></td>
												</tr>
											</tfoot>
							<?php
								}
							?>
								</table>
				</form>
    </body>
</html>