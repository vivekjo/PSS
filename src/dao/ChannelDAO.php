<?php

	include_once '../constants/SQLConstants.php';
	include_once '../constants/DBConstants.php';
	include_once '../util/DBUtil.php';
	include_once '../3putils/Collection.php';
	include_once '../exceptions/DBException.php';
	include_once '../vo/ChannelVO.php';

	class ChannelDAO {

		function getAllChannels(){
			$channelVOList =  new CU_Collection('ChannelVO');
			try{
				$channelVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ALL_CHANNELS)) {
					$stmt->execute();
					$stmt->bind_result($channelId,$channelName,$channelType);
					while($stmt->fetch()){
						$channelVO = new ChannelVO();
						$channelVO->setChannelId($channelId);
						$channelVO->setChannelName($channelName);
						$channelVO->setChannelType($channelType);
						$channelVOList->add($channelVO);
					}
					$stmt->close();
				}else{
					throw new DBException("AccountheadDAO :: getAllChannels :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $channelVOList;
		}
		
		function getChannelsByType($type){
			$channelVOList =  new CU_Collection('ChannelVO');
			try{
				$channelVO = null;
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_CHANNELS_BY_TYPE)) {
					$stmt->bind_param('s',$type);
					$stmt->execute();
					$stmt->bind_result($channelId,$channelName,$channelType);
					while($stmt->fetch()){
						$channelVO = new ChannelVO();
						$channelVO->setChannelId($channelId);
						$channelVO->setChannelName($channelName);
						$channelVO->setChannelType($channelType);
						$channelVOList->add($channelVO);
					}
					$stmt->close();
				}else{
					throw new DBException("AccountheadDAO :: getChannelsByType :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $channelVOList;
		}
	
		function addChannelVO($channelVO){
			$result = false;
			try{
				$channelName = $channelVO->getChannelName();
				$channelType = $channelVO->getChannelType();
				$isDuplicate = $this->doesChannelExist($channelName,$channelType);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(ADD_CHANNEL_INFO)) {
						$stmt->bind_param('ss',$channelName,$channelType);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("AccountheadDAO :: addChannelVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Channel Name already exists. Please provide a different channel name");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function modifyChannelVO($channelVO){
			$result = false;
			try{
				$channelId = $channelVO->getChannelId();
				$channelName = $channelVO->getChannelName();
				$channelType = $channelVO->getChannelType();
				$isDuplicate = $this->doesChannelExist($channelName,$channelType);
				if($isDuplicate != true){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(MODIFY_CHANNEL_INFO)) {
						$stmt->bind_param('ss',$channelName,$channelId);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("AccountheadDAO :: modifyChannelVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Channel Name already exists. Please provide a different channel name");
				}
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
	
		function deleteChannelVO($id){
			$result = false;
			try{
				if($this->hasAccountHeads($id) == false){
					$dbConnection = DBUtil::getConnection();
					if($stmt = $dbConnection->prepare(DELETE_CHANNEL_INFO)) {
						$stmt->bind_param('s',$id);
						$result = $stmt->execute();
						$stmt->close();
					}else{
						throw new DBException("AccountheadDAO :: deleteChannelVO :: " . $dbConnection->error);
					}
					$dbConnection->close();
				}else{
					throw new DBException("Cannot delete categories with account heads. Only empty categories can be deleted.");
				}
				
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $result;
		}
		
		function hasAccountHeads($channelId){
			$hasAccountHeads = false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(GET_ACCOUNTHEADS_BY_CHANNEL)) {
					$stmt->bind_param('s',$channelId);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$hasAccountHeads = true;
					}
					$stmt->close();
				}else{
					throw new DBException("AccountheadDAO :: hasAccountHeads :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $hasAccountHeads;
		}
		
		function doesChannelExist($channelName, $channelType){
			$isDuplicate= false;
			try{
				$dbConnection = DBUtil::getConnection();
				if($stmt = $dbConnection->prepare(DOES_CHANNEL_EXISTS)) {
					$stmt->bind_param('ss',$channelName, $channelType);
					$stmt->execute();
					$stmt->store_result();
					$num_rows= $stmt->num_rows; 
					if($num_rows > 0){
						$isDuplicate = true;
					}
					$stmt->close();
				}else{
					throw new DBException("AccountheadDAO :: doesChannelExist :: " . $dbConnection->error);
				}
				$dbConnection->close();
			}catch(Exception $e){
				throw new DBException($e->getMessage());
			}
			return $isDuplicate;
		}
		
	}
?>