<?php
	include_once '../src/vo/PurchaseVO.php'; 
	include_once '../src/vo/PurchasedetailsVO.php'; 
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>

<html>
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Payment Schedule :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/purchasereportdetails.css" />
		
		<script src="../js/reports/purchasereport.js"></script>
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
				getAllGroups();
				getAllItems();
				getAllSubItems();
				setTimeout('updateProductNames()',1000);
			}
		</script>		
</head>
 <body onload="init()">
	<form method="POST" action="">
		<div id="purchasereportdetaildiv">
			<?php 
				$paymentReportDetailArray = null;
		 		if(isset($_SESSION['reportDetailsArray'])){
		 			$paymentReportDetailArray = $_SESSION['reportDetailsArray'];
		 		}				
			?>
			<table class="purchase-table"	cellpadding="3px" FRAME="box"  border="0">
				<tr>
					<td colspan="4" height="35px" align="center" style="font-size:13px;font-weight:bold">
						PURCHASE REPORT
					</td>
				</tr>
				<tr height="20px">
					<td width="90px">
						Supplier :
					</td>
					<td width="160px">
						 <?php echo $paymentReportDetailArray['suppliername'];?>
					</td>
					<td width="90px">
						Group :
					</td>
					<td id="groupreport">
						<?php echo $paymentReportDetailArray['group'];?>
					</td>
				</tr>
				<tr height="20px">
					<td>
						Date Range :
					</td>
					<td width="30px">
						 <?php echo $paymentReportDetailArray['fromdate'];?>&nbsp;&nbsp;To&nbsp;&nbsp;<?php echo $paymentReportDetailArray['todate'];?> 
					</td>
					<td>
						Item :
					</td>
					<td id="itemreport" width="100px">
						<?php echo $paymentReportDetailArray['item'];?>
					</td>																
				</tr>
				<?php 
					$fromVouchNo = $paymentReportDetailArray['fromvoucherno'];
					$toVouchNo = $paymentReportDetailArray['tovoucherno'];
					$voucherStr = "";
					
					if($fromVouchNo !="" && $toVouchNo !="" ){
						$voucherStr = "";
						$voucherStr = "From ".$fromVouchNo ." To ".$toVouchNo;
					}else if($fromVouchNo =="" && $toVouchNo !="" ){
						$voucherStr = "";
						$voucherStr = "Upto ".$toVouchNo;
					}else if($fromVouchNo !="" && $toVouchNo =="" ){
						$voucherStr = "";
						$voucherStr = "From ".$fromVouchNo;
					}
					
					//if($voucherStr != ""){
				?>
				<tr height="20px">
					<td>
						 Voucher No :
					</td>
					<td>
					<?php 
						  echo $voucherStr;
					?>
					</td>
					<td>
						Sub Item :
					</td>
					<td id="subitemreport">
						<?php echo $paymentReportDetailArray['subItem'];?>
					</td>															
				</tr>
				
				<?php  		
					//}
				?>
			</table>
		</div>
		<div id="purchasereportdiv">
			<table class="purchase-table" cellpadding="3px" FRAME="box" RULES="all">
				<tr id="r_1" height="25px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
					<td align="right" rowspan="2">
						S.no
					</td>
					<td align="center" rowspan="2" width="30px">
						Date
					</td>
					<td  align="center" rowspan="2" width="190px">
						Supplier Name
					</td>
					<td align="center"  rowspan="2" width="60px" rowspan="1""> 
						Voucher No
					</td>
					<td colspan="14" align="center">
						Purchase Details
					</td>
				</tr>
				<tr id="r_1" height="25px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
					<td align="center"  width="15px">
						S.no
					</td>
					<td align="center"  width="70px">
						Group
					</td>
					<td align="center"  width="70px">
						Item
					</td>
					<td align="center"  width="100px">
						Sub Item
					</td>
					<td align="center"  width="30px">
						G.wt
					</td>
					<td align="center"  width="30px">
						Net wt
					</td>
					<td align="center"  width="30px">
						24ctpure
					</td>
					<td align="center"  width="30px">
						Maintain As
					</td>
					<td align="center"  width="30px">
						Value
					</td>
					<td align="center"  width="30px">
						MC
					</td>
					<td align="center"  width="30px">
						Maintain As
					</td>
					<td  align="center" width="30px">
						Value
					</td>
					<td align="center"  width="30px">
						Payment In
					</td>
					<td  align="center" width="30px">
						Last Payment Date
					</td>																 	 	 	
				</tr>
				<?php  
					$purchaselist = null;
					if(isset($_SESSION['purchaselist'])){
						$purchaselist = $_SESSION['purchaselist'];
						$count = 1;
						$rowCount = 1;
						if(count($purchaselist)!=0){
							foreach($purchaselist as $purchaseVO){
								$purchaseDetailList = $purchaseVO->getPurchaseDetailsList();
				?>
				<tr>			
						<td rowspan="<?php echo (count($purchaseDetailList)+1);?>"><?php echo $count?></td>
						<td rowspan="<?php echo (count($purchaseDetailList)+1);?>" id="<?php echo 'date' . $count;?>"><?php echo $purchaseVO->getDate();?></td>												
						<td rowspan="<?php echo (count($purchaseDetailList)+1);?>" id="<?php echo 'supplierid' . $count;?>"><?php echo $purchaseVO->getSupplierId();?></td>												
						<td rowspan="<?php echo (count($purchaseDetailList)+1);?>" align="center"><?php echo $purchaseVO->getbillno();
							$count++;
						?></td>	
				</tr>													
						
							<?php 
								$detailCount = 1;
								if(count($purchaseDetailList)!=0){
									foreach($purchaseDetailList as $purchaseDetailVO){															
							?>																																
									<tr>
										<td align="right"><?php echo $detailCount;?></td>
										<td id="<?php echo 'group' . $rowCount;?>" align="center"><?php echo $purchaseDetailVO->getGroupId();?></td>
										<td id="<?php echo 'item' . $rowCount;?>" align="center"><?php echo $purchaseDetailVO->getItemId();?></td>
										
										<td id="<?php echo 'subitem' . $rowCount;?>" align="center"><?php echo $purchaseDetailVO->getSubitemId();?></td>
										<td align="right"><?php echo number_format($purchaseDetailVO->getGwt(),3);?></td>
										
										<td align="right"><?php echo number_format($purchaseDetailVO->getNwt(),3);?></td>
										<td align="right"><?php echo number_format($purchaseDetailVO->getCtpure(),3);?></td>
										
										<td align="center"><?php echo $purchaseDetailVO->getMaintainMetalAs();?></td>
										<td align="right"><?php echo number_format($purchaseDetailVO->getMaintainMetalValue(),3);?></td>
										
										<td align="right"><?php echo number_format($purchaseDetailVO->getMc(),3);?></td>																		
										<td align="center"><?php echo $purchaseDetailVO->getMaintainMcAs();?></td>
										 	 	 	
										<td align="right"><?php echo number_format($purchaseDetailVO->getMaintainMcValue(),3);?></td>																		
										<td align="center"><?php echo $purchaseDetailVO->getPaymentDays();?></td>
									
										<td align="center" id="<?php echo 'lastpaymentdate' . $rowCount;?>"><?php echo $purchaseDetailVO->getLastPaymentDate();?></td>
																										
									</tr>
						<?php 
									$detailCount++;	
									$rowCount++;
								}
							}																
						?>
								
				<?php  				
							}
						}else{
				?>			
						<tr>
							<td height="30px" colspan="18" align="center" colspan="18">
								THERE ARE NO PURCHASE ENTRIES FOR THE SELECTED CRITERIA
							</td>
						</tr>	
				<?php 		}	
					}														
				?>
				 
			</table>
		</div>
	</form>
</body>
</html>