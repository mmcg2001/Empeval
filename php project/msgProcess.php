<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
$id = $_SESSION['id'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
require_once('db_cred.php');

//connecting to the database
try {
  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
}
catch(PDOException $e) {
	echo $e->getMessage();
}

$subject = $_POST['subject'];
$msg = $_POST['message'];
$date = date('Y-m-d');
foreach($_POST['assign_Recip'] as $reciever){
	$iSql = $dbc->prepare('Insert into Messages(To_ID, From_ID, Subject, Message, Sent_Date) Values (:to, :from, :subject, :msg, :date)');
	$iSql->bindValue(':to', $reciever);
	$iSql->bindValue(':from', $id);
	$iSql->bindValue(':subject', $subject);
	$iSql->bindValue(':msg', $msg);
	$iSql->bindValue(':date', $date);
	$chk = $iSql->execute();
}
	if($chk == true){
			header("Location: UpdateSuccess.php");
	}
	else{
		echo "Something went wrong. Try making sure all fields are selected and filled.";
	}
?>