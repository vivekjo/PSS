var selectedChannel = null;
var selectedType = null;
var windowType = null;
var mode = null;
var tmpTimeOut = null;

function getAllChannels(){
	var params = "action=GetAllChannels";
	sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseGetAllChannels");
}

function responseGetAllChannels(responseText, isSuccess){
	if(isSuccess == "true"){
		
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function getChannelsByType(type){
	var params = "action=GetChannelsByType&type=" + type;
	sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseGetChannelsByType");
}

function responseGetChannelsByType(responseText, isSuccess){
	if(isSuccess == "true"){
		updateChannelsPanel(responseText);
		clearAccHeadsPanel();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateChannelsPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("channelspanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('channel').length;
	
	for(var i=0;i<totalItems;i++){
		channelId = getNodeValue(itemsXML,'channelid',i);
		channelName = getNodeValue(itemsXML,'channelname',i);
		
		htmlText = htmlText + "<div id=\"" + "c_" + channelId + "\" class=\"panel-element\" onclick=\"selectChannel(this.id);getAccHeadsByChannel(this.id);\">";
		htmlText = htmlText + channelName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	unselectChannelsPanel();
	selectedChannel = null;
}

function clearAccHeadsPanel(){
	var divElement = document.getElementById("accheadspanel");
	divElement.innerHTML = "";
	selectedAccHead = null;
}

function addChannel(){
	if(validateWindowForm()){
		updateWindowStatus("Processing . . .");
		var typeId = selectedType;
		var channelName = trim(document.getElementById("name").value);
		var params = "action=add" + "&channelname=" + channelName + "&channeltype=" + typeId;
		sendAJAXRequest('../src/controller/ChannelController.php',params,'responseAddChannel');
	}
}

function responseAddChannel(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getChannelsByType(selectedType);
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function selectType(id){
	unselectTypesPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-panel-element");
	selectedType = id.split('_')[1];
}

function unselectTypesPanel(){
	var divElement = document.getElementById("typespanel");
	var noOfTypes = divElement.childNodes.length;
	for(var i=0;i<noOfTypes;i++){
		divElement.childNodes[i].setAttribute("class","panel-element");
	}
}

function selectChannel(id){
	unselectChannelsPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-panel-element");
	selectedChannel = id.split('_')[1];
}

function deleteSelectedChannel(){
	if(selectedChannel != null){
		var selectedChannelName = document.getElementById("c_" + selectedChannel).innerHTML;
		var isConfirmed = confirm("Are you sure to delete \"" + selectedChannelName + "\"");
		if(isConfirmed){
			var params = "action=delete" + "&channelid=" + selectedChannel;
			sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseDeleteChannel");
		}
	}else{
		alert("Please Select an item and then press delete");
	}
}

function responseDeleteChannel(responseText, isSuccess){
	if(isSuccess == "true"){
		getChannelsByType(selectedType);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		alert(errorMsg);
	}
}

function editChannel(){
	if(validateWindowForm() && isValidChannelName()){
		updateWindowStatus("Processing . . .");
		var channelId = selectedChannel;
		var channelName = trim(document.getElementById("name").value);
		var params = "action=modify" + "&channelname=" + channelName + "&channelid=" + channelId + "&channeltype=" + selectedType;
		sendAJAXRequest('../src/controller/ChannelController.php',params,'responseEditChannel');
	}
}

function isValidChannelName(){
	var isValid = true;
	var currentChannelName = trim(document.getElementById("c_" + selectedChannel).innerHTML);
	var newChannelName = trim(document.getElementById("name").value);
	if(newChannelName == currentChannelName){
		isValid = false;
		updateWindowStatus("Both old and new channel names are same. Please enter a different channel name.");
		document.getElementById("name").select();
	}
	return isValid;
}

function responseEditChannel(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getChannelsByType(selectedType);
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function editSelectedChannel(){
	if(selectedChannel != null){
		showNewTypeWindow('Channel','edit');
		var channelName = document.getElementById("c_" + selectedChannel).innerHTML;
		document.getElementById("name").value = channelName;
		document.getElementById("name").select();
	}else{
		alert("Please Select an channel to edit");
	}
}

function unselectChannelsPanel(){
	var divElement = document.getElementById("channelspanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","panel-element");
	}
}

function closeNewTypeWindow(){
	var divElement = document.getElementById("newProductDiv");
	divElement.style.display = "none";
}

function showNewTypeWindow(type, action){
	var titleStr = "";
	if(type == "Channel" && selectedType == null){
		alert('Please Select Income/Expense Type');
	}else if(type == "Account Head" && selectedChannel == null){
		alert('Please Select an Account head');
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
		if(windowType == "Channel"){
			addChannel();
		}else if(windowType == "Account Head"){
			addAccHead();
		}
	}else{
		if(windowType == "Channel"){
			editChannel();
		}else if(windowType == "Account Head"){
			editAccHead();
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