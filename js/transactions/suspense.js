var currentTxnId = 0;
var rowIndex = 0;
var selectRowIndex = 0;

var groupSelectHTML = null;
var itemObj = {};
var subitemObj = {};
var mode = null;
var itemsObj = {};
var subitemsObj = {};
var findReturnObj = {};

var netWeightObj = {};

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
	if(mode != 'return'){
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
	 
	    var cellTyps = document.createElement("TD");
	    cellTyps.setAttribute("align", "left");
	    
	    var cellGwt = document.createElement("TD");
	    cellGwt.setAttribute("align", "left");
	    var cellNwt = document.createElement("TD");
	    cellNwt.setAttribute("align", "left");
	    
	    var cellStone = document.createElement("TD");
	    cellStone.setAttribute("align", "left");
	    var cellMetal = document.createElement("TD");
	    cellMetal.setAttribute("align", "left");
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
		
		selectTypes=document.createElement('select');
		selectTypes.setAttribute("id", "selectTypes" + lastRowId);
		selectTypes.setAttribute("name", "selectTypes");
		selectTypes.setAttribute("class", "select-group");
		selectTypes.setAttribute("onchange","typeControl('" + rowid + "',this.value)");
		selectTypes.innerHTML = maintainAsOptions;
		
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
		
		var txtStone = document.createElement('input');
		txtStone.setAttribute("type", "text");
		txtStone.setAttribute("id", "stone" + lastRowId);
		txtStone.setAttribute("name", "stone");
		txtStone.setAttribute("disabled", "disabled");
//		txtStone.setAttribute("value", listOfProducts[i].getElementsByTagName('nwt')[0].firstChild.nodeValue);
		txtStone.setAttribute("class", "tblAmountInputField");
		txtStone.setAttribute("onkeypress", "return isValidAmount(event,this)");
		txtStone.setAttribute("onkeydown", "keyCheck(event,this)");
		txtStone.setAttribute("size", "4");
		
		var txtMetal = document.createElement('input');
		txtMetal.setAttribute("type", "text");
		txtMetal.setAttribute("id", "metal" + lastRowId);
		txtMetal.setAttribute("name", "metal");
		txtMetal.setAttribute("disabled", "disabled");
//		txtMetal.setAttribute("value", listOfProducts[i].getElementsByTagName('nwt')[0].firstChild.nodeValue);
		txtMetal.setAttribute("class", "tblAmountInputField");
		txtMetal.setAttribute("onkeypress", "return isValidAmount(event,this)");
		txtMetal.setAttribute("onkeydown", "keyCheck(event,this)");
		txtMetal.setAttribute("size", "4");
		
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
		amount.setAttribute("disabled", "disabled");
		
		cellX.appendChild(txtDelete);
		cellGroup.appendChild(selectGroup);
		cellItem.appendChild(selectItem);
		cellSubItem.appendChild(selectSubItem);
		cellPcs.appendChild(txtPcs);
		cellTyps.appendChild(selectTypes);
		cellGwt.appendChild(txtGwt);
		cellNwt.appendChild(txtNwt);
		cellStone.appendChild(txtStone);
		cellMetal.appendChild(txtMetal);
		
		cell24Ct.appendChild(txt24Ct);
		cellAmount.appendChild(amount);
		
		row.appendChild(cellX);
		row.appendChild(cellGroup);
		row.appendChild(cellItem);
		row.appendChild(cellSubItem);
		row.appendChild(cellPcs);
		row.appendChild(cellTyps);
		row.appendChild(cellGwt);
		row.appendChild(cellNwt);
		row.appendChild(cellStone);
		row.appendChild(cellMetal);
		
		
		row.appendChild(cell24Ct);
		row.appendChild(cellAmount);
		
		tableElement.appendChild(row);
		
		var selectGroupObj = document.getElementById('selectGroup' + lastRowId);
		selectGroupObj.innerHTML = groupSelectHTML;
		
		document.getElementById('selectGroup' + lastRowId).focus();
	}
	
}

function typeControl(rowId,value){
	var currentRowId = rowId.split("_")[1];
//	alert(currentRowId);
//	alert(value);
	var gwtElement = document.getElementById("gwt"+currentRowId);
	var nwtElement = document.getElementById("nwt"+currentRowId);
	var ctpureElement = document.getElementById("24ctpure"+currentRowId);
	var stoneElement = document.getElementById("stone"+currentRowId);
	var amountElement = document.getElementById("amount"+currentRowId);
	
	if(value == 'cash'){
		gwtElement.value = "0.000";
		nwtElement.value = "0.000";
		ctpureElement.value = "0.000";
		gwtElement.setAttribute("disabled", "disabled");
		nwtElement.setAttribute("disabled", "disabled");
		ctpureElement.setAttribute("disabled", "disabled");
		stoneElement.setAttribute("disabled", "disabled");
		amountElement.disabled = false;
	}else{
		gwtElement.disabled = false;
		nwtElement.disabled = false;
		ctpureElement.disabled = false;
		stoneElement.disabled = false;
		amountElement.value = "0.00";
		amountElement.setAttribute("disabled", "disabled");
	}
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

function addSuspense(){
	var isValid = validateSuspenseForm();
	if(isValid){
		updateStatus("Processing . . . ");
		 var params = prepareParamsToAddSuspense();
		 sendAJAXRequest("/PSS/src/controller/SuspenseentryController.php",params,"responseAddSuspense");
	} 
}

function responseAddSuspense(responseText, isSuccess){
	if(isSuccess == "true"){
		responseXML = getXMLFromString(responseText);
		var suspenseId = getFirstNodeValue(responseXML,"response");
		updateProminentStatus("Suspense Entry Added Successfully. <br/> Voucher No : " + suspenseId + "<br/><br/>" + "<a href='#' onclick='hidemsg()'>close</a>");
		getSuspense();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function validateSuspenseForm(){
	var isValid = false;
	var suspenseno = document.getElementById("suspenseno");
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
		var arrayType = document.getElementsByName('selectTypes');
		var arrayGwt = document.getElementsByName('gwt');
		var arrayNwt = document.getElementsByName('nwt');
		var arrayStone = document.getElementsByName('stone');
		var arrayMetal = document.getElementsByName('metal');
		var array24Ct = document.getElementsByName('24ctpure');
		var arrayAmount = document.getElementsByName('amount');
		
		var rows = arrayGroup.length;
//		alert(rows);
		for(var i=0;i<rows;i++){
//			alert(arrayNwt[i].value);
//			alert(netWeightObj[i+2]);
			
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
			}else if(arrayType[i].value == null || trim(arrayType[i].value).length == 0){
				updateStatus("Please select a Type");
				arrayItem[i].focus();
				isValid = false;
				break;
			}else if(arrayGwt[i].disabled != true && (arrayGwt[i].value == null || trim(arrayGwt[i].value).length == 0)){
				updateStatus("Please enter the gross weight");
				arrayGwt[i].focus();
				isValid = false;
				break;
			}else if(arrayNwt[i].disabled != true && (arrayNwt[i].value == null || trim(arrayNwt[i].value).length == 0)){
				updateStatus("Please enter the net weight");
				arrayNwt[i].focus();
				isValid = false;
				break;				
			}else if(array24Ct[i].disabled != true && (array24Ct[i].value == null || trim(array24Ct[i].value).length == 0)){
				updateStatus("Please enter the 24 ct value");
				array24Ct[i].focus();
				isValid = false;
				break;
			}else if(arrayAmount[i].disabled != true && (arrayAmount[i].value == null || trim(arrayAmount[i].value).length == 0)){
				updateStatus("Please enter the amount");
				arrayAmount[i].focus();
				isValid = false;
				break;				
			}else if (trim(suspenseno.value).length != 0){ 
				 
				if(shortageCalculation(i) == false){
					isValid = false;
					break;
				}else{
					isValid = true;
					break;
				}
			}else{
				isValid = true;
			}
		}
	}
	return isValid;
}
function shortageCalculation(i){
	
	var netWeightValue = netWeightObj[i+2];
//	alert(netWeightValue);
	var arrayNwt = document.getElementsByName('nwt');
	var arrayStone = document.getElementsByName('stone');
	var arrayMetal = document.getElementsByName('metal');

	stoneValue = parseFloat(arrayStone[i].value);
	
	
//	alert("stoneValue"+stoneValue);
	metalValue =  parseFloat(arrayMetal[i].value);
	nwtValue = parseFloat(arrayNwt[i].value);
	
	if(nwtValue > netWeightValue){
		updateStatus("Net weight Should Not Greater  Than The Actual Value("+netWeightValue+")");
		arrayNwt[i].value = netWeightValue;
		arrayNwt[i].focus();
		return  false;		
	}else{
		var shotageValue = netWeightValue - nwtValue;
//		alert(shotageValue);
		if(shotageValue == 0){
			arrayMetal[i].value = 0;
			arrayStone[i].value =0;
			return true;			 		
		}else if(shotageValue == stoneValue){
			arrayMetal[i].value = shotageValue - arrayStone[i].value;
			return true;
		}else if(stoneValue > shotageValue){
			updateStatus("Stone weight Should Not Greater  Than Shortage Value");
			return false;
		}else{
			arrayMetal[i].value = shotageValue - arrayStone[i].value;
			return true;
		}
	}
}

function prepareParamsToAddSuspense(){
	var params = "";
	
	var suspenseId = document.getElementById("suspenseno").value;
	var issuerId = document.getElementById("issuerList").value;
	var receiverId = document.getElementById("receiverList").value;
	var bearerId = document.getElementById("bearerList").value;
	var locationId = document.getElementById("locationList").value;
	var type = document.getElementById("typeList").value;
	var mode = document.getElementById("modeList").value;
	var productsJSON = getProductsJSON();
	
	params = "action=add" + "&refsuspenseid=" + suspenseId + "&issuerid=" + issuerId + "&receiverid=" + receiverId + "&bearerid=" + bearerId + "&locationid=" + locationId + "&type=" + type + "&mode=" + mode + "&jsonProducts=" + productsJSON;
	
//	alert(params);
	return params;
}

function getProductsJSON(){
	var jsonString = "";
	var root = "suspense";
	
	var arrayGroup = document.getElementsByName('selectGroup');
	var arrayItem = document.getElementsByName('selectItem');
	var arraySubItem = document.getElementsByName('selectSubItem');
	var arrayPcs = document.getElementsByName('pcs');
	var arrayTyps = document.getElementsByName('selectTypes');	
	var arrayGwt = document.getElementsByName('gwt');
	var arrayNwt = document.getElementsByName('nwt');
	var arrayStone = document.getElementsByName('stone');
	var arrayMetal = document.getElementsByName('metal');
	var array24Ct = document.getElementsByName('24ctpure');
	var arrayAmount = document.getElementsByName('amount');
	
	//if(arrayGroup != null && arrayItem != null && arrayRates != null && arrayBilledQty != null && arrayActualQty!=null && arrayAmounts != null){
		jsonString = jsonString + "{\"root\":";
		jsonString = jsonString + "{\"suspense\":[";
		for(var i=0; i<arrayGroup.length; i++){
			//if(arrayProducts[i].value != "" && arrayUOMs[i].value != "" && arrayRates[i].value != "" && arrayActualQty[i].value != "" && arrayBilledQty[i].value != "" && arrayAmounts[i].value != ""){
				jsonString = jsonString + "{";
				jsonString = jsonString + "\"groupid\":" + "\"" + arrayGroup[i].value + "\"";
				jsonString = jsonString + ",\"itemid\":" + "\"" + arrayItem[i].value + "\"";
				jsonString = jsonString + ",\"subitemid\":" + "\"" + arraySubItem[i].value + "\"";
				jsonString = jsonString + ",\"pcs\":" +  "\"" + arrayPcs[i].value + "\"";
				jsonString = jsonString + ",\"type\":" +  "\"" + arrayTyps[i].value + "\"";
				jsonString = jsonString + ",\"gwt\":" +  "\"" + arrayGwt[i].value + "\"";
				jsonString = jsonString + ",\"nwt\":" +  "\"" + arrayNwt[i].value + "\"";
				jsonString = jsonString + ",\"stone\":" +  "\"" + arrayStone[i].value + "\"";
				jsonString = jsonString + ",\"metal\":" +  "\"" + arrayMetal[i].value + "\"";
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

function getSuspenseByBillNo(){
	var billnoObj = document.getElementById("voucherno");
	var supplierIdObj = document.getElementById("supplierList");
	var params = "action=getSuspense";  
	sendAJAXRequest("/PSS/src/controller/SuspenseController.php",params,"responseGetSuspense");
}

function getSuspense(){
	var billnoObj = document.getElementById("suspenseno");
	if(trim(billnoObj.value).length == 0 || !isNumber(billnoObj.value)){
		updateStatus("Please enter a valid suspense no");
	}else{
		updateStatus("Processing . . . ");
		var params = "action=getSuspense" + "&suspenseno=" + trim(billnoObj.value);  
		sendAJAXRequest("/PSS/src/controller/SuspenseentryController.php",params,"responseGetSuspense");
	}
}
function getSuspenseReturn(){
	var billnoObj = document.getElementById("suspenseno");
	if(trim(billnoObj.value).length == 0 || !isNumber(billnoObj.value)){
		updateStatus("Please enter a valid suspense no");
	}else{
		updateStatus("Processing . . . ");
		var params = "action=getSuspenseReturn" + "&suspenseno=" + trim(billnoObj.value);  
		sendAJAXRequest("/PSS/src/controller/SuspenseentryController.php",params,"responseGetSuspense");
	}
}

function responseGetSuspense(responseText, isSuccess){
	if(isSuccess == "true"){
		populateSuspenseDetails(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateSuspenseDetails(responseText){
//	var maintainAsOptions = "<option value='pg'>PG</option><option value='lpg'>LPG</option><option value='silver'>Silver</option><option value='cash'>Cash</option>";
	var maintainAsWeightOptions = "<option value='pg'>PG</option><option value='lpg'>LPG</option><option value='silver'>Silver</option>";
	var maintainAsCashOptions = "<option value='cash'>Cash</option>";
	var suspenseXML = getXMLFromString(responseText);
	
	if(suspenseXML!=null){
		var tableElement = document.getElementById("purchasetable");
		var suspenseId = getFirstNodeValue(suspenseXML,'suspenseid');
		currentTxnId = suspenseId;
		var date = getFirstNodeValue(suspenseXML,'date');
		var issuerId = getFirstNodeValue(suspenseXML,'issuerid');
		var receiverId = getFirstNodeValue(suspenseXML,'receiverid');
		var bearerId = getFirstNodeValue(suspenseXML,'bearerid');
		var locationId = getFirstNodeValue(suspenseXML,'locationid');
		var type = getFirstNodeValue(suspenseXML,'type');
		var mode = getFirstNodeValue(suspenseXML,'mode');
		
		document.getElementById("date").value = getFormattedDate(date,"-");
		document.getElementById("issuerList").value = issuerId;
		document.getElementById("receiverList").value = receiverId;
		document.getElementById("bearerList").value = bearerId;
		document.getElementById("locationList").value = locationId;
		document.getElementById("typeList").value = type;
		document.getElementById("modeList").value = mode;
		
		deleteAllRows(tableElement);
		
		var listOfProducts = suspenseXML.getElementsByTagName('suspense' + suspenseId);
		var totalProducts = listOfProducts.length;
		
		for(var i=0; i<totalProducts; i++){
			rowid = "r_" + (i+2);
			lastRowId = (i+2);
			suspensedetailsid = listOfProducts[i].getElementsByTagName('suspensedetailsid')[0].firstChild.nodeValue;
			//lastRowId = suspensedetailsid;
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
		    
		    var cellTyps = document.createElement("TD");
		    cellTyps.setAttribute("align", "left");
		    
		    
		    var cellGwt = document.createElement("TD");
		    cellGwt.setAttribute("align", "left");
		    var cellNwt = document.createElement("TD");
		    cellNwt.setAttribute("align", "left");
		   
		    var cellStone = document.createElement("TD");
		    cellStone.setAttribute("align", "left");
		    var cellMetal = document.createElement("TD");
		    cellMetal.setAttribute("align", "left");
		    
		    var cell24Ct = document.createElement("TD");
		    cell24Ct.setAttribute("align", "left");
		    var cellAmount = document.createElement("TD");
		    cellAmount.setAttribute("align", "left");
		    
		    var txtDelete = document.createElement('img');
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
			
			selectTypes=document.createElement('select');
			selectTypes.setAttribute("id", "selectTypes" + lastRowId);
			selectTypes.setAttribute("name", "selectTypes");
			selectTypes.setAttribute("class", "select-subitem");
			var type = listOfProducts[i].getElementsByTagName('type')[0].firstChild.nodeValue;
//			alert(type);
			if(type == 'cash'){
				selectTypes.innerHTML = maintainAsCashOptions;
			}else{
				selectTypes.innerHTML = maintainAsWeightOptions;
			}
			selectTypes.value = type;
			selectTypes.setAttribute("onchange","typeControl('" + rowid + "',this.value)");
			selectTypes.setAttribute("disabled", "disabled");
			
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
			netWeightObj[lastRowId] = listOfProducts[i].getElementsByTagName('nwt')[0].firstChild.nodeValue ;
//			alert(lastRowId);
//			alert(netWeightObj[lastRowId]);
			txtNwt.setAttribute("class", "tblAmountInputField");
			txtNwt.setAttribute("onkeypress", "return isValidAmount(event,this)");
			//txtNwt.setAttribute("onchange", "checkNWT(lastRowId,suspensedetailsid)");
			txtNwt.setAttribute("onkeydown", "keyCheck(event,this)");
			txtNwt.setAttribute("size", "8");
			
			var txtStone = document.createElement('input');
			txtStone.setAttribute("type", "text");
			txtStone.setAttribute("id", "stone" + lastRowId);
			txtStone.setAttribute("name", "stone");
			txtStone.setAttribute("disabled", "disabled");
			txtStone.setAttribute("value", "0");
			txtStone.setAttribute("class", "tblAmountInputField");
			txtStone.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtStone.setAttribute("onkeydown", "keyCheck(event,this)");
			txtStone.setAttribute("size", "4");
			
			var txtMetal = document.createElement('input');
			txtMetal.setAttribute("type", "text");
			txtMetal.setAttribute("id", "metal" + lastRowId);
			txtMetal.setAttribute("name", "metal");
			txtMetal.setAttribute("disabled", "disabled");
			txtMetal.setAttribute("value", "0");
			txtMetal.setAttribute("class", "tblAmountInputField");
			txtMetal.setAttribute("onkeypress", "return isValidAmount(event,this)");
			txtMetal.setAttribute("onkeydown", "keyCheck(event,this)");
			txtMetal.setAttribute("size", "4");
			
			
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
			cellTyps.appendChild(selectTypes);
			cellGwt.appendChild(txtGwt);
			cellNwt.appendChild(txtNwt);

			cellStone.appendChild(txtStone);
			cellMetal.appendChild(txtMetal);
			cell24Ct.appendChild(txt24Ct);
			cellAmount.appendChild(amount);
			
			row.appendChild(cellX);
			row.appendChild(cellGroup);
			row.appendChild(cellItem);
			row.appendChild(cellSubItem);
			row.appendChild(cellPcs);
			row.appendChild(cellTyps);			
			row.appendChild(cellGwt);
			row.appendChild(cellNwt);
			row.appendChild(cellStone);
			row.appendChild(cellMetal);
			
			row.appendChild(cell24Ct);
			row.appendChild(cellAmount);
			
			tableElement.appendChild(row);
			
			document.getElementById("selectGroup" + lastRowId).innerHTML = groupSelectHTML;
			document.getElementById("selectGroup" + lastRowId).value = listOfProducts[i].getElementsByTagName('groupid')[0].firstChild.nodeValue;
			
			var itemValue = listOfProducts[i].getElementsByTagName('itemid')[0].firstChild.nodeValue;
			document.getElementById("selectItem" + lastRowId).innerHTML = "<option value=\""+ itemValue + "\">"+ itemsObj[itemValue] + "</option>";
			
			var subitemValue = listOfProducts[i].getElementsByTagName('subitemid')[0].firstChild.nodeValue;
			document.getElementById("selectSubItem" + lastRowId).innerHTML = "<option value=\"" + subitemValue + "\">"+ subitemsObj[subitemValue] + "</option>";
			
			var findElementValue = document.getElementById("findReturn").Value;
			
			showEditButtonPanel();
			typeControl(rowid,selectTypes.value);
		}
	}
}

function checkNWT(rowId){
	/*var nwtElement = document.getElementById("nwt" + rowId);
	var netWeightObjValue = netWeightObj[rowId];
	
	alert(nwtElement.value);
	alert(netWeightObj[rowId]);
	
	var vwtValue = nwtElement.value;
	var netWeightObjValue = netWeightObj[rowId];
	
	if( vwtValue > netWeightObjValue){
		return false;
	}*/
}

function populateReturnValues(){
	
}

function deleteSuspense(){
	var isConfirmed = confirm("Are you sure to delete this suspense entry?");
	if(isConfirmed){
		updateStatus("Processing . . .");
		var params = "action=delete" + "&txnid=" + currentTxnId;  
		sendAJAXRequest("/PSS/src/controller/SuspenseentryController.php",params,"responseDeleteSuspense");
	}
}  

function responseDeleteSuspense(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Suspense Entry Deleted Successfully.");
		getSuspense();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateFormControls(mode){
	if(mode == "return"){
		document.getElementById("issuerList").setAttribute("disabled", "disabled");
		document.getElementById("receiverList").setAttribute("disabled", "disabled");
		document.getElementById("bearerList").setAttribute("disabled", "disabled");
		document.getElementById("locationList").setAttribute("disabled", "disabled");
		document.getElementById("typeList").setAttribute("disabled", "disabled");
		document.getElementById("modeList").setAttribute("disabled", "disabled");
		
		var noOfRows = document.getElementById("purchasetable").rows.length;
//		var noOfRows = document.getElementById("purchasetable").rows;
		for(var i=1;i<noOfRows;i++){
			document.getElementById("selectTypes" + (i+1)).removeAttribute("disabled");
			document.getElementById("pcs" + (i+1)).removeAttribute("disabled");
			//document.getElementById("gwt" + (i+1)).removeAttribute("disabled");
			//document.getElementById("nwt" + (i+1)).removeAttribute("disabled");
			//document.getElementById("stone" + (i+1)).removeAttribute("disabled");
		//	document.getElementById("metal" + (i+1)).removeAttribute("disabled");
			//document.getElementById("24ctpure" + (i+1)).removeAttribute("disabled");
	//		document.getElementById("amount" + (i+1)).removeAttribute("disabled");
		}
		document.getElementById("typeList").value = 'RETURN';
		hideEditButtonPanel();
	}else if(mode == "new" || mode == "edit"){
		document.getElementById("issuerList").removeAttribute("disabled");
		document.getElementById("receiverList").removeAttribute("disabled");
		document.getElementById("bearerList").removeAttribute("disabled");
		document.getElementById("locationList").removeAttribute("disabled");
//		document.getElementById("typeList").removeAttribute("disabled");
		document.getElementById("modeList").removeAttribute("disabled");
		document.getElementById("typeList").value = 'OUT';
		/*document.getElementById("selectTypes" + i).removeAttribute("disabled");
		document.getElementById("txtpcs" + i).removeAttribute("disabled");
		document.getElementById("txtgwt" + i).removeAttribute("disabled");
		document.getElementById("txtnwt" + i).removeAttribute("disabled");
		document.getElementById("txtamount" + i).removeAttribute("disabled");*/
	}
}
function findReturn(){
	mode = "return";
	getSuspenseReturn();
	var isValidBillNo = document.getElementById("selectGroup2").disabled;
	if(isValidBillNo == false){
		setTimeout("updateFormControls('return')","2000");
	}
}
