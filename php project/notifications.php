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
		
	//connects to the database
	try {
		$dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	
	
	
	
	
	
	
	
	
	
	
?>	
	