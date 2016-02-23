var oppg = 0;
var oplpg = 0;
var opsilver = 0;
var opcash = 0;

var clpg = 0;
var cllpg = 0;
var clsilver = 0;
var clcash = 0;

var tmppg = new Number(0.000);
var tmplpg = new Number(0.000);
var tmpsilver = new Number(0.000);
var tmpcash = new Number(0.00);


var suppliersObj = {};
var channelsObj = {};
var accheadsObj = {};

function printDaybook(){
	var divElement = document.getElementById("daybookreportdiv");
	var dateObj = document.getElementById("selectedDate").value;
	
	var windowObj = window.open("Daybook Report");
	var documentObj = windowObj.document;
	documentObj.write("<link rel='stylesheet' type='text/css' href='../css/print.css' media='print'/>");
	documentObj.write("<link rel='stylesheet' type='text/css' href='../css/style.css' />");
	documentObj.write("<link rel='stylesheet' type='text/css' href='../css/daybookreport.css' />");
	documentObj.write("<style>body{background-color:#FFFFFF;}</style>");
	documentObj.write("Daybook Report for : " + dateObj + "<br/><br/>");
	documentObj.write(divElement.innerHTML);
	documentObj.close();
}

function getAllAccheads(){
	var params = "action=GetAllAccheads";
	sendAJAXRequest("/PSS/src/controller/AccheadController.php",params,"responseGetAllAccheads");
}

function responseGetAllAccheads(responseText, isSuccess){
	if(isSuccess == "true"){
		populateAccheadsObj(responseText);
	}
}

function populateAccheadsObj(responseText){
	var itemsXML = getXMLFromString(responseText);
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('accounthead').length;
	
	for(var i=0;i<totalItems;i++){
		accheadId = getNodeValue(itemsXML,'accheadid',i);
		accheadName = getNodeValue(itemsXML,'accheadname',i);
		accheadsObj[accheadId] = accheadName;
	}
}
function getAllChannels(){
	var params = "action=GetAllChannels";
	sendAJAXRequest("/PSS/src/controller/ChannelController.php",params,"responseGetAllChannels");
}

function responseGetAllChannels(responseText, isSuccess){
	if(isSuccess == "true"){
		populateChannelsObj(responseText);
	}
}

function populateChannelsObj(responseText){
	var itemsXML = getXMLFromString(responseText);
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('channel').length;
	
	for(var i=0;i<totalItems;i++){
		channelId = getNodeValue(itemsXML,'channelid',i);
		channelName = getNodeValue(itemsXML,'channelname',i);
		channelsObj[channelId] = channelName;
	}
}
function getAllSuppliers(){
	var params = "action=GetAllSuppliers";
	sendAJAXRequest("/PSS/src/controller/SupplierController.php",params,"responseGetAllSuppliers");
}

function responseGetAllSuppliers(responseText, isSuccess){
	if(isSuccess == "true"){
		populateSuppliers(responseText);
	}
}

function populateSuppliers(responseText){
	var itemsXML = getXMLFromString(responseText);
	
	var supplierId = null;
	var supplierName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('supplier').length;
	htmlText = "<option value=\"\">-</option>";
	for(var i=0;i<totalItems;i++){
		supplierId = getNodeValue(itemsXML,'supplierid',i);
		supplierName = getNodeValue(itemsXML,'suppliername',i);
		
		suppliersObj[supplierId] = supplierName;
	}
}
function updateTableStatus(){
	var tableElement = document.getElementById("daybook-table");
	deleteTableRows(tableElement,2);
	
	var row=document.createElement("TR");
	row.setAttribute("height","25");
	var cellPayment = document.createElement("TD");
	cellPayment.setAttribute("align", "center");
	cellPayment.setAttribute("colspan", "15");
	addText(cellPayment,"PROCESSING . . . ");
	
	row.appendChild(cellPayment);
	tableElement.appendChild(row);
}

function getDetailedDaybook(date){
	updateTableStatus();
	var params = "action=getDetailedDaybook&date=" + date;
	sendAJAXRequest("/PSS/src/controller/DaybookReportController.php",params,"responseGetDaybook");
}

function getDaybook(date){
	updateTableStatus();
	var params = "action=getDaybook&date=" + date;
	sendAJAXRequest("/PSS/src/controller/DaybookReportController.php",params,"responseGetDaybook");
}

function getDaybookBySelectedDate(){
	var varDate = getFormattedDate(document.getElementById("selectedDate").value,"/");
	getDaybook(varDate);
}

function getPrevDateDaybook(){
	var prevDate = getFormattedDate(getPreviousDate(),"/");
	document.getElementById("selectedDate").value = getPreviousDate();
	getDaybook(prevDate);
}

function getNextDateDaybook(){
	var nextDate = getFormattedDate(getNextDate(),"/");
	document.getElementById("selectedDate").value = getNextDate();
	getDaybook(nextDate);
}

function getTodaysDaybook(){
	var today = getFormattedDate(getToday(),"/");
	document.getElementById("selectedDate").value = getToday();
	getDaybook(today);
}

function getDetailedDaybookBySelectedDate(){
	var varDate = getFormattedDate(document.getElementById("selectedDate").value,"/");
	getDetailedDaybook(varDate);
}

function getDetailedPrevDateDaybook(){
	var prevDate = getFormattedDate(getPreviousDate(),"/");
	document.getElementById("selectedDate").value = getPreviousDate();
	getDetailedDaybook(prevDate);
}

function getDetailedNextDateDaybook(){
	var nextDate = getFormattedDate(getNextDate(),"/");
	document.getElementById("selectedDate").value = getNextDate();
	getDetailedDaybook(nextDate);
}

function getDetailedTodaysDaybook(){
	var today = getFormattedDate(getToday(),"/");
	document.getElementById("selectedDate").value = getToday();
	getDetailedDaybook(today);
}

function responseGetDaybook(responseText, isSuccess){
	if(isSuccess == "true"){
		populateDaybook(responseText);
	}
}

function populateDaybook(responseText){
	var responseXML = getXMLFromString(responseText);
	
	var openingXML = responseXML.getElementsByTagName("opening")[0];
	var closingXML = responseXML.getElementsByTagName("closing")[0];
	
	var paymentsXML = responseXML.getElementsByTagName("PAYMENTINFO")[0];
	var transfersXML = responseXML.getElementsByTagName("TRANSFERINFO")[0];
	var purchasesXML = responseXML.getElementsByTagName("PURCHASEINFO")[0];
	var incomingXML = responseXML.getElementsByTagName("incoming")[0];
	var outgoingXML = responseXML.getElementsByTagName("outgoing")[0];
	
	var tableElement = document.getElementById("daybook-table");
	deleteTableRows(tableElement,2);
	
	populateOpeningInfo(openingXML,tableElement);
	populateIncomingInfo(incomingXML,tableElement);
	populateOutgoingInfo(outgoingXML,tableElement);
	populatePaymentInfo(paymentsXML,tableElement);
	populatePurchaseInfo(purchasesXML,tableElement);
	populateTransfersInfo(transfersXML,tableElement);
	populateClosingInfo(closingXML,tableElement);
}

function populateOpeningInfo(openingXML,tableElement){
	if(openingXML != null){
		oppg = getFormattedNo(getFirstNodeValue(openingXML,'pg'),3);
		oplpg = getFormattedNo(getFirstNodeValue(openingXML,'lpg'),3);
		opsilver = getFormattedNo(getFirstNodeValue(openingXML,'silver'),3);
		opcash = getFormattedNo(getFirstNodeValue(openingXML,'cash'),2);
		
		tmppg = oppg;
		tmplpg = oplpg;
		tmpsilver = opsilver;
		tmpcash = opcash;
		
		document.getElementById("oppg").innerHTML = oppg;
		document.getElementById("oplpg").innerHTML = oplpg;
		document.getElementById("opsilver").innerHTML = opsilver;
		document.getElementById("opcash").innerHTML = opcash;
		
		
		var row=document.createElement("TR");
		row.setAttribute("height", "25px");
		
		var cellSno = document.createElement("TD");
		cellSno.setAttribute("align", "right");
		addText(cellSno,"");
		
		var cellDescription = document.createElement("TD");
		cellDescription.setAttribute("align", "left");
		cellDescription.setAttribute("colspan", "10");
		addText(cellDescription,"Opening Balance"); 
		
		var cellClPg = document.createElement("TD");
	    cellClPg.setAttribute("align", "right");
	    cellClPg.setAttribute("class", "balance");
	    addText(cellClPg,getFormattedNo(oppg,3));
	    var cellClLpg = document.createElement("TD");
	    cellClLpg.setAttribute("align", "right");
	    cellClLpg.setAttribute("class", "balance");
	    addText(cellClLpg,getFormattedNo(oplpg,3));
	    var cellClSilver = document.createElement("TD");
	    cellClSilver.setAttribute("align", "right");
	    cellClSilver.setAttribute("class", "balance");
	    addText(cellClSilver,getFormattedNo(opsilver,3));
	    var cellClCash = document.createElement("TD");
	    cellClCash.setAttribute("align", "right");
	    cellClCash.setAttribute("class", "balance");
	    addText(cellClCash,getFormattedNo(opcash,2));
	    
	    row.appendChild(cellSno);
	    row.appendChild(cellDescription);
	    row.appendChild(cellClPg);
	    row.appendChild(cellClLpg);
	    row.appendChild(cellClSilver);
	    row.appendChild(cellClCash);
	    
		tableElement.appendChild(row);
	}
}

function populateClosingInfo(closingXML,tableElement){
	if(closingXML != null){
		clpg = getFormattedNo(getFirstNodeValue(closingXML,'pg'),3);
		cllpg = getFormattedNo(getFirstNodeValue(closingXML,'lpg'),3);
		clsilver = getFormattedNo(getFirstNodeValue(closingXML,'silver'),3);
		clcash = getFormattedNo(getFirstNodeValue(closingXML,'cash'),2);
		
		document.getElementById("clpg").innerHTML = clpg;
		document.getElementById("cllpg").innerHTML = cllpg;
		document.getElementById("clsilver").innerHTML = clsilver;
		document.getElementById("clcash").innerHTML = clcash;
		
		var row=document.createElement("TR");
		row.setAttribute("height", "25px");
		
		var cellSno = document.createElement("TD");
		cellSno.setAttribute("align", "right");
		addText(cellSno,"");
		
		var cellDescription = document.createElement("TD");
		cellDescription.setAttribute("align", "left");
		cellDescription.setAttribute("colspan", "10");
		addText(cellDescription,"Closing Balance"); 
		
		var cellClPg = document.createElement("TD");
	    cellClPg.setAttribute("align", "right");
	    cellClPg.setAttribute("class", "balance");
	    addText(cellClPg,getFormattedNo(clpg,3));
	    var cellClLpg = document.createElement("TD");
	    cellClLpg.setAttribute("align", "right");
	    cellClLpg.setAttribute("class", "balance");
	    addText(cellClLpg,getFormattedNo(cllpg,3));
	    var cellClSilver = document.createElement("TD");
	    cellClSilver.setAttribute("align", "right");
	    cellClSilver.setAttribute("class", "balance");
	    addText(cellClSilver,getFormattedNo(clsilver,3));
	    var cellClCash = document.createElement("TD");
	    cellClCash.setAttribute("align", "right");
	    cellClCash.setAttribute("class", "balance");
	    addText(cellClCash,getFormattedNo(clcash,2));
	    
	    row.appendChild(cellSno);
	    row.appendChild(cellDescription);
	    row.appendChild(cellClPg);
	    row.appendChild(cellClLpg);
	    row.appendChild(cellClSilver);
	    row.appendChild(cellClCash);
	    
		tableElement.appendChild(row);
	}
}
function populatePaymentInfo(paymentsXML,tableElement){
	var row=document.createElement("TR");
	var cellPayment = document.createElement("TD");
	cellPayment.setAttribute("align", "left");
	cellPayment.setAttribute("style", "background-color:#A1A2A3;padding:1px");
	cellPayment.setAttribute("colspan", "15");
	cellPayment.innerHTML = "<div class=\"panel-title\">Payments</div>";
	row.appendChild(cellPayment);
	tableElement.appendChild(row);
	
	if(paymentsXML != null){
		
		var noOfPayments =  paymentsXML.getElementsByTagName("payment").length;
		
		if(noOfPayments == 0){
			var row=document.createElement("TR");
			row.setAttribute("height", "40px");
			var cellPayment = document.createElement("TD");
			cellPayment.setAttribute("align", "center");
			cellPayment.setAttribute("colspan", "15");
			addText(cellPayment,"There are no Payment Entries for this date.");
			
			row.appendChild(cellPayment);
			tableElement.appendChild(row);
			
			
		}else{
			for(var i=0;i<noOfPayments;i++){
				var txnId = getNodeValue(paymentsXML,'txnid',i);
				var supplierId = getNodeValue(paymentsXML,'supplierid',i);
				var voucherNo = getNodeValue(paymentsXML,'voucherno',i);
				var paymentMode = getNodeValue(paymentsXML,'paymentmode',i);
				var adjustWith = getNodeValue(paymentsXML,'adjustwith',i);
				var adjustValue = getNodeValue(paymentsXML,'adjustamount',i);
				var amount = getNodeValue(paymentsXML,'amount',i);
				var description = getNodeValue(paymentsXML,'description',i);
				
				var row=document.createElement("TR");
				row.setAttribute("height", "25px");
				
				var cellSno = document.createElement("TD");
				cellSno.setAttribute("align", "right");
				addText(cellSno,(i+1));
				
				var cellDescription = document.createElement("TD");
			    cellDescription.setAttribute("align", "left");
			    addText(cellDescription,suppliersObj[supplierId]);
				
			    var cellType = document.createElement("TD");
			    cellType.setAttribute("align", "center");
			    addText(cellType,voucherNo);
			    
			    if(paymentMode != "cheque"){
				    var cellDrPg = document.createElement("TD");
				    cellDrPg.setAttribute("align", "right");
				    var cellDrLpg = document.createElement("TD");
				    cellDrLpg.setAttribute("align", "right");
				    var cellDrSilver = document.createElement("TD");
				    cellDrSilver.setAttribute("align", "right");
				    var cellDrCash = document.createElement("TD");
				    cellDrCash.setAttribute("align", "right");
			    }else{
			    	var cellDr = document.createElement("TD");
				    cellDr.setAttribute("align", "center");
				    cellDr.setAttribute("colspan", "4");
				    cellDr.innerHTML = "CHEQUE PAYMENT";
			    }
			    
			    var modeCell = null;
			    if(paymentMode == "pg"){
			    	tmppg = parseFloat(tmppg) - parseFloat(amount);
			    	modeCell = cellDrPg;
			    	modeCell.innerHTML = getFormattedNo(amount,3) + "<br /> <-> <br/>" + getFormattedNo(adjustValue,3) + " " + adjustWith;
			    }else if(paymentMode == "lpg"){
			    	tmplpg = parseFloat(tmplpg) - parseFloat(amount);
			    	modeCell = cellDrLpg;
			    	modeCell.innerHTML = getFormattedNo(amount,3) + "<br /> <-> <br/>" + getFormattedNo(adjustValue,3) + " " + adjustWith;
			    }else if(paymentMode == "silver"){
			    	tmpsilver = parseFloat(tmpsilver) - parseFloat(amount);
			    	modeCell = cellDrSilver;
			    	modeCell.innerHTML = getFormattedNo(amount,3) + "<br /> <-> <br/>" + getFormattedNo(adjustValue,3) + " " + adjustWith;
			    }else if(paymentMode == "cash"){
			    	tmpcash = parseFloat(tmpcash) - parseFloat(amount);
			    	modeCell = cellDrCash;
			    	modeCell.innerHTML = getFormattedNo(amount,3) + "<br /> <-> <br/>" + getFormattedNo(adjustValue,3) + " " + adjustWith;
			    }
			    
			    var cellCrPg = document.createElement("TD");
			    cellCrPg.setAttribute("align", "right");
			    addText(cellCrPg,'-');
			    var cellCrLpg = document.createElement("TD");
			    cellCrLpg.setAttribute("align", "right");
			    addText(cellCrLpg,'-');
			    var cellCrSilver = document.createElement("TD");
			    cellCrSilver.setAttribute("align", "right");
			    addText(cellCrSilver,'-');
			    var cellCrCash = document.createElement("TD");
			    cellCrCash.setAttribute("align", "right");
			    addText(cellCrCash,'-');
			    
			    var cellClPg = document.createElement("TD");
			    cellClPg.setAttribute("align", "right");
			    cellClPg.setAttribute("class", "balance");
			    addText(cellClPg,getFormattedNo(tmppg,3));
			    var cellClLpg = document.createElement("TD");
			    cellClLpg.setAttribute("align", "right");
			    cellClLpg.setAttribute("class", "balance");
			    addText(cellClLpg,getFormattedNo(tmplpg,3));
			    var cellClSilver = document.createElement("TD");
			    cellClSilver.setAttribute("align", "right");
			    cellClSilver.setAttribute("class", "balance");
			    addText(cellClSilver,getFormattedNo(tmpsilver,3));
			    var cellClCash = document.createElement("TD");
			    cellClCash.setAttribute("align", "right");
			    cellClCash.setAttribute("class", "balance");
			    addText(cellClCash,getFormattedNo(tmpcash,2));
			    
			    row.appendChild(cellSno);
			    row.appendChild(cellDescription);
			    row.appendChild(cellType);
			    
			    if(paymentMode != "cheque"){
				    row.appendChild(cellDrPg);
				    row.appendChild(cellDrLpg);
				    row.appendChild(cellDrSilver);
				    row.appendChild(cellDrCash);
			    }else{
			    	 row.appendChild(cellDr);
			    }
			    row.appendChild(cellCrPg);
			    row.appendChild(cellCrLpg);
			    row.appendChild(cellCrSilver);
			    row.appendChild(cellCrCash);
			    
			    row.appendChild(cellClPg);
			    row.appendChild(cellClLpg);
			    row.appendChild(cellClSilver);
			    row.appendChild(cellClCash);
			    
			    
				tableElement.appendChild(row);
			}
		}
	}
}	
	
	function populateIncomingInfo(incomingsXML,tableElement){
		var row=document.createElement("TR");
		var cellIncoming = document.createElement("TD");
		cellIncoming.setAttribute("align", "left");
		cellIncoming.setAttribute("style", "background-color:#A1A2A3;padding:1px");
		cellIncoming.setAttribute("colspan", "15");
		cellIncoming.innerHTML = "<div class=\"panel-title\">Incomings</div>";
		row.appendChild(cellIncoming);
		tableElement.appendChild(row);
		
		if(incomingsXML != null){
			
			var noOfIncomings =  incomingsXML.getElementsByTagName("daybook").length;
			
			if(noOfIncomings == 0){
				var row=document.createElement("TR");
				row.setAttribute("height", "40px");
				var cellIncoming = document.createElement("TD");
				cellIncoming.setAttribute("align", "center");
				cellIncoming.setAttribute("colspan", "15");
				addText(cellIncoming,"There are no Incomings Entries for this date.");
				
				row.appendChild(cellIncoming);
				tableElement.appendChild(row);
				
				
			}else{
				for(var i=0;i<noOfIncomings;i++){
					var txnId = getNodeValue(incomingsXML,'txnid',i);
					var type = getNodeValue(incomingsXML,'type',i);
					var categoryId = getNodeValue(incomingsXML,'categoryid',i);
					var accHeadId = getNodeValue(incomingsXML,'accheadid',i);
					var pg = getNodeValue(incomingsXML,'pg',i);
					var lpg = getNodeValue(incomingsXML,'lpg',i);
					var silver = getNodeValue(incomingsXML,'silver',i);
					var cash = getNodeValue(incomingsXML,'cash',i);
					var description = getNodeValue(incomingsXML,'description',i);
					
					var row=document.createElement("TR");
					row.setAttribute("height", "25px");
					
					var cellSno = document.createElement("TD");
					cellSno.setAttribute("align", "right");
					addText(cellSno,(i+1));
					
					var cellDescription = document.createElement("TD");
				    cellDescription.setAttribute("align", "left");
				    addText(cellDescription,channelsObj[categoryId] + "->" + accheadsObj[accHeadId]);
					
				    var cellType = document.createElement("TD");
				    cellType.setAttribute("align", "center");
				    addText(cellType,"-");
				    
				    var cellDrPg = document.createElement("TD");
				    cellDrPg.setAttribute("align", "right");
				    addText(cellDrPg,'-');
				    var cellDrLpg = document.createElement("TD");
				    cellDrLpg.setAttribute("align", "right");
				    addText(cellDrLpg,'-');
				    var cellDrSilver = document.createElement("TD");
				    cellDrSilver.setAttribute("align", "right");
				    addText(cellDrSilver,'-');
				    var cellDrCash = document.createElement("TD");
				    cellDrCash.setAttribute("align", "right");
				    addText(cellDrCash,'-');
				    
				    var cellCrPg = document.createElement("TD");
				    cellCrPg.setAttribute("align", "right");
				    var cellCrLpg = document.createElement("TD");
				    cellCrLpg.setAttribute("align", "right");
				    var cellCrSilver = document.createElement("TD");
				    cellCrSilver.setAttribute("align", "right");
				    var cellCrCash = document.createElement("TD");
				    cellCrCash.setAttribute("align", "right");
				    
				    if(getFormattedNo(pg,1) == 0.0){
				    	addText(cellCrPg,"-");
				    }else{
				    	tmppg = parseFloat(tmppg) + parseFloat(pg);
				    	addText(cellCrPg,getFormattedNo(pg,3));
				    }
			    	
				    if(getFormattedNo(lpg,1) == 0.0){
				    	addText(cellCrLpg,"-");
				    }else{	
				    	tmplpg = parseFloat(tmplpg) + parseFloat(lpg);
				    	addText(cellCrLpg,getFormattedNo(lpg,3));
				    }
			    	
				    if(getFormattedNo(silver,1) == 0.0){
				    	addText(cellCrSilver,"-");
				    }else{
				    	tmpsilver = parseFloat(tmpsilver) + parseFloat(silver);
				    	addText(cellCrSilver,getFormattedNo(silver,3));
				    }
			    	if(getFormattedNo(cash,1) == 0.0){
			    		addText(cellCrCash,"-");
			    	}else{	
			    		tmpcash = parseFloat(tmpcash) + parseFloat(cash);
			    		addText(cellCrCash,getFormattedNo(cash,2));
			    	}
				    var cellClPg = document.createElement("TD");
				    cellClPg.setAttribute("align", "right");
				    cellClPg.setAttribute("class", "balance");
				    addText(cellClPg,getFormattedNo(tmppg,3));
				    var cellClLpg = document.createElement("TD");
				    cellClLpg.setAttribute("align", "right");
				    cellClLpg.setAttribute("class", "balance");
				    addText(cellClLpg,getFormattedNo(tmplpg,3));
				    var cellClSilver = document.createElement("TD");
				    cellClSilver.setAttribute("align", "right");
				    cellClSilver.setAttribute("class", "balance");
				    addText(cellClSilver,getFormattedNo(tmpsilver,3));
				    var cellClCash = document.createElement("TD");
				    cellClCash.setAttribute("align", "right");
				    cellClCash.setAttribute("class", "balance");
				    addText(cellClCash,getFormattedNo(tmpcash,2));
				    
				    row.appendChild(cellSno);
				    row.appendChild(cellDescription);
				    row.appendChild(cellType);
				    
				    row.appendChild(cellDrPg);
				    row.appendChild(cellDrLpg);
				    row.appendChild(cellDrSilver);
				    row.appendChild(cellDrCash);
				    
				    row.appendChild(cellCrPg);
				    row.appendChild(cellCrLpg);
				    row.appendChild(cellCrSilver);
				    row.appendChild(cellCrCash);
				    
				    row.appendChild(cellClPg);
				    row.appendChild(cellClLpg);
				    row.appendChild(cellClSilver);
				    row.appendChild(cellClCash);
				    
					tableElement.appendChild(row);
				}
			}
		
		}
	}
	
	function populateOutgoingInfo(incomingsXML,tableElement){
		var row=document.createElement("TR");
		var cellIncoming = document.createElement("TD");
		cellIncoming.setAttribute("align", "left");
		cellIncoming.setAttribute("style", "background-color:#A1A2A3;padding:1px");
		cellIncoming.setAttribute("colspan", "15");
		cellIncoming.innerHTML = "<div class=\"panel-title\">Outgoings</div>";
		row.appendChild(cellIncoming);
		tableElement.appendChild(row);
		
		if(incomingsXML != null){
			
			var noOfIncomings =  incomingsXML.getElementsByTagName("daybook").length;
			
			if(noOfIncomings == 0){
				var row=document.createElement("TR");
				row.setAttribute("height", "40px");
				var cellIncoming = document.createElement("TD");
				cellIncoming.setAttribute("align", "center");
				cellIncoming.setAttribute("colspan", "15");
				addText(cellIncoming,"There are no Outgoing Entries for this date.");
				
				row.appendChild(cellIncoming);
				tableElement.appendChild(row);
				
				
			}else{
				for(var i=0;i<noOfIncomings;i++){
					var txnId = getNodeValue(incomingsXML,'txnid',i);
					var type = getNodeValue(incomingsXML,'type',i);
					var categoryId = getNodeValue(incomingsXML,'categoryid',i);
					var accHeadId = getNodeValue(incomingsXML,'accheadid',i);
					var pg = getNodeValue(incomingsXML,'pg',i);
					var lpg = getNodeValue(incomingsXML,'lpg',i);
					var silver = getNodeValue(incomingsXML,'silver',i);
					var cash = getNodeValue(incomingsXML,'cash',i);
					var description = getNodeValue(incomingsXML,'description',i);
					
					var row=document.createElement("TR");
					row.setAttribute("height", "25px");
					
					var cellSno = document.createElement("TD");
					cellSno.setAttribute("align", "right");
					addText(cellSno,(i+1));
					
					var cellDescription = document.createElement("TD");
					cellDescription.setAttribute("align", "left");
					addText(cellDescription,channelsObj[categoryId] + "->" + accheadsObj[accHeadId]);
					
					var cellType = document.createElement("TD");
					cellType.setAttribute("align", "center");
					addText(cellType,"-");
					
					var cellDrPg = document.createElement("TD");
					cellDrPg.setAttribute("align", "right");
					var cellDrLpg = document.createElement("TD");
					cellDrLpg.setAttribute("align", "right");
					var cellDrSilver = document.createElement("TD");
					cellDrSilver.setAttribute("align", "right");
					var cellDrCash = document.createElement("TD");
					cellDrCash.setAttribute("align", "right");
					
			    	if(getFormattedNo(pg,1) == 0.0){
			    		addText(cellDrPg,"-");
			    	}else{
			    		tmppg = parseFloat(tmppg) - getFormattedNo(pg,3);
			    		addText(cellDrPg,getFormattedNo(pg,3));
			    	}
			    	
			    	if(getFormattedNo(lpg,1) == 0.0){
			    		addText(cellDrLpg,"-");
			    	}else{
				    	tmplpg = parseFloat(tmplpg) - parseFloat(lpg);
				    	addText(cellDrLpg,getFormattedNo(lpg,3));
			    	}
			    	
			    	if(getFormattedNo(silver,1) == 0.0){
			    		addText(cellDrSilver,"-");
			    	}else{
			    		tmpsilver = parseFloat(tmpsilver) - parseFloat(silver);
			    		addText(cellDrSilver,getFormattedNo(silver,3));
			    	}
			    	
			    	if(getFormattedNo(cash,1) == 0.0){
			    		addText(cellDrCash,"-");
			    	}else{
			    		tmpcash = parseFloat(tmpcash) - parseFloat(cash);
			    		addText(cellDrCash,getFormattedNo(cash,2));
			    	}
					
			    	
			    	var cellCrPg = document.createElement("TD");
					cellCrPg.setAttribute("align", "right");
					addText(cellCrPg,'-');
					var cellCrLpg = document.createElement("TD");
					cellCrLpg.setAttribute("align", "right");
					addText(cellCrLpg,'-');
					var cellCrSilver = document.createElement("TD");
					cellCrSilver.setAttribute("align", "right");
					addText(cellCrSilver,'-');
					var cellCrCash = document.createElement("TD");
					cellCrCash.setAttribute("align", "right");
					addText(cellCrCash,'-');
					
					var cellClPg = document.createElement("TD");
					cellClPg.setAttribute("align", "right");
					cellClPg.setAttribute("class", "balance");
					addText(cellClPg,getFormattedNo(tmppg,3));
					var cellClLpg = document.createElement("TD");
					cellClLpg.setAttribute("align", "right");
					cellClLpg.setAttribute("class", "balance");
					addText(cellClLpg,getFormattedNo(tmplpg,3));
					var cellClSilver = document.createElement("TD");
					cellClSilver.setAttribute("align", "right");
					cellClSilver.setAttribute("class", "balance");
					addText(cellClSilver,getFormattedNo(tmpsilver,3));
					var cellClCash = document.createElement("TD");
					cellClCash.setAttribute("align", "right");
					cellClCash.setAttribute("class", "balance");
					addText(cellClCash,getFormattedNo(tmpcash,2));
					
					row.appendChild(cellSno);
					row.appendChild(cellDescription);
					row.appendChild(cellType);
					
					row.appendChild(cellDrPg);
					row.appendChild(cellDrLpg);
					row.appendChild(cellDrSilver);
					row.appendChild(cellDrCash);
					
					row.appendChild(cellCrPg);
					row.appendChild(cellCrLpg);
					row.appendChild(cellCrSilver);
					row.appendChild(cellCrCash);
					
					row.appendChild(cellClPg);
					row.appendChild(cellClLpg);
					row.appendChild(cellClSilver);
					row.appendChild(cellClCash);
					
					tableElement.appendChild(row);
				}
			}
		}
	}
	
	function populatePurchaseInfo(purchasesXML,tableElement){
		var row=document.createElement("TR");
		var cellIncoming = document.createElement("TD");
		cellIncoming.setAttribute("align", "left");
		cellIncoming.setAttribute("style", "background-color:#A1A2A3;padding:1px");
		cellIncoming.setAttribute("colspan", "15");
		cellIncoming.innerHTML = "<div class=\"panel-title\">Purchases</div>";
		row.appendChild(cellIncoming);
		tableElement.appendChild(row);
		
		if(purchasesXML != null){
			
			var noOfIncomings =  purchasesXML.getElementsByTagName("purchase").length;
			
			if(noOfIncomings == 0){
				var row=document.createElement("TR");
				row.setAttribute("height", "40px");
				var cellIncoming = document.createElement("TD");
				cellIncoming.setAttribute("align", "center");
				cellIncoming.setAttribute("colspan", "15");
				addText(cellIncoming,"There are no Purchase Entries for this date.");
				
				row.appendChild(cellIncoming);
				tableElement.appendChild(row);
				
				
			}else{
				for(var i=0;i<noOfIncomings;i++){
					var supplierId = getNodeValue(purchasesXML,'supplierid',i);
					var billNo = getNodeValue(purchasesXML,'billno',i);
					
					var row=document.createElement("TR");
					row.setAttribute("height", "25px");
					
					var cellSno = document.createElement("TD");
					cellSno.setAttribute("align", "right");
					addText(cellSno,(i+1));
					
					var cellDescription = document.createElement("TD");
					cellDescription.setAttribute("align", "left");
					addText(cellDescription,suppliersObj[supplierId]);
					
					var cellType = document.createElement("TD");
					cellType.setAttribute("align", "center");
					addText(cellType,billNo);
					
					var cellDrPg = document.createElement("TD");
					cellDrPg.setAttribute("align", "right");
					addText(cellDrPg,'-');
					var cellDrLpg = document.createElement("TD");
					cellDrLpg.setAttribute("align", "right");
					addText(cellDrLpg,'-');
					var cellDrSilver = document.createElement("TD");
					cellDrSilver.setAttribute("align", "right");
					addText(cellDrSilver,'-');
					var cellDrCash = document.createElement("TD");
					cellDrCash.setAttribute("align", "right");
					addText(cellDrCash,'-');
					
			    	
			    	var cellCrPg = document.createElement("TD");
					cellCrPg.setAttribute("align", "right");
					addText(cellCrPg,'-');
					var cellCrLpg = document.createElement("TD");
					cellCrLpg.setAttribute("align", "right");
					addText(cellCrLpg,'-');
					var cellCrSilver = document.createElement("TD");
					cellCrSilver.setAttribute("align", "right");
					addText(cellCrSilver,'-');
					var cellCrCash = document.createElement("TD");
					cellCrCash.setAttribute("align", "right");
					addText(cellCrCash,'-');
					
					var cellClPg = document.createElement("TD");
					cellClPg.setAttribute("align", "right");
					cellClPg.setAttribute("class", "balance");
					addText(cellClPg,getFormattedNo(tmppg,3));
					var cellClLpg = document.createElement("TD");
					cellClLpg.setAttribute("align", "right");
					cellClLpg.setAttribute("class", "balance");
					addText(cellClLpg,getFormattedNo(tmplpg,3));
					var cellClSilver = document.createElement("TD");
					cellClSilver.setAttribute("align", "right");
					cellClSilver.setAttribute("class", "balance");
					addText(cellClSilver,getFormattedNo(tmpsilver,3));
					var cellClCash = document.createElement("TD");
					cellClCash.setAttribute("align", "right");
					cellClCash.setAttribute("class", "balance");
					addText(cellClCash,getFormattedNo(tmpcash,2));
					
					row.appendChild(cellSno);
					row.appendChild(cellDescription);
					row.appendChild(cellType);
					
					row.appendChild(cellDrPg);
					row.appendChild(cellDrLpg);
					row.appendChild(cellDrSilver);
					row.appendChild(cellDrCash);
					
					row.appendChild(cellCrPg);
					row.appendChild(cellCrLpg);
					row.appendChild(cellCrSilver);
					row.appendChild(cellCrCash);
					
					row.appendChild(cellClPg);
					row.appendChild(cellClLpg);
					row.appendChild(cellClSilver);
					row.appendChild(cellClCash);
					
					tableElement.appendChild(row);
				}
			}
		}
	}
	
	function populateTransfersInfo(transfersXML,tableElement){
		var row=document.createElement("TR");
		var cellIncoming = document.createElement("TD");
		cellIncoming.setAttribute("align", "left");
		cellIncoming.setAttribute("style", "background-color:#A1A2A3;padding:1px");
		cellIncoming.setAttribute("colspan", "15");
		cellIncoming.innerHTML = "<div class=\"panel-title\">Supplier Balance Transfers</div>";
		row.appendChild(cellIncoming);
		tableElement.appendChild(row);
		
		if(transfersXML != null){
			
			var noOfIncomings =  transfersXML.getElementsByTagName("transfer").length;
			
			if(noOfIncomings == 0){
				var row=document.createElement("TR");
				row.setAttribute("height", "40px");
				var cellIncoming = document.createElement("TD");
				cellIncoming.setAttribute("align", "center");
				cellIncoming.setAttribute("colspan", "15");
				addText(cellIncoming,"There are no Transfers Entries for this date.");
				
				row.appendChild(cellIncoming);
				tableElement.appendChild(row);
				
				
			}else{
				for(var i=0;i<noOfIncomings;i++){
					
					txnId = getNodeValue(transfersXML,'txnid',i);
					currentTxnId = txnId;
					date = getNodeValue(transfersXML,'date',i);
					supplierId = getNodeValue(transfersXML,'supplierid',i);
					fromType = getNodeValue(transfersXML,'fromtype',i);
					toType = getNodeValue(transfersXML,'totype',i);
					fromAmount = getFormattedNo(getNodeValue(transfersXML,'fromamount',i),3);
					toAmount = getFormattedNo(getNodeValue(transfersXML,'toamount',i),3);
					description = getNodeValue(transfersXML,'description',i);
					
					var row=document.createElement("TR");
					row.setAttribute("height", "25px");
					
					var cellSno = document.createElement("TD");
					cellSno.setAttribute("align", "right");
					addText(cellSno,(i+1));
					
					var cellDescription = document.createElement("TD");
					cellDescription.setAttribute("align", "left");
					var tmp = fromAmount + " " + getFullName(fromType) + " <-> " + toAmount + " " + getFullName(toType);
					cellDescription.innerHTML = suppliersObj[supplierId];
					
					var cellDrPg = document.createElement("TD");
					cellDrPg.setAttribute("align", "center");
					cellDrPg.setAttribute("colspan", "9");
					addText(cellDrPg,tmp);
					
					var cellClPg = document.createElement("TD");
					cellClPg.setAttribute("align", "right");
					cellClPg.setAttribute("class", "balance");
					addText(cellClPg,getFormattedNo(tmppg,3));
					var cellClLpg = document.createElement("TD");
					cellClLpg.setAttribute("align", "right");
					cellClLpg.setAttribute("class", "balance");
					addText(cellClLpg,getFormattedNo(tmplpg,3));
					var cellClSilver = document.createElement("TD");
					cellClSilver.setAttribute("align", "right");
					cellClSilver.setAttribute("class", "balance");
					addText(cellClSilver,getFormattedNo(tmpsilver,3));
					var cellClCash = document.createElement("TD");
					cellClCash.setAttribute("align", "right");
					cellClCash.setAttribute("class", "balance");
					addText(cellClCash,getFormattedNo(tmpcash,2));
					
					row.appendChild(cellSno);
					row.appendChild(cellDescription);
					
					row.appendChild(cellDrPg);
					
					row.appendChild(cellClPg);
					row.appendChild(cellClLpg);
					row.appendChild(cellClSilver);
					row.appendChild(cellClCash);
					
					tableElement.appendChild(row);
				}
			}
		}
	}
	
	function getFullName(shortName){
		var fullName = "";
		if(shortName == "pg"){
			fullName = "(g) of Pure Gold";
		}else if(shortName == "lpg"){
			fullName = "(g) of Less Pure Gold";
		}else if(shortName == "silver"){
			fullName = "(kg) of Silver";
		}else if(shortName == "cash"){
			fullName = "Cash";
		}
		return fullName;
	}
	