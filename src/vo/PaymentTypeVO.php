<?php
	class PaymentTypeVO{
		private $pg = 0;
		private $lpg = 0;
		private $silver = 0;
		private $cash = 0;
		
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
		
	public function toString(){
			$str = "";

			$str = $str . 'Pg -> ' . $this->pg;
			$str = $str . 'Lpg -> ' . $this->lpg;
			$str = $str . 'Silver -> ' . $this->silver;
			$str = $str . 'Cash -> ' . $this->cash;
			echo $str;
		}
	}
?>