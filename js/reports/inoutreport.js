var suppliersObj = {};
var employeeObj = {};
var locationObj = {};

var pgtableElement = null;
var lpgtableElement = null;
var silvertableElement = null;
var cashtableElement = null;

var groupSelectHTML = null;
var groupsObj = {};
var itemsObj = {};
var subitemsObj = {};

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
		loadGroupList(responseText);		
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}
function loadGroupList(responseText){
	var groupsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("group");
	var groupId = null;
	var groupName = null;
	
	var htmlText = "";
	var totalItems = groupsXML.getElementsByTagName('itemgroup').length;
	htmlText = "<option value=\"ALL\">-</option>";
	for(var i=0;i<totalItems;i++){
		groupId = getNodeValue(groupsXML,'groupid',i);
		groupName = getNodeValue(groupsXML,'groupname',i);		
		htmlText = htmlText + "<option value=\"" + groupId + "\">" + groupName + "</option>";
		groupsObj[groupId] = groupName;
	}
	if(divElement != null){
		divElement.innerHTML = htmlText;
	}
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
		employeeObj[employeeId] = employeeName;
	}
	
	if(issuerElement != null){
		issuerElement.innerHTML = htmlText;
	}
	if(bearerElement != null){
		bearerElement.innerHTML = htmlText;
	}
	if(receiverElement != null){
		receiverElement.innerHTML = htmlText;
	}
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
		locationObj[locationId] = locationName;
		 
	}
	if(locationElement != null){
		locationElement.innerHTML = htmlText;
	}
}

function  buildQuery(){	
	var fromdate = getFormattedDate(document.getElementById("fromdate").value,"/");
	var todate = getFormattedDate(document.getElementById("todate").value,"/");;
	var query = " select distinct io.* from inoutentry io, inoutdetails iod where io.date>='"+fromdate+"' and io.date<='"+todate+"'";
	
	
//	var query = " select distinct p.* from purchase p, purchasedetails pd where ";
//	query = query + " p.date>='"+fromdate+"' and p.date<='"+todate+"'";
	

	var issuerId = document.getElementById('issuerList').value;
	var issuerText = document.getElementById('issuerList').options[document.getElementById('issuerList').selectedIndex].text;
	document.getElementById("hiddenIssuerName").value = issuerText;
	if(issuerText != "-"){
		query = query+" and issuer_Id='"+issuerId+"'";
	}

	var bearerId = document.getElementById('bearerList').value;
	var bearerText = document.getElementById('bearerList').options[document.getElementById('bearerList').selectedIndex].text;
	document.getElementById("hiddenBearerName").value = bearerText;
	if(bearerText != "-"){
		query = query+" and bearer_Id='"+bearerId+"'";
	}

	var receiverId = document.getElementById('receiverList').value;
	var receiverText = document.getElementById('receiverList').options[document.getElementById('receiverList').selectedIndex].text;
	document.getElementById("hiddenReceiverName").value = receiverText;
	if(receiverText != "-"){
		query = query+" and receiver_Id='"+receiverId+"'";
	}
	
	var locationId = document.getElementById('locationList').value;
	var locationText = document.getElementById('locationList').options[document.getElementById('locationList').selectedIndex].text;
	document.getElementById("hiddenLocationName").value = locationText;
	if(locationText != "-"){
		query = query+" and location_Id='"+locationId+"'";
	}

	var typeMode = document.getElementById("typeMode").value;
	document.getElementById("hiddenTypeMode").value = typeMode;
	if(typeMode != "ALL"){
		query = query+" and type='"+typeMode+"'";
	}
	query = query + " and io.inout_id =iod.inout_id order by io.date";
//	alert(query);
	return query;
}
 

function buildQueryForProduct(){
	var productQuery = " select * from inoutdetails where  inout_id=?";
	
	/*var groupText = "";
	var itemText = "";
	var subitemText = "";
	
	var groupObj = document.getElementById('group');
	var groupId = groupObj.value;
	if(groupObj.selectedIndex >= 0){
		groupText = groupObj.options[groupObj.selectedIndex].text;
	}
	
	var itemObj = document.getElementById("item");
	var itemId = itemObj.value;
	if(itemObj.selectedIndex >= 0){
		itemText = itemObj.options[itemObj.selectedIndex].text;
	}
	
	var subItemObj = document.getElementById("subItem");
	var subitemId = subItemObj.value;
	if(subItemObj.selectedIndex >= 0){
		subitemText = subItemObj.options[subItemObj.selectedIndex].text;
	}

	if(groupText != "-"){
		productQuery = productQuery+" and  group_id ='"+groupId+"'";
		if(itemText != "-"){
			productQuery = productQuery+" and   item_id ='"+itemId+"'";
			if(subitemText != "-"){
				productQuery = productQuery+" and   subitem_id ='"+subitemId+"'";
			}
		}
	}
*/
	return productQuery;
}
 
function updateDateFormat(){
	var count = 1;
	var date = null;
	while(document.getElementById("date" + count) != null){
		date = document.getElementById("date" + count).innerHTML;
		document.getElementById("date" + count).innerHTML = getFormattedDate(date,'-');
		count++;
	}
}

function createTableHeaders(tableElement){
	var row=document.createElement("TR");
	row.setAttribute("style", "background-color:#DCE4FF;font-weight:bold;");
	
	var cellSno = document.createElement("TD");
	cellSno.setAttribute("align", "center");
	cellSno.setAttribute("style", "width:15px");
	addText(cellSno,"S.no");
	
	var cellDate = document.createElement("TD");
	cellDate.setAttribute("align", "center");
	cellDate.setAttribute("style", "width:30px");
	addText(cellDate,"Date");
	
	var cellSupplier = document.createElement("TD");
	cellSupplier.setAttribute("align", "center");
	cellSupplier.setAttribute("style", "width:120px");
	addText(cellSupplier,"Supplier Name");
	
	var cellBillNo = document.createElement("TD");
	cellBillNo.setAttribute("align", "center");
	cellBillNo.setAttribute("style", "width:40px");
	addText(cellBillNo,"Voucher No");
	
	var cellType = document.createElement("TD");
	cellType.setAttribute("align", "center");
	cellType.setAttribute("style", "width:25px");
	addText(cellType,"Type");
	
	row.appendChild(cellSno);
	row.appendChild(cellDate);
	row.appendChild(cellSupplier);
	row.appendChild(cellBillNo);
	row.appendChild(cellType);
	
	var fromDate = document.getElementById("fromdate").value;
	var toDate = document.getElementById("todate").value;
	
	var cellDates = null;
	var tmpDate = fromDate;
	
	
	while(compareDates(toDate,tmpDate) == false){
		cellDates = document.createElement("TD");
		cellDates.setAttribute("id", tmpDate);
		cellDates.setAttribute("align", "center");
		cellDates.setAttribute("ondblclick", "getSupplierBalance(this.id)");
		addText(cellDates,getShortDate(tmpDate,"/"));
		tmpDate = getNextDate1(tmpDate);
		row.appendChild(cellDates);
	}
	tableElement.appendChild(row);
}

function updateNames(){
	var count = 1;
	var id = 0;
	while(document.getElementById("issuerid" + count) != null){
		id = document.getElementById("issuerid" + count).innerHTML;
		document.getElementById("issuerid" + count).innerHTML = employeeObj[id];
		count++;
	}
	count =1;
	id=0;
	while(document.getElementById("bearerid" + count) != null){
		id = document.getElementById("bearerid" + count).innerHTML;
		document.getElementById("bearerid" + count).innerHTML = employeeObj[id];
		count++;
	}
	count =1;
	id=0;
	while(document.getElementById("receiverid" + count) != null){
		id = document.getElementById("receiverid" + count).innerHTML;
		document.getElementById("receiverid" + count).innerHTML = employeeObj[id];
		count++;
	}
	
	count =1;
	id=0;
	while(document.getElementById("locationid" + count) != null){
		id = document.getElementById("locationid" + count).innerHTML;
		document.getElementById("locationid" + count).innerHTML = locationObj[id];
		count++;
	}
	 
	var count = 1;
	var id = 0;
	while(document.getElementById("group" + count) != null){
		id = document.getElementById("group" + count).innerHTML;
		document.getElementById("group" + count).innerHTML = groupsObj[id];
		count++;
	}
	
	count =1;
	id=0;
	while(document.getElementById("item" + count) != null){
		id = document.getElementById("item" + count).innerHTML;
		document.getElementById("item" + count).innerHTML = itemsObj[id];
		count++;
	}
	count =1;
	id=0;
	while(document.getElementById("subitem" + count) != null){
		id = document.getElementById("subitem" + count).innerHTML;
		document.getElementById("subitem" + count).innerHTML = subitemsObj[id];
		count++;
	}
	updateDateFormat();
	
	
}

function updateDateFormat(){
	var count = 1;
	var date = null;
	while(document.getElementById("date" + count) != null){
		date = document.getElementById("date" + count).innerHTML;
		document.getElementById("date" + count).innerHTML = getFormattedDate(date,'-');
		count++;
	}
}
