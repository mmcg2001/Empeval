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
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');

//connecting to the database
try {
  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
}
catch(PDOException $e) {
	echo $e->getMessage();
}

$inSql = $dbc->prepare("SELECT e.Emp_ID, e.Emp_FName, e.Emp_LName, t.Training_Title FROM Employee e, Evaluation v, Training_Info t WHERE v.Instruction_Completed = '0000-00-00' AND e.Emp_ID = v.Employee_ID AND v.Training_ID = t.Training_ID");
$inSql->execute();
$inSql->setFetchMode(PDO::FETCH_ASSOC);
?>

<head>
<!-- CSS and JavaScript need for the responsive datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() { $('#incomplete').DataTable(); } );
</script>

<!-- disable the clickable glyphs -->
<style>
.not-active {
 pointer-events: none;
 cursor: default;
}
</style>

</head>
<?php
//building the table to display the data
	
	echo "<div class='container-fluid bg-2 text-center'>";
	echo "<h2> Upcoming Evaluations </h2>";
	echo "<h5> All evaluations due within the next 7 days.</h5>";
	require_once('timetest.php');
	echo "<h2> Pending Evaluations </h2>";
	echo "<h5> All evaluations due within the next 3 days, or remain incomplete.</h5>";
	require_once('pendingEval.php');
	echo "<h2> Incomplete Work Instructions </h2>";
	echo "<div class = 'col-xs-3'></div>";
	echo "<div class='table-responsive col-xs-6'>";
	echo "<table id ='incomplete' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
	echo "<thead><tr><th class='col-xs-1'>Employee Name</th><th class='col-xs-1'>Work Instruction Title</th></tr></thead><tbody>";
		while($row = $inSql->fetch()){
			$tmpID = $row['Emp_ID'];
			$fname = $row['Emp_FName'];
			$lname = $row['Emp_LName'];
			$name = $fname . ' ' . $lname;
			
			echo "<tr> <td> <a href='viewProfile.php?id=$tmpID' data-toggle='tooltip' title='View Profile'>". $name . "</a></td>"
				 . "<td>" . $row['Training_Title'] ."</td></tr>";
		}
		echo "</tbody></table>";
echo "</div>";
echo "</div>"; 

require_once('footer.php');
?>
