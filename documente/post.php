<?php
require_once('../config.php');
//require (THF_PATH . 'cumparatori/controller.php');
require (__DIR__. '/controller.php');


if ( isset( $_POST[ 'action_template' ] ) ) {
    $oldx = many_query("SELECT * FROM `documente_propietati` WHERE id_doc = '". $_POST[ 'id_doc' ] ."' AND valoare = '".$_POST[ 'id_template' ]."' and cheie = 'template_doc_iesire' ") ;
    $insert_template_doc_iesire = array(
        'id_doc' => $_POST[ 'id_doc' ],
        'cheie' => 'template_doc_iesire',
        'json' => q(contract_template($_POST[ 'id_doc' ],$_POST[ 'id_template' ])),
        'valoare' => $_POST[ 'id_template' ],
    );
    if($_POST[ 'action_template' ] == 'delete'){
        delete_query("DELETE FROM `documente_propietati` WHERE id_doc = '". $_POST[ 'id_doc' ] ."' AND valoare = '".$_POST[ 'id_template' ]."' and cheie = 'template_doc_iesire' ");
    }  if($_POST[ 'action_template' ] == 'add') {
        if (!is_numeric($oldx['idp'])) {
            insert_qa('documente_propietati', $insert_template_doc_iesire);
        } else {
            update_qa("documente_propietati", $insert_template_doc_iesire, " idp= '" . $oldx['idp'] . "' ");
        }
    }
    echo list_doc_templates($_POST[ 'id_doc' ]);
    die;
}

if(count($_POST)) {
    if (isset($_POST['document_edit_insert'])) {
        $data = array(); $data['document_iesire'] = array();
        parse_str($_POST['expeditor'],$data['expeditor']);
        parse_str($_POST['destinatar'],$data['destinatar']);
        parse_str($_POST['companie_destinatar'],$data['companie_destinatar']);
        parse_str($_POST['companie_expeditor'],$data['companie_expeditor']);
        parse_str($_POST['document_edit_insert'],$data['document_edit_insert']);

        parse_str($_POST['continut_document_data'],$data['continut_document_data']);
        if(isset($_POST['document_iesire'])) {
            foreach ($_POST['document_iesire'] as $k => $parse) {
                parse_str($parse, $data['document_iesire'][]);
            }
        }

        $_POST['idd'] = $doc_id = $_GET['edit'];

        update_qa('documente', $data['document_edit_insert'], " idd = $doc_id ", ' limit 1');
        
        insert_update('locuitori', $data['expeditor'],array('idl'), array(), false);
        $data['expeditor']['idl'] = $idl_expeditor = one_query("SELECT idl  FROM locuitori WHERE cnp = '".$data['expeditor']['cnp']."' ");


        insert_update('locuitori', $data['destinatar'], array('idl'), array(), false);
        $data['destinatar']['idl'] = $idl_destinatar = one_query("SELECT idl  FROM locuitori WHERE cnp = '".$data['destinatar']['cnp']."' ");


        if(strlen($data['companie_expeditor']['denumire'])) {
            insert_update('companie', $data['companie_expeditor'], array('id_companie'), array(), false);
            $data['companie_expeditor']['id_companie'] =  $idc_companie_expeditor = one_query("SELECT id_companie  FROM companie WHERE cui = '".$data['companie_expeditor']['cui']."' ");
        }
        if(strlen($data['companie_destinatar']['denumire'])) {
            insert_update('companie', $data['companie_destinatar'], array('id_companie'), array(), false);
            $data['companie_destinatar']['id_companie'] = $idc_companie_destinatar = one_query("SELECT id_companie  FROM companie WHERE cui = '".$data['companie_destinatar']['cui']."' ");
        }


     //   delete_query("DELETE FROM `documente_propietati` WHERE `documente_propietati`.`id_doc` = $doc_id ");
        $insert_propietati_expeditor = array(
            'id_doc' => $doc_id,
            'cheie' => 'expeditor',
            'json' => json_encode($data['expeditor']),
            'valoare' => $idl_expeditor,
        );
        insert_update('documente_propietati', $insert_propietati_expeditor,array('idp'),array(),false);
        $insert_propietati_destinatar = array(
            'id_doc' => $doc_id,
            'cheie' => 'destinatar',
            'json' => json_encode($data['destinatar']),
            'valoare' => $idl_destinatar,
        );
        insert_update('documente_propietati', $insert_propietati_destinatar,array('idp'),array(),false);
        $insert_companie_expeditor= array(
            'id_doc' => $doc_id,
            'cheie' => 'companie_expeditor',
            'json' => json_encode($data['companie_expeditor']),
            'valoare' => $idc_companie_expeditor,
        );
        insert_update('documente_propietati', $insert_companie_expeditor,array('idp'),array(),false);
        $insert_companie_destinatar = array(
            'id_doc' => $doc_id,
            'cheie' => 'companie_destinatar',
            'json' => json_encode($data['companie_destinatar']),
            'valoare' => $idc_companie_destinatar,
        );
        insert_update('documente_propietati', $insert_companie_destinatar,array('idp'),array(),false);

        $insert_continut_document = array(
            'id_doc' => $doc_id,
            'cheie' => 'continut_document',
            'json' => q($data['continut_document_data']['continut_document']),
            'valoare' => '',
        );
        insert_update('documente_propietati', $insert_continut_document,array('idp'),array(),false);

        $insert_continut_document_ocr = array(
            'id_doc' => $doc_id,
            'cheie' => 'continut_document_ocr',
            'json' => q($data['continut_document_data']['descriere_publica']),
            'valoare' => '',
        );
        insert_update('documente_propietati', $insert_continut_document_ocr,array('idp'),array(),false);

        foreach ( $data['document_iesire'] as $k=>$val) {
            $insert_document_iesire = array(
                'id_doc' => $doc_id,
                'cheie' => 'template_doc_iesire',
                'json' => q($val['text_documente_template']),
                'valoare' => $val['id_template'],
            );
            insert_update('documente_propietati', $insert_document_iesire,array('idp'),array(),false);
        }

       //  ThfAjax::redirect('r'); //reload
        //  ThfAjax::redirect('R'); //reload+clear chache
        // ThfAjax::redirect('/afaceri/index.php'); //reload+clear chache
        ThfAjax::status(true, 'Salvat');
        ThfAjax::json();
    }

}




if(isset($_POST['alocat_la'])){
        $insert = array(
            'id_doc'=>$pid,
            'id_user'=>$login_user,
            'id_alocat'=>$_POST['alocat_la'],
            'status_istoric'=>$_POST['status'],
            'data_doc'=>$document['data_doc'],
            'html'=>get_document_data($pid)['continut_document'],
            'template_doc_iesire'=>json_encode(get_document_data($pid)['documente_iesire']),
            'atasamente'=>$document['atasamente'],
            'tip'=>$document['tip_doc'],
        );
        insert_qa('documente_istoric',$insert);
    ThfAjax::status(true, 'Document alocat!');
    ThfAjax::json();

}

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



if ( isset( $_POST[ 'delete_cumparator' ] ) ) {
	delete_query( 'delete from documente where idd="' . $_POST[ 'cumparator_id' ] . '"' );
	die();
}


if ( count( $_POST ) || $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) { //prea($_FILES);	prea($_POST); die;
    ThfAjax::$out[ 'show_time' ] = 2000;
//    $tablename = 'cumparatori';
  //  prea($documente);
    ThfGalleryEditor::$database_pics = ( is_numeric( $pid ) && $pid > 0 ? json_decode( $documente[$pid][ ThfGalleryEditor::$coloana_upload ], true ) : array() ); //load existing stored pictures
    ThfGalleryEditor::actionFileController(); //unlinks files fron the drive and updates ThfGalleryEditor::$database_pics
    ThfGalleryEditor_ury::uploadController_ury();
    //    ThfGalleryEditor::resize_uploaded_pics($resize_policy,$remove_original_pic=false);

    $_POST[ ThfGalleryEditor::$coloana_upload ] = json_encode( array_merge( ThfGalleryEditor::$database_pics, ThfGalleryEditor::$new_pics ) );


    ///!!!!!!!!!	SUPRASCRIS DE	isset( $_POST[ 'edit_vanzare' ])
    /////!!!!! RAMANE IN CAZ GENERAL SI PT UPLOAD FILE
    if ( is_numeric( $pid ) ) { //update
        update_qaf( $tablename, $_POST, "`idd`='$pid'", 'LIMIT 1', $setify_only_keys = array(), $return_query = false );
                // prea(ThfGalleryEditor::$coloana_upload ); prea( ThfGalleryEditor::$database_pics ); prea($pid);prea($tablename);prea($_POST); die;
        ThfAjax::status( true, 'Salvat cu succes!' );
        if ( count( $_POST ) > 2 ) {
            ThfAjax::redirect( '?edit=' . $pid );
        }
        //		redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.floor($pid));
    } elseif ( $pid == 'i' ) { //insert
        //$_POST['poze']=json_encode(ThfGalleryEditor::$new_pics);
        $id = insert_qa( $tablename, $_POST, array( 'idd' ) );
        ThfAjax::status( true, 'Inserted successfully!' );
        ThfAjax::redirect( '?edit=' . $id );
        //redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.$id);
    }
    ThfAjax::json(); //generate upload report

}



