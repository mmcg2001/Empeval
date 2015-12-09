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
$id = $_POST['dept_ID'];
$dept = $_POST['deptName'];
$deptSuper = $_POST['deptSuper'];

//connecting to the database
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
//SQL to update an employee
$uSql = $dbc->prepare("Update Department
					   Set Department_Name = :deptName,
						   Supervisor_ID = :deptSuper
						   where Department_ID = '$id'");
$uSql->bindValue(':deptName', $dept);
$uSql->bindValue(':deptSuper', $deptSuper);

//running the query							
$uemp = $uSql->execute();
//if query runs successfully send to this page, else output a message.							
if($uemp == true){
	redirect('UpdateSuccess.php');
}
else{
	echo "Did not work";
}

//function used to send to UpdateSuccess
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