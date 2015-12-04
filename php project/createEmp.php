<?php

session_start();

$type = $_SESSION['type'];

if($type == ''){
	header('Location: login.php');
}
	
	require_once('nav.php');
	require_once('bs.php');
?>

<html>
<body>
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
	               <option value="Temp">Temp/Kelly</option>
				   <option value="Koyo">Koyo</option>
			</select>
		<br/>
			<input class="form-control" type = 'text' name = 'eDep' placeholder = 'Department ID'/>
		<br/>
			<input class="form-control" type = 'date' name = 'eStart'  placeholder = 'mm/dd/yyyy'/>
		<br/>
			<input class = "btn-lg btn-success" type = 'submit' name = 'submit' />
			<input class = 'btn-lg btn-danger' type = 'reset' value = 'clear'/>
		</div>
	</form>
</div>
</body>
</html>