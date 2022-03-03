<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Artykuł - Portal</title>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap4.min.js"></script>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/comments.css" rel="stylesheet">
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

    <main role="main" class="container">
		<?php
		require_once("config.php");
		session_start();
		$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
		require 'notLogged.php';
		if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
		}
		$result = $connect->query("select * from posty inner join tematy on tematy.idTemat=posty.idTemat where idPost='".$_GET['idPost']."'");
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
		<div class='gallerybox'>
		<?php
			if ($ress2->num_rows > 0) {
				while($obraz = $ress2->fetch_assoc()){?> 
		<div class='item'><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($obraz['zawartosc']);?>"></div><?php } }?>
		</div>
		<?php 
			if($row['idUzytkownik']==$_SESSION["idUzytkownik"] || $_SESSION["uprawnienia"]==1){
				echo '<a class="btn-del btn btn-danger" style="float:right;" href="./deletePost.php?idPost=';
				echo $row['idPost'];
				echo '" role="button">Usuń posta</a>';
			}
		?>
		<div class="sidetext"> Temat: <?php echo $row["nazwa"];?> </div>
		<div class="sidetext"><?php echo $row['data_utworzenia']; ?></div>
		</div>
		<?php
					}
				}
		clearStoredResults();
		$idPost = $_GET['idPost'];
		$result = $connect->query("select * from komentarze k inner join uzytkownicy u on u.idUzytkownik=k.idUzytkownik where k.idPost='$idPost'");
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){
				?>
				<div class="commentbox">
				<h6> <?php echo $row["nazwa"]; ?></h6>
				<div class="secondary"><?php echo $row["tresc"]; ?></div>
				<?php 
				if($row['idUzytkownik']==$_SESSION["idUzytkownik"] || $_SESSION["uprawnienia"]==1){
					echo '<a class="btn-del-kom btn btn-danger" style="float:right;" href="./deleteComment.php?idKomentarz=';
					echo $row['idKomentarz'];
					echo '" role="button">Usuń komentarz</a>';
				}
				?>
				<div class="sidetext2"><?php echo $row["data"]; ?></div>
				</div>
				<?php
			}
		}
	?>
	  <div class="sp commentbox">
		<h5>Dodaj nowy komentarz</h5>
        <div class="secondary">
		<form class="form-horizontal" role="form" action="./addComment.php" method="post">
		<div class="form-group">
			<textarea id="form107" name="skomentuj" class="md-textarea form-control" rows="4"></textarea>
			</div>
			<input type='hidden' value='<?php echo $idPost; ?>' name="idPost">
		<div class='submit-btn'><button type="submit" class="btn btn-info">Skomentuj </button></div>
        </form>
		</div>
      </div>
    </main>
	<?php
	clearStoredResults();
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
</body>
</html>