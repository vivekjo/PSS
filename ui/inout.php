<?php 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: In/Out Entry :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/inout.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/transactions/inout.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script src="../js/util/validator.js"></script>
		
		<script type="text/javascript">
			function clear(){
				document.forms[0].reset();
				document.getElementById("date").value = getToday();
				document.getElementById("issuerList").focus();
				var tableObj = document.getElementById("purchasetable");
			}

			function clearForm(){
				document.forms[0].reset();
				document.getElementById("date").value = getToday();
				var tableObj = document.getElementById("purchasetable");
				deleteAllRows(tableObj);
				addRow();
				hideEditButtonPanel();
				document.getElementById("issuerList").focus();
			}
			
			function init(){
				clear();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllEmployees();
				getAllLocations();
				getAllGroups();
				getAllItems();
				getAllSubItems();
				getClosing();
				getSuspense();
				setTimeout('addRow()', 2000);
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
							IN/OUT ENTRY
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;">
										<form method="POST" action="">
											<table id="supplier-table">
												<tr height="30px">
													<td width="120px">
														Inout Id
													</td>
													<td>
														<input type="text" class="txtInputField" id="inoutno" name="inout" size="12" maxlength="20"/>
														<img src="../images/go.png" onclick="getInOut()" />
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Date
													</td>
													<td>
														<input type="text" class="txtInputField" id="date" name="date" size="12" maxlength="20" disabled="disabled"/>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Issuer
													</td>
													<td>
														<select id="issuerList" name="issuerid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Bearer
													</td>
													<td>
														<select id="bearerList" name="bearerid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Receiver
													</td>
													<td>
														<select id="receiverList" name="receiverid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Location
													</td>
													<td>
														<select id="locationList" name="locationid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Type
													</td>
													<td>
														<select id="typeList" name="type">
															<option value="in">IN</option>
															<option value="out">OUT</option>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="2">
														<table id="purchasetable" class="purchase-table" cellpadding="3px" FRAME="box" RULES="all">
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
																	Pcs
																</td>
																<td>
																	G.Wt
																</td>
																<td>
																	N.Wt
																</td>
																<td>
																	24 Ct Pure
																</td>
																<td>
																	Amount
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
															<a href="#" class="uibutton1" onclick="addInOut();">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="clearForm();">
																<span class="uitext1">Clear</span>
															</a>
														</div>
														<div id="edit-button-div" style="display:none">
															<a href="#" class="uibutton1" onclick="deleteInOut();">
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
    </body>
</html>
