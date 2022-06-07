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
			@media all and (max-width: 550px){ /*da una disposizione in colonna mettendo in evidenza la il contenuto principale quando si rimpicciolisce la pagina*/
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
				var usr = document.forms['userform']['username'].value; //assegnamo ad usr il valore di username
				var pwd= document.forms['userform']['password'].value;
				if(usr == null || pwd == null || usr == "" || pwd == ""){
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
	<h1 style="margin-top:5%;display:flex;justify-content:center;color:blue; font-family:Arial">INSERIRE NUOVO TELEFONO</h1>
		<div id="contenitore">
			<form name="userform" action="inserisci.php" method="post" onsubmit="return formvalidator()">
				<p>Modello: <input type="text" name="modello"></p>
				<p>Prezzo: <input type="text" name="prezzo"></p>
				<p style="display:flex; justify-content:center"><input type="submit" name="inserisci" value="inserisci"></p>
			</form>
	<?php
		if(isset($_POST['inserisci'])){ //se abbiamo compilato la form
		$modello=$_POST['modello'];
		$prezzo=$_POST['prezzo'];
		require_once("connection.php");
		$sql= "INSERT INTO Telefono(nome, prezzo) VALUES ('$modello', '$prezzo')";	
		$queryresult= mysqli_query($connection,$sql); /*mandiamo la query al dbs*/
			if($queryresult){ /*se la query da un risultato valido*/ 
					echo "<h2 style=\"color:green\">inserimento riuscito</h2>";
				}	
				else {
					echo "<h2 style=\"color:red\">errore inserimento</h2>";
				}
		}
	?>	
	</body>
	</html>
