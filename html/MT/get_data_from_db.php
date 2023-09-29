<?php

session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
	header("location: index.php");
}

require_once("db_connection_data.php");

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (isset($_GET['delete_records'])) {
    // Kasowanie rekordów o id_log większym od 1
    $query = $pdo->prepare("DELETE FROM log WHERE id_log > 1");
    $query->execute();
    
    // Przekierowanie z powrotem na tę samą stronę
    header("location: charts.php");
    exit();
}


$query = $pdo->query("SELECT id_log, temperature, humidity, posx, posy, timestamp FROM log");
$data = $query->fetchAll(PDO::FETCH_ASSOC);


$chartData = [
    'log_id' => [],
    'temperature' => [],
    'humidity' => [],
    'posx' => [],
    'posy' => [],
    'time_stamp' => []
];

foreach ($data as $row) {
    $chartData['time_stamp'][] = $row['timestamp'];
    $chartData['temperature'][] = $row['temperature'];
    $chartData['humidity'][] = $row['humidity'];
    $chartData['posx'][] = $row['posx'];
    $chartData['posy'][] = $row['posy'];
    $chartData['log_id'][] = $row['id_log'];
}

echo json_encode($chartData);
?> 
