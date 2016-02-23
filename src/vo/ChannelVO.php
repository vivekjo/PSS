<?php
	class ChannelVO {

		private $channelId;
		private $channelName;
		private $channelType;

		public function getChannelId(){
			return $this->channelId;
		}

		public function setChannelId($channelId){
			$this->channelId = $channelId;
		}

		public function getChannelName(){
			return $this->channelName;
		}

		public function setChannelName($channelName){
			$this->channelName = $channelName;
		}

		public function getChannelType(){
			return $this->channelType;
		}

		public function setChannelType($channelType){
			$this->channelType = $channelType;
		}

		public function toString(){
			$str = "";

			$str = $str . 'channelId -> ' . $this->channelId;
			$str = $str . 'channelName -> ' . $this->channelName;
			$str = $str . 'channelType -> ' . $this->channelType;
			echo $str;
		}

	}
?>