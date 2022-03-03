<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
	exit("ERROR: Could not connect. ".mysqli_connect_error());
}
$login = $_POST["usernameLogin"];
$password = hash('sha256',$_POST["passwordLogin"]);
$sql = "select idUzytkownik, miejscowosc, nazwa, data_rejestracji, uprawnienia, plec from uzytkownicy where (login='$login' or nazwa='$login')";
$result = $connect->query($sql);
if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		$sql2 = "select haslo from hasla where idUzytkownik = '".$row["idUzytkownik"]."' and czy_aktywne=1";
		$result2 = $connect->query($sql2);
		if ($result2->num_rows > 0) {
			$row2 = $result2->fetch_assoc();
		}
		if(strcmp($row2["haslo"],$password)==0){
			$sql3 = "select DlugoscBlokady(".$row["idUzytkownik"].") as czas from zablokowani;";
			$result3 = $connect->query($sql3);
			if ($result3->num_rows > 0) {
				$row3 = $result3->fetch_assoc();
				if($row3['czas']>0){
					$_SESSION["errorInfo"] = "Konto zablokowane. Pozostało ".$row3['czas']." dni blokady. ";
					$_SESSION["href"] = "login.html";
					header("Location: ./error.php");
					exit();
				}
			}
			$_SESSION["idUzytkownik"] = $row["idUzytkownik"]; //zapisuje id uzytkownika
			$_SESSION["Nazwa"] = $row["nazwa"];
			$_SESSION["miejscowosc"] = $row["miejscowosc"];
			$_SESSION["data_rejestracji"] = $row["data_rejestracji"];
			$_SESSION["uprawnienia"] = $row["uprawnienia"];
			$_SESSION["plec"] = $row["plec"];
			header("Location: ./index.php");
		}
		else{ //jesli sie nie uda znalezc aktualnego hasla to sprawdzamy stare
			$sql2 = "select haslo from hasla where idUzytkownik = '".$row["idUzytkownik"]."' and czy_aktywne=2";
			$result2 = $connect->query($sql2);
			if ($result2->num_rows > 0) {
				$row2 = $result2->fetch_assoc();
			}
			if(strcmp($row2["haslo"],$password)==0){
				$_SESSION["tmp"] = $row["idUzytkownik"];
				header("Location: ./newPassword.php?required=1");
				exit();
			}
			$_SESSION["errorInfo"] = "Błędne hasło.";
			$_SESSION["href"] = "login.html";
			header("Location: ./error.php");
			exit();
		}
		mysqli_close($connect);
		exit();
}
else{
	mysqli_close($connect);
	$_SESSION["errorInfo"] = "Uzytkownik nie istnieje.";
	$_SESSION["href"] = "login.html";
	header("Location: ./error.php");
	die();
}

function clearStoredResults(){
    global $connect;
    do {
         if ($res = $connect->store_result()) {
           $res->free();
         }
    } while ($connect->more_results() && $connect->next_result());
}
?>