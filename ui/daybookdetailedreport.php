<?php 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Detailed Daybook Report :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css">
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/daybookreport.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/reports/daybookreport.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script src="../js/util/validator.js"></script>
		
		<script type="text/javascript" src="../js/3putil/jquery-1.4.2.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.core.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.datepicker.js"></script>
		
		<script type="text/javascript">
			$(function() {
				$("#selectedDate").datepicker({
					changeMonth: true,
					changeYear: true
				}); 
				$('#selectedDate').datepicker('option', {dateFormat: 'dd/mm/yy'});
			});
			function init(){
				getAllSuppliers();
				getAllChannels();
				getAllAccheads();
				setTimeout('loadData()', 500);
			}
			function loadData(){
				getClosing();
				getSuspense();
				getDetailedTodaysDaybook();
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
					<div id="leftpanel" style="display:none">
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
						<div class="panel-title" style="margin-top:228px">
							
						</div>
					</div>
					<div id="rightpanel">
						<div class="panel-title">
							<div style="float:left">DAYBOOK REPORT</div>
							<div style="float:right;margin-top:-4px">
								<table cellspacing="3" cellpadding="2">
									<tr valign="middle">
										<!-- <td width="710"></td> -->
										<td>
											<input type="text" class="txtInputField" id="selectedDate" size="8" style="font-size: 10px;background-color: #E8EDFF;">
										</td>
										<td valign="top">
											<img src="../images/go.png" onclick="getDetailedDaybookBySelectedDate()" />
											<img src="../images/printer.jpg" onclick="printDaybook()" />
										</td>
										<td width="10"></td>
										<td>
											<img src="../images/arrow-left.png" onclick="getDetailedPrevDateDaybook()" /> 
											<img src="../images/home.png" onclick="getDetailedTodaysDaybook()" />
											<img src="../images/arrow-right.png" onclick="getDetailedNextDateDaybook()" />
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<div style="">
										<form method="POST" action="">
											<div class="panel-header-element2">
												<div style="float:left;margin-left:5px;border-radius:0px;">
													<div class="balance-type">OPENING : </div>
													<div class="balance-type" id="oppg"></div>
													<div class="balance-type" id="oplpg"></div>
													<div class="balance-type" id="opsilver"></div>
													<div class="balance-type" id="opcash"></div>
												</div>
												<div style="float:right;">
												<div class="balance-type">CLOSING : </div>
													<div class="balance-type" id="clpg"></div>
													<div class="balance-type" id="cllpg"></div>
													<div class="balance-type" id="clsilver"></div>
													<div class="balance-type" id="clcash"></div>
												</div>
											</div>
											<div class="daybookdiv">
												<table id="supplier-table">
													<tr>
														<td colspan="4">
															<div id="daybookreportdiv">
																<table id="daybook-table" class="purchase-table" cellpadding="3px" cellspacing="1px">
																	<tr id="r_1" height="30px" style="background-color: #DCE4FF;color: #000000;font-weight: bold;">
																		<td rowspan="2" align="center">
																			S.no
																		</td>
																		<td width="240px" rowspan="2" align="center">
																			Description
																		</td>
																		<td width="60px" rowspan="2" align="center"> 
																			Voucher No
																		</td>
																		<td width="60px" colspan="4" align="center"> 
																			Dr
																		</td>
																		<td colspan="4" align="center">
																			Cr
																		</td>
																		<td colspan="4" align="center">
																			Balance
																		</td>
																	</tr>
																	<tr id="r_2" height="30px" style="background-color: #DCE4FF;color: #000000;">
																		<td width="45px" align="center">
																			PG
																		</td>
																		<td width="45px" align="center">
																			LPG
																		</td>
																		<td width="45px" align="center"> 
																			Silver
																		</td>
																		<td width="45px" align="center">
																			Cash
																		</td>
																		<td width="45px" align="center">
																			PG
																		</td>
																		<td width="45px" align="center">
																			LPG
																		</td>
																		<td width="45px" align="center"> 
																			Silver
																		</td>
																		<td width="45px" align="center">
																			Cash
																		</td>
																		<td width="45px" align="center">
																			PG
																		</td>
																		<td width="45px" align="center">
																			LPG
																		</td>
																		<td width="45px" align="center"> 
																			Silver
																		</td>
																		<td width="45px" align="center">
																			Cash
																		</td>
																	</tr>
																</table>
															</div>
														</td>
													</tr>
												</table>
											</div>
										</form>
									</div>
									<div id="status-div" style="display:none;height:20px;width:510px;margin-left:10px;margin-right:10px;border:1px solid #D0D0D0;background-color:#EFEFEF;color:#303030;padding:5px 10px 2px 10px;">
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
			<!-- <div id="footer">
    		
    		</div> -->
    	</div>
    </body>
</html>
