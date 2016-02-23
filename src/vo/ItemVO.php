<?php
	class ItemVO {

		private $itemId;
		private $itemName;
		private $parentGroupId;

		public function getItemId(){
			return $this->itemId;
		}

		public function setItemId($itemId){
			$this->itemId = $itemId;
		}

		public function getItemName(){
			return $this->itemName;
		}

		public function setItemName($itemName){
			$this->itemName = $itemName;
		}

		public function getParentGroupId(){
			return $this->parentGroupId;
		}

		public function setParentGroupId($parentGroupId){
			$this->parentGroupId = $parentGroupId;
		}

		public function toString(){
			$str = "";

			$str = $str . 'itemId -> ' . $this->itemId;
			$str = $str . 'itemName -> ' . $this->itemName;
			$str = $str . 'parentGroupId -> ' . $this->parentGroupId;
			echo $str;
		}

	}
?>