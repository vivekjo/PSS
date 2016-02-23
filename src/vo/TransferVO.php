<?php
	class TransferVO {

		private $txnId;
		private $date;
		private $supplierId;
		private $fromType;
		private $fromAmount;
		private $toType;
		private $toAmount;
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

		public function getSupplierId(){
			return $this->supplierId;
		}

		public function setSupplierId($supplierId){
			$this->supplierId = $supplierId;
		}

		public function getFromType(){
			return $this->fromType;
		}

		public function setFromType($fromType){
			$this->fromType = $fromType;
		}

		public function getFromAmount(){
			return $this->fromAmount;
		}

		public function setFromAmount($fromAmount){
			$this->fromAmount = $fromAmount;
		}

		public function getToType(){
			return $this->toType;
		}

		public function setToType($toType){
			$this->toType = $toType;
		}

		public function getToAmount(){
			return $this->toAmount;
		}

		public function setToAmount($toAmount){
			$this->toAmount = $toAmount;
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
			$str = $str . 'supplierId -> ' . $this->supplierId;
			$str = $str . 'fromType -> ' . $this->fromType;
			$str = $str . 'fromAmount -> ' . $this->fromAmount;
			$str = $str . 'toType -> ' . $this->toType;
			$str = $str . 'toAmount -> ' . $this->toAmount;
			$str = $str . 'description -> ' . $this->description;
			echo $str;
		}

	}
?>