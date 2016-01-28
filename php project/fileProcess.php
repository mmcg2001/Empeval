<?php

//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$sid = $_SESSION['id'];
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
//reference the bootstrap, nav bar, and database information		
require_once('bs.php');
require_once('nav.php');
?>
<html>
<head>
	<title> File Process </title>
</head>
<div class='container-fluid bg-2 text-center'>
<body>
	<h1> File Process </h1>
<?php

$selection = $_POST['selection'];
$choice = $_POST['choice'];


if($choice == 'Work'){
	$dirpath = '/home/mcg2001/public_html/work_instructions/';
}
else{
	$dirpath = '/home/mcg2001/public_html/evaluation/';
}
if($selection == 'Upload'){

	if ($_FILES['userfile']['error'] > 0){
	
		echo 'Problem: ';
		switch ($_FILES['userfile']['error']){
			
			case 1: echo 'File exceeded the upload max size';
					break;
					
			case 2: echo 'File exceeded max file size';
					break;
			
			case 3: echo 'File only partially uploaded';
					break;
			
			case 4: echo 'No file uploaded';
					break;
			
			case 6: echo 'Cannot upload file: No temp directory specified';
					break;
			
			case 7: echo 'Upload failed: Cannot write to disk';
					break;
			}
	}
	//put the file in the directory
	
	$upfile = $dirpath.$_FILES['userfile']['name'];
	
	if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
		if(!move_uploaded_file($_FILES['userfile']['tmp_name'] ,$upfile)){
			echo 'Problem: Could not move file to destination directory';
			exit;
		}
	}
	else{
		echo 'Problem: Possible file upload attack. Filename: ';
		echo $_FILES['userfile']['name'];
		exit;	
	}
	
	echo "Upload Successful";
	echo "<br/><br/>";
	echo "<a href='readdir.php' class='btn btn-warning' role='button'>Return to Directory</a>&nbsp;&nbsp;<a href = 'viewProfile.php?id=$sid' class='btn btn-success' role='button'>Return Home</a>";
	
	$contents = file_get_contents($upfile);
		$contents = strip_tags($contents);
	file_put_contents($_FILES['userfile']['name'],$contents);
}	
else if($selection == 'Delete'){
	$filename = $_POST['files'];
	unlink($dirpath. '/' .$filename);
	echo "Delete Succesful";
	echo "<br/><br/>";
	echo "<a href='readdir.php' class='btn btn-warning' role='button'></a>&nbsp;&nbsp;<a href = 'viewProfile.php?id=$sid' class='btn btn-success' role='button'>Return Home</a>";
}
else if($selection == 'Preview'){

	function redirect($url){
	if (!headers_sent()){    
		header('Location: '.$url);
		exit;
	}
	else{  
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
		echo '</noscript>'; exit;
		}
	}
	
	$url = $_POST['files'];
	redirect("training.php?id=$url");
}	
?>
	
</body>
</div>
</html>
<?php
require_once('footer.php');
?>
	
