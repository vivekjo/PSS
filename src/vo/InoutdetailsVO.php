<?php
	class InoutdetailsVO {

		private $inoutdetailsId;
		private $inoutId;
		private $groupId;
		private $itemId;
		private $subitemId;
		private $pcs;
		private $gwt;
		private $nwt;
		private $ctpure;
		private $amount;

		public function getInoutdetailsId(){
			return $this->inoutdetailsId;
		}

		public function setInoutdetailsId($inoutdetailsId){
			$this->inoutdetailsId = $inoutdetailsId;
		}

		public function getInoutId(){
			return $this->inoutId;
		}

		public function setInoutId($inoutId){
			$this->inoutId = $inoutId;
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

		public function toString(){
			$str = "";

			$str = $str . 'inoutdetailsId -> ' . $this->inoutdetailsId;
			$str = $str . 'inoutId -> ' . $this->inoutId;
			$str = $str . 'groupId -> ' . $this->groupId;
			$str = $str . 'itemId -> ' . $this->itemId;
			$str = $str . 'subitemId -> ' . $this->subitemId;
			$str = $str . 'pcs -> ' . $this->pcs;
			$str = $str . 'gwt -> ' . $this->gwt;
			$str = $str . 'nwt -> ' . $this->nwt;
			$str = $str . 'ctpure -> ' . $this->ctpure;
			$str = $str . 'amount -> ' . $this->amount;
			echo $str;
		}

	}
?>