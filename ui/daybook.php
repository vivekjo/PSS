<?php 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Consolidated Daybook Report :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css">
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/daybook.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/transactions/daybook.js"></script>
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
				$("#selectedDate").datepicker({
					changeMonth: true,
					changeYear: true
				}); 
				$('#selectedDate').datepicker('option', {dateFormat: 'dd/mm/yy'});
			});
			function clearForm(){
				document.forms[0].reset();
				var divElement = document.getElementById("channelid");
				divElement.innerHTML = "";
				divElement = document.getElementById("accountheadid");
				divElement.innerHTML = "";
				divElement = document.getElementById("type");
				divElement.value = "";
				hideEditButtonPanel();
				mode = "add";
				currentTxnId = "0";
				var date = document.getElementById("date");
				date.value = getToday();
				date.focus();
			}
			
			function init(){
				clearForm();
				document.getElementById("selectedDate").value = getToday();
				setTimeout('loadData()', 100);
			}
			function loadData(){
				getAllChannels();
				getAllAccheads();
				getClosing();
				getSuspense();
				setTimeout('getTodaysAccounts()',200);
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
							Daily Accounts
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
														<input type="text" class="txtInputField" id="date" name="date" size="15" maxlength="15"/>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Type
													</td>
													<td>
														<select id="type" name="type" onchange="getChannelsByType(this.value)">
															<option value="">-</option>
															<option value="incoming">Incoming</option>
															<option value="outgoing">Outgoing</option>
														</select>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Category
													</td>
													<td>
														<select id="channelid" name="channel" onchange="getAccHeadsByChannel(this.value)">
														</select>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Account Head
													</td>
													<td>
														<select id="accountheadid" name="accounthead">
														</select>
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Pure Gold
													</td>
													<td>
														<input type="text" class="amountInputField" id="pg" name="pg" value="0" size="12" onkeypress="return isValidAmount(event,this)" maxlength="20"/>&nbsp;(g)
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Less Pure Gold
													</td>
													<td>
														<input type="text" class="amountInputField" id="lpg" name="lpg" value="0" size="12" onkeypress="return isValidAmount(event,this)" maxlength="20"/>&nbsp;(g)
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Silver
													</td>
													<td>
														<input type="text" class="amountInputField" id="silver" value="0" name="silver" size="12" onkeypress="return isValidAmount(event,this)" maxlength="20"/>&nbsp;(kg)
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Cash
													</td>
													<td>
														<input type="text" class="amountInputField" id="cash" name="cash" value="0" size="12" onkeypress="return isValidAmount(event,this)" maxlength="20"/>&nbsp;(INR)
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
															<a href="#" class="uibutton1" onclick="addAccounts();">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="clearForm();">
																<span class="uitext1">Clear</span>
															</a>
														</div>
														<div id="edit-button-div" style="display:none">
															<a href="#" class="uibutton1" onclick="modifyAccounts()">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="deleteAccounts();">
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
									<div id="status-div" style="display:none;height:20px;width:470px;margin-left:10px;margin-right:10px;border:1px solid #D0D0D0;background-color:#EFEFEF;color:#303030;padding:5px 10px 2px 10px;">
										<div id="status-text">Status Messages Go Here</div>
									</div>
								</div>
							</div>
							<div id="supplier-panel">
								<div class="panel-title">
									Info Panel
	    						</div>
								<div class="panel-header-element2" style="padding-top:0px;padding-bottom:1px;height:25px;">
	    							<table cellspacing="3" cellpadding="2">
										<tr valign="middle">
											<td>
												<input type="text" class="txtInputField" id="selectedDate" size="8" style="font-size: 10px;background-color:  #E8EDFF;">
											</td>
											<td valign="top"><input type="image" title="left" src="../images/go.png" onclick="getAccountsBySelectedDate()"></td>
											<td width="120"></td>
											<td>
												<input type="image" title="left" src="../images/arrow-left.png" onclick="getPrevDateAccounts()"> 
												<input type="image" title="today" src="../images/home.png" onclick="getTodaysAccounts()">
												<input type="image" title="right" src="../images/arrow-right.png" onclick="getNextDateAccounts()">
											</td>
										</tr>
									</table>
	    						</div>
	    						<div id="accountspanel"></div>
							</div>
						</div>
						<div class="panel-title">
							
						</div>
					</div>
				</div>
    		</div>
			<div id="footer">
    			<div style="padding-top:5px">&nbsp;&nbsp; &copy; All Rights Reserved. Sri Lakshmi Jewellers.</div>
    		</div>
    	</div>
    </body>
</html>
