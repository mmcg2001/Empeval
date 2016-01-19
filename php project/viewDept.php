<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}

$myID = $_SESSION['id'];
$myUserType = $_SESSION['uType'];
//reference the bootstrap, nav bar, and database information		
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');
?>
<html>
<head>
<!-- CSS and JavaScript need for the responsive datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() { $('#dept').DataTable(); } );
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
	$vSql = $dbc->prepare("Select Department_ID, Department_Name, Supervisor_ID, Emp_FName, Emp_LName from Department , Employee where Supervisor_ID = Emp_ID");
	//running the SQL statment
	$vSql->execute();
	//retrieving the dataset from the query
	$vSql->setFetchMode(PDO::FETCH_ASSOC);
	
	//building the table to display the data
	echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class='table-responsive col-xs-12'>";
	echo "<table id ='dept' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Action</th><th class='col-xs-1'>Department ID</th><th class='col-xs-2'>Department Name</th><th class='col-xs-2'>Supervisor Name</th></thead><tbody>";
				//looping through the found data
				while($row = $vSql->fetch()){
				//setting a temporary variable equal to the Emp_ID			
				$tmpID = $row['Department_ID'];
				$fName = $row['Emp_FName'];
				$lName = $row['Emp_LName'];
				$name = $fName . ' ' . $lName;
				
				if($myID == $row['Supervisor_ID'] || $myUserType == "admin"){					
					$status = 'active';
				}
				else{
					$status = 'not-active';
				}
				
								
					//displaying the data in the table
					echo "<tr> <td><a href='showDept.php?id=$tmpID' data-toggle='tooltip' title='View Department'><span class = 'glyphicon glyphicon-folder-open'></span></a>&nbsp;&nbsp;<a href='editDept.php?id=$tmpID' data-toggle='tooltip' title='Edit Employee'class = $status><span class = 'glyphicon glyphicon-pencil'></span></a>&nbsp;&nbsp;<a href='deleteDept.php?id=$tmpID' data-toggle='tooltip' title='Delete Department' class = $status><span class = 'glyphicon glyphicon-remove'></span></a></td>"
       					 ."<td>" . $row['Department_ID'] . "</td>"
						 ."<td>" . $row['Department_Name'] . "</td>"
						 ."<td>" . $name . "</td></tr>";
				}
	echo "</tbody></table>";
	//add new button
	echo "<a href='createDept.php' class='btn btn-warning active' role='button'>Add New</a>";
echo "</div>";
echo "</div>"; 
//including the footer
require_once('footer.php');
?>