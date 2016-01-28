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
//referencing the bootstrap, nav bar, and database information.
	require_once('nav.php');
	require_once('bs.php');
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
			
			
			$tw = date('Y-m-d',strtotime("+ 14 days"));
			$td = date('Y-m-d',strtotime("+ 30 days"));
			$nd = date('Y-m-d',strtotime("+ 90 days"));
			
			
			$iTSql = $dbc->prepare("Insert into Timed_Evaluations(Employee_ID, Training_ID, TwoWeek, ThirtyDays, NinetyDays) VALUES ('$emp', '$instruction', '$tw', '$td', '$nd' )");
			$tchk = $iTSql->execute();
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
			
			$tw = date('Y-m-d',strtotime("+ 14 days"));
			$td = date('Y-m-d',strtotime("+ 30 days"));
			$nd = date('Y-m-d',strtotime("+ 90 days"));
			
			$uTSql = $dbc->prepare("Update Timed_Evaluations
									Set TwoWeek = '$tw',
										ThirtyDays = '$td',
										NinetyDays = '$nd'
										where Employee_ID = '$emp'
										and Training_ID = '$instruction'");
			$tchk = $uTSql->execute();		
		}
		
	} 

 }
	if($chk == true && $tchk == true){
		echo "<div class = 'container-fluid bg-2 text-center'>";
		echo "Instructions Assigned.";
		echo "<br/><br/>";
		echo "<a href='assignTraining.php' class='btn btn-warning' role='button'>Assign More Training</a>&nbsp;&nbsp;<a href = 'viewProfile.php?id=$sid' class='btn btn-success' role='button'>Return Home</a>";
		echo "</div>";
	}
	else{
		echo "Did not work.";
	}
	
	require_once('footer.php');
?>