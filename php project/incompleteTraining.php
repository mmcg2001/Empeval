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


require_once('footer.php');
?>
