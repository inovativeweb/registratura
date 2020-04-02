<?php

require_login();

unset( $_SESSION[ 'cauta' ] );
unset( $_SESSION[ 'status' ] );
unset( $_SESSION[ 'sort' ] );
unset( $_SESSION[ 'localitate_id' ] );
unset( $_SESSION[ 'business_broker' ] );
unset( $_SESSION[ 'judet_id' ] );
unset( $_SESSION[ 'min' ] );
unset( $_SESSION[ 'max' ] );

//require_login();

// require_once(THF_CMS . 'login.php');
require_once( THF_PATH .'/afaceri/functions.php' );

//INSERT INTO `thf_server` (`var`, `value`, `group`) VALUES ('last_emag_data_page', '1533355770', 'site');


if ( isset( $_POST[ 'add_afacere' ] ) ) {
	$blanks=count_query("SELECT COUNT(*) as blanks FROM `vanzare` as vv
		LEFT JOIN companie as cc on vv.companie_vanzare=cc.id_companie
		WHERE LENGTH(vv.denumire_afacere)<1 AND vv.uid='".q($login_user)."'");
	if($blanks>0){
		echo one_query("SELECT vv.idv FROM `vanzare` as vv
		LEFT JOIN companie as cc on vv.companie_vanzare=cc.id_companie
		WHERE LENGTH(vv.denumire_afacere)<1 AND vv.uid='".q($login_user)."' LIMIT 1"); die;
	}
	
	$insert = array();
	$insertX = array();
	$insertIM = array();
	$adresa = array();
	$insertX[ 'tip_companie' ] = 'c';
	$insertX[ 'tip_f' ] = 'j';
	$insert[ 'companie_vanzare' ] = insert_qa( 'companie', $insertX );
	$insertX[ 'tip_companie' ] = 'r';
	$insertX[ 'tip_f' ] = 'f';
	$insert[ 'reprezentant_vanzare' ] = insert_qa( 'companie', $insertX );
	$insert[ 'uid' ] = $login_user;
    $insert[ 'idc_vanzator' ] = $_POST['idc'];
	
	$last_doc = insert_qa( 'vanzare', $insert );
	$insertIM[ 'idv' ] = $last_doc;
	// insert_qa( 'editare_im', $insertIM );
	insert_update('editare_im', $insertIM,$keys_to_exclude=array('id'),$setify_only_keys=array(),$return_query=false);

    if(is_numeric($_POST['id_forma']) and $_POST['id_forma'] > 0){
        update_query(" UPDATE `form_contact` SET `vanzator_asociat` = '".$last_doc."'  WHERE `form_contact`.`id` = '".$_POST['id_forma']."' LIMIT 1");
    }
	echo $last_doc;
	die;
}





if ( isset( $_POST[ 'delete_afacere' ] ) ) {
	$ids_to_delete=many_query("select companie_vanzare,reprezentant_vanzare,post_ro,post_en from vanzare where idv='".$_POST[ 'vanzator_id' ]."'");
	delete_query( 'delete from companie where id_companie="' . $ids_to_delete[ 'companie_vanzare' ] . '" and tip_companie="c"' );
	delete_query( 'delete from companie where id_companie="' . $ids_to_delete[ 'reprezentant_vanzare' ] . '" and tip_companie="r"' );
	delete_query( 'delete from vanzare where idv="' . $_POST[ 'vanzator_id' ] . '"' );
	delete_query( 'delete from editare_im where idv="' . $_POST[ 'vanzator_id' ] . '"' );
	thfQsdb('r53562busi_TradeX');
	update_query("UPDATE `wp_posts` SET `post_status`='draft' WHERE ID='".$ids_to_delete['post_ro']."' or ID='".$ids_to_delete['post_en']."'");
	thfQsdb('r53562busi_brokers'); //select database app
	die();
}



$sort = array(
	'data_publicare DESC' => 'Data publicare',
	'denumire ASC' => 'Denumire alfabetic',
);


$results_per_page = 50;
$curent_page = isset( $_REQUEST[ 'pag' ] ) ? floor( $_REQUEST[ 'pag' ] ) : 1;


$tabel = 'vanzare';

$vanzare = ( tableFieldsListWildcard( $tabel, '', '', array( 'json' ) ) );
$companie = ( tableFieldsListWildcard( 'companie', '', '', array( 'json' ) ) );
$loc = (tableFieldsListWildcard('localizare_localitati','','',array('id')));
$jud = (tableFieldsListWildcard('localizare_judete','','',array('id')));
//search in all fields
$concatWs = " CONCAT_WS(' ', " . $vanzare . ', ' . $companie.', '.$jud .', '.$loc. ") ";

$search_words = array();
$search_sql = '';
$where_sql = '';


if ( isset( $_GET[ 'reset' ] ) ) {
	//session_destroy();    unset($_SESSION);
	unset( $_SESSION[ 'cauta' ], $_SESSION[ 'status' ], $_SESSION[ 'sort' ], $_SESSION[ 'tip' ], $_SESSION[ 'domeniu_activitate' ], $_SESSION[ 'judet_id' ], $_SESSION[ 'localitate_id' ], $_SESSION[ 'business_broker' ], $_SESSION[ 'min' ], $_SESSION[ 'max' ] );
	redirect( 302, ROOT . 'afaceri/' );
}



///session

if ( isset( $_SESSION[ 'cauta' ] )and!isset( $_REQUEST[ 'cauta' ] ) ) {
	$_REQUEST[ 'cauta' ] = $_SESSION[ 'cauta' ];
} else {
	unset( $_SESSION[ 'cauta' ] );
}
if ( isset( $_SESSION[ 'status' ] )and!isset( $_REQUEST[ 'status' ] ) ) {
	$_REQUEST[ 'status' ] = $_SESSION[ 'status' ];
} else {
	unset( $_SESSION[ 'status' ] );
}
if ( isset( $_SESSION[ 'sort' ] )and!isset( $_REQUEST[ 'sort' ] ) ) {
	$_REQUEST[ 'sort' ] = $_SESSION[ 'sort' ];
} else {
	unset( $_SESSION[ 'sort' ] );
}
if(isset($_SESSION['domeniu_activitate']) and !isset($_REQUEST['domeniu_activitate'])){ 
$_REQUEST['domeniu_activitate'] = $_SESSION['domeniu_activitate'];
}
else {unset($_SESSION['domeniu_activitate']);}
if(isset($_SESSION['judet_id']) and !isset($_REQUEST['judet_id'])){ $_REQUEST['judet_id'] = $_SESSION['judet_id'];}
else {unset($_SESSION['judet_id']);}
if(isset($_SESSION['localitate_id']) and !isset($_REQUEST['localitate_id'])){ $_REQUEST['localitate_id'] = $_SESSION['localitate_id'];}
else {unset($_SESSION['localitate_id']);}
if(isset($_SESSION['business_broker']) and !isset($_REQUEST['business_broker'])){ $_REQUEST['business_broker'] = $_SESSION['business_broker'];}
else {unset($_SESSION['business_broker']);}

if ( isset( $_SESSION[ 'min' ] )and!isset( $_REQUEST[ 'min' ] ) ) {
	$_REQUEST[ 'min' ] = $_SESSION[ 'min' ];
} else {
	unset( $_SESSION[ 'min' ] );
}
////

if ( isset( $_REQUEST[ 'cauta' ] )and $_REQUEST[ 'cauta' ]and strlen( trim( $_REQUEST[ 'cauta' ] ) ) ) {
	foreach ( explode( ' ', $_REQUEST[ 'cauta' ] ) as $word ) {
		if ( strlen( $word ) > 0 ) {
			$search_words[] = $word;
		}
	}
	$_SESSION[ 'cauta' ] = $_REQUEST[ 'cauta' ];
}
foreach ( $search_words as $word ) {
	$search_sql .= ( $search_sql ? " AND " : "" ) . ( $concatWs . "LIKE '%" . q( $word ) . "%'   " );
}
$search_sql = ( $search_sql ? " ( \r\n $search_sql \r\n ) " : "" );

$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . $search_sql;


if ( isset( $_REQUEST[ 'sort' ] ) && strlen( $_REQUEST[ 'sort' ] ) ) {
	$status = urldecode( $_REQUEST[ 'sort' ] );
	if ( strlen( $status ) < 5 ) {
		$status = " idv DESC";
	}
	if ( 1 ) {
		$order = " ORDER BY $status  ";
	}
	$_SESSION[ 'sort' ] = $status;
}

if ( isset( $_REQUEST[ 'status' ] ) && is_numeric( $_REQUEST[ 'status' ] ) ) {
	if ( $_REQUEST[ 'status' ] >= 0 ) {
		$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . " status ='" . q( $_REQUEST[ 'status' ] ) . "'";
	}
	$_SESSION[ 'status' ] = $_REQUEST[ 'status' ];
}



if(isset($_REQUEST['judet_id']) && is_numeric($_REQUEST['judet_id'])){
  if ($_REQUEST['judet_id']>0)
  {
   if($_REQUEST['judet_id']!="") {
       $where_sql .= ($where_sql ? "\r\r AND " : "") . " judet_id ='" . q($_REQUEST['judet_id']) . "'";
    }
    $_SESSION['judet_id'] = $_REQUEST['judet_id'];
}	
 }
  
if(isset($_REQUEST['localitate_id']) && is_numeric($_REQUEST['localitate_id'])){
  if ($_REQUEST['localitate_id']>0)
  {
 
    if($_REQUEST['localitate_id']!="") {
       $where_sql .= ($where_sql ? "\r\r AND " : "") . " localitate_id ='" . q($_REQUEST['localitate_id']) . "'";
    }
    $_SESSION['localitate_id'] = $_REQUEST['localitate_id'];
}	
 }	
  
if(isset($_REQUEST['business_broker']) && is_numeric($_REQUEST['business_broker'])){
  if ($_REQUEST['business_broker']>0)
  {
 
    if($_REQUEST['business_broker']!="") {
       $where_sql .= ($where_sql ? "\r\r AND " : "") . " uid ='" . q($_REQUEST['business_broker']) . "'";
    }
    $_SESSION['business_broker'] = $_REQUEST['business_broker'];
}	
 }	
 
if(isset($_REQUEST['min']) && is_numeric($_REQUEST['min'])){
  if ($_REQUEST['min']>0)
  {
 
    if($_REQUEST['min']!="") {
       $where_sql .= ($where_sql ? "\r\r AND " : "") . " pret_vanzare >=" . q($_REQUEST['min']) . "";
    }
    $_SESSION['min'] = $_REQUEST['min'];
}	
 }	

if(isset($_REQUEST['max']) && is_numeric($_REQUEST['max'])){
  if ($_REQUEST['max']>0)
  {
 
    if($_REQUEST['max']!="") {
       $where_sql .= ($where_sql ? "\r\r AND " : "") . " pret_vanzare <=" . q($_REQUEST['max']) . "";
    }
    $_SESSION['max'] = $_REQUEST['max'];
}	
 }	


if ( isset( $_REQUEST[ 'tip' ] ) && !is_numeric( $_REQUEST[ 'tip' ] ) ) {
	$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . " tip ='" . q( $_REQUEST[ 'tip' ] ) . "'";
	$_SESSION[ 'tip' ] = $_REQUEST[ 'tip' ];
}

if ($GLOBALS['index_head'])
{
    	$where_sql .= ($where_sql ? "\r\r AND " : "") . " idc_vanzator ='".$_GET['edit']."' ";
}
else
    {
      //  $where_sql .= ($where_sql ? "\r\r AND " : "") . " idc_vanzator ='0'";

    }


$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . " ".($access_level_login>9?'1':" ( uid ='" . $user_id_login . "' OR vanzare.status = 3  ".($access_level_login == 2 ? " OR uid IN (".floor($asoc_in).")" : "" )." ".($access_level_login == 3 ? " OR uid IN (".floor($asoc_in_filiale).")" : "" )." ) ");

$where_sql = ( $where_sql ?
	"\r\n WHERE " . $where_sql . " " :
	" WHERE   1 " );
$order = ( strlen( $order ) ? $order : ' ORDER BY idv DESC' );

$count_sql = "SELECT COUNT(*) as cnt FROM `$tabel` 
            LEFT JOIN companie ON id_companie = companie_vanzare  
             LEFT JOIN localizare_localitati ON companie.localitate_id = localizare_localitati.`id`
             LEFT JOIN localizare_judete on companie.judet_id = localizare_judete.`id`
                  $where_sql ";

$total_results = floor( count_query( $count_sql ) );
$nb_pages = ceil( $total_results / $results_per_page );
$nb_pages = ( $nb_pages < 1 ? 1 : $nb_pages );
$curent_page = min( $curent_page, $nb_pages ); //switch page failsafe if overbuffer

 $select_sql_id_prd = "SELECT * FROM `$tabel` 
        LEFT JOIN companie ON id_companie = companie_vanzare 
        LEFT JOIN localizare_localitati ON companie.localitate_id = localizare_localitati.`id`
        LEFT JOIN localizare_judete on companie.judet_id = localizare_judete.`id`
$where_sql " . q( $order ) . " " . thf_paginate_limit_sql( $total_results, $curent_page, $results_per_page );

$data_documente = multiple_query( $select_sql_id_prd, 'idv' );


foreach ($data_documente as $k=>$r) {

	if (isset($_REQUEST['domeniu_activitate']) && is_numeric($_REQUEST['domeniu_activitate'])) {
		if ($_REQUEST['domeniu_activitate'] >= 0) {
			$tmp_domeniu = explode(',',$r['domeniu_activitate']);
			if(!in_array($_REQUEST['domeniu_activitate'],$tmp_domeniu)){
				unset($data_documente[$k]);
			}
			//$where_sql .= ($where_sql ? "\r\r AND " : "") . " domeniu_activitate ='" . q($_REQUEST['domeniu_activitate']) . "'";
		}
	}
}
$_SESSION['domeniu_activitate'] = $_REQUEST['domeniu_activitate'];
//*---------------------
$domenii_afacereX=array();
$judeteXX=array();
$localitatiXX=array();
foreach ($data_documente as $k=>$r){
    $rezultate_vanzare[] = $k;
	if(substr_count($r['domeniu_activitate'],',')){
		$tmp_domenii = explode(',',$r['domeniu_activitate']);
		foreach ($tmp_domenii as $dd=>$d){
			$domenii_afacereX[$d]=$d ;
		}
	} else {
		$domenii_afacereX[$r['domeniu_activitate']]=$r['domeniu_activitate'];
	}


    $localitatiXX[$r['localitate_id']]=$r['localitate_id'];
    $judeteXX[$r['judet_id']]=$r['judet_id'];

}

$filtre['domenii_afacere'] =array_intersect_key($domenii_afacere,$domenii_afacereX);
$filtre['judete'] =array_intersect_key($judete,$judeteXX);
$filtre['localitati'] =array_intersect_key($localitati,$localitatiXX);
//--------------------------
if(0) {
	prea($domenii_afacereX);
	prea($domenii_afacere);
	prea($filtre['domenii_afacere']);
	prea($contor_domenii);
}

$contor_judete=array();
$contor_localitati=array();
$contor_domenii=array();
foreach($data_documente as $r){
	@$contor_judete[$r['judet_id']]++;
	@$contor_localitati[$r['localitate_id']]++;
	$tmp_domenii = explode(',',$r['domeniu_activitate']);
	foreach ($tmp_domenii as $dd=>$d){
		@$contor_domenii[$d]++;
	}

}

foreach($contor_judete as $jid=>$nr){
	if(!$jid){continue;}
	$filtre['judete'][$jid].=' ('.$nr.')';
}
foreach($contor_localitati as $jid=>$nr){
	if(!$jid){continue;}
	$filtre['localitati'][$jid].=' ('.$nr.')';
}
foreach($contor_domenii as $jidx=>$nr){
	if(!$jidx){continue;}
	if(substr_count($jidx,',')){
		$tmp_domenii = explode(',',$jidx);
		foreach ($tmp_domenii as $dd=>$d){
			//$domenii_afacereX[$d]=$d;

			$filtre['domenii_afacere'][$d] .=' ('.$nr.')';
			if(!isset($filtre['domenii_afacere'][$d])) {
				//$filtre['domenii_afacere'][$d] .= ' (' . $d . ')';
			}
		}
	} else {
		$filtre['domenii_afacere'][$jidx] .=' ('.$nr.')';
	}

	//$filtre['domenii_afacere'][$jidx].=' ('.$nr.')';
}



if(0) {
	prea($domenii_afacereX);
	prea($domenii_afacere);
	prea($filtre['domenii_afacere']);
	prea($contor_domenii);
}


$page_details = array(
	'curent_page' => $curent_page,
	'total_results' => $total_results,
	//'sql' => $select_sql_id_prd,
	'sql' =>'',
	'nb_pages' => $nb_pages,
	'resultate_id_vanzare' => $rezultate_vanzare,
	'results_per_page' => $results_per_page,
);


if ( isset( $_REQUEST[ 'print' ] ) ) { //call ajax data

   // json_encode_header( $page_details, 1 );
}

if ( isset( $_REQUEST[ 'ajax' ] ) ) { //call ajax data
	ob_start();
	list_documente( $data_documente );
	$page_details[ 'table' ] = ob_get_contents();
	ob_end_clean();
	json_encode_header( $page_details, 1 );
}

