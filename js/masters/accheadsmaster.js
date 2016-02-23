var selectedAccHead = null;

function getAccHeadsByChannel(channelId){
	if(channelId.indexOf('_') != -1){
		channelId = channelId.split('_')[1];
	}
	var params = "action=GetAccHeadsByChannel&channelid=" + channelId;
	sendAJAXRequest("/PSS/src/controller/AccHeadController.php",params,"responseGetAccHeadByChannel");
}

function responseGetAccHeadByChannel(responseText, isSuccess){
	if(isSuccess == "true"){
		updateAccHeadsPanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateAccHeadsPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("accheadspanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('accounthead').length;
	
	for(var i=0;i<totalItems;i++){
		accheadId = getNodeValue(itemsXML,'accheadid',i);
		accheadName = getNodeValue(itemsXML,'accheadname',i);
		
		htmlText = htmlText + "<div id=\"" + "a_" + accheadId + "\" class=\"leaf-panel-element\" onclick=\"selectAccHead(this.id);\">";
		htmlText = htmlText + accheadName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	unselectAccHeadsPanel();
	selectedAccHead = null;
}

function clearAccHeadsPanel(){
	var divElement = document.getElementById("accheadspanel");
	divElement.innerHTML = "";
	selectedAccHead = null;
}

function selectAccHead(id){
	unselectAccHeadsPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-leaf-panel-element");
	selectedAccHead = id.split('_')[1];
}

function addAccHead(){
	if(validateWindowForm()){
		updateWindowStatus("Processing . . .");
		var channelId = selectedChannel;
		var AccheadName = trim(document.getElementById("name").value);
		var params = "action=add" + "&accheadname=" + AccheadName + "&parentchannelid=" + channelId;
		sendAJAXRequest('../src/controller/AccHeadController.php',params,'responseAddAccHead');
	}
}

function responseAddAccHead(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getAccHeadsByChannel(selectedChannel);
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}

function deleteSelectedAccHead(){
	if(selectedAccHead != null){
		var isConfirmed = confirm("Are you sure to delete the selected account head?");
		if(isConfirmed){
			updateStatus('Processing . . .');
			var params = "action=delete" + "&accheadid=" + selectedAccHead;
			sendAJAXRequest('../src/controller/AccHeadController.php',params,'responseDeleteAccHead');
		}
	}else{
		updateStatus("Please select the account head to delete.");
	}
	
}

function responseDeleteAccHead(responseText, isSuccess){
	if(isSuccess == "true"){
		selectedAccHead = null;
		updateStatus("The selected account head has been deleted successfully");
		getAccHeadsByChannel(selectedChannel);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function editSelectedAccHead(){
	if(selectedAccHead != null){
		showNewTypeWindow('Account Head','edit');
		var accHeadName = document.getElementById("a_" + selectedAccHead).innerHTML;
		document.getElementById("name").value = accHeadName;
		document.getElementById("name").select();
	}else{
		alert("Please Select an Account Head to edit");
	}
}

function editAccHead(){
	if(validateWindowForm() && isValidAccHeadName()){
		updateWindowStatus("Processing . . .");
		var accHeadId = selectedAccHead;
		var accHeadName = trim(document.getElementById("name").value);
		var params = "action=modify" + "&accheadname=" + accHeadName + "&accheadid=" + accHeadId + "&parentchannelid=" + selectedChannel;
		sendAJAXRequest('../src/controller/AccHeadController.php',params,'responseEditAccHead');
	}
}

function isValidAccHeadName(){
	var isValid = true;
	var currentAccHeadName = trim(document.getElementById("a_" + selectedAccHead).innerHTML);
	var newAccHeadName = trim(document.getElementById("name").value);
	if(newAccHeadName == currentAccHeadName){
		isValid = false;
		updateWindowStatus("Both old and new Account Head names are same. Please enter a different name.");
		document.getElementById("name").select();
	}
	return isValid;
}

function responseEditAccHead(responseText, isSuccess){
	if(isSuccess == "true"){
		closeNewTypeWindow();
		getAccHeadsByChannel(selectedChannel);
	}else{
		selectWindowForm();
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateWindowStatus(errorMsg);
	}
}
function unselectAccHeadsPanel(){
	var divElement = document.getElementById("accheadspanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","leaf-panel-element");
	}
}