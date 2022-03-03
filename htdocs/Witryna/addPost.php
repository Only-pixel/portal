<?php
require_once("config.php");
session_start();
require 'notLogged.php';
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}

$title = $_POST["title"];
$topic = $_POST["topic"];
if(strlen($title)<1 or strlen($topic)<1){
	$_SESSION["errorInfo"] = "uzupelnij wszystkie wymagane pola";
	$_SESSION["href"] = "addPostForm.php";
	header("Location: ./error.php");
	exit();
}
$content = $_POST["content"];
$allowTypes = array('jpg','png','jpeg');
$file_arr = cleanArrayFiles($_FILES['image']);
 if(!empty($file_arr[0]["name"])) { 
	foreach ($file_arr as $file) {
		$fileName = basename($file['name']);
		$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
		if(in_array($fileType, $allowTypes)){ 
			$photo = $file['tmp_name'];
			$imgContent = addslashes(file_get_contents($photo));
		}
		else{
			$_SESSION["errorInfo"] = "Sorry, only JPG, JPEG, PNG files are allowed to upload.";
			$_SESSION["href"] = "addPostForm.php";
			header("Location: ./error.php");
			exit();
		}
	}
}
if(strlen($content)<1){
	$content=NULL;
}
$query = $connect->query("call NowyPost('$title', '$content', '".$topic."', '".$_SESSION['idUzytkownik']."')");
clearStoredResults();
$query = $connect->query("select max(idPost) as idPost from posty where tytul LIKE '$title' and idUzytkownik = '".$_SESSION['idUzytkownik']."'");
if ($query->num_rows > 0) {
	$row = $query->fetch_assoc();
	$idPost = $row["idPost"];
}
clearStoredResults();
 if(!empty($file_arr[0]["name"])) { 
	foreach ($file_arr as $file) {
		$fileName = basename($file['name']);
		$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
		$photo = $file['tmp_name'];
		$imgContent = addslashes(file_get_contents($photo));
		$query = $connect->query("insert into galeria (zawartosc, nazwa_pliku, idPost) VALUES ('$imgContent', '$fileName','$idPost')"); 
		if($query){
			$statusMsg = "File uploaded successfully."; 
		}
		else{
			$_SESSION["errorInfo"] = "Wysyłanie pliku nie powiodło się."; 
			$_SESSION["href"] = "addPostForm.php";
			header("Location: ./error.php");
			exit();
		}
	}
}
mysqli_close($connect);
header("Location: ./index.php");
function clearStoredResults(){
    global $connect;
    
    do {
         if ($res = $connect->store_result()) {
           $res->free();
         }
    } while ($connect->more_results() && $connect->next_result());        
    
}

function cleanArrayFiles(&$file_input) { //lepiej uklada tablice plikow
    $file_ary = array();
    $file_count = count($file_input['name']);
    $file_keys = array_keys($file_input);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_input[$key][$i];
        }
    }
    return $file_ary;
}

?>