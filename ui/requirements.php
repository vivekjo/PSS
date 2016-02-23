<?php 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>::Requirements Entry :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css">
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/requirements.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/transactions/requirements.js"></script>
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
			function clear(){
				document.forms[0].reset();
				document.getElementById("date").value = getToday();
				document.getElementById("employeeList").focus();
				var tableObj = document.getElementById("requirementstable");
				
				//deleteAllRows(tableObj);
				
			}

			function clearForm(){
				document.forms[0].reset();
				document.getElementById("date").value = getToday();
				document.getElementById("date").select();
				document.getElementById("employeeList").disabled = false;
				var tableObj = document.getElementById("requirementstable");
				deleteAllRows(tableObj);
				addRow();
				hideEditButtonPanel();
			}
			
			function init(){
				clear();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllEmployees();
				getAllGroups();
				getAllItems();
				getAllSubItems();
				getClosing();
				getSuspense();
				setTimeout('addRow()', 300);
			}

			function deleteRow(rowId){
				var rowElement = document.getElementById(rowId);
				var tableElement = document.getElementById("requirementstable");
				if(tableElement.rows.length > 2){
					tableElement.removeChild(rowElement);
				}
			}

			function keyCheck(event,id){
				if(event.keyCode == 13){
					addRow();
				}
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
							Requirements Entry
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;">
										<form method="POST" action="">
											<table id="supplier-table">
												<tr height="25px">
													<td width="120px">
														Id
														
													</td>
													<td>
														<input type="text" class="txtInputField" id="voucherno" name="voucherno" size="12" maxlength="20"/>
														<img src="../images/go.png" onclick="getRequirements();" />
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="date" name="date" size="15" disabled="disabled" maxlength="15"/>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Employee Name
													</td>
													<td>
														<select id="employeeList" name="employeeid">
														</select>
													</td>
												</tr>
												
												<tr>
													<td colspan="2">
														<table id="requirementstable" class="requirements-table" cellpadding="3px" FRAME="box" RULES="all">
															<tr id="r_1" height="40px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
																<td>
																	X
																</td>
																<td width="90px">
																	Group
																</td>
																<td width="90px"> 
																	Item
																</td>
																<td width="90px">
																	Sub Item
																</td>
																<td>
																	Gms
																</td>
																<td>
																	Pcs
																</td>
																<td>
																	Size
																</td>
																<td>
																	Mc
																</td>
																<td>
																	Stone
																</td>																
																<td>
																	TotalAmount
																</td>
																<td>
																	No Of Days
																</td>
																<td>
																	Description
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr height="60px">
													<td>
													</td>
													<td>
														<div id="add-button-div">
															<a href="#" class="uibutton1" onclick="addRequirements();">
																<span class="uitext1">Save</span>
															</a>
															
															<a href="#" class="uibutton1" onclick="clearForm();">
																<span class="uitext1">Clear</span>
															</a>
														</div>
														<div id="edit-button-div" style="display:none">
															<a href="#" class="uibutton1" onclick="deleteRequirements();">
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
									<div id="status-div" style="display:none;overflow:auto;min-height:20px;width:510px;margin-left:10px;margin-right:10px;border:1px solid #D0D0D0;background-color:#EFEFEF;color:#303030;padding:5px 10px 2px 10px;">
										<div id="status-text">Status Messages Go Here</div>
									</div>
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
