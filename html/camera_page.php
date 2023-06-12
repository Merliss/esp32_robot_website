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
    
    /* Set black background color, white text, and some padding */
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

    /* Center the video element */
    #camera-stream {
      display: block;
      margin: 0 auto;
    }
  </style>
</head>
<body>
<!-- Your PHP code -->
<!-- Navigation bar -->
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
	<li class="active"><a href="camera_page.php">Cam view</a></li>
	<li><a href="weather.php">Forecast</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href='logout_script.php'><span class='glyphicon glyphicon-log-out'></span> Sign out</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Video element -->
<div class="container mx-auto">
  <img id="camera-stream" alt="camera view"/>
</div>

<!-- Remaining HTML content -->
<div class="container-fluid text-center">  
  <!-- Content -->
</div>

<!-- JavaScript code -->
<script>
	function generateRandomString(length) {
  var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var result = '';
  
  for (var i = 0; i < length; i++) {
    var randomIndex = Math.floor(Math.random() * characters.length);
    result += characters.charAt(randomIndex);
  }
  
  return result;
}
 // Connect to MQTT broker
      var client = new Paho.MQTT.Client("159.65.116.172", 9001, generateRandomString(10));
      var options = {
        timeout: 3,
	onSuccess: onConnect
      };
      client.onConnectionLost = onDisconnect;

      client.connect({
        ... options
      });
	function onDisconnect(responseObject) {
	  if (responseObject.errorCode !== 0) {
	    console.log("Connection lost: " + responseObject.errorMessage);
	    client.connect({ ... options});
	  }
	}
      function sendMessage(topic, msg) {
        var payload = new Paho.MQTT.Message(msg);
        payload.destinationName = topic;
        client.send(payload);
      }

      // Subscribe to topic
      function onConnect() {
        console.log("Connected to MQTT broker.");
	    client.subscribe("camera/image");
      }
      
      // Display received messages
      client.onMessageArrived = function(message) {

	if(message.destinationName == "camera/image"){
                console.log("Hi");
                var image_data = new Uint8Array(message.payloadBytes);
                var data_string = "";
                for (var i = 0; i < image_data.length; i++) {
                        data_string += String.fromCharCode(image_data[i]);
                }
                var base64_data = btoa(data_string);
                document.getElementById('camera-stream').src = "data:image/jpeg;base64," + base64_data;
		return;
        }
    }
</script>
</body>
</html>
