var selectedSupplier = null;

function getOpening(){
	var params = "action=GetOpening";
	sendAJAXRequest("/PSS/src/controller/CompanyController.php",params,"responseGetOpening");
}

function responseGetOpening(responseText, isSuccess){
	if(isSuccess == "true"){
		populateOpening(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateOpening(responseText){
	var openingXML = getXMLFromString(responseText);
	if(openingXML != null){
		var oppg = getFirstNodeValue(openingXML,'oppg');
		var oplpg = getFirstNodeValue(openingXML,'oplpg');
		var opsilver = getFirstNodeValue(openingXML,'opsilver');
		var opcash = getFirstNodeValue(openingXML,'opcash');
		
		document.getElementById("oppg").value = new Number(oppg).toFixed(3);
		document.getElementById("oplpg").value = new Number(oplpg).toFixed(3);
		document.getElementById("opsilver").value = new Number(opsilver).toFixed(3);
		document.getElementById("opcash").value = new Number(opcash).toFixed(2);
	}
}

function getClosing(){
	var params = "action=GetOpening";
	sendAJAXRequest("/PSS/src/controller/CompanyController.php",params,"responseGetClosing");
}

function responseGetClosing(responseText, isSuccess){
	if(isSuccess == "true"){
		populateClosing(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateClosing(responseText){
	var closingXML = getXMLFromString(responseText);
	if(closingXML != null){
		var clpg = getFirstNodeValue(closingXML,'clpg');
		var cllpg = getFirstNodeValue(closingXML,'cllpg');
		var clsilver = getFirstNodeValue(closingXML,'clsilver');
		var clcash = getFirstNodeValue(closingXML,'clcash');
		
		document.getElementById("c_pg").innerHTML = new Number(clpg).toFixed(3);
		document.getElementById("c_lpg").innerHTML = new Number(cllpg).toFixed(3);
		document.getElementById("c_silver").innerHTML = new Number(clsilver).toFixed(3);
		document.getElementById("c_cash").innerHTML = new Number(clcash).toFixed(2);
	}
}

function getSuspense(){
	var params = "action=getSuspenseBalance";
	sendAJAXRequest("/PSS/src/controller/SuspenseentryController.php",params,"responseGetSuspenseBalance");
}

function responseGetSuspenseBalance(responseText, isSuccess){
	if(isSuccess == "true"){
		populateSuspenseBalance(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateSuspenseBalance(responseText){
	var suspenseXML = getXMLFromString(responseText);
	if(suspenseXML != null){
		var clpg = getFirstNodeValue(suspenseXML,'pg');
		var cllpg = getFirstNodeValue(suspenseXML,'lpg');
		var clsilver = getFirstNodeValue(suspenseXML,'silver');
		var clcash = getFirstNodeValue(suspenseXML,'cash');
		
		document.getElementById("s_pg").innerHTML = new Number(clpg).toFixed(3);
		document.getElementById("s_lpg").innerHTML = new Number(cllpg).toFixed(3);
		document.getElementById("s_silver").innerHTML = new Number(clsilver).toFixed(3);
		document.getElementById("s_cash").innerHTML = new Number(clcash).toFixed(2);
	}
}

function validateOpeningForm(){
	var isValid = false;
	var oppg = document.getElementById("oppg");
	var oplpg = document.getElementById("oplpg");
	var opsilver = document.getElementById("opsilver");
	var opcash = document.getElementById("opcash");
	
	if(trim(oppg.value) == "" ){
		updateStatus("Please enter a value for pure gold");
		oppg.focus();
	}else if(trim(oplpg.value) == "" ){
		updateStatus("Please enter a value for less pure gold");
		oplpg.focus();
	}else if(trim(opsilver.value) == "" ){
		updateStatus("Please enter a value for silver");
		opsilver.focus();
	}else if(trim(opcash.value) == "" ){
		updateStatus("Please enter a value for cash");
		opcash.focus();
	}else{
		isValid = true;
	}
	return isValid;
}

function saveOpening(){
	if(validateOpeningForm()){
		updateStatus("Processing . . .");
		var params = prepareParams();
		sendAJAXRequest("/PSS/src/controller/CompanyController.php",params,"responseSaveOpening");
	}
}

function responseSaveOpening(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Opening Information saved successfully");
		getOpening();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("suppliername").select();
	}
}

function prepareParams(){
	var params = null;
	var oppg = document.getElementById("oppg").value;
	var oplpg = document.getElementById("oplpg").value;
	var opsilver = document.getElementById("opsilver").value;
	var opcash = document.getElementById("opcash").value;
	params = "action=modify" + "&oppg=" + oppg + "&oplpg=" + oplpg + "&opsilver=" + opsilver + "&opcash=" + opcash;
	return params;
}