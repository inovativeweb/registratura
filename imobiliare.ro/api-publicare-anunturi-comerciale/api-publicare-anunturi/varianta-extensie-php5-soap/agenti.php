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

define( 'API_URI', 'http://test-wsia.dm.rmn.ro/index.php?wsdl' );
define( 'API_USER', 'X3AJ' );
define( 'API_KEY', '928jf245h890' );

$s = new SoapClient( API_URI ); 

$idrandomagent = 751; // (int)rand(10,100);
$agentxml = '<agent>
  <email>radu.muresanu@imobiliare.ro</email>
  <fax>021123456789</fax>
  <functie>Consilier rezidential apartamente</functie>
  <id>751</id>
  <mobil>0744123456</mobil>
  <nume>Bogdan Muresanuuu</nume>
  <password>e2fc714c4727ee9395f324cd2e7f331f</password>
  <poza>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</poza>
  <telefon>021123456789</telefon>
  <username>testdiana</username>
  <web>www.imobiliare.ro</web>
</agent>';


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

// importare lista agenti
try {
	$result = $s->__soapCall( 
		'import_lista_agenti', 
		array( 
			'import_lista_agenti' => array( 
				'sid' 			=> $session_id, 
			) 	
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Publicare oferta: ' . $e->getMessage() );
}

echo '<pre>LISTA AGENTI: ' . print_r( $result, true ) . '</pre>';



// importare agent
try {
	$result = $s->__soapCall( 
		'import_agent', 
		array( 
			'import_agent' => array( 
				'sid' 			=> $session_id,
				'id'			=> 105,
			) 	
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Publicare oferta: ' . $e->getMessage() );
}

echo '<pre>INFORMATII AGENT ID #105: ' . print_r( $result, true ) . '</pre>';


// publica agent
try {
	$result = $s->__soapCall( 
		'publica_agent', 
		array( 
			'publica_agent' => array( 
				'id'		=> $idrandomagent,
				'sid' 			=> $session_id, 
				'operatie'		=> 'MOD',
				'agentxml' 	=> $agentxml,
			) 	
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Publicare agent: ' . $e->getMessage() );
}

echo '<pre>PUBLICARE AGENT: ' . print_r( $result, true ) . '</pre>';


// logout
try {
	$result = $s->__soapCall( 
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


/**
EXECUTIA ACESTUI SCRIPT ARATA IN FELUL URMATOR:

LOGIN: stdClass Object
(
    [cod] => 0
    [mesaj] => OK LOGIN
    [extra] => 100#78cc4320c63ca3a408690b59d1e91433754bfd10e93f4378ccafaccdaf0db076#0
)
LISTA AGENTI: stdClass Object
(
    [cod] => 0
    [mesaj] => OK LISTA AGENTI
    [extra] => 90 105 111 84 63 66 1 2 7 22 85 86 88 89 93 94 95 97 100 101 102 103 104 106 107 108 109 114 116 120 121 122 113 444 657 306 130 3 5 1861 3271
)
INFORMATII AGENT ID #105: stdClass Object
(
    [cod] => 0
    [mesaj] => OK LISTA AGENTI
    [extra] => 
	105
	Alex Alexandrescu
	0740.123.456
	alex.alexandrescu@agentieimobiliara.ro
	0
	0
	Alex_Alexandrescu
	vad493fg443
	1

)
LOGOUT: stdClass Object
(
    [cod] => 0
    [mesaj] => OK GOODBYE
    [extra] => 
)


*/

?>