<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(!isset($_SESSION['idUzytkownik']) || !isset($_GET['idPost'])){
	header("Location: ./index.php");
	die();
}
if($_SESSION["uprawnienia"]==1){
	$sql = "select * from posty where idPost=".$_GET['idPost'].";";
}
else{
	$sql = "select * from posty where idUzytkownik=".$_SESSION['idUzytkownik']." and idPost=".$_GET['idPost'].";";
}
$result = $connect->query($sql);
if ($result->num_rows > 0) {
	$sql = "delete from posty where idPost=".$_GET['idPost'].";";
	$result = $connect->query($sql);
	header("Location: ./index.php");
	exit();
}
else{
	$_SESSION["errorInfo"] = "Nie posiadasz wymaganych uprawnień do usunięcia tego postu.";
	$_SESSION["href"] = "index.php";
	header("Location: ./error.php");
	die();
}
?>