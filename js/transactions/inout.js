var currentTxnId = 0;
var rowIndex = 0;
var selectRowIndex = 0;

var groupSelectHTML = null;
var itemObj = {};
var subitemObj = {};

var itemsObj = {};
var subitemsObj = {};


function getAllEmployees(){
	var params = "action=GetAllEmployees";
	sendAJAXRequest("/PSS/src/controller/EmployeeController.php",params,"responseGetAllEmployees");
}

function responseGetAllEmployees(responseText, isSuccess){
	if(isSuccess == "true"){
		updateEmployeePanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateEmployeePanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var issuerElement = document.getElementById("issuerList");
	var bearerElement = document.getElementById("bearerList");
	var receiverElement = document.getElementById("receiverList");
	
	var htmlText = "<option value=\"\">" + "-" + "</option>";
	var totalItems = itemsXML.getElementsByTagName('employee').length;
	
	for(var i=0;i<totalItems;i++){
		employeeId = getNodeValue(itemsXML,'employeeid',i);
		employeeName = getNodeValue(itemsXML,'employeename',i);
		
		htmlText = htmlText + "<option value=\"" + employeeId + "\">" + employeeName + "</option>";
	}
	
	issuerElement.innerHTML = htmlText;
	bearerElement.innerHTML = htmlText;
	receiverElement.innerHTML = htmlText;
}

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
	var locationElement = document.getElementById("locationList");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "<option value=\"\">" + "-" + "</option>";
	var totalItems = itemsXML.getElementsByTagName('location').length;
	
	for(var i=0;i<totalItems;i++){
		locationId = getNodeValue(itemsXML,'locationid',i);
		locationName = getNodeValue(itemsXML,'locationname',i);
		
		htmlText = htmlText + "<option value=\"" + locationId + "\">" + locationName + "</option>";
	}
	
	locationElement.innerHTML = htmlText;
}

function getAllItems(){
	var params = "action=GetAllItems";
	sendAJAXRequest("/PSS/src/controller/ItemController.php",params,"responseGetAllItems");
}

function responseGetAllItems(responseText, isSuccess){
	if(isSuccess == "true"){
		var itemsXML = getXMLFromString(responseText);
		
		var itemId = null;
		var itemName = null;
		
		var totalItems = itemsXML.getElementsByTagName('item').length;
		
		for(var i=0;i<totalItems;i++){
			itemId = getNodeValue(itemsXML,'itemid',i);
			itemName = getNodeValue(itemsXML,'itemname',i);
			itemsObj[itemId] = itemName;
		}
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function getAllSubItems(){
	var params = "action=getAllSubitems";
	sendAJAXRequest("/PSS/src/controller/SubItemController.php",params,"responseGetAllSubItems");
}

function responseGetAllSubItems(responseText, isSuccess){
	if(isSuccess == "true"){
		var itemsXML = getXMLFromString(responseText);
		
		var itemId = null;
		var itemName = null;
		
		var totalItems = itemsXML.getElementsByTagName('subitem').length;
		
		for(var i=0;i<totalItems;i++){
			itemId = getNodeValue(itemsXML,'subitemid',i);
			itemName = getNodeValue(itemsXML,'subitemname',i);
			subitemsObj[itemId] = itemName;
		}
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
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

function updateSupplier(){
	var isValid = validateSupplierForm();
	if(isValid == true){
		var params = prepareParamsToUpdateSupplier();
		sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseUpdateSupplier");
	}
}

function responseUpdateSupplier(responseText, isSuccess){
	if(isSuccess == "true"){
		getAllSuppliers();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function addSupplier(){
	var isValid = validateSupplierForm();
	if(isValid == true){
		var params = prepareParamsToAddSupplier();
		sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseAddSupplier");
	}
}

function responseAddSupplier(responseText, isSuccess){
	if(isSuccess == "true"){
		getAllSuppliers();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function validateSupplierForm(){
	return true;
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

function getAllGroups(){
	if(groupSelectHTML == null){
		var params = "action=GetAllGroups";
		sendAJAXRequest("/PSS/src/controller/GroupController.php",params,"responseGetAllGroups");
	}else{
		var selectElement = document.getElementById("group");
		selectElement.innerHTML = groupSelectHTML;
	}
}

function responseGetAllGroups(responseText, isSuccess){
	if(isSuccess == "true"){
		populateGroupSelect(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateGroupSelect(responseText){
	var groupsXML = getXMLFromString(responseText);
	
	var groupId = null;
	var groupName = null;
	
	var htmlText = "";
	var totalItems = groupsXML.getElementsByTagName('itemgroup').length;
	htmlText = "<option value=\"\">-</option>";
	for(var i=0;i<totalItems;i++){
		groupId = getNodeValue(groupsXML,'groupid',i);
		groupName = getNodeValue(groupsXML,'groupname',i);
		
		htmlText = htmlText + "<option value=\"" + groupId + "\">" + groupName + "</option>";
	}
	groupSelectHTML = htmlText;
}

function addRow(){
	var htmlText = "";
	var tableElement = document.getElementById('purchasetable');
	var rowArray = tableElement.getElementsByTagName("tr");
	var lastRowId = null;
	if(rowArray != null){
		lastRowId = rowArray[rowArray.length-1].id;
		if(lastRowId != null && lastRowId.length > 0){
			lastRowId = lastRowId.split("_")[1];
		}else{
			lastRowId = 1;
		}
	}else{
		lastRowId = 1;
	}
	
	lastRowId = parseInt(lastRowId) +1;
	
	rowIndex = lastRowId;
	
	var rowid = "r_" + lastRowId;
	
	
    var row=document.createElement("TR");
    row.setAttribute("id", rowid);
    row.setAttribute("align", "left");
    
    var cellX = document.createElement("TD");
    cellX.setAttribute("align", "left");
    var cellGroup = document.createElement("TD");
    cellGroup.setAttribute("align", "left");
    var cellItem = document.createElement("TD");
    cellItem.setAttribute("align", "left");
    var cellSubItem = document.createElement("TD");
    cellSubItem.setAttribute("align", "left");
    var cellPcs = document.createElement("TD");
    cellPcs.setAttribute("align", "left");
    var cellGwt = document.createElement("TD");
    cellGwt.setAttribute("align", "left");
    var cellNwt = document.createElement("TD");
    cellNwt.setAttribute("align", "left");
    var cell24Ct = document.createElement("TD");
    cell24Ct.setAttribute("align", "left");
    var cellMaintainMetal = document.createElement("TD");
    var cellAmount = document.createElement("TD");
    cellAmount.setAttribute("align", "left");
    
    var txtDelete = document.createElement('input');
    txtDelete.setAttribute("type", "image");
    txtDelete.setAttribute("src", "../images/cross.png");
	txtDelete.setAttribute("onclick", "deleteRow('" + rowid + "')");
	
	selectGroup=document.createElement('select');
	selectGroup.setAttribute("id", "selectGroup" + lastRowId);
	selectGroup.setAttribute("name", "selectGroup");
	selectGroup.setAttribute("class", "select-group");
	selectGroup.setAttribute("onchange","getItemsByGroup(this.value,this.id)");
    
	selectItem=document.createElement('select');
	selectItem.setAttribute("id", "selectItem" + lastRowId);
	selectItem.setAttribute("name", "selectItem");
	selectItem.setAttribute("class", "select-item");
	selectItem.setAttribute("onchange","getSubItems(this.value,this.id)");
	
	selectSubItem=document.createElement('select');
	selectSubItem.setAttribute("id", "selectSubItem" + lastRowId);
	selectSubItem.setAttribute("name", "selectSubItem");
	selectSubItem.setAttribute("class", "select-subitem");
	
	var txtPcs = document.createElement('input');
	txtPcs.setAttribute("type", "text");
	txtPcs.setAttribute("id", "pcs" + lastRowId);
	txtPcs.setAttribute("name", "pcs");
	txtPcs.setAttribute("class", "tblAmountInputField");
	txtPcs.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txtPcs.setAttribute("onkeydown", "keyCheck(event,this)");
	txtPcs.setAttribute("size", "8");
	
	var txtGwt = document.createElement('input');
	txtGwt.setAttribute("type", "text");
	txtGwt.setAttribute("id", "gwt" + lastRowId);
	txtGwt.setAttribute("name", "gwt");
	txtGwt.setAttribute("class", "tblAmountInputField");
	txtGwt.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txtGwt.setAttribute("onkeydown", "keyCheck(event,this)");
	txtGwt.setAttribute("size", "8");
	
	var txtNwt = document.createElement('input');
	txtNwt.setAttribute("type", "text");
	txtNwt.setAttribute("id", "nwt" + lastRowId);
	txtNwt.setAttribute("name", "nwt");
	txtNwt.setAttribute("class", "tblAmountInputField");
	txtNwt.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txtNwt.setAttribute("onkeydown", "keyCheck(event,this)");
	txtNwt.setAttribute("size", "8");
	
	var txt24Ct = document.createElement('input');
	txt24Ct.setAttribute("type", "text");
	txt24Ct.setAttribute("id", "24ctpure" + lastRowId);
	txt24Ct.setAttribute("name", "24ctpure");
	txt24Ct.setAttribute("class", "tblAmountInputField");
	txt24Ct.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txt24Ct.setAttribute("onkeydown", "keyCheck(event,this)");
	txt24Ct.setAttribute("size", "8");
	
	var amount = document.createElement('input');
	amount.setAttribute("type", "text");
	amount.setAttribute("id", "amount" + lastRowId);
	amount.setAttribute("name", "amount");
	amount.setAttribute("class", "tblAmountInputField");
	amount.setAttribute("onkeypress", "return isValidAmount(event,this)");
	amount.setAttribute("onkeydown", "keyCheck(event,this)");
	amount.setAttribute("size", "8");
	
	cellX.appendChild(txtDelete);
	cellGroup.appendChild(selectGroup);
	cellItem.appendChild(selectItem);
	cellSubItem.appendChild(selectSubItem);
	cellPcs.appendChild(txtPcs);
	cellGwt.appendChild(txtGwt);
	cellNwt.appendChild(txtNwt);
	cell24Ct.appendChild(txt24Ct);
	cellAmount.appendChild(amount);
	
	row.appendChild(cellX);
	row.appendChild(cellGroup);
	row.appendChild(cellItem);
	row.appendChild(cellSubItem);
	row.appendChild(cellPcs);
	row.appendChild(cellGwt);
	row.appendChild(cellNwt);
	row.appendChild(cell24Ct);
	row.appendChild(cellAmount);
	
	tableElement.appendChild(row);
	
	var selectGroupObj = document.getElementById('selectGroup' + lastRowId);
	selectGroupObj.innerHTML = groupSelectHTML;
	
	document.getElementById('selectGroup' + lastRowId).focus();
}

function encloseTableData(inStr){
	return "<td>" + inStr + "</td>";
}

function getItemsByGroup(groupId,id){
	selectRowIndex = id.substring(id.length-1,id.length);
	if(itemObj[groupId] == null){
		var params = "action=GetItemsByGroup&groupId=" + groupId;
		sendAJAXRequest("/PSS/src/controller/ItemController.php",params,"responseGetItemsByGroup");
	}else{
		var selectItemObj = document.getElementById('selectItem' + selectRowIndex);
		selectItemObj.innerHTML = itemObj[groupId];
		var selectItemObj = document.getElementById('selectSubItem' + selectRowIndex);
		selectItemObj.innerHTML = "";
	}
	
}

function responseGetItemsByGroup(responseText, isSuccess){
	if(isSuccess == "true"){
		populateSelectItem(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateSelectItem(responseText){
	var itemsXML = getXMLFromString(responseText);
	var selectItemObj = document.getElementById('selectItem' + selectRowIndex);
	
	var itemId = null;
	var itemName = null;
	var parentGroupId = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('item').length;
	htmlText = "<option value=\"\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		itemId = getNodeValue(itemsXML,'itemid',i);
		itemName = getNodeValue(itemsXML,'itemname',i);
		parentGroupId = getNodeValue(itemsXML,'parentgroupid',i);
		
		htmlText = htmlText + "<option value=\"" + itemId + "\">" + itemName + "</option>";
	}
	itemObj[parentGroupId] = htmlText;
	selectItemObj.innerHTML = htmlText;
	
	var selectItemObj = document.getElementById('selectSubItem' + selectRowIndex);
	selectItemObj.innerHTML = "";
}

function getSubItems(itemId,id){
	selectRowIndex = id.substring(id.length-1,id.length);
	if(subitemObj[itemId] == null){
		var params = "action=GetSubItems&itemId=" + itemId;
		sendAJAXRequest("/PSS/src/controller/SubItemController.php",params,"responseGetSubItems");
	}else{
		var selectSubItemObj = document.getElementById('selectSubItem' + selectRowIndex);
		selectSubItemObj.innerHTML = subitemObj[itemId];
	}
}

function responseGetSubItems(responseText, isSuccess){
	if(isSuccess == "true"){
		populateSelectSubItems(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateSelectSubItems(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("selectSubItem" + selectRowIndex);
	
	var itemId = null;
	var itemName = null;
	var parentItemId = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('subitem').length;
	htmlText = "<option value=\"\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		subItemId = getNodeValue(itemsXML,'subitemid',i);
		subItemName = getNodeValue(itemsXML,'subitemname',i);
		parentItemId = getNodeValue(itemsXML,'parentitemid',i);
		
		htmlText = htmlText + "<option value=\"" + subItemId + "\">" + subItemName + "</option>";
	}
	subitemObj[parentItemId] = htmlText;
	divElement.innerHTML = htmlText;
}

function addInOut(){
	var isValid = validateInOutForm();
	if(isValid){
		updateStatus("Processing . . . ");
		var params = prepareParamsToAddInOut();
		sendAJAXRequest("/PSS/src/controller/InOutController.php",params,"responseAddInOut");
	}
}

function responseAddInOut(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("InOut Entry Added Successfully.");
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function validateInOutForm(){
	var isValid = false;
	
	var issuerList = document.getElementById("issuerList");
	var recevierList = document.getElementById("receiverList");
	var bearerList = document.getElementById("bearerList");
	var locationList = document.getElementById("locationList");
	var type = document.getElementById("typeList");
	
	if(issuerList.value == null || trim(issuerList.value).length == 0){
		updateStatus("Please select an issuer");
		issuerList.focus();
	}else if(recevierList.value == null || trim(recevierList.value).length == 0){
		updateStatus("Please select a receiver");
		recevierList.focus();
	}else if(bearerList.value == null || trim(bearerList.value).length == 0){
		updateStatus("Please select a bearer");
		bearerList.focus();
	}else if(locationList.value == null || trim(locationList.value).length == 0){
		updateStatus("Please select a Location");
		locationList.focus();
	}else if(issuerList.value == recevierList.value){
		updateStatus("Isuuer and receiver cannot be same");
		issuerList.focus();
	}else{
		var arrayGroup = document.getElementsByName("selectGroup");
		var arrayItem = document.getElementsByName('selectItem');
		var arraySubItem = document.getElementsByName('selectSubItem');
		var arrayPcs = document.getElementsByName('pcs');
		var arrayGwt = document.getElementsByName('gwt');
		var arrayNwt = document.getElementsByName('nwt');
		var array24Ct = document.getElementsByName('24ctpure');
		var arrayAmount = document.getElementsByName('amount');
		
		var rows = arrayGroup.length;
		
		for(var i=0;i<rows;i++){
			if(arrayGroup[i].value == null || trim(arrayGroup[i].value).length == 0){
				updateStatus("Please select a group");
				arrayGroup[i].focus();
				isValid = false;
				break;
			}else if(arrayItem[i].value == null || trim(arrayItem[i].value).length == 0){
				updateStatus("Please select an item");
				arrayItem[i].focus();
				isValid = false;
				break;
			}else if(arraySubItem[i].value == null || trim(arraySubItem[i].value).length == 0){
				updateStatus("Please select an sub item");
				arraySubItem[i].focus();
				isValid = false;
				break;
			}else if(arrayPcs[i].value == null || trim(arrayPcs[i].value).length == 0){
				updateStatus("Please enter the no of pieces");
				arrayPcs[i].focus();
				isValid = false;
				break;
			}else if(arrayGwt[i].value == null || trim(arrayGwt[i].value).length == 0){
				updateStatus("Please enter the gross weight");
				arrayGwt[i].focus();
				isValid = false;
				break;
			}else if(arrayNwt[i].value == null || trim(arrayNwt[i].value).length == 0){
				updateStatus("Please enter the net weight");
				arrayNwt[i].focus();
				isValid = false;
				break;
			}else if(array24Ct[i].value == null || trim(array24Ct[i].value).length == 0){
				updateStatus("Please enter the 24 ct value");
				array24Ct[i].focus();
				isValid = false;
				break;
			}else if(arrayAmount[i].value == null || trim(arrayAmount[i].value).length == 0){
				updateStatus("Please enter the amount");
				arrayAmount[i].focus();
				isValid = false;
				break;
			}else{
				isValid = true;
			}
		}
		
	}
	return isValid;
}

function prepareParamsToAddInOut(){
	var params = "";
	
	var issuerId = document.getElementById("issuerList").value;
	var receiverId = document.getElementById("receiverList").value;
	var bearerId = document.getElementById("bearerList").value;
	var locationId = document.getElementById("locationList").value;
	var type = document.getElementById("typeList").value;
	
	var productsJSON = getProductsJSON();
	
	params = "action=add" + "&issuerid=" + issuerId + "&receiverid=" + receiverId + "&bearerid=" + bearerId + "&locationid=" + locationId + "&type=" + type + "&jsonProducts=" + productsJSON;
	
	
	return params;
}

function getProductsJSON(){
	var jsonString = "";
	var root = "inout";
	
	var arrayGroup = document.getElementsByName('selectGroup');
	var arrayItem = document.getElementsByName('selectItem');
	var arraySubItem = document.getElementsByName('selectSubItem');
	var arrayPcs = document.getElementsByName('pcs');
	var arrayGwt = document.getElementsByName('gwt');
	var arrayNwt = document.getElementsByName('nwt');
	var array24Ct = document.getElementsByName('24ctpure');
	var arrayAmount = document.getElementsByName('amount');
	
	//if(arrayGroup != null && arrayItem != null && arrayRates != null && arrayBilledQty != null && arrayActualQty!=null && arrayAmounts != null){
		jsonString = jsonString + "{\"root\":";
		jsonString = jsonString + "{\"inout\":[";
		for(var i=0; i<arrayGroup.length; i++){
			//if(arrayProducts[i].value != "" && arrayUOMs[i].value != "" && arrayRates[i].value != "" && arrayActualQty[i].value != "" && arrayBilledQty[i].value != "" && arrayAmounts[i].value != ""){
				jsonString = jsonString + "{";
				jsonString = jsonString + "\"groupid\":" + "\"" + arrayGroup[i].value + "\"";
				jsonString = jsonString + ",\"itemid\":" + "\"" + arrayItem[i].value + "\"";
				jsonString = jsonString + ",\"subitemid\":" + "\"" + arraySubItem[i].value + "\"";
				jsonString = jsonString + ",\"pcs\":" +  "\"" + arrayPcs[i].value + "\"";
				jsonString = jsonString + ",\"gwt\":" +  "\"" + arrayGwt[i].value + "\"";
				jsonString = jsonString + ",\"nwt\":" +  "\"" + arrayNwt[i].value + "\"";
				jsonString = jsonString + ",\"ct\":" +  "\"" + array24Ct[i].value + "\"";
				jsonString = jsonString + ",\"amount\":" + "\"" + arrayAmount[i].value + "\"";
				jsonString = jsonString + "}";
			//}
			if(i !=arrayGroup.length - 1){
				jsonString = jsonString + ",";
			}
		}
		jsonString = jsonString + "]";
		jsonString = jsonString + "}";
		jsonString = jsonString + "}";
	//}
	return jsonString;
}

function getInOutByBillNo(){
	var billnoObj = document.getElementById("voucherno");
	var supplierIdObj = document.getElementById("supplierList");
	var params = "action=getInOut";  
	sendAJAXRequest("/PSS/src/controller/InOutController.php",params,"responseGetInOut");
}
function getInOut(){
	var billnoObj = document.getElementById("inoutno");
	if(trim(billnoObj.value).length == 0 || !isNumber(billnoObj.value)){
		updateStatus("Please enter a valid inout no");
	}else{
		updateStatus("Processing . . . ");
		var params = "action=getInOut" + "&inoutno=" + trim(billnoObj.value);  
		sendAJAXRequest("/PSS/src/controller/InOutController.php",params,"responseGetInOut");
	}
}

function responseGetInOut(responseText, isSuccess){
	if(isSuccess == "true"){
		populateInOutDetails(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateInOutDetails(responseText){
	var maintainAsOptions = "<option value='pg'>PG</option><option value='lpg'>LPG</option><option value='silver'>Silver</option><option value='cash'>Cash</option>";
	var inoutXML = getXMLFromString(responseText);
	if(inoutXML!=null){
		
		var tableElement = document.getElementById("purchasetable");
		var inoutId = getFirstNodeValue(inoutXML,'inoutid');
		currentTxnId = inoutId;
		var date = getFirstNodeValue(inoutXML,'date');
		var issuerId = getFirstNodeValue(inoutXML,'issuerid');
		var receiverId = getFirstNodeValue(inoutXML,'receiverid');
		var bearerId = getFirstNodeValue(inoutXML,'bearerid');
		var locationId = getFirstNodeValue(inoutXML,'locationid');
		var type = getFirstNodeValue(inoutXML,'type');
		
		document.getElementById("date").value = getFormattedDate(date,"-");
		document.getElementById("issuerList").value = issuerId;
		document.getElementById("receiverList").value = receiverId;
		document.getElementById("bearerList").value = bearerId;
		document.getElementById("locationList").value = locationId;
		document.getElementById("typeList").value = type;
		
		deleteAllRows(tableElement);
		
		var listOfProducts = inoutXML.getElementsByTagName('inout' + inoutId);
		var totalProducts = listOfProducts.length;
		
		for(var i=0; i<totalProducts; i++){
			rowid = "r_" + (i+2);
			lastRowId = (i+2);
		    var row=document.createElement("TR");
		    row.setAttribute("id", rowid);
		    row.setAttribute("align", "left");
		    
		    var cellX = document.createElement("TD");
		    cellX.setAttribute("align", "left");
		    var cellGroup = document.createElement("TD");
		    cellGroup.setAttribute("align", "left");
		    var cellItem = document.createElement("TD");
		    cellItem.setAttribute("align", "left");
		    var cellSubItem = document.createElement("TD");
		    cellSubItem.setAttribute("align", "left");
		    var cellPcs = document.createElement("TD");
		    cellPcs.setAttribute("align", "left");
		    var cellGwt = document.createElement("TD");
		    cellGwt.setAttribute("align", "left");
		    var cellNwt = document.createElement("TD");
		    cellNwt.setAttribute("align", "left");
		    var cell24Ct = document.createElement("TD");
		    cell24Ct.setAttribute("align", "left");
		    var cellAmount = document.createElement("TD");
		    cellAmount.setAttribute("align", "left");
		    
		    var txtDelete = document.createElement('input');
		    txtDelete.setAttribute("type", "image");
		    txtDelete.setAttribute("src", "../images/cross.png");
			txtDelete.setAttribute("onclick", "deleteRow('" + rowid + "')");
			
			selectGroup=document.createElement('select');
			selectGroup.setAttribute("id", "selectGroup" + lastRowId);
			selectGroup.setAttribute("name", "selectGroup");
			selectGroup.setAttribute("class", "select-group");
			selectGroup.setAttribute("disabled", "disabled");
			selectGroup.setAttribute("onchange","getItemsByGroup(this.value,this.id)");
		    
			selectItem=document.createElement('select');
			selectItem.setAttribute("id", "selectItem" + lastRowId);
			selectItem.setAttribute("name", "selectItem");
			selectItem.setAttribute("class", "select-item");
			selectItem.setAttribute("disabled", "disabled");
			selectItem.setAttribute("onchange","getSubItems(this.value,this.id)");
			
			selectSubItem=document.createElement('select');
			selectSubItem.setAttribute("id", "selectSubItem" + lastRowId);
			selectSubItem.setAttribute("name", "selectSubItem");
			selectSubItem.setAttribute("disabled", "disabled");
			selectSubItem.setAttribute("class", "select-subitem");
			
			var txtPcs = document.createElement('input');
			txtPcs.setAttribute("type", "text");
			txtPcs.setAttribute("id", "pcs" + lastRowId);
			txtPcs.setAttribute("name", "pcs");
			txtPcs.setAttribute("disabled", "disabled");
			txtPcs.setAttribute("value", listOfProducts[i].getElementsByTagName('pcs')[0].firstChild.nodeValue);
			txtPcs.setAttribute("class", "tblAmountInputField");
			txtPcs.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtPcs.setAttribute("onkeydown", "keyCheck(event,this)");
			txtPcs.setAttribute("size", "8");
			
			var txtGwt = document.createElement('input');
			txtGwt.setAttribute("type", "text");
			txtGwt.setAttribute("id", "gwt" + lastRowId);
			txtGwt.setAttribute("name", "gwt");
			txtGwt.setAttribute("disabled", "disabled");
			txtGwt.setAttribute("value", listOfProducts[i].getElementsByTagName('gwt')[0].firstChild.nodeValue);
			txtGwt.setAttribute("class", "tblAmountInputField");
			txtGwt.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtGwt.setAttribute("onkeydown", "keyCheck(event,this)");
			txtGwt.setAttribute("size", "8");
			
			var txtNwt = document.createElement('input');
			txtNwt.setAttribute("type", "text");
			txtNwt.setAttribute("id", "nwt" + lastRowId);
			txtNwt.setAttribute("name", "nwt");
			txtNwt.setAttribute("disabled", "disabled");
			txtNwt.setAttribute("value", listOfProducts[i].getElementsByTagName('nwt')[0].firstChild.nodeValue);
			txtNwt.setAttribute("class", "tblAmountInputField");
			txtNwt.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtNwt.setAttribute("onkeydown", "keyCheck(event,this)");
			txtNwt.setAttribute("size", "8");
			
			var txt24Ct = document.createElement('input');
			txt24Ct.setAttribute("type", "text");
			txt24Ct.setAttribute("id", "24ctpure" + lastRowId);
			txt24Ct.setAttribute("name", "24ctpure");
			txt24Ct.setAttribute("disabled", "disabled");
			txt24Ct.setAttribute("value", listOfProducts[i].getElementsByTagName('ctpure')[0].firstChild.nodeValue);
			txt24Ct.setAttribute("class", "tblAmountInputField");
			txt24Ct.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txt24Ct.setAttribute("onkeydown", "keyCheck(event,this)");
			txt24Ct.setAttribute("size", "8");
			
			
			var amount = document.createElement('input');
			amount.setAttribute("type", "text");
			amount.setAttribute("id", "amount" + lastRowId);
			amount.setAttribute("name", "amount");
			amount.setAttribute("disabled", "disabled");
			amount.setAttribute("value", listOfProducts[i].getElementsByTagName('amount')[0].firstChild.nodeValue);
			amount.setAttribute("class", "tblAmountInputField");
			amount.setAttribute("onkeypress", "return isValidAmount(event,this)");
			amount.setAttribute("onkeydown", "keyCheck(event,this)");
			amount.setAttribute("size", "8");
			
			cellX.appendChild(txtDelete);
			cellGroup.appendChild(selectGroup);
			cellItem.appendChild(selectItem);
			cellSubItem.appendChild(selectSubItem);
			cellPcs.appendChild(txtPcs);
			cellGwt.appendChild(txtGwt);
			cellNwt.appendChild(txtNwt);
			cell24Ct.appendChild(txt24Ct);
			cellAmount.appendChild(amount);
			
			row.appendChild(cellX);
			row.appendChild(cellGroup);
			row.appendChild(cellItem);
			row.appendChild(cellSubItem);
			row.appendChild(cellPcs);
			row.appendChild(cellGwt);
			row.appendChild(cellNwt);
			row.appendChild(cell24Ct);
			row.appendChild(cellAmount);
			
			tableElement.appendChild(row);
			
			document.getElementById("selectGroup" + lastRowId).innerHTML = groupSelectHTML;
			document.getElementById("selectGroup" + lastRowId).value = listOfProducts[i].getElementsByTagName('groupid')[0].firstChild.nodeValue;
			
			var itemValue = listOfProducts[i].getElementsByTagName('itemid')[0].firstChild.nodeValue;
			document.getElementById("selectItem" + lastRowId).innerHTML = "<option value=\"+itemValue +\">"+ itemsObj[itemValue] + "</option>";
			
			var subitemValue = listOfProducts[i].getElementsByTagName('subitemid')[0].firstChild.nodeValue;
			document.getElementById("selectSubItem" + lastRowId).innerHTML = "<option value=\"+subitemValue +\">"+ subitemsObj[subitemValue] + "</option>";
			
		}
		showEditButtonPanel();
	}
}

function deleteInOut(){
	var isConfirmed = confirm("Are you sure to delete this inout entry?");
	if(isConfirmed){
		updateStatus("Processing . . .");
		var params = "action=delete" + "&txnid=" + currentTxnId;  
		sendAJAXRequest("/PSS/src/controller/InOutController.php",params,"responseDeleteInOut");
	}
}

function responseDeleteInOut(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("InOut Entry Deleted Successfully.");
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}