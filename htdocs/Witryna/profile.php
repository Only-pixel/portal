
<!doctype html>
<?php
require_once("config.php");
session_start();
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
if(!isset($_SESSION['idUzytkownik'])){
	header("Location: ./index.php");
	die();
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap4.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/profile.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Blog</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <a class="nav-link" href="./index.php">Strona główna </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contacts.php">Wiadomości</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="./profile.php">Profil użytkownika <span class="sr-only">(current)</span></a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="./destroy.php">Wyloguj się</a>
          </li>
          </ul>
          <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      </nav>
    </header>
    <main role="main">

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1" ></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="img/grey.jpg" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1>Dzień dobry!</h1>
                <p>Świat nie jest dla tych, którzy wcześnie wstają. Świat należy do tych, którzy wstają szczęśliwi.</p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="img/grey.jpg" alt="Second slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1>Dzień dobry!</h1>
                <p>Wraz z dniem pojawia się nowa siła i nowe myśli.</p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="img/grey.jpg" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1>Dzień dobry!</h1>
                <p>Dzień bez uśmiechu to dzień stracony.</p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <div class="container marketing"><div class="row">
	<?php
	$sql = "select Nadawca from wiadomosci where Odbiorca = '".$_SESSION['idUzytkownik']."' and data in (select max(data) from wiadomosci where Odbiorca = '".$_SESSION['idUzytkownik']."' group by Nadawca) order by data desc limit 3";
	$result = $connect->query($sql);
	if ($result->num_rows > 0) {
		$i=0;
		while($row = $result->fetch_assoc()){
			$sql2 = "select nazwa from uzytkownicy where idUzytkownik = '".$row['Nadawca']."'";
			$result2 = $connect->query($sql2);
			$name = $result2->fetch_assoc();
			echo '<div class="col-lg-4">
            <img class="rounded-circle" src="img/';
			if($i==0){
				echo "kiwi.jpg";
			}
			else if($i==1){
				echo "arbuz.jpg";
			}
			else{
				echo "owoc2.jpg";
			}
			echo '" alt="Image" width="140" height="140">
            <h2>';
			echo $name["nazwa"];
			echo '</h2>
            <p><a class="btn btn-secondary" href="messages.php?uid=';
			echo $row['Nadawca'];
			echo '" role="button">Napisz &raquo;</a></p></div>';
			$i = $i + 1;
		}
	}
	?>
	</div><!-- /.row -->

		<div class="bg-dark text-center text-white overflow-hidden">
			<form class="form-horizontal" role="form" action="./profile.php">
					<div class="my-3 py-3">
					<h2 class="display-5">Szczegóły</h2>
					<p class="lead"> Aktualna nazwa użytkownika:  <?php echo $_SESSION["Nazwa"];?> </p>
					<p class="lead">Płeć:  <?php require 'plec.php'; ?> </p>
					<p class="lead">Data rejestracji: <?php echo $_SESSION["data_rejestracji"];?></p>
					<p class="lead">Aktualne miejsce zamieszkania: <?php echo $_SESSION["miejscowosc"];?> </p>
					<a class="btn btn-lg btn-secondary" href="./alterProfile.html" role="button">Zmień dane &raquo;</a>
					<a class="btn btn-lg btn-secondary" href="./newPassword.php" role="button">Zmień hasło &raquo;</a><br>
				</div>
			</form>
		</div>
		<?php
		if($_SESSION["uprawnienia"]==1){	
				echo '<div class="admin text-center text-white overflow-hidden"><form class="form-horizontal" role="form" method="post" action="./userBan.php">
					<h2 class="display-5">Tryb podniesionych uprawnień</h2>
					<p class="lead">Nazwa użytkownika: <input type="text" id="firstName" name = "username"></p>
					<p class="lead">Czas blokady: <input type="number" id="firstName" name = "time"></p>
					<p class="lead">Powód: <input type="text" id="firstName" name = "reason"></p>
					<button type="submit" class="btn btn-lg btn-secondary">Zablokuj użytkownika &raquo;</button>
					</form><br>
					<form class="form-horizontal" role="form" method="post" action="./markPassword.php">
					<p class="lead">Nazwa użytkownika: <input type="text" id="firstName" name = "username"></p>
					<button type="submit" class="btn btn-lg btn-secondary">Wymuś zmianę hasła &raquo;</button>
					</form>
					</div>';
		}
		?>
      </div><!-- /.container -->
    </main>
  </body>
</html>

