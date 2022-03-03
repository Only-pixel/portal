<?php
	require_once("config.php");
	session_start();
	$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
$wiadomosc = $_POST["wyslij"];
$sql = "insert into wiadomosci values(current_timestamp(),'$wiadomosc' ,0,'".$_SESSION['idUzytkownik']."','".$_GET['uid']."')";
$result = $connect->query($sql);
header("Location: ./messages.php?uid=".$_GET['uid']);
exit();
mysqli_close($connect);
?>