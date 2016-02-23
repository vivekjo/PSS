<?php 
	include_once '../src/vo/DaybookVO.php';
	include_once '../src/vo/ProjectionVO.php';
	include_once '../src/vo/PaymentTypeVO.php'; 
	include_once '../src/util/XMLBuilder.php'; 
	include_once 'Authenticator.php'; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title>:: Purchase Planner :: Payment Scheduling :: Sri Lakshmi Jewellery</title>
		
		<link rel="stylesheet" type="text/css" href="../css/jquery/jquery.ui.all.css">
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/conspurchaseplanner.css" />
		
		<script type="text/javascript">
			function init(){
				toggleRows('incomingRows','collapse');
				toggleRows('outgoingRows','collapse');
			}
			function toggleRows(rowName,action){
				var rowElement = document.getElementsByName(rowName);
				var rowLength = rowElement.length;
				var styleVar = null;
				if(action == 'expand'){
					styleVar = "table-row";
				}else{
					styleVar = "none";
				}
				for(var i=0;i<rowLength;i++){
					rowElement[i].style.display = styleVar;
				}
			}		
		</script>
		
    </head>
    <body onload="init()">
    	<?php 
    		$reportDetails = null;
    		$xmlBuilder = new XMLBuilder();
    		if(isset($_SESSION['reportDetails'])){
				$reportDetails = $_SESSION['reportDetails'];
			}
    	?>
    	<div id="reportdetailsdiv">
    		CONSOLIDATED PURCHASE PLANNER FROM <?php echo $xmlBuilder->getFormattedDateString($reportDetails['fromdate'],'d/m/Y')?> TO <?php echo $xmlBuilder->getFormattedDateString($reportDetails['todate'],'d/m/Y')?>
    	</div>
		<div id="psreportdiv">
			<?php 
				$incomingHeads = null;	
				$outgoingHeads = null;	
				$incomingsList = null;	
				$outgoingsList = null;	
				$projectedIncomingsList = null;
				$projectedOutgoingsList = null;
				
				$projectedIncomingTotal = null;
				$vendorPaymentsList = null;	
				
				if(isset($_SESSION['incomingHeads'])){
					$incomingHeads = $_SESSION['incomingHeads'];
				}
				if(isset($_SESSION['outgoingHeads'])){
					$outgoingHeads = $_SESSION['outgoingHeads'];
				}
				if(isset($_SESSION['incomingsList'])){
					$incomingsList = $_SESSION['incomingsList'];
				}
				if(isset($_SESSION['outgoingsList'])){
					$outgoingsList = $_SESSION['outgoingsList'];
				}
				
				if(isset($_SESSION['projectedIncomingsList'])){
					$projectedIncomingsList = $_SESSION['projectedIncomingsList'];
				}
				if(isset($_SESSION['projectedOutgoingsList'])){
					$projectedOutgoingsList = $_SESSION['projectedOutgoingsList'];
				}
				if(isset($_SESSION['vendorPaymentsList'])){
					$vendorPaymentsList = $_SESSION['vendorPaymentsList'];
				}
				
				if($reportDetails != null){
			?>
				<table id="purchaseplannertable" style="font-size:11px;" class="purchase-table" cellpadding="3px">
						<tr height="35px" class="highlighted-row1">
							<td width="170px" align="center"> 
								Description
							</td>
							<?php 
								$incomingTotals = array(); 
								$projectedIncomingTotals = array(); 
								$projectedOutgoingTotals = array(); 
								$outgoingTotals = array(); 
								$totals = array(); 
								
								$fromdate = $reportDetails['fromdate'];
								$todate = $reportDetails['todate'];
								
								$tmpdate = $fromdate;
								$noOfDays = 0;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
								<td align="right" width="70px">
									<?php echo $xmlBuilder->getShortDate($tmpdate); ?>
								</td>
							<?php 
									$incomingTotals[$tmpdate] = 0;
									$projectedIncomingTotals[$tmpdate] = 0;
									$projectedOutgoingTotals[$tmpdate] = 0;
									$outgoingTotals[$tmpdate] = 0;
									$totals[$tmpdate] = 0;
									
									$noOfDays++;
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>
						</tr>
						<tr>
							<td colspan="<?php echo ($noOfDays+1); ?>" style="background-color:#FFFFFF" >
								Incomings
								<a href="#"  onclick="toggleRows('incomingRows','expand');">
									[  Expand(+) ]
								</a>								 
								<a href="#"  onclick="toggleRows('incomingRows','collapse');">
									[  Collapse(-)  ]
								</a>
								 
							</td>
						</tr>
						<?php
							foreach($incomingHeads as $accheadid=>$head){
						?>
								<tr height="25px" name ="incomingRows">
									<td>
										<?php echo $head; ?>
									</td>
									<?php 
										$tmpdate = $fromdate;
										while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
											$incomingList = $incomingsList[$tmpdate];
											$projectedIncomingList = $projectedIncomingsList[$tmpdate];
									?>
										<td align="right" width="70px">
											<?php 
												$incomingVO = null;
											if(isset($incomingList[$accheadid])){
													$incomingVO = $incomingList[$accheadid];
												}else{
													$incomingVO = null;
												}
												
												if($incomingVO == null){
													echo "0.00";
												}else{
													$pg = $incomingVO->getPg();
													$lpg = $incomingVO->getLpg();
													$silver = $incomingVO->getSilver();
													$cash = $incomingVO->getCash();
													$totalCash = $pg+$lpg+$silver+$cash;
													
													$incomingTotals[$tmpdate] = $incomingTotals[$tmpdate] + $totalCash;
													echo number_format($totalCash,2);
												}
											?>
											<?php 
												$projectionVO = null;
												if(isset($projectedIncomingList[$accheadid])){
													$projectionVO = $projectedIncomingList[$accheadid];
												}else{
													$projectionVO = null;
												}
												
												if($projectionVO == null){
//													echo "0.00";
												}else{
													$projectedIncomingPg = $projectionVO->getPg();
													$projectedIncomingLpg = $projectionVO->getLpg();
													$projectedIncomingSilver = $projectionVO->getSilver();
													$projectedIncomingCash = $projectionVO->getCash();
													$projectedIncomingTotalCash = $projectedIncomingPg+$projectedIncomingLpg+$projectedIncomingSilver+$projectedIncomingCash;
													
													$projectedIncomingTotals[$tmpdate] = $projectedIncomingTotals[$tmpdate] + $projectedIncomingTotalCash;
//													echo number_format($projectedIncomingTotalCash,2);
												}
											?>
										</td>
									<?php
											$tmpdate = $xmlBuilder->getNextDate($tmpdate);
										}
									?>
								</tr>
						<?php 
							}
						?>
						<tr class="highlighted-row2" height="30px">
							<td>
								Total (+)
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
									<td align="right">
										<?php echo number_format($incomingTotals[$tmpdate],2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						<tr class="highlighted-row2" height="30px">
							<td>
								Projected Total (+)
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
									<td align="right">
										<?php echo number_format($projectedIncomingTotals[$tmpdate],2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						<tr class="highlighted-row2" height="30px">
							<td>
								Surplus/Deficit 
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
									$incomingDifference = $incomingTotals[$tmpdate] - $projectedIncomingTotals[$tmpdate];
							?>
									<td align="right">
										<?php echo number_format($incomingDifference,2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						
						<tr>
							<td colspan="<?php echo ($noOfDays+1); ?>" style="background-color:#FFFFFF">
								Outgoings
								<a href="#"  onclick="toggleRows('outgoingRows','expand');">
									[  Expand(+)  ]
								</a>								 
								<a href="#"  onclick="toggleRows('outgoingRows','collapse');">
									[  Collapse(-)  ]
								</a>
							</td>
						</tr>
						<?php
							foreach($outgoingHeads as $accheadid=>$head){
						?>
								<tr height="25px" name ="outgoingRows">
									<td>
										<?php echo $head; ?>
									</td>
									<?php 
										$tmpdate = $fromdate;
										while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
											$outgoingList = $outgoingsList[$tmpdate];
											$projectedOutgoingList = $projectedOutgoingsList[$tmpdate];
									?>
										<td align="right" width="70px">
											<?php 
												$outgoingVO = null;
												if(isset($outgoingList[$accheadid])){
													$outgoingVO = $outgoingList[$accheadid];
												}else{
													$outgoingVO = null;
												}
												
												if($outgoingVO == null){
													echo "0.00";
												}else{
													$pg = $outgoingVO->getPg();
													$lpg = $outgoingVO->getLpg();
													$silver = $outgoingVO->getSilver();
													$cash = $outgoingVO->getCash();
													$totalCash = $pg+$lpg+$silver+$cash;
													
													$outgoingTotals[$tmpdate] = $outgoingTotals[$tmpdate] + $totalCash;
													echo number_format($totalCash,2);
												}
											?>
											<?php 
												$projectionVO = null;
												if(isset($projectedOutgoingList[$accheadid])){
													$projectionVO = $projectedOutgoingList[$accheadid];
												}else{
													$projectionVO = null;
												}
												
												if($projectionVO == null){
//													echo "0.00";
												}else{
													$projectedOutgoingPg = $projectionVO->getPg();
													$projectedOutgoingLpg = $projectionVO->getLpg();
													$projectedOutgoingSilver = $projectionVO->getSilver();
													$projectedOutgoingCash = $projectionVO->getCash();
													$projectedOutgoingTotalCash = $projectedOutgoingPg+$projectedOutgoingLpg+$projectedOutgoingSilver+$projectedOutgoingCash;
													
													$projectedOutgoingTotals[$tmpdate] = $projectedOutgoingTotals[$tmpdate] + $projectedOutgoingTotalCash;
//													echo number_format($projectedIncomingTotalCash,2);
												}
											?>
										</td>
									<?php
											$tmpdate = $xmlBuilder->getNextDate($tmpdate);
										}
									?>
								</tr>
						<?php 
							}
						?>
						<tr name="outgoingRows">
							<td>
								Vendor Payments
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
									$vendorPaymentVO = $vendorPaymentsList[$tmpdate];
							?>
								<td align="right" width="70px">
									<?php 
										if($vendorPaymentVO == null){
											echo "0.00";
										}else{
											$pg = $vendorPaymentVO->getPg();
											$lpg = $vendorPaymentVO->getLpg();
											$silver = $vendorPaymentVO->getSilver();
											$cash = $vendorPaymentVO->getCash();
											$totalCash = $pg+$lpg+$silver+$cash;
											
											$outgoingTotals[$tmpdate] = $outgoingTotals[$tmpdate] + $totalCash;
											echo number_format($totalCash,2);
										}
									?>
								</td>
							<?php
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>
						</tr>
						<tr class="highlighted-row2" height="30px">
							<td>
								Total (-)
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
									<td align="right">
										<?php echo number_format($outgoingTotals[$tmpdate],2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						<tr class="highlighted-row2" height="30px">
							<td>
								Projected Total (-)
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
									<td align="right">
										<?php echo number_format($projectedOutgoingTotals[$tmpdate],2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						<tr class="highlighted-row2" height="30px">
							<td>
								Surplus/Deficit
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
									$outgoingDifference = $outgoingTotals[$tmpdate] - $projectedOutgoingTotals[$tmpdate];
							?>
									<td align="right">
										<?php echo number_format($outgoingDifference,2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						<tr class="highlighted-row1" height="30px">
							<td>
								Grand Total
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
									<td align="right">
										<?php 
											$tmp = $incomingTotals[$tmpdate] - $outgoingTotals[$tmpdate];
											echo number_format($tmp,2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						<tr class="highlighted-row1" height="30px">
							<td>
								Projected Grand Total
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
									<td align="right">
										<?php 
											$tmp = $projectedIncomingTotals[$tmpdate] - $projectedOutgoingTotals[$tmpdate];
											echo number_format($tmp,2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
						<tr class="highlighted-row1" height="30px">
							<td>
								Surplus/Deficit
							</td>
							<?php 
								$tmpdate = $fromdate;
								while($xmlBuilder->compareDates($tmpdate,$todate) <= 0){
							?>
									<td align="right">
										<?php 
											$projectedTotal = $projectedIncomingTotals[$tmpdate] - $projectedOutgoingTotals[$tmpdate];
											$total = $incomingTotals[$tmpdate] - $outgoingTotals[$tmpdate];
											$tmp = $total - $projectedTotal ;
											echo number_format($tmp,2); ?>
									</td>
							<?php 
									$tmpdate = $xmlBuilder->getNextDate($tmpdate);
								}
							?>		
						</tr>
				</table>
			<?php 
				}
			?>
		</div>
										
    </body>
</html>
