<?php
	session_start();
	
	$type = $_SESSION['type'];
	
	if($type == ''){
		/* echo "Not logged in.";
		echo "<br/><br/>";
		echo "<a href = 'login.php'>Return To Login Page</a>"; */
		header('Location: login.php');
	}
	require_once('nav.php');
	require_once('bs.php');
	require_once('bs.php');
	
	$user = $_SESSION['user'];
	$date = $_SESSION['date'];
	$fname = $_SESSION['fName'];
	$lname = $_SESSION['lName'];
	$name = $fname . ' '. $lname;
?>

<html>
<div class="container-fluid bg-2 text-center">
	<h2 align = 'center'><b><?php echo "Welcome ". $name . "!"; ?></b></h2>
	<h3 align = 'center'><b><?php echo $date; ?></b></h3>
</div>

</html>

