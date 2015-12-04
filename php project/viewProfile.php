<?php
session_start();

$type = $_SESSION['type'];

if($type == ''){
	header('Location: login.php');
}
	
	require_once('nav.php');
	require_once('bs.php');
	require_once('db_cred.php');
?>
<?php

	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	$tmpID = $_GET['id'];
	
	if($tmpID > ""){
		$eSql = $dbc->prepare("Select * from Employee where Emp_ID = '" . $tmpID . "'");		
	}
	else{
		redirect('home.php');
		exit();
	}

	
	$eSql->execute();
	
	$eSql->setFetchMode(PDO::FETCH_ASSOC);
	$row = $eSql->fetch();
		$id = $row['Emp_ID'];
		$fname = $row['Emp_FName'];
		$lname = $row['Emp_LName'];
		$pos = $row['Emp_Position'];
		$type = $row['Emp_Type'];
		$shift = $row['Emp_Shift'];
		$dept = $row['Emp_DepartmentID'];
		$start = $row['Emp_StartDate'];
		
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
?>
<head>

	<style>
		form {border: 2.5px solid;}
	</style>

</head>
<div class="container-fluid bg-2 text-center">
	<h2 align = 'center'><b><?php echo $fname . " " . $lname . "'s Profile"; ?></b></h2>	
	<div class = 'col-xs-4'>
		<form>
			<h4 align = 'center'><font color = 'FFFFFF'> Personal Information </font></h4>
			<label for="ID">ID: </label> <?php echo $id; ?> <br/> 
			<label for="First Name">First Name: </label> <?php echo $fname; ?> <br/>
			<label for="Last Name">Last Name: </label> <?php echo $lname; ?> <br/>
			<label for="Position">Position: </label> <?php echo $pos; ?> <br/>
			<label for="Type">Type: </label> <?php echo $type; ?> <br/>
			<label for="Shift">Shift: </label> <?php echo $shift; ?> <br/>
			<label for="Description">Department: </label> <?php echo $dept; ?> <br/>
			<label for="Start Date">Start Date: </label> <?php echo $start; ?> <br/>
			<?php echo "<a href='editEmp.php?id=$id' class='btn btn-warning active' role='button'>Edit Info</a>"; ?> <br/><br/>
			
		</form>
	</div>
	<div class = 'col-xs-8'>
		<form> This is another form, just for outlining at the moment!
		</form>
	</div>
</div>
<?php
require_once('footer.php');
?>