<?php
	
//starts the session	
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
//reference the bootstrap, nav bar	
require_once('bs.php');
require_once('nav.php');

	
?>
<div class="container-fluid bg-2 text-center">
<?php
//display deletion status
echo 'Deleted Successfully';
  echo '<br /><br /><br />';  
  //button to take back to the home page
  echo '<a href = "home.php" class = "btn btn-warning" role = "button">Return to Home Page</a>';
?>
</div>

<?php
require_once('footer.php');
?>