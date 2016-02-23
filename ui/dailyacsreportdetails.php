<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php 
	include_once '../src/vo/DaybookVO.php'; 
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Daily Accounts Report :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/dailyacsreportdetails.css" />
		
		<script src="../js/reports/dailyacsreport.js"></script>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>
		<script src="../js/util/validator.js"></script>
		
		<script type="text/javascript" src="../js/3putil/sortable.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery-1.4.2.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.core.js"></script>
		<script type="text/javascript" src="../js/3putil/jquery.ui.datepicker.js"></script>
		
		<script type="text/javascript">
			
			function init(){
				sortables_init();
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllChannels();
				getAllAccheads();
				setTimeout('updateTables()',1000);
			}
		</script>		
    </head>
    <body onload="init()">
				<form method="POST" action="">
					<div id="paymentreportdetaildiv">
						<?php 
							$accountsCriteriaList = null;
					 		if(isset($_SESSION['accountsCriteriaList'])){
					 			$accountsCriteriaList = $_SESSION['accountsCriteriaList'];
					 		}				
						?>
						<table class="purchase-table" cellpadding="3px" FRAME="box"  border="0">
									<tr>
										<td colspan="6" height="35px" align="center" style="font-size:13px;font-weight:bold">
											INCOMING/OUTGOING REPORT
										</td>
									</tr>
									<tr height="20px">
										<td>
											Date Range :
										</td>
										<td width="160px">
											 <?php echo $accountsCriteriaList['fromdate'];?>&nbsp;&nbsp;To&nbsp;&nbsp;<?php echo $accountsCriteriaList['todate'];?> 
										</td>
										<td width="100px">
											Mode :
										</td>
										<td width="40px">
											 <?php echo $accountsCriteriaList['mode'];?>
										</td>														
									</tr>
									<tr height="20px">
										<td width="100px">
											Type :
										</td>
										<td width="40px">
											 <?php echo $accountsCriteriaList['type'];?>
										</td>
										<td>
											Category :
										</td>
										<td width="110px" id="categoryreport">
											<?php echo $accountsCriteriaList['category'];?>
										</td>
										<td>
											Account Head :
										</td>
										<td id="accheadreport">
											<?php echo $accountsCriteriaList['acchead'];?>
										</td>
									</tr>
								</table>
						
					</div>										
					<div id="paymentreportdiv">
						<?php 
							if($accountsCriteriaList['type'] != 'outgoing'){
						?>
						INCOMING
						<table class="purchase-table" cellpadding="3px" FRAME="box" RULES="all">
							<tr id="r_1" height="40px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
								<td>
									S.no
								</td>
								<td align="center" width="30px">
									Date
								</td>
								<td align="center" width="90px"> 
									Category
								</td>
								<td align="center" width="30px">
									Account Head
								</td>
								<td align="center">
									PG
								</td>
								<td align="center">
									LPG
								</td>
								<td align="center">
									Silver
								</td>
								<td align="center">
									Cash
								</td>
								<td align="center">
									Description
								</td>
							</tr>
							<?php  
								$accountslist = null;
								if(isset($_SESSION['accountsList'])){
									$accountslist = $_SESSION['accountsList'];
									$count = 1;
									$incomingCount = 0;
									if(count($accountslist)!=0){
										$pg = 0;
										$lpg=0;
										$silver = 0;
										$cash = 0;
										foreach($accountslist as $daybookVO){
											if($daybookVO->getType() == 'incoming'){																
							?>
												<tr>
													<td align="right"><?php echo $count;?></td>
													<td id="<?php echo 'idate' . $count ?>" ><?php echo $daybookVO->getDate();?></td>
													<td width="120px" id="<?php echo 'icategory' . $count ?>" align="center"><?php echo $daybookVO->getCategoryId();?></td>
													<td width="120px" id="<?php echo 'iacchead' . $count ?>" align="center"><?php echo $daybookVO->getAccheadId();?></td>
													<td width="50px" align="right"><?php echo number_format($daybookVO->getPg(),3);?></td>
													<td width="50px" align="right"><?php echo number_format($daybookVO->getLpg(),3);?></td>
													<td width="50px" align="right"><?php echo  number_format($daybookVO->getSilver(),3);?></td>
													<td width="50px" align="right"><?php echo  number_format($daybookVO->getCash(),2);?></td>
													<td width="150px"><?php echo $daybookVO->getDescription();?></td>
												</tr>
							<?php
												$pg = $pg + $daybookVO->getPg();								
												$lpg = $lpg + $daybookVO->getLpg();								
												$silver = $silver + $daybookVO->getSilver();								
												$cash = $cash + $daybookVO->getCash();	
																			
												$count++;
												$incomingCount++;
											} 
										}
										if($incomingCount > 0){
							?>
											<tr>
												<td colspan="4" align="right">TOTAL : </td>
												<td align="right"><?php echo number_format($pg,3); ?></td>
												<td align="right"><?php echo number_format($lpg,3); ?></td>
												<td align="right"><?php echo number_format($silver,3); ?></td>
												<td align="right"><?php echo number_format($cash,2); ?></td>
												<td align="right"></td>
											</tr>
							<?php
										}else{
							?>
											<tr>
												<td height="30px" colspan="9" align="center" colspan="18">
													THERE ARE NO INCOMING ENTRIES FOR THE SELECTED CRITERIA
												</td>
											</tr>
							<?php 				
											
										}
									}else{
							?>
									<tr>
										<td height="30px" colspan="9" align="center" colspan="18">
											THERE ARE NO INCOMING ENTRIES FOR THE SELECTED CRITERIA
										</td>
									</tr>
							<?php 			
									}
								}
							?>
					</table>
					<?php } ?>
					<?php 
						if($accountsCriteriaList['type'] != 'incoming'){
					?>
						<br />OUTGOING
						<table class="purchase-table" cellpadding="3px" FRAME="box" RULES="all">
							<tr id="r_1" height="40px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
								<td>
									S.no
								</td>
								<td width="30px">
									Date
								</td>
								<td align="center" width="90px"> 
									Category
								</td>
								<td align="center" width="30px">
									Account Head
								</td>
								<td align="center">
									PG
								</td>
								<td align="center">
									LPG
								</td>
								<td align="center">
									Silver
								</td>
								<td align="center">
									Cash
								</td>
								<td align="center">
									Description
								</td>
							</tr>
							<?php  
								$accountslist = null;
								if(isset($_SESSION['accountsList'])){
									$accountslist = $_SESSION['accountsList'];
									$count = 1;
									$outgoingCount = 0;
									if(count($accountslist)!=0){
										$pg = 0;
										$lpg=0;
										$silver = 0;
										$cash = 0;
										foreach($accountslist as $daybookVO){
											if($daybookVO->getType() == 'outgoing'){																
							?>
												<tr>
													<td align="right"><?php echo $count;?></td>
													<td id="<?php echo 'odate' . $count ?>" ><?php echo $daybookVO->getDate();?></td>
													<td width="120px" id="<?php echo 'ocategory' . $count ?>" align="center"><?php echo $daybookVO->getCategoryId();?></td>
													<td width="120px" id="<?php echo 'oacchead' . $count ?>" align="center"><?php echo $daybookVO->getAccheadId();?></td>
													<td width="50px" align="right"><?php echo number_format($daybookVO->getPg(),3);?></td>
													<td width="50px" align="right"><?php echo number_format($daybookVO->getLpg(),3);?></td>
													<td width="50px" align="right"><?php echo  number_format($daybookVO->getSilver(),3);?></td>
													<td width="50px" align="right"><?php echo  number_format($daybookVO->getCash(),2);?></td>
													<td width="150px"><?php echo $daybookVO->getDescription();?></td>
												</tr>
							<?php
												$pg = $pg + $daybookVO->getPg();								
												$lpg = $lpg + $daybookVO->getLpg();								
												$silver = $silver + $daybookVO->getSilver();								
												$cash = $cash + $daybookVO->getCash();	
																			
												$count++;
												$outgoingCount++;
											} 
										}
										if($outgoingCount > 0){
							?>
											<tr>
												<td colspan="4" align="right">TOTAL : </td>
												<td align="right"><?php echo number_format($pg,3); ?></td>
												<td align="right"><?php echo number_format($lpg,3); ?></td>
												<td align="right"><?php echo number_format($silver,3); ?></td>
												<td align="right"><?php echo number_format($cash,2); ?></td>
												<td align="right"></td>
											</tr>
							<?php
										}else{
											
							?>				
											<tr>
												<td height="30px" colspan="9" align="center" colspan="18">
													THERE ARE NO OUTGOING ENTRIES FOR THE SELECTED CRITERIA
												</td>
											</tr>
							<?php 				
										}
									}else{
							?>
									<tr>
										<td height="30px" colspan="9" align="center" colspan="18">
											THERE ARE NO OUTGOING ENTRIES FOR THE SELECTED CRITERIA
										</td>
									</tr>
							<?php 			
									}
								}
							?>
					</table>
				<?php } ?>
				</div>
			</form>
    </body>
</html>
