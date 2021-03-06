<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Checkout</title>
		<style type="text/css">
			body{
				background-color:beige;
				text-align:center;
				font-family:Arial;
			}
			#header{
				background-color:blue;
				color:white;
				border-style:solid;
				border-color:black;
				display:flex;
				justify-content:center;
				font-family:Arial;
				font-size:30px;
			}
			#header ul{
				list-style-type:none;
			}
			#header a{
				text-decoration:none;
				color:white;
			}
			#header li{
				padding-right:20px;
				padding-left:20px;
				display:inline-block;
				opacity:90%;
			}
			#header li:hover{
				opacity:100%;
			}
			#main{
				display:flex;
				justify-content:center;
				padding:2%;
				font-size:30px;
			}
			.borderrow{
				background-color:blue;
				color:white;
			}
			@media all and (max-width: 550px){ /*da una disposizione in colonna mettendo in evidenza la il contenuto principale quando si rimpicciolisce la pagina*/
				#header ul{
					display:flex;
					flex-direction:column;
				}
			}
		</style>
	</head>
	<!-- nella pagina di checkout dovremo come prima cosa richiamare l'array di sessione contenente le informazioni sui prodotti selezionati
	successivamente richiamare l'array relativo alla spesa totale ed aggiornare nel dbs la spesa dell'utente-->
	<body>
	<div id="header">
		<ul>
			<li><a href="telefoni.php" title="Shop">Shop</a></li>
			<li><a href="info.php" title="Scheda tecnica">Informazioni dispositivi</a></li>
			<li><a href="checkout.php" title="Checkout">Checkout</a></li>
			<li><a href="Logout.php" title="Logout">Logout</a></li>
		</ul>
	</div>
	<div id="main">
		<?php
			/*come prima cosa avviamo la sessione*/
			session_start();
			require_once("connection.php");
			/*dopo stampiamo a schermo le info contenute negli array di sessione relativi al carrello*/
			if(isset($_SESSION['carrello']) && isset($_SESSION['spesa_attuale'])){
				///////////////SE IL CARRELLO E'PIENO
				if($_SESSION['carrello']){
				echo "<table border=\"1\">
						<tr class=\"borderrow\">
						<td><h3>Carrello</h3></td>
						</tr>";
				foreach($_SESSION['carrello'] as $item){ /*METODO STAMPA ELEMENTI ARRAY*/
					echo "<tr>
						<td>$item</td>
						</tr>";
				}
				echo "<tr class=\"borderrow\">
						<td> TOTALE ";echo $_SESSION['spesa_attuale'];echo"&euro; </td></tr></table>";
				echo "</div>"; /*fine div main content*/
				echo "<form action=\"Arrivederci.php\" method=\"post\"><p><input type=\"submit\" name=\"paga\" value=\"Effettua pagamento\"></p></form>";/*form per pagare e terminare*/
				}
			else{ /*se il carrello ?? vuoto stampiamo un annuncio*/
				echo "<h1 style=\"color:red\"> CARRELLO VUOTO <hr> </h1></div>";
				echo "<form action=\"telefoni.php\" method=\"post\">
					<p><input type=\"submit\" name=\"return\" value=\"Torna al negozio\"></p></form>"; /*form per dare l'opportunit?? all'utente di tornare in ogni caso al negozio per fare modifiche*/
			}
			}
			///////////SE NON PROVENIAMO DA UNA FORM
			else {
				echo "<h1 style=\"color:red\"> LOGIN NECESSARIO <hr> </h1></div>";
			}
			
		?>
	</body>


</html>