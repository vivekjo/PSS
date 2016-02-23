<?php
	class EmployeeVO {

		private $employeeId;
		private $employeeName;

		public function getEmployeeId(){
			return $this->employeeId;
		}

		public function setEmployeeId($employeeId){
			$this->employeeId = $employeeId;
		}

		public function getEmployeeName(){
			return $this->employeeName;
		}

		public function setEmployeeName($employeeName){
			$this->employeeName = $employeeName;
		}

		public function toString(){
			$str = "";

			$str = $str . 'employeeId -> ' . $this->employeeId;
			$str = $str . 'employeeName -> ' . $this->employeeName;
			echo $str;
		}

	}
?>