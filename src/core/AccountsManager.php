<?php
	
	include_once '../dao/ChannelDAO.php';
	include_once '../dao/AccountheadDAO.php';
	
	class AccountsManager{
		function getAllChannels(){
			$channelsList = null;
			$channelDAO = new ChannelDAO();
			$channelsList = $channelDAO->getAllChannels();
			return $channelsList;
		}
		function getChannelsByType($type){
			$channelsList = null;
			$channelDAO = new ChannelDAO();
			$channelsList = $channelDAO->getChannelsByType($type);
			return $channelsList;
		}
		
		function getAllAccheads(){
			$accheadsList = null;
			$accheadDAO = new AccountheadDAO();
			$accheadsList = $accheadDAO->getAllAccheads();
			return $accheadsList;
		}
		function getAccHeadsByChannel($channelId){
			$accheadsList = null;
			$accheadDAO = new AccountheadDAO();
			$accheadsList = $accheadDAO->getAccHeadsByChannel($channelId);
			return $accheadsList;
		}
		
		function addChannelVO($channelVO){
			$result = false;
			try{
				$channelDAO = new ChannelDAO();
				$result = $channelDAO->addChannelVO($channelVO);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
		
		function modifyChannelVO($channelVO){
			$result = false;
			try{
				$channelDAO = new ChannelDAO();
				$result = $channelDAO->modifyChannelVO($channelVO);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
		
		function deleteChannelVO($channelId){
			$result = 0;
			try{
				$channelDAO = new ChannelDAO();
				$result = $channelDAO->deleteChannelVO($channelId);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
		
		function addAccountHeadVO($accountheadVO){
			$result = false;
			try{
				$accheadDAO = new AccountheadDAO();
				$result = $accheadDAO->addAccountheadVO($accountheadVO);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
		
		function modifyAccountHeadVO($accountheadVO){
			$result = false;
			try{
				$accheadDAO = new AccountheadDAO();
				$result = $accheadDAO->modifyAccountheadVO($accountheadVO);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
		
		function deleteAccountHeadVO($accheadId){
			$result = 0;
			try{
				$accheadDAO = new AccountheadDAO();
				$result = $accheadDAO->deleteAccountHeadVO($accheadId);
			}catch(DBException $e){
				throw $e;
			}
			return $result;
		}
		
		function getIncomingHeads(){
			$channelsList = null;
			$accheadsList = null;
			$incomingHeadsList = array();
			try{
				$channelsList = $this->getChannelsByType('incoming');
				foreach($channelsList as $channelVO){
					$accheadsList = $this->getAccHeadsByChannel($channelVO->getChannelId());
					foreach($accheadsList as $accheadVO){
						$incomingHeadsList[$accheadVO->getAccheadId()] = $channelVO->getChannelName() . " -> " . $accheadVO->getAccheadName(); 
					}
				}
			}catch(DBException $e){
				throw $e;
			}
			return $incomingHeadsList;
		}
		
		function getOutgoingHeads(){
			$channelsList = null;
			$accheadsList = null;
			$outgoingHeadsList = array();
			try{
				$channelsList = $this->getChannelsByType('outgoing');
				foreach($channelsList as $channelVO){
					$accheadsList = $this->getAccHeadsByChannel($channelVO->getChannelId());
					foreach($accheadsList as $accheadVO){
						$outgoingHeadsList[$accheadVO->getAccheadId()] = $channelVO->getChannelName() . " -> " . $accheadVO->getAccheadName(); 
					}
				}
			}catch(DBException $e){
				throw $e;
			}
			return $outgoingHeadsList;
		}
		
	}
?>
