<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Product Master :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/home.css" />
		
		<script src="../js/masters/groupmaster.js"></script>
		<script src="../js/masters/itemmaster.js"></script>
		<script src="../js/masters/subitemmaster.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		
		<script>
			function init(){
				getAllGroups();
			}
		</script>
		
    </head>
    <body onload="init()">
    	<div id="wrapper">
    		<div id="header">
    			<img src="images/slj_logo.jpg" style="margin-left:27px;"/>
    		</div>
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
							PRODUCT MASTER
						</div>
						<div id="panel-wrapper">
							<div id="selectpanel-header-wrapper">
								<div id="grouppanel-header">
									<div class="panel-header">Group</div>
								</div>
								<div id="itempanel-header">
									<div class="panel-header">Items</div>
								</div>
								<div id="subitempanel-header">
									<div class="panel-header">SubItems</div>
								</div>
							</div>
			    			<div id="selectpanel-wrapper">
			    				<div id="grouppanel">
			    					<div id="1" class="panel-element" onclick="getItemsByGroup(this.id)">
			    						Gold
			    					</div>
			    					<div id="2" class="panel-element" onclick="getItemsByGroup(this.id)">
			    						Diamond
			    					</div>
			    					<div class="panel-element">
			    						Silver
			    					</div>
			    					<div class="panel-element">
			    						Accessories
			    					</div>
			    					<div class="panel-element">
			    						Accessories
			    					</div>
			    					<div class="panel-element">
			    						Accessories
			    					</div>
			    					<div class="panel-element">
			    						Accessories
			    					</div>
			    					<div class="panel-element">
			    						Accessories
			    					</div>
			    					<div class="panel-element">
			    						Accessories
			    					</div>
			    					
			    				</div>
			    				<div id="itempanel">
			    				</div>
			    				<div id="subitempanel">
			    				</div>
			    			</div>
			    			<div id="selectpanel-footer-wrapper">
								<div id="grouppanel-footer">
									<div class="panel-footer">
										<a href="#" class="uibutton2" onclick="login()">
											<span class="uitext2"><img src="../images/plus.jpg" onclick="addGroup();"/></span>
										</a>
										<a href="#" class="uibutton2" onclick="clear()">
											<span class="uitext2"><img src="../images/b_edit.png" onclick="editSelectedGroup();"/></span>
										</a>
										<a href="#" class="uibutton2" onclick="clear()">
											<span class="uitext2"><img src="../images/b_drop.png" onclick="deleteSelectedGroup();" /></span>
										</a>
									</div>
								</div>
								<div id="itempanel-footer">
									<div class="panel-footer">
										<a href="#" class="uibutton2" onclick="login()">
											<span class="uitext2"><img src="../images/plus.jpg" onclick="addItem();"/></span>
										</a>
										<a href="#" class="uibutton2" onclick="clear()">
											<span class="uitext2"><img src="../images/b_edit.png" onclick="editSelectedItem();"/></span>
										</a>
										<a href="#" class="uibutton2" onclick="clear()">
											<span class="uitext2"><img src="../images/b_drop.png" onclick="deleteSelectedItem();"/></span>
										</a>
									</div>
								</div>
								<div id="subitempanel-footer">
									<div class="panel-footer">
										<a href="#" class="uibutton2" onclick="login()">
											<span class="uitext2"><img src="../images/plus.jpg" onclick="addSubItem();"/></span>
										</a>
										<a href="#" class="uibutton2" onclick="clear()">
											<span class="uitext2"><img src="../images/b_edit.png" onclick="editSelectedSubItem();"/></span>
										</a>
										<a href="#" class="uibutton2" onclick="clear()">
											<span class="uitext2"><img src="../images/b_drop.png" onclick="deleteSelectedSubItem();"/></span>
										</a>
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
