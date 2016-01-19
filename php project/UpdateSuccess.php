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

$id = $_SESSION['id'];
?>
<div class="container-fluid bg-2 text-center">
<?php
//updated status
echo 'Updated Successfully';
  echo '<br /><br /><br />';  
  echo '<a href = "viewProfile.php?id='.$id.'" class = "btn btn-warning" role = "button">Return to Home Page</a>';
?>
</div>

<?php
require_once('footer.php');
?>