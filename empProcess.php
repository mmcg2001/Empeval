<?php
	require_once('nav.php');
	require_once('bs.php');
	require_once('db_cred.php');
?>

<?php

/* 	$db_hostname = 'localhost';
	$db_username = 'samarc';
	$db_userpass = 'Iworkatkoyo15';
	$db_dbname = 'Koyo'; */


$fName = $_POST['fName'];
$lName = $_POST['lName'];
$position = $_POST['ePosition'];
$shift = $_POST['eShift'];
$type = $_POST['eType'];
$department = $_POST['eDep'];
$startDate = $_POST['eStart'];
$user = strtolower(substr($fName, 0, 1) . $lName);
$pass = pass;


	 try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	$cSql = $dbc->prepare("Select Count(Emp_ID) from Employee");
	
	$cSql->execute();
	$id = $cSql->fetchcolumn() + 1;
	
	
	$iSql =  $dbc->prepare("Insert into Employee (Emp_FName, Emp_LName, Emp_Position, Emp_Shift, Emp_Type, Emp_DepartmentID, Emp_StartDate, Username, Password) Values ('$fName', '$lName', '$position', '$shift', '$type', '$department', '$startDate', '$user$id', '$pass')");

		
	$chk = $iSql->execute();
	
	if($chk == TRUE){
		echo "Employee had been entered.";
		echo "<br/><br/>";
		echo "<a href='viewEmp.php'> Click to Return to Employee list</a>";
	}
	else{
		"SQL command contains: ". $iSql ."<br/>";
	} 

?>
