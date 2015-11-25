<!DOCTYPE html>


<html>

<nav class="navbar navbar-default">
  <div class="container">
     <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="#">Home</a>
     </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <!--<ul class="nav navbar-nav navbar-right">
        <li><a href="#">Create</a></li>
	<li><a href="#">Read</a></li>
         <li><a href="#">Update</a></li>
        <li><a href="#">Delete</a></li>
      </ul>-->
     </div>
  </div>
</nav>

<head>
<img src="koyo logo.jpg" alt="Bird">
<style>
.bg-1 { 
    background-color: #004cff; /* Blue */
    color: #0f0f0f;
}
</style>

<title>Employee Training</title>

  <link rel="stylesheet"
href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container-fluid bg-1">



<h1>Employee Record/Evaluation Login</h1>


<form class="form-inline" role="form" method = 'post' action = 'loginprocess.php'>
  <div class="form-group">
     <label for="user">User Name:</label>
    <input type="text" class="form-control" name = "user">
  </div>
  <div class="form-group">
    <label for="pass">Password:</label>
    <input type="password" class="form-control" name ="pass">
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
<br>
<br>
</form> 

</div>

</body>

<!--background color for footer-->
<style>
.bg-4 { 
    background-color: #2f2f2f;
    color: #ffffff;
}
</style>

<footer class="container-fluid bg-4 text-center">
  <p><a href="http://koyo-bearings.com/">Copyright © 2015 Koyo Bearings. All rights reserved. </a></p> 
</footer>

</html> 