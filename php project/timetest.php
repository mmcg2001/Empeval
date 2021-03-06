<?php

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
?>
<head>
<!-- CSS and JavaScript need for the responsive datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() { $('#utwoweeks').DataTable(); } );
	$(document).ready(function() { $('#uthirtydays').DataTable(); } );
	$(document).ready(function() { $('#uninetydays').DataTable(); } );
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
$tSql = $dbc->prepare("Select e.Emp_ID, e.Emp_FName, e.Emp_LName, t.TwoWeek, i.Training_Title from Timed_Evaluations t, Employee e, Training_Info i, Evaluation v where e.Current = '1' and v.Eval_Status = '0' and t.Employee_ID = e.Emp_ID and i.Training_ID = t.Training_ID  and v.Employee_ID = e.Emp_ID");
$tSql->execute();
$tSql->setFetchMode(PDO::FETCH_ASSOC);
	//building the table to display the data
	
	echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class='table-responsive col-xs-4'>";
	echo "<table id ='utwoweeks' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
	echo "<caption align = 'bottom'><font color = '0f0f0f'> Two Week Evaluations Due </font></caption>";
	echo "<thead><tr><th class='col-xs-2'>Employee Name</th><th class = 'col-xs-2'>2 weeks</th><th class = 'col-xs-2'>Training Title</th></tr></thead></tr></thead><tbody>";

		while($row = $tSql->fetch()){
		// true if my_date is more than a month ago
			$tmpID = $row['Emp_ID'];
			$fName = $row['Emp_FName'];
			$lName = $row['Emp_LName'];
			$name = $fName . ' ' . $lName;
			if(date('Y-m-d',strtotime("+ 7 days")) >= date('Y-m-d', strtotime($row['TwoWeek']))&& date('Y-m-d', strtotime('+ 4 days')) <= date('Y-m-d', strtotime($row['TwoWeek']))){
			echo "<tr> <td> <a href='viewProfile.php?id=$tmpID' data-toggle='tooltip' title='View Profile'>". $name . "</a></td>"
				 . "<td>" . $row['TwoWeek'] ."</td>"
				 . "<td>". $row['Training_Title'] ."</td></tr>";
			 }

		}

			echo "</tbody></table>";
		echo "</div>";

$thSql = $dbc->prepare("Select e.Emp_ID, e.Emp_FName, e.Emp_LName, t.ThirtyDays, i.Training_Title from Timed_Evaluations t, Employee e, Training_Info i, Evaluation v where e.Current = '1' and v.Eval_Status = '0' and t.Employee_ID = e.Emp_ID and i.Training_ID = t.Training_ID  and v.Employee_ID = e.Emp_ID");
$thSql->execute();
$thSql->setFetchMode(PDO::FETCH_ASSOC);
		//building the table to display the data
	//echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class='table-responsive col-xs-4'>";
	echo "<table id ='uthirtydays' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";	
	echo "<caption align = 'bottom'><font color = '0f0f0f'> 30-Day Evaluations Due </font></caption>";
	echo "<thead><tr><th class='col-xs-2'>Employee Name</th><th class = 'col-xs-2'>30 Days</th><th class = 'col-xs-2'>Training Title</th></tr></thead></tr></thead><tbody>";
		while($thRow = $thSql->fetch()){
			$thID = $thRow['Emp_ID'];
			$thFName = $thRow['Emp_FName'];
			$thLName = $thRow['Emp_LName'];
			$thName = $thFName . ' ' . $thLName;
			if(date('Y-m-d',strtotime("+ 7 days")) >= date('Y-m-d', strtotime($thRow['ThirtyDays'])) && date('Y-m-d', strtotime('+ 4 days')) <= date('Y-m-d', strtotime($thRow['ThirtyDays']))){
			echo "<tr> <td> <a href='viewProfile.php?id=$thID' data-toggle='tooltip' title='View Profile'>". $thName . "</a></td>"
				 . "<td>" . $thRow['ThirtyDays'] ."</td>"
				 . "<td>". $thRow['Training_Title'] ."</td></tr>";
			 }
		}

		echo "</tbody></table>";
	//echo "</div>";
echo "</div>";

$nSql = $dbc->prepare("Select e.Emp_ID, e.Emp_FName, e.Emp_LName, t.NinetyDays, i.Training_Title from Timed_Evaluations t, Employee e, Training_Info i, Evaluation v where e.Current = '1' and v.Eval_Status = '0' and t.Employee_ID = e.Emp_ID and i.Training_ID = t.Training_ID  and v.Employee_ID = e.Emp_ID");
$nSql->execute();
$nSql->setFetchMode(PDO::FETCH_ASSOC);

	//building the table to display the data
	//echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class='table-responsive col-xs-4'>";
	echo "<table id ='uninetydays' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";	
	echo "<caption align = 'bottom'><font color = '0f0f0f'> 90-Day Evaluations Due </font></caption>";
	echo "<thead><tr><th class='col-xs-2'>Employee Name</th><th class = 'col-xs-2'>90 Days</th><th class = 'col-xs-2'>Training Title</th></tr></thead></tr></thead><tbody>";
		while($nRow = $nSql->fetch()){
			$nID = $nRow['Emp_ID'];
			$nFName = $nRow['Emp_FName'];
			$nLName = $nRow['Emp_LName'];
			$nName = $nFName . ' ' . $nLName;
			if(date('Y-m-d',strtotime("+ 7 days")) >= date('Y-m-d', strtotime($nRow['NinetyDays'])) && date('Y-m-d', strtotime(' + 4 days')) <= date('Y-m-d', strtotime($nRow['NinetyDays']))){
			echo "<tr> <td> <a href='viewProfile.php?id=$nID' data-toggle='tooltip' title='View Profile'>". $nName . "</a></td>"
				 . "<td>" . $nRow['NinetyDays'] ."</td>"
				 . "<td>". $nRow['Training_Title'] ."</td></tr>";
			 }
		}
	
		echo "</tbody></table>";
	echo "</div>";
echo "</div>";

?>