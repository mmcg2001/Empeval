<?php

$type = $_SESSION['type'];

if($type == ''){
	header('Location: login.php');
}
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() { $('#employee').DataTable(); } );
</script>
</head>
<?php

	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	$vSql = $dbc->prepare("Select * from Employee");
	
	$vSql->execute();
	
	$vSql->setFetchMode(PDO::FETCH_ASSOC);
	
	echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class='table-responsive col-xs-12'>";
	echo "<table id ='employee' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Action</th><th class='col-xs-1'>Employee ID</th><th class='col-xs-2'>First Name</th><th class='col-xs-2'>Last Name</th><th class='col-xs-2'>Position</th><th class='col-xs-1'>Type</th><th class='col-xs-1'>Shift</th><th class='col-xs-1'>Department ID</th><th class='col-xs-2'>Start Date</th></tr></thead><tbody>";
				while($row = $vSql->fetch()){
								
				$tmpID = $row['Emp_ID'];
				
					echo "<tr> <td><a href='viewProfile.php?id=$tmpID'><span class = 'glyphicon glyphicon-folder-open'></span></a>&nbsp;&nbsp;<a href='editEmp.php?id=$tmpID'<span class = 'glyphicon glyphicon-pencil'></span></a>&nbsp;&nbsp;<a href='delete.php?id=$tmpID'<span class = 'glyphicon glyphicon-remove'></span></a> </td>"
       					 ."<td>" . $row['Emp_ID'] . "</td>"
						 ."<td>" . $row['Emp_FName'] . "</td>"
						 ."<td>" . $row['Emp_LName'] . "</td>"
						 ."<td>" . $row['Emp_Position'] . "</td>"
						 ."<td>" . $row['Emp_Type'] . "</td>"
						 ."<td>" . $row['Emp_Shift'] . "</td>"
						 ."<td>" . $row['Emp_DepartmentID'] . "</td>"
						 ."<td>" . $row['Emp_StartDate'] ."</td></tr>";
				}
	echo "</tbody></table>";
	
	echo "<a href='createEmp.php' class='btn btn-warning active' role='button'>Add New</a>";
echo "</div>";
echo "</div>"; 

require_once('footer.php');
?>
	