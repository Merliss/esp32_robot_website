<!DOCTYPE html>
<html lang="en">
<head>
  <title>Weather Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>
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
      <a class="navbar-brand" href="index.php">Weather dashboard</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login_page.php"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
      </ul>
    </div>
  </div>
</nav>
        <div class="container">
		<div class="col-md-12 mx-auto">
                <h3 class="text-center mb-4">Zaloguj się do systemu</h3>
                <form method="post" action="login_script.php">
                    <div class="form-group">
                        <label for="username">Nazwa użytkownika:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Podaj nazwę użytkownika">
                    </div>
                    <div class="form-group">
                        <label for="password">Hasło:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Podaj hasło">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Zaloguj</button>
                </form>
		
            </div>
        </div>
	<?php session_start(); if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) header('location:index.php'); ?>

</body>
</html>
