<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Shop</title>
		<style type= "text/css">
		/*utilizziamo un layout holy grail responsive avente una zona header dedicata al menu con i servizi offerti
		una zona main suddivisa in due sezioni a destra è presente ciò che abbiamo aggiunto al carrello con il totale speso.
		A sinistra invece è presente una lista di telefoni da aggiungere al carrello*/
		body{
			font-family:sans-serif;
			display:flex;
			flex-direction:column;		/*impostiamo il body in modo da avere un layout a colonne*/
			text-align:center;
			font-size:20px;
			background-color:beige;
		}
		.main{
			display:flex;
			padding:1%;
			height:85%; 
		}
		#header{
			border-style:solid;
			border-color:black;
			background-color:blue;
			color:white;
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
		/*SEZIONE RIGHT*/
		#right{
			padding:5%;
			flex: 1 1 100px;
		}
		#right table{
			margin-left:auto;
			margin-right:auto;
			font-size:25px;
		}
		#right img{
			height:200px;
			width:200px;
		}
		.desc{
			background-color:blue;
			color:white;
		}
		/*SEZIONE LEFT*/
		#left{
			padding:5%;
			flex: 1 1 100px;
			color:black;
		}
		
		@media all and (max-width: 550px){ /*da una disposizione in colonna mettendo in evidenza la il contenuto principale quando si rimpicciolisce la pagina*/
		.main{
			flex-direction:column;
			}
		#header ul{
			display:flex;
			flex-direction:column;
			}
		}
		</style>
	</head>
	
	<body>
	<div id="header">
		<ul>
			<li><a href="telefoni.php" title="Shop">Shop</a></li>
			<li><a href="info.php" title="Scheda tecnica">Informazioni dispositivi</a></li>
			<li><a href="checkout.php" title="Checkout">Checkout</a></li>
			<li><a href="Logout.php" title="Logout">Logout</a></li>
		</ul>
	</div>
	<div class="main">
	<div id="left">
		<?php
			session_start(); /*avviamo la sessione (va avviata per ogni pagina)*/
			require_once("connection.php");
			$autocall=$_SERVER['PHP_SELF'];
			$xmlString = "";
			foreach ( file("telefoni.xml") as $node ) {
			$xmlString .= trim($node);
			}
				/*Adesso carichiamo i telefoni disponibili dal file xml attraverso metodo DOM*/
				$doc=new DomDocument();
				$doc->loadXML($xmlString);
				$root = $doc->documentElement;
				$elementi = $root->childNodes;
				echo"<h3 style>Scegliere quale scheda tecnica visualizzare </h3><hr>";
				echo"<form action = \"$autocall\" method=\"post\">";/*form con auto chiamata*/
				for($i=0; $i<sizeof($elementi); $i++){
					$telefono= $elementi->item($i);
					$idvalue=$telefono->getAttribute('id'); //otteniamo attributo con metodo getAttribute
					///////////SCORRIAMO L'ALBERO ED ESTRAIAMO ELEMENTI DI INTERESSE////////////
					$modello= $telefono->firstChild;
					$modellovalue=$modello->textContent;
					$prezzo= $modello->nextSibling; /////nextSibling ci porta al prossimo elemento
					$prezzovalue= $prezzo->textContent;
					echo"<p style=\"color:blue;\"><input type=\"radio\"name=\"id\" value=";echo $idvalue;echo ">
					$modellovalue ($prezzovalue &euro;) </p>";
				}
				echo"<input type=\"submit\" name=\"visualizza\" value=\"visualizza\">";/*bottone action del form*/
				echo"</form>";
		?>
		</div>
		<div id="right">
			<h3>SCHEDA TECNICA</h3><hr>
			<?php 
			$modellovalue="";
			$prezzovalue="";
			$processorevalue="";
			$schedagraficavalue="";
			$ramvalue="";
			$displayvalue="";
			$immaginevalue="";
			if(isset($_POST['visualizza'])){
				if(isset($_POST['id'])){
				$id=$_POST['id']; //id del telefono scelto
				for($i=0; $i<sizeof($elementi);$i++){
					if($elementi->item($i)->getAttribute('id') == $id){ //cerchiamo da id 
						$modello=$elementi->item($i)->firstChild;
						$modellovalue=$modello->textContent;
						$prezzo=$modello->nextSibling;
						$prezzovalue=(int)$prezzo->textContent; //casting necessario
						$processore=$prezzo->nextSibling;
						$processorevalue=$processore->textContent;
						$schedagrafica=$processore->nextSibling;
						$schedagraficavalue=$schedagrafica->textContent;
						$ram=$schedagrafica->nextSibling;
						$ramvalue=$ram->textContent;
						$display=$ram->nextSibling;
						$displayvalue=$display->textContent;
						$immagine=$display->nextSibling;
						$immaginevalue=$immagine->textContent;
						$i=sizeof($elementi);
					}
				}
					echo "	<table border=\"1px\" cellpadding=\"5px\"><tbody>
							<tr><td class=\"desc\">Nome</td><td>$modellovalue</td></tr> 
							<tr><td class=\"desc\">Prezzo</td><td>$prezzovalue&euro;</td></tr>
							<tr><td class=\"desc\">Processore</td><td>$processorevalue</td></tr>
							<tr><td class=\"desc\">GPU</td><td>$schedagraficavalue</td></tr>
							<tr><td class=\"desc\">Ram</td><td>$ramvalue</td></tr>
							<tr><td class=\"desc\">Display</td><td>$displayvalue</td></tr> 
							<tr><td colspan=\"2\"><img src=\"immagini/$immaginevalue\" alt=\"Immagine non disponibile per questo prodotto\"/></td></tr></tbody></table>";			
				}
			}
			$connection->close();
			?>
		</div>
		</div>
	</body>

</html>