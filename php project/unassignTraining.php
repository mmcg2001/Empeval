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
//setting the id variable from the previously submitted form
$id = $_GET['tmpID'];
$tID = $_GET['training'];

	//connecting to the database
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	

//SQL query to delete a user
$dSql = $dbc->prepare("Delete from Evaluation where Employee_ID = '$id' and Training_ID = '$tID'");
//run the query							
$demp = $dSql->execute();

$dTSql = $dbc->prepare("Delete from Timed_Evaluations where Employee_ID = '$id' and Training_ID = '$tID'");

$dTrain = $dTSql->execute();
//if delete was successful send to this page, else display a message							
if($demp == true && $dTrain == true){

echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.location.href='viewProfile.php?id=$id';
    </SCRIPT>");
}
else{
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Did not work.')
    window.location.href='viewProfile.php?id=$id';
    </SCRIPT>");
	exit();
}							

?>