<?php 
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Payment Schedule :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/paymentreport.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script src="../js/util/validator.js"></script>
		<script src="../js/reports/purchasereport.js"></script>
		
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
			});
			function clear(){
				document.forms[0].reset();
				document.getElementById("fromdate").value = getToday();
				document.getElementById("todate").value = getToday();
				document.getElementById("supplierList").focus();
				var tableObj = document.getElementById("purchasetable");
				
			}

			function clearForm(){
				document.forms[0].reset();
				document.getElementById("fromdate").value = getToday();
				document.getElementById("todate").value = getToday();
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
				getAllGroups();		
				getAllItems();
				getAllSubItems();		
				getClosing();
				getSuspense(); 
			}

			function deleteRow(rowId){
				var rowElement = document.getElementById(rowId);
				var tableElement = document.getElementById("purchasetable");
				if(tableElement.rows.length > 2){
					tableElement.removeChild(rowElement);
				}
			}

			function keyCheck(event,id){
				if(event.keyCode == 13){
					addRow();
				}
			}
			function showPurchaseReport(){
				var queryString1 = buildQueryForPurchase();
				var queryString2 = buildQueryForProduct();
				document.getElementById("query1").value ="";
				document.getElementById("query1").value = queryString1;
				document.getElementById("query2").value = "";
				document.getElementById("query2").value = queryString2;
				document.forms[0].submit();
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
						<!-- <div class="panel-title" style="margin-top:188px">
							
						</div> -->
					</div>					
					 
					<div id="rightpanel">
						<div class="panel-title">
							PURCHASE  REPORT
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;font-size:11px">
										<form method="POST" action="../src/controller/PurchaseReportController.php">
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
												<tr height="30px">
													<td width="120px">
														Voucher No
													</td>
													<td>
														<input type="text" class="txtInputField" id="fromvoucherno"  name="fromvoucherno"  size="3"/>
														&nbsp;&nbsp;To&nbsp;&nbsp;<input type="text" class="txtInputField" id="tovoucherno" name="tovoucherno" size="3"/>
													</td>
													
												</tr>
												 	
												<tr height="30px">
													<td width="120px">
														Group Name
													</td>
													<td colspan="3">
														<select id="group" name="group" onchange="getItemsByGroup(this.value);">
														</select>
													</td>
												</tr>										
												 	
												<tr height="30px">
													<td width="120px">
														Item Name
													</td>
													<td colspan="3">
														<select id="item" name="item" onchange="getSubItems(this.value);">
														</select>
													</td>
												</tr>										
												 	
												<tr height="30px">
													<td width="120px">
														SubItem Name
													</td>
													<td colspan="3">
														<select id="subItem" name="subItem">
														</select>
													</td>
												</tr>										
												<tr height="35px">
													<td></td>
													<td colspan="3">
														<a href="#" class="uibutton1" onclick="showPurchaseReport();">
																<span class="uitext1">Show Report</span>
														</a>
														<a href="#" class="uibutton1" onclick="printPurchaseReport();">
																<span class="uitext1">Print Report</span>
														</a>
													</td>
												</tr>
												<tr height="0px">
													<td>
														<input type="hidden" class="txtInputField" id="query1" name="query1" size="3"/>
														<input type="hidden" class="txtInputField" id="query2" name="query2" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenSupplierName" name="hiddenSupplierName" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenPaymentMode" name="hiddenPaymentMode" size="3"/>
													</td>													 
												</tr>												
											</table>	
										
										</form>
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
