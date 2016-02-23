var timeoutObj = null;

function updateStatus(msg){
	if(timeoutObj != null){
		clearTimeout(timeoutObj);
	}
	//document.getElementById("status-text").innerHTML = "<img src=\"../images/ajax-loader.gif\" />  " + msg;
	document.getElementById("status-text").innerHTML = msg;
	document.getElementById("status-div").style.display = "block";
	timeoutObj = setTimeout('hidemsg()',3000);
}

function updateProminentStatus(msg){
	if(timeoutObj != null){
		clearTimeout(timeoutObj);
	}
	document.getElementById("status-text").innerHTML = msg;
	document.getElementById("status-div").style.display = "block";
}

function hidemsg(){
	document.getElementById("status-div").style.display = "none";
}

function getFormattedDate(datestr,delimiter){
	var olddate = datestr.split(delimiter);
	var newdate = olddate[2]+"/"+olddate[1]+"/"+olddate[0];
	return newdate;
}

function getShortDate(datestr,delimiter){
	var olddate = datestr.split(delimiter);
	var newdate = olddate[0]+"/"+olddate[1];
	return newdate;
}

function getToday(){
	var currentDate = new Date();
	return formatDate(currentDate);
}

function getNextDate(){
	var currentDate = document.getElementById("selectedDate").value;
	var dateObj = new Date(getFormattedDate(currentDate,"/"));
	dateObj.setDate(dateObj.getDate()+1);
	var nextDate = formatDate(dateObj);
	return nextDate;
}

function getPreviousDate(){
	var currentDate = document.getElementById("selectedDate").value;
	var dateObj = new Date(getFormattedDate(currentDate,"/"));
	dateObj.setDate(dateObj.getDate()-1);
	var nextDate = formatDate(dateObj);
	return nextDate;
}

function formatDate(dateObj){
	var month = dateObj.getMonth() + 1;
	var day = dateObj.getDate();
	var year = dateObj.getFullYear();
	if(day<10){day='0'+ day; }
	if(month<10){month='0'+month; }
	var formattedDate = day + "/" + month + "/" + year ;
	return formattedDate;
}

function compareDates(date1,date2){
	var result = false;
	var dateObj1 = new Date(getFormattedDate(date1,"/"));
	var dateObj2 = new Date(getFormattedDate(date2,"/"));
	
	if((dateObj1-dateObj2) < 0){
		result =  true;
	}
	/*if(dateObj1.getFullYear()==dateObj2.getFullYear()){
		if(dateObj1.getMonth()==dateObj2.getMonth()){
			if(dateObj1.getDate()<dateObj2.getDate()){
				result = true;
			}
		}else{
			
		}
	}elseif(dateObj1.getFullYear()==dateObj2.getFullYear()){
		
	}*/
	return result;
}

function getNextDate1(dateStr){
	var dateObj = new Date(getFormattedDate(dateStr,"/"));
	dateObj.setDate(dateObj.getDate()+1);
	var nextDate = formatDate(dateObj);
	return nextDate;
}

function getPrevDate1(dateStr){
	var dateObj = new Date(getFormattedDate(dateStr,"/"));
	dateObj.setDate(dateObj.getDate()-1);
	var nextDate = formatDate(dateObj);
	return nextDate;
}

function getCurrentRoot(){
	var uri = window.location.href;
	var approot = uri.substr(0,uri.lastIndexOf("/"));
	return approot;
}

function deleteAllRows(tableObj){
	deleteTableRows(tableObj,1);
}

function deleteTableRows(tableObj,noOfRows){
	var tableRowsLength = tableObj.rows.length;
	for(var i=0; i<tableRowsLength && tableObj.rows.length != noOfRows; i++){
		tableObj.deleteRow(noOfRows);
	}
}

function getWord(amt) {
	var rs = amt.split(",");
	var RSnum = ""; 
	for(var i=0;i<rs.length;i++){
		RSnum = RSnum+rs[i]+"";
	}
	var junkVal = RSnum;
    junkVal=Math.floor(junkVal);
    var obStr=new String(junkVal);
    numReversed=obStr.split("");
    actnumber=numReversed.reverse();
 	var word = "";
 	
    if(Number(junkVal) >=0){
        //do nothing
    }
    else{
        alert('wrong Number cannot be converted');
        return false;
    }
    if(Number(junkVal)==0){
        //document.getElementById('container').innerHTML = 'Rupees Zero Only';
        word = 'Zero';
        return false;
    }
    if(actnumber.length>12){
        alert('Oops!!!! the Number is too big to covertes');
        return false;
    }
 
    var iWords=["Zero", " One", " Two", " Three", " Four", " Five", " Six", " Seven", " Eight", " Nine"];
    var ePlace=['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tensPlace=['dummy', ' Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety' ];
 
    var iWordsLength=numReversed.length;
    var totalWords="";
    var inWords=new Array();
    var finalWord="";
    j=0;
    for(i=0; i<iWordsLength; i++){
        switch(i)
        {
        case 0:
            if(actnumber[i]==0 || actnumber[i+1]==1 ) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            //inWords[j]=inWords[j]+' Rupees';
            inWords[j]=inWords[j];
            break;
        case 1:
            tens_complication();
            break;
        case 2:
            if(actnumber[i]==0) {
                inWords[j]='zero';
            }
            else if(actnumber[i-1]!=0 && actnumber[i-2]!=0) {
                inWords[j]=iWords[actnumber[i]]+' Hundred and';
            }
            else {
                inWords[j]=iWords[actnumber[i]]+' Hundred';
            }
            break;
        case 3:
            if(actnumber[i]==0 || actnumber[i+1]==1) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            if(actnumber[i+1] != 0 || actnumber[i] > 0){
                inWords[j]=inWords[j]+" Thousand";
            }
            break;
        case 4:
            tens_complication();
            break;
        case 5:
            if(actnumber[i]==0 || actnumber[i+1]==1 ) {
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+" Lakh";
            break;
        case 6:
            tens_complication();
            break;
        case 7:
            if(actnumber[i]==0 || actnumber[i+1]==1 ){
                inWords[j]='';
            }
            else {
                inWords[j]=iWords[actnumber[i]];
            }
            inWords[j]=inWords[j]+" Crore";
            break;
        case 8:
            tens_complication();
            break;
        default:
            break;
        }
        j++;
    }
	
    function tens_complication() {
        if(actnumber[i]==0) {
            inWords[j]='';
        }
        else if(actnumber[i]==1) {
            inWords[j]=ePlace[actnumber[i-1]];
        }
        else {
            inWords[j]=tensPlace[actnumber[i]];
        }
    }
    inWords.reverse();
    
    for(i=0; i<inWords.length; i++) {
        finalWord+=inWords[i];
    }
    //document.getElementById('container').innerHTML = finalWord;
    word= finalWord;
    return word;
}

function getText(amount){
	var amt = amount;
	var num = amt.split(".");
	var s = (getWord(num[0]) +" Rupees");
	if(num[1]>0){
		var e = (getWord(num[1]) + " Paise only");
	}else{
		e = " only";
	} 
	return (s+" and"+e);
}

function isNotZero(numValue){
	numValue = trim(numValue);
	if(numValue>0){
		return true;
	}else{
		return false;
	}
	
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function trim(inStr){
	var str = inStr.toString();
	str = str.replace(/^\s+|\s+$/g, '');
	return str;
}

function getFormattedNo(inStr,fractionDigits){
	if(inStr != null){
		var num = new Number(inStr);
		return num.toFixed(fractionDigits);
	}
}

var cX = 0; var cY = 0; var rX = 0; var rY = 0;
function UpdateCursorPosition(e){ cX = e.pageX; cY = e.pageY;}
function UpdateCursorPositionDocAll(e){ cX = event.clientX; cY = event.clientY;}
if(document.all) { document.onmousemove = UpdateCursorPositionDocAll; }
else { document.onmousemove = UpdateCursorPosition; }
function AssignPosition(d) {
	if(self.pageYOffset) {
		rX = self.pageXOffset;
		rY = self.pageYOffset;
		}
	else if(document.documentElement && document.documentElement.scrollTop) {
		rX = document.documentElement.scrollLeft;
		rY = document.documentElement.scrollTop;
		}
	else if(document.body) {
		rX = document.body.scrollLeft;
		rY = document.body.scrollTop;
		}
	if(document.all) {
		cX += rX; 
		cY += rY;
		}
	d.style.left = (cX+10) + "px";
	d.style.top = (cY+10) + "px";
	
}

function HideContent(d) {
	if(d.length < 1) { return; }
	document.getElementById(d).style.display = "none";
}

function ShowContent(d) {
	if(d.length < 1) { return; }
	var dd = document.getElementById(d);
	AssignPosition(dd);
	dd.style.display = "block";
}

function ReverseContentDisplay(d) {
	if(d.length < 1) { return; }
	var dd = document.getElementById(d);
	AssignPosition(dd);
	if(dd.style.display == "none") { dd.style.display = "block"; }
	else { dd.style.display = "none"; }
}

function groupTable(tableElement, colIndex){
	
}