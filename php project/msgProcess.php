<?php
	require_once('bs.php');
	require_once('nav.php');
?>

<?php

$recips = $_POST['recipients'];
$msg = $_POST['message'];

echo $recips;
echo "<br/>";
echo $msg;
?>