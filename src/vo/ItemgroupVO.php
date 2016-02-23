<?php
	class ItemgroupVO {

		private $groupId;
		private $groupName;

		public function getGroupId(){
			return $this->groupId;
		}

		public function setGroupId($groupId){
			$this->groupId = $groupId;
		}

		public function getGroupName(){
			return $this->groupName;
		}

		public function setGroupName($groupName){
			$this->groupName = $groupName;
		}

		public function toString(){
			$str = "";

			$str = $str . 'groupId -> ' . $this->groupId;
			$str = $str . 'groupName -> ' . $this->groupName;
			echo $str;
		}

	}
?>