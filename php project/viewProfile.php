<?php
//starts the session
session_start();
//sets the variable type to the session variable type, session variable set at the time of log in
$type = $_SESSION['type'];
$uID = $_SESSION['id'];
//check if the session has been started, and value you set. if not set send back to login page.
if($type == ''){
	header('Location: login.php');
}
//reference the bootstrap, nav bar, and database information		
require_once('bs.php');
require_once('nav.php');
require_once('db_cred.php');
?>
<?php
	//connecting to the database
	try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
	//pull the id from the URL
	$tmpID = $_GET['id'];
	//if the variable is not blank prepare the SQL statement, else send back to the home page
	if($tmpID > ""){
		$eSql = $dbc->prepare("Select * from Employee, Department where Emp_ID = '" . $tmpID . "' and Emp_DepartmentID = Department_ID");		
	}
	else{
		redirect('login.php');
		exit();
	}
	
	


	//run the query
	$eSql->execute();
	//fetch the result dataset from the query
	$eSql->setFetchMode(PDO::FETCH_ASSOC);
	$row = $eSql->fetch();
		//setting variables equal to the dataset
		$id = $row['Emp_ID'];
		$fname = $row['Emp_FName'];
		$lname = $row['Emp_LName'];
		$pos = $row['Emp_Position'];
		$type = $row['Emp_Type'];
		$shift = $row['Emp_Shift'];
		$dept = $row['Department_Name'];
		$start = $row['Emp_StartDate'];
		$current = $row['Current'];
		if($current == '1'){
			$curr = 'Yes';
		}
		else{
			$curr = 'No';
		}
		//query to populate the completed evaluation drop down
		$tSql = $dbc->prepare("Select * from Training_Info t, Evaluation v where v.Eval_Status = 1 and Employee_ID = '". $tmpID ."' and t.Training_ID = v.Training_ID ");
		
		$tSql->execute();
		
		$tSql->setFetchMode(PDO::FETCH_ASSOC);
		
		//query to populate the incomplete evaluation dropdown
		$uSql = $dbc->prepare("Select * from Training_Info t, Evaluation v where v.Eval_Status = 0 and Employee_ID = '". $tmpID ."' and t.Training_ID = v.Training_ID ");
		
		$uSql->execute();
		
		$uSql->setFetchMode(PDO::FETCH_ASSOC);
		
		//query to show how many messages the user has recieved
	
		$mSql = $dbc->prepare("Select count(M_ID) as Message from Messages where To_ID = $uID and M_Read = '0'");
		
		$mSql->execute();
		
		$mSql->setFetchMode(PDO::FETCH_ASSOC);
		
		while ($mRow = $mSql->fetch()){
			$count = $mRow['Message'];
		}
		
		//function used to send users back to the home page if the id was blank.
		function redirect($url)
		{
			if (!headers_sent())
			{    
				header('Location: '.$url);
				exit;
				}
			else
				{  
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.$url.'";';
				echo '</script>';
				echo '<noscript>';
				echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
				echo '</noscript>'; exit;
			}
		}
?>
<head>
   <!--formatting for the form-->
	<style>
		#form-div {border: 2.5px solid;}
	</style>

</head>
<div class="container-fluid bg-2 text-center">
	<?php
	    if($uID == $tmpID){
			echo "<h2 align = 'center'><b> Welcome ". $fname . "!</b></h2>";
			echo "<br/>";
			echo "<a href = 'inbox.php' style = 'color:990000'><h4 align = 'center'><b> You Have " . $count . " New Messages. Click to view Inbox.</b></h4></a>";
			echo "<br/>";
		}
		else{
			echo"<h2 align = 'center'><b>". $fname . ' ' . $lname . "'s Profile</b></h2>";
		}
	?>




	<div class = 'col-xs-4'>
		<form id = 'form-div'>
			<h4 align = 'center'><font color = 'FFFFFF'> Personal Information </font></h4>
			<label for="ID">ID: </label> <?php echo $id; ?> <br/> 
			<label for="First Name">First Name: </label> <?php echo $fname; ?> <br/>
			<label for="Last Name">Last Name: </label> <?php echo $lname; ?> <br/>
			<label for="Position">Position: </label> <?php echo $pos; ?> <br/>
			<label for="Type">Type: </label> <?php echo $type; ?> <br/>
			<label for="Shift">Shift: </label> <?php echo $shift; ?> <br/>
			<label for="Description">Department: </label> <?php echo $dept; ?> <br/>
			<label for="Start Date">Start Date: </label> <?php echo $start; ?> <br/>
			<label for="Current">Current Employee: </label> <?php echo $curr; ?><br/>
			<?php 
			if($_SESSION['uType'] == 'admin'){
			echo "<a href='editEmp.php?id=$id' class='btn btn-warning active' role='button'>Edit Info</a>"; 
			echo "&nbsp;&nbsp;";
			echo "<a href='resetPw.php?id=$id' class='btn btn-warning active' role='button'>Reset Password</a>";
			} else if($_SESSION['id'] == $row['Supervisor_ID'] || $_SESSION['id'] == $id) {
			echo "<a href='resetPw.php?id=$id' class='btn btn-warning active' role='button'>Reset Password</a>";
			}
			if($_SESSION['id'] != $row['Emp_ID'] && $curr == 'Yes'){
			echo "<br/><br/>";
			echo "<a href='directMessage.php?tID=$id' class ='btn btn-success active' role='button'>Send Message</a>";
			}
			?>			
			<br/><br/>
		</form>
	</div>	
 
<div class = 'col-xs-8'>
<form>			
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseC" aria-expanded="false" aria-controls="collapseC">
          Completed Evaluations
        </a>
      </h4>
    </div>
    <div id="collapseC" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
		
		<?php
		//building the table to display the data
		echo "<div class='container-fluid bg-2 text-center'>";
		echo "<div class='table-responsive col-xs-12'>";
		echo "<table id ='employee' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Powerpoint Instruction</th><th class='col-xs-1'>Work Instruction Title</th><th class='col-xs-2'>Department</th><th class='col-xs-2'>Evaluation Form</th><th class='col-xs-2'>Evaluation Score</th><th class='col-xs-1'>Average Score by Dept</th><th class='col-xs-1'>Overall Average</th></tr></thead><tbody>";
				//looping through the found data
				while($tRow = $tSql->fetch()){
				//setting a temporary variable equal to the Emp_ID	
				$tmpURL = $tRow['Training_URL'];
				$tmpEval = $tRow['Evaluation_URL'];
					//displaying the data in the table
					echo "<tr> <td><a href='training.php?id=$tmpURL' style='color: 990000'><span class = 'glyphicon glyphicon-blackboard'></span></a></td>"
       					 ."<td>" . $tRow['Training_Title'] . "</td>"
						 ."<td>" . $tRow['Dept_Required'] ."</td>"
						 ."<td><a href='eval.php?id=$tmpEval'>" . $tmpEval ."</a></td>"
						 ."<td>". $tRow['Evaluation_Score']."</td></tr>";
				}
		echo "</tbody></table>";
		?>
		</div>
	 </div>
    </div>
  </div>
</div>
</form>
</div>

<div class = 'col-xs-8'>
<form>			
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseU" aria-expanded="false" aria-controls="collapseU">
          Incomplete Evaluations
        </a>
      </h4>
    </div>
    <div id="collapseU" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
		
		<?php
		//building the table to display the data
		echo "<div class='container-fluid bg-2 text-center'>";
		echo "<div class='table-responsive col-xs-12'>";
		echo "<table id ='employee' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-1'>Powerpoint Instruction</th><th class='col-xs-1'>Work Instruction Title</th><th class='col-xs-2'>Department</th><th class='col-xs-2'>Evaluation Form</th><th class='col-xs-2'>Evaluation Score</th><th class='col-xs-1'>Average Score by Dept</th><th class='col-xs-1'>Overall Average</th></tr></thead><tbody>";
				//looping through the found data
				while($uRow = $uSql->fetch()){
				//setting a temporary variable equal to the Emp_ID	
				$tID = $uRow['Training_ID'];
				$tmpURL = $uRow['Training_URL'];
				$tmpEval = $uRow['Evaluation_URL'];
					//displaying the data in the table
					echo "<tr> <td><a href='training.php?id=$tmpURL' style='color: 990000'><span class = 'glyphicon glyphicon-blackboard'></span></a>&nbsp;&nbsp<a href='javascript:AlertIt();' style = 'color: 990000'><span class = 'glyphicon glyphicon-remove'></span></a></td>"
       					 ."<td>" . $uRow['Training_Title'] . "</td>"
						 ."<td>" . $uRow['Dept_Required'] ."</td>"
						 ."<td><a href='eval.php?id=$tmpEval'>" . $tmpEval ."</a></td>"
						 ."<td>". $uRow['Evaluation_Score']."</td></tr>";	
?>
    	 <script type="text/javascript">
			function AlertIt() {
			var answer = confirm ("Do you want to unassign the training?")
			if (answer)
			window.location="unassignTraining.php?tmpID=<?php echo $uRow['Employee_ID']; ?>&training=<?php echo $tID; ?>";
			}
		</script>

	<?php			}	
		echo "</tbody></table>";
		
	?>
		

		
		</div>
	 </div>
    </div>
  </div>
</div>
<?php
	require_once('overall.php');
?>
</form>
</div>
</div>
<?php
require_once('footer.php');
?>