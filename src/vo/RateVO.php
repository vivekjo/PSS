<?php
	class RateVO {

		private $rateId;
		private $metal;
		private $rate;

		public function getRateId(){
			return $this->rateId;
		}

		public function setRateId($rateId){
			$this->rateId = $rateId;
		}

		public function getMetal(){
			return $this->metal;
		}

		public function setMetal($metal){
			$this->metal = $metal;
		}

		public function getRate(){
			return $this->rate;
		}

		public function setRate($rate){
			$this->rate = $rate;
		}

		public function toString(){
			$str = "";

			$str = $str . 'rateId -> ' . $this->rateId;
			$str = $str . 'metal -> ' . $this->metal;
			$str = $str . 'rate -> ' . $this->rate;
			echo $str;
		}

	}
?>