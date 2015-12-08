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
//setting variables to values submitted from another form
$dept = $_POST['deptName'];
$sup = $_POST['dept_Supervisor'];

//connecting to the database
try {
  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
}
catch(PDOException $e) {
	echo $e->getMessage();
}
//SQL query to insert into the Department table
$iSql = $dbc->prepare("Insert Into Department (Department_Name, Supervisor_ID) values (:deptName, :sup_id)");
//binding values to placeholder values, help protect against SQL injection
$iSql->bindValue(':deptName', $dept);
$iSql->bindValue(':sup_id', $sup);
//running the SQL statement
$chk = $iSql->execute();
	
	//if it runs correctly 
	if($chk == TRUE){
		echo "Department had been entered.";
		echo "<br/><br/>";
		echo "<a href='viewDept.php'> Click to Return Department List</a>";
	}
	else{
		echo "did not work.";
	} 

?>