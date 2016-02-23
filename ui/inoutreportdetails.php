<?php
	include_once '../src/vo/InoutentryVO.php'; 
	include_once '../src/vo/InoutdetailsVO.php'; 
	include_once '../src/3putils/Collection.php'; 
	include_once 'Authenticator.php'; 
?>

<html>
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: In/Out Report :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/inoutreportdetails.css" />
		
		<script src="../js/reports/inoutreport.js"></script>
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
				getAllGroups();
				getAllItems();
				getAllSubItems();
				getAllEmployees();
				getAllLocations();
					
				
				setTimeout('updateNames()',1000);
			}
		</script>		
</head>
 <body onload="init()">
	<form method="POST" action="">
		<div id="inoutereportdetaildiv">
			<?php 
				$inoutReportDetailArray = null;
		 		if(isset($_SESSION['reportDetailsArray'])){
		 			$inoutReportDetailArray = $_SESSION['reportDetailsArray'];
		 		}				
			?>
			<table class="inout-table"	cellpadding="3px" FRAME="box"  border="0">
				<tr>
					<td colspan="4" height="35px" align="center" style="font-size:13px;font-weight:bold">
						IN/OUT REPORT
					</td>
				</tr>
				<tr height="20px">
					<td>
						Date Range :
					</td>
					<td width="30px">
						 <?php echo $inoutReportDetailArray['fromdate'];?>&nbsp;&nbsp;To&nbsp;&nbsp;<?php echo $inoutReportDetailArray['todate'];?> 
					</td>
					<td>
						Type :
					</td>
					<td id="itemreport" width="100px">
						<?php echo $inoutReportDetailArray['typeMode'];?>
					</td>																
				</tr>
				<tr height="20px">
					<td width="90px">
						Issuer :
					</td>
					<td width="160px">
						 <?php echo $inoutReportDetailArray['issuerName'];?>
					</td>
					<td width="90px">
						Bearer:
					</td>
					<td id="groupreport">
						<?php echo $inoutReportDetailArray['bearerName'];?>
					</td>
				</tr>
				<tr height="20px">
					<td width="90px">
						Receiver :
					</td>
					<td width="160px">
						 <?php echo $inoutReportDetailArray['receiverName'];?>
					</td>
					<td width="90px">
						Location :
					</td>
					<td id="groupreport">
						<?php echo $inoutReportDetailArray['locationName'];?>
					</td>
				</tr>			
			</table>
		</div>
		<div id="inoutereportdiv">
			<table class="inout-table" cellpadding="3px" FRAME="box" RULES="all">
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
					<td colspan="9" align="center">
						Inout Details
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
					$inoutentrylist = null;
					if(isset($_SESSION['inoutentrylist'])){
						$inoutentrylist = $_SESSION['inoutentrylist'];
						$count = 1;
						$rowCount = 1;
						if(count($inoutentrylist)!=0){
							foreach($inoutentrylist as $inoutentryVO){
								$inoutDetailsList = $inoutentryVO->getInoutDetailsList();
				?>
				<tr>			
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>"><?php echo $count?></td>
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>" id="<?php echo 'inoutid' . $count;?>"><?php echo $inoutentryVO->getInoutId();?></td>
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>" id="<?php echo 'date' . $count;?>"><?php echo $inoutentryVO->getDate();?></td>		
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>" id="<?php echo 'issuerid' . $count;?>"><?php echo $inoutentryVO->getIssuerId();?></td>		
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>" id="<?php echo 'bearerid' . $count;?>"><?php echo $inoutentryVO->getBearerId();?></td>		
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>" id="<?php echo 'receiverid' . $count;?>"><?php echo $inoutentryVO->getReceiverId();?></td>		
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>" id="<?php echo 'locationid' . $count;?>"><?php echo $inoutentryVO->getLocationId();?></td>		
					<td align="center" rowspan="<?php echo (count($inoutDetailsList)+1);?>" id="<?php echo 'typeid' . $count;?>"><?php echo $inoutentryVO->getType();?></td>
					<?php $count++;?>		
				</tr>	
				<?php 
					$detailCount = 1;
						if(count($inoutDetailsList)!=0){ 
								foreach($inoutDetailsList as $inoutdetailsVO){		
						?>																																
								<tr>
									<td align="right"><?php echo $detailCount;?></td>
									<td id="<?php echo 'group'. $rowCount;?>" align="center"><?php echo $inoutdetailsVO->getGroupId();?></td>
									<td id="<?php echo 'item'. $rowCount;?>" align="center"><?php echo $inoutdetailsVO->getItemId();?></td>
									
									<td id="<?php echo 'subitem'. $rowCount;?>" align="center"><?php echo $inoutdetailsVO->getSubitemId();?></td>
									<td align="right"><?php echo  $inoutdetailsVO->getPcs();?></td>

									<td align="right"><?php echo number_format($inoutdetailsVO->getGwt(),3);?></td>
									<td align="right"><?php echo number_format($inoutdetailsVO->getNwt(),3);?></td>

									<td align="right"><?php echo number_format($inoutdetailsVO->getCtpure(),3);?></td>
									<td align="right"><?php echo number_format($inoutdetailsVO->getAmount(),2);?></td>
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
							<td height="30px" colspan="18" align="center" colspan="18">
								THERE ARE NO INOUT ENTRIES FOR THE SELECTED CRITERIA
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