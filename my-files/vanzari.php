<?php
require_once( '../config.php' );
$cale = '/dms/vanzari/';
require ('controller.php');

$page_head = array(
    'meta_title' => 'File vanzari',
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
          SELECT * FROM `vanzare` 
        LEFT JOIN companie  on companie_vanzare = companie.id_companie
        LEFT JOIN localizare_localitati ON companie.localitate_id = localizare_localitati.`id`
        LEFT JOIN localizare_judete on companie.judet_id = localizare_judete.`id`
       
        WHERE uid in($my_list)
        ORDER BY denumire ASC
";
$vanzari = multiple_query($sql,'idv'); ?>
<div class="ui bottom attached active tab segment">
    <div class="container-fluid">





<?php

if(isset($_GET['view']) and is_numeric($_GET['view']) AND isset($vanzari[$_GET['view']])){
    $data = $vanzari[$_GET['view']];
    $idv = $data['idv'];

    ?>
    <div class="row">
        <div class="col-sm-3">
            <div class="ui segments">
                <a href="<?='/my-files/vanzari.php?type=media&view='.$idv;?>"><div class="ui <?=$_GET['type'] == 'media' ? ' purple ' :'  message ' ?>segment">Atasamente Media Afacere </div></a>
                <a href="<?='/my-files/vanzari.php?type=doc&view='.$idv;?>"><div class="ui segment <?=$_GET['type'] == 'doc' ? ' purple ' :'  message ' ?>">Atasamente Documente Afacere</div></a>
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

<h3>Vanzarile mele</h3>

<?php foreach ($vanzari as $idv=>$v){ $i++;
    $atash = json_decode($v['atasamente'],true);
    echo $i%6==0 ? '<div class="row">':''; ?>
    <div class="col-sm-2">
                <?php echo '<a href="/my-files/vanzari.php?view='.$idv.(isset($_GET['type']) ? '&type='.$_GET['type'] : '').'">
<i class="selectable yellow folder open icon"></i><span style="color: black; '.($_GET['view'] == $idv ? 'border-bottom:2px solid #a333c8' : '').'">' . $v['denumire'] .
                    (count($atash)>0 ? ' <div class="aligned right text-right selectable icon note_icon fa fa-file-text-o" style="color: " title=""></div> ('.count($atash).')' :'').
                    '</span></a>'; ?>

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