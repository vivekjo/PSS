var suppliersObj = {};

var categoryObj = {};
var accheadObj = {};

var pgtableElement = null;
var lpgtableElement = null;
var silvertableElement = null;
var cashtableElement = null;

function getAllChannels(){
	var params = "action=GetAllChannels";
	sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseGetAllChannels");
}

function responseGetAllChannels(responseText, isSuccess){
	if(isSuccess == "true"){
		populateCategoryJSON(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateCategoryJSON(responseText){
	var channelsXML = getXMLFromString(responseText);
	var totalItems = channelsXML.getElementsByTagName('channel').length;
	var channelId = null;
	var channelName = null;
	for(var i=0;i<totalItems;i++){
		channelId = getNodeValue(channelsXML,'channelid',i);
		channelName = getNodeValue(channelsXML,'channelname',i);
		channelType = getNodeValue(channelsXML,'channeltype',i);
		categoryObj[channelId] = channelName;
	}
}
function getAllAccheads(){
	var params = "action=GetAllAccheads";
	sendAJAXRequest("/PSS/src/controller/AccHeadController.php",params,"responseGetAllAccheads");
}

function responseGetAllAccheads(responseText, isSuccess){
	if(isSuccess == "true"){
		populateAccheadsJSON(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function populateAccheadsJSON(responseText){
	var accheadsXML = getXMLFromString(responseText);
	var totalItems = accheadsXML.getElementsByTagName('accounthead').length;
	var channelId = null;
	var channelName = null;
	for(var i=0;i<totalItems;i++){
		accheadId = getNodeValue(accheadsXML,'accheadid',i);
		accheadName = getNodeValue(accheadsXML,'accheadname',i);
		accheadObj[accheadId] = accheadName;
	}
}

function updateTables(){
	updateDateFormat();
	updateTypes();
}

function getChannelsByType(type){
	var params = "action=GetChannelsByType&type=" + type;
	sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseGetChannelsByType");
}

function responseGetChannelsByType(responseText, isSuccess){
	if(isSuccess == "true"){
		updateChannelsPanel(responseText);
		clearAccHeads();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateChannelsPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("channelid");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('channel').length;
	htmlText = "<option value=\"ALL\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		channelId = getNodeValue(itemsXML,'channelid',i);
		channelName = getNodeValue(itemsXML,'channelname',i);
		
		htmlText = htmlText + "<option value=\"" + channelId + "\">" + channelName + "</option>";
		htmlText = htmlText + channelName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
}

function clearAccHeads(){
	accountheadid.options.length = 0;
}

function getAccHeadsByChannel(channelId){
	var params = "action=GetAccHeadsByChannel&channelid=" + channelId;
	sendAJAXRequest("/PSS/src/controller/AccHeadController.php",params,"responseGetAccHeadByChannel");
}

function responseGetAccHeadByChannel(responseText, isSuccess){
	if(isSuccess == "true"){
		updateAccHeadsPanel(responseText);
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
	}
}

function updateAccHeadsPanel(responseText){
	var itemsXML = getXMLFromString(responseText);
	var divElement = document.getElementById("accountheadid");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('accounthead').length;
	htmlText = "<option value=\"ALL\">-</option>";
	
	for(var i=0;i<totalItems;i++){
		accheadId = getNodeValue(itemsXML,'accheadid',i);
		accheadName = getNodeValue(itemsXML,'accheadname',i);
		
		htmlText = htmlText + "<option value=\"" + accheadId + "\">" + accheadName + "</option>";
		htmlText = htmlText + accheadName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
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

function  buildQuery(){	
	var fromdate = getFormattedDate(document.getElementById("fromdate").value,"/");
	var todate = getFormattedDate(document.getElementById("todate").value,"/");;
	var query = " select * from daybook where date>='" + fromdate + "' and date<='"+todate+"'";

	var type = document.getElementById('type').value;
	if(type != "ALL"){
		query = query + " and type='" + type + "'";
	}
	
	var channelId = document.getElementById('channelid').value;
	if(channelId != "" && channelId != "ALL"){
		query = query + " and category_id='" + channelId + "'";
	}
	
	var accheadId = document.getElementById('accountheadid').value;
	if(accheadId != "" && accheadId != "ALL"){
		query = query + " and acchead_id='" + accheadId + "'";
	}
	
	var mode = document.getElementById("mode").value;
	document.getElementById("hiddenPaymentMode").value = mode;
	if(mode != "ALL"){
		query = query + " and " + mode + ">0";
	}
	
	query = query + " order by date";
	
	return query;
}


function updateDateFormat(){
	var count = 1;
	var date = null;
	while(document.getElementById("idate" + count) != null){
		date = document.getElementById("idate" + count).innerHTML;
		document.getElementById("idate" + count).innerHTML = getFormattedDate(date,'-');
		count++;
	}
	count = 1;
	date = null;
	while(document.getElementById("odate" + count) != null){
		date = document.getElementById("odate" + count).innerHTML;
		document.getElementById("odate" + count).innerHTML = getFormattedDate(date,'-');
		count++;
	}
}

function updateTypes(){
	var count = 1;
	var id = 0;
	while(document.getElementById("icategory" + count) != null){
		id = document.getElementById("icategory" + count).innerHTML;
		document.getElementById("icategory" + count).innerHTML = categoryObj[id];
		count++;
	}
	count = 1;
	id = 0;
	while(document.getElementById("iacchead" + count) != null){
		id = document.getElementById("iacchead" + count).innerHTML;
		document.getElementById("iacchead" + count).innerHTML = accheadObj[id];
		count++;
	}
	count = 1;
	id = 0;
	while(document.getElementById("oacchead" + count) != null){
		id = document.getElementById("oacchead" + count).innerHTML;
		document.getElementById("oacchead" + count).innerHTML = accheadObj[id];
		count++;
	}
	count = 1;
	id = 0;
	while(document.getElementById("ocategory" + count) != null){
		id = document.getElementById("ocategory" + count).innerHTML;
		document.getElementById("ocategory" + count).innerHTML = categoryObj[id];
		count++;
	}
	
	id = trim(document.getElementById("accheadreport").innerHTML);
	if(id != "" && id != "ALL"){
		document.getElementById("accheadreport").innerHTML = accheadObj[id];
	}else{
		document.getElementById("accheadreport").innerHTML = "ALL";
	}
	id = trim(document.getElementById("categoryreport").innerHTML);
	if(id != "" && id != "ALL"){
		document.getElementById("categoryreport").innerHTML = categoryObj[id];
	}else{
		document.getElementById("categoryreport").innerHTML = "ALL";
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