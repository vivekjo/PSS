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
        <title>:: Accounts Master :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/accmaster.css" />
		
		<script src="../js/masters/company.js"></script>
		<script src="../js/masters/channelmaster.js"></script>
		<script src="../js/masters/accheadsmaster.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script>
			function init(){
				setTimeout('loadData()', 150);
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
    		<!-- <div id="header">
    			<?php include_once 'header.php';?>
    		</div>
    		 -->
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
							ACCOUNT MASTER
						</div>
						<div id="panel-wrapper">
							<div id="selectpanel-header-wrapper">
								<div id="grouppanel-header">
									<div class="panel-title">Type</div>
								</div>
								<div id="itempanel-header">
									<div class="panel-title">Category</div>
								</div>
								<div id="subitempanel-header">
									<div class="panel-title">Account Heads</div>
								</div>
							</div>
			    			<div id="selectpanel-wrapper">
			    				<div id="typespanel"><div id="t_incoming" class="panel-element" onclick="selectType(this.id);getChannelsByType('incoming')">Incoming</div><div id="t_outgoing" class="panel-element" onclick="selectType(this.id);getChannelsByType('outgoing')">Outgiong</div></div>		    					
			    				<div id="channelspanel">
			    				</div>
			    				<div id="accheadspanel">
			    				</div>
			    			</div>
			    			<div id="selectpanel-footer-wrapper">
								<div id="grouppanel-footer">
									<div class="panel-footer">
										
									</div>
								</div>
								<div id="itempanel-footer">
									<div class="panel-footer">
										<a href="#" class="uibutton2" onclick="showNewTypeWindow('Channel','add');">
											<span class="uitext2"><img src="../images/plus.jpg" /></span>
										</a>
										<a href="#" class="uibutton2" onclick="editSelectedChannel();">
											<span class="uitext2"><img src="../images/b_edit.png" /></span>
										</a>
										<a href="#" class="uibutton2" onclick="deleteSelectedChannel();">
											<span class="uitext2"><img src="../images/b_drop.png"/></span>
										</a>
									</div>
								</div>
								<div id="subitempanel-footer">
									<div class="panel-footer">
										<a href="#" class="uibutton2" onclick="showNewTypeWindow('Account Head','add');">
											<span class="uitext2"><img src="../images/plus.jpg" /></span>
										</a>
										<a href="#" class="uibutton2" onclick="editSelectedAccHead();">
											<span class="uitext2"><img src="../images/b_edit.png" /></span>
										</a>
										<a href="#" class="uibutton2" onclick="deleteSelectedAccHead();">
											<span class="uitext2"><img src="../images/b_drop.png" /></span>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div id="status-div" style="display:none;height:20px;width:510px;margin-left:70px;margin-top: 10px;margin-right:10px;border:1px solid #D0D0D0;background-color:#EFEFEF;color:#303030;padding:5px 10px 2px 10px;">
							<div id="status-text">Status Messages Go Here</div>
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
			<div style="background-color:#FFFFFF;z-index:101">	
				<table style="background-color:#FFFFF;font-size:11px" width="450px" cellpadding="5" cellspacing="0">
					<tr height="20px"><td colspan="3"></td></tr>
					<tr height="40px">
						<td width="1px"></td>
						<td id="field-label" width="100px">Product Name</td>
						<td>
							<input type="text" class="txtInputField" id="name" size="30"></input> 
						</td>
					</tr>
					<tr height="50px">
						<td colspan="2"></td>
						<td>
							<a href="#" class="uibutton2" onclick="addType()">
								<span class="uitext2">Save</span>
							</a>
							<a href="#" class="uibutton2" onclick="clearWindowForm()">
								<span class="uitext2">Clear</span>
							</a>
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
