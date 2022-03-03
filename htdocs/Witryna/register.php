<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}

$username = $_POST["username"];
$password = hash('sha256',$_POST["password"]);
$email = $_POST["email"];
$password_redo = hash('sha256',$_POST["password_redo"]);
$country =$_POST["country"];
$sex = $_POST["sex"];

if(strlen($username)<1 or strlen($password)<1 or strlen($password_redo)<1 or strlen($country)<1 or strlen($email)<1){
	$_SESSION["errorInfo"] = "Zbyt krótka nazwa";
	$_SESSION["href"] = "register.html";
	header("Location: ./error.php");
	exit();
}
if($password != $password_redo){
	$_SESSION["errorInfo"] = "Blad wpisywania hasla";
	$_SESSION["href"] = "register.html";
	header("Location: ./error.php");
	die();
}
$result=$connect->query("SELECT * from uzytkownicy WHERE login='$email' or nazwa='$username'");
if(mysqli_num_rows($result) > 0)
    {			
		$_SESSION["errorInfo"] = "Uzytkownik o tej nazwie juz istnieje";
		$_SESSION["href"] = "register.html";
		header("Location: ./error.php");  //blad: uzytkownik o tej nazwie juz istnieje
		die();
    }
$connect->store_result();
$query = $connect->query("call NowyUzytkownik('$email', '$username', '$password', '$sex', '$country')");
echo "Uzytkownik $username zostal dodany";
clearStoredResults();
$sql = "select idUzytkownik, data_rejestracji, uprawnienia, plec from uzytkownicy where login='$email' and '$username'=nazwa";
$result = $connect->query($sql);
if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$_SESSION["idUzytkownik"] = $row["idUzytkownik"];
		$_SESSION["Nazwa"] = $username;
		$_SESSION["miejscowosc"] = $country;
		$_SESSION["data_rejestracji"] = $row["data_rejestracji"];
		$_SESSION["uprawnienia"] = $row["uprawnienia"];
		$_SESSION["plec"] = $row["plec"];
  }
clearStoredResults();
header("Location: ./login.html");
mysqli_close($connect);

function clearStoredResults(){
    global $connect;
    
    do {
         if ($res = $connect->store_result()) {
           $res->free();
         }
    } while ($connect->more_results() && $connect->next_result());        
    
}

?>