<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(!isset($_POST) || !isset($_SESSION['idUzytkownik'])){
	header("Location: ./index.php");
	die();
}
$username = $_POST["username"];
$location = $_POST["country"];
$_SESSION["Nazwa"] = $username;
$_SESSION["miejscowosc"] = $location;
$result = $connect->query("UPDATE uzytkownicy SET nazwa='".$username."', miejscowosc='".$location."' WHERE idUzytkownik=".$_SESSION['idUzytkownik']." ;");
header("Location: ./profile.php");
die();

?>