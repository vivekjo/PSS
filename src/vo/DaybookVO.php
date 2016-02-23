<?php
	class DaybookVO {

		private $txnId;
		private $date;
		private $type;
		private $categoryId;
		private $accheadId;
		private $pg;
		private $lpg;
		private $silver;
		private $cash;
		private $description;

		public function getTxnId(){
			return $this->txnId;
		}

		public function setTxnId($txnId){
			$this->txnId = $txnId;
		}

		public function getDate(){
			return $this->date;
		}

		public function setDate($date){
			$this->date = $date;
		}

		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}

		public function getCategoryId(){
			return $this->categoryId;
		}

		public function setCategoryId($categoryId){
			$this->categoryId = $categoryId;
		}

		public function getAccheadId(){
			return $this->accheadId;
		}

		public function setAccheadId($accheadId){
			$this->accheadId = $accheadId;
		}

		public function getPg(){
			return $this->pg;
		}

		public function setPg($pg){
			$this->pg = $pg;
		}

		public function getLpg(){
			return $this->lpg;
		}

		public function setLpg($lpg){
			$this->lpg = $lpg;
		}

		public function getSilver(){
			return $this->silver;
		}

		public function setSilver($silver){
			$this->silver = $silver;
		}

		public function getCash(){
			return $this->cash;
		}

		public function setCash($cash){
			$this->cash = $cash;
		}

		public function getDescription(){
			return $this->description;
		}

		public function setDescription($description){
			$this->description = $description;
		}

		public function toString(){
			$str = "";

			$str = $str . 'txnId -> ' . $this->txnId;
			$str = $str . 'date -> ' . $this->date;
			$str = $str . 'type -> ' . $this->type;
			$str = $str . 'categoryId -> ' . $this->categoryId;
			$str = $str . 'accheadId -> ' . $this->accheadId;
			$str = $str . 'pg -> ' . $this->pg;
			$str = $str . 'lpg -> ' . $this->lpg;
			$str = $str . 'silver -> ' . $this->silver;
			$str = $str . 'cash -> ' . $this->cash;
			$str = $str . 'description -> ' . $this->description;
			echo $str;
		}

	}
?>