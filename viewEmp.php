<?php
	require_once('bs.php');
	require_once('nav.php');
	require_once('db_cred.php');
?>

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
	
	echo "<div class='table-responsive col-xs-12'>";
	echo "<table id ='employee' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Employee ID</th><th class='col-xs-2'>First Name</th><th class='col-xs-2'>Last Name</th><th class='col-xs-2'>Position</th><th class='col-xs-1'>Type</th><th class='col-xs-1'>Shift</th><th class='col-xs-1'>Department ID</th><th class='col-xs-2'>Start Date</th></tr></thead><tbody>";
				//       ^<th class='col-xs-1'>Action</th>
				while($row = $vSql->fetch()){
				
					echo "<tr> <td>" . $row['Emp_ID'] . "</td>"
						 //."<td>" . $row['Emp_ID'] . "</td>"
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


?>
	