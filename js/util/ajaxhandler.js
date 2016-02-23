	function getXmlHTTPObject(){
			if (window.XMLHttpRequest){
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlHTTPObject = new XMLHttpRequest();
			}else if (window.ActiveXObject){
				// 	code for IE6, IE5
				xmlHTTPObject = new ActiveXObject("Microsoft.XMLHTTP");
			}else {
				alert("Your browser does not support XMLHTTP!");
			}
		return xmlHTTPObject;
	}

	function sendAJAXRequest(url,params,callbackMethod){
		var ajaxRequestObj = getXmlHTTPObject();
		
		if(ajaxRequestObj != null){
			ajaxRequestObj.open("POST", url, true);
			if(params != null)
				
				ajaxRequestObj.setRequestHeader("Content-length",params.length);
				ajaxRequestObj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				ajaxRequestObj.setRequestHeader("Connection","close");
				
				ajaxRequestObj.onreadystatechange = function() {
					if(ajaxRequestObj.readyState == 4){
						if(ajaxRequestObj.status == 200){
							var isSuccess = false;
							//alert(trim(ajaxRequestObj.responseText));
							var responseXML = ajaxRequestObj.responseXML;
							if(responseXML != null){
								if(responseXML.getElementsByTagName('error').length == 0){
									isSuccess = true;
								}else{
									isSuccess = false;
								}
							}
							var responseTextStr = trim(ajaxRequestObj.responseText);
							responseTextStr = responseTextStr.replace("'","");
							eval(callbackMethod + "('" + responseTextStr +  "','" + isSuccess + "')");
						}
					}
				};
			ajaxRequestObj.send(params);
		}
	}
	