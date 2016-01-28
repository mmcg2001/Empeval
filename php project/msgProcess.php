<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
$sid = $_SESSION['id'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
	require_once('bs.php');
	require_once('nav.php');
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
	$iSql->bindValue(':from', $sid);
	$iSql->bindValue(':subject', $subject);
	$iSql->bindValue(':msg', $msg);
	$iSql->bindValue(':date', $date);
	$chk = $iSql->execute();
}
	if($chk == true){
		
		echo "<div class = 'container-fluid bg-2 text-center'>";
		echo "Message has been entered.";
		echo "<br/><br/>";
		echo "<a href='inbox.php' class='btn btn-warning' role='button'>Return to Inbox</a>&nbsp;&nbsp;<a href = 'viewProfile.php?id=$sid' class='btn btn-success' role='button'>Return Home</a>";
		echo "</div>";
	}
	else{
		echo "Something went wrong. Try making sure all fields are selected and filled.";
	}
	
	require_once('footer.php');
?>