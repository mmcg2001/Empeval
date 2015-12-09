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

//setting the id variable from the previously submitted form
$id = $_POST['dept_ID'];

	//connecting to the database
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
//SQL query to delete a user
$dSql = $dbc->prepare("Delete from Department where Department_ID = '$id'");
//run the query							
$demp = $dSql->execute();
//if delete was successful send to this page, else display a message							
if($demp == true){
	redirect('DeleteSuccess.php');
}
else{
	echo "Did not work";
	exit();
}							
//function used to send the user to the DeleteSuccessful page.						
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