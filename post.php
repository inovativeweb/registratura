<?php
require_once('./config.php');



if(isset($_POST['file_hash'])){
    $file_nameX = base64_decode($_POST['file_hash']);
    $tmp = (explode('/',$file_nameX));
     $file_name = end($tmp);
    $update = array(
        'file_name'=>$file_name,
        'id_doc'=>$_POST['doc_id'],
        'ocr_data'=>q($_POST['ocr_text']),
        'ocr_date'=>date("Y-m-d H:i:s"),
    );
    if(strlen($_POST['ocr_text']) > 3) {
        insert_update('documente_atasamente_data', $update, array('id_data'), array(), false);
    }
    die;
}
if(isset($_GET['process_file'])){
    $file_nameX = base64_decode($_GET['process_file']);
    $tmp = (explode('/',$file_nameX));
    $file_name = end($tmp);
    $id_doc = $_GET['doc_id'];
    set_time_limit(200);
    ini_set('max_execution_time', 0);
    error_reporting(0);
    $documente_atasamente_data = many_query("select * from documente_atasamente_data WHERE id_doc = '".floor($id_doc)."' and file_name = '".$file_name."' ");
    if(1 || strlen($documente_atasamente_data['ocr_data']) < 15){
       $remote_file = 'http://mydms.live/ocr/?'.(isset($_GET['pagina']) ? 'pagina='.$_GET['pagina'].'&':'').'process_file='.$_GET['process_file'];
       $ocr_data =  file_get_contents($remote_file);
    } else {
        $ocr_data = $documente_atasamente_data['ocr_data'];
    }
    echo nl2br($ocr_data);
    die;
    
}

if(isset($_POST['comanda_promovare'])){
    $old_status = $_POST['status'] == 0 ? 1 : 0;
   update_query("UPDATE `thf_facturi` SET `status` = '".$_POST['status']."' WHERE idvf = '".$_POST['idvf']."' and status = $old_status ");
}
if(isset($_POST['auto_save_promovare'])){
    $total = 0;
    $idf = $_POST['idf'];
    foreach ($promovari_db as $idp=>$promo){
        $copii = multiple_query("SELECT * FROM `promovari` WHERE parinte = $idp ",'idp');
        //  prea($copii);
        if(!count($copii)) {
            if (isset($_POST['select_' . $idp]) and $_POST['select_' . $idp] != '-1') {
                $repere [$idp]['denumire'] = $promovari_db[$idp]['nume_promovare'];
                $repere [$idp]['pret_unitar'] = $promovari_db[$idp]['pret_promovare'];
                $repere [$idp]['idp'] = $idp;
                $repere [$idp]['cantitatea'] = $_POST['select_' . $idp];
                $repere [$idp]['valoarea'] = $_POST['select_' . $idp] * $promovari_db[$idp]['pret_promovare'];
                $total += $repere [$idp]['valoarea'];
            }
        } else {
            foreach ($copii as $idp_copil=>$copil) {
                if ($_POST['select_' . $idp] == $idp_copil) {
                    $repere [$idp_copil]['denumire'] = $copil['nume_promovare'];
                    $repere [$idp_copil]['idp'] = $idp_copil;
                    $repere [$idp_copil]['pret_unitar'] = $copil['pret_promovare'];
                    $repere [$idp_copil]['cantitatea'] = $copil['variante'];
                    $repere [$idp_copil]['valoarea'] =$copil['variante'] * $copil['pret_promovare'];
                    $total += $repere [$idp_copil]['valoarea'];
                }
            }
        }
    }
    //prea($insert_update);   prea($_POST); prea($repere);
    $insert_update = array(
        'uid'=>$_POST['uid'],
        'id_asociatie'=>$_POST['id_asociatie'],
        'idvf'=>$_POST['idvf'],
        'repere'=>json_encode($repere),
        'valoarea'=>$total,
        'data'=>date("Y-m-d"),
    );

    if(is_numeric($idf) and $idf > 0){
        update_qa('thf_facturi',$insert_update," idf = '".$idf."' ");
    } else {
        if (count_query("SELECT COUNT(*) FROM `thf_facturi` WHERE idvf = '" . $_POST['idvf'] . "' and status = 0 ") == 0) {
            insert_qa("thf_facturi", $insert_update);
        } else {
            unset($insert_update['idvf']);
            update_qa('thf_facturi', $insert_update, " idvf = '" . $_POST['idvf'] . "' and status = 0 ");
        }
    }
    echo $total;
    die;
}
if($_POST['judet_id'] > 0 and is_numeric($_POST['judet_id'])){
    $loc = multiple_query("select * from localizare_localitati where parinte  = '".$_POST['judet_id']."' ");
    $localitati=array(""=>"Selecteaza localitatea");
    foreach ($loc as $k=>$v){
        $localitati[$v['id']]=$v['localitate'];
    }
    $localitati=array(""=>"Selecteaza localitatea") + $localitati;
    select_rolem('localitate_id','Localitate ',array(""=>"Neselectat") + $localitati,$adrese['localitate_id'],'Alege...',false,array());
    die;
}



