<?php
/*//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}*/
//reference the bootstrap, nav bar, and database information		
require_once('bs.php');
require_once('nav.php');
?>



<html>
<head>
<!-- Javascript for the back button -->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
<head>
<body>
<div class="container-fluid bg-2 text-center">
		<form method = 'post' action = 'deptProcess.php'>
		<iframe src="http://docs.google.com/gview?url=http://mcg2001.com/DataBaseRecovery.pptx&embedded=true" style="width:800px; height:600px;" frameborder="0"></iframe>
		<br/>
		<input class = "btn-lg btn-success" type = 'submit' name = 'submit' value = 'Finish' />
		<input class = 'btn-lg btn-danger' type = 'button' value = 'Back' onclick = 'goBack()'/>	
		<form>
</div>
	
</div>
</body>
</html>