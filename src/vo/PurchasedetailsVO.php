<?php
	class PurchasedetailsVO {

		private $txnId;
		private $purchasedetailsId;
		private $groupId;
		private $itemId;
		private $subitemId;
		private $gwt;
		private $nwt;
		private $ctpure;
		private $maintainMetalAs;
		private $maintainMetalValue;
		private $mc;
		private $maintainMcAs;
		private $maintainMcValue;
		private $paymentDays;
		private $lastPaymentDate;

		public function getPurchasedetailsId(){
			return $this->purchasedetailsId;
		}

		public function setPurchasedetailsId($purchasedetailsId){
			$this->purchasedetailsId = $purchasedetailsId;
		}
		public function getTxnId(){
			return $this->txnId;
		}

		public function setTxnId($txnId){
			$this->txnId = $txnId;
		}

		public function getGroupId(){
			return $this->groupId;
		}

		public function setGroupId($groupId){
			$this->groupId = $groupId;
		}

		public function getItemId(){
			return $this->itemId;
		}

		public function setItemId($itemId){
			$this->itemId = $itemId;
		}

		public function getSubitemId(){
			return $this->subitemId;
		}

		public function setSubitemId($subitemId){
			$this->subitemId = $subitemId;
		}

		public function getGwt(){
			return $this->gwt;
		}

		public function setGwt($gwt){
			$this->gwt = $gwt;
		}

		public function getNwt(){
			return $this->nwt;
		}

		public function setNwt($nwt){
			$this->nwt = $nwt;
		}

		public function getCtpure(){
			return $this->ctpure;
		}

		public function setCtpure($ctpure){
			$this->ctpure = $ctpure;
		}

		public function getMaintainMetalAs(){
			return $this->maintainMetalAs;
		}

		public function setMaintainMetalAs($maintainMetalAs){
			$this->maintainMetalAs = $maintainMetalAs;
		}

		public function getMaintainMetalValue(){
			return $this->maintainMetalValue;
		}

		public function setMaintainMetalValue($maintainMetalValue){
			$this->maintainMetalValue = $maintainMetalValue;
		}

		public function getMc(){
			return $this->mc;
		}

		public function setMc($mc){
			$this->mc = $mc;
		}

		public function getMaintainMcAs(){
			return $this->maintainMcAs;
		}

		public function setMaintainMcAs($maintainMcAs){
			$this->maintainMcAs = $maintainMcAs;
		}

		public function getMaintainMcValue(){
			return $this->maintainMcValue;
		}

		public function setMaintainMcValue($maintainMcValue){
			$this->maintainMcValue = $maintainMcValue;
		}

		public function getPaymentDays(){
			return $this->paymentDays;
		}

		public function setPaymentDays($paymentDays){
			$this->paymentDays = $paymentDays;
		}
		public function getLastPaymentDate(){
			return $this->lastPaymentDate;
		}

		public function setLastPaymentDate($lastPaymentDate){
			$this->lastPaymentDate = $lastPaymentDate;
		}

		public function toString(){
			$str = "";

			$str = $str . 'txnId -> ' . $this->txnId;
			$str = $str . 'groupId -> ' . $this->groupId;
			$str = $str . 'itemId -> ' . $this->itemId;
			$str = $str . 'subitemId -> ' . $this->subitemId;
			$str = $str . 'gwt -> ' . $this->gwt;
			$str = $str . 'nwt -> ' . $this->nwt;
			$str = $str . 'ctpure -> ' . $this->ctpure;
			$str = $str . 'maintainMetalAs -> ' . $this->maintainMetalAs;
			$str = $str . 'maintainMetalValue -> ' . $this->maintainMetalValue;
			$str = $str . 'mc -> ' . $this->mc;
			$str = $str . 'maintainMcAs -> ' . $this->maintainMcAs;
			$str = $str . 'maintainMcValue -> ' . $this->maintainMcValue;
			$str = $str . 'paymentDays -> ' . $this->paymentDays;
			echo $str;
		}

	}
?>