<?php
require_once("config.php");
session_start();

$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(!isset($_SESSION['idUzytkownik']) && !isset($_SESSION['tmp'])){
	header("Location: ./index.php");
	die();
}
if(isset($_GET['required'])){
	$required=1;
}
else{
	$required=0;
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
    <title>Ustaw nowe hasło</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel='stylesheet' href='css/newPassword.css'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
            <form class="form-horizontal" role="form" method='post' action="./setPassword.php">
                <div class="title-bar">
					<h2>Ustaw nowe hasło</h2>
					<?php if($required==1){echo "<h6>Administrator zdezaktywował Twoje hasło z powodu ryzyka włamania lub przeterminowania.</h6>"; }?>
				</div>
                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">Nowe Hasło</label>
                    <div class="col-sm-8">
                        <input type="password" id="password" class="form-control" name="password">
                    </div>
                </div>
				<div class="form-group">
                    <label for="password_redo" class="col-sm-4 control-label">Powtórz hasło</label>
                    <div class="col-sm-8">
                        <input type="password" id="password" class="form-control" name="password2">
                    </div>
                </div>
                       <button type="submit" class="btn btn-primary">Zapisz</button>
            </form> <!-- /form -->
        </div> <!-- ./container -->
		<p class="text-center"><a href="./destroy.php">Wyloguj się</a></p>
</body>