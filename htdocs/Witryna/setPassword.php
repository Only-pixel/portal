<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(!isset($_POST) || !isset($_SESSION['idUzytkownik'])){
	if(!isset($_POST) || !isset($_SESSION['tmp'])){
		header("Location: ./destroy.php");
		die();
	}
	$user = $_SESSION['tmp'];
}
else{
	$user = $_SESSION['idUzytkownik'];
}
$password=$_POST["password"];
$password2=$_POST["password2"];
if(strcmp($password,$password2) == 0){
	$password = hash('sha256',$password);
	$result = $connect->query("UPDATE hasla SET czy_aktywne=0 WHERE idUzytkownik=".$user." ;");
	$result = $connect->query("INSERT INTO hasla( Haslo, czy_aktywne,idUzytkownik) VALUES ('".$password."', 1, '".$user."' )");
	header("Location: ./profile.php");
	exit();
}
else{
	$_SESSION["errorInfo"] = "Hasła nie są takie same.";
	$_SESSION["href"] = "./newPassword.php";
	header("Location: ./error.php");
	die();
}
?>