<?php
	class UserVO {

		private $userId;
		private $username;
		private $password;
		private $usertype;

		public function getUserId(){
			return $this->userId;
		}

		public function setUserId($userId){
			$this->userId = $userId;
		}

		public function getUsername(){
			return $this->username;
		}

		public function setUsername($username){
			$this->username = $username;
		}

		public function getPassword(){
			return $this->password;
		}

		public function setPassword($password){
			$this->password = $password;
		}

		public function getUsertype(){
			return $this->usertype;
		}

		public function setUsertype($usertype){
			$this->usertype = $usertype;
		}

		public function toString(){
			$str = "";

			$str = $str . 'userId -> ' . $this->userId;
			$str = $str . 'username -> ' . $this->username;
			$str = $str . 'password -> ' . $this->password;
			$str = $str . 'usertype -> ' . $this->usertype;
			echo $str;
		}

	}
?>