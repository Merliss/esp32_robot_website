<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mobile Robot Centre</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.1.0/paho-mqtt.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="chartshow.js"></script>

 
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      background-color: invert;
      text-decoration-color: bisque;
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


        /* Custom styles for joystick buttons */
    /* Custom styles for joystick buttons */
    .joystick-button {
      width: 100px;
      height: 100px;
      margin: 5px;
      border-radius: 50%;
      font-size: 30px;
    }

    .joystick-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 400px;
    }

    .row-center {
      display: flex;
      justify-content: center;
    }

    .chartContainer {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

  width: 45%;
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
      <a class="navbar-brand" href="index.php">Mobile Robot Center</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <?php
          session_start();
          if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
            echo "<li><a href='charts.php'>Chart</a></li>";
            echo "<li><a href='devices.php'>Device</a></li>";
          }
	
	if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
        header("location: login_page.php");
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

<div class="container-fluid text-center">  
  <div class="row content">
    <div class="col-sm-6 text-left">
      <h2>Device Control</h2>
      <div class="joystick-container">
        <div class="row-center">
          <div class="row">
            <div class="col-xs-6">
              <button class="btn btn-primary joystick-button" id="btnAuto">AUTO</button>
            </div>
            <div class="col-xs-6">
              <button class="btn btn-primary joystick-button" id="btnStop">STOP</button>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="col-sm-6 text-left">
      <h2>Chart</h2>
      <canvas id="position" style="width: 50%; display: inline-block;"></canvas>
      <div class="chartContainer" style="height: 300px; width: 100%;">
      <canvas id="refresh" style="width: 50%; display: none; "></canvas>
      <button id="update-btn" onclick="get_data()">Update Position</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Tworzenie klienta MQTT
    var client = new Paho.Client("broker.hivemq.com", Number(8000), "clientId-MQMkc5j7o");

    // Konfiguracja klienta MQTT
    client.onConnectionLost = onConnectionLost;

    // Funkcja wywoływana po utracie połączenia
    function onConnectionLost(responseObject) {
      if (responseObject.errorCode !== 0) {
        console.log("Connection lost: " + responseObject.errorMessage);
      }
    }

    // Nawiązywanie połączenia MQTT
    function connectMQTT() {
      var options = {
        onSuccess: onConnect,
        //userName: "username",
        //password: "password"
      };
      client.connect(options);
    }

    // Funkcja wywoływana po pomyślnym nawiązaniu połączenia MQTT
    function onConnect() {
      console.log("Connected to MQTT broker");

      // Rejestracja nasłuchiwania przycisków
      $("#btnAuto").on("mousedown", function() {
        sendMQTTMessage("A");
      });

      $("#btnStop").on("mousedown", function() {
        sendMQTTMessage("S");
      }).on("mouseup", function() {
        sendMQTTMessage("S");
      });

    }

    // Funkcja wysyłająca wiadomość MQTT
    function sendMQTTMessage(message) {
      var mqttMessage = new Paho.Message(message);
      mqttMessage.destinationName = "iiot/device/control";
      client.send(mqttMessage);
    }

    // Wywołanie funkcji do nawiązywania połączenia MQTT
    connectMQTT();
  });
</script>

</body>
</html>
