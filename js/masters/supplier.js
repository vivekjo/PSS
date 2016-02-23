var selectedSupplier = null;

function getAllSuppliers(){
	var params = "action=GetAllSuppliers";
	sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseGetAllSuppliers");
}

function responseGetAllSuppliers(responseText, isSuccess){
	if(isSuccess == "true"){
		updateSupplierPanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateSupplierPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("supplierpanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('supplier').length;
	
	for(var i=0;i<totalItems;i++){
		supplierId = getNodeValue(itemsXML,'supplierid',i);
		supplierName = getNodeValue(itemsXML,'suppliername',i);
		
		htmlText = htmlText + "<div id=\"" + supplierId + "\" class=\"panel-element\" onclick=\"selectSupplier(this.id);\" ondblclick=\"editSelectedSupplier();\">";
		htmlText = htmlText + supplierName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	unselectSupplierPanel();
	selectedSupplier = null;
}

function selectSupplier(id){
	unselectSupplierPanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-panel-element");
	selectedSupplier = id;
	clearForm();
}

function unselectSupplierPanel(){
	var divElement = document.getElementById("supplierpanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","panel-element");
	}
}

function editSelectedSupplier(){
	if(selectedSupplier == null){
		updateStatus("Please select a supplier");
	}else{
		editSupplier();
	}
}

function deleteSelectedSupplier(){
	if(selectedSupplier == null){
		updateStatus("Please select a supplier");
	}else{
		var confirmed = confirm("Are you Sure to delete this supplier?");
		if(confirmed){
			deleteSupplier();
		}
	}
	
}

function deleteSupplier(){
	updateStatus("Processing . . .");
	var params = "action=delete&supplierid=" + selectedSupplier;
	sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseDeleteSupplier");
}

function responseDeleteSupplier(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Supplier deleted successfully.");
		getAllSuppliers();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("suppliername").select();
	}
}

function editSupplier(){
	var params = "action=getsupplierdetails&supplierid=" + selectedSupplier;
	sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseEditSupplier");
}

function responseEditSupplier(responseText, isSuccess){
	if(isSuccess == "true"){
		populateSupplierDetails(responseText);
		showEditButtonPanel();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("suppliername").select();
	}
}

function populateSupplierDetails(responseText){
	supplierXML = getXMLFromString(responseText);
	
	if(supplierXML != null){
		var supplierName = getFirstNodeValue(supplierXML,'suppliername');
		var oppg = getFirstNodeValue(supplierXML,'oppg');
		var oplpg = getFirstNodeValue(supplierXML,'oplpg');
		var opsilver = getFirstNodeValue(supplierXML,'opsilver');
		var opcash = getFirstNodeValue(supplierXML,'opcash');
		
		document.getElementById("suppliername").value = supplierName;
		document.getElementById("oppg").value = getFormattedNo(oppg,3);
		document.getElementById("oplpg").value = getFormattedNo(oplpg,3);
		document.getElementById("opsilver").value = getFormattedNo(opsilver,3);
		document.getElementById("opcash").value = getFormattedNo(opcash,2);
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

function updateSupplier(){
	var isValid = validateSupplierForm();
	if(isValid == true){
		updateStatus("Processing . . .");
		var params = prepareParamsToUpdateSupplier();
		sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseUpdateSupplier");
	}
}

function responseUpdateSupplier(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Supplier details modified successfully.");
		getAllSuppliers();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("suppliername").select();
	}
}

function addSupplier(){
	var isValid = validateSupplierForm();
	if(isValid == true){
		updateStatus("Processing . . .");
		var params = prepareParamsToAddSupplier();
		sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseAddSupplier");
	}
}

function responseAddSupplier(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Supplier added successfully.");
		getAllSuppliers();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("suppliername").select();
	}
}
function validateSupplierForm(){
	var isValid = false;
	var supplierName = document.getElementById("suppliername");
	var oppg = document.getElementById("oppg");
	var oplpg = document.getElementById("oplpg");
	var opsilver = document.getElementById("opsilver");
	var opcash = document.getElementById("opcash");
	
	if(trim(supplierName.value) == ""){
		updateStatus("Please enter a valid supplier name");
		supplierName.focus();
	}else if(trim(oppg.value) == "" ){
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

function prepareParamsToAddSupplier(){
	var params = null;
	var supplierName = document.getElementById("suppliername").value;
	var oppg = document.getElementById("oppg").value;
	var oplpg = document.getElementById("oplpg").value;
	var opsilver = document.getElementById("opsilver").value;
	var opcash = document.getElementById("opcash").value;
	params = "action=add" + "&suppliername=" + supplierName + "&oppg=" + oppg + "&oplpg=" + oplpg + "&opsilver=" + opsilver + "&opcash=" + opcash;
	return params;
}

function prepareParamsToUpdateSupplier(){
	var params = null;
	var supplierId = selectedSupplier;
	var supplierName = document.getElementById("suppliername").value;
	var oppg = document.getElementById("oppg").value;
	var oplpg = document.getElementById("oplpg").value;
	var opsilver = document.getElementById("opsilver").value;
	var opcash = document.getElementById("opcash").value;
	params = "action=modify" + "&supplierid=" + supplierId + "&suppliername=" + supplierName + "&oppg=" + oppg + "&oplpg=" + oplpg + "&opsilver=" + opsilver + "&opcash=" + opcash;
	return params;
}