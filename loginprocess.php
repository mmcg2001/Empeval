<?php
// Starts Session
session_start();
// Passes Variables
$user = $_POST['user'];
$pass = $_POST['pass'];

require_once('db_cred.php'); 
?>
<?php
 	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	$lSql = $dbc->prepare('Select * from Employee where Username = "'. $user.'"');
	$lSql->execute();
	$lSql->setFetchMode(PDO::FETCH_ASSOC);
	
	

				$row = $lSql->fetch();	
					$pw = $row['Password'];
					if($pw == $pass){
						header('Location: home.php');
						// sets session variables
						$_SESSION['fName'] = $row['Emp_FName'];
						$_SESSION['lName'] = $row['Emp_LName'];
						$_SESSION['type'] = $row['Emp_Type'];
						$_SESSION['user'] = $row['Username'];
						$_SESSION['position'] = $row['Emp_Position'];
						$_SESSION['shift'] = $row['Emp_Shift'];
						$_SESSION['dept'] = $row['Emp_DepartmentID'];
						$_SESSION['startDate'] = $row['Emp_StartDate'];
						$_SESSION['date'] = date('m-d-Y'); 
					}
					else{
						header('Location: login.php');
					}

			
 		
	

?>