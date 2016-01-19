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
if($uType != 'admin'){
	header('Location: notAuthorized.php');
}
//reference the bootstrap, nav bar, and database information		

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
	if($id != $vRow['Supervisor_ID'] && $vRow['Emp_UserType'] != "admin"){					
		header("Location: viewProfile.php?id=$id");
	}
require_once('bs.php');
require_once('nav.php');
?>
<?php

	
	//getting the id passed from the URL
	$tmpID = $_GET['id'];
	
	//if $tmpID is set run this query, or else send it back to the home page.
	if($tmpID > ""){
		$eSql = $dbc->prepare("Select * from Department, Employee where Department_ID = '" . $tmpID . "' and Supervisor_ID = Emp_ID");		
	}
	else{
		redirect('home.php');
		exit();
	}
	
	//runs the query
	$eSql->execute();
	
	//retrieves the data set
	$eSql->setFetchMode(PDO::FETCH_ASSOC);
	$row = $eSql->fetch();
	$deptID = $row['Department_ID'];
	$deptName = $row['Department_Name'];
	$deptSuper = $row['Supervisor_ID'];
	$deptfName = $row['Emp_FName'];
	$deptlName = $row['Emp_LName'];
	$superName = $deptfName . ' ' . $deptlName;
	//link supervisor id to emp id to link the names
	
	
	//sql to generate names and id numbers in case of change in supervisors
	$sSql = $dbc->prepare("Select * from Employee");
	
	$sSql->execute();
	
?>
	
<html>
<head>
<!-- javascript to go back one page -->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
</head>
<!-- main form of the program -->
<body>
	<div class = 'container-fluid bg-2 text-center'>
		<form method = 'post' action = 'editDeptProcess.php'>
		 <!-- formatting the form  --> 
			<div class = 'col-xs-4'></div>
				<div class = 'col-xs-4'>
				  <!-- check if the variables hold a value, if not use a placeholder in the input boxes -->
					<div class = 'form-group'>
						<input type = 'hidden' name ='dept_ID' value = "<?php echo $deptID;?>" />
						<label for="deptName">Department Name: </label>
							<?php if($deptName>""){ ?>
								<input type="text" class="form-control" name="deptName" id="deptName"  value="<?php echo $deptName; ?>">
							<?php } else { ?>
								<input type="text" class="form-control" name="deptName" id="deptName"  placeholder="Department Name">
							<?php } ?>
					</div>
						<div class = 'form-group'>
						<label for="deptSuper">Supervisor: </label>
						<?php if($deptSuper > ""){ ?>
							<select name = "deptSuper" class = "form-control">
								 <option value = <?php echo $deptSuper; ?>> <?php echo $superName; ?></option>
								 <?php while($r = $sSql->fetch()){
										$id = $r['Emp_ID'];
										$fName = $r['Emp_FName'];
										$lName = $r['Emp_LName'];
										$name  = $fName . ' ' . $lName; 
										echo "<option value='".$id."'>".$name."</option>";
									  }?>
							</select>
							<?php } else { ?>
								<select name = "deptSuper" class = "form-control">
									<option value =" ">Select</option>
								</select>
							<?php } ?> 
					</div>
					<!-- Creating Buttons -->
					<div class = 'form-group'>
						<input class = "btn-lg btn-success" type = 'submit' name = 'Update Department' />
						<input class = 'btn-lg btn-danger' onclick='goBack()' type = 'button' name ='back' value = 'Back'/>					
					</div>
				</div>
				</div>
		</form>
	</div>
</body>
</html>

<?php
//including the footer
require_once('footer.php');
?>