<?php
	require_once('bs.php');
	require_once('nav.php');
?>

<html>

<h1 align = 'center'> Send Message </h1>

<body>

<div class="container-fluid bg-2 text-center">
	<form method = 'post' action = 'msgProcess.php'>
	  <div class = 'col-xs-4'> </div>
	  <div class = 'clo-xs-4'>
		<div class = 'form-group'>
			<input type = 'text' class = 'form-control' name = 'recipients' placeholder = 'Recipient'/>
		</div>
		<div class = 'form-group'>
			<textarea rows = '4' cols = '50' class = 'form-control' name = 'message' placeholder = 'Insert Message Here'></textarea>
		</div>
		<div class = 'form-group'>
			<input class = "btn-lg btn-success" type = 'submit' name = 'submit' value = 'Send' />
			<input class = 'btn-lg btn-danger' type = 'button'  value = 'Back' onclick = "goBack()"/>
				<script>
					function goBack() {
						window.history.back();
					}
				</script>
		</div>
	  </div>
	</form>
</div>
</body>
</html>