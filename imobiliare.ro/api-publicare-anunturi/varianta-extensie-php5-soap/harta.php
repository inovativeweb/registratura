<?php  require_once (__DIR__.'/../../../config.php');


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

//echo '<pre>LOGIN: ' . print_r( $result, true ) . '</pre>';


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

<iframe id="hartaiframe" scrolling="no" height="500" frameborder="0" width="800" src="" allowtransparency="true" hspace="0" vspace="0" marginheight="0" marginwidth="0"></iframe>

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
	var iframe = document.getElementById('hartaiframe');
	iframe.src = 'https://harta.imobiliare.ro/layout/api-publicare/sid/<?php echo $session_id;?>/loc/' + obj.options[obj.selectedIndex].value + '/categorie/1';
	window.location.hash = '';
}

initHarta();

</script>

<br /><br />
<div class="row">
	<div class="col-xs-3">
		<br>
<input class="btn" type="button" id="preluare" value="Preluare valori" onclick="preluareValori();" />
</div><div class="col-xs-3">

<label>Punct:</label>
<input type="text" name="punct" class=" field form-control" id="punct" value="" size="50" />
	</div><div class="col-xs-3">
<label>Caroiaj:</label>
<input  type="text" class=" field form-control" name="caroiaj" id="caroiaj" value="" size="50" />
	</div><div class="col-xs-3">
		<br>
<input class="field ui green button" type="button" onclick="save_caroiaj()" value="Salveaza">
</div>
	</div>
<script>
	function save_caroiaj() {
		var valc = $('#caroiaj').val();
		if(!valc.length){
			alert('Trebuie preluat un Caroiaj pentru a salva!');
			return 0;
		}
		$.post("",{"save_caroiaj":valc,"company":<?=$_GET['company']?>},function (r) {
				location.reload();
		})
	}

</script>