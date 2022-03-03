<?php
		require_once("config.php");
		session_start();
		$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}

$odbiorca = $_POST["odbiorca"];
if(strlen($odbiorca)<1){
	$_SESSION["errorInfo"] = "Zbyt krótka nazwa jak na poprawnego uzytkownika :)";
	$_SESSION["href"] = "contacts.php";
	header("Location: ./error.php");
	exit();
}
$sql = "select idUzytkownik from uzytkownicy where nazwa = '$odbiorca'";
$result = $connect->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			//$_SESSION["odbiorcaId"] = $row["idUzytkownik"];
			//$_SESSION["odbiorcaNazwa"] = $odbiorca;
			clearStoredResults();
			mysqli_close($connect);
			header("Location: ./messages.php?uid=".$row["idUzytkownik"]);
			exit();
		}
		else{
			$_SESSION["errorInfo"] = "Podany uzytkownik nie istnieje";
			$_SESSION["href"] = "contacts.php";
			header("Location: ./error.php");
			exit();
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