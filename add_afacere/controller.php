<?php

if (isset($_POST['idv_new']) and $_POST['idv_new']>0) $_GET['edit']=$_POST['idv_new'];

if ($_GET['edit']>0){
	$vanzare = $vanzari_all[ $_GET[ 'edit' ] ] or die('No access');		
	}

$editare_im = $editIM[ $_GET[ 'edit' ] ];
$pid = floor( $_GET[ 'edit' ] ); // 333
$check_list=multiple_query("SELECT * FROM `ckeck_list` where idc='".$_GET['edit']."'",'qid');



if ( isset( $_POST[ 'promoveaza' ] )and is_numeric( $_POST[ 'idv' ] ) ) {
    if($_POST['promovat_until'] == 'on'){
        $_POST['promovat_until'] = date("Y-m-d",strtotime('+6 months'));
    } else {
        $_POST['promovat_until'] = '0000-00-00';
    }
    $insert = array(
        'id_asociatie'=>$asoc_id_login,
        'data'=> $_POST['promovat_until'],
        'valoarea'=>$valoare_promovare,
        'uid'=>$user_id_login,
        'idvf'=>$_POST[ 'idv' ],
    );
    delete_query("DELETE FROM `thf_facturi` WHERE `thf_facturi`.`idvf` = '".floor($_POST[ 'idv' ])."' ");
    $idf = insert_qa('thf_facturi',$insert);

    $html = factura($idf,true);
    generate_pdf($html,$title = NULL,$save_pdf = true,$idf);

    update_query("UPDATE vanzare SET `promovat_until` = '".q($_POST[ 'promovat_until' ])."' WHERE `vanzare`.`idv` = '".q($_POST[ 'idv' ])."';");

    ThfAjax::status( true, 'Salvat' );
    ThfAjax::json();

}

if ( isset( $_POST[ 'change_status' ] ) and is_numeric( $_POST[ 'change_status' ] ) and $_POST[ 'idv' ] ) {
	if($_POST[ 'change_status' ]>0 && $_POST[ 'change_status' ]<2){
	//	send_mail_vanzare_asteapta_publicare($_POST[ 'idv' ]);
	}
    $data_publicare = $_POST[ 'change_status' ]==3 ? ", `data_publicare` =  '" . date("Y-m-d H:i:s") ."'" : ", `data_publicare` =  NULL ";
   update_query("UPDATE vanzare SET `status` = '".floor($_POST[ 'change_status' ])."' ".$data_publicare.  " WHERE `vanzare`.`idv` = '".q($_POST[ 'idv' ])."';");
   export_vanzare_to_wp($_POST[ 'idv' ]);
    ThfAjax::status( true, 'Status salvat' );
    ThfAjax::json();
}

if ( isset( $_POST[ 'business_broker' ] )and is_numeric( $_POST[ 'business_broker' ] ) ) {
    update_query("UPDATE vanzare SET `uid` = '".floor($_POST[ 'business_broker' ])."' WHERE `vanzare`.`idv` = '".q($_POST[ 'idv' ])."';");
    ThfAjax::status( true, 'Salvat' );
    ThfAjax::json();
}


if ( isset( $_POST[ 'percent_step' ] ) and is_array( $_POST[ 'percent_step' ] )  ) { //vanzare
	//prea($_POST[ 'percent_step' ]);die;
	
	update_qaf( 'vanzare', array('procente'=>json_encode($_POST[ 'percent_step' ])), '`idv`=' . @floor( $_GET[ 'edit' ] ), 'LIMIT 1' );
	ThfAjax::status( true, 'Procente salvate cu succes!' );
	ThfAjax::json();
}


if ( isset( $_POST[ 'edit_companie' ] )and is_numeric( $_POST[ 'edit_companie' ] ) ) { //companii



	update_qaf( 'companie', $_POST, '`id_companie`=' . @floor( $_POST[ 'edit_companie' ] ), 'LIMIT 1' );
	ThfAjax::status( true, 'Statusul salvat cu succes!' );
	ThfAjax::json();

}


if(isset($_POST['edit_cumparator_vanz']) ){  //companii

	if ($_POST['edit_cumparator_vanz']=="" || $_POST['edit_cumparator_vanz']==0){
			
			$insert = array();
			$insert[ 'business_broker' ] = $login_user;
			$insert[ 'uid' ] = $login_user;
			$insert['idv_cumparator']=$_GET['edit'];
			$insert[ 'create_date' ] = date("Y-m-d H:i:s");
			$cump_id = insert_qa( 'cumparatori', $insert );
			$_POST['edit_cumparator_vanz']=$cump_id;
		}
    update_qaf('cumparatori', $_POST, '`idc`=' . @floor($_POST['edit_cumparator_vanz']), 'LIMIT 1');
  //  ThfAjax::redirect('r'); //reload
  //  ThfAjax::redirect('R'); //reload+clear chache
   // ThfAjax::redirect('/afaceri/index.php'); //reload+clear chache
 
    ThfAjax::status(true,'Salvat');
    ThfAjax::json();
}

if ( isset( $_POST[ 'edit_vanzare_checklist' ] )and is_numeric( $_POST[ 'edit_vanzare_checklist' ] ) ) { //
    foreach ($ckeck_list_text as $k=>$value){
        $a=array("idc"=>$_POST['edit_vanzare_checklist'],"qid"=>$k,"se_aplica"=>$_POST['q_'.$k],"actiune"=>$_POST['action_'.$k]);

        $query=insert_update2("ckeck_list",$a,array('id'),array(),false);
    }


}
if ( isset( $_POST[ 'edit_vanzare' ] )and is_numeric( $_POST[ 'edit_vanzare' ] ) ) { //companii
    //prea($_POST['promovat_imobiliare']); die;

    if(!isset($_POST['promovat_imobiliare'])){ $_POST['promovat_imobiliare'] = 0;}
	if(isset($_POST['domeniu_activitate']) && is_array($_POST['domeniu_activitate'])){
		$_POST['domeniu_activitate']=implode(',',$_POST['domeniu_activitate']);//multiple select
	}
    if(isset($_POST['utilitati']) && is_array($_POST['utilitati'])){
		$_POST['utilitati']=implode(',',$_POST['utilitati']);//multiple select
	}
	if(isset($_POST['dotari']) && is_array($_POST['dotari'])){
		$_POST['dotari']=implode(',',$_POST['dotari']);//multiple select
	}
	if(isset($_POST['servicii']) && is_array($_POST['servicii'])){
		$_POST['servicii']=implode(',',$_POST['servicii']);//multiple select
	}
	if(isset($_POST['altecaracteristici']) && is_array($_POST['altecaracteristici'])){
		$_POST['altecaracteristici']=implode(',',$_POST['altecaracteristici']);//multiple select
	}

	unset($_POST['companie_vanzare']);
	unset($_POST['reprezentant_vanzare']);
	update_qaf( 'vanzare', $_POST, '`idv`=' . @floor( $_POST[ 'edit_vanzare' ] ), 'LIMIT 1' );
	//  ThfAjax::redirect('r'); //reload
	//  ThfAjax::redirect('R'); //reload+clear chache
	// ThfAjax::redirect('/afaceri/'); //reload+clear chache
	ThfAjax::status( true, 'Salvat' );
	
	export_vanzare_to_wp($_POST[ 'edit_vanzare' ]);
	ThfAjax::json();
}

if ( isset( $_POST[ 'editare_im' ] )) { //companii
	 $_POST[ 'idv'] = @floor($_POST[ 'editare_im' ]);
	insert_update("editare_im",$_POST,array('id'),array(),false);
	
	//	update_qaf( 'editare_im', $_POST, '`idv`=' . @floor( $_POST[ 'editare_im' ] ), 'LIMIT 1' );
	//  ThfAjax::redirect('r'); //reload
	//  ThfAjax::redirect('R'); //reload+clear chache
	// ThfAjax::redirect('/afaceri/'); //reload+clear chache
	ThfAjax::status( true, 'Salvat' );
	ThfAjax::json();
}





if ( isset( $_POST[ 'evaluare_tab_form' ] )) { 
	
	$_POST[ 'idv'] = @floor($_POST[ 'evaluare_tab_form' ]);
	insert_update("evaluare",$_POST,array('id'),array(),false);
	ThfAjax::status( true, 'Salvat' );
	ThfAjax::json();
}

if ( isset( $_POST[ 'new_text_contract' ] ) ) {
	update_query( "UPDATE `vanzare` SET `contract` = '" . q($_POST[ 'new_text_contract' ]) . "' WHERE `vanzare`.`idv` = '" . floor( $_POST[ 'idv' ] ) . "';" );
	ThfAjax::status( true, 'Contractul a fost salvat cu succes!' );
	ThfAjax::json();
}

if ( isset( $_POST[ 'new_text_oferta' ] ) ) {
	update_query( "UPDATE `vanzare` SET `oferta` = '" . q($_POST[ 'new_text_oferta' ]) . "' WHERE `vanzare`.`idv` = '" . floor( $_POST[ 'idv' ] ) . "';" );
	ThfAjax::status( true, 'Oferta de Asistare in Vederea Vânzării Afacerii a fost salvata cu succes!' );
	ThfAjax::json();
}

if ( isset( $_POST[ 'new_text_nda' ] ) ) {
	update_query( "UPDATE `vanzare` SET `nda` = '" . q($_POST[ 'new_text_nda' ]) . "' WHERE `vanzare`.`idv` = '" . floor( $_POST[ 'idv' ] ) . "';" );
	ThfAjax::status( true, 'Acordul de confidentialitate a fost salvat cu succes!' );
	ThfAjax::json();
}


if(isset($_POST['edit_vanzare_checklist']) and is_numeric($_POST['edit_vanzare_checklist'])){  //
    foreach ($ckeck_list_text as $k=>$value){
        $a=array("idc"=>$_POST['edit_vanzare_checklist'],"qid"=>$k,"task_id"=>$_POST['task_id_'.$k],"se_aplica"=>$_POST['q_'.$k],"actiune"=>$_POST['action_'.$k]);
        $query=insert_update2("ckeck_list",$a,array('id'),array(),false);
    }
    ThfAjax::status(true,'Salvat');
    ThfAjax::json();
}




//////uploader si salvare generala in tabel vanzare:


ThfGalleryEditor::$ajax_upload = true;
ThfGalleryEditor::$max_files = 10;
ThfGalleryEditor::$accept = 'jpg|jpeg|png|pdf|txt|doc|docx|xls|xlsx';
ThfGalleryEditor::$web_path = UPLOAD . 'vanzari/';
ThfGalleryEditor::$sv_path = THF_ROOT . UPLOAD . 'vanzari/';
ThfGalleryEditor::$file_name_policy = '*f*';
ThfGalleryEditor::$overwritePolicy = 'r';
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


if ( count( $_POST ) || $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) { //prea($_FILES);	prea($_POST); die;
    $tablename = 'vanzare';
    ThfAjax::$out[ 'show_time' ] = 2000;

    ThfGalleryEditor::$database_pics = ( is_numeric( $pid ) && $pid > 0 ? json_decode( $vanzare[ 'atasamente' ], true ) : array() ); //load existing stored pictures
    ThfGalleryEditor::actionFileController(); //unlinks files fron the drive and updates ThfGalleryEditor::$database_pics
    ThfGalleryEditor::uploadController();
    //    ThfGalleryEditor::resize_uploaded_pics($resize_policy,$remove_original_pic=false);

    $_POST[ 'atasamente' ] = json_encode( array_merge( ThfGalleryEditor::$database_pics, ThfGalleryEditor::$new_pics ) );

	
	///!!!!!!!!!	SUPRASCRIS DE	isset( $_POST[ 'edit_vanzare' ])
	/////!!!!! RAMANE IN CAZ GENERAL SI PT UPLOAD FILE
    if ( is_numeric( $pid ) ) { //update
        //prea($_FILES);	prea($_POST); die;
        update_qaf( $tablename, $_POST, "`idv`='$pid'", 'LIMIT 1', $keys_to_exclude = array( 'idv' ), $setify_only_keys = array(), $return_query = false );
        ThfAjax::status( true, 'Salvat cu succes!' );
        if ( count( $_POST ) > 2 ) {
            ThfAjax::redirect( '?edit=' . $pid );
        }
        //		redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.floor($pid));
    } elseif ( $pid == 'i' ) { //insert
        //$_POST['poze']=json_encode(ThfGalleryEditor::$new_pics);
        $id = insert_qa( $tablename, $_POST, array( 'idv' ) );
        ThfAjax::status( true, 'Inserted successfully!' );
        ThfAjax::redirect( '?edit=' . $id );
        //redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.$id);
    }
    ThfAjax::json(); //generate upload report

}