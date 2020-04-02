<?php
require_once('../config.php');

if(!$GLOBALS["login"]->is_logged_in()){redirect(303,LROOT.'login.php');}

if($user_id_login == $promovari[$_GET['idf']]['uid'] || $access_level_login>9){}
else { die('No access');}
$html = factura($_GET['idf'],true);
if(isset($_GET['view'])){
    die($html);
}

define('THF_PDF_TITLE','FACTURA PROFORMA nr. '.$_GET['idf']);
require_once('template_fisa.php');



