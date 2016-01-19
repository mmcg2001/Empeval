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
?>

<html>
<title> Compose Message </title>
<body>

<div class="container-fluid bg-2 text-center">
	<h1 align = 'center'> Send Message </h1>
	<form method = 'post' action = 'msgProcess.php'>
	  		<div class = 'col-xs-3'>
		
			<?php

				echo "Select Recipients";
				echo "<br/>";
				 $aSql = $dbc->prepare("Select * from Employee where Current = '1'");
				
				$aSql->execute();
				
				$aSql->setFetchMode(PDO::FETCH_ASSOC);
				
				echo "<div col-xs-12'>";
				echo "<select name='assign_Recip[]' class = 'form-control' size= '10' multiple='multiple'>";


				while($aRow = $aSql->fetch()){
					$eID = $aRow['Emp_ID'];
					$fname = $aRow['Emp_FName'];
					$lname = $aRow['Emp_LName'];
					$name = $fname . ' ' . $lname;					
					echo "<option value='$eID'>".$name."</option>";
				} 
	
				echo "</select>";
				echo "</div>";
			?>
		</div>
	  <div class = 'col-xs-9'>
		<h4>Write Your Message</h4>
		<div class = 'form-group'>
			<input class="form-control" type = 'text' name = 'subject' placeholder = 'Subject'/>
		</div>
		<div class = 'form-group'>
			<textarea rows = '4' cols = '50' class = 'form-control' name = 'message' placeholder = 'Insert Message Here'></textarea>
		</div>
		
	  </div>
	  <div class = 'form-group'>
			<input class = "btn-lg btn-success" type = 'submit' name = 'submit' value = 'Send' />
			<input class = 'btn-lg btn-danger' type = 'button'  value = 'Back' onclick = "goBack()"/>
				<script>
					function goBack() {
						window.history.back();
					}
				</script>
		</div>
	</form>
</div>
</body>
</html>
<?php
	require_once('footer.php');
?>