<?php

session_start();

require_once("../../db_connection_data.php");

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$login = $_POST['username'];
$pwd = $_POST['password'];

// echo $login . $pwd;

$query = $pdo->prepare("SELECT * FROM SYSTEM_USER WHERE LOGIN = :login AND PASSWORD = :pwd");
$query->execute(['login'=> $login, 'pwd' => $pwd]); 

if($query->rowCount()){
	$row = $query->fetch();

	$_SESSION['logged_in'] = true;
	$_SESSION['login'] = $row['LOGIN'];
	$_SESSION['username'] =$row['NAME_SURNAME'];
}

$pdo = null;

// echo var_dump($_SESSION);

header('Location:index.php');
?>
