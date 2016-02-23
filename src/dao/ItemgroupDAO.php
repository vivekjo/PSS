<?php
	
	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/ItemgroupVO.php';

	class ItemgroupDAO {

		function getAllGroups(){
			$groupList = new CU_Collection('ItemgroupVO'); 
			try{
				$itemgroupVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ALL_ITEMGROUPS)) {
					$stmt->execute();
					$stmt->bind_result($groupId,$groupName);
					while($stmt->fetch()){
						$itemgroupVO = new ItemgroupVO();
						$itemgroupVO->setGroupId($groupId);
						$itemgroupVO->setGroupName($groupName);
						$groupList->add($itemgroupVO);
					}
					$stmt->close();
				}else{
					throw new DBException("ItemGroupDAO :: getAllGroups :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $groupList;
		}
		
		function getItemgroupVO($groupId){
			try{
				$itemgroupVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ITEMGROUP_INFO)) {
					$stmt->execute();
					$stmt->bind_result($groupId,$groupName);
					if($stmt->fetch()){
	
						$itemgroupVO = new ItemgroupVO();
						$itemgroupVO->setGroupId($groupId);
						$itemgroupVO->setGroupName($groupName);
					}
					$stmt->close();
				}else{
					throw new DBException("ItemGroupDAO :: getItemgroupVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $itemgroupVO;
		}
	
		function addgroupVO($itemgroupVO){
			$result = 0;
			$isDuplicate = true;
			try{
				$groupName = $itemgroupVO->getGroupName();
				$isDuplicate = $this->doesGroupExists($groupName);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(ADD_ITEMGROUP_INFO)) {
						$stmt->bind_param('s',$groupName);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("ItemGroupDAO :: addgroupVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Group name already exists. Please provide a different name.");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function modifyGroupVO($itemgroupVO){
			$result = 0;
			$isDuplicate = true;
			try{
				$groupId = $itemgroupVO->getGroupId();
				$groupName = $itemgroupVO->getGroupName();
				$isDuplicate = $this->doesGroupExists($groupName);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(MODIFY_ITEMGROUP_INFO)) {
						$stmt->bind_param('ss',$groupName,$groupId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("ItemGroupDAO :: modifyGroupVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Group name already exists. Please provide a different name.");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function deleteGroupVO($id){
			$result = 0;
			try{
				if($this->hasItems($id) == false){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(DELETE_ITEMGROUP_INFO)) {
						$stmt->bind_param('s',$id);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("ItemGroupDAO :: deleteGroupVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Cannot delete group(s) with items. Only empty groups can be deleted");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function hasItems($groupId){
			$hasItems = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ITEMS_BY_GROUP)) {
					$stmt->bind_param('s',$groupId);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$hasItems = true;
					}
					$stmt->close();
				}else{
					throw new DBException("ItemGroupDAO :: hasItems :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $hasItems;
		}
		
		function doesGroupExists($groupName){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_GROUP_EXISTS)) {
					$stmt->bind_param('s',$groupName);
					$result = $stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("ItemGroupDAO :: doesGroupExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
	}
?>