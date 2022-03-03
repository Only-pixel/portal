<?php
require_once("config.php");
if($_SESSION["plec"] == 1){
	echo "kobieta";
}
else if($_SESSION["plec"] == 0){
	echo "mezczyzna";
}
else{
	echo "inna";
}
	
?>