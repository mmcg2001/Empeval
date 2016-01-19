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
	
	//connecting to the database
	$from = $_POST['from'];
	$to = $_GET['tID'];
	
	if($to == 0){
		header('Location: notAuthorized.php');
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
	
	$sSql = $dbc->prepare("Select Emp_FName, Emp_LName from Employee where Emp_ID = " . $to);
	
	$sSql->execute();
	
	$sSql->setFetchMode(PDO::FETCH_ASSOC);
	
	$sRow = $sSql->fetch();
	
	$name = $sRow['Emp_FName']. ' ' . $sRow['Emp_LName'];
?>
<head>
	<!-- javascript to go back a page, for the back button -->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
<head>

<div class='container-fluid bg-2 text-center'/>
	<form method = 'post' action = 'msgProcess.php'>
	<div class = 'col-xs-3'></div>
	<div class = 'col-xs-6'>
		<h1>Compose Message To: <?php echo $name; ?></h1>
		<div class = 'form-group'>
			<input class="form-control" type = 'text' name = 'subject' placeholder = 'Subject'/>
		</div>
		<div class = 'form-group'>
				<textarea rows = '4' cols = '50' class = 'form-control' name = 'message' placeholder = 'Insert Message Here'></textarea>
		</div>
			
			<input type = 'hidden' name = 'assign_Recip[]' value ='<?php echo $to;?>'/>
		
		<div class = 'form-group'>
				<input class = "btn-lg btn-success" type = 'submit' name = 'submit' value = 'Send' />
				<input class = 'btn-lg btn-danger' type = 'button'  value = 'Back' onclick = "goBack()"/>
		</div>
		</form>
	</div>
</div>
<?php
	require_once('footer.php');
?>