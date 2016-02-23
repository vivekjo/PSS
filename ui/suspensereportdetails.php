<?php
	include_once '../src/vo/SuspenseentryVO.php';
	include_once '../src/vo/SuspensedetailsVO.php';
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>

<html>
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Payment Schedule :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/suspensereportdetails.css" />
		
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
			
			function init(){
				setTimeout('loadData()', 150);
			}
			function loadData(){
				getAllGroups();
				getAllItems();
				getAllSubItems();
				getAllEmployees();
				getAllLocations();					
				
				setTimeout('updateNames()',500);
			}
		</script>		
</head>
 <body onload="init()">
	<form method="POST" action="">
		<div id="suspensereportdetaildiv">
			<?php 
				$suspenseReportDetailArray = null;
		 		if(isset($_SESSION['reportDetailsArray'])){
		 			$suspenseReportDetailArray = $_SESSION['reportDetailsArray'];
		 		}				
			?>
			<table class="suspense-table"	cellpadding="3px" FRAME="box"  border="0">
				<tr>
					<td colspan="4" height="35px" align="center" style="font-size:13px;font-weight:bold">
						SUSPENSE REPORT
					</td>
				</tr>
				<tr height="20px">
					<td>
						Date Range :
					</td>
					<td width="30px">
						 <?php echo $suspenseReportDetailArray['fromdate'];?>&nbsp;&nbsp;To&nbsp;&nbsp;<?php echo $suspenseReportDetailArray['todate'];?> 
					</td>
					<td>
						Type :
					</td>
					<td id="itemreport" width="100px">
						<?php echo $suspenseReportDetailArray['typeMode'];?>
					</td>																
				</tr>
				<tr height="20px">
					<td width="90px">
						Issuer :
					</td>
					<td width="160px">
						 <?php echo $suspenseReportDetailArray['issuerName'];?>
					</td>
					<td width="90px">
						Bearer:
					</td>
					<td id="groupreport">
						<?php echo $suspenseReportDetailArray['bearerName'];?>
					</td>
				</tr>
				<tr height="20px">
					<td width="90px">
						Receiver :
					</td>
					<td width="160px">
						 <?php echo $suspenseReportDetailArray['receiverName'];?>
					</td>
					<td width="90px">
						Location :
					</td>
					<td id="groupreport">
						<?php echo $suspenseReportDetailArray['locationName'];?>
					</td>
				</tr>			
				<tr height="20px">
					<td width="90px">
						Mode :
					</td>
					<td width="160px">
						 <?php echo $suspenseReportDetailArray['mode'];?>
					</td>
				</tr>			
			</table>
		</div>
		<div id="suspenseereportdiv">
			<table class="suspense-table" cellpadding="3px" FRAME="box" RULES="all">
				<tr id="r_1" height="25px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
					<td align="right" rowspan="2">
						S.no
					</td>
					<td align="center" rowspan="2" width="30px">
						ID
					</td>
					<td align="center" rowspan="2" width="30px">
						Date
					</td>
					<td  align="center" rowspan="2" width="90px">
						Issuer
					</td>				
					<td align="center"  rowspan="2" width="90px" > 
						Bearer
					</td>
					<td align="center"  rowspan="2" width="90px" > 
						Receiver
					</td>
					<td align="center"  rowspan="2" width="60px" > 
						Location
					</td>
					<td align="center"  rowspan="2" width="60px" > 
						Type
					</td>					
					<td align="center"  rowspan="2" width="60px" > 
						Mode
					</td>					
					<td align="center"  rowspan="2" width="60px" > 
						RefId
					</td>					
					<td colspan="10" align="center">
						Suspense Details
					</td>
				</tr>
				<tr id="r_1" height="25px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
					<td align="center"  width="15px">
						S.no
					</td>
					<td align="center"  width="70px">
						Group
					</td>
					<td align="center"  width="70px">
						Item
					</td>
					<td align="center"  width="100px">
						Sub Item
					</td>
					<td align="center"  width="30px">
						Pcs
					</td>
					<td align="center"  width="30px">
						Type
					</td>
					<td align="center"  width="30px">
						G.wt
					</td>
					<td align="center"  width="30px">
						N.wt
					</td>
					<td align="center"  width="30px">
						24ctpure
					</td>
					<td align="center"  width="30px">
						Amount
					</td>
				</tr>
				<?php  
					$suspenseentrylist = null;
					if(isset($_SESSION['suspenseentrylist'])){
						$suspenseentrylist = $_SESSION['suspenseentrylist'];
						$count = 1;
						$rowCount = 1;
						if(count($suspenseentrylist)!=0){
							foreach($suspenseentrylist as $suspenseentryVO){
								$suspenseDetailsList = $suspenseentryVO->getSuspenseDetailList();
				?>
				<tr>	
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>"><?php echo $count?></td>
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'suspenseid' . $count;?>"><?php echo $suspenseentryVO->getSuspenseId();?></td>		
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'date' . $count;?>"><?php echo $suspenseentryVO->getDate();?></td>		
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'issuerid' . $count;?>"><?php echo $suspenseentryVO->getIssuerId();?></td>		
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'bearerid' . $count;?>"><?php echo $suspenseentryVO->getBearerId();?></td>		
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'receiverid' . $count;?>"><?php echo $suspenseentryVO->getReceiverId();?></td>		
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'locationid' . $count;?>"><?php echo $suspenseentryVO->getLocationId();?></td>		
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'typeid' . $count;?>"><?php echo $suspenseentryVO->getType();?></td>
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'mode' . $count;?>"><?php echo $suspenseentryVO->getMode();?></td>
					<td align="center" rowspan="<?php echo (count($suspenseDetailsList)+1);?>" id="<?php echo 'refId' . $count;?>"><?php echo $suspenseentryVO->getRefSuspenseId();?></td>
					<?php $count++;?>		
				</tr>	
				<?php 
					$detailCount = 1;
						if(count($suspenseDetailsList)!=0){ 
								foreach($suspenseDetailsList as $suspensedetailsVO){		
						?>																																
								<tr>
									<td align="right"><?php echo $detailCount;?></td>
									<td id="<?php echo 'group'. $rowCount;?>" align="center"><?php echo $suspensedetailsVO->getGroupId();?></td>
									<td id="<?php echo 'item'. $rowCount;?>" align="center"><?php echo $suspensedetailsVO->getItemId();?></td>
									
									<td id="<?php echo 'subitem'. $rowCount;?>" align="center"><?php echo $suspensedetailsVO->getSubitemId();?></td>
									<td align="right"><?php echo  $suspensedetailsVO->getPcs();?></td>
									<td align="right"><?php echo  $suspensedetailsVO->getType();?></td>
									<td align="right"><?php echo number_format($suspensedetailsVO->getGwt(),3);?></td>
									<td align="right"><?php echo number_format($suspensedetailsVO->getNwt(),3);?></td>

									<td align="right"><?php echo number_format($suspensedetailsVO->getCtpure(),3);?></td>
									<td align="right"><?php echo number_format($suspensedetailsVO->getAmount(),3);?></td>
								</tr>
					<?php 
								$detailCount++;	
								$rowCount++;
							}
						}																
					?>
								
				<?php  				
							}
						}else{
				?>			
						<tr>
							<td height="30px" align="center" colspan="19">
								THERE ARE NO SUSPENSE ENTRIES FOR THE SELECTED CRITERIA
							</td>
						</tr>	
				<?php 		}	
					}														
				?>
				 
			</table>
		</div>
	</form>
</body>
</html>