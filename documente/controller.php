<?php
require_login();
$has_controller = true;
require (THF_PATH . '/documente/functions.php');

$pid = floor( $_REQUEST[ 'edit' ] ? $_REQUEST[ 'edit' ] : $_REQUEST[ 'doc_id' ] );

$document = many_query("SELECT * FROM `documente` WHERE idd = '".floor($pid)."' ");
$nr_atasamente = count(json_decode($document['atasamente']),true);
$expeditori = get_document_data($pid)['expeditor'];
$destinatari = get_document_data($pid)['destinatar'];
$companie_destinatar = get_document_data($pid)['companie_destinatar'];
$companie_expeditor = get_document_data($pid)['companie_expeditor'];
$documente_iesire = get_document_data($pid)['documente_iesire'];
$document_istoric = many_query("SELECT * FROM documente_istoric WHERE id_doc = '".floor($pid)."' order by idi DESC");

$template_uri_doc_iesire = multiple_query("SELECT * FROM `template_contracte` ");
foreach ($template_uri_doc_iesire as $k=>$v){
    $template_uri_doc_iesire_select[$v['id']] = $v['nume_contract'];
}

$tip_documente = multiple_query("SELECT * FROM `definitii` WHERE cheie = 'tip_document'");
$tip_documente_select['']='Tip nedefinit';
foreach ($tip_documente as $k=>$v){
    $tip_documente_select[$v['tip']] = $v['tip'];
}

if ( isset( $_POST[ 'get_full_name' ] ) ) {
    $emails = multiple_query("SELECT * FROM `locuitori`  WHERE fullname LIKE '%". $_POST[ 'get_full_name' ]."%' ");
    foreach ($emails as $k=>$v){
        $icon = $v['id_organigrama'] < 1 ? '<i class="circular green user  icon"></i>'.'('.$v['cnp'].' )' :
                        '<i class="circular purple laravel  icon"></i>'.'('.$organigrame_all[$v['id_organigrama']]['functie'].')';
        echo ' <li onclick="fill_locuitor_data('.$v['idl'].',this)" class="list-group-item ul_list_search">'.$v['fullname'].' '.$icon.'</li>';
    }
    die;
}


if ( isset( $_POST[ 'add_cumparator_display' ] ) ) {
    expeditor_destinatar_edit_insert(array(),"1",'adauga_cumparator', 'Date expeditor');
	die();
	}
if ( isset( $_POST[ 'add_document' ] ) ) {
	$insert = array();
	$insert[ 'preluat_de' ] = $login_user;
	$insert[ 'uid' ] = $login_user;
	$insert[ 'data_doc' ] = date("Y-m-d");
	$insert[ 'data_creat' ] = date("Y-m-d H:i:s");
	$id_doc = insert_qa( 'documente', $insert );
	insert_qa('documente_istoric',array('id_doc'=>$id_doc,'id_user'=>$login_user));
	echo $id_doc;
	die;
}

if (isset( $_POST[ 'get_locuitor_data' ] ))
{
    expeditor_destinatar_edit_insert($locuitori_all[$_POST[ 'get_locuitor_data' ]],"1",$_POST['formtype'], $_POST['formname']);
	die();
}




//////uploader si salvare generala in tabel vanzare:

$tablename = 'documente'; //pt upload
ThfGalleryEditor::$ajax_upload = true;
ThfGalleryEditor::$max_files = 10;
ThfGalleryEditor::$accept = 'jpg|jpeg|png|pdf|txt|doc|docx|xls|xlsx';
ThfGalleryEditor::$web_path=UPLfOAD.'documente/';
ThfGalleryEditor::$sv_path=THF_ROOT.UPLOAD.'documente/';

ThfGalleryEditor::$file_name_policy = '*f*';
ThfGalleryEditor::$overwritePolicy = 'r';
ThfGalleryEditor::$coloana_upload='atasamente'; 
ThfGalleryEditor::$id = floor( $pid ); //specifica ce id are produsul pentru a putea urca asincron poze si file
////3333333


ThfGalleryEditor::$layout = array(
    'container_class' => 'container-fluid',
    'row_class' => 'colpadsm',
    //'row_class'=>'sortableRowConnected colpadsm',
    'col_class' => 'col-xs-12',
    'img_wrap_class' => 'CoverRatio4_3',
    'file_wrap_class' => 'ThfGalleryFileWrap',
    'img_class' => 'img-thumbnail',
    'remove_class' => 'ThfGalleryEditorRemove',
);





$results_per_page=30;
$curent_page=isset($_REQUEST['pag'])?floor($_REQUEST['pag']):1;

$tabel='documente';
//$cumparatori = (tableFieldsListWildcard($tabel,'','',array('json')));
$cumparatori_search = (tableFieldsListWildcard($tabel,'','',array('idd')));
//$loc = (tableFieldsListWildcard('localizare_localitati','','',array('id')));
//$jud = (tableFieldsListWildcard('localizare_judete','','',array('id')));
//search in all fields
$concatWs = " CONCAT_WS(' ', " . $cumparatori_search . ','.$jud .', '.$loc. ") ";
$concatWs = " CONCAT_WS(' ', " . $cumparatori_search . ") ";



$search_words=array(); $search_sql='';
$where_sql="";





///session

if(isset($_SESSION['cauta']) and !isset($_REQUEST['cauta'])){ $_REQUEST['cauta'] = $_SESSION['cauta'];}
else {unset($_SESSION['cauta']);}



////

if(isset($_REQUEST['cauta'])  and $_REQUEST['cauta'] and strlen(trim($_REQUEST['cauta']))){
    foreach(explode(' ',$_REQUEST['cauta']) as $word){
        if(strlen($word)>0){$search_words[] = $word;  }
    }
        $_SESSION['cauta'] = $_REQUEST['cauta'];
}

foreach($search_words as $word){
    $search_sql.=($search_sql?" AND ":"").( $concatWs."LIKE '%".q($word)."%'   " );
}

$search_sql=($search_sql?" ( \r\n $search_sql \r\n ) ":"");

$where_sql.=($where_sql?"\r\r AND " :"").$search_sql;



 $where_sql=($where_sql             ?
    "\r\n WHERE ".$where_sql ." "
                                     :
    " WHERE   1 ");
$order_cump = (strlen($order_cump) ? $order_cump : ' ORDER BY idd DESC');

    $count_sql = "SELECT COUNT(*) as cnt FROM `$tabel` 
                   
                $where_sql ";

    $total_results=floor(count_query($count_sql));
$nb_pages=ceil($total_results/$results_per_page); $nb_pages=($nb_pages<1?1:$nb_pages);
$curent_page=min($curent_page,$nb_pages); //switch page failsafe if overbuffer

  $select_sql_id_prd="SELECT * FROM `documente` 
                    $where_sql ".q($order_cump)." ".thf_paginate_limit_sql($total_results,$curent_page,$results_per_page);

$date_cumparatori=multiple_query($select_sql_id_prd,'idd');


$page_details=array(
    'curent_page'=>$curent_page,
    'total_results'=>$total_results,
    'sql'=>$select_sql_id_prd,
    'nb_pages'=>$nb_pages,
    'results_per_page'=>$results_per_page,
);


if(isset($_REQUEST['search_cump'])){ //call ajax data
    ob_start();

    list_documente($date_cumparatori);
    $page_details['table']=ob_get_contents();
    ob_end_clean();
    json_encode_header($page_details,1);
}

