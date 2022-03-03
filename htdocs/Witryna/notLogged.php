<?php
require_once("config.php");
if(!isset($_SESSION["idUzytkownik"])){
			$_SESSION["errorInfo"] = "Zaloguj się, aby kontynuować.";
			$_SESSION["href"] = "login.html";
			header("Location: ./error.php");
			die();
		}
?>