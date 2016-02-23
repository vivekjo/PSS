<?php
	class SubitemVO {

		private $subitemId;
		private $subitemName;
		private $parentItemId;

		public function getSubitemId(){
			return $this->subitemId;
		}

		public function setSubitemId($subitemId){
			$this->subitemId = $subitemId;
		}

		public function getSubitemName(){
			return $this->subitemName;
		}

		public function setSubitemName($subitemName){
			$this->subitemName = $subitemName;
		}

		public function getParentItemId(){
			return $this->parentItemId;
		}

		public function setParentItemId($parentItemId){
			$this->parentItemId = $parentItemId;
		}

		public function toString(){
			$str = "";

			$str = $str . 'subitemId -> ' . $this->subitemId;
			$str = $str . 'subitemName -> ' . $this->subitemName;
			$str = $str . 'parentItemId -> ' . $this->parentItemId;
			echo $str;
		}

	}
?>