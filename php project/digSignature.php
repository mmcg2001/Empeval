<?php

//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$id = $_SESSION['id'];
$type = $_SESSION['type'];
$uType = $_SESSION['uType'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}

//reference the bootstrap, nav bar, and database information		
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

$url = $_GET['test'];

$gSql = $dbc->prepare("Select Training_ID from Training_Info where Training_URL = '$url'");
//running the SQL statement
$gSql->execute();
//retrieving the dataset from the query
$gSql->setFetchMode(PDO::FETCH_ASSOC);
$row = $gSql->fetch();
?>

	<html>
	<head>
	<!-- Javascript for the back button -->
		<script>
			function goBack() {
				window.history.back();
			}
		</script>
		
	</head>
		<!-- form that submits to the same page it's on-->
		<div class="container-fluid bg-2 text-center">
		<h2> Confirmation of Completion </h2>
		<h4> By filling out this form you are confirming that you have completed the given work instruction </h4><br/>
		<form method = 'post' action = ''>
			<div class = 'col-xs-4'> </div>
			<div class = 'col-xs-4'>
				<label for = "pass">Please Type In Your First and Last Name: </label>
					<input class = "form-control" type 'text' name = 'name' required/><br/>
				<label><input class = "form-control" type="checkbox" required> Confirm Signature</label><br/>
				<input type = 'hidden' name = 'urlID' value = <?php echo $row['Training_ID']; ?> />
			<input class = "btn-lg btn-success" type = 'submit' name = 'submit' />
			<input class = 'btn-lg btn-danger' onclick='goBack()' type = 'button' name ='back' value = 'back'/>	
			</div>
		</form>
		</div>
	</html>
	
<?php
	//checks to see if the form was submitted, if so set local variables to the POSTed variables else do nothing
	if(isset($_POST['submit'])){
	$uName = $_SESSION['fName']. ' ' .$_SESSION['lName'];
	$uID = $_SESSION['id'];
	
	$urlID = $_POST['urlID'];
	$cName = $_POST['name'];
	
	$t=time();
		if($uName == $cName){
			$uSql = $dbc->prepare("Update Evaluation
					Set Instruction_Completed = '".date("Y-m-d",$t)."',
						Eval_Status = 1
						where Employee_ID = '$uID'
						and Training_ID = '$urlID'");
			$uEval = $uSql->execute(); 
			if($uEval == true){
				redirect('UpdateSuccess.php');
			}
			else{
				echo "Didn't work";
			}
		}
	}
					
				
		//function used to send the user to UpdateSuccess	
		function redirect($url)
		{
			if (!headers_sent())
			{    
				header('Location: '.$url);
				exit;
				}
			else
				{  
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.$url.'";';
				echo '</script>';
				echo '<noscript>';
				echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
				echo '</noscript>'; exit;
			}
		}
	
	require_once('footer.php');
?>