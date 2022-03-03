<?php
		require_once("config.php");
		session_start();
		$connect = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

if($connect == false){
            exit("ERROR: Could not connect. ".mysqli_connect_error());
}
		$sql = "select Nadawca, tresc, data, czy_odczytana, Nadawca, Odbiorca from wiadomosci where Odbiorca = '".$_SESSION['idUzytkownik']."' and data in (select max(data) from wiadomosci where Odbiorca = '".$_SESSION['idUzytkownik']."' group by Nadawca) order by data desc";
		$result = $connect->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){
				$sql2 = "select distinct nazwa from uzytkownicy where idUzytkownik = '".$row['Nadawca']."'";
				$result2 = $connect->query($sql2);
				$name = $result2->fetch_assoc();
				?>
				<div class="jumbotron">
					<a class="btn btn-lg btn-success" href="messages.php?uid=<?php echo $row['Nadawca']; ?>" role="button"> Rozmowa  </a>
					<div class='username'><h3><?php echo $name["nazwa"]; ?> </h3></div>
					<p class="lead"><?php echo $row["tresc"]; ?> </p>
				<div class="sidetext"><?php echo $row["data"]; ?> </div>
				</div>
				<?php
			}
			clearStoredResults();
		}
		else{
			?>
			<div class="jumbotron">
				<div class='username'><h3>Brak wiadomosci </h3></div>
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