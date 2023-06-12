<?php
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header("location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Weather Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
  <style>
    .font_size{
	font-size: 16px;
    }
    #dashboardFrame {
    width: 100%;
    height: 100%;
    border: none;
    overflow: hidden;
    background-color: white;
    }
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
        <li><a href="charts.php">Charts</a></li>
        <li><a href="devices.php">Devices</a></li>
	<li><a href="camera_page.php">Cam view</a></li>
     	<li class="active"><a href="weather.php">Forecast</a></li> 
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href='logout_script.php'><span class='glyphicon glyphicon-log-out'></span> Sign out</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">  
  <div class="row content">
    <div class="col-sm-12 text-left"> 
	<div class="container">
    <h2>Weather Forecast</h2>
    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th colspan="3">Today</th>
	  <th></th>
          <th colspan="3">Tomorrow</th>
        </tr>
        <tr>
          <th>Hour</th>
          <th>Temperature (°C)</th>
          <th>Humidity (%)</th>
          <th>Pressure (hPa)</th>
	  <th>Hour </th>
          <th>Temperature (°C)</th>
          <th>Humidity (%)</th>
          <th>Pressure (hPa)</th>
        </tr>
      </thead>
      <tbody id="weatherData"></tbody>
    </table>
  </div>
      <!-- <p>Our venture offers many IoT devices such as weather stations, home alarm systems and so on.</p> -->
    </div>
    </div>
  </div>
</div>
<script>
fetch('https://api.open-meteo.com/v1/forecast?latitude=50.04&longitude=22.00&hourly=temperature_2m,relativehumidity_2m,weathercode,surface_pressure&current_weather=true&forecast_days=3&timezone=Europe%2FBerlin')
  .then(response => response.json())
  .then(data => {
    // Process the response data
    console.log(data);

	var temperature = data.hourly.temperature_2m;
	var humidity = data.hourly.relativehumidity_2m;
	var pressure = data.hourly.surface_pressure;
	var dates = data.hourly.time;

	var tableBody = document.getElementById('weatherData');

	for(var i = 0; i < 24; ++i){
		var row = document.createElement('tr');
		var tmp1 = document.createElement('th');
		var tmp2 = document.createElement('th');
		var press1 = document.createElement('th');
		var press2 = document.createElement('th');
		var hum1 = document.createElement('th');
		var hum2 = document.createElement('th');
		var tim1 = document.createElement('th');
		var tim2 = document.createElement('th');

		tmp1.textContent = temperature[i];
		tmp2.textContent = temperature[i + 24];

		press1.textContent = pressure[i];
		press2.textContent = pressure[i + 24];

		hum1.textContent = humidity[i];
		hum2.textContent = humidity[i + 24];

		tim1.textContent = dates[i].slice(-5);
		tim2.textContent = dates[i + 24].slice(-5);

		row.appendChild(tim1);
		row.appendChild(tmp1);
		row.appendChild(hum1);
		row.appendChild(press1);

		row.appendChild(tim2);
		row.appendChild(tmp2);
		row.appendChild(hum2);
		row.appendChild(press2);

		tableBody.appendChild(row);
	}

  })
  .catch(error => {
    // Handle any errors that occurred during the request
    console.error('Error:', error);
  });
</script>

</body>
</html>

