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
	</head>
	<body>
	        <h1 style="margin-top:5%;display:flex;justify-content:center;color:blue; font-family:Arial">EFFETTUARE LOGIN</h1>
		    <div id="contenitore">
			<form name="userform" action="admin.php" method="post" onsubmit="return formvalidator()">
				<p>Username: <input type="text" name="username"></p>
				<p>Password: <input type="password" name="password"></p>
				<p style="display:flex; justify-content:center"><input type="submit" name="login" value="Login"></p>
			</form>
			</div>
			<?php
				require_once("connection.php");
				if(isset($_POST['username']) && isset($_POST['password'])){
				$username=$_POST['username'];
				$password=$_POST['password'];
				$sql= "SELECT * FROM Admin WHERE username='$username' AND password='$password'"; /*realizziamo la query che controlla se i dati ricevuti via POST sono nel dbs*/
				$queryresult= mysqli_query($connection,$sql); /*mandiamo la query al dbs*/
				if($queryresult){ /*se la query da un risultato valido allora verifichiamo che l'utente esista*/
					$row = mysqli_fetch_array($queryresult); /*salviamo l'utente e le sue informazioni in un array*/
					if($row){
						header('Location: inserisci.php');
					}
					else{
					echo "<script> alert(\"Credenziali non corrette\") </script>";
				}
				}
				}
			?>
	</body>
</html>