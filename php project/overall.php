<?php
//starting the session
session_start();
//aesthetics
require_once("bs.php");
//navigation bar
require_once("nav.php");
//db credentials for connection
require_once("db_cred.php");
//database connection


try {
	  $dbc = new PDO("mysql:host=$db_hostname; dbname=$db_dbname", $db_username, $db_userpass);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
//query all instructions from training
	$sSql = $dbc->prepare("Select count(Training_ID) As TotalInstructions From Training_Info");
//execute query
	$sSql->execute();
//gather results into an array	
	$sSql->setFetchMode(PDO::FETCH_ASSOC);
	
	$row = $sSql->fetch();
	
	$total = $row['TotalInstructions'];
/*
//query for total evals 	
	$tSql = $dbc->prepare("Select Count(Evaluation_ID) as Total_Eval from Evaluation where Employee_ID = $id");
//execute query
	$tSql->execute();
//gather results into an array	
	$tSql->setFetchMode(PDO::FETCH_ASSOC);
	
	$tRow = $tSql->fetch();
	$total = $tRow['Total_Eval'];*/
	
//query for completed evals
	$cSql = $dbc->prepare("Select Count(Evaluation_ID) as Completed_Eval from Evaluation where Employee_ID = $id and Eval_Status = 1");
//execute query
	$cSql->execute();
//gather results into an array	
	$cSql->setFetchMode(PDO::FETCH_ASSOC);
	
	$cRow = $cSql->fetch();
	$completed = $cRow['Completed_Eval'];
	
	$percentCompleted = ($completed / $total) * 100;
	

?><!--end php-->

<!DOCTYPE html>
<html>
<h1>Completion of Training for Whole Warehouse As a %</h1>
</html> 

<div class="progress">
  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $percentCompleted; ?>"
  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentCompleted;?>%">
    <?php echo $percentCompleted;?> % Complete
  </div>
</div>

<?php
	
 	$dSql = $dbc->prepare("Select * from Department where Department_Name <> 'admin'");
//execute query
	$dSql->execute();
//gather results into an array	
	$dSql->setFetchMode(PDO::FETCH_ASSOC);
	
	//building the table to display the data
	echo "<div class='container-fluid bg-2 text-center'>";
	echo "<div class='table-responsive col-xs-12'>";
	echo "<table id ='employee' cellpadding = '0' cellspacing='0' border='0' class='table table-striped table-bordered'>";
		echo "<thead><tr><th class='col-xs-4'>Department Name</th><th class='col-xs-8'>Completion of Training for Whole Warehouse As A Percentage</th></thead><tbody>";
 
			while($dRow = $dSql->fetch()){
		
				 $dName = $dRow['Department_Name'];
				 
				$fSql = $dbc->prepare("SELECT COUNT(Training_ID) AS Total_Training FROM Training_Info WHERE Dept_Required = '$dName'");
				 
				$fSql->execute(); 
				 //gather results into an array
				$fSql->setFetchMode(PDO::FETCH_ASSOC);
				//fetch the results			
				$fRow = $fSql->fetch();
				$ftotal = $fRow['Total_Training'];
				 
				//query for department completed evals
				$dcSql = $dbc->prepare("Select Count(e.Evaluation_ID) as Completed_Eval from Evaluation e, Training_Info t where e.Employee_ID = $id and e.Eval_Status = 1 and t.Dept_Required = '$dName' and e.Training_ID = t.Training_ID");
				//execute query
				$dcSql->execute();
				//gather results into an array	
				$dcSql->setFetchMode(PDO::FETCH_ASSOC);
			
				$dcRow = $dcSql->fetch();
				$dcompleted = $dcRow['Completed_Eval'];
				
				$deptPercentComplete = ($dcompleted / $ftotal) * 100;
	
		echo "<tr><td>" ."<a href='deptMatrix.php?d=$dName&id=$id' style = 'color:990000'>". $dName. "</a>". "</td>"
				."<td>".'<div class="progress">
						  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="'.$deptPercentComplete.'"
						  aria-valuemin="0" aria-valuemax="100" style="width:'.$deptPercentComplete.'%">
							'.$deptPercentComplete.' % Complete
						  </div>
						</div>'."</td></tr>";
		}
				
		echo"</tbody></table>";
	echo"</div>";
echo"</div>";
?>

	