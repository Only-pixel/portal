<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Strona główna</title>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap4.min.js"></script>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
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
            <a class="nav-link" href="./profile.php">Panel użytkownika</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="./destroy.php">Wyloguj się</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0" action="./szukaj.php" method="post">
          <input class="form-control mr-sm-2" type="text" name = "key" placeholder="Wpisz tytuł lub temat..." aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Szukaj</button>
        </form>
      </div>
    </nav>

    <main role="main" class="container">
	  <div class='newPost'><a class="btn-np btn-lg btn-primary" href="addPostForm.php" role="button">Nowy post...</a></div>
	  <?php
		require_once("config.php");
		session_start();
		require 'notLogged.php';
		$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

		if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
		}
		if(!isset($_SESSION["key"])){ //normalne zapytanie bez parametru seesion
			$result = $connect->query("select * from posty order by data_utworzenia desc");
		}
		else{
			$result = $connect->query("select * from posty inner join tematy on tematy.idTemat=posty.idTemat where posty.tytul LIKE '%".$_SESSION['key']."%' or tematy.nazwa LIKE '%".$_SESSION['key']."%' order by data_utworzenia desc");
			unset($_SESSION['key']);
		}
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()){ 
					?>
						<div class="jumbotron">
						<h2><?php echo $row['tytul'] ?></h2>
						<p class="lead"> 
						<?php 
						$ress = $connect->query("select tresc from trescpostow where idPost = '".$row['idPost']."'");if ($ress->num_rows > 0) { $tresc = $ress->fetch_assoc(); 
						if(!is_null($tresc['tresc'])) {echo $tresc['tresc']; }}
						$ress2 = $connect->query("select zawartosc from galeria where idPost = '".$row['idPost']."'");
						 ?>
						</p>
						<div class="sidetext"><?php $res3 = $connect->query("select count(idKomentarz) as kom from komentarze where idPost = '".$row['idPost']."'"); 
						$tresc = $res3->fetch_assoc(); echo $tresc['kom']." komentarzy"; ?>&bull; <?php echo $row['data_utworzenia']; ?>
						</div>
						<a class="btn-lg btn-primary" href="./comments.php?idPost=<?php echo $row['idPost']; ?>" role="button">Komentarze »</a>
						</div>
					<?php
					}
				}
				else{
					?>
						<div class="jumbotron">
						<h2>Brak postów</h2>
						</div>
					<?php
				}
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
	  
    </main>
</body>
</html>