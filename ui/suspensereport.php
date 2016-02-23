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
		<link rel="stylesheet" href="../css/suspensereport.css" />
		 
		<script src="../js/masters/company.js"></script>
		<script src="../js/reports/suspensereport.js"></script>
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
			}
			function init(){
				clear();
				getAllEmployees();
				getAllLocations();
				setTimeout('loadData()', 150);
			}
			function showSuspenseReport(){
				var queryString1 = buildQuery();
				var queryString2 = buildQueryForProduct();
				document.getElementById("query1").value ="";
				document.getElementById("query1").value = queryString1;
				document.getElementById("query2").value = "";
				document.getElementById("query2").value = queryString2;
				document.forms[0].submit();
			}

			
			function loadData(){
				getClosing();
				getSuspense();
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
							SUSPENSE REPORT
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;font-size:11px">
										<form method="POST" action="../src/controller/SuspenseReportController.php">
											<table id="suspense-table" >
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
														Issuer 
													</td>
													<td colspan="3">
														<select id="issuerList" name="Issuerid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Bearer 
													</td>
													<td colspan="3">
														<select id="bearerList" name="Bearerid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Receiver 
													</td>
													<td colspan="3">
														<select id="receiverList" name="Receiverid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Location 
													</td>
													<td colspan="3">
														<select id="locationList" name="Locationid">
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Type 
													</td>
													<td colspan="3">
														<select id="typeMode" name="typeMode">
															<option value="ALL">ALL</option>
															<option value="OUT">OUT</option>
															<option value="RETURN">RETURN</option>															
														</select>
													</td>
												</tr>
												<tr height="30px">
													<td width="120px">
														Mode 
													</td>
													<td colspan="3">
														<select id="mode" name="mode">
															<option value="ALL">ALL</option>
															<option value="HALLMARK">HALLMARK</option>
															<option value="REGULAR">REGULAR</option>															
														</select>
													</td>
												</tr>
												<tr height="35px">
													<td></td>
													<td colspan="3">
														<a href="#" class="uibutton1" onclick="showSuspenseReport();">
																<span class="uitext1">Show Report</span>
														</a>
														<a href="#" class="uibutton1" onclick="printInOutReport();">
																<span class="uitext1">Print Report</span>
														</a>
													</td>
												</tr>
												<tr height="0px">
													<td>
														<input type="hidden" class="txtInputField" id="query1" name="query1" size="3"/>
														<input type="hidden" class="txtInputField" id="query2" name="query2" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenIssuerName" name="hiddenIssuerName" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenBearerName" name="hiddenBearerName" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenReceiverName" name="hiddenReceiverName" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenLocationName" name="hiddenLocationName" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenTypeMode" name="hiddenTypeMode" size="3"/>
														<input type="hidden" class="txtInputField" id="hiddenMode" name="hiddenMode" size="3"/>
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
