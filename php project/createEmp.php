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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<!-- Javascript for the back button -->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
	<script>
		  $(function() {
			$( "#datepicker" ).datepicker({
			  dateFormat: 'yy-mm-dd',
			  changeMonth: true,
			  changeYear: true
			});
		  });
	</script>
<head>
<body>
<!-- Form for Employee Creation -->

<div class="container-fluid bg-2 text-center">
	<h2 align = 'center'>Create Employee</h2>
	<form method = 'post' action = 'empProcess.php'>
	  <div class = 'col-xs-4'> </div>
		<div class = 'col-xs-4'>
			<div class="form-group">
				<label for="fName">First Name</label>
			<input class="form-control" type = 'text' name = 'fName' placeholder = 'First Name'/>
			</div>
			<div class="form-group">
				<label for="lName">Last Name</label>
			<input class="form-control" type = 'text' name = 'lName' placeholder = 'Last Name'/>
			</div>
			<div class="form-group">
				<label for="Position">Position</label>	
			<input class="form-control" type = 'text' name = 'ePosition' placeholder = 'Position'/>
			</div>
			<div class="form-group">
				<label for="eShift">Shift</label>
			<select  class="form-control" name = "eShift">
	               <option value="First">First</option>
				   <option value="Second">Second</option>
			</select>
			</div>
			<div class="form-group">
				<label for="Type">Employee Type</label>	
			<select  class="form-control" name = "eType">
	               <option value="Temp">Temp</option>
				   <option value="Koyo">Koyo</option>
			</select>
			</div>
			<div class="form-group">
				<label for="eUType">User Type</label>
			<select  class="form-control" name = "eUType">
				   <option value="user">User</option>
				   <option value="admin">Admin</option>
			</select>
			</div>
			
			<div class="form-group">
				<label for="eDep">Department</label>	
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
			</div>
			<div class="form-group">
				<label for="eStart">Start Date</label>	
			<input type="text" class="form-control" name="eStart" id="datepicker" placeholder="Date">
			</div>
			
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