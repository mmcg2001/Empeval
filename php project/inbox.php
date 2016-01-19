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
	
	$sSql = $dbc->prepare("Select * from Messages where To_ID = $id Order by M_ID DESC");
	$sSql->execute();
	
	$sSql->setFetchMode(PDO::FETCH_ASSOC);
?>
<head>
<!-- CSS and JavaScript need for the responsive datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src = '//code.jquery.com/jquery-1.11.3.min.js'></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() { $('#message').DataTable(); } );
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
	echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class = 'col-xs-3'></div>";
	echo "<div class='table-responsive col-xs-6'>";
	echo "<h1>Inbox</h1><br/>";
	echo "<table id ='message' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Action</th><th class='col-xs-1'>From</th><th class='col-xs-2'>Subject</th><th class='col-xs-2'>Date</th></thead><tbody>";
				//looping through the found data
				while($row = $sSql->fetch()){
				$tmpID = $row['M_ID'];
				$fSql = $dbc->prepare("Select Emp_FName, Emp_LName from Employee where Emp_ID = '".$row['From_ID']."'");
				$fSql->execute();
				$fSql->setFetchMode(PDO::FETCH_ASSOC);
				$fRow = $fSql->fetch();
					$fName = $fRow['Emp_FName'];
					$lName = $fRow['Emp_LName'];
					$name = $fName . ' ' . $lName;
					
						echo "<tr> <td><a href='showMessage.php?id=$tmpID' data-toggle='tooltip' title='View Message'><span class = 'glyphicon glyphicon-folder-open'></span></a>&nbsp;&nbsp;</span></a>&nbsp;&nbsp;<a href='deleteMessage.php?id=$tmpID' data-toggle='tooltip' title='Delete Message'><span class = 'glyphicon glyphicon-remove'></span></a></td>"
       					 ."<td>" . $name . "</td>"
						 ."<td><a href ='showMessage.php?id=$tmpID' data-toggle = 'tootip' title = 'View Message'>" . $row['Subject'] . "</a></td>"
						 ."<td>" . $row['Sent_Date'] . "</td></tr>";
				}
				echo "</tbody></table>";
	//add new button
	echo "<a href='sendMessage.php' class='btn btn-warning active' role='button'>Send a Message</a>";
echo "</div>";
echo "</div>"; 
//including the footer
require_once('footer.php');
?>