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
/*
define( 'API_URI', 'http://test-wsia.dm.rmn.ro/index.php?wsdl' );
define( 'API_USER', 'X3AJ' );
define( 'API_KEY', '928jf245h890' );
*/



$s = new SoapClient( API_URI );
//atasamente


$idrandomagent = $user['id']; // (int)rand(10,100);
$agentxml = '<agent>
  <email>'.$user['mail'].'</email>
  <fax></fax>
  <functie>'.$user['job_title'].'</functie>
  <id>'.$user['id'].'</id>
  <mobil>'.$user['tel'].'</mobil>
  <nume>'.$user['full_name'].'</nume>
  <password></password>
  <poza>'.$img_codat_agent.'</poza>
  <telefon>'.$user['tel'].'</telefon>
  <username></username>
  <web>'.$user['website'].'</web>
</agent>';

//prea($agentxml); die;

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

//echo '<pre>LISTA AGENTI: ' . print_r( $result, true ) . '</pre>';



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

//echo '<pre>INFORMATII AGENT ID #105: ' . print_r( $result, true ) . '</pre>';


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

//echo '<pre>PUBLICARE AGENT: ' . print_r( $result, true ) . '</pre>';


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

//echo '<pre>LOGOUT: ' . print_r( $result, true ) . '</pre>';


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

