<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(!isset($_SESSION['idUzytkownik']) || !isset($_POST['username'])){
	header("Location: ./index.php");
	die();
}
if($_SESSION['uprawnienia']<1){
	$_SESSION["errorInfo"] = "Nie posiadasz uprawnień do wymuszania zmiany hasła.";
	$_SESSION["href"] = "profile.php";
	header("Location: ./error.php");
	die();
}
$user = $_POST['username'];
$sql = "select * from uzytkownicy where nazwa='".$user."';";
$result = $connect->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$sql = "UPDATE hasla SET czy_aktywne=2 WHERE idUzytkownik='".$row['idUzytkownik']."' and czy_aktywne=1;";
	$result = $connect->query($sql);
	header("Location: ./profile.php");
	exit();
}
else{
	$_SESSION["errorInfo"] = "Nie znaleziono użytkownika o podanej nazwie.";
	$_SESSION["href"] = "profile.php";
	header("Location: ./error.php");
	die();
}
?>