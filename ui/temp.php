							<?php  
								$paymentsList = null;	
								if(isset($_SESSION['paymentsList'])){
									$paymentsList = $_SESSION['paymentsList'];
										foreach($paymentsList as $paymentVO){
							?>
											<tr>
												<td align="right"><?php echo $count;?></td>
												<td align="center" id="<?php echo 'date' . $count ?>"><?php echo $paymentVO->getDate();?></td>
												<td align="center"><?php echo $paymentVO->getVoucherNo();?></td>
												<td align="center"><?php echo 'Payment';?></td>
												<td align="center"><?php echo $paymentVO->getPaymentMode();?></td>
												<td align="right"><?php echo number_format($paymentVO->getAmount(),3);?></td>
												<?php 
													if($paymentVO->getAdjustWith() == "pg"){
														$pg = $pg - $paymentVO->getAdjustAmount();
												?>
													<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),3);?></td>
												<?php }else{?>
													<td align="right"></td>
												<?php }?>
												
												<?php 
													if($paymentVO->getAdjustWith() == "lpg"){
														$lpg = $lpg - $paymentVO->getAdjustAmount();
												?>
													<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),3);?></td>
												<?php }else{?>
													<td align="right"></td>
												<?php }?>
												
												<?php 
													if($paymentVO->getAdjustWith() == "silver"){
														$silver = $silver - $paymentVO->getAdjustAmount();
												?>
													<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),3);?></td>
												<?php }else{?>
													<td align="right"></td>
												<?php }?>
												
												<?php 
													if($paymentVO->getAdjustWith() == "cash"){
														$cash = $cash - $paymentVO->getAdjustAmount();
												?>
													<td align="right"><?php echo number_format($paymentVO->getAdjustAmount(),2);?></td>
												<?php }else{?>
													<td align="right"></td>
												<?php }?>
												
												<td align="right"></td>
												<td align="right"></td>
												<td align="right"></td>
												<td align="right"></td>
												
												<td align="right"><?php echo number_format($pg,3)?></td>
												<td align="right"><?php echo number_format($lpg,3)?></td>
												<td align="right"><?php echo number_format($silver,3)?></td>
												<td align="right"><?php echo number_format($cash,2)?></td>
												
											</tr>
							<?php
										$count++;
										}
								}
							?>
							<?php  
								$purchasesList = null;	
								$purchaseDetailsVO = null;	
								if(isset($_SESSION['purchasesList'])){
									$purchasesList = $_SESSION['purchasesList'];
										foreach($purchasesList as $purchaseVO){
											$purchaseDetailsList = $purchaseVO->getPurchaseDetailsList();
											foreach($purchaseDetailsList as $purchaseDetailsVO){
							?>
												<tr>
													<td align="right"><?php echo $count;?></td>
													<td align="center" id="<?php echo 'date' . $count ?>"><?php echo $purchaseVO->getDate();?></td>
													<td align="center"><?php echo $purchaseVO->getBillNo();?></td>
													<td align="center"><?php echo 'Purchase';?></td>
													<td align="center"><?php echo 'PG';?></td>
													<td align="right"><?php echo number_format($purchaseDetailsVO->getCtPure(),3);?></td>						
													
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "pg"){
															$pg = $pg + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "lpg"){
															$lpg = $lpg + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "silver"){
															$silver = $silver + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMetalAs() == "cash"){
															$cash = $cash + $purchaseDetailsVO->getMaintainMetalValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMetalValue(),2);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													
													
													<td align="right"><?php echo number_format($pg,3)?></td>
													<td align="right"><?php echo number_format($lpg,3)?></td>
													<td align="right"><?php echo number_format($silver,3)?></td>
													<td align="right"><?php echo number_format($cash,2)?></td>
												</tr>
												
												<?php $count++;?>
												<tr>
													<td align="right"><?php echo $count;?></td>
													<td align="center" id="<?php echo 'date' . $count ?>"><?php echo $purchaseVO->getDate();?></td>
													<td align="center"><?php echo $purchaseVO->getBillNo();?></td>
													<td align="center"><?php echo 'Purchase';?></td>
													<td align="center"><?php echo 'Cash';?></td>
													<td align="right"><?php echo number_format($purchaseDetailsVO->getMc(),3);?></td>						
													
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													<td align="right"></td>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "pg"){
															$pg = $pg + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "lpg"){
															$lpg = $lpg + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "silver"){
															$silver = $silver + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),3);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													<?php 
														if($purchaseDetailsVO->getMaintainMcAs() == "cash"){
															$cash = $cash + $purchaseDetailsVO->getMaintainMcValue();
													?>
														<td align="right"><?php echo number_format($purchaseDetailsVO->getMaintainMcValue(),2);?></td>
													<?php }else{?>
														<td align="right"></td>
													<?php }?>
													
													
													
													<td align="right"><?php echo number_format($pg,3)?></td>
													<td align="right"><?php echo number_format($lpg,3)?></td>
													<td align="right"><?php echo number_format($silver,3)?></td>
													<td align="right"><?php echo number_format($cash,2)?></td>
												</tr>
							<?php
										$count++;
										}
										}
								}
							?>