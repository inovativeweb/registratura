<?php
require_once( '../config.php' );
$cale = '/dms/cumparatori/';
require ('controller_cump.php');

$page_head = array(
    'meta_title' => 'File cumparatori',
    'trail' => 'my-files'

);

index_head();
// table table-striped table-hover table-condensed table-responsive

echo list_menu_myfiles();
if ($access_level_login==3)
{
 $my_list = implode(',',return_users_filiala($user_id_login));	
}
else
{
 $my_list = implode(',',return_users_agentie($user_id_login));	
}

$sql = "
          SELECT * FROM `cumparatori` 
        LEFT JOIN localizare_localitati ON cumparatori.localitate_id = localizare_localitati.`id`
        LEFT JOIN localizare_judete on cumparatori.judet_id = localizare_judete.`id`
        WHERE uid in($my_list)
        ORDER BY full_name ASC
";
$cumparatori= multiple_query($sql,'idc'); ?>
    <div class="ui bottom attached active tab segment">
        <div class="container-fluid">
          <?php
                if(!count($cumparatori)){ echo 'Nici un document uploadat';}
            if(isset($_GET['view']) and is_numeric($_GET['view']) AND isset($cumparatori[$_GET['view']])){
                $data = $cumparatori[$_GET['view']];
                $idc = $data['idc'];

                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="ui segments">
                            <a href="<?='/my-files/cumparatori.php?type=media&view='.$idc;?>"><div class="ui <?=$_GET['type'] == 'media' ? ' purple ' :'  message ' ?>segment">Atasamente Media cumparatori </div></a>
                            <a href="<?='/my-files/cumparatori.php?type=doc&view='.$idc;?>"><div class="ui segment <?=$_GET['type'] == 'doc' ? ' purple ' :'  message ' ?>">Atasamente Documente cumparatori</div></a>
                        </div>


                    </div>
                    <div class="col-sm-9">
                        <form action="" method="post" enctype="multipart/form-data" class="ThfGalleryEditorForm">
                            <?php
                            if($_GET['type'] == 'media') {
                                $poze = ThfGalleryEditor::get_poze_produs($data['atasamente']);
                                ThfGalleryEditor::pics_layout_frontend($poze);
                            }
                            if($_GET['type'] == 'doc') {
                                $poze = ThfGalleryEditor::get_poze_produs($data['atasamente_documente']);
                                ThfGalleryEditor::pics_layout_frontend($poze);

                            }
                            ?>
                        </form>
                    </div>
                </div>
            <?php } ?>




            <hr>



            <?php foreach ($cumparatori as $idc=>$v){ $i++;
                $atash = json_decode($v['atasamente'],true);
                echo $i%6==0 ? '<div class="row">':''; ?>
                <div class="col-sm-2">
                    <?php echo '<a href="/my-files/cumparatori.php?view='.$idc.(isset($_GET['type']) ? '&type='.$_GET['type'] : '').'"><i class="selectable yellow folder open icon"></i>
                    <span style="color: black; '.($_GET['view'] == $idc ? 'border-bottom:2px solid #b5cc18' : '').'">' . $v['full_name'] .
                        (count($atash)>0 ? ' <div class="aligned right text-right selectable icon note_icon fa fa-file-text-o" style="color: " title=""></div> ('.count($atash).')' :''). '</span></a>'; ?>

                    <hr>
                </div>

                <?php  echo $i%6==0 ? '</div>':'';
            } ?>
            <hr>
        </div>
    </div>
    <script>
        <!-- 1 -->
        <?php ThfGalleryEditor::javascript_settings(); ?>
    </script>
<?php
//prea($vanzari[70]);

index_footer();