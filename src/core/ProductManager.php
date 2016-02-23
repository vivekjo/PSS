<?php 
	
	include_once '../dao/ItemgroupDAO.php';
	include_once '../dao/ItemDAO.php';
	include_once '../dao/SubitemDAO.php';
	
	class ProductManager{

		function getAllGroups(){
			$groupList = null;
			$itemGroupDAO = new ItemgroupDAO();
			$groupList = $itemGroupDAO->getAllGroups();
			return $groupList;
		}
		
		function getItemGroupVO($groupId){
			$groupVO = null;
			
			$itemGroupDAO = new ItemgroupDAO();
			$groupVO = $itemGroupDAO->getItemGroupVO($groupId);
			return $groupVO;
		}
		
		function addGroupVO($groupVO){
			$result = false;
			try{
				$itemGroupDAO = new ItemgroupDAO();
				$result = $itemGroupDAO->addGroupVO($groupVO);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function modifyGroupVO($groupVO){
			$result = false;
			try{
				$itemGroupDAO = new ItemgroupDAO();
				$result = $itemGroupDAO->modifyGroupVO($groupVO);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function deleteGroupVO($groupId){
			$result = 0;
			try{
				$itemGroupDAO = new ItemgroupDAO();
				$result = $itemGroupDAO->deleteGroupVO($groupId);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function getAllItems(){
			$itemList = null;
			
			$itemDAO = new ItemDAO();
			$itemList = $itemDAO->getAllItems();
			return $itemList;
		}
		function getItemsByGroup($groupId){
			$itemList = null;
			
			$itemDAO = new ItemDAO();
			$itemList = $itemDAO->getItemsByGroup($groupId);
			return $itemList;
		}
		
		function getItemVO($itemId){
			$itemVO = null;
			
			$itemDAO = new ItemDAO();
			$itemVO = $itemDAO->getItemVO($itemId);
			return $itemVO;
		}
		
		function addItemVO($itemVO){
			$result = false;
			try{
				$itemDAO = new ItemDAO();
				$result = $itemDAO->addItemVO($itemVO);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function modifyItemVO($itemVO){
			$result = false;
			try{
				$itemDAO = new ItemDAO();
				$result = $itemDAO->modifyItemVO($itemVO);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function deleteItemVO($itemId){
			$result = 0;
			try{
				$itemDAO = new ItemDAO();
				$result = $itemDAO->deleteItemVO($itemId);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function getAllSubitems(){
			$subitemsList = null;
			
			$subitemDAO = new SubitemDAO();
			$subitemsList = $subitemDAO->getAllSubitems();
			return $subitemsList;
		}
		function getSubitemsByItemId($itemId){
			$subitemsList = null;
			
			$subitemDAO = new SubitemDAO();
			$subitemsList = $subitemDAO->getSubitemsByItemId($itemId);
			return $subitemsList;
		}
		
		function getSubitemVO($subitemId){
			$subitemVO = null;
			
			$subitemDAO = new SubitemDAO();
			$subitemVO = $subitemDAO->getSubitemVO($subitemId);
			return $subitemVO;
		}
		
		function addSubitemVO($subitemVO){
			$result = false;
			try{
				$subitemDAO = new SubitemDAO();
				$result = $subitemDAO->addSubitemVO($subitemVO);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function modifySubitemVO($subitemVO){
			$result = false;
			try{
				$subitemDAO = new SubitemDAO();
				$result = $subitemDAO->modifySubitemVO($subitemVO);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function delteSubitemVO($subitemId){
			$result = 0;
			try{
				$subitemDAO = new SubitemDAO();
				$result = $subitemDAO->deleteSubitemVO($subitemId);
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	}
?>