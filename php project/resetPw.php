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

//connecting to the database
try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	//retrieving the encryption key
	$KeySQL = 'SELECT EncryptKey from SystemSettings';
	$KSQL = $dbc->query($KeySQL);
	$KSQL->setFetchMode(PDO::FETCH_ASSOC);
	$GetKey =$KSQL->fetch();
	
	$enc_key = $GetKey['EncryptKey'];
	
	//setting local variable to the Session variable
	$user = $_GET['id'];
	//SQL query to retrieve a users information, most importantly the password
	$pwSql = $dbc->prepare("Select *,AES_DECRYPT(Password,'$enc_key') as passw from Employee where Emp_ID = '". $user."'");
	//running the query
	$pwSql->execute();
	//retrieve the dataset from query
	$pwSql->setFetchMode(PDO::FETCH_ASSOC);

				$row = $pwSql->fetch();	
?>
	<html>
		<!-- form that submits to the same page it's on-->
		<div class="container-fluid bg-2 text-center">
		<form method = 'post' action = ''>
			<div class = 'col-xs-4'> </div>
			<div class = 'col-xs-4'>
				<label for = "pass">Current Password</label>
					<input class = "form-control" type = 'password' name = 'pass'/><br/>
				<label for = "newPass">Enter New Password</label>
					<input class = "form-control" type = 'password' name = 'newPass'/><br/>
				<label for = "newPW">Re-Enter New Password</label>
					<input class = "form-control" type = 'password' name = 'newPW'/><br/>
			<input class = "btn-lg btn-success" type = 'submit' name = 'submit' />
			<input class = "btn-lg btn-danger" type ='button' value = 'Back' onclick = 'history.go(-1);' /><br/>
			</div>
		</form>		
		<?php
			//checks to see if the form was submitted, if so set local variables to the POSTed variables else do nothing
			if(isset($_POST['submit'])){
					$pw = $_POST['pass'];
					$npw1 = $_POST['newPass'];
					$npw2 = $_POST['newPW'];
					$pass = $row['passw'];
					
					//if local variable pass does not equal what the database house do not allow the change, else allow the update
					if($pw != $pass){
						echo "Current password was incorrect. Please try again.";
					}
					else{
						if($npw1 != $npw2){
							echo "New passwords did not match. Please re-enter your new password.";
						}
						else{
							//SQL query to update the password field
							$uSql = $dbc->prepare("Update Employee
									 Set Password = AES_ENCRYPT(:npw1, '$enc_key')
									 where Emp_ID = '$user'");
							//run the query
							$uSql->bindValue(':npw1', $npw1);
							$upw = $uSql->execute();
							//if it is true send the user to UpdateSuccess, else do nothing.
							if($upw == true){
								redirect('UpdateSuccess.php');
							}
							else{
								echo "Didn't work";
							}
						}
					}
			}
			
		//function used to send the user to UpdateSuccess	
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
		</div>
	</html>
<?php
	require_once('footer.php');
?>