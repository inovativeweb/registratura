<?php
//DATA FETCH

$statusuri=array(
    0=>'Creat',
    1=>'In lucru',
    2=>'Actiune solicitant',
    3=>'Solutionat',
);
$prioritate=array(
    3=>'Prio 3',
    2=>'Prio 2',
    1=>'Prio 1',
);
$culoare_status=array(
    0=>'black',
    1=>'blue',
    2=>'orange',
    3=>'green',
);
$straziX = multiple_query("SELECT * FROM `strazi` ORDER BY `strazi`.`nume` ASC",'ids');
foreach($straziX as $i=>$s){ if(!$s['deleted']){$strazi[$i]=$s['nume'];} }
$strazi[0] = 'Selecteaza';


$users = multiple_query("SELECT * FROM `thf_users`",'id');
$users_all = multiple_query("SELECT * FROM `thf_users`",'id');
$filiale_asoc=multiple_query("SELECT * FROM `asociatii`",'id');
$asoc_in = implode(',',return_users_agentie($user_id_login));
$asoc_in_filiale=implode(',',return_users_filiala($user_id_login));
$organigrame_all = multiple_query("SELECT * FROM `organigrama` ",'ido');
foreach($organigrame_all as $i=>$s){ if(!$s['deleted']){$organigrame[$i]=$s['functie'];} }


$departamente_all = multiple_query("SELECT * FROM `departamente` ",'idd');
foreach($departamente_all as $i=>$s){ if(!$s['deleted']){$departamente[$i]=$s['nume_departament'];} }
$departamente[0] = 'Fara departament';


if(!count($asoc_in)){$asoc_in = 0;}
$vanzari_all = multiple_query("SELECT * FROM `vanzare`
  LEFT JOIN companie  on companie_vanzare = companie.id_companie",'idv');

$vanzari = multiple_query("SELECT * FROM `vanzare`
  LEFT JOIN companie  on companie_vanzare = companie.id_companie
  WHERE  ".($access_level_login>9?'1':" (uid='$login_user' OR vanzare.status = 3   ".($access_level_login == 2 ? " OR uid IN (".floor($asoc_in).")" : "" )." ".($access_level_login == 3 ? " OR uid IN (".floor($asoc_in_filiale).")" : "" ).") ORDER BY denumire_afacere ASC"),'idv');


$promovari  = multiple_query("SELECT * FROM `thf_facturi`
 LEFT join vanzare on vanzare.idv = thf_facturi.idvf 
 LEFT JOIN asociatii on asociatii.id = id_asociatie
 LEFT JOIN thf_users on thf_users.id = thf_facturi.uid
  LEFT JOIN companie ON id_companie = vanzare.companie_vanzare

ORDER BY idf DESC",'idf');


    $ids_vanzari=array(0);
    $vanzari_select=array();
    $afaceri_select=array();
        foreach($vanzari as $k=>$v){
            if($access_level_login<2 and $v['uid'] != $login_user){ continue; }
            $vanzari_select[$k]=$v['denumire'];
        }
         foreach($vanzari as $k=>$v){
            if($access_level_login<2 and $v['uid'] != $login_user){ continue; }
            // $afaceri_select[$k]=$v['denumire_afacere'] .(strlen($v['denumire_afacere_en']) > 3 ? ' <br>' . $v['denumire_afacere_en'] . '' : '');
             $afaceri_select[$k]=$v['denumire_afacere'];
        }
        //prea($afaceri_select);
        foreach($vanzari as $v){
            $ids_vanzari[]=$v['companie_vanzare'];
            $ids_vanzari[]=$v['reprezentant_vanzare'];
        }
//prea($vanzari); die;

function limita_promovari($idp){
    if($idp == 10 || $idp == 12){  //Anunt simplu
        $active = count_query("SELECT COUNT(*) FROM `promovari_active` WHERE (idp = '10' or idp = '12') and activ = '1' and date(valabilitate) >= CURRENT_DATE ()");
        return 6 - $active;
    } elseif ($idp == 9 || $idp == 13){  //Top Listing
        $active = count_query("SELECT COUNT(*) FROM `promovari_active` WHERE (idp = '9' or idp = '13') and activ = '1' and date(valabilitate) >= CURRENT_DATE ()");
        return 5 - $active;
    } elseif ($idp == 8 || $idp == 11){ // Top listing S
        $active = count_query("SELECT COUNT(*) FROM `promovari_active` WHERE (idp = '8' or idp = '11') and activ > 0 and date(valabilitate) >= CURRENT_DATE ()");
        return 1 - $active;
    } else {
        return '-1';
    }
}
function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}
asort($afaceri_select);


$companii_all = multiple_query("SELECT * FROM `companie` ",'id_companie'); //
$companii = multiple_query("SELECT * FROM `companie` WHERE   id_companie IN (".implode(',',$ids_vanzari).") ",'id_companie'); //
//$emitentii = multiple_query("SELECT * FROM `companie` WHERE `tip_companie` = 'e'",'id_companie');
$emitentii=$emitenti_nume=array();  //??????????????????
foreach ($companii as $idc=>$c){
	if($c['tip_companie']=='e'){
		$emitentii[$idc]=$c;
		$emitenti_nume[$idc] = $c['denumire'];
	}
}

/*
$anunturi_promovate=multiple_query("SELECT GROUP_CONCAT(CONCAT(post_ro,' , ',post_en) SEPARATOR ', ') as total_posts FROM `vanzare` where promovare_aprobata='1' and promovat_until>=".date("Y-m.d")." and (post_ro>0 or post_en>0) ");

$anunturi_nepromovate=multiple_query("SELECT GROUP_CONCAT(CONCAT(post_ro,' , ',post_en) SEPARATOR ', ') as total_posts FROM `vanzare` where (promovare_aprobata='0' or promovat_until<".date("Y-m.d").") and (post_ro>0 or post_en>0) ");
*/


	$toate_anunturile=multiple_query("SELECT idv,post_ro,post_en from `vanzare` where post_ro>0 or post_en>0");
	$$anunturi_promovate="";
	$anunturi_nepromovate="";
	foreach ($toate_anunturile as $k=>$v)
		{
			if (isset(get_promovare_activa($v['idv'])[0]))
			{
				$anunturi_promovate.=$v['post_ro'].",".$v['post_en'].",";
			}
		else
			{
				$anunturi_nepromovate.=$v['post_ro'].", ".$v['post_en'].",";
			}
		}
		if (strlen($anunturi_promovate)>0) $anunturi_promovate=trim($anunturi_promovate,",");
		if (strlen($anunturi_nepromovate)>0) $anunturi_nepromovate=trim($anunturi_nepromovate,",");
		
		
		



$cumparatori_all = multiple_query("SELECT * FROM `cumparatori` WHERE  1 ",'idc');


$cumparatori = multiple_query("SELECT * FROM `cumparatori` WHERE  idv_cumparator = 0 and ".($access_level_login>9?'1':" business_broker='$login_user' ") . " ",'idc');
$documente = multiple_query("SELECT * FROM `documente` ",'idd');

$types_imobiliare = array(
    '0'=>'apartament',
    '1'=>'casevile',
    '3'=>'terenuri',
    '4'=>'spatii',
);
$cumparatori_select=array();
        foreach($cumparatori as $k=>$v){
            $cumparatori_select[$k]=$v['full_name'];
        }


//prea(return_users_filiala($login_user));
$tasks = multiple_query("SELECT * FROM `task` WHERE ".($access_level_login>9?'1':" (user_id='$login_user' ".($access_level_login == 2 ? " OR user_id IN (".$asoc_in.")" : "" )." ".($access_level_login == 3 ? " OR user_id IN (".$asoc_in_filiale."))" : ")" ))." ORDER BY completed ASC , favorit DESC,  deadline ASC",'task_id');
$tasks = multiple_query("SELECT * FROM `task` WHERE user_id='$login_user' ORDER BY completed ASC , favorit DESC,  deadline ASC",'task_id');

$users_list_q = multiple_query("SELECT id, full_name FROM `thf_users` ORDER BY full_name ASC"); 
foreach ($users_list_q as $k=>$v){
	$users_list[$v['id']]=$v['full_name'];
}


$asociatii = multiple_query("SELECT * FROM `asociatii`",'id');
$locuitori_all = multiple_query("SELECT * FROM `locuitori` LEFT JOIN organigrama on ido = id_organigrama ORDER by fullname ASC",'idl');
$locuitori_organigrama[0] = 'Nealocat';
foreach ($locuitori_all as $k=>$v){
    $locuitori[$v['idl']]=$v['fullname'];
    if($v['id_organigrama'] > 0) {
        $locuitori_organigrama[$v['idl']] = $v['fullname'] .' ('. $v['functie'].')';
    }
}

$editIM = multiple_query("SELECT * FROM `editare_im`",'idv');

$due_diligence_text = multiple_query("SELECT * FROM `due_diligence_text`",'id');
$ckeck_list_text = multiple_query("SELECT * FROM `ckeck_list_text`",'id');





$judete_localitati = multiple_query("SELECT * FROM localizare_localitati LEFT JOIN localizare_judete ON parinte=localizare_judete.id ORDER BY localizare_localitati.localitate ASC,localizare_localitati.id ASC");
$judete_all = multiple_query("SELECT * FROM `localizare_judete` ORDER BY nume_judet ASC");
foreach ($judete_all as $k=>$v){
    $judete[$v['id']]=$v['nume_judet'];
}  $judete[0] = 'Selecteaza un judet';
$localitati_all = multiple_query("SELECT * FROM `localizare_localitati` ORDER BY localitate ASC");
foreach ($localitati_all as $k=>$v){
    $localitati[$v['id']]=$v['localitate'];
}


//AUTO EMAIL SEND
$send_proforma = multiple_query("SELECT * FROM `thf_facturi` WHERE email_send = 0 and `status` > 0 ");
foreach ($send_proforma as $k=>$e){
        send_email_proforma($e['idf']);
 update_query("UPDATE `thf_facturi` SET `email_send` = '1' WHERE `thf_facturi`.`idf` = '".q($e['idf'])."';");
}

$send_useri_noi = multiple_query("SELECT * FROM `thf_users` WHERE anuntat_email_initial = 0");
foreach ($send_useri_noi as $k=>$e){
    send_email_cont_nou($e['id']);
   update_query("UPDATE `thf_users` SET `anuntat_email_initial` = '1' WHERE `thf_users`.`id` = '".q($e['id'])."';");
}
