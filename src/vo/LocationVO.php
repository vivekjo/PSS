<?php
	class LocationVO {

		private $locationId;
		private $locationName;

		public function getLocationId(){
			return $this->locationId;
		}

		public function setLocationId($locationId){
			$this->locationId = $locationId;
		}

		public function getLocationName(){
			return $this->locationName;
		}

		public function setLocationName($locationName){
			$this->locationName = $locationName;
		}

		public function toString(){
			$str = "";

			$str = $str . 'locationId -> ' . $this->locationId;
			$str = $str . 'locationName -> ' . $this->locationName;
			echo $str;
		}

	}
?>