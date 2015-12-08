<?php
// starts the session
session_start();
// gets variables submitted from the previous page
$user = $_POST['user'];
$pass = $_POST['pass'];
// retrieves the information for the database
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
	//the query that is to be run
	$lSql = $dbc->prepare('Select * from Employee where Username = :user');
	//binding the varible to the placeholder, used to protect against SQL injection
	$lSql->bindValue(':user', $user);
	//runs the query
	$lSql->execute();
	//retrieves the dataset from the query
	$lSql->setFetchMode(PDO::FETCH_ASSOC);
				//boolean for no rows found, set to true by default
				$nrf = true;
				//looping through the results
				while($row = $lSql->fetch()){
					//setting no rows found boolean to false
					$nrf = false;
					//retrieving the password form the db dataset
					$pw = $row['Password'];
					//if the username and password match, send them to the home page, and set these session variables, else send them back to the login.
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
						do_alert();
					}
				}
				//if no rows found remains to be true send them back to the login page
				if($nrf == true){
					header('Location: login.php');
				}
			//will probably wind up going away	
			 function do_alert() 
			 {
				echo '<script type="text/javascript">alert(Wrong username or password was entered!); </script>';
			 }

?>
