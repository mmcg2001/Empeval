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
     </div>
    <div class="collapse navbar-collapse" id="myNavbar">
     </div>
  </div>
</nav>

<head>
<img src="koyo logo.jpg" >
<style>
.bg-1 { 
    background-color: #3399ff; /* Blue */
    color: #0f0f0f;
}

form {
  text-align: center;
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



<h1 align = 'center'>Employee Record/Evaluation Login</h1>


<form class="form-inline" role="form" method = 'post' action = 'loginprocess.php'>


  <div class="form-group">
     <label for="user">User Name:</label>
    <input type="text" class="form-control" name = "user">
  </div>
  <br/><br/>
  <div class="form-group">
    <label for="pass">Password:&nbsp; </label>
    <input type="password" class="form-control" name ="pass">
  </div>
  <br/><br/>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div> &nbsp;
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