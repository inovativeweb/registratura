<?php
require_once( '../config.php' );

$page_head = array(
    'meta_title' => 'General files',
    'trail' => 'my-files'

);
require_login();
$data= many_query("  SELECT * FROM `thf_users`  WHERE id = '".q($user_id_login)."' ",'id');
$data_files= multiple_query("  SELECT * FROM `thf_users`  WHERE general_files != '' ",'id');
foreach ($data_files as $k=>$v){
    $data_files_all[$k] = $v['general_files'];
}

$pid = $user_id_login;


ThfGalleryEditor::$ajax_upload = true;
ThfGalleryEditor::$max_files = 10;
ThfGalleryEditor::$accept = 'jpg|jpeg|png|pdf|txt|doc|docx|xls|xlsx';
ThfGalleryEditor::$web_path = UPLOAD . 'general-files/';
ThfGalleryEditor::$sv_path = THF_ROOT . UPLOAD . 'general-files/';
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
    $tablename = 'thf_users';
    ThfAjax::$out['show_time'] = 2000;

    ThfGalleryEditor::$database_pics = (is_numeric($pid) && $pid > 0 ? json_decode($data['general_files'], true) : array()); //load existing stored pictures
    ThfGalleryEditor::actionFileController(); //unlinks files fron the drive and updates ThfGalleryEditor::$database_pics
    ThfGalleryEditor::uploadController();
    //    ThfGalleryEditor::resize_uploaded_pics($resize_policy,$remove_original_pic=false);

    $_POST['general_files'] = json_encode(array_merge(ThfGalleryEditor::$database_pics, ThfGalleryEditor::$new_pics));


    ///!!!!!!!!!	SUPRASCRIS DE	isset( $_POST[ 'edit_vanzare' ])
    /////!!!!! RAMANE IN CAZ GENERAL SI PT UPLOAD FILE
    if (is_numeric($pid)) { //update
        //prea($_FILES);	prea($_POST); die;
        update_qaf($tablename, $_POST, "`id`='$pid'", 'LIMIT 1', $keys_to_exclude = array('id'), $setify_only_keys = array(), $return_query = false);
        ThfAjax::status(true, 'Salvat cu succes!');
        if (count($_POST) > 2) {
            ThfAjax::redirect('?view=' . $pid);
        }
        //		redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.floor($pid));
    } elseif ($pid == 'i') { //insert
        //$_POST['poze']=json_encode(ThfGalleryEditor::$new_pics);
        $id = insert_qa($tablename, $_POST, array('idc'));
        ThfAjax::status(true, 'Inserted successfully!');
        ThfAjax::redirect('?view=' . $id);
        //redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.$id);
    }
    ThfAjax::json(); //generate upload report

}




index_head();
// table table-striped table-hover table-condensed table-responsive

echo list_menu_myfiles();

 ?>
    <div class="ui bottom attached active tab segment">
        <div class="container-fluid">
            <?php if($access_level_login>9){?>
                <div class="row">
                    <div class="col-sm-12">
                        <form action="" method="post" enctype="multipart/form-data" class="ThfGalleryEditorForm">
                            <?php
                                $poze = ThfGalleryEditor::get_poze_produs($data['general_files']);
                                ThfGalleryEditor::pics_layout_frontend($poze);


                            ?>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped single line table-hover table-responsive ui blue table ">
                        <thead>
                        <tr class="violet">
                            <th>Nume fisier</th>
                            <th>Tip</th>
                            <th>Uploadat de</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data_files_all as $k=>$d){
                            $file = json_decode($d,true);
                            foreach ($file as $ff=>$f){
                                $fff  = explode('/',$f);
                                $ext  = explode('.',$f);
                                if(is_array($fff)){
                                    $nume = end($fff);
                                    $extensie = end($ext);

                                    ?>
                                <tr>
                                    <td><a href="<?=$f?>" target="_blank"> <?=ucfirst($nume)?></a></td>
                                    <td><?=$extensie?></td>
                                    <td><?=$users_all[$k]['full_name']?></td>
                                </tr>
                            <?php }
                        } ?>

                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <hr>
        </div>
    </div>
    <script>
        <!-- 1 -->
        <?php ThfGalleryEditor::javascript_settings(); ?>

        <?php if($access_level_login < 9){?>
        $('.ThfGalleryEditorDropZone ').remove();
        <?php } ?>
    </script>
<?php
//prea($vanzari[70]);

index_footer();