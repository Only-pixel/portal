<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(strlen($_POST["key"])>0){
	$_SESSION["key"] = $_POST["key"];
}

header("Location: ./index.php");
exit();
mysqli_close($connect);
?>