<html>
	<head>
		<script src="../js/util/ajaxhandler.js"></script>
		<script src="../js/util/common.js"></script>
		<script src="../js/util/xmlutil.js"></script>	
		<script>
			function init(){
				params = "action=closeSuspense";
				sendAJAXRequest("/PSS/src/controller/SuspenseentryController.php",params,"responseCloseSuspense");
			}
			function responseCloseSuspense(responseText,isSuccess){
				document.write("Closing Suspense Entry Complete");
			}
		</script>
	</head>
	<body onload="init()">
	</body>
</html>
