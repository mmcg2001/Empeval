<?php
//starts the session	
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
//reference the bootstrap, nav bar	
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
<!-- Form for Employee Creation -->
<h2 align = 'center'>Create Employee</h2>
<div class="container-fluid bg-2 text-center">
	<form method = 'post' action = 'empProcess.php'>
	  <div class = 'col-xs-4'> </div>
		<div class = 'col-xs-4'>
			<input class="form-control" type = 'text' name = 'fName' placeholder = 'First Name'/>
		<br/>
			<input class="form-control" type = 'text' name = 'lName' placeholder = 'Last Name'/>
		<br/>
			<input class="form-control" type = 'text' name = 'ePosition' placeholder = 'Position'/>
		<br/>
			<select  class="form-control" name = "eShift">
	               <option value="First">First</option>
				   <option value="Second">Second</option>
			</select>
		<br/>
			<select  class="form-control" name = "eType">
	               <option value="Temp">Temp</option>
				   <option value="Koyo">Koyo</option>
			</select>
		<br/>
			<input class="form-control" type = 'text' name = 'eDep' placeholder = 'Department ID'/>
		<br/>
			<input class="form-control" type = 'date' name = 'eStart'  placeholder = 'mm/dd/yyyy'/>
		<br/>
			<input class = "btn-lg btn-success" type = 'submit' name = 'submit' />
			<input class = 'btn-lg btn-danger' type = 'reset' value = 'clear'/>
			<br/><br/>
			<input class = 'btn-lg btn-danger' type = 'button' value = 'back' onclick = 'goBack()'/>
		</div>
	</form>
</div>
</body>
</html>