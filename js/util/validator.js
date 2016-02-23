function validateStringLength(inStr,length){
	if( inStr!= null && trim(inStr).length>=length){
		return true;
	}else{
		return false;
	}
}

function validateOpeningBalance(inStr){
	var result = true;
//	alert(validateString(inStr));
	if(validateString(inStr)){
		if( inStr!= null && trim(inStr).length>=length){
			result = true;
		}else{
			result = false;
		}
	}else{
		result = false;
	}
	return result;
}

function validateString(inStr){
	if( inStr!= null && trim(inStr).length>0){
		return true;
	}else{
		return false;
	}
}

function isValidEmailId(emailId){
	var result = true;
	if(validateString(emailId)){
		var result = false;
		if(validateString(emailId)){
			var pos_at = emailId.indexOf("@");
			var pos_dot = emailId.indexOf(".");
			if(pos_at == -1 || pos_dot == -1 || (pos_dot - pos_at)<=2)
				result = false;
			else
				result = true;
		}else{
			result = false;
		}
		
		myVar = emailId.split('@');
		if (myVar.length>2)
		{
			result = false;
		}
	}
	return result;
}

function isValidNumber(evt) {
	var result = true;
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

//     alert(charCode);
    
    var allowedChar = new Array();
    allowedChar.push("48","49","50","51","52","53","54","55","56","57","96","97","98","99","100","101","102","103","104","105");
    allowedChar.push("8","46","35","36","16","17","18","37","110","190");

    var allowedCharStr = allowedChar.toString();
   
    if((allowedCharStr.search(charCode)) == -1) {
//    	 alert(charCode);
    	result = false;
    }else{
    	
    }
    return result;
}

function disableSplChars(evt){
	var result = true;
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    var allowedChar = new Array();
    allowedChar.push("48","49","50","51","52","53","54","55","56","57","96","97","98","99","100","101","102","103","104","105");
    allowedChar.push("8","46","35","36","16","17","18");

    var allowedCharStr = allowedChar.toString();

    if((allowedCharStr.search(charCode)) == -1 && evt.shiftKey) {
    	result = false;
    }else{
    	
    }
    return result;
}

function isAmount(evt,amtValue) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	var returnValue = true;
	
	var allowedChar = new Array();
	var allowedChar2 = new Array();
	allowedChar.push("48","49","50","51","52","53","54","55","56","57","96","97","98","99","100","101","102","103","104","105","8","16","35","36","37","39","46","110","190","18","9","17");
	allowedChar2.push("8","16","35","36","37","39","46","110","190","18","9","17");
	
//    alert(evt.keyCode);
    
    var allowedCharStr = allowedChar.toString();
    var allowedCharStr2 = allowedChar2.toString();
    
    if ( allowedCharStr.search(charCode) == -1) {
//        alert(evt.keyCode);
		returnValue = false;
	}
	
    if( charCode == 110 || charCode == 190 ){
    	if( amtValue.indexOf(".") != -1 ){
    		var test = amtValue.indexOf(".");
    		returnValue = false;
    	}
    }
    
    if( (amtValue.indexOf(".") != -1) && (allowedCharStr2.search(charCode) == -1) ){
    
	    var dotPosition = amtValue.indexOf(".");
	    var amtLength = amtValue.length;
	    var noOfDecimal = amtLength - dotPosition;
    }
	return returnValue;
}

function isEqual(string1,string2){
	if(trim(string1) == trim(string2))
	return true;
	else
	return false;
}

// *********************************************************
function isValidAmount(evt,obj){
  var charCode = (evt.which) ? evt.which : event.keyCode;
  
  var textBoxValue = obj.value;
//  alert(textBoxValue);
  
  if (charCode > 31 && (charCode < 48 || charCode > 57))
	if(charCode != 46){
		return false;
	}else{
		if( textBoxValue.indexOf(".") != -1 ){
			return false;		
		}
	}
  return true;
}

function isBlankOrSigleQuot(evt,obj){
	var charCode = (evt.which) ? evt.which : event.keyCode;
//	alert(charCode);
	
	var allowedChar = new Array();
	allowedChar.push("32","39","34");
	var allowedCharStr = allowedChar.toString();
	
//	alert(allowedCharStr.search(charCode));
	
    if ( allowedCharStr.search(charCode) != -1) {
		return false;
	}
    
	return true;
}

function isValidPhone(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

function isValidQty(evt,obj){
	  var charCode = (evt.which) ? evt.which : event.keyCode;
	  
	  var textBoxValue = obj.value;
	//  alert(textBoxValue);
	  
	  if (charCode > 31 && (charCode < 48 || charCode > 57))
		if(charCode != 46){
			return false;
		}else{
			if( textBoxValue.indexOf(".") != -1 ){
				return false;		
			}
		}
	  return true;
}

function setClosingBalance(){
	document.getElementById("DrCrCB").selectedIndex = document.getElementById("DrCr").selectedIndex;
}

function isValidName(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode == 58)
		return false;
	return true;
}

function isValidDate(evt,obj){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	var textBoxValue = obj.value;
	var position = 0;
	if (charCode > 31 && (charCode < 48 || charCode > 57)){
		var position = null; 
		position = textBoxValue.lastIndexOf("/");
		length = textBoxValue.length-1;
		if(charCode != 47){
			return false;
		}else{
			if( textBoxValue.count('/') > 1 ){
				return false;		
			}
			if(position == length){
				return false;
			}else{
				return true;
			}
		}
	}
  return true;
}

String.prototype.count=function(s1) { 
	return (this.length - this.replace(new RegExp(s1,"g"), '').length) / s1.length;
};








