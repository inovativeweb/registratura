<?php
/**
 * Cod PHP functional pentru demonstrarea functionalitatii API imobiliare.ro
 * ------------------------------------------------------------------
 * 
 * ACEST COD ESTE PUS LA DISPOZITIE CU TITLU DEMONSTRATIV, SI NU ESTE
 * SUB NICI O FORMA INDICAT SA FIE UTILIZAT IN PRODUCTIE.
 * 
 * REALMEDIA NETWORK NU ISI ASUMA NICI O VINA PENTRU EVENTUALELE PAGUBE
 * PRODUSE DE ACEST SCRIPT.
 *
 */

define( 'API_URI', 'http://wsia.imobiliare.ro/index.php?wsdl' );
define( 'API_USER', 'X36V' );
define( 'API_KEY', '89cn23489fn32r' );


$s = new SoapClient( API_URI ); 

// login
try {
	$result = $s->__soapCall( 
		'login', 
		array( 
			'login' => array( 
				'id' 	=> API_USER, 
				'hid' 	=> API_KEY,
				'server' => '',
				'agent'	 	=> '',
				'parola'	=> '',
			) 
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Login: ' . $e->getMessage() );
}

$extra = explode( '#', $result->extra );
// id-ul de sesiune va fi folosit ulterior la orice request
$session_id = $extra[ 1 ];

echo '<pre>LOGIN: ' . print_r( $result, true ) . '</pre>';

?>

<label>Initializare harta pe oras:</label>

<select id="oras" onchange="initHarta()">
	<option value="730">Arad</option>
	<option value="3319">Brasov</option>
	<option value="13822" selected="selected">Bucuresti</option>
	<option value="4926">Constanta</option>
	<option value="">Cluj-Napoca</option>
	<option value="7203">Deva</option>
	<option value="7871">Iasi</option>		
	<option value="7263">Hunedoara</option>
	<option value="2373">Oradea</option>	
	<option value="12224">Timisoara</option>
</select>
<br /><br />

<iframe id="harta" scrolling="no" height="500" frameborder="0" width="800" src="" allowtransparency="true" hspace="0" vspace="0" marginheight="0" marginwidth="0"></iframe>

<script type="text/javascript">
function preluareValori() {	
	var sHash = window.location.hash;
	if (sHash != '') {
		sHash = sHash.substr(1);
		var aCampuri = sHash.split(';');
		document.getElementById('punct').value = aCampuri[0];
		document.getElementById('caroiaj').value = aCampuri[1];
	}
}

function initHarta() {
	obj = document.getElementById('oras');
	var iframe = document.getElementById('harta');	
	iframe.src = 'http://harta.imobiliare.ro/layout/api-publicare/sid/<?php echo $session_id;?>/loc/' + obj.options[obj.selectedIndex].value + '/categorie/1';
	window.location.hash = '';
}

initHarta();

</script>

<br /><br />
<input type="button" id="preluare" value="Preluare valori" onclick="preluareValori();" />
<br /><br />
<label>Punct:</label>
<input type="text" name="punct" id="punct" value="" size="50" />
<br /><br />
<label>Caroiaj:</label>
<input type="text" name="caroiaj" id="caroiaj" value="" size="50" />

