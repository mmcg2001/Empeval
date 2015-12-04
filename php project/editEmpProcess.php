<?php
session_start();

$type = $_SESSION['type'];

if($type == ''){
	header('Location: login.php');
}
	
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');
?>
<?php
$fname = $_POST['fName'];
$lname = $_POST['lName'];
$pos = $_POST['ePosition'];
$type = $_POST['eType'];
$shift = $_POST['eShift'];
$dept = $_POST['eDept'];
$start = $_POST['eStart'];
$id = $_POST['emp_ID'];


	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

$uSql = $dbc->prepare("Update Employee
					   Set Emp_FName = '$fname',
						   Emp_LName = '$lname',
						   Emp_Position = '$pos',
						   Emp_Type = '$type',
						   Emp_Shift = '$shift',
						   Emp_DepartmentID = '$dept',
						   Emp_StartDate = '$start'
						   Where Emp_ID = '$id'");
							
$uemp = $uSql->execute();
							
if($uemp == true){
	redirect('UpdateSuccess.php');
}
else{
	echo "Did not work";
}							
							
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
