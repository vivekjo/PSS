var currentTxnId = 0;
var rowIndex = 0;
var selectRowIndex = 0;

var groupSelectHTML = null;
var itemObj = {};
var subitemObj = {};

var itemsObj = {};
var subitemsObj = {};


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
	var tableElement = document.getElementById('newarrivaltable');
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
    var cellGms = document.createElement("TD");
    cellGms.setAttribute("align", "left");

    var cellPcs = document.createElement("TD");    
    cellPcs.setAttribute("align", "left");
    
    var cellSize = document.createElement("TD");
    cellSize.setAttribute("align", "left");
    
    var cellMC = document.createElement("TD");
    cellMC.setAttribute("align", "left");
    
    var cellStone = document.createElement("TD");
    cellStone.setAttribute("align", "left");
   
    var cellTotalAmount = document.createElement("TD");
    cellTotalAmount.setAttribute("align", "left");
    
    var cellNoOfDays = document.createElement("TD");
    cellNoOfDays.setAttribute("align", "left");
  
    var cellDescription = document.createElement("TD");
    cellDescription.setAttribute("align", "left");
    
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
	
	var txtGms = document.createElement('input');
	txtGms.setAttribute("type", "text");
	txtGms.setAttribute("id", "gms" + lastRowId);
	txtGms.setAttribute("name", "gms");
	txtGms.setAttribute("class", "tblAmountInputField");
	txtGms.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txtGms.setAttribute("onkeydown", "keyCheck(event,this)");
	txtGms.setAttribute("size", "8");
	
	
	var txtPcs = document.createElement('input');
	txtPcs.setAttribute("type", "text");
	txtPcs.setAttribute("id", "pcs" + lastRowId);
	txtPcs.setAttribute("name", "pcs");
	txtPcs.setAttribute("class", "tblAmountInputField");
	txtPcs.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txtPcs.setAttribute("onkeydown", "keyCheck(event,this)");
	txtPcs.setAttribute("size", "8");
	
	var txtSize = document.createElement('input');
	txtSize.setAttribute("type", "text");
	txtSize.setAttribute("id", "size" + lastRowId);
	txtSize.setAttribute("name", "size");
	txtSize.setAttribute("class", "tblAmountInputField");
	txtSize.setAttribute("onkeypress", "return isValidAmount(event,this)");
	txtSize.setAttribute("onkeydown", "keyCheck(event,this)");
	txtSize.setAttribute("size", "8");
	
 
	var MC = document.createElement('input');
	MC.setAttribute("type", "text");
	MC.setAttribute("id", "mc" + lastRowId);
	MC.setAttribute("name", "mc");
	MC.setAttribute("class", "tblAmountInputField");
	MC.setAttribute("onkeypress", "return isValidAmount(event,this)");
	MC.setAttribute("onkeydown", "keyCheck(event,this)");
	MC.setAttribute("size", "8");
	
	
	var Stone = document.createElement('input');
	Stone.setAttribute("type", "text");
	Stone.setAttribute("id", "stone" + lastRowId);
	Stone.setAttribute("name", "stone");
	Stone.setAttribute("class", "tblAmountInputField");
	Stone.setAttribute("onkeypress", "return isValidAmount(event,this)");
	Stone.setAttribute("onkeydown", "keyCheck(event,this)");
	Stone.setAttribute("size", "8");
	
	var TotalAmount = document.createElement('input');
	TotalAmount.setAttribute("type", "text");
	TotalAmount.setAttribute("id", "totalAmount" + lastRowId);
	TotalAmount.setAttribute("name", "totalAmount");
	TotalAmount.setAttribute("class", "tblAmountInputField");
	TotalAmount.setAttribute("onkeypress", "return isValidAmount(event,this)");
	TotalAmount.setAttribute("onkeydown", "keyCheck(event,this)");
	TotalAmount.setAttribute("size", "8");
	
	 
	var NoOfDays = document.createElement('input');
	NoOfDays.setAttribute("type", "text");
	NoOfDays.setAttribute("id", "noOfDays" + lastRowId);
	NoOfDays.setAttribute("name", "noOfDays");
	NoOfDays.setAttribute("class", "tblAmountInputField");
	NoOfDays.setAttribute("onkeypress", "return isValidAmount(event,this)");
	NoOfDays.setAttribute("onkeydown", "keyCheck(event,this)");
	NoOfDays.setAttribute("size", "8");
	
	var Description = document.createElement('input');
	Description.setAttribute("type", "text");
	Description.setAttribute("id", "description" + lastRowId);
	Description.setAttribute("name", "description");
	Description.setAttribute("class", "tblAmountInputField");
	Description.setAttribute("onkeypress", "return isValidAmount(event,this)");
	Description.setAttribute("onkeydown", "keyCheck(event,this)");
	Description.setAttribute("size", "8");
	
	cellX.appendChild(txtDelete);
	cellGroup.appendChild(selectGroup);
	cellItem.appendChild(selectItem);
	cellSubItem.appendChild(selectSubItem);
	cellGms.appendChild(txtGms);
	cellPcs.appendChild(txtPcs);
	cellSize.appendChild(txtSize);
	cellMC.appendChild(MC);
	cellStone.appendChild(Stone);	
	cellTotalAmount.appendChild(TotalAmount);
	cellNoOfDays.appendChild(NoOfDays);
	cellDescription.appendChild(Description);
	
	row.appendChild(cellX);
	row.appendChild(cellGroup);
	row.appendChild(cellItem);
	row.appendChild(cellSubItem);
	row.appendChild(cellGms);
	row.appendChild(cellPcs);
	row.appendChild(cellSize);
	row.appendChild(cellMC);
	row.appendChild(cellStone);
	row.appendChild(cellTotalAmount);
	row.appendChild(cellNoOfDays);
	row.appendChild(cellDescription);
	
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

function addNewArrival(){
	var isValid = validateNewarrivalForm();
	if(isValid){
		updateStatus("Processing . . . ");
		var params = prepareParamsToAddNewarrival();
		sendAJAXRequest("/PSS/src/controller/NewarrivalController.php",params,"responseAddNewarrival");
	}
}

function responseAddNewarrival(responseText, isSuccess){
//	alert(responseText);
	if(isSuccess == "true"){
		newarrivalXML = getXMLFromString(responseText);
		updateStatus("Newarrival Entry Added Successfully.");
		var newId = getFirstNodeValue(newarrivalXML,'newarrivalId');
		updateProminentStatus("Newarrival Entry Added Successfully. <br/> Newarrival Id : " + newId + "<br/><br/>" + "<a href='#' onclick='hidemsg()'>close</a>");
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function validateNewarrivalForm(){
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
		var arrayGms = document.getElementsByName('gms');
		var arrayPcs = document.getElementsByName('pcs');
		var arraySize = document.getElementsByName('size');
		var arrayMC = document.getElementsByName('mc');
		var arrayStoneAs = document.getElementsByName('stone');
		//var arrayStoneValue = document.getElementsByName('maintainMetalValue');
		
		var arrayTotalAmountAs = document.getElementsByName('totalAmount');
		//var arrayTotalAmountValue = document.getElementsByName('maintainMCValue');
		var arrayNoOfDays = document.getElementsByName('noOfDays');
		var arrayDescription = document.getElementsByName('description');
		
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
			}else if(arrayGms[i].value == null || trim(arrayGms[i].value).length == 0){
				updateStatus("Please enter the gms");
				arrayGms[i].focus();
				isValid = false;
				break;
			}else if(arrayPcs[i].value == null || trim(arrayPcs[i].value).length == 0){
				updateStatus("Please enter the pcs");
				arrayPcs[i].focus();
				isValid = false;
				break;
			}else if(arraySize[i].value == null || trim(arraySize[i].value).length == 0){
				updateStatus("Please enter the Size");
				arraySize[i].focus();
				isValid = false;
				break;
			}else if(arrayStoneAs[i].value == null || trim(arrayStoneAs[i].value).length == 0){
				updateStatus("Please enter the Stone");
				arrayStoneAs[i].focus();
				isValid = false;
				break;
			}else if(arrayMC[i].value == null || trim(arrayMC[i].value).length == 0){
				updateStatus("Please enter the making charges value");
				arrayMC[i].focus();
				isValid = false;
				break;
			}else if(arrayTotalAmountAs[i].value == null || trim(arrayTotalAmountAs[i].value).length == 0){
				updateStatus("Please enter the TotalAmount ");
				arrayTotalAmountAs[i].focus();
				isValid = false;
				break;
			}else if(arrayNoOfDays[i].value == null || trim(arrayNoOfDays[i].value).length == 0){
				updateStatus("Please enter the No of days for Payment");
				arrayNoOfDays[i].focus();
				isValid = false;
				break;
			}else if(arrayDescription[i].value == null || trim(arrayDescription[i].value).length == 0){
				updateStatus("Please enter the Description");
				arrayDescription[i].focus();
				isValid = false;
				break;
			}else{
				isValid = true;
			}
		}
		
	}
	return isValid;
}

function prepareParamsToAddNewarrival(){
	var params = "";
	
	var date = getFormattedDate(document.getElementById("date").value,"/");
	var supplierId = document.getElementById("supplierList").value;
	//var billNo = document.getElementById("voucherno").value;
	
	var productsJSON = getProductsJSON();
	
	params = "action=add" + "&date=" + date + "&supplierid=" + supplierId + "&jsonProducts=" + productsJSON;
	
	
	return params;
}

function getProductsJSON(){
	var jsonString = "";
	var root = "newarrival";
	
	var arrayGroup = document.getElementsByName('selectGroup');
	var arrayItem = document.getElementsByName('selectItem');
	var arraySubItem = document.getElementsByName('selectSubItem');
	var arrayGms = document.getElementsByName('gms');
	var arrayPcs = document.getElementsByName('pcs');
	var arraySize = document.getElementsByName('size');
	var arrayMC = document.getElementsByName('mc');
	var arrayStoneAs = document.getElementsByName('stone');
	//var arrayStoneValue = document.getElementsByName('maintainMetalValue');
	
	var arrayTotalAmountAs = document.getElementsByName('totalAmount');
	//var arrayTotalAmountValue = document.getElementsByName('maintainMCValue');
	var arrayNoOfDays = document.getElementsByName('noOfDays');
	var arrayDescription = document.getElementsByName('description');
	
	//if(arrayGroup != null && arrayItem != null && arrayRates != null && arrayBilledQty != null && arrayActualQty!=null && arrayAmounts != null){
		jsonString = jsonString + "{\"root\":";
		jsonString = jsonString + "{\"newarrival\":[";
		for(var i=0; i<arrayGroup.length; i++){
			//if(arrayProducts[i].value != "" && arrayUOMs[i].value != "" && arrayRates[i].value != "" && arrayActualQty[i].value != "" && arrayBilledQty[i].value != "" && arrayAmounts[i].value != ""){
				jsonString = jsonString + "{";
				jsonString = jsonString + "\"groupid\":" + "\"" + arrayGroup[i].value + "\"";
				jsonString = jsonString + ",\"itemid\":" + "\"" + arrayItem[i].value + "\"";
				jsonString = jsonString + ",\"subitemid\":" + "\"" + arraySubItem[i].value + "\"";
				jsonString = jsonString + ",\"gms\":" +  "\"" + arrayGms[i].value + "\"";
				jsonString = jsonString + ",\"pcs\":" +  "\"" + arrayPcs[i].value + "\"";
				jsonString = jsonString + ",\"size\":" +  "\"" + arraySize[i].value + "\"";
				jsonString = jsonString + ",\"stone\":" + "\"" + arrayStoneAs[i].value + "\"";
				//jsonString = jsonString + ",\"discamt\":" + arrayDiscAmt[i].value;
				jsonString = jsonString + ",\"mc\":" + "\"" + arrayMC[i].value + "\"";
				jsonString = jsonString + ",\"totalAmount\":"  + "\""+ arrayTotalAmountAs[i].value + "\"";
				
				//jsonString = jsonString + ",\"total\":" + arrayTotal[i].value;
				jsonString = jsonString + ",\"noOfDays\":" + "\"" + arrayNoOfDays[i].value + "\"";
				jsonString = jsonString + ",\"description\":" + "\"" + arrayDescription[i].value + "\"";
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

function getNewarrivalByBillNo(){
	var billnoObj = document.getElementById("voucherno");
	var supplierIdObj = document.getElementById("supplierList");
	var params = "action=getNewarrival";  
	sendAJAXRequest("/PSS/src/controller/NewarrivalController.php",params,"responseGetNewarrival");
}
function getNewArrival(){
	var billnoObj = document.getElementById("voucherno");
	var supplierIdObj = document.getElementById("supplierList");
	if(trim(billnoObj.value).length == 0 || !isNumber(billnoObj.value)){
		updateStatus("Please Enter Valid Id");
	}else{
		updateStatus("Processing . . . ");
		var params = "action=getNewarrival" + "&txnid=" + trim(billnoObj.value);  
//		alert(params);
		sendAJAXRequest("/PSS/src/controller/NewarrivalController.php",params,"responseGetNewarrival");
	}
}

function responseGetNewarrival(responseText, isSuccess){
//	alert(responseText);
	if(isSuccess == "true"){
		populateNewarrivalDetails(responseText);
		hidemsg();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		clearForm();
	}
}

function populateNewarrivalDetails(responseText){
	
	var newarrivalXML = getXMLFromString(responseText);
	
	if(newarrivalXML!=null){
		
		var tableElement = document.getElementById("newarrivaltable");
		var txnId = getFirstNodeValue(newarrivalXML,'newarrivalid');
		currentTxnId = txnId;
		var date = getFirstNodeValue(newarrivalXML,'date');
		 
		var supplierId = getFirstNodeValue(newarrivalXML,'supplierid');
		
		document.getElementById("date").value = getFormattedDate(date,"-");
		document.getElementById("supplierList").value = supplierId;
		document.getElementById("supplierList").disabled = "disabled";
		document.getElementById("voucherno").value = txnId;
		
		deleteAllRows(tableElement);
		
		var listOfProducts = newarrivalXML.getElementsByTagName('product' + txnId);
		var totalProducts = listOfProducts.length;
//		alert("totalProducts"+totalProducts);
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
		    var cellGms = document.createElement("TD");
		    cellGms.setAttribute("align", "left");

		    var cellPcs = document.createElement("TD");    
		    cellPcs.setAttribute("align", "left");
		    
		    var cellSize = document.createElement("TD");
		    cellSize.setAttribute("align", "left");
		    
		    var cellMC = document.createElement("TD");
		    cellMC.setAttribute("align", "left");
		    
		    var cellStone = document.createElement("TD");
		    cellStone.setAttribute("align", "left");
		   
		    var cellTotalAmount = document.createElement("TD");
		    cellTotalAmount.setAttribute("align", "left");
		    
		    var cellNoOfDays = document.createElement("TD");
		    cellNoOfDays.setAttribute("align", "left");
		  
		    var cellDescription = document.createElement("TD");
		    cellDescription.setAttribute("align", "left");
		    
		    var txtDelete = document.createElement('input');
		    txtDelete.setAttribute("type", "image");
		    txtDelete.setAttribute("src", "../images/cross.png");
			txtDelete.setAttribute("onclick", "deleteRow('" + rowid + "')");
			
			selectGroup=document.createElement('select');
			selectGroup.setAttribute("id", "selectGroup" + lastRowId);
			selectGroup.setAttribute("name", "selectGroup");
			selectGroup.setAttribute("class", "select-group");
			selectGroup.setAttribute("onchange","getItemsByGroup(this.value,this.id)");
			selectGroup.setAttribute("disabled", "disabled");
		    
			selectItem=document.createElement('select');
			selectItem.setAttribute("id", "selectItem" + lastRowId);
			selectItem.setAttribute("name", "selectItem");
			selectItem.setAttribute("class", "select-item");
			selectItem.setAttribute("onchange","getSubItems(this.value,this.id)");
			selectItem.setAttribute("disabled", "disabled");
			
			selectSubItem=document.createElement('select');
			selectSubItem.setAttribute("id", "selectSubItem" + lastRowId);
			selectSubItem.setAttribute("name", "selectSubItem");
			selectSubItem.setAttribute("class", "select-subitem");
			selectSubItem.setAttribute("disabled", "disabled");
			
			var txtGms = document.createElement('input');
			txtGms.setAttribute("type", "text");
			txtGms.setAttribute("id", "gms" + lastRowId);
			txtGms.setAttribute("name", "gms");
			txtGms.setAttribute("class", "tblAmountInputField");
			txtGms.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtGms.setAttribute("onkeydown", "keyCheck(event,this)");
			txtGms.setAttribute("size", "8");
			txtGms.setAttribute("value", listOfProducts[i].getElementsByTagName('gms')[0].firstChild.nodeValue);
			txtGms.setAttribute("disabled", "disabled");
			
			var txtPcs = document.createElement('input');
			txtPcs.setAttribute("type", "text");
			txtPcs.setAttribute("id", "pcs" + lastRowId);
			txtPcs.setAttribute("name", "pcs");
			txtPcs.setAttribute("class", "tblAmountInputField");
			txtPcs.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtPcs.setAttribute("onkeydown", "keyCheck(event,this)");
			txtPcs.setAttribute("size", "8");
			txtPcs.setAttribute("value", listOfProducts[i].getElementsByTagName('pcs')[0].firstChild.nodeValue);
			txtPcs.setAttribute("disabled", "disabled");
			
			var txtSize = document.createElement('input');
			txtSize.setAttribute("type", "text");
			txtSize.setAttribute("id", "size" + lastRowId);
			txtSize.setAttribute("name", "size");
			txtSize.setAttribute("class", "tblAmountInputField");
			txtSize.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtSize.setAttribute("onkeydown", "keyCheck(event,this)");
			txtSize.setAttribute("size", "8");
			txtSize.setAttribute("value", listOfProducts[i].getElementsByTagName('size')[0].firstChild.nodeValue);
			txtSize.setAttribute("disabled", "disabled");
		 
			var MC = document.createElement('input');
			MC.setAttribute("type", "text");
			MC.setAttribute("id", "mc" + lastRowId);
			MC.setAttribute("name", "mc");
			MC.setAttribute("class", "tblAmountInputField");
			MC.setAttribute("onkeypress", "return isValidAmount(event,this)");
			MC.setAttribute("onkeydown", "keyCheck(event,this)");
			MC.setAttribute("size", "8");
			MC.setAttribute("value", listOfProducts[i].getElementsByTagName('mc')[0].firstChild.nodeValue);
			MC.setAttribute("disabled", "disabled");
			
			var Stone = document.createElement('input');
			Stone.setAttribute("type", "text");
			Stone.setAttribute("id", "stone" + lastRowId);
			Stone.setAttribute("name", "stone");
			Stone.setAttribute("class", "tblAmountInputField");
			Stone.setAttribute("onkeypress", "return isValidAmount(event,this)");
			Stone.setAttribute("onkeydown", "keyCheck(event,this)");
			Stone.setAttribute("size", "8");
			Stone.setAttribute("value", listOfProducts[i].getElementsByTagName('stone')[0].firstChild.nodeValue);
			Stone.setAttribute("disabled", "disabled");
			
			var TotalAmount = document.createElement('input');
			TotalAmount.setAttribute("type", "text");
			TotalAmount.setAttribute("id", "totalamount" + lastRowId);
			TotalAmount.setAttribute("name", "totalamount");
			TotalAmount.setAttribute("class", "tblAmountInputField");
			TotalAmount.setAttribute("onkeypress", "return isValidAmount(event,this)");
			TotalAmount.setAttribute("onkeydown", "keyCheck(event,this)");
			TotalAmount.setAttribute("size", "8");
			TotalAmount.setAttribute("value", listOfProducts[i].getElementsByTagName('totalamount')[0].firstChild.nodeValue);
			TotalAmount.setAttribute("disabled", "disabled");
			
			 
			var NoOfDays = document.createElement('input');
			NoOfDays.setAttribute("type", "text");
			NoOfDays.setAttribute("id", "noOfDays" + lastRowId);
			NoOfDays.setAttribute("name", "noOfDays");
			NoOfDays.setAttribute("class", "tblAmountInputField");
			NoOfDays.setAttribute("onkeypress", "return isValidAmount(event,this)");
			NoOfDays.setAttribute("onkeydown", "keyCheck(event,this)");
			NoOfDays.setAttribute("size", "8");
			NoOfDays.setAttribute("value", listOfProducts[i].getElementsByTagName('noofdays')[0].firstChild.nodeValue);
			NoOfDays.setAttribute("disabled", "disabled");
			
			var Description = document.createElement('input');
			Description.setAttribute("type", "text");
			Description.setAttribute("id", "description" + lastRowId);
			Description.setAttribute("name", "description");
			Description.setAttribute("class", "tblAmountInputField");
			Description.setAttribute("onkeypress", "return isValidAmount(event,this)");
			Description.setAttribute("onkeydown", "keyCheck(event,this)");
			Description.setAttribute("size", "8");
			Description.setAttribute("value", listOfProducts[i].getElementsByTagName('description')[0].firstChild.nodeValue);
			Description.setAttribute("disabled", "disabled");
			
			cellX.appendChild(txtDelete);
			cellGroup.appendChild(selectGroup);
			cellItem.appendChild(selectItem);
			cellSubItem.appendChild(selectSubItem);
			cellGms.appendChild(txtGms);
			cellPcs.appendChild(txtPcs);
			cellSize.appendChild(txtSize);
			cellMC.appendChild(MC);
			cellStone.appendChild(Stone);	
			cellTotalAmount.appendChild(TotalAmount);
			cellNoOfDays.appendChild(NoOfDays);
			cellDescription.appendChild(Description);
			
			row.appendChild(cellX);
			row.appendChild(cellGroup);
			row.appendChild(cellItem);
			row.appendChild(cellSubItem);
			row.appendChild(cellGms);
			row.appendChild(cellPcs);
			row.appendChild(cellSize);
			row.appendChild(cellMC);
			row.appendChild(cellStone);
			row.appendChild(cellTotalAmount);
			row.appendChild(cellNoOfDays);
			row.appendChild(cellDescription);
			
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

function deleteNewarrival(){
	var isConfirmed = confirm("Are you sure to delete this newarrival?");
	if(isConfirmed){
		updateStatus("Processing . . .");
		var supplierId = trim(document.getElementById("supplierList").value);
		var params = "action=delete" + "&txnid=" + currentTxnId + "&supplierid=" + supplierId;  
		sendAJAXRequest("/PSS/src/controller/NewarrivalController.php",params,"responseDeleteNewarrival");
	}
}

function responseDeleteNewarrival(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Newarrival Deleted Successfully.");
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