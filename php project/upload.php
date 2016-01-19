<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$id = $_SESSION['id'];
$type = $_SESSION['type'];
$uType = $_SESSION['uType'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}

if($uType != 'admin'){
	header('Location: notAuthorized.php');
}
//reference the bootstrap, nav bar, and database information		
require_once('bs.php');
require_once('nav.php');
?>
<html>
<head>
	<title> File Upload </title>
	
	<!-- javascript to go back one page -->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>

</head>
<body>
<div class='container-fluid bg-2'>

	<h1> Upload a Work Instruction </h1>
	<form action = 'fileProcess.php' method = 'post' enctype='multipart/form-data'/>

	<div>
		<label for = 'userfile'>Upload a file:</label>
		<input type = 'file' name = 'userfile' id = 'userfile'/><br/><br/>
		<input type = 'submit' class = 'btn-lg btn-success' name = 'selection' value = 'Upload'/>
		<input class = 'btn-lg btn-danger' onclick='goBack()' type = 'button' name ='back' value = 'Back'/>
	</div>
	</form>
</div>
</body>
</html>
<?php
	require_once('footer.php');
?>