<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$id = $_SESSION['id'];
$type = $_SESSION['type'];
$uType = $_SESSION['uType'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}

if($uType != 'admin'){
	header('Location: notAuthorized.php');
}
//reference the bootstrap, nav bar, and database information		
require_once('bs.php');
require_once('nav.php');
?>
<html>
<head>
	<title>Browse Work Instructions and Evaluations</title>
</head>
<body>
<div class='container-fluid bg-2 text-center'>
<h1>Available Work Instructions and Evaluation Forms</h1>
<div class = 'col-xs-6'>
<form method = 'post' action = 'fileProcess.php'>
<?php
	
	$cur_dir = '/home/mcg2001/public_html/work_instructions/';
	$dir = opendir($cur_dir);

	echo '<p>Directory Listing:</p><ul>';
	
	while (false !== ($file = readdir($dir))){
		//strip out the two entries of . and ..
		if($file != '.' && $file != ".."){
			echo"<input type = 'checkbox' name = 'files' value = '$file'/>$file<br/>";
		}
	}
	echo '</ul>';
	closedir($dir);
	
		echo "<a href = 'upload.php' class = 'btn-lg btn-warning' role = 'button'>Upload Work Instruction</a>";
		echo "&nbsp;&nbsp;";
		echo "<input type = 'submit' class = 'btn-lg btn-danger' name ='selection' value='Delete Work Instruction'/>";
		echo "<br/><br/>";
		echo "<input type = 'submit' class = 'btn-lg btn-primary' name = 'selection' value = 'Preview'/>";
		
?>

</form>
</div>
<div class = 'col-xs-6'>
<form method = 'post' action = 'fileProcess.php'>
<?php
	
	$cur_dir = '/home/mcg2001/public_html/evaluation/';
	$dir = opendir($cur_dir);

	echo '<p>Directory Listing:</p><ul>';
	
	while (false !== ($file = readdir($dir))){
		//strip out the two entries of . and ..
		if($file != '.' && $file != ".."){
			echo"<input type = 'checkbox' name = 'files' value = '$file'/>$file<br/>";
		}
	}
	echo '</ul>';
	closedir($dir);
	
		echo "<a href = 'upload.php' class = 'btn-lg btn-warning' role = 'button'>Upload Evaluation Form</a>";
		echo "&nbsp;&nbsp;";
		echo "<input type = 'submit' class = 'btn-lg btn-danger' name ='selection' value='Delete'/>";
		echo "<br/><br/>";
		echo "<input type = 'submit' class = 'btn-lg btn-primary' name = 'selection' value = 'Preview'/>";
		
?>
</form>
</div>
</div>
</body>
</html>
<?php
	require_once('footer.php');
?>