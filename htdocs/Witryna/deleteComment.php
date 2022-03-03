<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(!isset($_SESSION['idUzytkownik']) || !isset($_GET['idKomentarz'])){
	header("Location: ./index.php");
	die();
}
if($_SESSION["uprawnienia"]==1){
	$sql = "select * from komentarze where idKomentarz=".$_GET['idKomentarz'].";";
}
else{
	$sql = "select * from komentarze where idUzytkownik=".$_SESSION['idUzytkownik']." and idKomentarz=".$_GET['idKomentarz'].";";
}
$result = $connect->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$idPosta = $row['idPost'];
	$sql = "delete from komentarze where idKomentarz=".$_GET['idKomentarz'].";";
	$result = $connect->query($sql);
	header("Location: ./comments.php?idPost=".$idPosta);
	exit();
}
else{
	$_SESSION["errorInfo"] = "Nie posiadasz wymaganych uprawnień do usunięcia tego komentarza.";
	$_SESSION["href"] = "index.php";
	header("Location: ./error.php");
	die();
}
?>