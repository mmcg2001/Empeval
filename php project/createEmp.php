<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
$uType = $_SESSION['uType'];
$id = $_SESSION['id'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
if($uType != 'admin'){
	header('Location: notAuthorized.php');
}
//reference database information		

require_once('db_cred.php');

//connecting to the database
try {
  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
}
catch(PDOException $e) {
	echo $e->getMessage();
}

$vSql = $dbc->prepare("Select * from Employee, Department where Emp_ID = '$id' and Department_ID = Emp_DepartmentID");
	//running the SQL statement
	$vSql->execute();
	//retrieving the dataset from the query
	$vSql->setFetchMode(PDO::FETCH_ASSOC);
	$vRow = $vSql->fetch();
	if( $vRow['Emp_UserType'] != "admin"){					
		header("Location: viewProfile.php?id=$id");
	}

//reference the bootstrap, nav bar.
require_once('bs.php');
require_once('nav.php');

//Sql query to pull data from the employee table
$dSql = $dbc->prepare("Select * from Department"); 
//running the query
$dSql->execute();
//fetching the dataset
$dSql->setFetchMode(PDO::FETCH_ASSOC);
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
			<select  class="form-control" name = "eUType">
	               <option value="admin">Admin</option>
				   <option value="user">User</option>
			</select>
		<br/>
			<!-- creating and using the result set from a query to populate the dropdown box -->
			<select  class="form-control" name = "eDep">
				<option>Select Department</option>
	            <?php while($row = $dSql->fetch()){
						$dept_ID = $row['Department_ID'];
					    $deptName = $row['Department_Name'];
					    echo "<option value='".$dept_ID."'>".$deptName."</option>";
					  }
				?>			
			</select> 
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
<?php
require_once('footer.php');
?>