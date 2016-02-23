<?php 
	include_once '../src/vo/DaybookVO.php';
	include_once '../src/vo/PaymentTypeVO.php'; 
	include_once '../src/util/XMLBuilder.php'; 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Purchase Planner :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css">
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/purchaseplanner.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/reports/purchaseplanner.js"></script>
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
			});
			function clear(){
				document.forms[0].reset();
				document.getElementById("fromdate").value = getToday();
				document.getElementById("todate").value = getToday();
//				document.getElementById("supplierList").focus();
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
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllSuppliers();
				getClosing();
				getSuspense();
				//getPaymentSchedule();
				//getAllGroups();
				//getAllItems();
				//getAllSubItems();
				//setTimeout('addRow()', 300);
			}
	
			function getPurchasePlanner(type){
				document.getElementById("fromdate").value = getFormattedDate(document.getElementById("fromdate").value,"/");
				document.getElementById("todate").value = getFormattedDate(document.getElementById("todate").value,"/");
				document.getElementById("action").value = "getPurchasePlanner";
				document.getElementById("type").value = type;
				document.forms[0].submit();
			}
		</script>
		
    </head>
    <body onload="init()">
    <?php include_once 'toolbar.php';?>
    	<div id="wrapper">
    		<!-- <div id="header">
    			<?php include_once 'header.php';?>
    		</div>  -->
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
							PURCHASE PLANNER
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;font-size:11px">
										<form method="POST" action="../src/controller/PurchasePlannerController.php">
											<table id="supplier-table" >
												<tr height="25px">
													<td width="70px">
														From Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="fromdate" name="fromdate" size="10" maxlength="15"/>
													</td>
													<td width="50px">
														To Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="todate" name="todate" size="10" maxlength="15"/>
														<input type="hidden" id="action" name="action" size="10" maxlength="15"/>
														<input type="hidden" id="type" name="type" size="10" maxlength="15"/>
													</td>
													<td>
													</td>
												</tr>
												<tr>
													<td colspan="4">
														<br/>
														<a href="#" class="uibutton2" onclick="getPurchasePlanner('consolidated');">
															<span class="uitext2">Consolidated Report</span>
														</a>
														<a href="#" class="uibutton2" onclick="getPurchasePlanner('detailed');">
															<span class="uitext2">Detailed Report</span>
														</a>
													</td>
												</tr>
												<tr>
													<td colspan="4">
														
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
					</div>
				</div>
    		</div>
			<div id="footer">
    			
    		</div>
    	</div>
    </body>
</html>
