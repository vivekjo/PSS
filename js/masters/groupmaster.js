var selectedGroup = null;

function getAllGroups(){
	var params = "action=GetAllGroups";
	sendAJAXRequest("/PSS/src/controller/GroupController.php",params,"responseGetAllGroups");
}

function responseGetAllGroups(responseText, isSuccess){
	if(isSuccess == "true"){
		updateGroupPanel(responseText);
		clearItemsPanel();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateGroupPanel(responseText){
	var groupsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("grouppanel");
	
	var groupId = null;
	var groupName = null;
	
	var htmlText = "";
	var totalItems = groupsXML.getElementsByTagName('itemgroup').length;
	
	for(var i=0;i<totalItems;i++){
		groupId = getNodeValue(groupsXML,'groupid',i);
		groupName = getNodeValue(groupsXML,'groupname',i);
		
		htmlText = htmlText + "<div id=\"" + "g_" + groupId + "\" class=\"panel-element\" onclick=\"selectGroup(this.id);getItemsByGroup(this.id);\">";
		htmlText = htmlText + groupName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	unselectGroupPanel();
	selectedGroup = null;
}

function clearItemsPanel(){
	var divElement = document.getElementById("itempanel");
	divElement.innerHTML = "";
	selectedItem = null;
	selectedSubItem = null;
}

function selectGroup(id){
	unselectGroupPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-panel-element");
	selectedGroup = id.split('_')[1];
}

function unselectGroupPanel(){
	var divElement = document.getElementById("grouppanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","panel-element");
	}
}

function deleteSelectedGroup(){
	if(selectedGroup != null){
		var selectedGroupName = document.getElementById("g_" + selectedGroup).innerHTML;
		var isConfirmed = confirm("Are you sure to delete \"" + selectedGroupName + "\"");
		if(isConfirmed){
			updateStatus("Processing . . .");
			var params = "action=delete" + "&groupid=" + selectedGroup;
			sendAJAXRequest("/PSS/src/controller/GroupController.php",params,"responseDeleteGroup");
		}
	}else{
		updateStatus("Please Select a group and then press delete");
	}
}

function responseDeleteGroup(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Group Deleted Successfully");
		getAllGroups();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function editSelectedGroup(){
	if(selectedGroup != null){
		showNewTypeWindow('Group','edit');
		var groupName = document.getElementById("g_" + selectedGroup).innerHTML;
		document.getElementById("name").value = groupName;
		document.getElementById("name").select();
	}else{
		updateStatus("Please Select a group to edit");
	}
}

function addGroup(){
	if(validateWindowForm()){
		updateWindowStatus("Processing . . .");
		var groupName = trim(document.getElementById("name").value);
		var params = "action=add" + "&groupname=" + groupName;
		sendAJAXRequest('../src/controller/GroupController.php',params,'responseAddGroup');
	}
}

function responseAddGroup(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getAllGroups();
		updateWindowStatus("");
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function editGroup(){
	if(validateWindowForm() && isValidGroupName()){
		updateWindowStatus("Processing . . .");
		var groupName = trim(document.getElementById("name").value);
		var params = "action=modify" + "&groupid=" + selectedGroup + "&groupname=" + groupName;
		sendAJAXRequest('../src/controller/GroupController.php',params,'responseEditGroup');
	}
}

function isValidGroupName(){
	var isValid = true;
	var currentGroupName = trim(document.getElementById("g_" + selectedGroup).innerHTML);
	var newGroupName = trim(document.getElementById("name").value);
	if(newGroupName == currentGroupName){
		isValid = false;
		updateWindowStatus("Both old and new group names are same. Please enter a different group name.");
		document.getElementById("name").select();
	}
	return isValid;
}

function responseEditGroup(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getAllGroups();
		updateWindowStatus("");
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function closeNewTypeWindow(){
	var divElement = document.getElementById("newProductDiv");
	divElement.style.display = "none";
}