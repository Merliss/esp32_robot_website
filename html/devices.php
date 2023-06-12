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
        <li class="active"><a href="devices.php">Devices</a></li>
	<li><a href="camera_page.php">Cam view</a></li>
	<li><a href="weather.php">Forecast</a></li>

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
        <div class="container mt-5">
    <form id="settings">
      <div class="form-group">
        <label for="input1">Device ID:</label>
        <input type="number" class="form-control" id="input1" name="input1">
      </div>
      <div class="form-group">
        <label for="input2">High threshold:</label>
        <input type="number" class="form-control" id="input2" name="input2">
      </div>
      <div class="form-group">
        <label for="input3">Low threshold:</label>
        <input type="number" class="form-control" id="input3" name="input3">
      </div>
      <div class="form-group">
        <label for="input4">Set/Clear alarm:</label>
        <select class="form-control" id="input4" name="input4">
          <option value="0">Alarm cleared</option>
          <option value="1">Alarm set</option>
        </select>
      </div>
      <div class="form-group">
        <label for="input5">Logging frequency:</label>
        <select class="form-control" id="input5" name="input5">
          <option value="0">Every 10 minutes</option>
          <option value="1">Every 30 minutes</option>
          <option value="2">Every hour</option>
        </select>
      </div>
      <div class="form-group">
        <label for="input6">Chart update frequency:</label>
        <select class="form-control" id="input6" name="input6">
          <option value="0">Every 10 minutes</option>
          <option value="1">Every 30 minutes</option>
          <option value="2">Every hour</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
      <!-- <p>Our venture offers many IoT devices such as weather stations, home alarm systems and so on.</p> -->
    </div>
    </div>
  </div>
</div>
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
	    client.subscribe("ws_init/dev_settings");
	    sendMessage("ws_init", "dummy");
      }
      
      // Display received messages
      client.onMessageArrived = function(message) {
	if(message.destinationName == "ws_init/dev_settings"){
		data = JSON.parse(message.payloadString);
		console.log(data);

		document.getElementById("input1").value = data.device_id;
		document.getElementById("input2").value = data.alarm_high;
		document.getElementById("input3").value = data.alarm_low;
		document.getElementById("input4").value = data.alarm_set;
		document.getElementById("input5").value = data.logging_config;
		document.getElementById("input6").value = data.graph_config;
	}
    }

document.getElementById("settings").addEventListener("submit", function(event) {
  event.preventDefault();

  var dev_id = parseInt(document.getElementById("input1").value);
  var hi_tr = parseInt(document.getElementById("input2").value);
  var lo_tr = parseInt(document.getElementById("input3").value);
  var alm = parseInt(document.getElementById("input4").value);
  var log_freq = parseInt(document.getElementById("input5").value);
  var chart_freq = parseInt(document.getElementById("input6").value);

  message = {
        "device_id" : dev_id,
        "alarm_high" : hi_tr,
        "alarm_low" : lo_tr,
        "alarm_set" : alm,
        "graph_config" : chart_freq,
        "logging_config" : log_freq
  };

  console.log(message);

  stringified_message = JSON.stringify(message);

  console.log(stringified_message);

  sendMessage("ws_settings", stringified_message);
  // Additional code to handle the cancellation of the form submission
});

</script>

</body>
</html>

