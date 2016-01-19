<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
//reference the bootstrap, nav bar, and database information		
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');
?>
<?php
//connecting to the database
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	//pull the id from the URL
	$tmpID = $_GET['id'];
	//if the variable is not blank prepare the SQL statement, else send back to the home page
	if($tmpID > ""){
		$eSql = $dbc->prepare("Select * from Department, Employee where Department_ID = '" . $tmpID . "' and Supervisor_ID = Emp_ID");		
	}
	else{
		redirect('home.php');
		exit();
	}
		//run the query
	$eSql->execute();
	//fetch the result dataset from the query
	$eSql->setFetchMode(PDO::FETCH_ASSOC);
	$row = $eSql->fetch();
	
	if($myID == $row['Supervisor_ID'] || $myUserType == "admin"){					
		$status = 'active';
	}
	else{
		$status = 'not-active';
	}
	
	$id = $row['Department_ID'];
	$deptName = $row['Department_Name'];
	$fName = $row['Emp_FName'];
	$lName = $row['Emp_LName'];
	$name = $fName . ' ' . $lName;
	
	
	//function used to send users back to the home page if the id was blank.
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
   <!--formatting for the form-->
	<style>
		form {border: 2.5px solid;}
	</style>

<!-- CSS and JavaScript need for the responsive datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() { $('#dept').DataTable(); } );
</script>

<!-- disable the clickable glyphs -->
<style>
.not-active {
 pointer-events: none;
 cursor: default;
}
</style>
</head>
<div class="container-fluid bg-2 text-center">
	<h2 align = 'center'><b><?php echo $deptName . " Department"; ?></b></h2>	
	<div class = 'col-xs-4'>
		<form>
			<h4 align = 'center'><font color = 'FFFFFF'> Department Information </font></h4>
			<label for="ID">Department ID: </label> <?php echo $id; ?> <br/> 
			<label for="Department Name">Department Name: </label> <?php echo $deptName; ?> <br/>
			<label for="Supervisor Name">Supervisor Name: </label> <?php echo $name; ?> <br/>
			<?php echo "<a href='editDept.php?id=$id'  class='btn btn-warning active' role='button'>Edit Info</a>"; ?> <br/><br/>
		</form>
	</div>
	<div class='col-xs-8'>
			<?php
				
				 $vSql = $dbc->prepare("Select * from Employee, Department where Emp_DepartmentID = '".$id."' and Department_ID = Emp_DepartmentID" );
				
				$vSql->execute();
				
				$vSql->setFetchMode(PDO::FETCH_ASSOC);
				
				echo "<table id ='dept' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
				echo "<thead><tr><th class='col-xs-1'>Action</th><th class='col-xs-1'>Employee ID</th><th class='col-xs-2'>First Name</th><th class='col-xs-2'>Last Name</th><th class='col-xs-2'>Position</th><th class='col-xs-1'>Type</th><th class='col-xs-1'>Shift</th><th class='col-xs-2'>Start Date</th></tr></thead><tbody>";
				//looping through the found data
				while($r = $vSql->fetch()){
				//setting a temporary variable equal to the Emp_ID			
				$tmpID = $r['Emp_ID'];
				
				//displaying the data in the table
					
					
					//displaying the data in the table
					echo "<tr> <td><a href='viewProfile.php?id=$tmpID' data-toggle='tooltip' title='View Employee Profile' class = $status><span class = 'glyphicon glyphicon-folder-open'></span></a>&nbsp;&nbsp;<a href='editEmp.php?id=$tmpID' data-toggle='tooltip' title='Edit Employee' class = $status><span class = 'glyphicon glyphicon-pencil'></span></a>&nbsp;&nbsp;<a href='deleteEmp.php?id=$tmpID' data-toggle='tooltip' title='Delete Employee' class = $status><span class = 'glyphicon glyphicon-remove'></span></a> </td>"
       					 ."<td>" . $r['Emp_ID'] . "</td>"
						 ."<td>" . $r['Emp_FName'] . "</td>"
						 ."<td>" . $r['Emp_LName'] . "</td>"
						 ."<td>" . $r['Emp_Position'] . "</td>"
						 ."<td>" . $r['Emp_Type'] . "</td>"
						 ."<td>" . $r['Emp_Shift'] . "</td>"
						 ."<td>" . $r['Emp_StartDate'] ."</td></tr>";
				}
				//closing the table
				echo "</tbody></table>";
				 
			?>
	</div>
</div>
<?php
//including the footer
require_once('footer.php');
?>