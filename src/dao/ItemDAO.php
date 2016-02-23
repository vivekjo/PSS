<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/ItemVO.php';

	class ItemDAO {
		
		function getAllItems(){
			$itemVOList =  new CU_Collection('ItemVO');
			try{
				$itemVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ALL_ITEMS)) {
					$stmt->execute();
					$stmt->bind_result($itemId,$itemName,$parentGroupId);
					while($stmt->fetch()){
						$itemVO = new ItemVO();
						$itemVO->setItemId($itemId);
						$itemVO->setItemName($itemName);
						$itemVO->setParentGroupId($parentGroupId);
						$itemVOList->add($itemVO);
					}
					$stmt->close();
				}else{
					throw new DBException("ItemDAO :: getAllItemVOs :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $itemVOList;
		}
		
		function getItemsByGroup($groupId){
			$itemVOList =  new CU_Collection('ItemVO');
			try{
				$itemVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ITEMS_BY_GROUP)) {
					$stmt->bind_param('s',$groupId);
					$stmt->execute();
					$stmt->bind_result($itemId,$itemName,$parentGroupId);
					while($stmt->fetch()){
	
						$itemVO = new ItemVO();
						$itemVO->setItemId($itemId);
						$itemVO->setItemName($itemName);
						$itemVO->setParentGroupId($parentGroupId);
						$itemVOList->add($itemVO);
					}
					$stmt->close();
				}else{
					throw new DBException("ItemDAO :: getItemsByGroup :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $itemVOList;
		}
	
		function getItemVO($itemId){
			try{
				$itemVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ITEM_INFO)) {
					$stmt->bind_param('s',$itemId);
					$stmt->execute();
					$stmt->bind_result($itemId,$itemName,$parentGroupId);
					if($stmt->fetch()){
						$itemVO = new ItemVO();
						$itemVO->setItemId($itemId);
						$itemVO->setItemName($itemName);
						$itemVO->setParentGroupId($parentGroupId);
					}
					$stmt->close();
				}else{
					throw new DBException("ItemDAO :: getItemVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $itemVO;
		}
	
		function addItemVO($itemVO){
			$result = 0;
			try{
				$itemName = $itemVO->getItemName();
				$parentGroupId = $itemVO->getParentGroupId();
				$isDuplicate = $this->doesItemExists($itemName,$parentGroupId);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(ADD_ITEM_INFO)) {
						$stmt->bind_param('ss',$itemName,$parentGroupId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("ItemDAO :: addItemVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Item Name already exists in the Group. Please provide another name");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function modifyItemVO($itemVO){
			$result = 0;
			try{
				$itemId = $itemVO->getItemId();
				$itemName = $itemVO->getItemName();
				$parentGroupId = $itemVO->getParentGroupId();
				$isDuplicate = $this->doesItemExists($itemName,$parentGroupId);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(MODIFY_ITEM_INFO)) {
						$stmt->bind_param('sd',$itemName,$itemId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException($dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Item Name already exists in the Group. Please provide another name");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function deleteItemVO($id){
			$result = false;
			try{
				if($this->hasSubItems($id) == false){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(DELETE_ITEM_INFO)) {
						$stmt->bind_param('s',$id);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("ItemDAO :: deleteItemVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Cannot delete items with subitems. Only empty items can be deleted");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function hasSubItems($itemId){
			$hasSubItems = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_SUBITEMS_BY_ITEM)) {
					$stmt->bind_param('s',$itemId);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$hasSubItems = true;
					}
					$stmt->close();
				}else{
					throw new DBException("ItemDAO :: hasSubItems :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $hasSubItems;
		}
		
		function doesItemExists($itemName,$parentGroupId){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_ITEM_EXISTS)) {
					$stmt->bind_param('ss',$itemName,$parentGroupId);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("ItemDAO :: doesItemExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
	}
?>