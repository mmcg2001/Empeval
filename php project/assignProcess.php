<?php

//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
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

foreach($_POST['assign_Emp'] as $emp){
  foreach ($_POST['wInstruction'] as $instruction) {
		$sSql = $dbc->prepare("Select * from Evaluation where Employee_ID = $emp and Training_ID = $instruction");
		$sSql->execute();
			
		$rows = $sSql->fetchAll();
		$num_rows = count($rows);
		
		if($num_rows < 1){
			$aSql = $dbc->prepare("Insert Into Evaluation(Employee_ID, Training_ID, Evaluation_Score, Eval_Status) Values ('$emp', '$instruction', '0', '0')");
			
			$chk = $aSql->execute();
		}
		else{
			$uSql = $dbc->prepare("Update Evaluation
								   Set Evaluation_Score = 0,
									   Eval_Status = 0,
									   Instruction_Completed = '0000-00-00',
									   Eval_Completed = '0000-00-00'
									   where Training_ID = '$instruction'
									   and Employee_ID = '$emp'");
			
			$chk = $uSql->execute();
		
		}
		
	} 

 }
	if($chk == true){
		header("Location: UpdateSuccess.php");
	}
	else{
		echo "Did not work.";
	}
?>