<?php
require_once("config.php");
session_start();
require 'notLogged.php';
$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Utwórz nowy post</title>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap4.min.js"></script>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/addPost.css" rel="stylesheet">
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
            <a class="nav-link" href="">Strona główna <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Wiadomości</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="">Panel użytkownika</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="">Wyloguj się</a>
          </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Wpisz tytuł lub temat..." aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Szukaj</button>
        </form>
      </div>
    </nav>

    <main role="main" class="container">
      <div class="jumbotron">
			<h2>Utwórz nowy post</h2>
			<form class="form-horizontal" action="./addPost.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				<label for="title">Tytuł</label>
				<div class="tinput">
					<input type="text" id="title" name='title' class="form-control" autofocus>
				</div>
				</div>
				<div class="form-group">
					<label for="form107">Treść posta (opcjonalnie)</label>
					<textarea id="form107" class="md-textarea form-control" name = "content" rows="10"></textarea>
				</div>
				<div class="smx form-group">
				<label for="topic">Temat</label>
				<div class="t2input">
				<select name="topic" id="topic">
				<?php
				$result = $connect->query("select idTemat, nazwa from tematy");
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()){ 
					echo "<option value='".$row['idTemat']."'>".$row['nazwa']."</option>";
					}
				}
				?>
				</select>
				</div>
				</div>
				<div class="fileAdd form-group">
				<label for="ImgUpload">Dodaj zdjęcia</label>
				<input type="file" name='image[]' class="form-control-file" id="ImgUpload" accept=".jpg,.jpeg,.png"  multiple>
				</div>
				<div class='submit-btn'><button type="submit" name="submitButton" value="Upload" class="btn btn-primary">Utwórz</button></div>
        </form>
      </div>
    </main>
</body>
</html>