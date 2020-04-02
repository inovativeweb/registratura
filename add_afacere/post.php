<?php
require ('../config.php');

//==================TEASER===============================



if(isset($_POST['change_desc_teaser'])){
    $selected_lng=$_POST['change_desc_teaser'];//$teaser[$selected_lng]
    echo show_teaser($selected_lng,$_POST['vanzare_edit']);
    die;
} else {
    $selected_lng='en';//$teaser[$selected_lng]
}
//==================TEASER===============================

if($_POST['judet_id'] > 0 and is_numeric($_POST['judet_id'])){
    $loc = multiple_query("select * from localizare_localitati where parinte  = '".$_POST['judet_id']."' ");
    $localitati=array(""=>"Selecteaza localitatea");
    foreach ($loc as $k=>$v){
        $localitati[$v['id']]=$v['localitate'];
    }
    $localitati=array(""=>"Selecteaza judet") + $localitati; 
    select_rolem('localitate_id','Localitate ',$localitati,$adrese['localitate_id'],'Alege...',false,array());
    die;
}


