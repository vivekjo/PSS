var currentTxnId = 0;
var rowIndex = 0;
var selectRowIndex = 0;

var groupSelectHTML = null;
var itemObj = {};
var subitemObj = {};

var itemsObj = {};
var subitemsObj = {};
var currentRowId = 0;

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
	
	var maintainAsOptions = "<option value='pg'>PG</option><option value='lpg'>LPG</option><option value='silver'>Silver</option><option value='cash'>Cash</option>";
	
    var row=document.createElement("TR");
    row.setAttribute("id", rowid);
    row.setAttribute("name", "row");
    row.setAttribute("align", "left");
    
//    var cellPurchaseDetailId = document.createElement("TD");
//    cellPurchaseDetailId.setAttribute("align", "left");
//    
    var cellX = document.createElement("TD");
    cellX.setAttribute("align", "left");
    var cellGroup = document.createElement("TD");
    cellGroup.setAttribute("align", "left");
    var cellItem = document.createElement("TD");
    cellItem.setAttribute("align", "left");
    var cellSubItem = document.createElement("TD");
    cellSubItem.setAttribute("align", "left");
    var cellGwt = document.createElement("TD");
    cellGwt.setAttribute("align", "left");
    var cellNwt = document.createElement("TD");
    cellNwt.setAttribute("align", "left");
    var cell24Ct = document.createElement("TD");
    cell24Ct.setAttribute("align", "left");
    var cellMaintainMetal = document.createElement("TD");
    cellMaintainMetal.setAttribute("align", "left");
    var cellMC = document.createElement("TD");
    cellMC.setAttribute("align", "left");
    var cellMaintainMC = document.createElement("TD");
    cellMaintainMC.setAttribute("align", "left");
    var cellPayment = document.createElement("TD");
    cellPayment.setAttribute("align", "left");
    
    
    var txtPurchaseDetailId = document.createElement('input');
    txtPurchaseDetailId.setAttribute("type", "text");
    txtPurchaseDetailId.setAttribute("id", "purchasedetailsid" + lastRowId);
    txtPurchaseDetailId.setAttribute("name", "purchasedetailsid");
    txtPurchaseDetailId.setAttribute("disabled", "disabled");
	txtPurchaseDetailId.setAttribute("visibility", "hidden");
    txtPurchaseDetailId.setAttribute("size", "1");
    
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
	txtNwt.setAttribute("onchange","silverTypeControl('" + rowid + "',selectMaintainMetal.value)");
	txtNwt.setAttribute("size", "8");
	
	var txt24Ct = document.createElement('input');
	txt24Ct.setAttribute("type", "text");
	txt24Ct.setAttribute("id", "24ctpure" + lastRowId);
	txt24Ct.setAttribute("name", "24ctpure");
	txt24Ct.setAttribute("class", "tblAmountInputField");
	txt24Ct.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txt24Ct.setAttribute("onkeydown", "keyCheck(event,this)");
	txt24Ct.setAttribute("size", "8");
	
	var selectMaintainMetal = document.createElement('select');
	selectMaintainMetal.setAttribute("id", "selectMaintainMetal" + lastRowId);
	selectMaintainMetal.setAttribute("name", "selectMaintainMetal");
	selectMaintainMetal.setAttribute("onchange","silverTypeControl('" + rowid + "',this.value)");
	
	
	var MC = document.createElement('input');
	MC.setAttribute("type", "text");
	MC.setAttribute("id", "mc" + lastRowId);
	MC.setAttribute("name", "mc");
	MC.setAttribute("class", "tblAmountInputField");
	MC.setAttribute("onkeypress", "return isValidAmount(event,this)");
	MC.setAttribute("onkeydown", "keyCheck(event,this)");
	MC.setAttribute("size", "8");
	
	selectMaintainMC=document.createElement('select');
	selectMaintainMC.setAttribute("id", "selectMaintainMC" + lastRowId);
	selectMaintainMC.setAttribute("name", "selectMaintainMC");
	
	var noOfDays = document.createElement('input');
	noOfDays.setAttribute("type", "text");
	noOfDays.setAttribute("id", "noOfDays" + lastRowId);
	noOfDays.setAttribute("name", "noOfDays");
	noOfDays.setAttribute("class", "tblAmountInputField");
	noOfDays.setAttribute("onkeypress", "return isValidAmount(event,this)");
	noOfDays.setAttribute("onkeydown", "keyCheck(event,this)");
	noOfDays.setAttribute("size", "8");
	
//	cellPurchaseDetailId.appendChild(txtPurchaseDetailId);
//	cellX.appendChild(txtPurchaseDetailId);
	cellX.appendChild(txtDelete);
	cellGroup.appendChild(selectGroup);
	cellItem.appendChild(selectItem);
	cellSubItem.appendChild(selectSubItem);
	cellGwt.appendChild(txtGwt);
	cellNwt.appendChild(txtNwt);
	cell24Ct.appendChild(txt24Ct);
	cellMaintainMetal.appendChild(selectMaintainMetal);
	cellMC.appendChild(MC);
	cellMaintainMC.appendChild(selectMaintainMC);
	cellPayment.appendChild(noOfDays);
	
//	row.appendChild(cellPurchaseDetailId);
	row.appendChild(cellX);
	row.appendChild(cellGroup);
	row.appendChild(cellItem);
	row.appendChild(cellSubItem);
	row.appendChild(cellGwt);
	row.appendChild(cellNwt);
	row.appendChild(cell24Ct);
	row.appendChild(cellMaintainMetal);
	row.appendChild(cellMC);
	row.appendChild(cellMaintainMC);
	row.appendChild(cellPayment);
	
	tableElement.appendChild(row);
	
	var selectGroupObj = document.getElementById('selectGroup' + lastRowId);
	selectGroupObj.innerHTML = groupSelectHTML;
	
	var selectMaintianMetalObj = document.getElementById('selectMaintainMetal' + lastRowId);
	selectMaintianMetalObj.innerHTML = maintainAsOptions;
	
	var selectMaintianMCObj = document.getElementById('selectMaintainMC' + lastRowId);
	selectMaintianMCObj.innerHTML = maintainAsOptions;
	
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

function updatePurchase(){
	var isValid = validatePurchaseForm();
	if(isValid){
		updateStatus("Processing . . . ");
		var params = prepareParamsToUpdatePurchase();
		sendAJAXRequest("/PSS/src/controller/PurchaseController.php",params,"responseUpdatePurchase");
	}
}
function responseUpdatePurchase(responseText, isSuccess){
	if(isSuccess == "true"){
		purchaseXML = getXMLFromString(responseText);
		updateStatus("Purchase Entry Modified Successfully");
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function addPurchase(){
	var isValid = validatePurchaseForm();
	if(isValid){
		updateStatus("Processing . . . ");
		var params = prepareParamsToAddPurchase();
		sendAJAXRequest("/PSS/src/controller/PurchaseController.php",params,"responseAddPurchase");
	}
}

function responseAddPurchase(responseText, isSuccess){
	if(isSuccess == "true"){
		purchaseXML = getXMLFromString(responseText);
		var billNo = getFirstNodeValue(purchaseXML,'txnid');
		updateProminentStatus("Purchase Entry Added Successfully. <br/> Bill No : " + billNo + "<br/><br/>" + "<a href='#' onclick='hidemsg()'>close</a>");
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function validatePurchaseForm(){
	var isValid = false;
	var date = document.getElementById("date");
	var supplierList = document.getElementById("supplierList");
	var voucherno = document.getElementById("voucherno");
	
	if(date.value == null || trim(date.value).length == 0){
		updateStatus("Please enter a valid date");
		date.focus();
	}else if(supplierList.value == null || trim(supplierList.value).length == 0){
		updateStatus("Please select a supplier");
		supplierList.focus();
	}else{
		
		var arrayGroup = document.getElementsByName("selectGroup");
		var arrayItem = document.getElementsByName('selectItem');
		var arraySubItem = document.getElementsByName('selectSubItem');
		var arrayGwt = document.getElementsByName('gwt');
		var arrayNwt = document.getElementsByName('nwt');
		var array24Ct = document.getElementsByName('24ctpure');
		var arrayMaintainMetalAs = document.getElementsByName('selectMaintainMetal');
		//var arrayMaintainMetalValue = document.getElementsByName('maintainMetalValue');
		var arrayMC = document.getElementsByName('mc');
		var arrayMaintainMCAs = document.getElementsByName('selectMaintainMC');
		//var arrayMaintainMCValue = document.getElementsByName('maintainMCValue');
		var arrayPaymentDays = document.getElementsByName('noOfDays');
		
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
			}else if(arrayMaintainMetalAs[i].value == null || trim(arrayMaintainMetalAs[i].value).length == 0){
				updateStatus("Please select the maintain metal as option");
				arrayMaintainMetalAs[i].focus();
				isValid = false;
				break;
			}else if(arrayMC[i].value == null || trim(arrayMC[i].value).length == 0){
				updateStatus("Please enter the making charges value");
				arrayMC[i].focus();
				isValid = false;
				break;
			}else if(arrayMaintainMCAs[i].value == null || trim(arrayMaintainMCAs[i].value).length == 0){
				updateStatus("Please select the maintain MC as option");
				arrayMaintainMCAs[i].focus();
				isValid = false;
				break;
			}else if(arrayPaymentDays[i].value == null || trim(arrayPaymentDays[i].value).length == 0){
				updateStatus("Please enter the No of days for Payment");
				arrayPaymentDays[i].focus();
				isValid = false;
				break;
			}else{
				isValid = true;
			}
		}
		
	}
	return isValid;
}

function prepareParamsToUpdatePurchase(){
	var params = "";
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var productsJSONForUpadte = getProductsJSONForUpdate();	
	params = "action=update" + "&date=" + date +"&jsonProductsforupdate=" + productsJSONForUpadte;
	return params;
}

function prepareParamsToAddPurchase(){
	var params = "";
	
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var supplierId = document.getElementById("supplierList").value;

	var productsJSON = getProductsJSON();
	
	params = "action=add" + "&date=" + date + "&supplierid=" + supplierId + "&jsonProducts=" + productsJSON;
	
	
	return params;
}

function getProductsJSONForUpdate(){
	var jsonString = "";
	var root = "purchase";
	
//	var arrayPurchaseDetailsId = document.getElementsByName('purchasedetailsid');
	var arrayPaymentDays = document.getElementsByName('noOfDays');
 	var arrayRows = document.getElementsByName('row');
	
	//if(arrayGroup != null && arrayItem != null && arrayRates != null && arrayBilledQty != null && arrayActualQty!=null && arrayAmounts != null){
	jsonString = jsonString + "{\"root\":";
	jsonString = jsonString + "{\"purchase\":[";
	for(var i=0; i<arrayRows.length; i++){
		jsonString = jsonString + "{";
		jsonString = jsonString + "\"purchasedetailsid\":" + "\"" + arrayRows[i].id + "\"";
		jsonString = jsonString + ",\"paymentdays\":" + "\"" + arrayPaymentDays[i].value + "\"";
		jsonString = jsonString + "}";
		if(i !=arrayRows.length - 1){
			jsonString = jsonString + ",";
		}
	}
	jsonString = jsonString + "]";
	jsonString = jsonString + "}";
	jsonString = jsonString + "}";
	//}
	return jsonString;
}
function getProductsJSON(){
	var jsonString = "";
	var root = "purchase";
	
	var arrayGroup = document.getElementsByName('selectGroup');
	var arrayItem = document.getElementsByName('selectItem');
	var arraySubItem = document.getElementsByName('selectSubItem');
	var arrayGwt = document.getElementsByName('gwt');
	var arrayNwt = document.getElementsByName('nwt');
	var array24Ct = document.getElementsByName('24ctpure');
	var arrayMaintainMetalAs = document.getElementsByName('selectMaintainMetal');
	//var arrayMaintainMetalValue = document.getElementsByName('maintainMetalValue');
	var arrayMC = document.getElementsByName('mc');
	var arrayMaintainMCAs = document.getElementsByName('selectMaintainMC');
	//var arrayMaintainMCValue = document.getElementsByName('maintainMCValue');
	var arrayPaymentDays = document.getElementsByName('noOfDays');
	
	//if(arrayGroup != null && arrayItem != null && arrayRates != null && arrayBilledQty != null && arrayActualQty!=null && arrayAmounts != null){
		jsonString = jsonString + "{\"root\":";
		jsonString = jsonString + "{\"purchase\":[";
		for(var i=0; i<arrayGroup.length; i++){
			//if(arrayProducts[i].value != "" && arrayUOMs[i].value != "" && arrayRates[i].value != "" && arrayActualQty[i].value != "" && arrayBilledQty[i].value != "" && arrayAmounts[i].value != ""){
				jsonString = jsonString + "{";
				jsonString = jsonString + "\"groupid\":" + "\"" + arrayGroup[i].value + "\"";
				jsonString = jsonString + ",\"itemid\":" + "\"" + arrayItem[i].value + "\"";
				jsonString = jsonString + ",\"subitemid\":" + "\"" + arraySubItem[i].value + "\"";
				jsonString = jsonString + ",\"gwt\":" +  "\"" + arrayGwt[i].value + "\"";
				jsonString = jsonString + ",\"nwt\":" +  "\"" + arrayNwt[i].value + "\"";
				jsonString = jsonString + ",\"ct\":" +  "\"" + array24Ct[i].value + "\"";
				jsonString = jsonString + ",\"maintainmetalas\":" + "\"" + arrayMaintainMetalAs[i].value + "\"";
				//jsonString = jsonString + ",\"discamt\":" + arrayDiscAmt[i].value;
				jsonString = jsonString + ",\"mc\":" + "\"" + arrayMC[i].value + "\"";
				jsonString = jsonString + ",\"maintainmc\":"  + "\""+ arrayMaintainMCAs[i].value + "\"";
				//jsonString = jsonString + ",\"total\":" + arrayTotal[i].value;
				jsonString = jsonString + ",\"paymentdays\":" + "\"" + arrayPaymentDays[i].value + "\"";
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

function getPurchaseByBillNo(){
	var billnoObj = document.getElementById("voucherno");
	var supplierIdObj = document.getElementById("supplierList");
	var params = "action=getPurchase";  
	sendAJAXRequest("/PSS/src/controller/PurchaseController.php",params,"responseGetPurchase");
}
function getPurchase(){
	var billnoObj = document.getElementById("voucherno");
	var supplierIdObj = document.getElementById("supplierList");
	if(trim(billnoObj.value).length == 0 || !isNumber(billnoObj.value)){
		updateStatus("Please enter a bill no");
	}else if(trim(supplierIdObj.value).length == 0){
		updateStatus("Please select a supplier");
	}else{
		updateStatus("Processing . . . ");
		var params = "action=getPurchase" + "&billno=" + trim(billnoObj.value) + "&supplierid=" + trim(supplierIdObj.value);  
		sendAJAXRequest("/PSS/src/controller/PurchaseController.php",params,"responseGetPurchase");
	}
}

function responseGetPurchase(responseText, isSuccess){
	if(isSuccess == "true"){
		populatePurchaseDetails(responseText);
		hidemsg();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		clearForm();
	}
}

function populatePurchaseDetails(responseText){
	var maintainAsOptions = "<option value='pg'>PG</option><option value='lpg'>LPG</option><option value='silver'>Silver</option><option value='cash'>Cash</option>";
	var purchaseXML = getXMLFromString(responseText);
	if(purchaseXML!=null){
		
		var tableElement = document.getElementById("purchasetable");
		var txnId = getFirstNodeValue(purchaseXML,'txnid');
		currentTxnId = txnId;
		var date = getFirstNodeValue(purchaseXML,'date');
		var supplierId = getFirstNodeValue(purchaseXML,'supplierid');
		var billNo = getFirstNodeValue(purchaseXML,'billno');
		
		document.getElementById("date").value = getFormattedDate(date,"-");
		document.getElementById("supplierList").value = supplierId;
		document.getElementById("voucherno").value = billNo;
		document.getElementById("date").disabled = "false";
		document.getElementById("supplierList").disabled = "false";
		
		deleteAllRows(tableElement);
		
		var listOfProducts = purchaseXML.getElementsByTagName('product' + txnId);
		var totalProducts = listOfProducts.length;
		
		for(var i=0; i<totalProducts; i++){
			rowid = listOfProducts[i].getElementsByTagName('purchasedetailsid')[0].firstChild.nodeValue;
			lastRowId = listOfProducts[i].getElementsByTagName('purchasedetailsid')[0].firstChild.nodeValue;

			var row=document.createElement("TR");
		    row.setAttribute("id", rowid);
		    row.setAttribute("name", "row");
		    row.setAttribute("align", "left");
		    
		    var cellPurchaseDetailId = document.createElement("TD");
		    cellPurchaseDetailId.setAttribute("align", "left");
		    
		    var cellX = document.createElement("TD");
		    cellX.setAttribute("align", "left");
		    var cellGroup = document.createElement("TD");
		    cellGroup.setAttribute("align", "left");
		    var cellItem = document.createElement("TD");
		    cellItem.setAttribute("align", "left");
		    var cellSubItem = document.createElement("TD");
		    cellSubItem.setAttribute("align", "left");
		    var cellGwt = document.createElement("TD");
		    cellGwt.setAttribute("align", "left");
		    var cellNwt = document.createElement("TD");
		    cellNwt.setAttribute("align", "left");
		    var cell24Ct = document.createElement("TD");
		    cell24Ct.setAttribute("align", "left");
		    var cellMaintainMetal = document.createElement("TD");
		    cellMaintainMetal.setAttribute("align", "left");
		    var cellMC = document.createElement("TD");
		    cellMC.setAttribute("align", "left");
		    var cellMaintainMC = document.createElement("TD");
		    cellMaintainMC.setAttribute("align", "left");
		    var cellPayment = document.createElement("TD");
		    cellPayment.setAttribute("align", "left");
		    
		    
		    
		    var txtPurchaseDetailId = document.createElement('input');
		    txtPurchaseDetailId.setAttribute("type", "text");
		    txtPurchaseDetailId.setAttribute("id", "purchasedetailsid" + lastRowId);
		    txtPurchaseDetailId.setAttribute("name", "purchasedetailsid");
		    txtPurchaseDetailId.setAttribute("disabled", "disabled");
			txtPurchaseDetailId.setAttribute("visibility", "hidden");
		    txtPurchaseDetailId.setAttribute("value", listOfProducts[i].getElementsByTagName('purchasedetailsid')[0].firstChild.nodeValue);
		    txtPurchaseDetailId.setAttribute("size", "1");
			 
		    
		    var txtDelete = document.createElement('input');
		    txtDelete.setAttribute("type", "image");
		    txtDelete.setAttribute("src", "../images/cross.png");
		    txtDelete.setAttribute("disabled", "disabled");
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
			
			selectMaintainMetal=document.createElement('select');
			selectMaintainMetal.setAttribute("id", "selectMaintainMetal" + lastRowId);
			selectMaintainMetal.setAttribute("name", "selectMaintainMetal");
			selectMaintainMetal.setAttribute("disabled", "disabled");
			
			var MC = document.createElement('input');
			MC.setAttribute("type", "text");
			MC.setAttribute("id", "mc" + lastRowId);
			MC.setAttribute("name", "mc");
			MC.setAttribute("disabled", "disabled");
			MC.setAttribute("value", listOfProducts[i].getElementsByTagName('mc')[0].firstChild.nodeValue);
			MC.setAttribute("class", "tblAmountInputField");
			MC.setAttribute("onkeypress", "return isValidAmount(event,this)");
			MC.setAttribute("onkeydown", "keyCheck(event,this)");
			MC.setAttribute("size", "8");
			
			selectMaintainMC=document.createElement('select');
			selectMaintainMC.setAttribute("id", "selectMaintainMC" + lastRowId);
			selectMaintainMC.setAttribute("name", "selectMaintainMC");
			selectMaintainMC.setAttribute("disabled", "disabled");
			
			var noOfDays = document.createElement('input');
			noOfDays.setAttribute("type", "text");
			noOfDays.setAttribute("id", "noOfDays" + lastRowId);
			noOfDays.setAttribute("name", "noOfDays");
//			noOfDays.setAttribute("disabled", "true");
			noOfDays.setAttribute("value", listOfProducts[i].getElementsByTagName('paymentdays')[0].firstChild.nodeValue);
			noOfDays.setAttribute("class", "tblAmountInputField");
			noOfDays.setAttribute("onkeypress", "return isValidAmount(event,this)");
			noOfDays.setAttribute("onkeydown", "keyCheck(event,this)");
			noOfDays.setAttribute("size", "8");
			
//			cellPurchaseDetailId.appendChild(txtPurchaseDetailId);
//			cellX.appendChild(txtPurchaseDetailId);
			cellX.appendChild(txtDelete);
			cellGroup.appendChild(selectGroup);
			cellItem.appendChild(selectItem);
			cellSubItem.appendChild(selectSubItem);
			cellGwt.appendChild(txtGwt);
			cellNwt.appendChild(txtNwt);
			cell24Ct.appendChild(txt24Ct);
			cellMaintainMetal.appendChild(selectMaintainMetal);
			cellMC.appendChild(MC);
			cellMaintainMC.appendChild(selectMaintainMC);
			cellPayment.appendChild(noOfDays);
			
//			row.appendChild(cellPurchaseDetailId);
			row.appendChild(cellX);
			row.appendChild(cellGroup);
			row.appendChild(cellItem);
			row.appendChild(cellSubItem);
			row.appendChild(cellGwt);
			row.appendChild(cellNwt);
			row.appendChild(cell24Ct);
			row.appendChild(cellMaintainMetal);
			row.appendChild(cellMC);
			row.appendChild(cellMaintainMC);
			row.appendChild(cellPayment);
			
			tableElement.appendChild(row);
			
			document.getElementById("selectGroup" + lastRowId).innerHTML = groupSelectHTML;
			document.getElementById("selectGroup" + lastRowId).value = listOfProducts[i].getElementsByTagName('groupid')[0].firstChild.nodeValue;
			
			var itemValue = listOfProducts[i].getElementsByTagName('itemid')[0].firstChild.nodeValue;
			document.getElementById("selectItem" + lastRowId).innerHTML = "<option value=\"+itemValue +\">"+ itemsObj[itemValue] + "</option>";
			
			var subitemValue = listOfProducts[i].getElementsByTagName('subitemid')[0].firstChild.nodeValue;
			document.getElementById("selectSubItem" + lastRowId).innerHTML = "<option value=\"+subitemValue +\">"+ subitemsObj[subitemValue] + "</option>";
			
			document.getElementById("selectMaintainMC" + lastRowId).innerHTML = maintainAsOptions;
			document.getElementById("selectMaintainMC" + lastRowId).value = listOfProducts[i].getElementsByTagName('maintainmcas')[0].firstChild.nodeValue;
			document.getElementById("selectMaintainMetal" + lastRowId).innerHTML = maintainAsOptions;
			document.getElementById("selectMaintainMetal" + lastRowId).value = listOfProducts[i].getElementsByTagName('maintainmetalas')[0].firstChild.nodeValue;
		}
		showEditButtonPanel();
		
	}
}

function deletePurchase(){
	var isConfirmed = confirm("Are you sure to delete this purchase?");
	if(isConfirmed){
		updateStatus("Processing . . .");
		var supplierId = trim(document.getElementById("supplierList").value);
		var params = "action=delete" + "&txnid=" + currentTxnId + "&supplierid=" + supplierId;  
		sendAJAXRequest("/PSS/src/controller/PurchaseController.php",params,"responseDeletePurchase");
	}
}

function responseDeletePurchase(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Purchase Deleted Successfully.");
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function showWindow(){
	var divElement = document.getElementById("newProductDiv");
	divElement.style.display = "block";
	getAllRates();
}

function updateWindowStatus(statusMsg){
	if(tmpTimeOut != null){
		clearTimeout(tmpTimeOut);
	}
	var windowStatusDiv = document.getElementById("window-status-div");
	windowStatusDiv.innerHTML = "<font color=\"red\">" + statusMsg + "</font>";
	tmpTimeOut = setTimeout('clearWindowStatus()',5000);
}
function closeNewTypeWindow(){
	var divElement = document.getElementById("newProductDiv");
	divElement.style.display = "none";
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


function convertValue(){
	var transferFrom = "silver";
	var transferTo = "pg";
	var transferAmount = getFormattedNo(trim(document.getElementById("nwt"+currentRowId).value),3);
	//alert(transferAmount);
	if(transferAmount ==  "0.000"){
		updateStatus("Nwt Should Not Be Empty");
	}else{
		var params = "action=convertMetal" + "&transferfrom=" + transferFrom + "&transferto=" + transferTo + "&amount=" + transferAmount;
//		alert(params);
		sendAJAXRequest("/PSS/src/controller/PaymentController.php",params,"responseConvertValue");
	}
	
}

function responseConvertValue(responseText,isSuccess){
	if(isSuccess == "true"){
		var transferedAmount = document.getElementById("24ctpure"+currentRowId);
		var response = responseText.replace("<response>","");
		response = response.replace("</response>","");
		transferedAmount.value = getFormattedNo(response,3);
		currentRowId = 0;
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function silverTypeControl(rowId,value){
	currentRowId = rowId.split("_")[1];
// 	alert(currentRowId);
//  	alert(value);
	var selectMaintainMetalElement = document.getElementById("selectMaintainMetal"+currentRowId);
	var ctpureElement = document.getElementById("24ctpure"+currentRowId);
	var nwtElement = document.getElementById("nwt"+currentRowId);
	if(value == 'silver'){
		convertValue(currentRowId);
		ctpureElement.setAttribute("disabled", "disabled");
	}else{
		ctpureElement.disabled = false;
		ctpureElement.value = nwtElement.value;
	}
	
}