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
<div class="container-fluid bg-2 text-center">
<h2> Assign Work Instructions </h2>
<div class = 'col-xs-4'>
		<form method = 'post' action = ''>
		<?php
			echo "Select Department";
			echo "<br/>";
			$sSql = $dbc->prepare('Select * from Department');
			
			$sSql->execute();
			
			$sSql->setFetchMode(PDO::FETCH_ASSOC);
			?>
			<select name = 'dept' onchange = 'this.form.submit();'>
				<?php 
					if($_POST['dept'] == true){ 
						echo "<option value = " . $_POST['dept']. " selected = 'selected'>".$_POST['dept']."</option>";
					} else{
				?>
					<option>Select Department</option>
				<?php 
					  }
					while($dRow = $sSql->fetch()){
						$deptName= $dRow['Department_Name'];
						$dID = $dRow['Department_ID'];
						echo "<option value='".$deptName."'>".$deptName."</option>";
					}
				?>	
			</select>
			<input type = 'hidden' name = 'dept_ID' value = <?php echo $dID; ?>>
		</form>
	</div>	

	<div class = 'col-xs-4'>
		<form method = 'post' id = 'form2' action = 'assignProcess.php'>
		<?php
			if(!isset($_POST['dept'])){
				echo "Please select a department from the drop down menu";
			}
			else{
				$dept = $_POST['dept'];
				echo "Select Work Instructions";
				echo "<br/>";
				
				$tSql = $dbc->prepare("Select * from Training_Info where Dept_Required = '$dept'");

				$tSql->execute();

				$tSql->setFetchMode(PDO::FETCH_ASSOC);
				

				while($row = $tSql->fetch()){
					$tID = $row['Training_ID'];
					$tTitle = $row['Training_Title'];
					echo "<input type='checkbox' name='wInstruction[]' value='$tID'>$tTitle<br>";
				}
			}
		?>
	</div>
	
	
		<div class = 'col-xs-4'>
		
			<?php
			
			if(!isset($_POST['dept'])){
				//echo "Please select a department from the drop down menu";
			}
			else{				
				$dept_ID = $_POST['dept_ID'];
				
				
				echo "Select Employee(s) to be assigned a work instruction";
				echo "<br/>";
				 $aSql = $dbc->prepare("Select * from Employee, Department where Emp_DepartmentID = Department_ID Order by Department_ID");
				
				$aSql->execute();
				
				$aSql->setFetchMode(PDO::FETCH_ASSOC);
				
				echo "<div col-xs-12'>";
				echo "<select name='assign_Emp[]' class = 'form-control' size= '10' multiple='multiple'>";


				while($aRow = $aSql->fetch()){
					$eID = $aRow['Emp_ID'];
					$fname = $aRow['Emp_FName'];
					$lname = $aRow['Emp_LName'];
					$name = $fname . ' ' . $lname;
					$eDept = $aRow['Department_Name'];
					
					echo "<option value='$eID'>".$name."</option>";
				} 
				
				echo "</select>";
			
			?>
				<br/>
				<input class = 'btn-lg btn-warning' type = 'submit' name = 'submit' value = 'Assign Training'/>
				<input type = 'hidden' name = 'dept_ID' value = <?php echo $_POST['dept_ID']; ?>>
	    <?php } echo "</div>"; ?>
		
		</div>
	</form>	
</div>
<?php
require_once('footer.php');
?>