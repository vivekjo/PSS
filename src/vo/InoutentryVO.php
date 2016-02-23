<?php
	class InoutentryVO {

		private $inoutId;
		private $date;
		private $issuerId;
		private $bearerId;
		private $receiverId;
		private $locationId;
		private $type;
		private $inoutDetailsList;

		public function getInoutId(){
			return $this->inoutId;
		}

		public function setInoutId($inoutId){
			$this->inoutId = $inoutId;
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

		public function getInoutDetailsList(){
			return $this->inoutDetailsList;
		}

		public function setInoutDetailsList($inoutDetailsList){
			$this->inoutDetailsList = $inoutDetailsList;
		}
		public function toString(){
			$str = "";

			$str = $str . 'inoutId -> ' . $this->inoutId;
			$str = $str . 'date -> ' . $this->date;
			$str = $str . 'issuerId -> ' . $this->issuerId;
			$str = $str . 'bearerId -> ' . $this->bearerId;
			$str = $str . 'receiverId -> ' . $this->receiverId;
			$str = $str . 'locationId -> ' . $this->locationId;
			$str = $str . 'type -> ' . $this->type;
			echo $str;
		}

	}
?>