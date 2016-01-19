<?php

session_start();

$id = $_SESSION['id'];

 require_once('db_cred.php');

//connecting to the database
 	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
		
		$mSql = $dbc->prepare("Select count(M_ID) as Message from Messages where To_ID = $id and M_Read = '0'");
		
		$mSql->execute();
		
		$mSql->setFetchMode(PDO::FETCH_ASSOC);
		
		$mRow = $mSql->fetch();
		$count = $mRow['Message'];
		$message = "You have " . $count . " unread messages.";
		if($count > 0){ 
			
            echo '<script language="javascript">';
			echo 'alert("'.$message.'")';
			echo '</script>'; 
		 }
		
?>