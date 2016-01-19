<html>
<head>
	<title> Uploading </title>
</head>
<body>
	<h1> Uploading File </h1>
<?php
$selection = $_POST['selection'];

$dirpath = '/home/mcg2001/public_html/work_instructions/';
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
	echo "<a href = 'readdir.php'>Return to the Directory</a>";
	
	$contents = file_get_contents($upfile);
		$contents = strip_tags($contents);
	file_put_contents($_FILES['userfile']['name'],$contents);
}	
else if($selection == 'Delete'){
	$filename = $_POST['files'];
	unlink($dirpath. '/' .$filename);
	echo "Delete Succesful";
	echo "<br/><br/>";
	echo "<a href = 'readdir.php'>Return to the Directory</a>";
}	
	?>
	
</body>
</html>
	
