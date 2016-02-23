var selectHTML = null;
var suppliersObj = {};
var mode = null;
var currentTxnId = 0;

function getAllSuppliers(){
	var params = "action=GetAllSuppliers";
	sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseGetAllSuppliers");
}

function responseGetAllSuppliers(responseText, isSuccess){
	if(isSuccess == "true"){
		loadSuppliersList(responseText);
	}else{
		
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
		htmlText = "<div class=\"panel-element\"> Pure Gold      : <b>" + clpg + " (g)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Less Pure Gold : <b>" + cllpg + " (g)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Silver         : <b>" + clsilver + " (kg)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Cash           : <b>" + clcash + " (INR)</b></div>";
		
		divElement.innerHTML = htmlText;
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

function prepareParamsToAddPayment(){
	var params = null;
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var supplierId = document.getElementById("supplierList").value;
	var voucherNo = document.getElementById("voucherno").value;
	var paymentMode = document.getElementById("paymentmode").value;
	var amount = document.getElementById("amount").value;
	var description = document.getElementById("description").value;
	params = "action=add" + "&date=" + date + "&supplierid=" + supplierId + "&voucherno=" + voucherNo + "&paymentmode=" + paymentMode + "&amount=" + amount + "&description=" + description;
	return params;
}

function prepareParamsToModifyPayment(){
	var params = null;
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var supplierId = document.getElementById("supplierList").value;
	var voucherNo = document.getElementById("voucherno").value;
	var paymentMode = document.getElementById("paymentmode").value;
	var amount = document.getElementById("amount").value;
	var description = document.getElementById("description").value;
	params = "action=modify" + "&txnid=" + currentTxnId + "&date=" + date + "&supplierid=" + supplierId + "&voucherno=" + voucherNo + "&paymentmode=" + paymentMode + "&amount=" + amount + "&description=" + description;
	return params;
}

function addPaymentEntry(){
	var isValid = validatePaymentForm();
	if(isValid){
		updateStatus("Processing . . .");
		var params = prepareParamsToAddPayment();
		sendAJAXRequest("/PSS/src/controller/PaymentController.php",params,"responseAddPayment");
	}
}

function responseAddPayment(responseText,isSuccess){
	if(isSuccess == "true"){
		updateStatus("Payment details added successfully");
		clearForm();
		getTodaysPayment();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function modifyPaymentEntry(){
	var isValid = validatePaymentForm();
	if(isValid){
		updateStatus("Processing . . .");
		var params = prepareParamsToModifyPayment();
		sendAJAXRequest("/PSS/src/controller/PaymentController.php",params,"responseModifyPayment");
	}
}

function responseModifyPayment(responseText,isSuccess){
	if(isSuccess == "true"){
		updateStatus("Payment details updated successfully");
		clearForm();
		getTodaysPayment();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function validatePaymentForm(){
	var isValid = false;
	
	var date = document.getElementById("date");
	var supplierId = document.getElementById("supplierList");
	var voucherNo = document.getElementById("voucherno");
	var paymentMode = document.getElementById("paymentmode");
	var amount = document.getElementById("amount");
	
	if(date.value == null || trim(date.value).length == 0){
		updateStatus("Please enter a valid date");
		date.select();
	}else if(supplierId.value == null || trim(supplierId.value).length == 0){
		updateStatus("Please select a supplier");
		supplierId.focus();
	}else if(voucherNo.value == null || trim(voucherNo.value).length == 0){
		updateStatus("Please enter a value for voucher no");
		voucherNo.select();
	}else if(paymentMode.value == null || trim(paymentMode.value).length == 0){
		updateStatus("Please select a payment mode");
		paymentMode.focus();
	}else if(amount.value == null || trim(amount.value).length == 0 || !isNumber(amount.value)){
		updateStatus("Please enter a numeric value for amount");
		amount.select();
	}else{
		isValid = true;
	}
	
	return isValid;
}

function getNextDatePayment(){
	var nextDate = getFormattedDate(getNextDate(),"/");
	document.getElementById("selectedDate").value = getNextDate();
	getPayment(nextDate);
}

function getPrevDatePayment(){
	var prevDate = getFormattedDate(getPreviousDate(),"/");
	document.getElementById("selectedDate").value = getPreviousDate();
	getPayment(prevDate);
}

function getTodaysPayment(){
	var today = getFormattedDate(getToday(),"/");
	document.getElementById("selectedDate").value = getToday();
	getPayment(today);
}

function getPaymentBySelectedDate(){
	var varDate = getFormattedDate(document.getElementById("selectedDate").value,"/");
	getPayment(varDate);
}

function getPayment(varDate){
	var params = "action=getDaywisePayment&date=" + varDate;
	sendAJAXRequest("/PSS/src/controller/PaymentController.php",params,"responseGetPayment");
}

function responseGetPayment(responseText,isSuccess){
	if(isSuccess == "true"){
		populatePaymentPanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populatePaymentPanel(responseText){
	var paymentXML = getXMLFromString(responseText);
	var htmlText = "";
	if(paymentXML != null){
		var divElement = document.getElementById("paymentpanel");
		var noOfPayments =  paymentXML.getElementsByTagName("payment").length;
		
		for(var i=0;i<noOfPayments;i++){
			var txnId = getNodeValue(paymentXML,'txnid',i);
			var supplierId = getNodeValue(paymentXML,'supplierid',i);
			var voucherNo = getNodeValue(paymentXML,'voucherno',i);
			var paymentMode = getNodeValue(paymentXML,'paymentmode',i);
			var amount = getNodeValue(paymentXML,'amount',i);
			var description = getNodeValue(paymentXML,'description',i);
			
			htmlText = htmlText + "<div id='" + txnId +"' class='panel-element' ondblClick=\"editPayment('"+ txnId +"')\">";
				htmlText = htmlText + "<div class='suppliercell'>" + suppliersObj[supplierId] + "</div>"; 
				htmlText = htmlText + "<div class='paymentmodecell'>" + paymentMode + "</div>";
				var number = new Number(amount);
				htmlText = htmlText + "<div class='amountcell'>" + number.toFixed(2) +  "</div>";
			htmlText = htmlText + "</div>";
		}
		
		if(noOfPayments == 0){
			htmlText = "<div class='panel-element'>There are no payments for this date</div>";
		}
		divElement.innerHTML = htmlText;
	}
}

function editPayment(txnId){
	var params = "action=getPaymentById&txnid=" + txnId;
	sendAJAXRequest("/PSS/src/controller/PaymentController.php",params,"responseEditPayment");
}

function responseEditPayment(responseText,isSuccess){
	if(isSuccess == "true"){
		populatePaymentForm(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populatePaymentForm(responseText){
	var paymentXML = getXMLFromString(responseText);
	var htmlText = "";
	if(paymentXML != null){
		mode = "edit";
		var txnId = getFirstNodeValue(paymentXML,'txnid');
		var date = getFirstNodeValue(paymentXML,'date');
		var supplierId = getFirstNodeValue(paymentXML,'supplierid');
		var voucherNo = getFirstNodeValue(paymentXML,'voucherno');
		var paymentMode = getFirstNodeValue(paymentXML,'paymentmode');
		var amount = getFirstNodeValue(paymentXML,'amount');
		var description = getFirstNodeValue(paymentXML,'description');
		
		currentTxnId = txnId;
		document.getElementById("date").value = getFormattedDate(date,"-");
		document.getElementById("supplierList").value = supplierId;
		document.getElementById("voucherno").value = voucherNo;
		document.getElementById("paymentmode").value = paymentMode;
		document.getElementById("amount").value = amount;
		document.getElementById("description").value = description;
		
		showEditButtonPanel();
		
		document.getElementById("voucherno").select();
	}
}

function showEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "none";
	editDiv.style.display = "block";
	
	var supplierList = document.getElementById("supplierList");
	supplierList.disabled= "disabled";
	var paymentmode = document.getElementById("paymentmode");
	paymentmode.disabled= "disabled";
}

function hideEditButtonPanel(){
	var addDiv = document.getElementById("add-button-div");
	var editDiv = document.getElementById("edit-button-div");
	
	addDiv.style.display = "block";
	editDiv.style.display = "none";
	
	var supplierList = document.getElementById("supplierList");
	supplierList.disabled= false;
	
	var paymentmode = document.getElementById("paymentmode");
	paymentmode.disabled= false;
}

function deletePayment(){
	if(currentTxnId != 0){
		var isConfirmed = confirm("Are you sure to delete the payment?");
		if(isConfirmed){
			updateStatus('Processing . . .');
			var params = prepareParamsToDeletePayment();
			sendAJAXRequest("/PSS/src/controller/PaymentController.php",params,"responseDeletePayment");
		}
	}
}

function responseDeletePayment(responseText,isSuccess){
	if(isSuccess == "true"){
		updateStatus('Payment Entry Deleted Successfully');
		getPaymentBySelectedDate();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function prepareParamsToDeletePayment(){
	var params = null;
	var supplierId = document.getElementById("supplierList").value;
	var paymentMode = document.getElementById("paymentmode").value;
	var amount = document.getElementById("amount").value;
	params = "action=delete" + "&txnid=" + currentTxnId + "&supplierid=" + supplierId + "&paymentmode=" + paymentMode + "&amount=" + amount;
	return params;
}
function getOpening(){
	var params = "action=GetOpening";
	sendAJAXRequest("/PSS/src/controller/CompanyController.php",params,"responseGetOpening");
}

function responseGetOpening(responseText, isSuccess){
	if(isSuccess == "true"){
		populateOpening(responseText);
	}
}

function populateOpening(responseText){
	var pgRate = 0;
	var lpgRate = 0;
	var silverRate = 0;
	var tmp = null;
	var openingXML = getXMLFromString(responseText);
	if(openingXML != null){
		var clpg = getFormattedNo(getFirstNodeValue(openingXML,'clpg'),4);
		var cllpg = getFormattedNo(getFirstNodeValue(openingXML,'cllpg'),4);
		var clsilver = getFormattedNo(getFirstNodeValue(openingXML,'clsilver'),4);
		var clcash = getFormattedNo(getFirstNodeValue(openingXML,'clcash'),4);
		
		var divElement = document.getElementById("companypanel");
		
		var htmlText = "";
		htmlText = "<div class=\"panel-element\"> Pure Gold      : <b>" + clpg + " (g)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Less Pure Gold : <b>" + cllpg + " (g)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Silver         : <b>" + clsilver + " (kg)</b></div>";
		htmlText = htmlText + "<div class=\"panel-element\"> Cash           : <b>" + clcash + " (INR)</b></div>";
		
		divElement.innerHTML = htmlText;
	}
}