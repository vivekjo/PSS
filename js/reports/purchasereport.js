var suppliersObj = {};
var groupsObj = {};

var selectedGroup = null;
var pgtableElement = null;
var lpgtableElement = null;
var silvertableElement = null;
var cashtableElement = null;

var currentTxnId = 0;
var rowIndex = 0;
var selectRowIndex = 0;


var itemObj = {};
var subitemObj = {};

var groupSelectHTML = null;

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

function printPaymentSchedule(){
	var divElement = document.getElementById("psreportdiv");
	var fromDate = document.getElementById("fromdate").value;
	var toDate = document.getElementById("todate").value;
	
	var windowObj = window.open("Payment Schedule");
	var documentObj = windowObj.document;
	documentObj.write("<link rel='text/css' type='stylesheet' href='../css/print.css' media='print'/>");
	documentObj.write("<link rel='text/css' type='stylesheet' href='../css/style.css' />");
	documentObj.write("<link rel='text/css' type='stylesheet' href='../css/paymentschedule.css' />");
	documentObj.write("Payment Schedule From : " + fromDate + " To " + toDate + "<br/><br/>");
	documentObj.write(divElement.innerHTML);
	document.close();
}

function  buildQueryForPurchase(){	
	var fromdate = getFormattedDate(document.getElementById("fromdate").value,"/");
	var todate = getFormattedDate(document.getElementById("todate").value,"/");;
	var query = " select distinct p.* from purchase p, purchasedetails pd where ";
	query = query + " p.date>='"+fromdate+"' and p.date<='"+todate+"'";

	var supplierId = document.getElementById('supplierList').value;
	var supplierText = document.getElementById('supplierList').options[document.getElementById('supplierList').selectedIndex].text;
	document.getElementById("hiddenSupplierName").value = supplierText;
	if(supplierText != "ALL SUPPLIERS"){
		query = query + " and p.supplier_id='"+supplierId+"'";
	}

	var fromvoucherno =  document.getElementById("fromvoucherno").value;
	var tovoucherno =  document.getElementById("tovoucherno").value;
	
	var voucherStr="";
	if(fromvoucherno !="" && tovoucherno !="" ){
		voucherStr = " and p.billno>='"+fromvoucherno+"' and p.billno<='"+tovoucherno+"'";
	}else if(fromvoucherno =="" && tovoucherno !="" ){
		voucherStr = " and p.billno<='"+tovoucherno+"'";
	}else if(fromvoucherno !="" && tovoucherno =="" ){
		voucherStr = " and p.billno>='"+fromvoucherno+"'";
	}
	query = query + voucherStr;
	
	var productQuery = "";
	var groupText = "";
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
		productQuery = productQuery+" and  pd.group_id ='"+groupId+"'";
		if(itemText != "-"){
			productQuery = productQuery+" and pd.item_id ='"+itemId+"'";
			if(subitemText != "-"){
				productQuery = productQuery+" and pd.subitem_id ='"+subitemId+"'";
			}
		}
	}
	
	query = query + productQuery;
	
	query = query + " and p.txn_id = pd.txn_id order by p.date";
	
	return query;
	
}

function buildQueryForProduct(){
	var productQuery = " select * from purchasedetails where  txn_id=?";
	
	var groupText = "";
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
	return productQuery;
}
function getSupplierBalance(date){
	//document.getElementById("popupdiv").innerHTML = "Processing . . . ";
	//ShowContent("popupdiv");
	var supplierId = document.getElementById("supplierList").value;
	var params = "action=getSupplierBalance" + "&date=" + getFormattedDate(date,"/") + "&supplierid=" + supplierId;
	sendAJAXRequest("/PSS/src/controller/PaymentScheduleController.php",params,"responseGetSupplierBalance");
}

function responseGetSupplierBalance(responseText, isSuccess){
	if(isSuccess == "true"){
		showSupplierBalance(responseText);
	}
}

function showSupplierBalance(responseText){
	var balanceXML = getXMLFromString(responseText);
	var balanceXML = balanceXML.getElementsByTagName("balance")[0];
	
	var pg = getFirstNodeValue(balanceXML,"pg");
	var lpg = getFirstNodeValue(balanceXML,"lpg");
	var silver = getFirstNodeValue(balanceXML,"silver");
	var cash = getFirstNodeValue(balanceXML,"cash");
	
	document.getElementById("pg").innerHTML = getFormattedNo(pg,3);
	document.getElementById("lpg").innerHTML = getFormattedNo(lpg,3);
	document.getElementById("silver").innerHTML = getFormattedNo(silver,3);
	document.getElementById("cash").innerHTML = getFormattedNo(cash,3);
	
	ShowContent("supplierbalancediv");
}
function getAllSuppliers(){
	var params = "action=GetAllSuppliers";
	sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseGetAllSuppliers");
}

function responseGetAllSuppliers(responseText, isSuccess){
	if(isSuccess == "true"){
		loadSuppliersList(responseText);
		updateSupplierNames();
		updateDateFormat();
	}
}
function loadSuppliersList(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("supplierList");
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('supplier').length;
	htmlText = "<option value=\"all\">ALL SUPPLIERS</option>";
	for(var i=0;i<totalItems;i++){
		supplierId = getNodeValue(itemsXML,'supplierid',i);
		supplierName = getNodeValue(itemsXML,'suppliername',i);
		
		htmlText = htmlText + "<option value=\"" + supplierId + "\">";
		htmlText = htmlText + supplierName;
		htmlText = htmlText + "</option>";
		suppliersObj[supplierId] = supplierName;
	}
	if(divElement != null){
		divElement.innerHTML = htmlText;
	}
}
function updateDateFormat(){
	var count = 1;
	var date = null;
	while(document.getElementById("date" + count) != null){
		date = document.getElementById("date" + count).innerHTML;
		document.getElementById("date" + count).innerHTML = getFormattedDate(date,'-');
		count++;
	}
	var paymentDetailsCount = 1;
	var tmpDate = null;
	while(document.getElementById("lastpaymentdate" + paymentDetailsCount) != null){
		tmpDate = document.getElementById("lastpaymentdate" + paymentDetailsCount).innerHTML;
		document.getElementById("lastpaymentdate" + paymentDetailsCount).innerHTML = getFormattedDate(tmpDate,'-');
		paymentDetailsCount++;
	}
}

function updateSupplierNames(){
	var count = 1;
	var supplierId = 0;
	while(document.getElementById("supplierid" + count) != null){
		supplierId = document.getElementById("supplierid" + count).innerHTML;
		document.getElementById("supplierid" + count).innerHTML = suppliersObj[supplierId];
		count++;
	}
}
function updateProductNames(){
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
	
	id = trim(document.getElementById("groupreport").innerHTML);
	if(id != "" && id != "ALL"){
		document.getElementById("groupreport").innerHTML = groupsObj[id];
	}else{
		document.getElementById("groupreport").innerHTML = "ALL";
	}
	
	id = trim(document.getElementById("itemreport").innerHTML);
	if(id != "" && id != "ALL"){
		document.getElementById("itemreport").innerHTML = itemsObj[id];
	}else{
		document.getElementById("itemreport").innerHTML = "ALL";
	}
	
	id = trim(document.getElementById("subitemreport").innerHTML);
	if(id != "" && id != "ALL"){
		document.getElementById("subitemreport").innerHTML = subitemsObj[id];
	}else{
		document.getElementById("subitemreport").innerHTML = "ALL";
	}
}

function getPaymentSchedule(){
	var fromdate = getFormattedDate(document.getElementById("fromdate").value,"/");
	var todate = getFormattedDate(document.getElementById("todate").value,"/");;
	var supplierid = document.getElementById("supplierList").value;
	var params = "action=getPaymentSchedule&fromdate=" + fromdate + "&todate=" + todate + "&supplierid=" + supplierid;
	sendAJAXRequest("/PSS/src/controller/PaymentScheduleController.php",params,"responseGetPaymentSchedule");
}

function responseGetPaymentSchedule(responseText, isSuccess){
	if(isSuccess == "true"){
		populatePaymentSchedule(responseText);
	}else{
		
	}
}

function populatePaymentSchedule(responseText){
	var responseXML = getXMLFromString(responseText);
	
	var paymentsXML = responseXML.getElementsByTagName("PAYMENTINFO")[0];
	var purchasesXML = responseXML.getElementsByTagName("PURCHASEINFO")[0];
	
	if(pgtableElement == null){
		pgtableElement = document.getElementById("pgpaymentscheduletable");
		lpgtableElement = document.getElementById("lpgpaymentscheduletable");
		silvertableElement = document.getElementById("silverpaymentscheduletable");
		cashtableElement = document.getElementById("cashpaymentscheduletable");
	}
	
	deleteTableRows(pgtableElement,0);
	deleteTableRows(lpgtableElement,0);
	deleteTableRows(silvertableElement,0);
	deleteTableRows(cashtableElement,0);
	
	createTableHeaders(pgtableElement);
	lpgtableElement.innerHTML = pgtableElement.innerHTML;
	silvertableElement.innerHTML = pgtableElement.innerHTML;
	cashtableElement.innerHTML = pgtableElement.innerHTML;
	
	populatePurchaseDetails(purchasesXML);
	populatePaymentDetails(paymentsXML);
	
	sortables_init();
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

function populatePurchaseDetails(purchasesXML){
	
	var tableElement = null;
	var mctableElement = null;
	
	if(purchasesXML != null){
		var noOfIncomings =  purchasesXML.getElementsByTagName("purchase").length;
		if(noOfIncomings == 0){
		}else{
			for(var i=0;i<noOfIncomings;i++){
				var txnId = getNodeValue(purchasesXML,'txnid',i);
				var supplierId = getNodeValue(purchasesXML,'supplierid',i);
				var billNo = getNodeValue(purchasesXML,'billno',i);
				var date = getNodeValue(purchasesXML,'date',i);
				
				var row=document.createElement("TR");
				row.setAttribute("height", "25px");
				
				var cellSno = document.createElement("TD");
				cellSno.setAttribute("align", "right");
				addText(cellSno,(i+1));
				
				var cellDate = document.createElement("TD");
				cellDate.setAttribute("align", "right");
				addText(cellDate,getFormattedDate(date,"-"));
				
				var cellDescription = document.createElement("TD");
				cellDescription.setAttribute("align", "left");
				addText(cellDescription,suppliersObj[supplierId]);
				
				var cellBillNo = document.createElement("TD");
				cellBillNo.setAttribute("align", "center");
				addText(cellBillNo,billNo);
				
				var cellType = document.createElement("TD");
				cellType.setAttribute("align", "center");
				addText(cellType,"Metal");
				
				row.appendChild(cellSno);
				row.appendChild(cellDate);
				row.appendChild(cellDescription);
				row.appendChild(cellBillNo);
				row.appendChild(cellType);
				
				/* Making charges */
				
				var mcrow=document.createElement("TR");
				mcrow.setAttribute("height", "25px");
				
				var mccellSno = document.createElement("TD");
				mccellSno.setAttribute("align", "right");
				addText(mccellSno,(i+2));
				
				var mccellDate = document.createElement("TD");
				mccellDate.setAttribute("align", "right");
				addText(mccellDate,getFormattedDate(date,"-"));
				
				var mccellDescription = document.createElement("TD");
				mccellDescription.setAttribute("align", "left");
				addText(mccellDescription,suppliersObj[supplierId]);
				
				var mccellBillNo = document.createElement("TD");
				mccellBillNo.setAttribute("align", "center");
				addText(mccellBillNo,billNo);
				
				var mccellType = document.createElement("TD");
				mccellType.setAttribute("align", "center");
				addText(mccellType,"MC");
				
				mcrow.appendChild(mccellSno);
				mcrow.appendChild(mccellDate);
				mcrow.appendChild(mccellDescription);
				mcrow.appendChild(mccellBillNo);
				mcrow.appendChild(mccellType);
				
				tmpPurchasesXML = purchasesXML.getElementsByTagName("purchase")[i];
				
				var listOfProducts = tmpPurchasesXML.getElementsByTagName('product' + txnId);
				var totalProducts = listOfProducts.length;
				for(var j=0; j<totalProducts; j++){
					var maintainMetalAs = listOfProducts[j].getElementsByTagName('maintainmetalas')[0].firstChild.nodeValue;
					var maintainMetalValue = listOfProducts[j].getElementsByTagName('maintainmetalvalue')[0].firstChild.nodeValue;
					var maintainMcAs = listOfProducts[j].getElementsByTagName('maintainmcas')[0].firstChild.nodeValue;
					var maintainMcValue = listOfProducts[j].getElementsByTagName('maintainmcvalue')[0].firstChild.nodeValue;
					var paymentDays = listOfProducts[j].getElementsByTagName('paymentdays')[0].firstChild.nodeValue;
					var lastPaymentDate = listOfProducts[j].getElementsByTagName('lastpaymentdate')[0].firstChild.nodeValue;
					
					
					tableElement = document.getElementById(maintainMetalAs + "paymentscheduletable");
					mctableElement = document.getElementById(maintainMcAs + "paymentscheduletable");
					
					var paymentPerDay = parseFloat(maintainMetalValue) / parseFloat(paymentDays);
					var mcPerDay = parseFloat(maintainMcValue) / parseFloat(paymentDays);
					
					var fromDate = document.getElementById("fromdate").value;
					var toDate = document.getElementById("todate").value;
					
					var paymentStartDate = getFormattedDate(date,"-");
					var cellDates = null;
					var mccellDates = null;
					var tmpDate = fromDate;
					
					while(compareDates(paymentStartDate,tmpDate) == false){
						cellDates = document.createElement("TD");
						cellDates.setAttribute("align", "center");
						addText(cellDates,"-");
						
						row.appendChild(cellDates);
						
						mccellDates = document.createElement("TD");
						mccellDates.setAttribute("align", "center");
						addText(mccellDates,"-");
						mcrow.appendChild(mccellDates);
						
						tmpDate = getNextDate1(tmpDate);
					}
					
					tmpDate = paymentStartDate;
					
					lastPaymentDate = getFormattedDate(lastPaymentDate,'-');
					
					
					if(compareDates(lastPaymentDate,toDate) == true){
						tmpToDate = getPrevDate1(lastPaymentDate);
					}else{
						tmpToDate = getPrevDate1(toDate);
					}
					
					
					
					while(compareDates(tmpToDate,tmpDate) == false){
						cellDates = document.createElement("TD");
						cellDates.setAttribute("align", "right");
						addText(cellDates,getFormattedNo(paymentPerDay,3));
						row.appendChild(cellDates);
						
						mccellDates = document.createElement("TD");
						mccellDates.setAttribute("align", "right");
						addText(mccellDates,getFormattedNo(mcPerDay,3));
						mcrow.appendChild(mccellDates);
						
						tmpDate = getNextDate1(tmpDate);
					}
				}
				cellSno.innerHTML = tableElement.rows.length;
				tableElement.appendChild(row);
				mccellSno.innerHTML = mctableElement.rows.length;
				mctableElement.appendChild(mcrow);
			}
		}
	}
}

function populatePaymentDetails(paymentsXML){

	var tableElement = null;
	
	if(paymentsXML != null){
		var noOfIncomings =  paymentsXML.getElementsByTagName("payment").length;
		if(noOfIncomings == 0){
		}else{
			for(var i=0;i<noOfIncomings;i++){
				var txnId = getNodeValue(paymentsXML,'txnid',i);
				var date = getNodeValue(paymentsXML,'date',i);
				var supplierId = getNodeValue(paymentsXML,'supplierid',i);
				var voucherNo = getNodeValue(paymentsXML,'voucherno',i);
				var paymentMode = getNodeValue(paymentsXML,'paymentmode',i);
				var adjustWith = getNodeValue(paymentsXML,'adjustwith',i);
				var adjustAmount = getNodeValue(paymentsXML,'adjustamount',i);
				var amount = getNodeValue(paymentsXML,'amount',i);
				var description = getNodeValue(paymentsXML,'description',i);
				
				var row=document.createElement("TR");
				row.setAttribute("height", "25px");
				
				var cellSno = document.createElement("TD");
				cellSno.setAttribute("align", "right");
				addText(cellSno,(i+1));
				
				var cellDate = document.createElement("TD");
				cellDate.setAttribute("align", "right");
				addText(cellDate,getFormattedDate(date,"-"));
				
				var cellDescription = document.createElement("TD");
				cellDescription.setAttribute("align", "left");
				addText(cellDescription,suppliersObj[supplierId]);
				
				var cellBillNo = document.createElement("TD");
				cellBillNo.setAttribute("align", "center");
				addText(cellBillNo,voucherNo);
				
				var cellType = document.createElement("TD");
				cellType.setAttribute("align", "center");
				addText(cellType,"Payment");
				
				row.appendChild(cellSno);
				row.appendChild(cellDate);
				row.appendChild(cellDescription);
				row.appendChild(cellBillNo);
				row.appendChild(cellType);
				
				tableElement = document.getElementById(adjustWith + "paymentscheduletable");
				
				var fromDate = document.getElementById("fromdate").value;
				var toDate = document.getElementById("todate").value;
				
				var paymentStartDate = getFormattedDate(date,"-");
				var paymentStartDate = getPrevDate1(paymentStartDate);
				var cellDates = null;
				var mccellDates = null;
				var tmpDate = fromDate;
				
				while(compareDates(paymentStartDate,tmpDate) == false){
					cellDates = document.createElement("TD");
					cellDates.setAttribute("align", "center");
					addText(cellDates,"-");
					
					row.appendChild(cellDates);
					
					tmpDate = getNextDate1(tmpDate);
				}
				
				cellDates = document.createElement("TD");
				cellDates.setAttribute("align", "right");
				addText(cellDates,getFormattedNo(adjustAmount,3));
				
				row.appendChild(cellDates);
				
			cellSno.innerHTML = tableElement.rows.length;
			tableElement.appendChild(row);
			}
		}
	}
}

function getItemsByGroup(groupId){
	//selectRowIndex = id.substring(id.length-1,id.length);
	if(itemObj[groupId] == null){
		var params = "action=GetItemsByGroup&groupId=" + groupId;
		sendAJAXRequest("/PSS/src/controller/ItemController.php",params,"responseGetItemsByGroup");
	}else{
		var selectItemObj = document.getElementById('item');
		selectItemObj.innerHTML = itemObj[groupId];
		var selectItemObj = document.getElementById('subItem');
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
	var selectItemObj = document.getElementById('item');
	
	var itemId = null;
	var itemName = null;
	var parentGroupId = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('item').length;
	htmlText = "<option value=\"ALL\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		itemId = getNodeValue(itemsXML,'itemid',i);
		itemName = getNodeValue(itemsXML,'itemname',i);
		parentGroupId = getNodeValue(itemsXML,'parentgroupid',i);
		
		htmlText = htmlText + "<option value=\"" + itemId + "\">" + itemName + "</option>";
	}
	itemObj[parentGroupId] = htmlText;
	selectItemObj.innerHTML = htmlText;
	
	var selectItemObj = document.getElementById('subItem');
	selectItemObj.innerHTML = "";
}

function getSubItems(itemId){
	if(subitemObj[itemId] == null){
		var params = "action=GetSubItems&itemId=" + itemId;
		sendAJAXRequest("/PSS/src/controller/SubItemController.php",params,"responseGetSubItems");
	}else{
		var selectSubItemObj = document.getElementById('subItem');
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
	var divElement = document.getElementById("subItem");
	
	var itemId = null;
	var itemName = null;
	var parentItemId = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('subitem').length;
	htmlText = "<option value=\"ALL\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		subItemId = getNodeValue(itemsXML,'subitemid',i);
		subItemName = getNodeValue(itemsXML,'subitemname',i);
		parentItemId = getNodeValue(itemsXML,'parentitemid',i);
		
		htmlText = htmlText + "<option value=\"" + subItemId + "\">" + subItemName + "</option>";
	}
	subitemObj[parentItemId] = htmlText;
	divElement.innerHTML = htmlText;
}