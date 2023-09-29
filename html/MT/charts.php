
<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
	header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Robot Mobile Center</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="chartshow.js"></script>
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
      <a class="navbar-brand" href="index.php">Robot Mobile Center</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li class="active"><a href="charts.php">Chart</a></li>
        <li><a href="devices.php">Device</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
       	<li><a href='logout_script.php'><span class='glyphicon glyphicon-log-out'></span> Sign out</a></li>
      </ul>
    </div>
  </div>
</nav>



<style>
.button-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-top: 1%;
  width: 80%;
  margin-left: 5%;

}


.chart-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  width: 45%;
}

</style>
 



<div class="button-container">
  <div>

      
  </div>
  <canvas id="position" style="width: 50%; display: inline-block;"></canvas>
  <canvas id="line" style="width: 50%; display: none;"></canvas>
 
 
  <a href="get_data_from_db.php?delete_records=true" onclick="return confirm('Czy na pewno chcesz usunąć rekordy?')">Czyść przejazd</a>



<div class="chart-container">
<script src="chartshow.js"></script>
<canvas id="refresh" style="width: 50%; display: none; "></canvas>
<button id="update-btn" onclick="get_data()">Update Position</button>



</div>
</div>
</body>
</html>
