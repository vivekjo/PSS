var mode = null;
var currentTxnId = 0;
var categoryObj = {};
var accheadObj = {};
var categoryTypeObj = {};
var accheadCategoryObj = {};

function getAllChannels(){
	var params = "action=GetAllChannels";
	sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseGetAllChannels");
}

function responseGetAllChannels(responseText, isSuccess){
	if(isSuccess == "true"){
		populateCategoryJSON(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateCategoryJSON(responseText){
	var channelsXML = getXMLFromString(responseText);
	var totalItems = channelsXML.getElementsByTagName('channel').length;
	var channelId = null;
	var channelName = null;
	for(var i=0;i<totalItems;i++){
		channelId = getNodeValue(channelsXML,'channelid',i);
		channelName = getNodeValue(channelsXML,'channelname',i);
		channelType = getNodeValue(channelsXML,'channeltype',i);
		categoryObj[channelId] = channelName;
		categoryTypeObj[channelType] = channelName;
	}
}
function getAllAccheads(){
	var params = "action=GetAllAccheads";
	sendAJAXRequest("/PSS/src/controller/AccHeadController.php",params,"responseGetAllAccheads");
}

function responseGetAllAccheads(responseText, isSuccess){
	if(isSuccess == "true"){
		populateAccheadsJSON(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateAccheadsJSON(responseText){
	var accheadsXML = getXMLFromString(responseText);
	var totalItems = accheadsXML.getElementsByTagName('accounthead').length;
	var channelId = null;
	var channelName = null;
	for(var i=0;i<totalItems;i++){
		accheadId = getNodeValue(accheadsXML,'accheadid',i);
		accheadName = getNodeValue(accheadsXML,'accheadname',i);
		accheadObj[accheadId] = accheadName;
	}
}

function getProjection(date){
	var params = "action=getProjectionByDate&date="+ date;
	sendAJAXRequest("/PSS/src/controller/ProjectionController.php",params,"responseGetProjectionByDate");
}

function responseGetProjectionByDate(responseText, isSuccess){
	if(isSuccess == "true"){
		updatePanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updatePanel(responseText){
	accountsXML = getXMLFromString(responseText);
	if(accountsXML != null){
		var divElement = document.getElementById("accountspanel");
		var noOfPayments =  accountsXML.getElementsByTagName("projection").length;
		var htmlText = "";
		for(var i=0;i<noOfPayments;i++){
			var txnId = getNodeValue(accountsXML,'txnid',i);
			var type = getNodeValue(accountsXML,'type',i);
			var categoryId = getNodeValue(accountsXML,'categoryid',i);
			var accHeadId = getNodeValue(accountsXML,'accheadid',i);
			var pg = getNodeValue(accountsXML,'pg',i);
			var lpg = getNodeValue(accountsXML,'lpg',i);
			var silver = getNodeValue(accountsXML,'silver',i);
			var cash = getNodeValue(accountsXML,'cash',i);
			var description = getNodeValue(accountsXML,'description',i);
			
			if(type =="incoming"){
				type = "<b>+</b>";
			}else{
				type = "<b>-</b>";
			}
			
			htmlText = htmlText + "<div id='" + txnId +"' class='panel-element' ondblClick=\"editProjection('"+ txnId +"')\">";
				htmlText = htmlText + "<div class='typeCell'>" + type + "</div>"; 
				htmlText = htmlText + "<div class='categorycell'>" + categoryObj[categoryId] + "</div>";
				htmlText = htmlText + "<div class='accheadcell'>" + accheadObj[accHeadId] + "</div>";
				htmlText = htmlText + "<div class='amountcell'>" + getProjectionAsString(pg,lpg,silver,cash) +  "</div>";
			htmlText = htmlText + "</div>";
		}
		
		if(noOfPayments == 0){
			htmlText = "<div class='panel-element'>There are no entries for this date</div>";
		}
		
		divElement.innerHTML = htmlText;
	}
}

function getProjectionAsString(pg,lpg,silver,cash){
	var htmlText = "";
	
	if(getFormattedNo(pg,2) == 0.00){
		pgText = "";
	}else{
		pgText = "<div class='amtWrapperDiv'><div class='amt-label-div'>PG</div>" + "<div class='amt-value-div'>" + getFormattedNo(pg,2) + "</div></div>";
	}
	
	if(getFormattedNo(lpg,2) == 0.00){
		lpgText = "";
	}else{
		lpgText = "<div class='amtWrapperDiv'><div class='amt-label-div'>LPG</div>" + "<div class='amt-value-div'>" + getFormattedNo(lpg,2) + "</div></div>";
	}
	
	if(getFormattedNo(silver,2) == 0.00){
		silverText = "";
	}else{
		silverText = "<div class='amtWrapperDiv'><div class='amt-label-div'>Silver</div>" + "<div class='amt-value-div'>" + getFormattedNo(silver,2) + "</div></div>";
	}
	
	if(getFormattedNo(cash,2) == 0.00){
		cashText = "";
	}else{
		cashText = "<div class='amtWrapperDiv'><div class='amt-label-div'>Cash</div>" + "<div class='amt-value-div'>" + getFormattedNo(cash,2) + "</div></div>";
	}
	
	htmlText = pgText + lpgText + silverText + cashText;
	
	return htmlText;
}

function getChannelsByType(type){
	var params = "action=GetChannelsByType&type=" + type;
	sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseGetChannelsByType");
}

function responseGetChannelsByType(responseText, isSuccess){
	if(isSuccess == "true"){
		updateChannelsPanel(responseText);
		clearAccHeads();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateChannelsPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("channelid");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('channel').length;
	htmlText = "<option value=\"\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		channelId = getNodeValue(itemsXML,'channelid',i);
		channelName = getNodeValue(itemsXML,'channelname',i);
		
		htmlText = htmlText + "<option value=\"" + channelId + "\">" + channelName + "</option>";
		htmlText = htmlText + channelName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
}

function clearAccHeads(){
	accountheadid.options.length = 0;
}

function getAccHeadsByChannel(channelId){
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
	var divElement = document.getElementById("accountheadid");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('accounthead').length;
	htmlText = "<option value=\"\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		accheadId = getNodeValue(itemsXML,'accheadid',i);
		accheadName = getNodeValue(itemsXML,'accheadname',i);
		
		htmlText = htmlText + "<option value=\"" + accheadId + "\">" + accheadName + "</option>";
		htmlText = htmlText + accheadName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
}

function prepareParamsToAddProjection(){
	var params = null;
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var type = document.getElementById("type").value;
	var categoryid = document.getElementById("channelid").value;
	var accheadid = document.getElementById("accountheadid").value;
	var pg = document.getElementById("pg").value;
	var lpg = document.getElementById("lpg").value;
	var silver = document.getElementById("silver").value;
	var cash = document.getElementById("cash").value;
	var description = document.getElementById("description").value;
	params = "action=add" + "&date=" + date + "&type=" + type + "&categoryid=" + categoryid + "&accheadid=" + accheadid + "&pg=" + pg + "&lpg=" + lpg + "&silver=" + silver + "&cash=" + cash + "&description=" + description;
	return params;
}

function addProjection(){
	var isValid = validateProjectionForm();
	if(isValid){
		updateStatus("Processing . . .");
		var params = prepareParamsToAddProjection();
		sendAJAXRequest("/PSS/src/controller/ProjectionController.php",params,"responseAddProjection");
	}
}

function validateProjectionForm(){
	var isValid = false;
	
	var date = document.getElementById("date");
	var type = document.getElementById("type");
	var categoryid = document.getElementById("channelid");
	var accheadid = document.getElementById("accountheadid");
	var pg = document.getElementById("pg");
	var lpg = document.getElementById("lpg");
	var silver = document.getElementById("silver");
	var cash = document.getElementById("cash");
	var description = document.getElementById("description");
	
	if(date.value == null || trim(date.value).length == 0){
		updateStatus("Please enter a valid date");
		date.select();
	}else if(type.value == null || trim(type.value).length == 0){
		updateStatus("Please select a valid type");
		type.focus();
	}else if(categoryid.value == null || trim(categoryid.value).length == 0){
		updateStatus("Please select a valid category");
		categoryid.focus();
	}else if(accheadid.value == null || trim(accheadid.value).length == 0){
		updateStatus("Please select a valid account head");
		accheadid.focus();
	}else if(pg.value == null || trim(pg.value).length == 0 || !isNumber(pg.value)){
		updateStatus("Please enter a value for pure gold");
		pg.select();
	}else if(lpg.value == null || trim(lpg.value).length == 0 || !isNumber(lpg.value)){
		updateStatus("Please enter a value for less pure gold");
		lpg.select();
	}else if(silver.value == null || trim(silver.value).length == 0 || !isNumber(silver.value)){
		updateStatus("Please enter a value for silver");
		silver.select();
	}else if(cash.value == null || trim(cash.value).length == 0 || !isNumber(cash.value)){
		updateStatus("Please enter a value for cash");
		cash.select();
	}else if(trim(pg.value) == "0" && trim(lpg.value) == "0" && trim(silver.value) == "0" && trim(cash.value) == "0" ){
		updateStatus("All values cannot be zero");
		pg.select();
	}else{
		isValid = true;
	}
	return isValid;
}

function responseAddProjection(responseText,isSuccess){
	if(isSuccess == "true"){
		updateStatus("Account details added successfully");
		clearForm();
		getProjectionBySelectedDate();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function getPrevDateProjection(){
	var prevDate = getFormattedDate(getPreviousDate(),"/");
	document.getElementById("selectedDate").value = getPreviousDate();
	getProjection(prevDate);
}
function getNextDateProjection(){
	var nextDate = getFormattedDate(getNextDate(),"/");
	document.getElementById("selectedDate").value = getNextDate();
	getProjection(nextDate);
}

function getTodaysProjection(){
	var today = getFormattedDate(getToday(),"/");
	document.getElementById("selectedDate").value = getToday();
	getProjection(today);
}

function getProjectionBySelectedDate(){
	var varDate = getFormattedDate(document.getElementById("selectedDate").value,"/");
	getProjection(varDate);
}

function showEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "none";
	editDiv.style.display = "block";
	
	var type = document.getElementById("type");
	type.disabled= "disabled";
	var channel = document.getElementById("channelid");
	channel.disabled= "disabled";
	var acchead = document.getElementById("accountheadid");
	acchead.disabled= "disabled";
}

function hideEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "block";
	editDiv.style.display = "none";
	
	var type = document.getElementById("type");
	type.disabled= false;
	var channel = document.getElementById("channelid");
	channel.disabled= false;
	var acchead = document.getElementById("accountheadid");
	acchead.disabled= false;
	
}
function editProjection(txnId){
	var params = "action=getProjectionById&txnid=" + txnId;
	sendAJAXRequest("/PSS/src/controller/ProjectionController.php",params,"responseEditProjection");
}

function responseEditProjection(responseText,isSuccess){
	if(isSuccess == "true"){
		populateProjectionForm(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateProjectionForm(responseText){
	var accountsXML = getXMLFromString(responseText);
	var htmlText = "";
	if(accountsXML != null){
		mode = "edit";
		var txnId = getFirstNodeValue(accountsXML,'txnid');
		var date = getFirstNodeValue(accountsXML,'date');
		var type = getFirstNodeValue(accountsXML,'type');
		var categoryId = getFirstNodeValue(accountsXML,'categoryid');
		var accheadId = getFirstNodeValue(accountsXML,'accheadid');
		var pg = getFirstNodeValue(accountsXML,'pg');
		var lpg = getFirstNodeValue(accountsXML,'lpg');
		var silver = getFirstNodeValue(accountsXML,'silver');
		var cash = getFirstNodeValue(accountsXML,'cash');
		var description = getFirstNodeValue(accountsXML,'description');
		
		currentTxnId = txnId;
		document.getElementById("date").value = getFormattedDate(date,"-");
		document.getElementById("type").value = type;
		document.getElementById("channelid").innerHTML = "<option value='" + categoryId + "'>" + categoryObj[categoryId] + "</option>";
		document.getElementById("channelid").value = categoryId;
		document.getElementById("accountheadid").innerHTML = "<option value='" + accheadId + "'>" + accheadObj[accheadId] + "</option>";
		document.getElementById("accountheadid").value = accheadId;
		document.getElementById("pg").value = pg;
		document.getElementById("lpg").value = lpg;
		document.getElementById("silver").value = silver;
		document.getElementById("cash").value = cash;
		document.getElementById("description").value = description;
		
		showEditButtonPanel();
		
//		document.getElementById("voucherno").select();
	}
}

function deleteProjection(){
	var isConfirmed = confirm("Are you sure to delete this projection entry ?");
	if(isConfirmed){
		updateStatus("Processing . . .");
		var params = prepareParamsToDeleteProjection();
		sendAJAXRequest("/PSS/src/controller/ProjectionController.php",params,"responseDeleteProjection");
	}
}

function responseDeleteProjection(responseText,isSuccess){
	if(isSuccess == "true"){
		updateStatus("Projection entry deleted successfully.");
		clearForm();
		getProjectionBySelectedDate();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function prepareParamsToDeleteProjection(){
	var params = null;
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var type = document.getElementById("type").value;
	var categoryid = document.getElementById("channelid").value;
	var accheadid = document.getElementById("accountheadid").value;
	var pg = document.getElementById("pg").value;
	var lpg = document.getElementById("lpg").value;
	var silver = document.getElementById("silver").value;
	var cash = document.getElementById("cash").value;
	var description = document.getElementById("description").value;
	params = "action=delete" + "&txnid=" + currentTxnId + "&type=" + type +"&pg=" + pg + "&lpg=" + lpg + "&silver=" + silver + "&cash=" + cash;
	return params;
}

function modifyProjection(){
	var isValid = validateProjectionForm();
	if(isValid){
		updateStatus("Processing . . .");
		var params = prepareParamsToModifyProjection();
		sendAJAXRequest("/PSS/src/controller/ProjectionController.php",params,"responseModifyProjection");
	}
}

function responseModifyProjection(responseText,isSuccess){
	if(isSuccess == "true"){
		updateStatus("Projection entry updated successfully.");
		clearForm();
		getProjectionBySelectedDate();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function prepareParamsToModifyProjection(){
	var params = null;
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var type = document.getElementById("type").value;
	var categoryid = document.getElementById("channelid").value;
	var accheadid = document.getElementById("accountheadid").value;
	var pg = document.getElementById("pg").value;
	var lpg = document.getElementById("lpg").value;
	var silver = document.getElementById("silver").value;
	var cash = document.getElementById("cash").value;
	var description = document.getElementById("description").value;
	params = "action=modify" + "&txnid=" + currentTxnId +"&date=" + date + "&type=" + type + "&categoryid=" + categoryid + "&accheadid=" + accheadid + "&pg=" + pg + "&lpg=" + lpg + "&silver=" + silver + "&cash=" + cash + "&description=" + description;
	return params;
}