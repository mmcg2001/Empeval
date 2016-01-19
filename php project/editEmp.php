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
		$eSql = $dbc->prepare("Select * from Employee, Department where Emp_ID = '" . $tmpID . "' AND Department_ID = Emp_DepartmentID");		
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
	//set variables equal to the data set from the query
		$fName = $row['Emp_FName'];
		$lName = $row['Emp_LName'];
		$position = $row['Emp_Position'];
		$type = $row['Emp_Type'];
		$shift = $row['Emp_Shift'];
		$dept = $row['Emp_DepartmentID'];
		$start = $row['Emp_StartDate'];
		$deptName = $row['Department_Name'];
		$current = $row['Current'];
		
		if($current == '1'){
			$curr = 'Yes';
		}
		else{
			$curr = 'No';
		}
		
//Sql query to pull data from the employee table
$dSql = $dbc->prepare("Select * from Department"); 
//running the query
$dSql->execute();
//fetching the dataset
$dSql->setFetchMode(PDO::FETCH_ASSOC);
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
		<form method = 'post' action = 'editEmpProcess.php'>
		 <!-- formatting the form  --> 
			<div class = 'col-xs-4'></div>
				<div class = 'col-xs-4'>
				  <!-- check if the variables hold a value, if not use a placeholder in the textbox -->
					<div class = 'form-group'>
						<input type = 'hidden' name ='emp_ID' value = "<?php echo $tmpID;?>" />
						<label for="fName">First Name: </label>
							<?php if($fName>""){ ?>
								<input type="text" class="form-control" name="fName" id="fName"  value="<?php echo $fName; ?>">
							<?php } else { ?>
								<input type="text" class="form-control" name="fName" id="fName"  placeholder="First Name">
							<?php } ?>
					</div>
					<div class = 'form-group'>
						<label for="lName">Last Name: </label>
							<?php if($lName>""){ ?>
								<input type="text" class="form-control" name="lName" id="lName"  value="<?php echo $lName; ?>">
							<?php } else { ?>
								<input type="text" class="form-control" name="lNname" id="lName"  placeholder="Last Name">
							<?php } ?>
					</div>
					<div class = 'form-group'>
						<label for="Position">Position: </label>
							<?php if($position>""){ ?>
								<input type="text" class="form-control" name="ePosition" id="ePosition"  value="<?php echo $position; ?>">
							<?php } else { ?>
								<input type="text" class="form-control" name="ePosition" id="ePosition"  placeholder="Position">
							<?php } ?>
					</div>
					<div class = 'form-group'>
						<label for="eType">Type: </label>
						<?php if($type > ""){ ?>
							<select name = "eType" class = "form-control">
								<option value="<?php echo $type ?>"><?php echo $type; ?></option>
								<?php if($type == "Koyo"){ ?>
								<option value="Temp">Temp</option>
								<?php } else if ($type == "Temp") { ?>
								<option value="Koyo">Koyo</option>
								<?php } ?>
							</select>
							<?php } else { ?>
								<select name = "eType" class = "form-control">
									<option value ="Temp">Temp</option>
									<option value ="Koyo">Koyo</option>
								</select>
							<?php } ?> 
					</div>
					<div class = 'form-group'>	
						<label for="eShift">Shift: </label>
						<?php if($shift > ""){ ?>
							<select name = "eShift" class = "form-control">
								<option value="<?php echo $shift ?>"><?php echo $shift; ?></option>
								<?php if($shift == "First"){ ?>
								<option value="Second">Second</option>
								<?php } else if ($shift == "Second") { ?>
								<option value="First">First</option>
								<?php } ?>
							</select>
							<?php } else { ?>
								<select name = "eShift" class = "form-control">
									<option value ="First">First</option>
									<option value ="Second">Second</option>
								</select>
							<?php } ?> 
					</div>
															
					<div class = 'form-group'>
					<label for="eDept">Department: </label>
					<?php if($dept > ""){ ?>
						<select name = "eDept" class = "form-control">
							 <option value = <?php echo $dept; ?>> <?php echo $deptName; ?></option>
							 	<option>---------------</option>
								<?php while($row = $dSql->fetch()){
										$dept_ID = $row['Department_ID'];
										$deptN = $row['Department_Name'];
										echo "<option value='".$dept_ID."'>".$deptN."</option>";
									}
								?>	
						</select>
						<?php } else { ?>
							<select name = "eDept" class = "form-control">
								<option value =" ">Select</option>
							</select>
						<?php } ?> 
					</div>
					
					<div class = 'form-group'>
						<label for="eStart">Start Date: </label>
						<?php if($position>""){ ?>
							<input type="date" class="form-control" name="eStart" id="eStart"  value="<?php echo $start; ?>">
						<?php } else { ?>
							<input type="date" class="form-control" name="eStart" id="eStart"  placeholder="Start Date">
						<?php } ?>
					</div>
						
					<div class = 'form-group'>	
						<label for="curr">Current Employee: </label>
						<?php if($shift > ""){ ?>
							<select name = "curr" class = "form-control">
								<option value="<?php echo $curr ?>"><?php echo $curr; ?></option>
								<?php if($curr == "Yes"){ ?>
								<option value="0">No</option>
								<?php } else if ($curr == "No") { ?>
								<option value="1">Yes</option>
								<?php } ?>
							</select>
							<?php } else { ?>
								<select name = "curr" class = "form-control">
									<option value ="1">Yes</option>
									<option value ="0">No</option>
								</select>
							<?php } ?> 
					</div>
					<br/>
					<div class = 'form-group'>
						<input class = "btn-lg btn-success" type = 'submit' name = 'submit' />
						<input class = 'btn-lg btn-danger' onclick='goBack()' type = 'button' name ='back' value = 'back'/>					
					</div>
					
					</div>
				</div>
		</form>
	</div>
</body>
</html>