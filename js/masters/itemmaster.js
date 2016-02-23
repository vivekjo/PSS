var selectedItem = null;
var windowType = null;
var mode = null;
var tmpTimeOut = null;

function getAllItems(){
	var params = "action=GetAllItems";
	sendAJAXRequest("src/controller/ItemController.php",params,"responseGetAllItems");
}

function responseGetAllItems(responseText, isSuccess){
	if(isSuccess  == "true"){
		//updateStatus(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function getItemsByGroup(groupId){
	if(groupId.indexOf('_') != -1){
		groupId = groupId.split('_')[1];
	}
	var params = "action=GetItemsByGroup&groupId=" + groupId;
	sendAJAXRequest("/PSS/src/controller/ItemController.php",params,"responseGetItemsByGroup");
}

function responseGetItemsByGroup(responseText, isSuccess){
	if(isSuccess == "true"){
		updateItemPanel(responseText);
		clearSubitemsPanel();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateItemPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("itempanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('item').length;
	
	for(var i=0;i<totalItems;i++){
		itemId = getNodeValue(itemsXML,'itemid',i);
		itemName = getNodeValue(itemsXML,'itemname',i);
		
		htmlText = htmlText + "<div id=\"" + "i_" + itemId + "\" class=\"panel-element\" onclick=\"selectItem(this.id);getSubItems(this.id);\">";
		htmlText = htmlText + itemName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	unselectItemPanel();
	selectedItem = null;
}

function clearSubitemsPanel(){
	var divElement = document.getElementById("subitempanel");
	divElement.innerHTML = "";
	selectedSubItem = null;
}

function selectItem(id){
	unselectItemPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-panel-element");
	selectedItem = id.split('_')[1];
}

function deleteSelectedItem(){
	if(selectedItem != null){
		var selectedItemName = document.getElementById("i_" + selectedItem).innerHTML;
		var isConfirmed = confirm("Are you sure to delete \"" + selectedItemName + "\"");
		if(isConfirmed){
			var params = "action=delete" + "&itemid=" + selectedItem;
			sendAJAXRequest("/PSS/src/controller/ItemController.php",params,"responseDeleteItem");
		}
	}else{
		updateStatus("Please Select an item and then press delete");
	}
}

function responseDeleteItem(responseText, isSuccess){
	if(isSuccess == "true"){
		getItemsByGroup(selectedGroup);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function editSelectedItem(){
	if(selectedItem != null){
		showNewTypeWindow('Item','edit');
		var itemName = document.getElementById("i_" + selectedItem).innerHTML;
		document.getElementById("name").value = itemName;
		document.getElementById("name").select();
	}else{
		updateStatus("Please Select an item to edit");
	}
}

function unselectItemPanel(){
	var divElement = document.getElementById("itempanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","panel-element");
	}
}

function addItem(){
	if(validateWindowForm()){
		updateWindowStatus("Processing . . .");
		var groupId = selectedGroup;
		var itemName = trim(document.getElementById("name").value);
		var params = "action=add" + "&itemname=" + itemName + "&parentgroupid=" + groupId;
		sendAJAXRequest('../src/controller/ItemController.php',params,'responseAddItem');
	}
}

function responseAddItem(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getItemsByGroup(selectedGroup);
		updateWindowStatus("");
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function editItem(){
	if(validateWindowForm() && isValidItemName()){
		updateWindowStatus("Processing . . .");
		var itemId = selectedItem;
		var itemName = trim(document.getElementById("name").value);
		var params = "action=modify" + "&itemname=" + itemName + "&itemid=" + itemId + "&parentgroupid=" + selectedGroup;
		sendAJAXRequest('../src/controller/ItemController.php',params,'responseEditItem');
	}
}

function responseEditItem(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getItemsByGroup(selectedGroup);
		updateWindowStatus("");
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function validateWindowForm(){
	var isValid = true;
	var name = document.getElementById("name");
	if(trim(name.value) == ""){
		isValid = false;
		updateWindowStatus("Please enter a valid name");
		name.value = "";
		name.focus();
	}
	return isValid;
}

function isValidItemName(){
	var isValid = true;
	var currentItemName = trim(document.getElementById("i_" + selectedItem).innerHTML);
	var newItemName = trim(document.getElementById("name").value);
	if(newItemName == currentItemName){
		isValid = false;
		updateWindowStatus("Both old and new item names are same. Please enter a different item name.");
		document.getElementById("name").select();
	}
	return isValid;
}

function closeNewTypeWindow(){
	var divElement = document.getElementById("newProductDiv");
	divElement.style.display = "none";
}

function showNewTypeWindow(type, action){
	var titleStr = "";
	if(type == "Item" && selectedGroup == null){
		updateStatus('Please Select a group');
	}else if(type == "Sub item" && selectedItem == null){
		updateStatus('Please Select an item');
	}else{
		windowType = type;
		mode = action;
		var windowTitle = document.getElementById("window-title");
		var fieldLabel = document.getElementById("field-label");
		if(action == "add"){
			titleStr = "Add New ";
		}else if(action == "edit"){
			titleStr = "Edit ";
		}
		windowTitle.innerHTML = titleStr + type;
		fieldLabel.innerHTML = type + " Name ";
		var divElement = document.getElementById("newProductDiv");
		divElement.style.display = "block";
		document.getElementById("name").value = "";
		document.getElementById("name").focus();
	}
}

function addType(){
	if(mode == "add"){
		if(windowType == "Group"){
			addGroup();
		}else if(windowType == "Item"){
			addItem();
		}else if(windowType == "Sub item"){
			addSubItem();
		}
	}else{
		if(windowType == "Group"){
			editGroup();
		}else if(windowType == "Item"){
			editItem();
		}else if(windowType == "Sub item"){
			editSubItem();
		}
	}
}

function updateWindowStatus(statusMsg){
	if(tmpTimeOut != null){
		clearTimeout(tmpTimeOut);
	}
	var windowStatusDiv = document.getElementById("window-status-div");
	windowStatusDiv.innerHTML = "<font color=\"red\">" + statusMsg + "</font>";
	tmpTimeOut = setTimeout('clearWindowStatus()',5000);
}

function clearWindowStatus(){
	var windowStatusDiv = document.getElementById("window-status-div");
	windowStatusDiv.innerHTML = "";
}

function clearWindowForm(){
	var windowNameElement = document.getElementById("name");
	windowNameElement.value= "";
	windowNameElement.focus();
}
function selectWindowForm(){
	var windowNameElement = document.getElementById("name");
	windowNameElement.select();
}