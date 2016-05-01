<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Timeline view</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="favicon.png">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="bootstrap-3.3.6-dist/css/bootstrap.min.css">
  <link href="visjs-dist/vis.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
  <script src="visjs-dist/vis.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php"><img src="favicon.png" height="25px" /></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Acceuil</a></li>
        <li><a href="#">A Propos</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <p><a href="#">Link1</a></p>
      <p><a href="#">Link2</a></p>
      <p><a href="#">Link3</a></p>
    </div>
    <div class="col-sm-10 text-left" style="text-align: center;"> 
          <?php

    if(isset($_POST['submit']))
    {

    	$uploaddir = 'uploaded/';
    	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		$_SESSION["uploadfile"] = $uploadfile;

    	echo '<pre>';
    	if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
    	{
    		header('Location: errorupload.html');
    	}
		header('Location: xmlToMysql.php');
    }
    else
    {
    	echo '<center>Error: no file specified !</center>';
    }

    ?>
</div>

</body>
</html>
