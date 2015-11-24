<html>
<body>
	<div class = 'container-fluid bg-2 text-center'>
		<form>
			<div class = 'col-xs-4'></div>
				<div class = 'col-xs-4'>
					<div class = 'form-group'>
						<label for="fName">First Name: </label>
							<?php if($fName>""){ ?>
								<input type="text" class="form-control" name="fName" id="fName"  value="<?php echo $fName; ?>">
							<?php } else { ?>
								<input type="text" class="form-control" name="fName" id="fName"  placeholder="First Name">
							<?php } ?>
					</div>
					<div class = 'form-group'>
						<label for="lName">Last Name: </label>
							<?php if($lName>""){ ?>
								<input type="text" class="form-control" name="lName" id="lName"  value="<?php echo $lName; ?>">
							<?php } else { ?>
								<input type="text" class="form-control" name="lNname" id="lName"  placeholder="Last Name">
							<?php } ?>
					</div>
					<div class = 'form-group'>
						<label for="Position">Position: </label>
							<?php if($position>""){ ?>
								<input type="text" class="form-control" name="ePosition" id="ePosition"  value="<?php echo $position; ?>">
							<?php } else { ?>
								<input type="text" class="form-control" name="ePosition" id="ePosition"  placeholder="Position">
							<?php } ?>
					</div>
					<div class = 'form-group'>
						<label for="eType">Type: </label>
						<?php if($type > ""){ ?>
							<select name = "eType" class = "form-control">
								<option value=<?php $type ?>><?php echo $type; ?></option>
								<?php if($type == "Koyo"){ ?>
								<option value="Temp">Temp</option>
								<?php } else if ($type == "Temp") { ?>
								<option value="Koyo">Koyo</option>
								<?php } ?>
							</select>
							<?php } else { ?>
								<select name = "eType" class = "form-control">
									<option value ="Temp">Temp/Kelly</option>
									<option value ="Koyo">Koyo</option>
								</select>
							<?php } ?> 
					</div>
					<div class = 'form-group'>	
						<label for="eShift">Shift: </label>
						<?php if($shift > ""){ ?>
							<select name = "eShift" class = "form-control">
								<option value=<?php $shift ?>><?php echo $shift; ?></option>
								<?php if($shift == "First"){ ?>
								<option value="Second">Second</option>
								<?php } else if ($shift == "Second") { ?>
								<option value="First">First</option>
								<?php } ?>
							</select>
							<?php } else { ?>
								<select name = "eShift" class = "form-control">
									<option value ="First">First</option>
									<option value ="Second">Second</option>
								</select>
							<?php } ?> 
					</div>
					<div class = 'form-group'>
						<label for="eSup">Supervisor: </label>
						<?php if($supervisor>""){ ?>
							<input type="text" class="form-control" name="eSup" id="eSup"  value="<?php echo $supervisor; ?>">
						<?php } else { ?>
							<input type="text" class="form-control" name="eSub" id="eSup"  placeholder="Supervisor">
						<?php } ?>
					</div>
					<div class = 'form-group'>
						<label for="eStart">Start Date: </label>
						<?php if($position>""){ ?>
							<input type="date" class="form-control" name="eStart" id="eStart"  value="<?php echo $startDate; ?>">
						<?php } else { ?>
							<input type="date" class="form-control" name="eStart" id="eStart"  placeholder="Start Date">
						<?php } ?>
						<br/>
					<div class = 'form-group'>
						<input class = "btn-lg btn-success" type = 'submit' name = 'submit' />
						<a href = 'createEmp.php'><input class = 'btn-lg btn-danger' type = 'button' name ='back' value = 'back'/></a>						
					</div>
					
					</div>
				</div>
		</form>
	</div>
</body>
</html>