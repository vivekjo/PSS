<?php
	class SuspenseentryVO {

		private $suspenseId;
		private $date;
		private $issuerId;
		private $bearerId;
		private $receiverId;
		private $locationId;
		private $type;
		private $mode;
		private $refSuspenseId;
		private $suspenseDetailList;

		public function getSuspenseId(){
			return $this->suspenseId;
		}

		public function setSuspenseId($suspenseId){
			$this->suspenseId = $suspenseId;
		}

		public function getDate(){
			return $this->date;
		}

		public function setDate($date){
			$this->date = $date;
		}

		public function getIssuerId(){
			return $this->issuerId;
		}

		public function setIssuerId($issuerId){
			$this->issuerId = $issuerId;
		}

		public function getBearerId(){
			return $this->bearerId;
		}

		public function setBearerId($bearerId){
			$this->bearerId = $bearerId;
		}

		public function getReceiverId(){
			return $this->receiverId;
		}

		public function setReceiverId($receiverId){
			$this->receiverId = $receiverId;
		}

		public function getLocationId(){
			return $this->locationId;
		}

		public function setLocationId($locationId){
			$this->locationId = $locationId;
		}

		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}

		public function getMode(){
			return $this->mode;
		}

		public function setMode($mode){
			$this->mode = $mode;
		}

		public function getSuspenseDetailList(){
			return $this->suspenseDetailList;
		}

		public function setSuspenseDetailList($suspenseDetailList){
			$this->suspenseDetailList = $suspenseDetailList;
		}
		public function getRefSuspenseId(){
			return $this->refSuspenseId;
		}

		public function setRefSuspenseId($refSuspenseId){
			$this->refSuspenseId = $refSuspenseId;
		}

		public function toString(){
			$str = "";

			$str = $str . 'suspenseId -> ' . $this->suspenseId;
			$str = $str . 'date -> ' . $this->date;
			$str = $str . 'issuerId -> ' . $this->issuerId;
			$str = $str . 'bearerId -> ' . $this->bearerId;
			$str = $str . 'receiverId -> ' . $this->receiverId;
			$str = $str . 'locationId -> ' . $this->locationId;
			$str = $str . 'type -> ' . $this->type;
			$str = $str . 'mode -> ' . $this->mode;
			$str = $str . 'refSuspenseId -> ' . $this->refSuspenseId;
			echo $str;
		}
		

	}
?>