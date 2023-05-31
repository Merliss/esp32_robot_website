<?php

session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
	header("location: index.php");
}

require_once("db_connection_data.php");

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$startDate = $_GET['start_date']; // Pobierz wartość start_date z parametrów URL
$endDate = $_GET['end_date']; // Pobierz wartość end_date z parametrów URL


$query = $pdo->prepare("SELECT LOG_ID, TEMPERATURE, PRESSURE, HUMIDITY, AIR_QUALITY, TIME_STAMP FROM log WHERE TIME_STAMP BETWEEN :start_date AND :end_date");
$query->bindParam(':start_date', $startDate);
$query->bindParam(':end_date', $endDate);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);


$chartData = [
    'log_id' => [],
    'temperature' => [],
    'humidity' => [],
    'pressure' => [],
    'air_quality' => [],
    'time_stamp' => []
];

foreach ($data as $row) {
    $chartData['time_stamp'][] = $row['TIME_STAMP'];
    $chartData['temperature'][] = $row['TEMPERATURE'];
    $chartData['humidity'][] = $row['HUMIDITY'];
    $chartData['pressure'][] = $row['PRESSURE'];
    $chartData['air_quality'][] = $row['AIR_QUALITY'];
    $chartData['log_id'][] = $row['LOG_ID'];
}

//header('Content-Type: application/json');
echo json_encode($chartData);
?> 