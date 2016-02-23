<?php
	class PaymentVO {

		private $txnId;
		private $date;
		private $supplierId;
		private $voucherNo;
		private $paymentMode;
		private $amount;
		private $adjustWith;
		private $adjustAmount;
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

		public function getVoucherNo(){
			return $this->voucherNo;
		}

		public function setVoucherNo($voucherNo){
			$this->voucherNo = $voucherNo;
		}

		public function getPaymentMode(){
			return $this->paymentMode;
		}

		public function setPaymentMode($paymentMode){
			$this->paymentMode = $paymentMode;
		}

		public function getAmount(){
			return $this->amount;
		}

		public function setAmount($amount){
			$this->amount = $amount;
		}

		public function getAdjustWith(){
			return $this->adjustWith;
		}

		public function setAdjustWith($adjustWith){
			$this->adjustWith = $adjustWith;
		}

		public function getAdjustAmount(){
			return $this->adjustAmount;
		}

		public function setAdjustAmount($adjustAmount){
			$this->adjustAmount = $adjustAmount;
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
			$str = $str . 'voucherNo -> ' . $this->voucherNo;
			$str = $str . 'paymentMode -> ' . $this->paymentMode;
			$str = $str . 'amount -> ' . $this->amount;
			$str = $str . 'adjustWith -> ' . $this->adjustWith;
			$str = $str . 'adjustAmount -> ' . $this->adjustAmount;
			$str = $str . 'description -> ' . $this->description;
			echo $str;
		}

	}
?>