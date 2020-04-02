<?php

if(!isset($_GET['type'])) { $_GET['type'] = 'media';}
$pid = floor($_GET['view']);
$vanzare = $vanzari_all[ $pid ];






if($_GET['type'] == 'media') {

//////uploader si salvare generala in tabel vanzare:


    ThfGalleryEditor::$ajax_upload = true;
    ThfGalleryEditor::$max_files = 25;
    ThfGalleryEditor::$accept = 'jpg|jpeg|png|pdf|txt|doc|docx|xls|xlsx|mp4';
    ThfGalleryEditor::$web_path = UPLOAD . 'vanzari/';
    ThfGalleryEditor::$sv_path = THF_ROOT . UPLOAD . 'vanzari/';
    ThfGalleryEditor::$file_name_policy = '*f*';
    ThfGalleryEditor::$overwritePolicy = 'r';
    ThfGalleryEditor::$id = floor($pid); //specifica ce id are produsul pentru a putea urca asincron poze si file
////3333333


    ThfGalleryEditor::$layout = array(
        'container_class' => 'container-fluid',
        'row_class' => 'colpadsm',
        //'row_class'=>'sortableRowConnected colpadsm',
        'col_class' => 'col-xs-6 col-sm-4 col-md-3 col-lg-2',
        'img_wrap_class' => 'CoverRatio4_3',
        'file_wrap_class' => 'ThfGalleryFileWrap',
        'img_class' => 'img-thumbnail',
        'remove_class' => 'ThfGalleryEditorRemove',
    );


    if (count($_POST) || $_SERVER['REQUEST_METHOD'] == 'POST') { //prea($_FILES);	prea($_POST); die;
        $tablename = 'vanzare';
        ThfAjax::$out['show_time'] = 2000;

        ThfGalleryEditor::$database_pics = (is_numeric($pid) && $pid > 0 ? json_decode($vanzare['atasamente'], true) : array()); //load existing stored pictures
        ThfGalleryEditor::actionFileController(); //unlinks files fron the drive and updates ThfGalleryEditor::$database_pics
        ThfGalleryEditor::uploadController();
        //    ThfGalleryEditor::resize_uploaded_pics($resize_policy,$remove_original_pic=false);

        $_POST['atasamente'] = json_encode(array_merge(ThfGalleryEditor::$database_pics, ThfGalleryEditor::$new_pics));


        ///!!!!!!!!!	SUPRASCRIS DE	isset( $_POST[ 'edit_vanzare' ])
        /////!!!!! RAMANE IN CAZ GENERAL SI PT UPLOAD FILE
        if (is_numeric($pid)) { //update
            //prea($_FILES);	prea($_POST); die;
            update_qaf($tablename, $_POST, "`idv`='$pid'", 'LIMIT 1', $keys_to_exclude = array('idv'), $setify_only_keys = array(), $return_query = false);
            ThfAjax::status(true, 'Salvat cu succes!');
            if (count($_POST) > 2) {
                ThfAjax::redirect('?view=' . $pid);
            }
            //		redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.floor($pid));
        } elseif ($pid == 'i') { //insert
            //$_POST['poze']=json_encode(ThfGalleryEditor::$new_pics);
            $id = insert_qa($tablename, $_POST, array('idv'));
            ThfAjax::status(true, 'Inserted successfully!');
            ThfAjax::redirect('?view=' . $id);
            //redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.$id);
        }
        ThfAjax::json(); //generate upload report

    }
}



if($_GET['type'] == 'doc') {
    //////uploader si salvare generala in tabel vanzare:


    ThfGalleryEditor::$ajax_upload = true;
    ThfGalleryEditor::$max_files = 10;
    ThfGalleryEditor::$accept = 'jpg|jpeg|png|pdf|txt|doc|docx|xls|xlsx';
    ThfGalleryEditor::$web_path = UPLOAD . 'vanzari_documente/';
    ThfGalleryEditor::$sv_path = THF_ROOT . UPLOAD . 'vanzari_documente/';
    ThfGalleryEditor::$file_name_policy = '*f*';
    ThfGalleryEditor::$overwritePolicy = 'r';
    ThfGalleryEditor::$id = floor($pid); //specifica ce id are produsul pentru a putea urca asincron poze si file
////3333333


    ThfGalleryEditor::$layout = array(
        'container_class' => 'container-fluid',
        'row_class' => 'colpadsm',
        //'row_class'=>'sortableRowConnected colpadsm',
        'col_class' => 'col-xs-2',
        'img_wrap_class' => 'CoverRatio4_3',
        'file_wrap_class' => 'ThfGalleryFileWrap',
        'img_class' => 'img-thumbnail',
        'remove_class' => 'ThfGalleryEditorRemove',
    );


    if (count($_POST) || $_SERVER['REQUEST_METHOD'] == 'POST') { //prea($_FILES);	prea($_POST); die;
        $tablename = 'vanzare';
        ThfAjax::$out['show_time'] = 2000;

        ThfGalleryEditor::$database_pics = (is_numeric($pid) && $pid > 0 ? json_decode($vanzare['atasamente_documente'], true) : array()); //load existing stored pictures
        ThfGalleryEditor::actionFileController(); //unlinks files fron the drive and updates ThfGalleryEditor::$database_pics
        ThfGalleryEditor::uploadController();
        //    ThfGalleryEditor::resize_uploaded_pics($resize_policy,$remove_original_pic=false);

        $_POST['atasamente_documente'] = json_encode(array_merge(ThfGalleryEditor::$database_pics, ThfGalleryEditor::$new_pics));


        ///!!!!!!!!!	SUPRASCRIS DE	isset( $_POST[ 'edit_vanzare' ])
        /////!!!!! RAMANE IN CAZ GENERAL SI PT UPLOAD FILE
        if (is_numeric($pid)) { //update
            //prea($_FILES);	prea($_POST); die;
            update_qaf($tablename, $_POST, "`idv`='$pid'", 'LIMIT 1', $keys_to_exclude = array('idv'), $setify_only_keys = array(), $return_query = false);
            ThfAjax::status(true, 'Salvat cu succes!');
            if (count($_POST) > 2) {
                ThfAjax::redirect('?view=' . $pid);
            }
            //		redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.floor($pid));
        } elseif ($pid == 'i') { //insert
            //$_POST['poze']=json_encode(ThfGalleryEditor::$new_pics);
            $id = insert_qa($tablename, $_POST, array('idv'));
            ThfAjax::status(true, 'Inserted successfully!');
            ThfAjax::redirect('?view=' . $id);
            //redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.$id);
        }
        ThfAjax::json(); //generate upload report

    }
}