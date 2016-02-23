<?php 
	include_once '../src/vo/PaymentVO.php'; 
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Supplier Report :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/supplierreport.css" />
		
		<script src="../js/masters/company.js"></script>
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
			$(function() {
				$("#fromdate").datepicker({
					changeMonth: true,
					changeYear: true
				}); 
				$('#fromdate').datepicker('option', {dateFormat: 'dd/mm/yy'});
				$("#todate").datepicker({
					changeMonth: true,
					changeYear: true
				}); 
				$('#todate').datepicker('option', {dateFormat: 'dd/mm/yy'});
				$("#paymentdate").datepicker({
					changeMonth: true,
					changeYear: true
				}); 
				$('#paymentdate').datepicker('option', {dateFormat: 'dd/mm/yy'});
			});
			function clear(){
				document.forms[0].reset();
				document.getElementById("fromdate").value = getToday();
				document.getElementById("todate").value = getToday();
				document.getElementById("paymentdate").value = getToday();
				document.getElementById("supplierList").focus();
				var tableObj = document.getElementById("purchasetable");
				
			}

			function clearForm(){
				document.forms[0].reset();
				document.getElementById("fromdate").value = getToday();
				document.getElementById("todate").value = getToday();
				document.getElementById("paymentdate").value = getToday();
				document.getElementById("fromdate").select();
				var tableObj = document.getElementById("purchasetable");
				deleteAllRows(tableObj);
				addRow();
				hideEditButtonPanel();
			}
			
			function init(){
				clear();
				sortables_init();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllSuppliers();
				getClosing();
				getSuspense();
			}

			function showSupplierBalanceReport(){
				document.getElementById("action").value ="getAllSuppliersBalance";
				var dateValue = document.getElementById("paymentdate").value;
				document.getElementById("paydate").value = getFormattedDate(dateValue,'/');
				document.forms[0].submit();
			}
			function showOverdueSuppliers(){
				document.getElementById("action").value ="getOverdueSuppliers";
				var dateValue = document.getElementById("paymentdate").value;
				document.getElementById("paydate").value = getFormattedDate(dateValue,'/');
				document.forms[0].submit();
			}
			
			function showSupplierTxnReport(){
				document.getElementsByName("action")[1].value ="getSuppliersTransactions";
				var dateValue = document.getElementById("fromdate").value;
				document.getElementById("txnfromdate").value = getFormattedDate(dateValue,'/');
				dateValue = document.getElementById("todate").value;
				document.getElementById("txntodate").value = getFormattedDate(dateValue,'/');
				document.forms[1].submit();
			}
			
		</script>
		
    </head>
    <body onload="init()">
	<?php include_once 'toolbar.php';?>
    	<div id="wrapper">
    		<div id="header">
    			<?php include_once 'header.php';?>
    		</div>
			<div id="content">
				<div id="content-wrapper">
					<div id="leftpanel">
						<div class="panel-title">
							MENU
						</div>
						<div>
							<?php 
								$includeFile = null;
								if($userType == "operator"){
									$includeFile = 'operatormenu.php';
								}else{
									$includeFile = 'adminmenu.php';
								}
								include_once $includeFile;
							?>
						</div>
					</div>					
					 
					<div id="rightpanel">
						<div class="panel-title">
							SUPPLIER REPORT
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;font-size:11px">
										<form method="POST" action="../src/controller/SupplierReportController.php">
											<table id="supplier-table" >
												<tr height="25px">
													<td width="120px">
														Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="paymentdate" name="paymentdate" size="15" maxlength="15"/>
														<input type="hidden" id="action" name="action" />
														<input type="hidden" id="paydate" name="paydate" />
													</td>
												</tr>
												<tr height="35px">
													<td></td>
													<td colspan="3">
														<a href="#" class="uibutton1" onclick="showSupplierBalanceReport();">
																<span class="uitext1">Get Scheduled Payment</span>
														</a>
													</td>
													<td colspan="3">
														<a href="#" class="uibutton1" onclick="showOverdueSuppliers();">
																<span class="uitext1">Show Overdue Suppliers</span>
														</a>
													</td>
												</tr>
											</table>
										</form>
										<br />
										<form method="POST" action="../src/controller/SupplierReportController.php">
											<table id="supplier-table" >
												<tr height="25px">
													<td width="120px">
														From Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="fromdate" name="fromdate" size="15" maxlength="15"/>
													</td>
													<td width="50px">
														To Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="todate" name="todate" size="15" maxlength="15"/>
														<input type="hidden" id="action" name="action" />
														<input type="hidden" id="txnfromdate" name="txnfromdate" />
														<input type="hidden" id="txntodate" name="txntodate" />
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Supplier Name
													</td>
													<td colspan="3">
														<select id="supplierList" name="supplierid">
														</select>
													</td>
												</tr>
												
												<tr height="35px">
													<td></td>
													<td colspan="3">
														<a href="#" class="uibutton1" onclick="showSupplierTxnReport();">
																<span class="uitext1">Show Report</span>
														</a>
														<a href="#" class="uibutton1" onclick="showSupplierTxnReport();">
																<span class="uitext1">Print Report</span>
														</a>
													</td>
												</tr>
												<tr height="0px">
													<td>
														<input type="hidden" class="txtInputField" id="query" name="query" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenSupplierName" name="hiddenSupplierName" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenPaymentMode" name="hiddenPaymentMode" size="3"/>
													</td>													 
												</tr>												
											</table>	
											 <!--<div id="paymentreportdiv">
															<?php
																$paymentList = null;
																if(isset($_SESSION['paymentlist'])){
																	$paymentList = $_SESSION['paymentlist'];
																	$count = 1;
															?>
												<table id="purchasetable" class="sortable" cellpadding="3px" FRAME="box" RULES="all">
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
																	//print_r($paymentList);
																	foreach($paymentList as $paymentVO){																
															?>
																<tr>
																	<td align="right"><?php echo $count;?></td>
																	<td id="<?php echo 'date' . $count ?>" ><?php echo $paymentVO->getDate();?></td>
																	<td id="<?php echo 'supplierid' . $count ?>" ><?php echo $paymentVO->getSupplierId();?></td>
																	<td align="right"><?php echo $paymentVO->getVoucherNo();?></td>
																	<td align="center"><?php echo $paymentVO->getPaymentMode();?></td>
																	<td align="right"><?php echo number_format($paymentVO->getAmount(),3);?></td>
																	<td align="center"><?php echo $paymentVO->getAdjustWith();?></td>
																	<td align="right"><?php echo  number_format($paymentVO->getAdjustAmount(),3);?></td>
																	<td><?php echo $paymentVO->getDescription();?></td>
																	
																</tr>
															<?php
																	$count++; 
																}
															}
															?>
														
														</table>
													</td>
												</tr>
											</table>
												<br/>
												<b>Less Pure Gold</b><br/>
												<table class="sortable" id="lpgpaymentscheduletable" style="font-size:11px;" class="purchase-table" cellpadding="3px" FRAME="box">
																
												</table>
												<br/>
												<b>Silver</b><br/>
												<table class="sortable" id="silverpaymentscheduletable" style="font-size:11px;" class="purchase-table" cellpadding="3px" FRAME="box">
																
												</table>
												<br/>
												<b>Cash</b><br/>
												<table class="sortable" id="cashpaymentscheduletable" style="font-size:11px;" class="purchase-table" cellpadding="3px" FRAME="box">
																
												</table>	
												
												</div>  
												
										--></form>
									</div>
									<div id="status-div" style="display:none;height:20px;width:510px;margin-left:10px;margin-right:10px;border:1px solid #D0D0D0;background-color:#EFEFEF;color:#303030;padding:5px 10px 2px 10px;">
										<div id="status-text">Status Messages Go Here</div>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="panel-title">
						</div>  -->
					</div>
				</div>
    		</div>
			<div id="footer">
    		
    		</div>
    		<div id="supplierbalancediv" style="padding:5px;background-color:#EFEFEF;position:absolute;font-size:12px;float:left;z-index:999999;display:none;height:110px;width:200px;border:2px solid #A1A2A3">
    			<div style="height:20px;"><div style="float:right;text-align:right;width:130px;padding-right:5px;"><a href="#" onclick="HideContent('supplierbalancediv')">x</a></div></div>
    			<div style="height:20px;padding-top:5px;"><div style="float:left;width:130px">Pure Gold : </div><div id="pg" style="float:left;text-align:right;width:70px"></div></div>
    			<div style="height:20px;"><div style="float:left;width:130px">Less Pure Gold :</div><div id="lpg" style="float:left;text-align:right;width:70px"></div></div>
    			<div style="height:20px;"><div style="float:left;width:130px">Silver :</div><div id="silver" style="float:left;text-align:right;width:70px"></div></div>
    			<div style="height:20px;"><div style="float:left;width:130px">Cash : </div><div id="cash" style="float:left;text-align:right;width:70px"></div></div>
    		</div>
    	</div>
    </body>
</html>
