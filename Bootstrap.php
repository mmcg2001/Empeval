<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark McGregor">

    <title>Koyo Employee Portal</title>

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


	<!-- BR note: All code needed to make datatables work within bootstrap version 3 came from -->
	<!--          the following location: -->
	<!--            https://github.com/DataTables/Plugins/tree/master/integration/bootstrap/3  -->
	
	
	<!-- obtain bootstrap version 3.1.1 CSS settings from a reputable source -->
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	
	<!-- note: this next link has css settings to make datatables work with bootstrap version 3 -->
	<link rel="stylesheet" type="text/css" href="DT_bootstrap.css">

	
	
	<!-- obtain the jquery javascript library from a reputable source -->
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	
	<!-- obtain the datatables javascript library from a reputable source -->
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10-dev/js/jquery.dataTables.min.js"></script>
	
	<!-- obtain bootstrap version 3.1.1 javascript library from a reputable source -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	
	<!-- note: this next link has code to make datatables work with bootstrap version 3 -->
	<script type="text/javascript" language="javascript" src="DT_bootstrap.js"></script>

	
	
	<!-- here's the $ script that is automatically run by jquery once the page has finished loading -->
	<script type="text/javascript" charset="utf-8">	
		/* Table initialisation */
		$(document).ready(function() {
			$('').dataTable();
		} );
	</script>

	
</head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="">Koyo</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="">Employees</a></li>
            <li><a href="">Create Employee</a></li>
			<li><a href="">Training</a></li>
            <li><a href="">Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
