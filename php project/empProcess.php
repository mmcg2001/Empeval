<?php

//starts the session	
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
//referencing the bootstrap, nav bar, and database information.
	require_once('nav.php');
	require_once('bs.php');
	require_once('db_cred.php');
?>

<?php
//getting data from the previous page and placing information into variables.
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$position = $_POST['ePosition'];
$shift = $_POST['eShift'];
$type = $_POST['eType'];
$department = $_POST['eDep'];
$startDate = $_POST['eStart'];
$user = strtolower(substr($fName, 0, 1) . $lName);
$pass = "pass";

//connecting to the database
	 try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	//Sql statement to determine part of the user name
	$cSql = $dbc->prepare("Select Count(Emp_ID) from Employee");
	//running the sql
	$cSql->execute();
	//getting the result
	$id = $cSql->fetchcolumn() + 1;
	
	//SQL to insert into the database.
	$iSql =  $dbc->prepare("Insert into Employee (Emp_FName, Emp_LName, Emp_Position, Emp_Shift, Emp_Type, Emp_DepartmentID, Emp_StartDate, Username, Password) Values (:fName, :lName, :pos, :shift, :type, :dept, :start, :user, :pass)");
	//binding variables to the placeholders by value, help protect against SQL injection
	$iSql->bindValue(':fName', $fName);
	$iSql->bindValue(':lName', $lName);
	$iSql->bindValue(':pos', $position);
	$iSql->bindValue(':shift', $shift);
	$iSql->bindValue(':type', $type);
	$iSql->bindValue(':dept', $department);
	$iSql->bindValue(':start', $startDate);
	$iSql->bindValue(':user', $user.$id);
	$iSql->bindValue(':pass', $pass);
	$chk = $iSql->execute();
	
	//if it runs correctly 
	if($chk == TRUE){
		echo "Employee had been entered.";
		echo "<br/><br/>";
		echo "<a href='viewEmp.php'> Click to Return to Employee list</a>";
	}
	else{
		echo "did not work.";
	} 

?>
