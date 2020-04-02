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

define( 'API_URI', 'http://wsia.imobiliare.ro/index.php' ); // pt. nuSOAP e fara '?wsdl' in coada
define( 'API_USER', 'X36V' );
define( 'API_KEY', '89cn23489fn32r' );

$id2random = (int)rand( 5000, 500000 );
$ofertaxml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oferta tip="apartament" versiune="2">
<id2>'. $id2random . '</id2>
<idstr></idstr>
<judet>10</judet>
<localitate>13822</localitate>
<zona>750</zona>

<tiplocuinta>110</tiplocuinta>

<devanzare>1</devanzare>
<dataadaugare>1</dataadaugare>
<datamodificare>1</datamodificare>
<destinatie>466</destinatie>

<idnum></idnum>
<agent>51</agent>
<tipimobil>121</tipimobil>
<ansamblurezidential>0</ansamblurezidential>
<tipcompartimentare>26</tipcompartimentare>
<demisol>0</demisol><dotari>20 142 145</dotari>
<finisaje>55 56</finisaje>
<deinchiriat>0</deinchiriat>
<mansarda>0</mansarda>
<nrbucatarii>1</nrbucatarii>
<nrnivele>4</nrnivele>
<pretnegociabil>1</pretnegociabil>
<pretvanzare>125000</pretvanzare>
<monedavanzare>172</monedavanzare>
<patratecaroiaj>172</patratecaroiaj>
<etaj>47</etaj>   
<nrcamere>1</nrcamere>   
<tara>1048</tara>
<pretinchiriere>464000</pretinchiriere>
<monedainchiriere>172</monedainchiriere>
<vicii>
	<lang id="1048">Zm9hcnRlIHVyYXQ=</lang>
</vicii>
<pretinchiriereunitar>464000</pretinchiriereunitar>
<monedainchiriereunitar>172</monedainchiriereunitar>
<comisioncumparator>
	<lang id="1048">Zm9hcnRlIHVyYXQ=</lang>
</comisioncumparator>
<structurarezistenta>138</structurarezistenta>
<subsol>0</subsol>
<regimhotelier>0</regimhotelier>
<imagini nrimagini="1">
    <imagine dummy="False" modificata="1228840157" latime="38" inaltime="38" pozitie="1">
      <descriere>' . base64_encode( 'O descriere optionala a fotografiei' ) . '</descriere>
      <blob>' . base64_encode( file_get_contents( dirname( __FILE__ ) . '/IMG_1010.JPG' ) ) . '</blob>
      <titlu>' . base64_encode( 'Un titlu sugestiv dar optional...' ) . '</titlu>
    </imagine>
  </imagini>
<pretfaratva>0</pretfaratva>
<utilitati>21 22 28 32 34 44 91</utilitati>

</oferta>'; 

require_once( dirname( __FILE__ ) . '/nusoap/nusoap.php' );
//test
$s = new soapclient( API_URI ); 
$s->timeout = 3600;
$s->response_timeout = 3600;

// login
try {
	$result = $s->call( 
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

$extra = explode( '#', $result[ 'extra' ] );
// id-ul de sesiune va fi folosit ulterior la orice request
$session_id = $extra[ 1 ];

echo '<pre>LOGIN: ' . print_r( $result, true ) . '</pre>SessionID = `' . $session_id . '`';

// publica oferta - adaugare
try {
	$result = $s->call( 
		'publica_oferta', 
		array( 
			'publica_oferta' => array( 
				'id_str'		=> '0:' . $id2random, // 0 = apartamente, 1 = case/vile etc
				'sid' 			=> $session_id, 
				'operatie'		=> 'ADD', // ADAUGARE
				'ofertaxml' 	=> $ofertaxml,
			) 	
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Publicare oferta: ' . $e->getMessage() );
}

echo '<pre>ADAUGARE OFERTA: ' . print_r( $result, true ) . '</pre>';


// publica oferta - modificare
try {
	$result = $s->call( 
		'publica_oferta', 
		array( 
			'publica_oferta' => array( 
				'id_str'		=> '0:' . $id2random,  // 0 = apartamente, 1 = case/vile etc
				'sid' 			=> $session_id, 
				'operatie'		=> 'MOD', // MODIFICARE
				'ofertaxml' 	=> $ofertaxml,
			) 	
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Publicare oferta: ' . $e->getMessage() );
}

echo '<pre>MODIFICARE OFERTA: ' . print_r( $result, true ) . '</pre>';


// publica oferta - stergere
try {
	$result = $s->call( 
		'publica_oferta', 
		array( 
			'publica_oferta' => array( 
				'id_str'		=> '0:' . $id2random,
				'sid' 			=> $session_id, 
				'operatie'		=> 'DEL', // STERGERE
				'ofertaxml' 	=> '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
									<oferta tip="apartament" versiune="2">
									<id2>'. $id2random . '</id2>
</xml>', // $ofertaxml,
			) 	
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Publicare oferta: ' . $e->getMessage() );
}

echo '<pre>STERGERE OFERTA: ' . print_r( $result, true ) . '</pre>';


// logout
try {
	$result = $s->call( 
		'logout', 
		array( 
			'logout' => array( 
				'sid' 		=> $session_id, 
				'id'		=> '',
				'jurnal'	=> '',
			) 
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Logout: ' . $e->getMessage() );
}

echo '<pre>LOGOUT: ' . print_r( $result, true ) . '</pre>';

/** executia arata cam asa:

LOGIN: stdClass Object
(
    [cod] => 0
    [mesaj] => OK LOGIN
    [extra] => 100#7bd92a64c504ed31364ee69985ed7ea469b785092dbdc3eba057db9d823a272e#0
)

PUBLICARE OFERTA: stdClass Object
(
    [cod] => 0
    [mesaj] => OK - ADD OFERTA X36V1000G
    [extra] => 
)

LOGOUT: stdClass Object
(
    [cod] => 0
    [mesaj] => OK GOODBYE
    [extra] => 
)

Oferta adaugata o vom gasi in Adminonline, cautand ID-ul ei (in acest exemplu, X36V1000G)

*/
?>