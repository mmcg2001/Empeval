<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
$uType = $_SESSION['uType'];
$id = $_SESSION['id'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
if($uType != 'admin'){
	header('Location: notAuthorized.php');
}
//reference database information		

require_once('db_cred.php');

//connecting to the database
try {
  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
}
catch(PDOException $e) {
	echo $e->getMessage();
}

$vSql = $dbc->prepare("Select * from Employee, Department where Emp_ID = '$id' and Department_ID = Emp_DepartmentID");
	//running the SQL statement
	$vSql->execute();
	//retrieving the dataset from the query
	$vSql->setFetchMode(PDO::FETCH_ASSOC);
	$vRow = $vSql->fetch();
	if( $vRow['Emp_UserType'] != "admin"){					
		header("Location: viewProfile.php?id=$id");
	}

//reference the bootstrap, nav bar.
require_once('bs.php');
require_once('nav.php');
	//getting the id from the URL
	$tmpID = $_GET['id'];
	//if the id is holding a value use this query, if not send back to the home page.
	if($tmpID > ""){
		$eSql = $dbc->prepare("Select * from Department,Employee where Department_ID = '" . $tmpID . "' and Supervisor_ID = Emp_ID");		
	}
	else{
		redirect('home.php');
		exit();
	}
	//run the query
	$eSql->execute();
	//fetch the dataset from the query
	$eSql->setFetchMode(PDO::FETCH_ASSOC);
	$row = $eSql->fetch();
	$deptName = $row['Department_Name'];
	$deptSuper = $row['Supervisor_ID'];
	$deptSupName = $row['Emp_FName'] . ' ' . $row['Emp_LName'];
	
	
	//function used to send the user back to the homepage if there isn't an ID selected
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
?>
<html>
<head>
	<!-- javascript to go back a page, for the back button -->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
<head>
<!-- starting the form -->
<body>
	<div class = 'container-fluid bg-2 text-center'>
		<form method = 'post' action = 'deleteDeptProcess.php'>
		  <!-- formatting the form -->
			<div class = 'col-xs-4'></div>
				<div class = 'col-xs-4'>
				  <!-- check if variables are set, if not use placeholders in the textbox -->
					<div class = 'form-group'>
						<input type = 'hidden' name ='dept_ID' value = "<?php echo $tmpID;?>" />
						<label for="deptName">Department Name: </label>
							<?php if($deptName>""){ ?>
								<input type="text" class="form-control" name="deptName" id="deptName"  value="<?php echo $deptName; ?>"disabled>
							<?php } else { ?>
								<input type="text" class="form-control" name="deptName" id="deptName"  placeholder="Department Name"disabled>
							<?php } ?>
					</div>
					
					<div class = 'form-group'>
						<label for="deptSuper">Supervisor: </label>
						<?php if($deptSuper > ""){ ?>
							<select name = "deptSuper" class = "form-control" disabled>
								<option value="<?php echo $deptSuper ?>"><?php echo $deptSupName; ?></option>
							</select>
							<?php } else { ?>
							<select name = "deptSuper" class = "form-control" disabled>
								<option value ="select">Select</option>
							</select>
							<?php } ?> 
					</div>
					<!-- Creating buttons -->
					<div class = 'form-group'>
						<input class = "btn-lg btn-warning" type = 'submit' name = 'submit' value = "Delete" />
						<input class = 'btn-lg btn-danger' onclick='goBack()' type = 'button' name ='back' value = 'Back'/>					
					</div>
					
					</div>
				</div>
		</form>
	</div>
</body>
</html>