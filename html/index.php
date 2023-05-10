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
    /* .row.content {height: 450px} */
    
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
    @media screen {
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
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login_page.php"><span class="glyphicon glyphicon-log-in"></span> Sign in</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center">  
  <div class="row content">
    <div class="col-sm-12 text-left"> 
      <h1>Welcome to your management dashboard!</h1>
      <p>Please sign in to proceed to your devices or sign up and get yourself a device :)</p>
      <hr>
      <!-- <p>Our venture offers many IoT devices such as weather stations, home alarm systems and so on.</p> -->
    </div>
    </div>
  </div>
</div>

<div class="container">

	<?php
        require_once("../../db_connection_data.php");
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $sql = 'SELECT * FROM DEVICE WHERE 1';
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
                echo $row['DEVICE_ID'] .$row['USER_ID'];
        }

        mysqli_close($conn);
	?>


    <h2>Sign up for free</h2>
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
    </form>
  </div>


</body>
</html>
