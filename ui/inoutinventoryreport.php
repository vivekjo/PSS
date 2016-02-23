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
				//getAllEmployees();
				//getAllLocations();
				
				setTimeout('updateNames()',1000);
			}
		</script>		
</head>
 <body onload="init()">
	<form method="POST" action="">
		<div id="inoutereportdetaildiv">
			<?php 
				$inlistArray = null;
		 		if(isset($_SESSION['inlist'])){
		 			$inlistArray = $_SESSION['inlist'];
		 		}				
				$outlistArray = null;
		 		if(isset($_SESSION['outlist'])){
		 			$outlistArray = $_SESSION['outlist'];
		 		}				
				$opInoutArray = null;
		 		if(isset($_SESSION['opinout'])){
		 			$opInoutArray = $_SESSION['opinout'];
		 		}				
				$clInoutArray = null;
		 		if(isset($_SESSION['clinout'])){
		 			$clInoutArray = $_SESSION['clinout'];
		 		}				
				$parentGroup = null;
		 		if(isset($_SESSION['parentGroup'])){
		 			$parentGroup = $_SESSION['parentGroup'];
		 		}				
				$parentItem = null;
		 		if(isset($_SESSION['parentItem'])){
		 			$parentItem = $_SESSION['parentItem'];
		 		}				
			?>
			<?php 
				$inoutReportDetailArray = null;
		 		if(isset($_SESSION['reportDetailsArray'])){
		 			$inoutReportDetailArray = $_SESSION['reportDetailsArray'];
		 		}				
			?>
			<table class="inout-table"	cellpadding="3px" FRAME="box"  border="0">
				<tr>
					<td colspan="4" height="35px" align="center" style="font-size:13px;font-weight:bold">
						IN/OUT INVENTORY REPORT
					</td>
				</tr>
				<tr height="20px">
					<td>
						Date :
					</td>
					<td id="datevalue" width="30px">
						 <?php echo $inoutReportDetailArray['selecteddate']; ?>
					</td>
				</tr>
			</table>
		</div>
		<div id="inoutereportdiv">
			<table class="inout-table" cellpadding="3px" FRAME="box" RULES="all">
				<tr id="r_1" height="25px" style="background-color: #e7edf6;color: #000000;font-weight: bold;">
					<td align="right" rowspan="1">
						S.no
					</td>
					<td align="center" rowspan="1" width="30px">
						Group
					</td>
					<td align="center" rowspan="1" width="30px">
						Item
					</td>
					<td  align="center" rowspan="1" width="90px">
						SubItem
					</td>				
					<td align="center"  rowspan="1" width="90px" > 
						Opening
					</td>
					<td align="center"  rowspan="1" width="90px" > 
						In
					</td>
					<td align="center"  rowspan="1" width="60px" > 
						Out
					</td>
					<td align="center"  rowspan="1" width="60px" > 
						Closing
					</td>					
				</tr>
				
				<?php  
					$count = 1;
					
					$total_opening = 0;
					$total_in = 0;
					$total_out = 0;
					$total_closing = 0;
					
					$opening = 0;
					$in = 0;
					$out = 0;
					$closing = 0;
					
				?>
				<?php 
					foreach($inlistArray as $subitemId=>$pcs){
				?>
				<tr>			
					<td align="center" ><?php echo $count;?></td>
					<td align="center" id="<?php echo 'group'. $count;?>"><?php echo $parentGroup[$subitemId];?></td>		
					<td align="center" id="<?php echo 'item'. $count;?>"><?php echo $parentItem[$subitemId];?></td>		
					<td align="center" id="<?php echo 'subitem'. $count;?>"><?php echo $subitemId;?></td>
					<?php 
						if(isset($opInoutArray[$subitemId])){
							$opening = $opInoutArray[$subitemId];
							$total_opening = $total_opening + $opening;
							unset($opInoutArray[$subitemId]);
						}else{
							$opening = 0;
						}
						if(isset($inlistArray[$subitemId])){
							$in = $inlistArray[$subitemId];
							$total_in = $total_in + $in;
							unset($inlistArray[$subitemId]);
						}
						if(isset($outlistArray[$subitemId])){
							$out = $outlistArray[$subitemId];
							$total_out = $total_out + $out;
							unset($outlistArray[$subitemId]);
						}else{
							$out = 0;
						}
						if(isset($clInoutArray[$subitemId])){
							$closing = $clInoutArray[$subitemId];
							$total_closing = $total_closing + $closing;
							unset($clInoutArray[$subitemId]);
						}else{
							$closing = 0;
						}
					?>		
					<td align="center"><?php echo $opening;?></td>		
					<td align="center"><?php echo $in;?></td>		
					<td align="center"><?php echo $out;?></td>		
					<td align="center"><?php echo $closing;?></td>
					<?php $count++;?>		
				</tr>	
				<?php 
					}
				?>
				 <?php 
					foreach($outlistArray as $subitemId=>$pcs){
				?>
				<tr>			
					<td align="center" ><?php echo $count;?></td>
					<td align="center" id="<?php echo 'group'. $count;?>"><?php echo $parentGroup[$subitemId];?></td>		
					<td align="center" id="<?php echo 'item'. $count;?>"><?php echo $parentItem[$subitemId];?></td>		
					<td align="center" id="<?php echo 'subitem'. $count;?>"><?php echo $subitemId;?></td>
					<?php 
						if(isset($opInoutArray[$subitemId])){
							$opening = $opInoutArray[$subitemId];
							$total_opening = $total_opening + $opening;
							unset($opInoutArray[$subitemId]);
						}else{
							$opening = 0;
						}
						$in=0;
						if(isset($outlistArray[$subitemId])){
							$out = $outlistArray[$subitemId];
							$total_out = $total_out + $out;
							unset($outlistArray[$subitemId]);
						}
						if(isset($clInoutArray[$subitemId])){
							$closing = $clInoutArray[$subitemId];
							$total_closing = $total_closing + $closing;
							unset($clInoutArray[$subitemId]);
						}else{
							$closing = 0;
						}
					?>		
					<td align="center"><?php echo $opening;?></td>		
					<td align="center"><?php echo $in;?></td>		
					<td align="center"><?php echo $out;?></td>		
					<td align="center"><?php echo $closing;?></td>
					<?php $count++;?>		
				</tr>	
				<?php 
					}
				?>
				<?php 
					foreach($opInoutArray as $subitemId=>$pcs){
				?>
				<tr>			
					<td align="center" ><?php echo $count;?></td>
					<td align="center" id="<?php echo 'group'. $count;?>"><?php echo $parentGroup[$subitemId];?></td>		
					<td align="center" id="<?php echo 'item'. $count;?>"><?php echo $parentItem[$subitemId];?></td>		
					<td align="center" id="<?php echo 'subitem'. $count;?>"><?php echo $subitemId;?></td>
					<?php 
						if(isset($opInoutArray[$subitemId])){
							$opening = $opInoutArray[$subitemId];
							$total_opening = $total_opening + $opening;
							unset($opInoutArray[$subitemId]);
						}
						$in=0;
						$out=0;
						if(isset($clInoutArray[$subitemId])){
							$closing = $clInoutArray[$subitemId];
							$total_closing = $total_closing + $closing;
							unset($clInoutArray[$subitemId]);
						}else{
							$closing = 0;
						}
					?>		
					<td align="center"><?php echo $opening;?></td>		
					<td align="center"><?php echo $in;?></td>		
					<td align="center"><?php echo $out;?></td>		
					<td align="center"><?php echo $closing;?></td>
					<?php $count++;?>		
				</tr>	
				<?php 
					}
				?>
				<tr>
					<td align="right" colspan="4">TOTAL : </td>
					<td align="center"><?php echo $total_opening;?></td>		
					<td align="center"><?php echo $total_in;?></td>		
					<td align="center"><?php echo $total_out;?></td>		
					<td align="center"><?php echo $total_closing;?></td>				
				</tr>
			</table>
		</div>
	</form>
</body>
</html>