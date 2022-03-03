<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Wiadomości</title>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap4.min.js"></script>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/contacts.css" rel="stylesheet">
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
            <a class="nav-link" href="./index.php">Strona główna </a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="./contacts.php">Wiadomości <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./profile.php">Profil użytkownika</a>
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
		<form class="user-search form-inline mt-2 mt-md-0" action="./napisz.php" method="post">
          <input class="form-control mr-sm-2" type="text" placeholder="Nazwa użytkownika..." aria-label="Search" name="odbiorca">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Napisz</button>
        </form>
      <?php require 'rozmowa.php'; require 'notLogged.php';?>
    </main>
</body>
</html>