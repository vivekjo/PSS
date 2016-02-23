var selectedEmployee = null;

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
	var divElement = document.getElementById("employeepanel");
	
	var itemId = null;
	var itemName = null;
	
	var htmlText = "";
	var totalItems = itemsXML.getElementsByTagName('employee').length;
	
	for(var i=0;i<totalItems;i++){
		employeeId = getNodeValue(itemsXML,'employeeid',i);
		employeeName = getNodeValue(itemsXML,'employeename',i);
		
		htmlText = htmlText + "<div id=\"" + employeeId + "\" class=\"panel-element\" onclick=\"selectEmployee(this.id);\" ondblclick=\"editSelectedEmployee();\">";
		htmlText = htmlText + employeeName;
		htmlText = htmlText + "</div>";
	}
	
	divElement.innerHTML = htmlText;
	unselectEmployeePanel();
	selectedEmployee = null;
}

function selectEmployee(id){
	unselectEmployeePanel();
	var divElement = document.getElementById(id);
	divElement.setAttribute("class","selected-panel-element");
	selectedEmployee = id;
	clearForm();
}

function unselectEmployeePanel(){
	var divElement = document.getElementById("employeepanel");
	var noOfGroups = divElement.childNodes.length;
	for(var i=0;i<noOfGroups;i++){
		divElement.childNodes[i].setAttribute("class","panel-element");
	}
}

function editSelectedEmployee(){
	if(selectedEmployee == null){
		updateStatus("Please select a Employee");
	}else{
		editEmployee();
	}
}

function deleteSelectedEmployee(){
	if(selectedEmployee == null){
		updateStatus("Please select a Employee");
	}else{
		var confirmed = confirm("Are you Sure to delete this Employee?");
		if(confirmed){
			deleteEmployee();
		}else{
			getAllEmployees();
			clearForm();
		}
	}
}

function deleteEmployee(){
	updateStatus("Processing . . .");
	var params = "action=delete&employeeid=" + selectedEmployee;
	sendAJAXRequest("/PSS/src/controller/EmployeeController.php",params,"responseDeleteEmployee");
}

function responseDeleteEmployee(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Employee deleted successfully.");
		getAllEmployees();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("employeename").select();
	}
}

function editEmployee(){
	var params = "action=getemployeedetails&employeeid=" + selectedEmployee;
	sendAJAXRequest("/PSS/src/controller/EmployeeController.php",params,"responseEditEmployee");
}

function responseEditEmployee(responseText, isSuccess){
	if(isSuccess == "true"){
		populateEmployeeDetails(responseText);
		showEditButtonPanel();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("employeename").select();
	}
}

function populateEmployeeDetails(responseText){
	employeeXML = getXMLFromString(responseText);
	
	if(employeeXML != null){
		var employeeName = getFirstNodeValue(employeeXML,'employeename');
		document.getElementById("employeename").value = employeeName;
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

function updateEmployee(){
	var isValid = validateEmployeeForm();
	if(isValid == true){
		updateStatus("Processing . . .");
		var params = prepareParamsToUpdateEmployee();
		sendAJAXRequest("/PSS/src/controller/EmployeeController.php",params,"responseUpdateEmployee");
	}
}

function responseUpdateEmployee(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Employee details modified successfully.");
		getAllEmployees();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("employeename").select();
	}
}

function addEmployee(){
	var isValid = validateEmployeeForm();
	if(isValid == true){
		updateStatus("Processing . . .");
		var params = prepareParamsToAddEmployee();
		sendAJAXRequest("/PSS/src/controller/EmployeeController.php",params,"responseAddEmployee");
	}
}

function responseAddEmployee(responseText, isSuccess){
	if(isSuccess == "true"){
		updateStatus("Employee added successfully.");
		getAllEmployees();
		clearForm();
	}else{
		var errorMsg = responseText.replace("<error>","");
		var errorMsg = errorMsg.replace("</error>","");
		updateStatus(errorMsg);
		document.getElementById("employeename").select();
	}
}
function validateEmployeeForm(){
	var isValid = false;
	var employeeName = document.getElementById("employeename");
	
	if(trim(employeeName.value) == ""){
		updateStatus("Please enter a valid employee name");
		employeeName.focus();
	}else{
		isValid = true;
	}
	return isValid;
}

function prepareParamsToAddEmployee(){
	var params = null;
	var employeeName = document.getElementById("employeename").value;
	params = "action=add" + "&employeename=" + employeeName;
	return params;
}

function prepareParamsToUpdateEmployee(){
	var params = null;
	var employeeId = selectedEmployee;
	var employeeName = document.getElementById("employeename").value;
	params = "action=modify" + "&employeeid=" + employeeId + "&employeename=" + employeeName;
	return params;
}