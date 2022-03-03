<!DOCTYPE html>
<head>
	<meta charset="utf-8">
    <title>Wystąpił błąd</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="js/jquery-1.11.1.min.js"></script>	
	<script src="js/bootstrap.min.js"></script>
	<link rel='stylesheet' href='css/error.css'>
</head>
<body>
	<div class='box'>
		<h2 class="text-center">Wystąpił błąd</h2>
		<p>
		<?php
			session_start();
			echo $_SESSION["errorInfo"];
		?>
		</p>
		<a href="<?php echo $_SESSION["href"]; ?>" class="btn btn-danger">Wróć</a>
	</div>
</body>