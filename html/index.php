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
	body, html {
      height: auto;
      margin: 0;
      padding: 0;
    }
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    /* .row.content {height: 450px} */
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }

.container {
  position: relative;
  overflow: hidden;
  width: 100%;
  padding-top: 100%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
  padding-bottom: 56.25%;
}

.container1{
position: relative;
  overflow: hidden;
  width: 100%;
}

/* Then style the iframe to fit in the container div with full height and width */
.responsive-iframe {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;
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
        <li class="active"><a href="index.php">Home</a></li>
	<?php
		session_start();
                if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
                        echo "<li><a href='charts.php'>Charts</a></li>";
        		echo "<li><a href='devices.php'>Devices</a></li>";
			echo "<li><a href='camera_page.php'>Cam view</a></li>";
			echo "<li><a href='weather.php'>Forecast</a></li>";
                }

	?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
	<?php
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
			echo "<li><a href='logout_script.php'><span class='glyphicon glyphicon-log-out'></span> Sign out</a></li>";
		}
		else{
			echo "<li><a href='login_page.php'><span class='glyphicon glyphicon-log-in'></span> Sign in</a></li>";
	
		}
	?>
      </ul>
    </div>
  </div>
</nav>

<?php

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
	echo '<div class="container">';

	echo "<h1>Data visualization</h1>";
	echo '<iframe id="dashboardFrame" class="responsive-iframe" src="http://159.65.116.172:1880/ui" frameborder="0"></iframe>';
	echo '</div>';
}
else{
	 echo '<div class="container1"><h2>Sign up for free</h2>
	   <form action="/action_page.php">
         <div class="form-group">
           <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your name" name="name">
          </div>
          <div class="form-group">
            <label for="sname">Surname:</label>
            <input type="text" class="form-control" id="sname" placeholder="Enter your surname" name="sname">
          </div>
          <div class="form-group">
            <label for="nick">Nickname:</label>
            <input type="text" class="form-control" id="nick" placeholder="Enter your unique nickname" name="nick">
          </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email">
      </div>
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" placeholder="Enter your password" name="pwd">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form></div>';

}

?>


</body>
</html>
