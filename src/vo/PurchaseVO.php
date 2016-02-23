<?php
	class PurchaseVO {

		private $txnId;
		private $date;
		private $supplierId;
		private $billno;
		private $purchaseDetailsList;
			
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

		public function getBillno(){
			return $this->billno;
		}

		public function setBillno($billno){
			$this->billno = $billno;
		}
		
		public function getPurchaseDetailsList(){
			return $this->purchaseDetailsList;
		}

		public function setPurchaseDetailsList($purchaseDetailsList){
			$this->purchaseDetailsList = $purchaseDetailsList;
		}
		public function toString(){
			$str = "";

			$str = $str . 'txnId -> ' . $this->txnId;
			$str = $str . 'date -> ' . $this->date;
			$str = $str . 'supplierId -> ' . $this->supplierId;
			$str = $str . 'billno -> ' . $this->billno;
			echo $str;
		}

	}
?>