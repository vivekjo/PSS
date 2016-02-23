<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/SubitemVO.php';
	include_once '../dao/PurchaseDAO.php';
	include_once '../dao/ItemDAO.php';

	class SubitemDAO {

		function getAllSubitems(){
			$subitemVOList =  new CU_Collection('SubitemVO');
			try{
				$subitemVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ALL_SUBITEMS)) {
					$stmt->execute();
					$stmt->bind_result($subitemId,$subitemName,$parentItemId);
					while($stmt->fetch()){
						$subitemVO = new SubitemVO();
						$subitemVO->setSubitemId($subitemId);
						$subitemVO->setSubitemName($subitemName);
						$subitemVO->setParentItemId($parentItemId);
						$subitemVOList->add($subitemVO);
					}
					$stmt->close();
				}else{
					throw new DBException("SubitemDAO :: getAllSubitemVOs :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $subitemVOList;
		}
		
		function getAllSubitemsParents(){
			$parentList = array();
			$parentGroupList = array();
			$parentItemList =  array();
			try{
				$subitemVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ALL_SUBITEMS)) {
					$stmt->execute();
					$stmt->bind_result($subitemId,$subitemName,$parentItemId);
					while($stmt->fetch()){
						$parentItemList[$subitemId] = $parentItemId;
					}
					$stmt->close();
					$itemDAO = new ItemDAO();
					$itemVO = null;
					foreach($parentItemList as $subitemId=>$itemId){
						$itemVO = $itemDAO->getItemVO($itemId);
						$parentGroupList[$subitemId] = $itemVO->getParentGroupId();
					}
				}else{
					throw new DBException("SubitemDAO :: getAllSubitemVOs :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			$parentList[] = $parentGroupList;
			$parentList[] = $parentItemList;
			
			return $parentList;
		}
		
		function getSubitemsByItemId($itemId){
			$subitemVOList =  new CU_Collection('SubitemVO');
			try{
				$subitemVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_SUBITEMS_BY_ITEM)) {
					$stmt->bind_param('s',$itemId);
					$stmt->execute();
					$stmt->bind_result($subitemId,$subitemName,$parentItemId);
					while($stmt->fetch()){
						$subitemVO = new SubitemVO();
						$subitemVO->setSubitemId($subitemId);
						$subitemVO->setSubitemName($subitemName);
						$subitemVO->setParentItemId($parentItemId);
						$subitemVOList->add($subitemVO);
					}
					$stmt->close();
				}else{
					throw new DBException("SubitemDAO :: getSubitemsByItemId :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $subitemVOList;
		}
	
		function getSubitemVO($subitemId){
			try{
				$subitemVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_SUBITEM_INFO)) {
					$stmt->bind_param('s',$subitemId);
					$stmt->execute();
					$stmt->bind_result($subitemId,$subitemName,$parentItemId);
					if($stmt->fetch()){
						$subitemVO = new SubitemVO();
						$subitemVO->setSubitemId($subitemId);
						$subitemVO->setSubitemName($subitemName);
						$subitemVO->setParentItemId($parentItemId);
					}
					$stmt->close();
				}else{
					throw new DBException("SubitemDAO :: getSubitemVO :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $subitemVO;
		}
	
		function addSubitemVO($subitemVO){
			$result = 0;
			$isDuplicate = false;
			try{
				$subitemName = $subitemVO->getSubitemName();
				$parentItemId = $subitemVO->getParentItemId();
				$isDuplicate = $this->doesSubItemExists($subitemName,$parentItemId);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(ADD_SUBITEM_INFO)) {
						$stmt->bind_param('ss',$subitemName,$parentItemId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("SubitemDAO :: addSubitemVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("The Subitem already exists in the selected item. Please provide a different name.");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function modifySubitemVO($subitemVO){
			$result = 0;
			$isDuplicate = false;
			try{
				$subitemId = $subitemVO->getSubitemId();
				$subitemName = $subitemVO->getSubitemName();
				$parentItemId = $subitemVO->getParentItemId();
				$isDuplicate = $this->doesSubItemExists($subitemName,$parentItemId);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(MODIFY_SUBITEM_INFO)) {
						$stmt->bind_param('ss',$subitemName,$subitemId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("SubitemDAO :: modifySubitemVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("The Subitem already exists in the selected item. Please provide a different name.");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function deleteSubitemVO($subitemId){
			$result = false;
			try{
				$purchaseDAO = new PurchaseDAO();
				$hasTransaction = $purchaseDAO->hasTransaction($subitemId);
				if($hasTransaction == false){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(DELETE_SUBITEM_INFO)) {
						$stmt->bind_param('s',$subitemId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("SubitemDAO :: deleteSubitemVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Cannot delete sub item. It is involved in transactions");
				}
				
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function doesSubItemExists($subItemName,$parentItemId){
			$isDuplicate = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_SUBITEM_EXISTS)) {
					$stmt->bind_param('ss',$subItemName,$parentItemId);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($subitemId,$subitemName,$parentItemId);
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("SubitemDAO :: doesSubItemExists :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
	}
?>