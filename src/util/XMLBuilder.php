<?php
	class XMLBuilder{
		
		function getLocationVOAsXML($locationVO){
			$XMLContent="";
			$root = "LOCATIONINFO";
			$innerTag = "location";
		
			$XMLContent = $XMLContent . ($this->encloseTag($locationVO->getLocationId() , "locationid"));
			$XMLContent = $XMLContent . ($this->encloseTag($locationVO->getLocationName() , "locationname"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getLocationsListAsXML($locationList){
			$XMLContent="";
			$root = "LOCATIONINFO";
			$innerTag = "location";
		
			if($locationList != null){
		
				foreach($locationList as$locationVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($locationVO->getLocationId() , "locationid"));
					$XMLContent = $XMLContent . ($this->encloseTag($locationVO->getLocationName() , "locationname"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getEmployeeVOAsXML($employeeVO){
			$XMLContent="";
			$root = "EMPLOYEEINFO";
			$innerTag = "employee";
		
			$XMLContent = $XMLContent . ($this->encloseTag($employeeVO->getEmployeeId() , "employeeid"));
			$XMLContent = $XMLContent . ($this->encloseTag($employeeVO->getEmployeeName() , "employeename"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getEmployeesListAsXML($employeeList){
			$XMLContent="";
			$root = "EMPLOYEEINFO";
			$innerTag = "employee";
		
			if($employeeList != null){
		
				foreach($employeeList as$employeeVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($employeeVO->getEmployeeId() , "employeeid"));
					$XMLContent = $XMLContent . ($this->encloseTag($employeeVO->getEmployeeName() , "employeename"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}
		
		function getItemgroupVOAsXML($itemgroupVO){
			$XMLContent="";
			$root = "ITEMGROUPINFO";
			$innerTag = "itemgroup";
		
			$XMLContent = $XMLContent . ($this->encloseTag($itemgroupVO->getGroupId() , "groupid"));
			$XMLContent = $XMLContent . ($this->encloseTag($itemgroupVO->getGroupName() , "groupname"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getItemgroupListAsXML($itemgroupList){
			$XMLContent="";
			$root = "ITEMGROUPINFO";
			$innerTag = "itemgroup";
			if($itemgroupList != null){
				foreach($itemgroupList as$itemgroupVO){
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($itemgroupVO->getGroupId() , "groupid"));
					$XMLContent = $XMLContent . ($this->encloseTag($itemgroupVO->getGroupName() , "groupname"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
			return $XMLContent;
		}	
		
		function getItemVOAsXML($itemVO){
			$XMLContent="";
			$root = "ITEMINFO";
			$innerTag = "item";
		
			$XMLContent = $XMLContent . ($this->encloseTag($itemVO->getItemId() , "itemid"));
			$XMLContent = $XMLContent . ($this->encloseTag($itemVO->getItemName() , "itemname"));
			$XMLContent = $XMLContent . ($this->encloseTag($itemVO->getParentGroupId() , "parentgroupid"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}
		
		function getItemListAsXML($itemList){
			$XMLContent="";
			$root = "ITEMINFO";
			$innerTag = "item";
		
			if($itemList != null){
				foreach($itemList as$itemVO){
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($itemVO->getItemId() , "itemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($itemVO->getItemName() , "itemname"));
					$XMLContent = $XMLContent . ($this->encloseTag($itemVO->getParentGroupId() , "parentgroupid"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
			return $XMLContent;
		}
		
		function getSubitemVOAsXML($subitemVO){
			$XMLContent="";
			$root = "SUBITEMINFO";
			$innerTag = "subitem";
		
			$XMLContent = $XMLContent . ($this->encloseTag($subitemVO->getSubitemId() , "subitemid"));
			$XMLContent = $XMLContent . ($this->encloseTag($subitemVO->getSubitemName() , "subitemname"));
			$XMLContent = $XMLContent . ($this->encloseTag($subitemVO->getParentItemId() , "parentitemid"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getSubitemListAsXML($subitemList){
			$XMLContent="";
			$root = "SUBITEMINFO";
			$innerTag = "subitem";
		
			if($subitemList != null){
				foreach($subitemList as$subitemVO){
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($subitemVO->getSubitemId() , "subitemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($subitemVO->getSubitemName() , "subitemname"));
					$XMLContent = $XMLContent . ($this->encloseTag($subitemVO->getParentItemId() , "parentitemid"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
			return $XMLContent;
		}
		
		function getSupplierVOAsXML($supplierVO){
			$XMLContent="";
			$root = "SUPPLIERINFO";
			$innerTag = "supplier";
		
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getSupplierId() , "supplierid"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getSupplierName() , "suppliername"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpPg() , "oppg"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpLpg() , "oplpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpSilver() , "opsilver"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpCash() , "opcash"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClPg() , "clpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClLpg() , "cllpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClSilver() , "clsilver"));
			$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClCash() , "clcash"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getSuppliersListAsXML($supplierList){
			$XMLContent="";
			$root = "SUPPLIERINFO";
			$innerTag = "supplier";
		
			if($supplierList != null){
		
				foreach($supplierList as$supplierVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getSupplierId() , "supplierid"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getSupplierName() , "suppliername"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpPg() , "oppg"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpLpg() , "oplpg"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpSilver() , "opsilver"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getOpCash() , "opcash"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClPg() , "clpg"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClLpg() , "cllpg"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClSilver() , "clsilver"));
					$XMLContent = $XMLContent . ($this->encloseTag($supplierVO->getClCash() , "clcash"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getRateVOAsXML($rateVO){
			$XMLContent="";
			$root = "RATEINFO";
			$innerTag = "rates";
		
			$XMLContent = $XMLContent . ($this->encloseTag($rateVO->getRateId() , "rateid"));
			$XMLContent = $XMLContent . ($this->encloseTag($rateVO->getMetal() , "metal"));
			$XMLContent = $XMLContent . ($this->encloseTag($rateVO->getRate() , "rate"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		function getRatesListAsXML($rateList){
			$XMLContent="";
			$root = "RATEINFO";
			$innerTag = "rates";
		
			if($rateList != null){
		
				foreach($rateList as$rateVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($rateVO->getRateId() , "rateid"));
					$XMLContent = $XMLContent . ($this->encloseTag($rateVO->getMetal() , "metal"));
					$XMLContent = $XMLContent . ($this->encloseTag($rateVO->getRate() , "rate"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getChannelVOAsXML($channelVO){
			$XMLContent="";
			$root = "CHANNELINFO";
			$innerTag = "channel";
		
			$XMLContent = $XMLContent . ($this->encloseTag($channelVO->getChannelId() , "channelid"));
			$XMLContent = $XMLContent . ($this->encloseTag($channelVO->getChannelName() , "channelname"));
			$XMLContent = $XMLContent . ($this->encloseTag($channelVO->getChannelType() , "channeltype"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getChannelsListAsXML($channelList){
			$XMLContent="";
			$root = "CHANNELINFO";
			$innerTag = "channel";
		
			if($channelList != null){
		
				foreach($channelList as$channelVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($channelVO->getChannelId() , "channelid"));
					$XMLContent = $XMLContent . ($this->encloseTag($channelVO->getChannelName() , "channelname"));
					$XMLContent = $XMLContent . ($this->encloseTag($channelVO->getChannelType() , "channeltype"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getAccountheadVOAsXML($accountheadVO){
			$XMLContent="";
			$root = "ACCOUNTHEADINFO";
			$innerTag = "accounthead";
		
			$XMLContent = $XMLContent . ($this->encloseTag($accountheadVO->getAccheadId() , "accheadid"));
			$XMLContent = $XMLContent . ($this->encloseTag($accountheadVO->getAccheadName() , "accheadname"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		function getAccountheadsListAsXML($accountheadList){
			$XMLContent="";
			$root = "ACCOUNTHEADINFO";
			$innerTag = "accounthead";
		
			if($accountheadList != null){
		
				foreach($accountheadList as$accountheadVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($accountheadVO->getAccheadId() , "accheadid"));
					$XMLContent = $XMLContent . ($this->encloseTag($accountheadVO->getAccheadName() , "accheadname"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getCompanyVOAsXML($companyVO){
			$XMLContent="";
			$root = "COMPANYINFO";
			$innerTag = "company";
		
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getId() , "id"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getOpPg() , "oppg"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getOpLpg() , "oplpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getOpSilver() , "opsilver"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getOpCash() , "opcash"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getClPg() , "clpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getClLpg() , "cllpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getClSilver() , "clsilver"));
			$XMLContent = $XMLContent . ($this->encloseTag($companyVO->getClCash() , "clcash"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getDaybookVOAsXML($daybookVO){
			$XMLContent="";
			$root = "DAYBOOKINFO";
			$innerTag = "daybook";
		
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getTxnId() , "txnid"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getType() , "type"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getCategoryId() , "categoryid"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getAccheadId() , "accheadid"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getPg() , "pg"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getLpg() , "lpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getSilver() , "silver"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getCash() , "cash"));
			$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getDescription() , "description"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		function getAccountsListAsXML($daybookList,$root){
			$XMLContent="";
			$innerTag = "daybook";
		
			if($daybookList != null){
		
				foreach($daybookList as$daybookVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getTxnId() , "txnid"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getDate() , "date"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getType() , "type"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getCategoryId() , "categoryid"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getAccheadId() , "accheadid"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getPg() , "pg"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getLpg() , "lpg"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getSilver() , "silver"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getCash() , "cash"));
					$XMLContent = $XMLContent . ($this->encloseTag($daybookVO->getDescription() , "description"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getPaymentVOAsXML($paymentVO){
			$XMLContent="";
			$root = "PAYMENTINFO";
			$innerTag = "payment";
		
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getTxnId() , "txnid"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getSupplierId() , "supplierid"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getVoucherNo() , "voucherno"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getPaymentMode() , "paymentmode"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getAmount() , "amount"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getAdjustWith() , "adjustwith"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getAdjustAmount() , "adjustamount"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getDescription() , "description"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
	
		}
		
		function getPaymentListAsXML($paymentList){
			$XMLContent="";
			$root = "PAYMENTINFO";
			$innerTag = "payment";
		
			if($paymentList != null){
		
				foreach($paymentList as$paymentVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getTxnId() , "txnid"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getDate() , "date"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getSupplierId() , "supplierid"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getVoucherNo() , "voucherno"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getPaymentMode() , "paymentmode"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getAmount() , "amount"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getAdjustWith() , "adjustwith"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getAdjustAmount() , "adjustamount"));
					$XMLContent = $XMLContent . ($this->encloseTag($paymentVO->getDescription() , "description"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getTransferVOAsXML($transferVO){
			$XMLContent="";
			$root = "TRANSFERINFO";
			$innerTag = "transfer";
		
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getTxnId() , "txnid"));
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getSupplierId() , "supplierid"));
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getFromType() , "fromtype"));
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getFromAmount() , "fromamount"));
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getToType() , "totype"));
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getToAmount() , "toamount"));
			$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getDescription() , "description"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getTransfersListAsXML($transferList){
			$XMLContent="";
			$root = "TRANSFERINFO";
			$innerTag = "transfer";
		
			if($transferList != null){
		
				foreach($transferList as$transferVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getTxnId() , "txnid"));
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getDate() , "date"));
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getSupplierId() , "supplierid"));
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getFromType() , "fromtype"));
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getFromAmount() , "fromamount"));
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getToType() , "totype"));
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getToAmount() , "toamount"));
					$XMLContent = $XMLContent . ($this->encloseTag($transferVO->getDescription() , "description"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getPurchaseVOAsXML($purchaseVO){
			$XMLContent="";
			$root = "PURCHASEINFO";
			$innerTag = "purchase";
			$productsList = $purchaseVO->getPurchaseDetailsList();
			$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getTxnId() , "txnid"));
			$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getSupplierId() , "supplierid"));
			$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getBillno() , "billno"));
			
			foreach($productsList as $purchasedetailsVO){
				$XMLContent = $XMLContent . $this->addTagOpener("product".$purchaseVO->getTxnId());
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getPurchasedetailsId(), "purchasedetailsid"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getGroupId() , "groupid"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getItemId() , "itemid"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getSubitemId() , "subitemid"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getGwt() , "gwt"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getNwt() , "nwt"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getCtpure() , "ctpure"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMetalAs() , "maintainmetalas"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMetalValue() , "maintainmetalvalue"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMc() , "mc"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMcAs() , "maintainmcas"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMcValue() , "maintainmcvalue"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getPaymentDays() , "paymentdays"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getLastPaymentDate() , "lastpaymentdate"));
				$XMLContent = $XMLContent . $this->addTagCloser("product".$purchaseVO->getTxnId());
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
			return $XMLContent;
		}
		
	
		
		function getPurchaseListAsXML($purchaseList){
			$XMLContent="";
			$root = "PURCHASEINFO";
			$innerTag = "purchase";
			
			foreach($purchaseList as $purchaseVO){
				$XMLContent = $XMLContent . $this->addTagOpener($innerTag);
				
				$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getTxnId() , "txnid"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getDate() , "date"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getSupplierId() , "supplierid"));
				$XMLContent = $XMLContent . ($this->encloseTag($purchaseVO->getBillno() , "billno"));
				
				$productsList = $purchaseVO->getPurchaseDetailsList();
				foreach($productsList as $purchasedetailsVO){
					$XMLContent = $XMLContent . $this->addTagOpener("product".$purchaseVO->getTxnId());
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getGroupId() , "groupid"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getItemId() , "itemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getSubitemId() , "subitemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getGwt() , "gwt"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getNwt() , "nwt"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getCtpure() , "ctpure"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMetalAs() , "maintainmetalas"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMetalValue() , "maintainmetalvalue"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMc() , "mc"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMcAs() , "maintainmcas"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getMaintainMcValue() , "maintainmcvalue"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getPaymentDays() , "paymentdays"));
					$XMLContent = $XMLContent . ($this->encloseTag($purchasedetailsVO->getLastPaymentDate() , "lastpaymentdate"));
					$XMLContent = $XMLContent . $this->addTagCloser("product".$purchaseVO->getTxnId());
				}
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
			}
			
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}
		
		function getNewarrivalVOAsXML($newarrivalVO){
			$XMLContent="";
			$root = "NEWARRIVALINFO";
			$innerTag = "newarrival";
		
			$XMLContent = $XMLContent . ($this->encloseTag($newarrivalVO->getNewarrivalId() , "newarrivalId"));
			$XMLContent = $XMLContent . ($this->encloseTag($newarrivalVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($newarrivalVO->getSupplierId() , "supplierid"));
		
			$newarrivaldetailsList = $newarrivalVO->getNewArrivalDetailsList();
			
				foreach($newarrivaldetailsList as $newarrivaldetailsVO){
					$XMLContent = $XMLContent. $this->addTagOpener("product".$newarrivalVO->getNewarrivalId());
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getNewarrivalDetailsId() , "newarrivaldetailsid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getNewarrivalId() , "newarrivalid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getGroupId() , "groupid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getItemId() , "itemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getSubitemId() , "subitemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getGms() , "gms"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getPcs() , "pcs"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getSize() , "size"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getMc() , "mc"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getStone() , "stone"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getTotalAmount() , "totalamount"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getDueDate() , "duedate"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getNoOfDays() , "noofdays"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getDescription() , "description"));
					$XMLContent = $XMLContent. $this->addTagCloser("product".$newarrivalVO->getNewarrivalId());
				}
			$XMLContent = $this->encloseTag($XMLContent,$root);
			return $XMLContent;
		}	
		function getRequirementsVOAsXML($requirementsVO){
			$XMLContent="";
			$root = "requirementsINFO";
			$innerTag = "requirements";
			
			$XMLContent = $XMLContent . ($this->encloseTag($requirementsVO->getRequirementsId(), "requirementsId"));
			$XMLContent = $XMLContent . ($this->encloseTag($requirementsVO->getDate(), "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($requirementsVO->getEmployeeId(), "employeeid"));
		
			$requirementsdetailsList = $requirementsVO->getrequirementsDetailsList();
			
				foreach($requirementsdetailsList as $requirementsdetailsVO){
					$XMLContent = $XMLContent. $this->addTagOpener("product".$requirementsVO->getRequirementsId());
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getRequirementsDetailsId() , "Requirementsdetailsid"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getRequirementsId() , "Requirementsid"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getGroupId() , "groupid"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getItemId() , "itemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getSubitemId() , "subitemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getGms() , "gms"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getPcs() , "pcs"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getSize() , "size"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getMc() , "mc"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getStone() , "stone"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getTotalAmount() , "totalamount"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getDueDate() , "duedate"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getNoOfDays() , "noofdays"));
					$XMLContent = $XMLContent . ($this->encloseTag($requirementsdetailsVO->getDescription() , "description"));
					$XMLContent = $XMLContent. $this->addTagCloser("product".$requirementsVO->getRequirementsId());
				}
			$XMLContent = $this->encloseTag($XMLContent,$root);
			return $XMLContent;
		}	
		
		/*function getNewarrivalVOListAsXML($newarrivalVOList){
			$XMLContent="";
			$root = "NEWARRIVALINFO";
			$innerTag = "newarrival";
		
			foreach($newarrivalVOList as $newarrivalVO){	
				$XMLContent = $XMLContent . $this->addTagOpener($innerTag);		
				$XMLContent = $XMLContent . ($this->encloseTag($newarrivalVO->getNewarrivalId() , "newarrivalId"));
				$XMLContent = $XMLContent . ($this->encloseTag($newarrivalVO->getDate() , "date"));
				$XMLContent = $XMLContent . ($this->encloseTag($newarrivalVO->getSupplierId() , "supplierid"));
			
				$newarrivaldetailsList = $newarrivalVO->getNewArrivalDetailsList();
				foreach($newarrivaldetailsList as $newarrivaldetailsVO){
					$XMLContent = $XMLContent. $this->addTagOpener("product".$newarrivalVO->getNewarrivalId());
//					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getNewarrivalDetailsId() , "newarrivaldetailsid"));
//					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getNewarrivalId() , "newarrivalid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getGroupId() , "groupid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getItemId() , "itemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getSubitemId() , "subitemid"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getGms() , "gms"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getPcs() , "pcs"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getSize() , "size"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getMc() , "mc"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getStone() , "stone"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getTotalAmount() , "totalamount"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getDueDate() , "duedate"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getNoOfDays() , "noofdays"));
					$XMLContent = $XMLContent . ($this->encloseTag($newarrivaldetailsVO->getDescription() , "description"));
					$XMLContent = $XMLContent. $this->addTagCloser("product".$newarrivalVO->getNewarrivalId());
				}
				$XMLContent = $this->encloseTag($XMLContent,$root);
			}
			return $XMLContent;
		}	
*/
		function getOpeningAsXML($paymentTypeVO){
			$XMLContent="";
			$root = "opening";
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getPg() , "pg"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getLpg() , "lpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getSilver() , "silver"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getCash() , "cash"));
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}
		
		function getClosingAsXML($paymentTypeVO){
			$XMLContent="";
			$root = "closing";
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getPg() , "pg"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getLpg() , "lpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getSilver() , "silver"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getCash() , "cash"));
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}
		
		function getBalanceAsXML($paymentTypeVO){
			$XMLContent="";
			$root = "balance";
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getPg() , "pg"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getLpg() , "lpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getSilver() , "silver"));
			$XMLContent = $XMLContent . ($this->encloseTag($paymentTypeVO->getCash() , "cash"));
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}
		
		function getInoutVOAsXML($inoutentryVO){
			$XMLContent="";
			$root = "INOUTENTRYINFO";
			$innerTag = "inoutentry";
			$inoutdetailsList = $inoutentryVO->getInoutDetailsList();
			
			$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getInoutId() , "inoutid"));
			$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getIssuerId() , "issuerid"));
			$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getBearerId() , "bearerid"));
			$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getReceiverId() , "receiverid"));
			$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getLocationId() , "locationid"));
			$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getType() , "type"));
			
			foreach($inoutdetailsList as $inoutdetailsVO){
				$XMLContent = $XMLContent. $this->addTagOpener("inout" . $inoutentryVO->getInoutId());
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getInoutdetailsId() , "inoutdetailsid"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getInoutId() , "inoutid"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getGroupId() , "groupid"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getItemId() , "itemid"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getSubitemId() , "subitemid"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getPcs() , "pcs"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getGwt() , "gwt"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getNwt() , "nwt"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getCtpure() , "ctpure"));
				$XMLContent = $XMLContent . ($this->encloseTag($inoutdetailsVO->getAmount() , "amount"));
				$XMLContent = $XMLContent . $this->addTagCloser("inout" . $inoutentryVO->getInoutId());
			}
		
			//$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		
		function getInoutListAsXML($inoutentryList){
			$XMLContent="";
			$root = "INOUTENTRYINFO";
			$innerTag = "inoutentry";
		
			if($inoutentryList != null){
		
				foreach($inoutentryList as$inoutentryVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getInoutId() , "inoutid"));
					$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getDate() , "date"));
					$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getIssuerId() , "issuerid"));
					$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getBearerId() , "bearerid"));
					$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getReceiverId() , "receiverid"));
					$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getLocationId() , "locationid"));
					$XMLContent = $XMLContent . ($this->encloseTag($inoutentryVO->getType() , "type"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}

		function getSuspenseVOAsXML($suspenseentryVO){
			$XMLContent="";
			$root = "SUSPENSEENTRYINFO";
			$suspensedetailsList = $suspenseentryVO->getSuspenseDetailList();
			
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getSuspenseId() , "suspenseid"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getIssuerId() , "issuerid"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getBearerId() , "bearerid"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getReceiverId() , "receiverid"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getLocationId() , "locationid"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getType() , "type"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getMode() , "mode"));
			$XMLContent = $XMLContent . ($this->encloseTag($suspenseentryVO->getRefSuspenseId(), "refsuspenseid"));
			
			foreach($suspensedetailsList as $suspensedetailsVO){
				$XMLContent = $XMLContent. $this->addTagOpener("suspense" . $suspenseentryVO->getSuspenseId());
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getSuspensedetailsId() , "suspensedetailsid"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getSuspenseId() , "suspenseid"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getGroupId() , "groupid"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getItemId() , "itemid"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getSubitemId() , "subitemid"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getPcs() , "pcs"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getType() , "type"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getGwt() , "gwt"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getNwt() , "nwt"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getCtpure() , "ctpure"));
				$XMLContent = $XMLContent . ($this->encloseTag($suspensedetailsVO->getAmount() , "amount"));
				$XMLContent = $XMLContent . $this->addTagCloser("suspense" . $suspenseentryVO->getSuspenseId());
			}
		
			//$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		
		}
		
		function getProjectionVOAsXML($projectionVO){
			$XMLContent="";
			$root = "PROJECTIONINFO";
			$innerTag = "projection";
		
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getTxnId() , "txnid"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getDate() , "date"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getType() , "type"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getCategoryId() , "categoryid"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getAccheadId() , "accheadid"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getPg() , "pg"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getLpg() , "lpg"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getSilver() , "silver"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getCash() , "cash"));
			$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getDescription() , "description"));
		
			$XMLContent = $this->encloseTag($XMLContent,$innerTag);
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
	
		}
		
		function getProjectionListAsXML($projectionList){
			$XMLContent="";
			$root = "PROJECTIONINFO";
			$innerTag = "projection";
		
			if($projectionList != null){
		
				foreach($projectionList as$projectionVO){
		
					$XMLContent = $XMLContent. $this->addTagOpener($innerTag);
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getTxnId() , "txnid"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getDate() , "date"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getType() , "type"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getCategoryId() , "categoryid"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getAccheadId() , "accheadid"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getPg() , "pg"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getLpg() , "lpg"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getSilver() , "silver"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getCash() , "cash"));
					$XMLContent = $XMLContent . ($this->encloseTag($projectionVO->getDescription() , "description"));
				$XMLContent = $XMLContent . $this->addTagCloser($innerTag);
				}
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
		
			return $XMLContent;
		}
	
		function buildErrorXML($error){
			$XMLContent="";
			$XMLContent= $XMLContent . $this->encloseTag($error,"error");
			return $XMLContent;
		}
		
		function buildResponse($response){
			$XMLContent = "";
			$XMLContent = $XMLContent . $this->encloseTag($response,'response');
			return $XMLContent;
		}
		
		function addTagOpener($data){
			$data = "<" . $data . ">";
			return $data;
		}
		
		function addTagCloser($data){
			$data = "</" . $data . ">";
			return $data;
		}
		
		public function encloseTag($data,$tagname){
			$tag = "<" . $tagname . ">" . $data . "</" . $tagname . ">";
			return $tag;
		}
		
		function getFromDate($toDate){
			$date = new DateTime($toDate);
			date_sub($date, new DateInterval("P5D"));
			return $date->format("Y-m-d");
		}
		
		function getPrevDate($date){
			$date = new DateTime($date);
			date_sub($date, new DateInterval("P1D"));
			return $date->format("Y-m-d");
		}
		
		function getNextDate($date){
			$date = new DateTime($date);
			date_add($date, new DateInterval("P1D"));
			return $date->format("Y-m-d");
		}
		
		function getFormattedDate($date){
			$date = new DateTime($date);
			return $date->format("Y-m-d");
		}
		
		function getFormattedDateString($date,$format){
			$date = new DateTime($date);
			return $date->format($format);
		}
		
		function getShortDate($date){
			$date = new DateTime($date);
			$tmp = $date->format("d/m/Y");
			$tmp = substr($tmp,0,5);
			return $tmp;
		}
		
		function getDaysCount($from_date,$to_date){
			$number_of_days = $this->count_days(strtotime($from_date),strtotime($to_date)); 
		}
		
		function count_days( $a, $b ){
		    // First we need to break these dates into their constituent parts:
		    $gd_a = getdate( $a );
		    $gd_b = getdate( $b );
		    // Now recreate these timestamps, based upon noon on each day
		    // The specific time doesn't matter but it must be the same each day
		    $a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
		    $b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );
		    // Subtract these two numbers and divide by the number of seconds in a
		    // day. Round the result since crossing over a daylight savings time
		    // barrier will cause this time to be off by an hour or two.
		    return round( abs( $a_new - $b_new ) / 86400 );
		}
		 
		function getTodaysDate(){
			$date = new DateTime();
			return $date->format("Y-m-d");
		}
		
		function compareDates($strDate1,$strDate2){
			$result = 0;
			
			$date1 = strtotime($strDate1);
			$date2 = strtotime($strDate2);
			
			if($date1 == $date2){
				$result = 0;
			}else if($date1 > $date2){
				$result = 1;
			}else if($date1 < $date2){
				$result = -1;
			}
			
			return $result;
		}
		
		function arrayToXML($arr){
			$XMLContent="";
			$root = "BalanceSheet";
			foreach ($arr as $key1=>$value1){
				$XMLContent = $XMLContent . $this->addTagOpener($key1);				
				foreach ($value1 as $key2=>$value2){
					$XMLContent = $XMLContent . ($this->encloseTag(htmlspecialchars($key2),"ledger"));
					$XMLContent = $XMLContent . ($this->encloseTag($value2,"amount"));
				}
				$XMLContent = $XMLContent . $this->addTagCloser($key1);		
			}
			$XMLContent = $this->encloseTag($XMLContent,$root);
			return $XMLContent;
		}
	}
?>
