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
<head>
<!-- CSS and JavaScript need for the responsive datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script type = "text/javascript">
	$(document).ready(function() {var oTable = $('#selection').DataTable(); } );
	
    $('#form').submit( function() {
    var sData = $('input', oTable.fnGetNodes()).serialize();
    alert( "The following data would have been submitted to the server: \n\n"+sData );
    return false;
} );
</script>
 </head>
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
				
				echo "<div class='table-responsive col-xs-12'>";
				echo "<table id ='selection' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";	
				echo "<thead><tr><th class='col-xs-2'>Select</th><th class = 'col-xs-2'>First Name</th><th class = 'col-xs-2'>Last Name</th><th class = 'col-xs-2'>Department</th></tr></thead><tbody>";
				
				while($aRow = $aSql->fetch()){
					$eID = $aRow['Emp_ID'];
					$fname = $aRow['Emp_FName'];
					$lname = $aRow['Emp_LName'];
					$eDept = $aRow['Department_Name'];
					
					echo "<tr><td><input type='checkbox' name='assign_Emp[]' value='".$eID."'/></td>"
						 . "<td>" .$fname. "</td>"
						 . "<td>" .$lname. "</td>"
						 . "<td>" . $eDept ."</td></tr>";
				} 
				
				echo "</tbody></table>";
				
				/* while($aRow = $aSql->fetch()){
				$eID = $aRow['Emp_ID'];
				$fname = $aRow['Emp_FName'];
				$lname = $aRow['Emp_LName'];
				$name = $fname . ' ' . $lname;
				echo "<input type='checkbox' name='assign_Emp[]' value='$eID'>".$name."<br/>"; 
				}  */
			
			?>
				<br/>
				<input class = 'btn-lg btn-warning' type = 'submit' name = 'submit' value = 'Assign Training'/>
				<input type = 'hidden' name = 'dept_ID' value = <?php echo $_POST['dept_ID']; ?>>
	    <?php } echo "</div>"; ?>
		
		</div>
	</form>	
</div>