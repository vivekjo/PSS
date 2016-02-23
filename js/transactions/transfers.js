var currentTxnId = 0;
var suppliersObj = {};

function getAllSuppliers(){
	var params = "action=GetAllSuppliers";
	sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseGetAllSuppliers");
}

function responseGetAllSuppliers(responseText, isSuccess){
	if(isSuccess == "true"){
		loadSuppliersList(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function loadSuppliersList(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("supplierList");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('supplier').length;
	htmlText = "<option value=\"\">-</option>";
	for(var i=0;i<totalItems;i++){
		supplierId = getNodeValue(itemsXML,'supplierid',i);
		supplierName = getNodeValue(itemsXML,'suppliername',i);
		
		htmlText = htmlText + "<option value=\"" + supplierId + "\">";
		htmlText = htmlText + supplierName;
		htmlText = htmlText + "</option>";
		suppliersObj[supplierId] = supplierName;
	}
	
	divElement.innerHTML = htmlText;
}

function getAllTransfers(){
	var params = "action=GetAllTransfers";
	sendAJAXRequest("/PSS/src/controller/TransferController.php",params,"responseGetAllTransfers");
}

function responseGetAllTransfers(responseText, isSuccess){
	if(isSuccess == "true"){
		updatePanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updatePanel(responseText){
	var transfersXML = getXMLFromString(responseText);
	var divElement = document.getElementById("transferspanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = transfersXML.getElementsByTagName('transfer').length;
	
	for(var i=0;i<totalItems;i++){
		txnId = getNodeValue(transfersXML,'txnid',i);
		supplierId = getNodeValue(transfersXML,'supplierid',i);
		fromType = getNodeValue(transfersXML,'fromtype',i);
		toType = getNodeValue(transfersXML,'totype',i);
		
		htmlText = htmlText + "<div id=\"" + txnId + "\" class='panel-element' ondblclick=editTransfers("+ txnId +")>" ;
		htmlText = htmlText + "<div class='suppliercell'>" + suppliersObj[supplierId] + "</div>" ;
		htmlText = htmlText + "<div class='transfercell'>" + fromType + " <-> " + toType + "</div>" ;
		htmlText = htmlText + "</div>";
	}
	if(totalItems == 0){
		htmlText = htmlText + "<div class='panel-element'>There are no transfer entries for the day.</div>";
	}
	divElement.innerHTML = htmlText;
}


function addTransfers(){
	var isValid = validateTransfersForm();
	if(isValid){
		updateStatus("Processing . . .");
		var params = prepareParamsToAddTransfers();
		sendAJAXRequest("/PSS/src/controller/TransferController.php",params,"responseAddTransfers");
	}
}

function prepareParamsToAddTransfers(){
	var params = "";
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var supplierId = document.getElementById("supplierList").value;
	var fromType = getShortType(document.getElementById("transferfrom").value);
	var toType = getShortType(document.getElementById("transferto").value);
	var fromAmount = document.getElementById("transferamount").value;
	var toAmount = document.getElementById("transferedamount").value;
	var description = document.getElementById("description").value;
	
	params = "action=add" + "&date=" + date + "&supplierid=" + supplierId + "&fromtype=" + fromType + "&totype=" + toType + "&fromamount=" + fromAmount + "&toamount=" + toAmount + "&description=" + description;
	return params;
}
function responseAddTransfers(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Transfers added successfully.");
		clearForm();
		getTransfersBySelectedDate();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function getShortType(type){
	var shortType = null;
	if(type == "pure gold"){
		shortType = "pg";
	}else if(type == "less pure gold"){
		shortType = "lpg";
	}else if(type == "silver"){
		shortType = "silver";
	}else if(type == "cash"){
		shortType = "cash";
	}
	return shortType;
}
function getLongType(type){
	var shortType = null;
	if(type == "pg"){
		shortType = "pure gold";
	}else if(type == "lpg"){
		shortType = "less pure gold";
	}else if(type == "silver"){
		shortType = "silver";
	}else if(type == "cash"){
		shortType = "cash";
	}
	return shortType;
}

function validateTransfersForm(){
	var isValid = false;
	
	var date = document.getElementById("date");
	var supplierId = document.getElementById("supplierList");
	var fromType = document.getElementById("transferfrom");
	var toType = document.getElementById("transferto");
	var fromAmount = document.getElementById("transferamount");
	var toAmount = document.getElementById("transferedamount");
	var description = document.getElementById("description");
	
	if(date.value == null || trim(date.value).length == 0){
		updateStatus("Please enter a valid date");
		date.focus();
	}else if(supplierId.value == null || trim(supplierId.value).length == 0){
		updateStatus("Please select a supplier");
		supplierId.focus();
	}else if(fromAmount.value == null || trim(fromAmount.value).length == 0 || !isNumber(fromAmount.value)){
		updateStatus("Please select a value to transfer from");
		fromAmount.focus();
	}else if(toAmount.value == null || trim(toAmount.value).length == 0 || !isNumber(toAmount.value)){
		updateStatus("Please select a value to transfer to");
		toAmount.focus();
	}else if(trim(fromType.value) == trim(toType.value)){
		updateStatus("From and To types cannot be same");
		fromType.focus();
	}else{
		isValid = true;
	}
	return isValid;
}

function prepareParamsToDeleteTranfers(){
	var params = "";
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var supplierId = document.getElementById("supplierList").value;
	var fromType = getShortType(document.getElementById("transferfrom").value);
	var toType = getShortType(document.getElementById("transferto").value);
	var fromAmount = document.getElementById("transferamount").value;
	var toAmount = document.getElementById("transferedamount").value;
	var description = document.getElementById("description").value;
	
	params = "action=delete" + "&txnid=" + currentTxnId + "&date=" + date + "&supplierid=" + supplierId + "&fromtype=" + fromType + "&totype=" + toType + "&fromamount=" + fromAmount + "&toamount=" + toAmount + "&description=" + description;
	return params;
}
function deleteTransfers(){
	var isConfirmed = confirm("Are you sure to delete the transfer entry ? ");
	if(isConfirmed){
		updateStatus("Processing . . .");
		var params = prepareParamsToDeleteTranfers();
		sendAJAXRequest("/PSS/src/controller/TransferController.php",params,"responseDeleteTransfers");
	}
}

function responseDeleteTransfers(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Transfer Entry deleted successfully.");
		clearForm();
		getTransfersBySelectedDate();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function editTransfers(txnId){
	var params = "action=getTransfersById&txnid=" + txnId;
	sendAJAXRequest("/PSS/src/controller/TransferController.php",params,"responseEditTransfers");
}


function responseEditTransfers(responseText, isSuccess){
	if(isSuccess == "true"){
		populateTransfersForm(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateTransfersForm(responseText){
	var transfersXML = getXMLFromString(responseText);
	
	txnId = getFirstNodeValue(transfersXML,'txnid');
	currentTxnId = txnId;
	date = getFirstNodeValue(transfersXML,'date');
	supplierId = getFirstNodeValue(transfersXML,'supplierid');
	fromType = getFirstNodeValue(transfersXML,'fromtype');
	toType = getFirstNodeValue(transfersXML,'totype');
	fromAmount = getFormattedNo(getFirstNodeValue(transfersXML,'fromamount'),4);
	toAmount = getFormattedNo(getFirstNodeValue(transfersXML,'toamount'),4);
	description = getFirstNodeValue(transfersXML,'description');
	
	document.getElementById("date").value = getFormattedDate(date,"-");
	document.getElementById("supplierList").value = supplierId;
	document.getElementById("transferfrom").value = getLongType(fromType);
	document.getElementById("transferto").value = getLongType(toType);
	document.getElementById("transferamount").value = fromAmount;
	document.getElementById("transferedamount").value = toAmount;
	document.getElementById("description").value = description;
	
	document.getElementById("supplierList").focus();
	
	showEditButtonPanel();
	disableControls();
}

function showSupplierBalance(supplierId){
	if(supplierId != ""){
		var params = "action=getsupplierdetails&supplierid=" + supplierId;
		sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseShowSupplierBalance");
	}else{
		var divElement = document.getElementById("supplierpanel");
		htmlText = "<div class=\"panel-element\">Please select a supplier</div>";
		divElement.innerHTML = htmlText;
	}
}

function responseShowSupplierBalance(responseText, isSuccess){
	if(isSuccess == "true"){
		populateSupplierDetails(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateSupplierDetails(responseText){
	supplierXML = getXMLFromString(responseText);
	
	if(supplierXML != null){
		var supplierName = getFirstNodeValue(supplierXML,'suppliername');
		var clpg = getFirstNodeValue(supplierXML,'clpg');
		var cllpg = getFirstNodeValue(supplierXML,'cllpg');
		var clsilver = getFirstNodeValue(supplierXML,'clsilver');
		var clcash = getFirstNodeValue(supplierXML,'clcash');
	
		var divElement = document.getElementById("supplierpanel");
		
		var htmlText = "";
		htmlText = "<div class=\"panel-element\"> Pure Gold      : <b>" + getFormattedNo(clpg,3) + " (g)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Less Pure Gold : <b>" + getFormattedNo(cllpg,3) + " (g)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Silver         : <b>" + getFormattedNo(clsilver,3) + " (kg)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Cash           : <b>" + getFormattedNo(clcash,3) + " (INR)</b></div>";
		
		divElement.innerHTML = htmlText;
	}
	
}

function showEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "none";
	editDiv.style.display = "block";
	
	document.getElementById("date").disabled = false;
	document.getElementById("supplierList").disabled = false;
	document.getElementById("transferfrom").disabled = false;
	document.getElementById("transferto").disabled = false;
	document.getElementById("transferamount").disabled = false;
	document.getElementById("transferedamount").disabled = false;
	document.getElementById("description").disabled = false;
}

function hideEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "block";
	editDiv.style.display = "none";
	
	document.getElementById("date").disabled = "disabled";
	document.getElementById("supplierList").disabled = "disabled";
	document.getElementById("transferfrom").disabled = "disabled";
	document.getElementById("transferto").disabled = "disabled";
	document.getElementById("transferamount").disabled = "disabled";
	document.getElementById("transferedamount").disabled = "disabled";
	document.getElementById("description").disabled = "disabled";
}

function enableControls(){
	document.getElementById("date").disabled = false;
	document.getElementById("supplierList").disabled = false;
	document.getElementById("transferfrom").disabled = false;
	document.getElementById("transferto").disabled = false;
	document.getElementById("transferamount").disabled = false;
	document.getElementById("transferedamount").disabled = false;
	document.getElementById("description").disabled = false;
}

function disableControls(){
	document.getElementById("date").disabled = "disabled";
	document.getElementById("supplierList").disabled = "disabled";
	document.getElementById("transferfrom").disabled = "disabled";
	document.getElementById("transferto").disabled = "disabled";
	document.getElementById("transferamount").disabled = "disabled";
	document.getElementById("transferedamount").disabled = "disabled";
	document.getElementById("description").disabled = "disabled";
}

function closeNewTypeWindow(){
	var divElement = document.getElementById("newProductDiv");
	divElement.style.display = "none";
}

function showNewTypeWindow(){
	var windowTitle = document.getElementById("window-title");
	var fieldLabel = document.getElementById("field-label");
	var transferAmount = trim(document.getElementById("transferamount").value);
	var transferFrom = document.getElementById("transferfrom");
	var transferFromName = transferFrom.options[transferFrom.selectedIndex].text;
	var transferTo = document.getElementById("transferto");
	var transferToName = transferTo.options[transferTo.selectedIndex].text;
	if(transferFromName == transferToName){
		updateStatus("Please select different 'from' and 'to' values");
	}else if(transferAmount.length == 0){
		updateStatus("Please enter the value to convert");
		document.getElementById("transferamount").focus();
	}else{
		windowTitle.innerHTML = "Convert " + transferFromName + " to " + transferToName  ;
		var divElement = document.getElementById("newProductDiv");
		divElement.style.display = "block";
		document.getElementById("pgratebar").value = "";
		if(transferFrom.value == "silver"){
			document.getElementById("uom").innerHTML = "rate/kg";
		}
		if(transferFrom.value != "cash"){
			getRateByType(transferFrom.value);
			fieldLabel.innerHTML = "<b>" + transferFromName + " Rate" + "</b>";
		}else if(transferFrom.value == "cash" && transferTo.value == ""){
			
		}
		document.getElementById("pgratebar").focus();
	}
	
}

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
	}
}

function getRateByType(metal){
	var params = "action=getRateByType&metal=" + metal;
	sendAJAXRequest("/PSS/src/controller/RateController.php",params,"responseGetRateByType");
}

function responseGetRateByType(responseText, isSuccess){
	if(isSuccess == "true"){
		rateXML = getXMLFromString(responseText);
		if(rateXML != null){
			document.getElementById("pgratebar").value = getFirstNodeValue(rateXML,'rate');
			document.getElementById("pgrateg").value = new Number(document.getElementById("pgratebar").value)/116.47;
		}
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function convert(){
	var transferFrom = document.getElementById("transferfrom").value;
	var transferTo = document.getElementById("transferto").value;
	var percent = getFormattedNo(document.getElementById("conversionpercent").value,2);
	var transferAmount = getFormattedNo(trim(document.getElementById("transferamount").value),2);
	var rateperg = getFormattedNo(trim(document.getElementById("pgrateg").value),2);
	
	
	var convertedValue = "";
	if(transferFrom == "pure gold" && transferTo == "less pure gold"){
		convertedValue = transferAmount * (percent/100);
	}else if(transferFrom == "less pure gold" && transferTo == "pure gold"){
		convertedValue = transferAmount / (percent/100);
	}else if(transferFrom == "pure gold" && transferTo == "cash"){
		convertedValue = transferAmount * (rateperg);
	}
	document.getElementById("convertedvalue").value = convertedValue;
}

function getNextDateTransfers(){
	var nextDate = getFormattedDate(getNextDate(),"/");
	document.getElementById("selectedDate").value = getNextDate();
	getTransfers(nextDate);
}

function getPrevDateTransfers(){
	var prevDate = getFormattedDate(getPreviousDate(),"/");
	document.getElementById("selectedDate").value = getPreviousDate();
	getTransfers(prevDate);
}

function getTodaysTransfers(){
	var today = getFormattedDate(getToday(),"/");
	document.getElementById("selectedDate").value = getToday();
	getTransfers(today);
}

function getTransfersBySelectedDate(){
	var varDate = getFormattedDate(document.getElementById("selectedDate").value,"/");
	getTransfers(varDate);
}

function getTransfers(varDate){
	var params = "action=getDaywiseTransfers&date=" + varDate;
	sendAJAXRequest("/PSS/src/controller/TransferController.php",params,"responseGetTransfers");
}

function responseGetTransfers(responseText,isSuccess){
	if(isSuccess == "true"){
		updatePanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function convertValue(){
	var transferFrom = getShortType(document.getElementById("transferfrom").value);
	var transferTo = getShortType(document.getElementById("transferto").value);
	var transferAmount = getFormattedNo(trim(document.getElementById("transferamount").value),3);
	var params = "action=convertMetal" + "&transferfrom=" + transferFrom + "&transferto=" + transferTo + "&amount=" + transferAmount;
	sendAJAXRequest("/PSS/src/controller/PaymentController.php",params,"responseConvertValue");
}

function responseConvertValue(responseText,isSuccess){
	if(isSuccess == "true"){
		var transferedAmount = document.getElementById("transferedamount");
		var response = responseText.replace("<response>","");
		response = response.replace("</response>","");
		transferedAmount.value = getFormattedNo(response,3);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}