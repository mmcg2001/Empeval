<?php
//starts the session	
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
//reference the bootstrap, nav bar, and database information	
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');

$myID = $_SESSION['id'];
$myUserType = $_SESSION['uType'];

?>
<html>
<head>
<!-- CSS and JavaScript need for the responsive datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() { $('#employee').DataTable(); } );
</script>

<!-- disable the clickable glyphs -->
<style>
.not-active {
 pointer-events: none;
 cursor: default;
}
</style>

</head>
<?php
	//connecting to the database
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	//SQL query
	$vSql = $dbc->prepare("Select * from Employee, Department where Department_ID = Emp_DepartmentID and Current = '0'");
	//running the SQL statement
	$vSql->execute();
	//retrieving the dataset from the query
	$vSql->setFetchMode(PDO::FETCH_ASSOC);
	
	//building the table to display the data
	echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class='table-responsive col-xs-12'>";
	echo "<table id ='employee' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Action</th><th class='col-xs-1'>Employee ID</th><th class='col-xs-2'>First Name</th><th class='col-xs-1'>Last Name</th><th class='col-xs-2'>Position</th><th class='col-xs-1'>Type</th><th class='col-xs-1'>Shift</th><th class='col-xs-1'>Department Name</th><th class='col-xs-2'>Start Date</th><th class='col-xs-2'>User Name</th></tr></thead><tbody>";
				//looping through the found data
				while($row = $vSql->fetch()){
				//setting a temporary variable equal to the Emp_ID			
				$tmpID = $row['Emp_ID'];
					//displaying the data in the table
					if($myUserType == "admin"){					
						$status = 'active';
					}
					else{
						$status = 'not-active';
					}
					
										
					echo "<tr> <td><a href='viewProfile.php?id=$tmpID' data-toggle='tooltip' title='View Profile'><span class = 'glyphicon glyphicon-folder-open'></span></a>&nbsp;&nbsp;<a href='editEmp.php?id=$tmpID' data-toggle='tooltip' title='Edit Employee' class = $status><span class = 'glyphicon glyphicon-pencil'></span></a>&nbsp;&nbsp;<a href='deleteEmp.php?id=$tmpID' data-toggle='tooltip' title='Delete Employee' class = $status><span class = 'glyphicon glyphicon-remove'></span></a></td>"
       					 ."<td>" . $row['Emp_ID'] . "</td>"
						 ."<td>" . $row['Emp_FName'] . "</td>"
						 ."<td>" . $row['Emp_LName'] . "</td>"
						 ."<td>" . $row['Emp_Position'] . "</td>"
						 ."<td>" . $row['Emp_Type'] . "</td>"
						 ."<td>" . $row['Emp_Shift'] . "</td>"
						 ."<td>" . $row['Department_Name'] . "</td>"
						 ."<td>" . $row['Emp_StartDate'] ."</td>"
						 ."<td>" . $row['Username'] ."</td></tr>";
					
				}
	echo "</tbody></table>";
	//add new button
echo "</div>";
echo "</div>"; 

require_once('footer.php');
?>