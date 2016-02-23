<?php 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Transfers Entry :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css">
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/transfers.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/transactions/transfers.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script src="../js/util/validator.js"></script>
		
		<script type="text/javascript" src="../js/3putil/jquery-1.4.2.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.core.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.datepicker.js"></script>
		
		<script type="text/javascript">
			$(function() {
				$("#date").datepicker({
					changeMonth: true,
					changeYear: true
				}); 
				$('#date').datepicker('option', {dateFormat: 'dd/mm/yy'});
			});
			$(function() {
				$("#selectedDate").datepicker({
					changeMonth: true,
					changeYear: true
				}); 
				$('#selectedDate').datepicker('option', {dateFormat: 'dd/mm/yy'});
			});
			function clearForm(){
				document.forms[0].reset();
				document.getElementById("date").value = getToday();
				document.getElementById("date").select();
				var divElement = document.getElementById("supplierpanel");
				htmlText = "<div class=\"panel-element\">Please select a supplier</div>";
				divElement.innerHTML = htmlText;
				hideEditButtonPanel();
				enableControls();
				document.getElementById("supplierList").focus();
			}
			
			function init(){
				clearForm();
				document.getElementById("selectedDate").value = getToday();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllSuppliers();
				getClosing();
				getSuspense();
				setTimeout('getTodaysTransfers()',100);
			}
		</script>
		
    </head>
    <body onload="init()">
    	<?php include_once 'toolbar.php';?>
    	<div id="wrapper">
    		<!-- <div id="header">
    			<?php include_once 'header.php';?>
    		</div> -->
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
							BALANCE TRANSFER ENTRY
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;">
										<form method="POST" action="">
											<table id="supplier-table">
												<tr height="25px">
													<td width="120px">
														Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="date" name="date" size="25" maxlength="50"/>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Supplier Name
													</td>
													<td>
														<select name="supplierid" id="supplierList" onchange="showSupplierBalance(this.value);">
														</select>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Transfer
													</td>
													<td>
														<input type="text" class="amountInputField" id="transferamount" name="transferamount" size="12" onkeypress="return isValidAmount(event,this)" maxlength="20"/>
														&nbsp;&nbsp;
														<select id="transferfrom" name="transferfrom">
															<option value="pure gold">Pure Gold</option>
															<option value="less pure gold">Less Pure Gold</option>
															<option value="silver">Silver</option>
															<option value="cash">Cash</option>
														</select>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														To
													</td>
													<td>
														<input type="text" class="amountInputField" id="transferedamount" name="transferedamount" size="12" onkeypress="return isValidAmount(event,this)" maxlength="20"/>
														&nbsp;&nbsp;
														<select id="transferto" name="transferto">
															<option value="pure gold">Pure Gold</option>
															<option value="less pure gold">Less Pure Gold</option>
															<option value="silver">Silver</option>
															<option value="cash">Cash</option>
														</select>
														&nbsp;&nbsp;
														<img src="../images/go.png" onclick="convertValue()"/>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Description
													</td>
													<td>
														<textarea name="description" id="description" rows="3" cols="35"></textarea>
													</td>
												</tr>
												<tr height="60px">
													<td>
													</td>
													<td>
														<div id="add-button-div">
															<a href="#" class="uibutton1" onclick="addTransfers();">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="clearForm();">
																<span class="uitext1">Clear</span>
															</a>
														</div>
														<div id="edit-button-div" style="display:none">
															<a href="#" class="uibutton1" onclick="deleteTransfers();">
																<span class="uitext1">Delete</span>
															</a>
															<a href="#" class="uibutton1" onclick="clearForm();">
																<span class="uitext1">Clear</span>
															</a>
														</div>
														
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
							<div id="supplier-panel">
								<div class="panel-title">
									Supplier Current Balance
	    						</div>
								<div id="supplierpanel">
	    						</div>
	    						<div class="panel-title">
									Transfer Entry
	    						</div>
	    						<div class="panel-header-element2" style="padding-top:0px;padding-bottom:1px;height:25px;">
	    							<table cellspacing="3" cellpadding="2">
										<tr valign="middle">
											<td>
												<input type="text" class="txtInputField" id="selectedDate" size="8" style="font-size: 10px;background-color: #E8EDFF;">
											</td>
											<td valign="top"><input type="image" title="left" src="../images/go.png" onclick="getTransfersBySelectedDate()"></td>
											<td width="70"></td>
											<td>
												<input type="image" title="left" src="../images/arrow-left.png" onclick="getPrevDateTransfers()"> 
												<input type="image" title="today" src="../images/home.png" onclick="getTodaysTransfers()">
												<input type="image" title="right" src="../images/arrow-right.png" onclick="getNextDateTransfers()">
											</td>
										</tr>
									</table>
	    						</div>
	    						<div id="transferspanel">
	    						</div>
							</div>
						</div>
						<div class="panel-title">
						</div>
					</div>
				</div>
    		</div>
			<div id="footer">
    		
    		</div>
    	</div>
    	<div id="newProductDiv" class="transparency" style="display:none; position:absolute; top:100%; left: 420px; top:180px;border: 12px solid rgba(20,20,20,0.5);" >
			<div style="height:40px;position: relative;background-color:#3B5998;width:100%">
				<span id="window-title" style="padding-top: 10px;padding-left:10px;position: relative;float:left;font-size: 14px; font-weight: bold;color:#FFFFFF;vertical-align:middle;width:80%">
					Add New Item
				</span>
				<span style="padding-top: 10px;padding-right:0px;position:realtive;float:left;font-size: 11px; font-weight: bold;color:#FFFFFF;vertical-align:middle;text-align:right;width:16%">
					<a href="#" style="text-decoration:none;color:#EDEDED" onclick="closeNewTypeWindow()">Close</a>
				</span>
			</div>
			<div style="background-color:#FFFFFF;z-index:101;overflow:auto;font-size:11px;">	
				<div style="float:left;width:270px;border-right:1px solid #EFEFEF">
					<div id="label-text" style="height:20px">
						
					</div>
					<div style="padding-left:20px">
						<input type="text" id="convertedvalue"/>
					</div>
					<div style="padding-left:20px;padding-top:15px">
						<a href="#" class="uibutton2" onclick="convert()">
							<span class="uitext2">Convert</span>
						</a>
						<a href="#" class="uibutton2" onclick="clearWindowForm()">
							<span class="uitext2">Clear</span>
						</a>
					</div>
				</div>
				<div style="float:left;width:172px">
					<div id="field-label" style="height:30px"></div>
					<div style="height:25px">
						<div id="uom" style="float:left;width:70px;">rate/bar</div>
						<div style="float:left;width:90px;text-align:right"><input type="text" class="amountInputField" id="pgratebar" size="8"></input></div>
					</div>
					<div style="height:25px">
						<div style="float:left;width:70px;">rate/g</div>
						<div style="float:left;width:90px;text-align:right"><input type="text" class="amountInputField" id="pgrateg" size="8"></input></div>
					</div>
					<div style="height:25px">
						<div style="float:left;width:70px;">conversion(%)</div>
						<div style="float:left;width:90px;text-align:right"><input type="text" class="amountInputField" id="conversionpercent" size="8" value="91.6"></input></div>
					</div>
				</div>
			</div>
			<div style="height:30px;position: relative;background-color:#E6E6E6;border-top: 1px solid #ACA899;width:100%">
				<div id="window-status-div" style="padding-top: 10px;padding-left:10px;font-size: 11px; font-weight: bold;color:#101010;vertical-align:middle">
					
				</div>
			</div>
		</div>
    </body>
</html>
