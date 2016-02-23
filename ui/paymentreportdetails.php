<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
	include_once '../src/vo/PaymentVO.php'; 
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Payment Schedule :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
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
				getAllSuppliers();
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
						<table class="purchase-table" cellpadding="3px" FRAME="box"  border="0">
									<tr>
										<td colspan="4" height="35px" align="center" style="font-size:13px;font-weight:bold">
											PAYMENT REPORT
										</td>
									</tr>
									<tr height="20px">
										<td width="100px">
											Supplier :
										</td>
										<td width="40px">
											 <?php echo $paymentReportDetailArray['suppliername'];?>
										</td>
										<td>
											Payment Mode :
										</td>
										<td>
											<?php echo $paymentReportDetailArray['paymentMode'];?>
										</td>
									</tr>
									<tr height="20px">
										<td>
											Date Range :
										</td>
										<td width="160px">
											 <?php echo $paymentReportDetailArray['fromdate'];?>&nbsp;&nbsp;To&nbsp;&nbsp;<?php echo $paymentReportDetailArray['todate'];?> 
										</td>
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
											
											if($voucherStr != ""){
										?>
											<td width="90px">
												 Voucher No :
											</td>
											<td width="60px">
											<?php 
												  echo $voucherStr;
											?>
											</td>															
									<?php  		
										}
									?>																	
									</tr>
								</table>
						
					</div>										
					<div id="paymentreportdiv">
						<table class="purchase-table" class="sortable" cellpadding="3px" FRAME="box" RULES="all">
							<tr id="r_1" height="40px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
								<td>
									S.no
								</td>
								<td width="30px">
									Date
								</td>
								<td width="190px">
									Supplier Name
								</td>
								<td width="90px"> 
									Voucher No
								</td>
								<td width="30px">
									Payment Mode
								</td>
								<td>
									Payment Amount
								</td>
								<td>
									Adjusted With
								</td>
								<td>
									Adjusted Value
								</td>
								<td>
									Description
								</td>
							</tr>
							<?php  
								$paymentList = null;
								$noOfDigits = 3;
								if(isset($_SESSION['paymentlist'])){
									$paymentList = $_SESSION['paymentlist'];
									$count = 1;
									if(count($paymentList)!=0){
									foreach($paymentList as $paymentVO){																
							?>
								<tr>
									<td align="right"><?php echo $count;?></td>
									<td id="<?php echo 'date' . $count ?>" ><?php echo $paymentVO->getDate();?></td>
									<td id="<?php echo 'supplierid' . $count ?>" ><?php echo $paymentVO->getSupplierId();?></td>
									<td align="right"><?php echo $paymentVO->getVoucherNo();?></td>
									<td align="center"><?php echo $paymentVO->getPaymentMode();?></td>
									<?php 
										if($paymentVO->getPaymentMode() == "cash"){
											$noOfDigits = 2;
										}else{
											$noOfDigits = 3;
										}
									?>
									<td align="right"><?php echo number_format($paymentVO->getAmount(),$noOfDigits);?></td>
									<td align="center"><?php echo $paymentVO->getAdjustWith();?></td>
									<?php 
										if($paymentVO->getAdjustWith() == "cash"){
											$noOfDigits = 2;
										}else{
											$noOfDigits = 3;
										}
									?>
									<td align="right"><?php echo  number_format($paymentVO->getAdjustAmount(),$noOfDigits);?></td>
									<td width="100px"><?php echo $paymentVO->getDescription();?></td>
									
								</tr>
							<?php
											$count++; 
										}
									}else{
							?>
									<tr>
										<td height="30px" colspan="9" align="center" colspan="18">
											THERE ARE NO PAYMENT ENTRIES FOR THE SELECTED CRITERIA
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
