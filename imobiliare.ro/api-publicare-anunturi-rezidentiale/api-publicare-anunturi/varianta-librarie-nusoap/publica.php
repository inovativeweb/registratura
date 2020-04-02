<?php
/**
 * Cod PHP functional pentru demonstrarea functionalitatii API imobiliare.ro
 * ------------------------------------------------------------------
 *
 * ACEST COD ESTE PUS LA DISPOZITIE CU TITLU DEMONSTRATIV, SI NU ESTE
 * SUB NICI O FORMA INDICAT SA FIE UTILIZAT IN PRODUCTIE.
 *
 * TEXTELE, DESCRIERILE SI IMAGINILE SUNT CODIFICATE IN FORMAT BASE64
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
      <descriere>TyBkZXNjcmllcmUgb3B0aW9uYWxhIGEgZm90b2dyYWZpZWk=</descriere>
      <blob>/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAoHBwgHBgoICAgLCgoLDhgQDg0NDh0VFhEYIx8lJCIfIiEmKzcvJik0KSEiMEExNDk7Pj4+JS5ESUM8SDc9Pjv/2wBDAQoLCw4NDhwQEBw7KCIoOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozv/wAARCAF3AWcDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD2aiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiql9f2emWrXV/dQ20C9ZJnCqPTk155rnxv0OwLR6TbS6lIvHmE+VH+BILH/AL5x70AenUV886h8avFV6HW1a0sEJ+Vood7qM9MuSCcd8D8Kwrj4keMbpWWTxBdKGHPlFYz+BUDH4UAfUdFfKUXjPxTHIrjxJqhIIPzXsjD8i2D9DWlb/FTxpbFSNbeQKclZYkYH2OVz+tAH03RXhek/HfVIWC6tpdtcqSPnt2MTAdzg5BP5V6T4c+InhvxM6Q2l75N04GLe4GxyeeB2Y8H7pNAHV0UUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAV5546+Kdh4XeSw0/be6ntOVz+7gPbcR1P8Asj8SOKx/ij8TZdLkfQdCnAuxxdXSkHyv9hf9r1Pbtz93xFmZ2LMSzE5JJySaANPXfEWqeI7v7Vqt29xIM7QeFjB7KBwB0/KsmiigAooooAKKKKACnqzIwZSVYHIIOCDTKKAPU/A3xeutLaPT/EUkl7ZkhUuessI6c93X/wAe69eBXuFtcQ3lvHc20qTQyqGSRGDKwPIII6ivjyvS/hT4/bQb9dG1Kdjpt04ETMci3kJ6+ysTz2B59aAPoGiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArg/if41PhXQxDaPt1S9ysBxny1GNz/UZwPc9wDXazTR28LzzOEjiUs7N0UAZJP4V8s+M/EUvirxRdao+4RO2yBT/BGOFH9T7k0AYryPLIzuxZ2JJYnJJPUk1FRRQAUUVZsbG51K9is7OFpriZgscajJYmgCtWlZaBrGpI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KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP/2Q==</blob>
      <titlu>VW4gdGl0bHUgc3VnZXN0aXYgZGFyIG9wdGlvbmFsLi4u</titlu>
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
				'id_str'		=> '0:' . $id2random, // 0 = apartamente, 1 = case/vile 3 = terenuri 4 = spatii etc
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
				'id_str'		=> '0:' . $id2random,  // 0 = apartamente, 1 = case/vile 3 = terenuri 4 = spatii etc
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