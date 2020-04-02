<?php  require ('../../../config.php');
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

$imagini = array('jpg','jpeg');

$vanzare = many_query("SELECT * FROM `vanzare`  LEFT JOIN companie  on companie_vanzare = companie.id_companie WHERE idv = '".$_POST['id2']."' ");
$user = $users_all[$vanzare['uid']];
$img_codat_agent = 'https://brokers.trade-x.ro' . json_decode($user['atasamente'],true)[0][0];
$img_codat_agent = base64_encode(file_get_contents($img_codat_agent));

require_once ('agenti.php');


$i = 0;
$imgs = json_decode($vanzare['atasamente'],true);
$img_post = '<imagini nrimagini="'.count($imgs).'">';

foreach ($imgs as $ii=>$img){ $i++;
	$tmp = (explode('.',$img));
	$extension = end($tmp);
	if(!in_array($extension,$imagini)){ continue; }

	$image = new SimpleImage();
	$batch_return = $image->batch_resize($filename, $resize_policy, $remove_original_pic = false);
	@$image->unseti();
	unset($image);

if (is_file(THF_PATH . substr($tmp[0],1) . '_md.'.$extension))
	{
	 $filename_md = THF_PATH . substr($tmp[0],1) . '_md.'.$extension;
	
	}
	else
	{
 $filename_md = THF_PATH . substr($tmp[0],1) . '.'.$extension;
		
	}
	
	$filename = "../../.." . $img;
	$size = getimagesize($filename_md);
	$img_send[]['name'] = $filename_md;
	$img_send[]['height'] = $size[1];
	$img_send[]['height'] = $size[1];

	if ($size[1]>720) { continue; }
	if($size[0] * $size[1] < 120000){ continue; }
	
	$img_codat = base64_encode(file_get_contents($filename_md));
	$img_post .= '<imagine latime="'.$size[0].'" inaltime="'.$size[1].'" tip="imagine" pozitie="'.$i.'">';
	$img_post .='<descriere>'.$i.'</descriere>';
	$img_post .='<blob>'.$img_codat.'</blob>';
	$img_post .='<titlu>'.$i.'</titlu>';
	$img_post .= '</imagine>';
}
$img_post .= '</imagini>';

//prea($img_post);


$type=$_GET['type'];
$id2random = (int)rand( 5000, 500000 );
$id2random = $_POST['id2'];
$imagini = urldecode($_POST['imagini']);


if ($type==0 || $type==1)
{
$ofertaxml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oferta tip="'.($type==0?'apartament':'casavila').'" versiune="3">
  <agent>'.$user['id'].'</agent>
<id2>'.  $_POST['id2'] . '</id2>
<idstr></idstr>
<judet>'.  $_POST['judet'] . '</judet>
<localitate>'.  $_POST['localitate'] . '</localitate>
<zona>'.  $_POST['zone'] . '</zona>
<portal>'.  $_POST['portal'] . '</portal>
<tiplocuinta>'.$_POST['tiplocuinta'].'</tiplocuinta>
<devanzare>'.$_POST['devanzare'].'</devanzare>
<dataadaugare>1</dataadaugare>
<datamodificare>1</datamodificare>
<destinatie>'.$_POST['destinatie'].'</destinatie>
<idnum></idnum>
<tipimobil>'.$_POST['tipimobil'].'</tipimobil>
<ansamblurezidential>'.$_POST['ansamblurezidential'].'</ansamblurezidential>
<tipcompartimentare>'.$_POST['tipcompartimentare'].'</tipcompartimentare>
<demisol>'.$_POST['demisol'].'</demisol>
<dotari>'.(count($_POST['dotari'])?implode(" ",$_POST['dotari']):"").'</dotari>
<finisaje>'.(count($_POST['finisaje'])?implode(" ",$_POST['finisaje']):"").'</finisaje>
<deinchiriat>'.$_POST['deinchiriat'].'</deinchiriat>
<mansarda>'.$_POST['mansarda'].'</mansarda>
<nrbucatarii>'.$_POST['nrbucatarii'].'</nrbucatarii>
<nrnivele>'.$_POST['nrnivele'].'</nrnivele>
<pretnegociabil>'.$_POST['pretnegociabil<blockquote></blockquote>'].'</pretnegociabil>
<pretvanzare>'.$_POST['pretvanzare'].'</pretvanzare>
<monedavanzare>'.$_POST['monedavanzare'].'</monedavanzare>
<patratecaroiaj>'.$_POST['patratecaroiaj'].'</patratecaroiaj>
<etaj>'.$_POST['etaj'].'</etaj>   
<nrcamere>'.$_POST['nrcamere'].'</nrcamere>   
<tara>'.$_POST['tara'].'</tara>
<pretinchiriere>'.$_POST['pretinchiriere'].'</pretinchiriere>
<monedainchiriere>'.$_POST['monedainchiriere'].'</monedainchiriere>
<servicii>'.(count($_POST['servicii'])?implode(" ",$_POST['servicii']):"").'</servicii>
<altedetaliizona>'.(count($_POST['altedetaliizona'])?implode(" ",$_POST['altedetaliizona']):"").'</altedetaliizona>
<linkextern>'.$_POST['linkextern'].'</linkextern>
<pretinchiriereunitar>'.$_POST['pretinchiriereunitar'].'</pretinchiriereunitar>
<monedainchiriereunitar>'.$_POST['monedainchiriereunitar'].'</monedainchiriereunitar>
<suprafataconstruita>'.$_POST['suprafataconstruita'].'</suprafataconstruita>
  <suprafatautila>'.$_POST['suprafatautila'].'</suprafatautila>
<structurarezistenta>'.$_POST['structurarezistenta'].'</structurarezistenta>
<subsol>'.$_POST['subsol'].'</subsol>
<regimhotelier>'.$_POST['regimhotelier'].'</regimhotelier>
<pretfaratva>'.$_POST['pretfaratva'].'</pretfaratva>
<utilitati>'.(count($_POST['utilitati'])?implode(" ",$_POST['utilitati']):"").'</utilitati>
<caroiaj>'.$vanzare['caroiaj'].'</caroiaj>
'.$img_post.'
  <descriere>
    <lang id="1048">'.base64_encode($vanzare["descriere_publica"]).'</lang>
  </descriere>
</oferta>';
}
if ($type==3)
{
$ofertaxml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oferta tip="teren" versiune="3">
  <agent>'.$user['id'].'</agent>
<id2>'.  $_POST['id2'] . '</id2>
<idstr></idstr>
  <altecaracteristici>'.$_POST['altecaracteristici'].'</altecaracteristici>
  <constructiepeteren>'.$_POST['constructiepeteren'].'</constructiepeteren>
  <clasificareteren>'.$_POST['clasificareteren'].'</clasificareteren>
  <judet>'.$_POST['judet'].'</judet>
  <localitate>'.$_POST['localitate'].'</localitate>
  <destinatie>'.$_POST['destinatie'].'</destinatie>
  <tipteren>'.$_POST['tipteren'].'</tipteren>
  <suprafatateren>'.$_POST['suprafatateren'].'</suprafatateren>
  
  <tara>'.$_POST['tara'].'</tara>
  <zona>'.$_POST['zone'].'</zona>
  <umsuprafatateren>'.$_POST['umsuprafatateren'].'</umsuprafatateren>
  <altedetalii>
    <lang id="1048">YWZzZGY=</lang>
  </altedetalii>
  <altedetaliizona>'.(count($_POST['altedetaliizona'])?implode(" ",$_POST['altedetaliizona']):"").'</altedetaliizona>
  <numelotparcele>'.$_POST['numelotparcele'].'</numelotparcele>
  <frontstradal>'.$_POST['frontstradal'].'</frontstradal>
  '.$img_post.'
  <deinchiriat>'.$_POST['deinchiriat'].'</deinchiriat>
  <inclinatieteren>'.$_POST['inclinatieteren'].'</inclinatieteren>
  <latimedrumacces>'.$_POST['latimedrumacces'].'</latimedrumacces>
  <linkextern>'.$_POST['linkextern'].'</linkextern>
  <lotparcele>'.$_POST['lotparcele'].'</lotparcele>
  <monedainchiriere>'.$_POST['monedainchiriere'].'</monedainchiriere>
  <monedainchiriereunitar>'.$_POST['monedainchiriereunitar'].'</monedainchiriereunitar>
  <monedavanzare>'.$_POST['monedavanzare'].'</monedavanzare>
  <monedavanzaremp>'.$_POST['monedavanzaremp'].'</monedavanzaremp>
  <nrfronturistradale>'.$_POST['nrfronturistradale'].'</nrfronturistradale>
  <pretinchiriere>'.$_POST['pretinchiriere'].'</pretinchiriere>
  <pretnegociabil>'.$_POST['pretnegociabil'].'</pretnegociabil>
  <pretvanzare>'.$_POST['pretvanzare'].'</pretvanzare>
  <pretvanzaremp>'.$_POST['pretvanzaremp'].'</pretvanzaremp>
  <suprafataconstruita>'.$_POST['suprafataconstruita'].'</suprafataconstruita>
  <pretfaratva>'.$_POST['pretfaratva'].'</pretfaratva>
  <uminchiriereunitar>'.$_POST['uminchiriereunitar'].'</uminchiriereunitar>
  <umvanzareunitar>'.$_POST['umvanzareunitar'].'</umvanzareunitar>
  <utilitati>'.(count($_POST['utilitati'])?implode(" ",$_POST['utilitati']):"").'</utilitati>
  <devanzare>'.$_POST['devanzare'].'</devanzare>
  <pretinchiriereunitar>'.$_POST['pretinchiriereunitar'].'</pretinchiriereunitar>
 
 
  <comisionzero>'.$_POST['comisionzero'].'</comisionzero>
  <comisioncumparator>    <lang id="1048">MiU=</lang>  </comisioncumparator>

  
  <prettranzactie>'.$_POST['prettranzactie'].'</prettranzactie>

  <procentocupareteren>'.$_POST['procentocupareteren'].'</procentocupareteren>
  <coeficientutilizareteren>'.$_POST['coeficientutilizareteren'].'</coeficientutilizareteren>
  <regiminaltime>'.$_POST['regiminaltime'].'</regiminaltime>
  <sursainformatiicoeficienti>'.$_POST['sursainformatiicoeficienti'].'</sursainformatiicoeficienti>

  <portal>'.$_POST['portal'].'</portal>
  <comisionvanzator>'.$_POST['comisionvanzator'].'</comisionvanzator>
    <descriere>
    <lang id="1048">'.base64_encode($vanzare["descriere_publica"]).'</lang>
  </descriere>
</oferta>';	
}

if ($type==4)
{
	$ofertaxml='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oferta tip="spatiu" versiune="3">
  <agent>'.$user['id'].'</agent>
  <id2>'.$_POST['id2'].'</id2>

<idstr></idstr>

  <anconstructie>'.$_POST['anconstructie'].'</anconstructie>
  <clasabirouri>'.$_POST['clasabirouri'].'</clasabirouri>
  <tipimobil>'.$_POST['tipimobil'].'</tipimobil>
  <tipspatiu>'.$_POST['tipspatiu'].'</tipspatiu>
  <judet>'.$_POST['judet'].'</judet>
  <localitate>'.$_POST['localitate'].'</localitate>
  <zona>'.$_POST['zone'].'</zona>
  <tara>'.$_POST['tara'].'</tara>
  <suprafatautila>'.$_POST['suprafatautila'].'</suprafatautila>
  <altecaracteristici>'.(count($_POST['altecaracteristici'])?implode(" ",$_POST['altecaracteristici']):"").'</altecaracteristici>
 
  <altedetaliizona>'.(count($_POST['altedetaliizona'])?implode(" ",$_POST['altedetaliizona']):"").'</altedetaliizona>
 
  <demisol>'.$_POST['demisol'].'</demisol>
  <numeimobil>'.$_POST['numeimobil'].'</numeimobil>

  <dotari>'.(count($_POST['dotari'])?implode(" ",$_POST['dotari']):"").'</dotari>
  <etaj>'.$_POST['etaj'].'</etaj>
  <finisaje>'.(count($_POST['finisaje'])?implode(" ",$_POST['finisaje']):"").'</finisaje>
  '.$img_post.'
  <inaltimespatiu>'.$_POST['inaltimespatiu'].'</inaltimespatiu>
  <deinchiriat>'.$_POST['deinchiriat'].'</deinchiriat>
  <latimevitrina>'.$_POST['latimevitrina'].'</latimevitrina>
  <linkextern>'.$_POST['linkextern'].'</linkextern>
  <mansarda>'.$_POST['mansarda'].'</mansarda>
  <monedainchiriere>'.$_POST['monedainchiriere'].'</monedainchiriere>
  <monedainchiriereunitar>'.$_POST['monedainchiriereunitar'].'</monedainchiriereunitar>
  <monedavanzare>'.$_POST['monedavanzare'].'</monedavanzare>
  <monedavanzaremp>'.$_POST['monedavanzaremp'].'</monedavanzaremp>
  <nrgaraje>'.$_POST['nrgaraje'].'</nrgaraje>
  <nrgrupurisanitare>'.$_POST['nrgrupurisanitare'].'</nrgrupurisanitare>
  <nrincaperi>'.$_POST['nrincaperi'].'</nrincaperi>
  <nrparcari>'.$_POST['nrparcari'].'</nrparcari>
  <nrnivele>'.$_POST['nrnivele'].'</nrnivele>
  <nrnivelesubterane>'.$_POST['nrnivelesubterane'].'</nrnivelesubterane>
  <nrterase>'.$_POST['nrterase'].'</nrterase>
  <pretinchiriere>'.$_POST['pretinchiriere'].'</pretinchiriere>
  <pretinchiriereunitar>'.$_POST['pretinchiriereunitar'].'</pretinchiriereunitar>
  <pretnegociabil>'.$_POST['pretnegociabil'].'</pretnegociabil>
  <pretvanzare>'.$_POST['pretvanzare'].'</pretvanzare>
  <pretvanzaremp>'.$_POST['pretvanzaremp'].'</pretvanzaremp>
  <servicii>'.(count($_POST['servicii'])?implode(" ",$_POST['servicii']):"").'</servicii>
  <stadiuconstructie>'.$_POST['stadiuconstructie'].'</stadiuconstructie>
  <structurarezistenta>'.$_POST['structurarezistenta'].'</structurarezistenta>
  <suprafataconstruita>'.$_POST['suprafataconstruita'].'</suprafataconstruita>
  <suprafatacurte>'.$_POST['suprafatacurte'].'</suprafatacurte>
  <suprafataterase>'.$_POST['suprafataterase'].'</suprafataterase>
  <suprafatateren>'.$_POST['suprafatateren'].'</suprafatateren>
  <pretfaratva>'.$_POST['pretfaratva'].'</pretfaratva>
  <utilitati>'.(count($_POST['utilitati'])?implode(" ",$_POST['utilitati']):"").'</utilitati>
  <devanzare>'.$_POST['devanzare'].'</devanzare>
 
  <vitrina>'.$_POST['vitrina'].'</vitrina>
  
  <caroiaj>'.$vanzare['caroiaj'].'</caroiaj>
  <comisionzero>'.$_POST['comisionzero'].'</comisionzero>
  <comisioncumparator>    <lang id="1048">MiU=</lang>  </comisioncumparator>
 
  <portal>'.$_POST['portal'].'</portal>
  <comisionvanzator>'.$_POST['comisionvanzator'].'</comisionvanzator>
    <descriere>
    <lang id="1048">'.base64_encode($vanzare["descriere_publica"]).'</lang>
  </descriere>
</oferta>';
}
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
prea($result->extra);
$session_id = $extra[ 1 ];

if($vanzare['id_imobiliare']==''){

//echo '<pre>LOGIN: ' . print_r( $result, true ) . '</pre>';

// publica oferta - adaugare
try {
$result = $s->__soapCall(
		'publica_oferta',
	array(
			'publica_oferta' => array(
				'id_str'		=> $type.':' .  $_POST['id2'], // 0 = apartamente, 1 = case/vile etc
				'sid' 			=> $session_id,
				'operatie'		=> 'ADD', // ADAUGARE
				'ofertaxml' 	=> $ofertaxml,
			)
		)
	);
} catch( Exception $e ) {
	die( 'Eroare Publicare oferta: ' . $e->getMessage() );
}
	//echo '<pre>ADAUGARE OFERTA: ' . print_r($result, true) . '</pre>';
	if(substr_count($result->mesaj,'OK')){
		$ddff = explode(' ',$result->mesaj);
		$ids = end($ddff);
	}
		if(strlen($ids) == 9){
			update_query("UPDATE `vanzare` SET `id_imobiliare` = '".$ids."' WHERE `vanzare`.`idv` = '".$vanzare['idv']."' LIMIT 1");

			$_SESSION['id_imobiliare'] = $ids;
			$json = (json_encode($_POST));

			$insert = array(
				'type'=>$type,
				'id_vanzare'=>$id2random,
				'id_imobiliare'=>$ids,
				'json'=>$json,
			);
			insert_update('imobiliare',$insert);




		} else {
			if(0) {
				prea($img_send);
				prea($_GET);
				prea($_POST);
				prea($ofertaxml);
			}
			//prea(explode(' ',$result->mesaj));
		}
	echo $result->mesaj . '<br>' .$result->extra;
}


if(0) {
	try {
		$result = $s->__soapCall(
			'marcheaza_tl',
			array(
				'marcheaza_tl' => array(
					//'id' => 75572 . ':0',
					'id' => '0:' .  $_POST['id2'], //pt publicare oferta
					'sid' => $session_id,
					'operatie' => 'ADD',
					'ofertaxml' => $ofertaxml,
				)
			)
		);
	} catch (Exception $e) {
		die('Eroare Publicare oferta: ' . $e->getMessage());
	}
	echo '<pre>ADAUGARE TL: ' . print_r($result, true) . '</pre>';

}


if($vanzare['id_imobiliare']!='') {
// publica oferta - modificare
	try {
		$result = $s->__soapCall(
			'publica_oferta',
			array(
				'publica_oferta' => array(
					'id_str' => $type.':' . $_POST['id2'],  // 0 = apartamente, 1 = case/vile etc
					'sid' => $session_id,
					'operatie' => 'MOD', // MODIFICARE
					'ofertaxml' => $ofertaxml,
				)
			)
		);
	} catch (Exception $e) {
		die('Eroare Publicare oferta: ' . $e->getMessage());
	}
if(substr_count($result->mesaj,'OK')){
		$ddff = explode(' ',$result->mesaj);
		$ids = end($ddff);
	}
		if(strlen($ids) == 9){
			update_query("UPDATE `vanzare` SET `id_imobiliare` = '".$ids."' WHERE `vanzare`.`idv` = '".$vanzare['idv']."' LIMIT 1");

			$_SESSION['id_imobiliare'] = $ids;
			$json = (json_encode($_POST));

			$insert = array(
				'type'=>$type,
				'id_vanzare'=>$id2random,
				'id_imobiliare'=>$ids,
				'json'=>$json,
			);
			insert_update('imobiliare',$insert);




		} else {
			if(0) {
				prea($img_send);
				prea($_GET);
				prea($_POST);
				prea($ofertaxml);
			}
			//prea(explode(' ',$result->mesaj));
		}
	echo '<pre>MODIFICARE OFERTA: ' . print_r($result, true) . '</pre>';
}

// publica oferta - stergere
//try {
//	$result = $s->__soapCall(
//		'publica_oferta',
//		array(
//			'publica_oferta' => array(
//				'id_str'		=> '0:' . $id2random,
//				'sid' 			=> $session_id,
//				'operatie'		=> 'DEL', // STERGERE
//				'ofertaxml' 	=> $ofertaxml,
//			)
//		)
//	);
//} catch( Exception $e ) {
//	die( 'Eroare Publicare oferta: ' . $e->getMessage() );
//}
//
//echo '<pre>STERGERE OFERTA: ' . print_r( $result, true ) . '</pre>';


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