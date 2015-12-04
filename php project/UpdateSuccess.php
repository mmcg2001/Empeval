<?php
	
session_start();

$type = $_SESSION['type'];

if($type == ''){
	header('Location: login.php');
}
	
require_once('bs.php');
require_once('nav.php');
	
?>
<div class="container-fluid bg-2 text-center">
<?php
echo 'Updated Successfully';
  echo '<br /><br /><br />';  
  echo '<a href = "home.php" class = "btn btn-warning" role = "button">Return to Home Page</a>';
?>
</div>