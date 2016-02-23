var selectedSubItem = null;

function getSubItems(itemId){
	if(itemId.indexOf('_') != -1){
		itemId = itemId.split('_')[1];
	}
	var params = "action=GetSubItems&itemId=" + itemId;
	sendAJAXRequest("/PSS/src/controller/SubItemController.php",params,"responseGetSubItems");
}

function responseGetSubItems(responseText, isSuccess){
	if(isSuccess == "true"){
		updateSubItemPanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateSubItemPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("subitempanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('subitem').length;
	
	for(var i=0;i<totalItems;i++){
		subItemId = getNodeValue(itemsXML,'subitemid',i);
		subItemName = getNodeValue(itemsXML,'subitemname',i);
		
		htmlText = htmlText + "<div id=\"" + "si_" + subItemId + "\" class=\"leaf-panel-element\" onclick=\"selectSubItem(this.id);\">";
		htmlText = htmlText + subItemName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	selectedSubItem = null;
}

function selectSubItem(id){
	unselectSubItemPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-leaf-panel-element");
	selectedSubItem = id.split('_')[1];
}

function unselectSubItemPanel(){
	var divElement = document.getElementById("subitempanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","leaf-panel-element");
	}
}

function addSubItem(){
	if(validateWindowForm()){
		updateWindowStatus("Processing . . .");
		var itemId = selectedItem;
		var subItemName = trim(document.getElementById("name").value);
		var params = "action=add" + "&subitemname=" + subItemName + "&parentitemid=" + itemId;
		sendAJAXRequest('../src/controller/SubItemController.php',params,'responseAddSubItem');
	}
}

function responseAddSubItem(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getSubItems(selectedItem);
		updateWindowStatus("");
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function deleteSelectedSubItem(){
	var isConfirmed = confirm("Are you sure to delete the subitem?");
	if(isConfirmed){
		deleteSubItem(selectedSubItem);
	}
}

function editSelectedSubItem(){
	if(selectedSubItem != null){
		showNewTypeWindow('Sub item','edit');
		var subitemName = document.getElementById("si_" + selectedSubItem).innerHTML;
		document.getElementById("name").value = subitemName;
		document.getElementById("name").select();
	}else{
		updateStatus("Please Select an sub item to edit");
	}
}

function editSubItem(){
	if(validateWindowForm() && isValidSubItemName()){
		updateWindowStatus("Processing . . .");
		var subitemId = selectedSubItem;
		var subitemName = trim(document.getElementById("name").value);
		var params = "action=modify" + "&subitemname=" + subitemName + "&subitemid=" + subitemId + "&parentitemid=" + selectedItem;
		sendAJAXRequest('../src/controller/SubItemController.php',params,'responseEditSubItem');
	}
}

function responseEditSubItem(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getSubItems(selectedItem);
		updateWindowStatus("");
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function isValidSubItemName(){
	var isValid = true;
	var currentSubItemName = trim(document.getElementById("si_" + selectedSubItem).innerHTML);
	var newSubItemName = trim(document.getElementById("name").value);
	if(newSubItemName == currentSubItemName){
		isValid = false;
		updateWindowStatus("Both old and new sub item names are same. Please enter a different sub item name.");
		document.getElementById("name").select();
	}
	return isValid;
}

function deleteSubItem(subItemId){
	updateStatus("Processing . . .");
	var params = "action=delete&subitemid=" + subItemId;
	sendAJAXRequest('/PSS/src/controller/SubItemController.php',params,'responseDeleteSubItem');
}

function responseDeleteSubItem(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Sub item deleted successfully.");
		 getSubItems(selectedItem);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}