function getNodeValue(xml,tagName, position){
	var data = "";
	
	if(xml.getElementsByTagName(tagName)[position] != null && xml.getElementsByTagName(tagName)[position].firstChild != null){
		data = xml.getElementsByTagName(tagName)[position].firstChild.nodeValue;
	}
	return data;
}

function getFirstNodeValue(xml,tagName){
	var data = "";
	if(xml.getElementsByTagName(tagName)[0]!= null && xml.getElementsByTagName(tagName)[0].firstChild != null){
		data = xml.getElementsByTagName(tagName)[0].firstChild.nodeValue;
	}
	return data;
}

function getXMLFromString(strXML){
	var xmlDoc=null;
	if (window.DOMParser){
	  parser=new DOMParser();
	  xmlDoc=parser.parseFromString(strXML,"text/xml");
	} else {
	  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
	  xmlDoc.async="false";
	  xmlDoc.loadXML(strXML);
	} 
	return xmlDoc;
}


function addText(cellObj,data){
	var txtNode = document.createTextNode(data);
	cellObj.appendChild(txtNode);
}