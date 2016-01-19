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
?>
<?php


//Sql query to pull data from the employee table
$sSql = $dbc->prepare("Select * from Employee"); 
//running the query
$sSql->execute();
//fetching the dataset
$sSql->setFetchMode(PDO::FETCH_ASSOC);

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
<!-- Form for Department Creation -->

<div class="container-fluid bg-2 text-center">
	<h2>Create Department</h2><br/>	
	<form method = 'post' action = 'deptProcess.php'>
	  <div class = 'col-xs-4'> </div>
		<div class = 'col-xs-4'>
			<input class="form-control" type = 'text' name = 'deptName' placeholder = 'Department Name'/>
		<br/>
		    <!-- creating and using the result set from a query to populate the dropdown box -->
			<select  class="form-control" name = "dept_Supervisor">
				<option>Select Supervisor</option>
	            <?php while($row = $sSql->fetch()){
						$id = $row['Emp_ID'];
					    $fName = $row['Emp_FName'];
						$lName = $row['Emp_LName'];
					    $name  = $fName . ' ' . $lName; 
						echo "<option value='".$id."'>".$name."</option>";
					  }
				?>			
			</select> 
		<!-- Creating buttons -->	
		<br/>
		    <input class = "btn-lg btn-success" type = 'submit' name = 'submit' />
			<input class = 'btn-lg btn-warning' type = 'reset' value = 'clear'/>
			<br/><br/>
			<input class = 'btn-lg btn-danger' type = 'button' value = 'back' onclick = 'goBack()'/>
		</div>
	<form>
</div>
<html>

<?php
//including the footer
require_once('footer.php');
?>
