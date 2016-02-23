<?php
	class SuspensedetailsVO {

		private $suspensedetailsId;
		private $suspenseId;
		private $groupId;
		private $itemId;
		private $subitemId;
		private $pcs;
		private $type;
		private $gwt;
		private $nwt;
		private $ctpure;
		private $amount;
		private $stoneLoss;
		private $metalLoss;

		public function getSuspensedetailsId(){
			return $this->suspensedetailsId;
		}

		public function setSuspensedetailsId($suspensedetailsId){
			$this->suspensedetailsId = $suspensedetailsId;
		}

		public function getSuspenseId(){
			return $this->suspenseId;
		}

		public function setSuspenseId($suspenseId){
			$this->suspenseId = $suspenseId;
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

		public function getPcs(){
			return $this->pcs;
		}

		public function setPcs($pcs){
			$this->pcs = $pcs;
		}
		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
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

		public function getAmount(){
			return $this->amount;
		}

		public function setAmount($amount){
			$this->amount = $amount;
		}
		
		public function getStoneLoss(){
			return $this->stoneLoss;
		}

		public function setStoneLoss($stoneLoss){
			$this->stoneLoss = $stoneLoss;
		}
		
		public function getMetalLoss(){
			return $this->metalLoss;
		}

		public function setMetalLoss($metalLoss){
			$this->metalLoss = $metalLoss;
		}

		public function toString(){
			$str = "";

			$str = $str . 'suspensedetailsId -> ' . $this->suspensedetailsId;
			$str = $str . 'suspenseId -> ' . $this->suspenseId;
			$str = $str . 'groupId -> ' . $this->groupId;
			$str = $str . 'itemId -> ' . $this->itemId;
			$str = $str . 'subitemId -> ' . $this->subitemId;
			$str = $str . 'pcs -> ' . $this->pcs;
			$str = $str . 'type -> ' . $this->type;
			$str = $str . 'gwt -> ' . $this->gwt;
			$str = $str . 'nwt -> ' . $this->nwt;
			$str = $str . 'ctpure -> ' . $this->ctpure;
			$str = $str . 'amount -> ' . $this->amount;
			echo $str;
		}

	}
?>