<?php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Login :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/index.css" />
		
		<script src="js/util/ajaxhandler.js"></script>
		<script src="js/util/common.js"></script>
		
		<script>
			function login(){
				document.forms[0].submit();
			}
			function clearForm(){
				document.forms[0].reset();
				document.getElementById("username").focus();
			}
			function init(){
				login();
			}
		</script>
    </head>
    <body onload="init()">
    	<div id="wrapper">
    		<div id="header">
    		</div>
			<div id="content">
    			<div class="panel-title">
					WELCOME TO PAYMENT SCHEDULING SYSTEM
				</div>
    			<div id="logindialog-wrapper">
    				<div id="logindialog">
	    				<form method="POST" action="src/controller/LoginController.php">
	    					<table id="login-table">
	    						<tr height="30px">
	    							<td width="80px">
	    								Username :
	    							</td>
	    							<td>
	    								<input type="text" class="txtInputField" id="username" name="username" value="admin" maxlength="20" />
	    							</td>
	    						</tr>
	    						<tr height="30px">
	    							<td>
	    								Password :
	    							</td>
	    							<td>
	    								<input type="password" class="txtInputField" id="password" name="password" value="admin" maxlength="15" />
	    							</td>
	    						</tr>
	    						<tr height="35px">
	    							<td>
	    								Login as :
	    							</td>
	    							<td>
	    								<select name="usertype">
				    						<option value="administrator">Administrator</option>
				    						<option value="operator">Operator</option>
				    					</select>
	    							</td>
	    						</tr>
	    						<tr height="60px">
	    							<td>
	    							</td>
	    							<td>
	    								<a href="#" class="uibutton1" onclick="login()">
											<span class="uitext1">Login</span>
										</a>
										<a href="#" class="uibutton1" onclick="clearForm()">
											<span class="uitext1">Clear</span>
										</a>
	    							</td>
	    						</tr>
	    					</table>
	    				</form>
	    			</div>
    			</div>
    		</div>
			<div id="footer">
    		
    		</div>
    	</div>
    </body>
</html>
