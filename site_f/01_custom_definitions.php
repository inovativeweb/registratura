<?php


$tip_forma_juridica = array(
'f'=>'Persoană Fizică',
'j'=>'Persoană Juridică',
);

// definire tipuri documente
$tip_companie=array();
$bulk=multiple_query("DESCRIBE `companie`",'Field');
eval(str_replace('enum','$tmp=array',$bulk['tip_companie']['Type'].';'));
foreach($tmp as $m){$tip_companie[$m]=$m;}


$logo='http://brokers.trade-x.ro/media/Logo_Business_Escrow.png';

$valoare_promovare = 540;

$statusuri=array(
    0=>'Draft',
	1=>'Asteapta Aprobare',
	3=>'Publicat',
	5=>'In Escrow',
	7=>'Arhivat',
	9=>'Retras de la Vanzare'
	);
 //9=>'Sters',
$repeta_task=array(
    0=>'Nu se repeta',
    1=>'Zilnic',
    3=>'Saptamanal',
    4=>'2 saptamani',
    5=>'Lunar',
    7=>'Anual',
);

$icon_type_task = array(
    'c'=>'circular olive dollar icon',
    'v'=>'circular purple tag icon',
    'g'=>'circular teal tasks alternate outline icon'
);
$culori_statusuri = array(
    0=>'red',
    1=>'olive',
    3=>'teal',
    5=>'violet',
    7=>'blue',
    9=>'green'
);

$tip_act_identitate = array(
	'0'=>'Selecteaza',
	'1'=>'CI',
	'2'=>'Buletin',
	'3'=>'Pasaport',
	'4'=>'CI provizorie ',
);



$rol=array(
	//""=>"Alege",
	"1"=>"Broker",
	"2"=>"Manager asociatie",
	"3"=>"Manager filiala",
	"10"=>"Administrator",
	"11"=>"Web Developper"
);

//DATA FETCH FISIER SEPARAT

function get_promovare_activa ($idv){  
	$promovari_active = multiple_query("SELECT * FROM `promovari_active` WHERE idv = $idv and activ > 0 and valabilitate >= CURRENT_DATE ()",'idp');
	return $promovari_active;
}

function formatare_txt_cont($cont){	return ($cont['default_cont']?'<span class="glyphicon glyphicon-star default_cont"></span> ':'').h($cont['cont'].' ('.$cont['moneda'].') '.$cont['nume_banca']).' <em>'.h($cont['sucursala']).'</em>';}


function formatare_txt_adresa($cont){ // lista adresa

global $tip_arteta;
$judet=array(""=>"Selecteaza judet");
	$judet = one_query("SELECT nume_judet FROM `localizare_judete` WHERE id = '".$cont['judet_id']."' ");


	$adresa =
	//($cont['default_adrese']?'<img TITLE="Adresa unde se efectueaza lucrarea" id="logo_firma" src="/media/logo_2017_300.png" style="height:30px;width:auto;"> ':'').
	($cont['localitatea'] ? ''.$cont['localitatea'].', ' : '').
	($judet ? $judet.', ' : ''.'').
	($tip_arteta[$cont['tip_artera']] ? h($tip_arteta[$cont['tip_artera']]).', ' : ' ').
	(trim($cont['strada']) ? $cont['strada'].', ':'').
	(trim($cont['numar']) ? $cont['numar'].', ' : '').
	(trim($cont['bloc']) ? ''.h($cont['bloc']).', ' :'').
	(trim($cont['scara']) ? h($cont['scara']).', ' : '').
	(trim($cont['etaj']) ? h($cont['etaj']).', ':'').
	(trim($cont['ap']) ? h($cont['ap']).', ' : '').
	(trim($cont['cod_postal']) ? h($cont['cod_postal']).', ' : '').
	(trim($cont['nr_cf_cad']) ? h($cont['nr_cf_cad']) : '').
	(trim($cont['tara']) ? ''.h($cont['tara']).', ' : '').
	(strlen($cont['telefon']) > 8 ? $cont['telefon'] : '');
	return ($adresa);
    }



?>