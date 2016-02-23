<div style="float:right;font-size:11px;margin-right:15px;margin-top:20px;">
    <b>Welcome 
    <?php 
    	if($userType == "administrator"){
    		echo "Administrator!";
    	}else{
    		echo "Operator!";
    	}
    ?>
    </b>
    <br/>
    <p align="right">
    	<a href="../src/controller/LogoutController.php" style="text-decoration:underline">Logout </a>
    </p>
</div>