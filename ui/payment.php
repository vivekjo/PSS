<?php 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Payment Entry :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css">
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/payment.css" />
		
		<script src="../js/transactions/payment.js"></script>
		<script src="../js/masters/company.js"></script>
		<script src="../js/masters/ratemaster.js"></script>
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
				var divElement = document.getElementById("supplierpanel");
				htmlText = "<div class=\"panel-element\">Please select a supplier</div>";
				divElement.innerHTML = htmlText;
				hideEditButtonPanel();
				mode="add";
				currentTxnId = 0;
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
				setTimeout('getTodaysPayment()', 150);
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
							PAYMENT ENTRY
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left">
										<form method="POST" action="">
											<table id="supplier-table">
												<tr height="25px">
													<td width="120px">
														Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="date" name="date" size="15" maxlength="15"/>
													</td>
												</tr>
												<tr height="35px">
													<td width="120px">
														Supplier Name
													</td>
													<td>
														<select id="supplierList" name="supplierid" onchange="showSupplierBalance(this.value);">
														</select>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Voucher No
													</td>
													<td>
														<input type="text" class="txtInputField" id="voucherno" name="voucherno" size="12" maxlength="20" disabled="disabled"/>
													</td>
												</tr>
												<tr height="35px">
													<td width="120px">
														Payment mode
													</td>
													<td>
														<select id="paymentmode" name="paymentmode">
															<option value="pg">Pure Gold</option>
															<option value="lpg">Less Pure Gold</option>
															<option value="silver">Silver</option>
															<option value="cash">Cash</option>
															<option value="cheque">Cheque</option>
														</select>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Amount
													</td>
													<td>
														<input type="text" class="txtInputField" id="amount" name="amount" onkeypress="return isValidAmount(event,this)" size="12" maxlength="20" />
													</td>
												</tr>
												<tr height="35px">
													<td width="120px">
														Adjust With
													</td>
													<td>
														<select id="adjustwith" name="adjustwith">
															<option value="pg">Pure Gold</option>
															<option value="lpg">Less Pure Gold</option>
															<option value="silver">Silver</option>
															<option value="cash">Cash</option>
														</select>
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
															<a href="#" class="uibutton1" onclick="addPaymentEntry();">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="showWindow();">
																<span class="uitext1">Modify rate</span>
															</a>
															<a href="#" class="uibutton1" onclick="clearForm();">
																<span class="uitext1">Clear</span>
															</a>
														</div>
														<div id="edit-button-div" style="display:none">
															<a href="#" class="uibutton1" onclick="modifyPaymentEntry();">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="deletePayment();">
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
									<div id="status-div" style="display:none;overflow:auto;min-height:20px;width:470px;margin-left:10px;margin-right:10px;border:1px solid #D0D0D0;background-color:#EFEFEF;color:#303030;padding:5px 10px 2px 10px;">
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
									Payment Entry
	    						</div>
	    						<div class="panel-header-element2" style="padding-top:0px;padding-bottom:1px;height:25px;">
	    							<table cellspacing="3" cellpadding="2">
										<tr valign="middle">
											<td>
												<input type="text" class="txtInputField" id="selectedDate" size="8" style="font-size: 10px;background-color: #E8EDFF;">
											</td>
											<td valign="top"><input type="image" title="left" src="../images/go.png" onclick="getPaymentBySelectedDate()"></td>
											<td width="120"></td>
											<td>
												<input type="image" title="left" src="../images/arrow-left.png" onclick="getPrevDatePayment()"> 
												<input type="image" title="today" src="../images/home.png" onclick="getTodaysPayment()">
												<input type="image" title="right" src="../images/arrow-right.png" onclick="getNextDatePayment()">
											</td>
										</tr>
									</table>
	    						</div>
	    						<div id="paymentpanel"></div>
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
					Modify Rate
				</span>
				<span style="padding-top: 10px;padding-right:0px;position:realtive;float:left;font-size: 11px; font-weight: bold;color:#FFFFFF;vertical-align:middle;text-align:right;width:16%">
					<a href="#" style="text-decoration:none;color:#EDEDED" onclick="closeNewTypeWindow()">Close</a>
				</span>
			</div>
			<div style="padding-left:15px;padding-right:15px;padding-top:15px;padding-bottom:15px;background-color:#FFFFFF;z-index:101">	
				<table id="supplier-table">
					<tr height="25px">
						<td width="120px">
							Pure Gold
						</td>
						<td>
							<input type="text" class="amountInputField" id="pg" name="pg" size="12" onkeypress="return isValidAmount(event,this)" maxlength="15"/>
							(INR)/Bar
						</td>
						<td>
							<a href="#" class="uibutton1" onclick="savePG();">
								<span class="uitext1">Save</span>
							</a>
						</td>
					</tr>
					<tr height="25px">
						<td width="120px">
							Less Pure Gold
						</td>
						<td width="150px">
							<input type="text" class="amountInputField" id="lpg" name="lpg" size="12" onkeypress="return isValidAmount(event,this)" maxlength="15"/>
							(INR)/Bar
						</td>
						<td>
							<a href="#" class="uibutton1" onclick="saveLPG();">
								<span class="uitext1">Save</span>
							</a>
						</td>
					</tr>
					<tr height="25px">
						<td width="120px">
							Silver
						</td>
						<td>
							<input type="text" class="amountInputField" id="silver" name="silver" size="12" onkeypress="return isValidAmount(event,this)" maxlength="15"/>
							(INR)/Kg
						</td>
						<td>
							<a href="#" class="uibutton1" onclick="saveSilver();">
								<span class="uitext1">Save</span>
							</a>
						</td>
					</tr>
					<tr height="60px">
						<td>
						</td>
						<td colspan="2">
							<div id="add-button-div">
								<a href="#" class="uibutton1" onclick="getAllRates();">
									<span class="uitext1">Show Current Values</span>
								</a>
								<a href="#" class="uibutton1" onclick="clearWindowForm();">
									<span class="uitext1">Clear</span>
								</a>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div style="height:30px;position: relative;background-color:#E6E6E6;border-top: 1px solid #ACA899;width:100%">
				<div id="window-status-div" style="padding-top: 10px;padding-left:10px;font-size: 11px; font-weight: bold;color:#101010;vertical-align:middle">
					
				</div>
			</div>
		</div>
    </body>
</html>
