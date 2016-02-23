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
		
		<script src="../js/transactions/dashboard.js"></script>
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
				//clearForm();
				//document.getElementById("selectedDate").value = getToday();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllSuppliers();
				getOpening();
			}
		</script>
		
    </head>
    <body onload="init()">
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
						<div class="panel-title" style="margin-top:208px">
							
						</div>
					</div>
					<div id="rightpanel">
						<div class="panel-title">
							DASHBOARD
						</div>
						<div id="panel-wrapper">
							<div id="form-panel">
								<div id="form-panel-wrapper">
									<table id="supplier-table">
										<tr height="35px">
											<td width="120px">
												Supplier Name
											</td>
											<td>
												<select id="supplierList" name="supplierid" onchange="showSupplierBalance(this.value);">
												</select>
											</td>
										</tr>
									</table>
									<div id="status-div" style="display:none;height:20px;width:470px;margin-left:10px;margin-right:10px;border:1px solid #D0D0D0;background-color:#EFEFEF;color:#303030;padding:5px 10px 2px 10px;">
										<div id="status-text">Status Messages Go Here</div>
									</div>
								</div>
							</div>
							<div id="supplier-panel">
	    						<div class="panel-title">
									Company Current Balance
	    						</div>
								<div id="companypanel">
	    						</div>
	    						<div class="panel-title">
									Supplier Current Balance
	    						</div>
								<div id="supplierpanel">
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
