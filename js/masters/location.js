var selectedLocation = null;

function getAllLocations(){
	var params = "action=GetAllLocations";
	sendAJAXRequest("/PSS/src/controller/LocationController.php",params,"responseGetAllLocations");
}

function responseGetAllLocations(responseText, isSuccess){
	if(isSuccess == "true"){
		updateLocationPanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateLocationPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("locationpanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('location').length;
	
	for(var i=0;i<totalItems;i++){
		locationId = getNodeValue(itemsXML,'locationid',i);
		locationName = getNodeValue(itemsXML,'locationname',i);
		
		htmlText = htmlText + "<div id=\"" + locationId + "\" class=\"panel-element\" onclick=\"selectLocation(this.id);\" ondblclick=\"editSelectedLocation();\">";
		htmlText = htmlText + locationName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	unselectLocationPanel();
	selectedLocation = null;
}

function selectLocation(id){
	unselectLocationPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-panel-element");
	selectedLocation = id;
	clearForm();
}

function unselectLocationPanel(){
	var divElement = document.getElementById("locationpanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","panel-element");
	}
}

function editSelectedLocation(){
	if(selectedLocation == null){
		updateStatus("Please select a Location");
	}else{
		editLocation();
	}
}

function deleteSelectedLocation(){
	if(selectedLocation == null){
		updateStatus("Please select a Location");
	}else{
		var confirmed = confirm("Are you Sure to delete this Location?");
		if(confirmed){
			deleteLocation();
		}else{
			getAllLocations();
			clearForm();
		}
	}
}

function deleteLocation(){
	updateStatus("Processing . . .");
	var params = "action=delete&locationid=" + selectedLocation;
	sendAJAXRequest("/PSS/src/controller/LocationController.php",params,"responseDeleteLocation");
}

function responseDeleteLocation(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Location deleted successfully.");
		getAllLocations();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("locationname").select();
	}
}

function editLocation(){
	var params = "action=getlocationdetails&locationid=" + selectedLocation;
	sendAJAXRequest("/PSS/src/controller/LocationController.php",params,"responseEditLocation");
}

function responseEditLocation(responseText, isSuccess){
	if(isSuccess == "true"){
		populateLocationDetails(responseText);
		showEditButtonPanel();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("locationname").select();
	}
}

function populateLocationDetails(responseText){
	locationXML = getXMLFromString(responseText);
	
	if(locationXML != null){
		var locationName = getFirstNodeValue(locationXML,'locationname');
		document.getElementById("locationname").value = locationName;
	}
	
}

function showEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "none";
	editDiv.style.display = "block";
}

function hideEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "block";
	editDiv.style.display = "none";
}

function updateLocation(){
	var isValid = validateLocationForm();
	if(isValid == true){
		updateStatus("Processing . . .");
		var params = prepareParamsToUpdateLocation();
		sendAJAXRequest("/PSS/src/controller/LocationController.php",params,"responseUpdateLocation");
	}
}

function responseUpdateLocation(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Location details modified successfully.");
		getAllLocations();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("locationname").select();
	}
}

function addLocation(){
	var isValid = validateLocationForm();
	if(isValid == true){
		updateStatus("Processing . . .");
		var params = prepareParamsToAddLocation();
		sendAJAXRequest("/PSS/src/controller/LocationController.php",params,"responseAddLocation");
	}
}

function responseAddLocation(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Location added successfully.");
		getAllLocations();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("locationname").select();
	}
}
function validateLocationForm(){
	var isValid = false;
	var locationName = document.getElementById("locationname");
	
	if(trim(locationName.value) == ""){
		updateStatus("Please enter a valid location name");
		locationName.focus();
	}else{
		isValid = true;
	}
	return isValid;
}

function prepareParamsToAddLocation(){
	var params = null;
	var locationName = document.getElementById("locationname").value;
	params = "action=add" + "&locationname=" + locationName;
	return params;
}

function prepareParamsToUpdateLocation(){
	var params = null;
	var locationId = selectedLocation;
	var locationName = document.getElementById("locationname").value;
	params = "action=modify" + "&locationid=" + locationId + "&locationname=" + locationName;
	return params;
}