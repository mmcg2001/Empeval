<?php
// Starts Session
session_start();
// Unsets Session Variables
session_unset();
// Closes Session
session_destroy();
// Sends back to this page
header('Location: login.php');
?>