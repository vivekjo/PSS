<?php
	class SupplierVO {

		private $supplierId;
		private $supplierName;
		private $opPg;
		private $opLpg;
		private $opSilver;
		private $opCash;
		private $clPg;
		private $clLpg;
		private $clSilver;
		private $clCash;

		public function getSupplierId(){
			return $this->supplierId;
		}

		public function setSupplierId($supplierId){
			$this->supplierId = $supplierId;
		}

		public function getSupplierName(){
			return $this->supplierName;
		}

		public function setSupplierName($supplierName){
			$this->supplierName = $supplierName;
		}

		public function getOpPg(){
			return $this->opPg;
		}

		public function setOpPg($opPg){
			$this->opPg = $opPg;
		}

		public function getOpLpg(){
			return $this->opLpg;
		}

		public function setOpLpg($opLpg){
			$this->opLpg = $opLpg;
		}

		public function getOpSilver(){
			return $this->opSilver;
		}

		public function setOpSilver($opSilver){
			$this->opSilver = $opSilver;
		}

		public function getOpCash(){
			return $this->opCash;
		}

		public function setOpCash($opCash){
			$this->opCash = $opCash;
		}

		public function getClPg(){
			return $this->clPg;
		}

		public function setClPg($clPg){
			$this->clPg = $clPg;
		}

		public function getClLpg(){
			return $this->clLpg;
		}

		public function setClLpg($clLpg){
			$this->clLpg = $clLpg;
		}

		public function getClSilver(){
			return $this->clSilver;
		}

		public function setClSilver($clSilver){
			$this->clSilver = $clSilver;
		}

		public function getClCash(){
			return $this->clCash;
		}

		public function setClCash($clCash){
			$this->clCash = $clCash;
		}

		public function toString(){
			$str = "";

			$str = $str . 'supplierId -> ' . $this->supplierId;
			$str = $str . 'supplierName -> ' . $this->supplierName;
			$str = $str . 'opPg -> ' . $this->opPg;
			$str = $str . 'opLpg -> ' . $this->opLpg;
			$str = $str . 'opSilver -> ' . $this->opSilver;
			$str = $str . 'opCash -> ' . $this->opCash;
			$str = $str . 'clPg -> ' . $this->clPg;
			$str = $str . 'clLpg -> ' . $this->clLpg;
			$str = $str . 'clSilver -> ' . $this->clSilver;
			$str = $str . 'clCash -> ' . $this->clCash;
			echo $str;
		}

	}
?>