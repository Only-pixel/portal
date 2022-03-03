<?php
	require_once("config.php");
	session_start();
	$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
	require 'notLogged.php';
if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
//$_SESSION["odbiorcaId"];
$result2 = $connect->query("select nazwa from uzytkownicy where idUzytkownik=".$_GET['uid']);
if ($result2->num_rows > 0){
	$row = $result2->fetch_assoc();
	$nazwaOdbiorcy = $row['nazwa'];
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Rozmowa z <?php echo $nazwaOdbiorcy; ?></title>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap4.min.js"></script>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/messages.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="">Blog</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="./index.php">Strona główna <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contacts.php">Wiadomości</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="./profile.php">Panel użytkownika</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="./destroy.php">Wyloguj się</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Wpisz tytuł lub temat..." aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Szukaj</button>
        </form>
      </div>
    </nav>
	
<?php
$sql = "select * from wiadomosci where (Odbiorca = '".$_SESSION['idUzytkownik']."' and Nadawca = '".$_GET['uid']."') or  (Nadawca = '".$_SESSION['idUzytkownik']."' and Odbiorca = '".$_GET['uid']."') order by data desc limit 50";
$result = $connect->query($sql);
			?>
			<main role="main" class="container">
			<?php
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){  //other -> lewa strona
				if($_GET['uid'] == $row["Nadawca"]){ //jezeli wiadomosc odbiorcy
				?>
					<div class="other jumbotron"> 
						<div class='username'><h5><?php echo $nazwaOdbiorcy; ?></h5></div>
						<p class="lead"><?php echo $row["tresc"]; ?></p>
						<div class="sidetext"><?php echo $row["data"]; ?></div>
					</div>
				<?php }
				else{
					?>
					<div class="self jumbotron">
					<div class='username'><h5>Ty</h5></div>
					<p class="lead"><?php echo $row["tresc"]; ?></p>
					<div class="sidetext"><?php echo $row["data"]; ?></div>
					</div>
					<?php
				}
		}
		}
		?>
		</main>
		<?php
		mysqli_close($connect);
?>

<nav class="navbar fixed-bottom bg-dark">
        <form class="form-send form-inline" action="./wyslijWiadomosc.php?uid=<?php echo $_GET['uid']; ?>" method="post">
          <input class="text-scale text-input form-control" type="text" placeholder="Napisz wiadomość..." aria-label="Search" name = "wyslij">
          <button class="send-btn btn btn-primary my-2 my-sm-0" type="submit">Wyślij</button>
        </form>
    </nav>
</body>
</html>