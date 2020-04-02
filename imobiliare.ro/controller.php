<?php
if (!$GLOBALS['has_config']) {require ('../config.php'); }

      require ('functions.php');

$vanzare = $vanzari_all[$_GET['company']];


$fields = return_publish_fields();

$nomenclatorX = file_get_contents(THF_PATH . 'imobiliare.ro/nomenclator.txt');
$nomenclator = explode(PHP_EOL,$nomenclatorX);
/*
◦ apartamente|NUME_CAMP|ID_VALOARE|DENUMIRE_OPTIUNE
◦ casevile|NUME_CAMP|ID_VALOARE|DENUMIRE_OPTIUNE
◦ spatii|NUME_CAMP|ID_VALOARE|DENUMIRE_OPTIUNE
◦ terenuri|NUME_CAMP|ID_VALOARE|DENUMIRE_OPTIUNE
*/



$types = $types_imobiliare;
if(isset($_POST['save_caroiaj']) and is_numeric($_POST['save_caroiaj'])){
    update_query("UPDATE `vanzare` SET `caroiaj` = '".$_POST['save_caroiaj']."' WHERE `vanzare`.`idv` = '".$_POST['company']."' LIMIT 1");
    redirect(303,'/imobiliare.ro/?company=78');
    die;
}
if (isset($_POST['check_imobiliare_id'])) {
    $ids = $_SESSION['id_imobiliare'];
    if (strlen($ids) == 9) {
        if ($is_admin) { ?>
            <a target="_blank"
               href="https://adminonline.imobiliare.ro/oferte/apartamente/vanzari/<?= $ids ?>"><input
                    type="button" class="ui green teal button" id="" value="Adminonline.Imobiliare.ro"></a>
        <?php } ?>
        <a target="_blank"
           href="<?= /*$type != 4*/false ? 'https://www.imobiliare.ro' : 'https://www.spatiicomerciale.ro' ?>/anunt/<?= $ids ?>"><input
                type="button" class="ui green red button" id="" value="Imobiliare.ro"></a>
    <?php } else {
        echo 'Eroare!';
    } ?>
    <a href="https://brokers.trade-x.ro/add_afacere/?edit=<?= $vanzare['idv'] ?>">
        <input type="button" class="ui green purple button" id="" value="Inapoi la <?= $vanzare['denumire'] ?>"></a>
    <?php

    die();
}


$type = isset($_GET['type']) ? $_GET['type'] : 4;
$step = isset($_GET['step']) ? $_GET['step'] : 'verificare';

foreach ($nomenclator as $k=>$field){
    if(!strlen($field) || substr_count($field,'--')){continue ;}
  //   prea($field);
    $tmp = explode('|',$field);
   
    if($tmp[1] == 'localitati' || $tmp[1] == 'zone'){
    	
        $data[$tmp[0]][$tmp[1]][$tmp[3]]['denumire'] = $tmp[4];
        $data[$tmp[0]][$tmp[1]][$tmp[3]]['id'] = $tmp[3];
        $data[$tmp[0]][$tmp[1]][$tmp[3]]['parinte'] = $tmp[2];
    } else {
        $data[$tmp[0]][$tmp[1]][$tmp[2]]['denumire'] = $tmp[3];
        $data[$tmp[0]][$tmp[1]][$tmp[2]]['id'] = $tmp[2];
    }
}
$danu=array(''=>'Selecteaza','0'=>"Nu",'1'=>"Da");
ksort($danu);

$judete_imobiliareX = $data['localizare']['judete'];

$judet_tradex = $judete[$vanzare['judet_id']];
$localitate_tradex = $localitati[$vanzare['localitate_id']];

foreach ($judete_imobiliareX as $key=>$opt){
    $judete_imobiliare[$opt['id']] = $opt['denumire'];
    if($judet_tradex == $opt['denumire']){
        $jud_selectat = $opt['id'];
    }
}

$localitati_imobiliareX = $data['localizare']['localitati'];
        foreach ($localitati_imobiliareX as $key=>$opt){
                 if($opt['parinte'] == $jud_selectat) {
                     $localitati_imobiliare[$opt['id']] = $opt['denumire'];
                     if($localitate_tradex == $opt['denumire']){
                         $loc_selectata = $opt['id'];
                     }
                 }
        }


$zone_imobiliareX = $data['localizare']['zone'];
foreach ($zone_imobiliareX as $key=>$opt){
        if($opt['parinte'] == $loc_selectata) {
             $zone_imobiliare[$opt['id']] = $opt['denumire'];
         }
}
if(!count($zone_imobiliare)){ $zone_imobiliare = array('999999999'=>'Orice zona');}

$tip_locuintaX=$data['apartamente']['tiplocuinta'];  foreach ($tip_locuintaX as $key=>$opt){$tip_locuinta[$key] = $opt['denumire'];}

$monedavanzareX=$data['apartamente']['monedavanzare'];  foreach ($monedavanzareX as $key=>$opt){$moneda_vanzare[$key] = $opt['denumire'];}

$destinatieX=$data['apartamente']['destinatie'];  foreach ($destinatieX as $key=>$opt){$destinatie[$key] = $opt['denumire'];}

$etajX=$data['apartamente']['etaj'];  foreach ($etajX as $key=>$opt){$etaj[$key] = $opt['denumire'];}

$taraX=$data['apartamente']['tara'];  foreach ($taraX as $key=>$opt){$tara[$key] = $opt['denumire'];}

$tipimobilX=$data['apartamente']['tipimobil'];  foreach ($tipimobilX as $key=>$opt){$tipimobil[$key] = $opt['denumire'];}

$tipcompartimentareX=$data['apartamente']['tipcompartimentare'];  foreach ($tipcompartimentareX as $key=>$opt){$tipcompartimentare[$key] = $opt['denumire'];}

$confortX=$data['apartamente']['confort'];  foreach ($confortX as $key=>$opt){$confort[$key] = $opt['denumire'];}

$monedavanzareX=$data['apartamente']['monedavanzare'];  foreach ($monedavanzareX as $key=>$opt){$moneda_vanzare[$key] = $opt['denumire'];}

foreach ($data['apartamente'] as $tip=>$val)
{
	foreach ($val as $key=>$opt)
		{
			$values[$tip][$key]=$opt['denumire'];
		}
		
}


unset($values['destinatie'][465]); // remove first record

foreach ($data['casevile'] as $tip=>$val)
{
	foreach ($val as $key=>$opt)
		{
			$valuesCv[$tip][$key]=$opt['denumire'];
		}
		
}

unset($valuesCv['destinatie'][465]); // remove first record


foreach ($data['terenuri'] as $tip=>$val)
{
	foreach ($val as $key=>$opt)
		{
			$valuesTr[$tip][$key]=$opt['denumire'];
		}
		
}


foreach ($data['terenuri'] as $tip=>$val)
{
	foreach ($val as $key=>$opt)
		{
			$valuesTr[$tip][$key]=$opt['denumire'];
		}
		
}

foreach ($data['spatii'] as $tip=>$val)
{
	foreach ($val as $key=>$opt)
		{
			$valuesSp[$tip][$key]=$opt['denumire'];
		}
		
}

unset($valuesTr['utilitati']['304']);
unset($valuesTr['destinatie']['470']);


unset($valuesSp['altecaracteristici']['431']);
unset($valuesSp['altecaracteristici']['432']);
unset($valuesSp['altedetaliizona']['421']);
unset($valuesSp['dotari']['393']);
unset($valuesSp['finisaje']['366']);
unset($valuesSp['servicii']['415']);
unset($valuesSp['utilitati']['350']);
unset($valuesTr['destinatie']['470']);
unset($values['dotari']['68']);

$data = $data[$types[$type]];



if($_POST['localitate_imobiliare'] > 0 and is_numeric($_POST['localitate_imobiliare'])){
    foreach ($zone_imobiliareX as $key=>$opt){
        if($opt['parinte'] == $_POST['localitate_imobiliare']) {
            $zone_imobiliare_selectY[$opt['id']] = $opt['denumire'];
        }
    }
    if (count($zone_imobiliare_selectY)==0)
    	{
    		$zone_imobiliare_selectY[999999999]='Orice zona';
		}
	else
		{
			 $zone_imobiliare_selectY[0]  = "Selecteaza zona";
		}
   
    select_rolem('zone','Zona ',$zone_imobiliare_selectY,'','Alege...',false,array());
    die;
}

if($_POST['judet_imobiliare'] > 0 and is_numeric($_POST['judet_imobiliare'])){
    foreach ($localitati_imobiliareX as $key=>$opt){
        if($opt['parinte'] == $_POST['judet_imobiliare']) {
            $localitati_imobiliare_selectY[$opt['id']] = $opt['denumire'];
        }
    }
    $localitati=array(""=>"Selecteaza localitatea") + $localitati_imobiliare_selectY;
    select_rolem('localitate','Localitate ',$localitati,'','Alege...',false,array());
    die;
}