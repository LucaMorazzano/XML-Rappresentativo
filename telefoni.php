<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Shop</title>
		<style type= "text/css">
		/*utilizziamo un layout holy grail responsive avente una zona header dedicata al menu con i servizi offerti
		una zona main suddivisa in due sezioni a destra ? presente ci? che abbiamo aggiunto al carrello con il totale speso.
		A sinistra invece ? presente una lista di telefoni da aggiungere al carrello*/
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
			/*OSSERVAZIONE:
			se effettuiamo questo passaggio il web server acceder? all'area di memoria contenete proprio le informazioni dell'utente
			che ha effettuato una richiesta mandando al server anche il cookie di sessione, in questo modo il server ricorder? i dati
			e potr? aggiornarli
			session_start();
			echo $_SESSION['username'];*/
			session_start(); /*avviamo la sessione (va avviata per ogni pagina)*/
			require_once("connection.php");
			$autocall=$_SERVER['PHP_SELF'];
			///////////////DOM SECTION//////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////
			/////INIZIALIZZIAMO LA STRINGA CONTENENTE IL FILE XML PRIVO DI ELEMENTI FITTIZI//////////
			$xmlString = "";
			foreach ( file("telefoni.xml") as $node ) {
			$xmlString .= trim($node);
			}
				/*Adesso carichiamo i telefoni disponibili dal file xml attraverso metodo DOM*/
				$doc=new DomDocument();
				$doc->loadXML($xmlString);
				$root = $doc->documentElement;
				$elementi = $root->childNodes;
				echo"<h3 style>MODELLI DISPONIBILI</h3><hr>";
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
					$modellovalue ($prezzovalue &euro;)</p>";
				}
				echo"<input type=\"submit\"value=\"aggiungi al carrello\">";/*bottone action del form*/
				echo"</form>";
		?>
		</div>
		<div id="right">
			<h3>CARRELLO</h3><hr>
			<?php 
			if(isset($_POST['svuota'])){ /*SE L'UTENTE DECIDE DI SVUOTARE IL CARRELLO ALLORA DEALLOCHIAMO LE VARIABILI DI SESSIONE E RIALLOCHIAMOLE*//*RICORDIAMO SEMPRE ISSET PER VARIABILI SESSIONE O POST*/
				unset($_SESSION['spesa_attuale']);
				unset($_SESSION['carrello']);
				$_SESSION['spesa_attuale']=0; /*queste variabili session stanno nel server*/
				$_SESSION['carrello']=array();
			}
			
			if(isset($_SESSION['username']) && isset($_SESSION['password'])){ //SE abbiamo selezionato qualcosa e se siamo loggati
				if(isset($_POST['id'])){
				$id=$_POST['id']; //id del telefono scelto
				//cerchiamo il telefono selezionato dall'array contenente tutti i telefoni
				for($i=0; $i<sizeof($elementi);$i++){
					if($elementi->item($i)->getAttribute('id') == $id){ //cerchiamo da id 
						$modello=$elementi->item($i)->firstChild;
						$modellovalue=$modello->textContent;
						$_SESSION['modello']=$modellovalue;
						array_push($_SESSION['carrello'],$_SESSION['modello']); //salviamo il modello nella sessione in un apposita variabile array
						$prezzo=$modello->nextSibling;
						$prezzovalue=(int)$prezzo->textContent; //casting necessario
						$_SESSION['spesa_attuale']+=$prezzovalue; //aggiorniamo spesa corrente
						$i=sizeof($elementi);
					}
				}
				
				}
			}
			else{
				echo "<script> 
						alert(\"Azione non permessa effettuare login\");
						</script>";
			}
			if(isset($_SESSION['carrello'])&& isset($_SESSION['spesa_attuale'])){//se il carrello non ? vuoto 
							foreach($_SESSION['carrello'] as $item){ /*facciamo un ciclo foreach per stampare il contenuto*/
								echo"<p>";	
								echo $item; /*stampiamo tutti i modelli che sono stati aggiunti al carrello*/
								echo "</p>";
							}
							echo "<hr><strong>Totale spesa: ";echo $_SESSION['spesa_attuale']; echo"&euro;</strong>";
						}
			/*form per svuotare il carrello*/
			echo "<form action \"$autocall\" method=\"POST\">
			<p><input type=\"submit\" name=\"svuota\" value=\"Svuota\"></p>
			</form>"; //opzione per svuotare il carrello 
			
			/*form per andare al checkout*/
			echo "<form action =\"checkout.php\" method=\"POST\">
			<p><input type=\"submit\" name=\"checkout\" value=\"Checkout\"></p>
			</form>"; //opzione per effettuare checkout
			
			$connection->close();
			?>
		</div>
		</div>
	</body>

</html>