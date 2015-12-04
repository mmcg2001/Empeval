<?php
session_start();
$type = $_SESSION['type'];

if($type == ''){
	header('Location: login.php');
}
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');

try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	
	$user = $_SESSION['user'];
	$pwSql = $dbc->prepare('Select * from Employee where Username = "'. $user.'"');
	$pwSql->execute();
	$pwSql->setFetchMode(PDO::FETCH_ASSOC);

				$row = $pwSql->fetch();	
?>
	<html>
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
			if(isset($_POST['submit'])){
					$pw = $_POST['pass'];
					$npw1 = $_POST['newPass'];
					$npw2 = $_POST['newPW'];
					$pass = $row['Password'];
					
					if($pw != $pass){
						echo "Current password was incorrect. Please try again.";
					}
					else{
						if($npw1 != $npw2){
							echo "New passwords did not match. Please re-enter your new password.";
						}
						else{
							
							$uSql = $dbc->prepare("Update Employee
									 Set Password = '$npw1'
									 where Username = '$user'");
							
							$upw = $uSql->execute();
							
							if($upw == true){
								redirect('UpdateSuccess.php');
							}
							else{
								echo "Didn't work";
							}
						}
					}
			}
			
			
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