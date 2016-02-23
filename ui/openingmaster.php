<?php 
	
	include_once 'Authenticator.php'; 
	if($userType == "operator"){
		header('Location:' . 'Unauthorized.php');
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Opening Master :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/opening.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script src="../js/util/validator.js"></script>
	
		<script type="text/javascript">
			function clearForm(){
				document.forms[0].reset();
				var pg = document.getElementById("oppg");
				pg.focus();
			}
			
			function init(){
				clearForm();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getOpening();
				getClosing();
				getSuspense();
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
							<?php include_once 'adminmenu.php';?>
						</div>
					</div>
					<div id="rightpanel">
						<div class="panel-title">
							SRI LAKSHMI JEWELLERY OPENING BALANCE
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="float:left;">
										<form method="POST" action="">
											<table id="supplier-table">
												<tr height="25px">
													<td width="120px">
														Pure Gold
													</td>
													<td>
														<input type="text" class="txtInputField" style="text-align:right" id="oppg" name="oppg" size="12" onkeypress="return isValidAmount(event,this)" maxlength="15"/>
														(g)
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Less Pure Gold
													</td>
													<td>
														<input type="text" class="txtInputField" style="text-align:right" id="oplpg" name="oplpg" size="12" onkeypress="return isValidAmount(event,this)" maxlength="15"/>
														(g)
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Silver
													</td>
													<td>
														<input type="text" class="txtInputField" style="text-align:right" id="opsilver" name="opsilver" size="12" onkeypress="return isValidAmount(event,this)" maxlength="15"/>
														(kg)
													</td>
												</tr>
												<tr height="25px">
													<td width="120px">
														Cash
													</td>
													<td>
														<input type="text" class="txtInputField" style="text-align:right" id="opcash" name="opcash" size="12" onkeypress="return isValidAmount(event,this)" maxlength="15"/>
														(INR)
													</td>
												</tr>
												<tr height="60px">
													<td>
													</td>
													<td>
														<div id="add-button-div">
															<a href="#" class="uibutton1" onclick="saveOpening();">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="getOpening();">
																<span class="uitext1">Show Current Values</span>
															</a>
															<a href="#" class="uibutton1" onclick="clearForm();">
																<span class="uitext1">Clear</span>
															</a>
														</div>
														<div id="edit-button-div" style="display:none">
															<a href="#" class="uibutton1" onclick="updateSupplier();">
																<span class="uitext1">Save</span>
															</a>
															<a href="#" class="uibutton1" onclick="deleteSelectedSupplier();">
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
						</div>
					</div>
				</div>
    		</div>
			<div id="footer">
    		
    		</div>
    	</div>
    </body>
</html>
