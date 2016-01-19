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
?>
<head>
	<!-- javascript to go back a page, for the back button -->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
<head>
<?php
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	$tmpID = $_GET['id'];
	
	$mSql = $dbc->prepare("Select * from Messages where M_ID = $tmpID");
	$mSql->execute();
	
	$mSql->setFetchMode(PDO::FETCH_ASSOC);

	$uSql = $dbc->prepare("Update Messages
						   Set M_Read = '1'
						   where M_ID = $tmpID");
	$chk = $uSql->execute();
	if($chk != true){
		echo "Update did not work";
	}
	
	$row = $mSql->fetch();
	 if($id != $row['To_ID'] && $id != $row['From_ID']){
		redirect('notAuthorized.php');
	}
	else{
	
	$sSql = $dbc->prepare("Select Emp_FName, Emp_LName from Employee where Emp_ID = " .$row['From_ID']);
	
	$sSql->execute();
	
	$sSql->setFetchMode(PDO::FETCH_ASSOC);
	
	$sRow = $sSql->fetch();
	
	$name = $sRow['Emp_FName']. ' ' . $sRow['Emp_LName'];
	
	
	echo"<div class='container-fluid bg-2 text-center'/>";
		 echo "<form method = 'post' action = 'reply.php'>";
		 echo "<div class = 'col-xs-3'></div>";
		 echo "<div class = 'col-xs-6'>";
		 echo "<h1>". $row['Subject']. ' From: '. $name. "</h1>";
		 echo "<div class = 'form-group'>";
		 echo "<textarea rows = '4' cols = '25' class = 'form-control' name = 'message'  disabled>".$row['Message']."</textarea>";
		 echo "</div>";
		 echo "<input type = 'hidden' name = 'subject' value = '".$row['Subject']."' />";
		 echo "<input type = 'hidden' name = 'from' value = '".$row['From_ID']."'/>";
		 echo "<input type = 'hidden' name = 'to' value = '".$row['To_ID']."'/>";
		 if($id == $row['To_ID']){
		 echo "<input class = 'btn-lg btn-success' type = 'submit' value = 'Reply'/>";
		 echo "&nbsp;";
		 }
		 echo "<input class = 'btn-lg btn-danger' onclick='goBack()' type = 'button' name ='back' value = 'Back'/>";
		 echo "</div>";
		 echo "</form>";
	echo"</div>";
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
	
	require_once('footer.php');
	?>
