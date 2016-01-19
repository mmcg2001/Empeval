<?php

session_start();

//require_once('checkMessages.php');

$myUserType = $_SESSION['uType'];

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
			$color = 'color:cc0000';
/*             echo '<script language="javascript">';
			echo 'alert("'.$message.'")';
			echo '</script>'; */ 
		 }
 
?>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
     <?php echo "<a class='navbar-brand' href='viewProfile.php?id=$id'>Koyo</a>";?>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
	    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Employee<span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href='viewEmp.php'>View Current Employees</a></li>
			<li><a href='previousEmp.php'>View Previous Employees</a></li>
			<li><a href='createEmp.php'>Create Employee</a></li>
		  </ul>	
	    </li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Departments<span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href='viewDept.php'>View Departments</a></li>
			<li><a href='createDept.php'>Create Department</a></li>
		  </ul>	
	    </li>
		 <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Training/Evaluations<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="assignTraining.php">Assign</a></li>
            <li><a href="incompleteTraining.php">Incomplete</a></li>
          </ul>
        </li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Files<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="readdir.php">View Work Instruction Directory</a></li>
            <li><a href="upload.php">Upload Work Instruction</a></li>
          </ul>
        </li>
		<li class="dropdown">
          <a href="#" style = <?php echo $color; ?> class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Messages<span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href='inbox.php' style = <?php echo $color;?>>Inbox     <?php echo $count. " New Message(s)"; ?></a>
			<li><a href='sendMessage.php'>Send Message</a>
			<li><a href='outbox.php'>Outbox</a>
          </ul>
        </li>
		<!--</li>-->
		<li><a href='logout.php'>Log Out</a></li>
      </ul>
    </div>
  </div>
</nav>