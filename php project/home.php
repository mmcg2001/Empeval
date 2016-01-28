<!DOCTYPE html>

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
	
	//setting session variables into normal variables
	$user = $_SESSION['user'];
	$date = $_SESSION['date'];
	$fname = $_SESSION['fName'];
	$lname = $_SESSION['lName'];
	$name = $fname . ' '. $lname;
?>

<html>
<head>
	<!-- formatting the forms with borders -->
	<style>
		form {border: 2.5px solid;}
	</style>

</head>
<body>

<div class="container-fluid bg-2 text-center">
	<!-- Welcome Message shows name and date. -->
	<h2 align = 'center'><b><?php echo "Welcome ". $name . "!"; ?></b></h2>
	<h3 align = 'center'><b><?php echo $date; ?></b></h3>
	
	<div class = 'col-xs-4'>
	<?php
		//connects to the database
		try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
		//SQL query to retrieve all information linked to a user from the variable that is set to the session variable
		$pSql = $dbc->prepare('Select * from Employee, Department where Username = "'. $user .'" and Emp_DepartmentID = Department_ID');
		//run the query
		$pSql->execute();
		//retrieve the dataset
		$pSql->setFetchMode(PDO::FETCH_ASSOC);
		$row = $pSql->fetch();
		//set the dataset into variables
		$id = $row['Emp_ID'];
		$fname = $row['Emp_FName'];
		$lname = $row['Emp_LName'];
		$pos = $row['Emp_Position'];
		$type = $row['Emp_Type'];
		$shift = $row['Emp_Shift'];
		$dept = $row['Department_Name'];
		$start = $row['Emp_StartDate'];
		
		$tSql = $dbc->prepare('Select * from Training_Info, Evaluation where Dept_Required = "'.$dept.'"');
		
		$tSql->execute();
		
		$tSql->setFetchMode(PDO::FETCH_ASSOC);
		
		?>
		<!-- display the information from the dataset in a form -->
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
			<a href = 'resetPw.php' class='btn btn-warning active' role='button'/>Reset Password</a> <br/><br/>
			
		</form>
	
	</div>
	<div class = 'col-xs-8'>
		<form> 
		<?php
		//building the table to display the data
		echo "<div class='container-fluid bg-2 text-center'>";
		echo "<div class='table-responsive col-xs-12'>";
		echo "<table id ='employee' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Action</th><th class='col-xs-1'>Training Title</th><th class='col-xs-2'>Department</th><th class='col-xs-2'>Evaluation Form</th><th class='col-xs-2'>Evaluation Score</th><th class='col-xs-1'>Average Score by Dept</th><th class='col-xs-1'>Overall Average</th></tr></thead><tbody>";
				//looping through the found data
				while($tRow = $tSql->fetch()){
				//setting a temporary variable equal to the Emp_ID			
				$tmpURL = $tRow['Training_URL'];
				$tmpEval = $tRow['Evaluation_URL'];
					//displaying the data in the table
					echo "<tr> <td><a href='training.php?id=$tmpURL'><span class = 'glyphicon glyphicon-pencil'></span></a></td>"
       					 ."<td>" . $tRow['Training_Title'] . "</td>"
						 ."<td>" . $tRow['Dept_Required'] ."</td>"
						 ."<td><a href='eval.php?id=$tmpEval'>" . $tmpEval ."</a></td></tr>";
				}
		echo "</tbody></table>";
		?>
		
		</form>
	</div>
</div>
</body>
</html>

<?php
	require_once('footer.php');
?>
