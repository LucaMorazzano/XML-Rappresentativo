<?php echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Inserisci</title>
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
			@media all and (max-width: 550px){ /da una disposizione in colonna mettendo in evidenza la il contenuto principale quando si rimpicciolisce la pagina/
				#header ul{
					display:flex;
					flex-direction:column;
				}
			}
			</style>
			
			<style type="text/css">
			#contenitore{
				background-color:beige;
				margin-left:auto;
				margin-right:auto;
				display:flex;       
				justify-content:space-around;
				align-items:center;
				border-style:solid;
				border-color:blue;
				font-size:25px;
				height:30%;
				width:60%;
			}
		</style>
</head>
<script type="text/javascript">
			function formvalidator(){
				var modello = document.forms['userform']['modello'].value; //assegnamo ad usr il valore di username
				var prezzo = document.forms['userform']['prezzo'].value;
				var processore = document.forms['userform']['processore'].value;
				var sg= document.forms['userform']['sg'].value;
				var ram= document.forms['userform']['ram'].value;
				var display= document.forms['userform']['display'].value;
				if(modello == null || prezzo == null ||  processore == null || sg == null || ram == null || display == null || modello == "" || prezzo == "" ||  processore == "" || sg == "" || ram == "" || display == ""){
					alert ("Dati mancanti");
					return false;
				}
				return true;
			}
		</script>

<body>
	<div id="header">
		<ul>
			<li><a href="Logout.php" title="Logout">Logout</a></li>
		</ul>
	</div>
	<script>generaId()</script>
	<h1 style="margin-top:5%;display:flex;justify-content:center;color:blue; font-family:Arial">INSERIRE NUOVO TELEFONO</h1>
		<div id="contenitore">
			<form name="userform" action="inserisci.php" method="post" onsubmit="return formvalidator()">
				<p>Modello: <input type="text" name="modello"></p>
				<p>Prezzo: <input type="text" name="prezzo"></p>
				<p>Processore: <input type="text" name="processore"></p>
				<p>Scheda Grafica: <input type="text" name="sg"></p>
				<p>Ram: <input type="text" name="ram"></p>
				<p>Display: <input type="text" name="display"></p>
				<p style="display:flex; justify-content:center"><input type="submit" name="inserisci" value="inserisci"></p>
			</form>
	<?php
		if(isset($_POST['inserisci'])){ //se abbiamo compilato la form
		$modello=$_POST['modello'];
		$prezzo=$_POST['prezzo'];
		$processore=$_POST['processore'];
		$sg=$_POST['sg'];
		$ram=$_POST['ram'];
		$display=$_POST['display'];
		require_once("connection.php");
		$xmlString = "";
			foreach ( file("telefoni.xml") as $node ) 
			$xmlString .= trim($node);
			
		//creiamo il nodo 
		$doc=new DomDocument();
		$doc->loadXML($xmlString);
		$root = $doc->documentElement;
		$elementi = $root->childNodes;
	    $primo = $root->firstChild;
		$nuovo = $doc->createElement("telefono");
		$id= rand(0,1000);
		$nuovoModello = $doc->createElement("modello",$modello);
		$nuovoPrezzo = $doc->createElement("prezzo",$prezzo);
		$nuovoProcessore = $doc->createElement("processore",$processore);
		$nuovoSG = $doc->createElement("schedagrafica",$sg);
		$nuovoRam = $doc->createElement("ram",$ram);
		$nuovoDisplay = $doc->createElement("display",$display);
		
				
		$nuovo->appendChild($nuovoModello);
		$nuovo->appendChild($nuovoPrezzo);
		$nuovo->appendChild($nuovoProcessore);
		$nuovo->appendChild($nuovoSG);
		$nuovo->appendChild($nuovoRam);
		$nuovo->appendChild($nuovoDisplay);
		
		//inseriamo il nodo nel documento
		$root->insertBefore($nuovo,$primo);
		//ora che è stato creato settiamo l'attributo id che avevamo precedentemente generato
		$first=$root->firstChild;
		$first->setAttribute("id",$id);
		//salviamo ora il file 
		$filename="telefoni.xml";
		if($doc->save($filename)){
			echo "<script>
					alert(\"Inserimento riuscito\")</script>";
				
		}else{
			echo "<script>
					alert(\"Inserimento fallito\")</script>";
		}
		
		}
	?>	
	</body>
	</html>
