<?php
		require_once("config.php");
		session_start();
		$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
		require 'notLogged.php';
		if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
		}
		$tresc = $_POST["skomentuj"];
		$idPost = $_POST["idPost"];
		$idUser = $_SESSION['idUzytkownik'];
		if(strlen($tresc)>0){
			$result = $connect->query("insert into komentarze(data,tresc,idUzytkownik,idPost) values (current_timestamp(), '$tresc', '$idUser', '$idPost')");
		}
		mysqli_close($connect);
		header("Location: ./comments.php?idPost=$idPost");
		exit();
?>