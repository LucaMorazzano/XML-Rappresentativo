# XML DOM-RAPPRESENTATIVO3

indirizzo repository GitHub: https://github.com/LucaMorazzano/XML-Rappresentativo.git
nome componenti gruppo: Luca Morazzano 	matricola 1920476
						Andra Fionda 	matricola 1847591

L'esercizio realizzato consiste in un mini sito web dinamico in grado di gestire la vendita di smartphone online.
Per la realizzazione sono stati adoperati elementi di php combinati con xml metodo DOM e qualche pezzo di codice in javascript per validare le form direttamente dal client.

#ISTRUZIONI PER L'USO

#1) INSTALL.PHP
Per garantire il corretto funzionamento dell'applicazione come primo passo è necessario avviare la pagina install.php.
Questa pagina consente, assieme al file connection.php,  l'installazione e il popolamento della base di dati e delle sue tabelle utilizzata sulla propria macchina.
Verranno visualizzate a schermo le query inviate al dbms e al dbs con i relativi risultati che avranno colore verde in caso di successo o colore rosso in caso di errori.
Nel dbs sono presenti due tabelle :
- Utente: che contiene tre utenti "base" con i relativi username, password e spesa totale. Quest'ultima sarà incrementata al variare delle operazioni che l'utente effettuerà sul sito.
- Admin : che contiene un solo utente admin, avente username "admin" e password "admin". Tale utente gode di privilegi che gli utenti base non hanno, infatti
è in grado, attraverso un apposito login, di modificare il file xml.

#2)LOGIN.PHP
Una volta installata la base di dati sarà possibile effettuare il login. La pagina offre due modalità di accesso: una da utente e una da admin.
Per ora ci concentreremo su quella da utente. E' possibile visualizzare le credenziali di accesso nel file install.php, con un occhio di riguardo
alle query relative al popolamento della tabella Utente. 
La pagina riceverà quindi i dati inseriti nella form, effettuerà un controllo di validità dei dati inseriti attraverso uno script in js e se tutto va bene
invia i dati della form al server. Una volta che il server ha ricevuto i dati (per farlo è stato utilizzato il metodo POST) verifica la presenza
dell'utente nel dbs effettuando un controllo attraverso delle query al dbs e l'estrazione di dati da esso. A questo punto se l'utente è presente nel dbs
verrà aperta una sessione relativa ad esso per mantenere memoria delle operazioni fino ad un suo logout. Contrariamente a quanto detto in precedenza
se l'utente non è presente nel dbs verrà mostrato un messaggio di errore (un allert attraverso js).
NB. Questa pagina è raggiungibile anche senza effettuare il login, però non sarà possibile interagire con il carrello. Infatti qual'ora si provasse
ad aggiungere un telefono al carrello saranno mostrati allert di errore (client-side).

#3)TELEFONI.PHP
Se il login è andato a buon fine verremo rimandati nella pagina telefoni.php. All'interno di essa troveremo un layout a due colonne e una sezione header che consente la navigazione nel sito.
Nella sezione di sinistra troviamo i telefoni presenti nel doc xml. Essi sono selezionabili, una volta selezionati compariranno nella sezione destra ovvero nel carrello, e sotto di essi verrà mostrato il costo totale della spesa.
Per realizzarla abbiamo effettuato un accesso al dbs ed estratto i dati dalla tabella Telefono. Una volta fatto questo è stata creata una variabile all'interno
della sessione relativa all'utente chiamata carrello. Se il carrello è pieno possiamo procedere al checkout, in caso contrario non sarà possibile fare alcun checkout.
E' possibile aggiungere prodotti al carrello ed è possibile svuotare completamente il carrello. Una volta effettuata la scelta dei prodotti da acquistare
sarà possibile, attraverso il bottone checkout effettuare il pagamento.

#3)CHECKOUT.PHP
Una volta premuto il bottone checkout, se l'array carrello (presente nella sessione relativa all'utente) contiene almeno un elemento saremo reindirizzati alla pagina checkout.
N.B: E' sempre possibile navigare nella pagina checkout però se il carrello è vuoto sarà stampato un messaggio relativo alla casistica con opzione per tornare al negozio.
Questa pagina non fa altro che mostrare in una tabella i prodotti selezionati, cioè nient'altro che il contenuto del carrello, con il costo da sostenere.
Saranno quindi mostrati due button, uno che fa effettuare il pagamento e rimanda alla pagina Arrivederci.php, e uno per tornare al negozio che rimanda alla pagina Telefoni.php.

#4)ARRIVEDERCI.PHP
E' possibile arrivare a questa pagina solo mediante il bottone "effettua pagamento" della pagina checkout.php. Questa pagina non fa altro che 
stampare un messaggio di arrivederci, mostrare ciò che è stato acquistato, aggiornare la spesa dell'utente nel dbs e mostrare la spesa totale dell'utente
sul sito aggiornata con l'ultima operazione.

#FUNZIONI ADMIN

#1)ADMIN.PHP
Come detto in precedenza dalla pagina Login.php è possibile essere reindirizzati alla pagina Admin.php. Tale pagina agisce nello stesso identico modo di login.php,
con l'unica differenza che cerca compatibilità tra dati ricevuti e dati presenti nel dbs nella tabella Admin piuttosto che nella tabella Utente.
Se i dati sono corretti e la form è valida saremo rimandati alla pagina Inserisci.php. In caso contrario saranno mostrati allert differenti in base all'errore.

#2)INSERISCI.PHP
Inserisci.php consente l'inserimento di nuovi modelli di smartphone nel documento xml.

#PAGINE AUSILIARIE

#1)CONNECTION.PHP
Connection.php non fa altro che effettuare la connessione con il dbs. Tale pagina verrà data come parametro alla funzione required_once in tutte le altre pagine del sito,
garantendo in questo modo un corretto funzionamento di esso.

#2)LOGOUT.PHP
Logout.php permette il logout dell'utente eliminando la sessione ad esso relativa dal server attraverso la funzione "session_destroy()".
