<?php
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            die("ERROR: Could not connect. ".mysqli_connect_error());
        }
$username = $_POST["username"];
$country = $_POST["country"];

if(strlen($username)>3){
	
}
if(strlen($country)>3){
	
}
mysqli_close($connect);
?>