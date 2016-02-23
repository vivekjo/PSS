<?php
	class AccountheadVO {

		private $accheadId;
		private $accheadName;
		private $parentChannelId;

		public function getAccheadId(){
			return $this->accheadId;
		}

		public function setAccheadId($accheadId){
			$this->accheadId = $accheadId;
		}

		public function getAccheadName(){
			return $this->accheadName;
		}

		public function setAccheadName($accheadName){
			$this->accheadName = $accheadName;
		}

		public function getParentChannelId(){
			return $this->parentChannelId;
		}

		public function setParentChannelId($parentChannelId){
			$this->parentChannelId = $parentChannelId;
		}

		public function toString(){
			$str = "";

			$str = $str . 'accheadId -> ' . $this->accheadId;
			$str = $str . 'accheadName -> ' . $this->accheadName;
			$str = $str . 'parentChannelId -> ' . $this->parentChannelId;
			echo $str;
		}

	}
?>