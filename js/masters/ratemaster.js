var selectedSupplier = null;

function getAllRates(){
	var params = "action=GetAllRates";
	sendAJAXRequest("/PSS/src/controller/RateController.php",params,"responseGetAllRates");
}

function responseGetAllRates(responseText, isSuccess){
	if(isSuccess == "true"){
		populateRates(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateRates(responseText){
	var pgRate = 0;
	var lpgRate = 0;
	var silverRate = 0;
	var tmp = null;
	var rateXML = getXMLFromString(responseText);
	var noOfRates = rateXML.getElementsByTagName('rates').length;
	if(rateXML != null){
		for(var i=0;i<noOfRates;i++){
			tmp = getNodeValue(rateXML,'metal',i);
			if(tmp == 'pure gold'){
				pgRate = getNodeValue(rateXML,'rate',i);
			}else if(tmp == 'less pure gold'){
				lpgRate = getNodeValue(rateXML,'rate',i);
			}else if(tmp == 'silver'){
				silverRate = getNodeValue(rateXML,'rate',i);
			}
		}
		document.getElementById("pg").value = new Number(pgRate).toFixed(2);
		document.getElementById("lpg").value = new Number(lpgRate).toFixed(2);
		document.getElementById("silver").value = new Number(silverRate).toFixed(2);
	}
}

function savePG(){
	var pg = trim(document.getElementById("pg").value);
	if(pg != ""){
		updateStatus("Processing . . .");
		var params = "action=modifyPG" + "&pg=" + pg;
		sendAJAXRequest("/PSS/src/controller/RateController.php",params,"responseSavePG");
	}else{
		document.getElementById("pg").focus();
	}
}

function responseSavePG(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Saved Successfully.");
		getAllRates();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function saveLPG(){
	var lpg = trim(document.getElementById("lpg").value);
	if(lpg != ""){
		updateStatus("Processing . . .");
		var params = "action=modifyLPG" + "&lpg=" + lpg;
		sendAJAXRequest("/PSS/src/controller/RateController.php",params,"responseSaveLPG");
	}else{
		document.getElementById("lpg").focus();
	}
}

function responseSaveLPG(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Saved Successfully.");
		getAllRates();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function saveSilver(){
	var silver = trim(document.getElementById("silver").value);
	if(silver != ""){
		updateStatus("Processing . . .");
		var params = "action=modifySilver" + "&silver=" + silver;
		sendAJAXRequest("/PSS/src/controller/RateController.php",params,"responseSaveSilver");
	}else{
		document.getElementById("silver").focus();
	}
}

function responseSaveSilver(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Saved Successfully.");
		getAllRates();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}