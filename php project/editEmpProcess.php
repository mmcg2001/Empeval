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
?>
<?php
//pulling data from the previous page that was submitted, storing it into variables
$fname = $_POST['fName'];
$lname = $_POST['lName'];
$pos = $_POST['ePosition'];
$type = $_POST['eType'];
$shift = $_POST['eShift'];
$dept = $_POST['eDept'];
$start = $_POST['eStart'];
$id = $_POST['emp_ID'];

	//connecting to the database
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
//SQL to update an employee
$uSql = $dbc->prepare("Update Employee
					   Set Emp_FName = :fName,
						   Emp_LName = :lName,
						   Emp_Position = :pos,
						   Emp_Type = :type,
						   Emp_Shift = :shift,
						   Emp_DepartmentID = :dept,
						   Emp_StartDate = :start
						   Where Emp_ID = '$id'");
	//binding the placeholders to variables by value, help protect agains SQL injection
	$uSql->bindValue(':fName', $fname);
	$uSql->bindValue(':lName', $lname);
	$uSql->bindValue(':pos', $pos);
	$uSql->bindValue(':shift', $shift);
	$uSql->bindValue(':type', $type);
	$uSql->bindValue(':dept', $dept);
	$uSql->bindValue(':start', $start);
//running the query							
$uemp = $uSql->execute();
//if query runs successfully send to this page, else output a message.							
if($uemp == true){
	redirect('UpdateSuccess.php');
}
else{
	echo "Did not work";
}							
	//sends to UpdateSuccess.php						
function redirect($url){
	if (!headers_sent()){    
		header('Location: '.$url);
		exit;
	}
	else{  
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
		echo '</noscript>'; exit;
	}
}
?>
