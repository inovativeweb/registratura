<?php

if (!$GLOBALS['has_config']) {require ('../config.php'); }
require (THF_PATH . '/documente/controller.php');

$cumparator = $cumparatori_all[$_GET['edit']];



$pid=floor($_GET['edit']);  // 333



$page_head['title']='Adauga document';
$page_head['trail']='documente';
index_head();

?>
<style>
    .ThfGalleryFileWrap {
        padding-top: 5px;
        padding-bottom: 2em;
        padding-left: 1em;
        padding-right: 1em;
        border: 1px solid #ddd;
        border-radius: 0.33em;
    }
</style>
<script src="<?=ROOT;?>documente/java.js?<?=time()?>" type="text/javascript"></script>


<input type='hidden' name='from_vanzare' id='from_vanzare' value=<?=$_GET['idv']?>>
    <div class="ui ordered steps" id="add_afac"  style="width: 100%; height: 60px;">
        <a class="active completed step" step="date_document">
            <div class="content">
                <div class="title">Date document</div>
            </div>
        </a>
        <a class="step" step="continut">
            <div class="content">
                <div class="title">Continut</div>
            </div>
        </a>
        <?php if(has_right($_GET['edit'],'cumparator')){ ?>
        <a class="step" step="contract">
            <div class="content">
                <div class="title">Document iesire</div>
            </div>
        </a>
            <a class="step" step="istoric">
                <div class="content">
                    <div class="title">Istoric</div>
                </div>
            </a>
            <a class="step" step="attachments">
                <div class="content">
                    <div class="title">Atasamente (<?=$nr_atasamente?>)</div>
                </div>
            </a>
            <a class="step" step="todo">
                <div class="content">
                    <div class="title">To do</div>
                </div>
            </a>
        <a class="step" step="due_diligence">
            <div class="content">
                <div class="title">Actiuni</div>
            </div>
        </a>
        <?php } ?>
        
    </div>

   <div class="col-sm-9 col-md-9" id="ui_tabs_afacere" style="">
    <?php

    	include('1_document_intrare.php');
        include('2_continut.php');
        include('3_document_iesire.php');
        include('7_attachments_html.php');
        include('istoric.php');
        include('5_todo_html.php');
        include('6_actiuni_html.php');


    ?>
  </div>

<div class="col-sm-3 col-md-3">
<br><br>
    <div class="ui card grid">

        <div class="column">
               <h2 class="alocat_h" style="color: olive" title="Alocat la: ">
                   <?php
                   if($document_istoric[ 'id_alocat' ] > 0) {
                       echo $locuitori_all[$document_istoric['id_alocat']]['fullname'] . show_locuitor_icon($document_istoric['id_alocat']) .
                           ' <br><span style="font-size: 0.8em; color: grey"> - ' . $locuitori_all[$document_istoric['id_alocat']]['functie'] . ' - </span>';
                   } else {echo 'Nealocat'; }?>
               </h2>
                <?php ?>
            <form action="/post.php" method="post" enctype="application/x-www-form-urlencoded" class="ui form document_edit_insert" role="form" bootstraptoggle="true">
                <div class=" ">
                    <input type="hidden" name="idd" id="idd" value="<?=$_GET['edit']?>">
                    <?php
                    $nr_doc = $document[ 'nr_doc' ] > 0 ? $document[ 'nr_doc' ] : one_query("SELECT nr_doc FROM `documente` ORDER BY `nr_doc` DESC ") + 1;
                    $data_doc = $document[ 'data_doc' ] > 0 ? $document[ 'data_doc' ] : date("Y-m-d");
                    input_rolem( 'data_doc', 'Data document', $data_doc, '', false,array("attr"=>array("dateTimePicker"=>"")) );
                    input_rolem( 'nr_doc', 'Nr inregistrare', $nr_doc, '', false,array() );
                    select_rolem( 'status', 'Status ', $statusuri, $document[ 'status' ], '', false, array() );
                    select_rolem( 'tip_doc', 'Tip document ', $tip_documente_select, $document[ 'tip_doc' ], '', false, array() );

                    ?></div>
            </form>
<?php

select_rolem( 'alocat_la', 'Alocat la ', $locuitori_organigrama, $document_istoric[ 'id_alocat' ], '', false, array() );?>

            <br>

            <?php if(has_right($_GET['edit'],'cumparator')){ ?>
            <h2 style="color: #b5cc18"><?=$cumparatori['full_name']?></h2>
            Atasamente
            <hr>
            <form action="./post.php?edit=<?=$_GET['edit']?>" method="post" enctype="multipart/form-data" class="ThfGalleryEditorForm">
                <!-- 2-->
                <?php // $cumparatori);
				ThfGalleryEditor::$coloana_upload='atasamente';
				$wttff_fetch_tampit=one_query("select atasamente from documente WHERE idd='".q($_GET['edit'])."' LIMIT 1");
											
				//$poze=ThfGalleryEditor::get_poze_produs($cumparatori[$_GET['edit']][ThfGalleryEditor::$coloana_upload]);
				$poze=ThfGalleryEditor::get_poze_produs($wttff_fetch_tampit);
				//ThfGalleryEditor::pics_layout_frontend($poze);
				ThfGalleryEditor_ury::pics_layout_frontend_lista($poze);
                ?>
            </form>
            <?php } ?>
        </div>
    </div>
</div>
<?php if(has_right($_GET['edit'],'cumparator')){ ?>
<div style="position:fixed !important; bottom:5px; right:5px; padding: 3px; z-index:1000;" class="fixed  ui olive message">
    <span style="color: olive; font-size: 0.9em" id="date_companie_h3"></span>
    <input type="button" class="ui green button" id="save_cumparator" onmousedown="save_all_document_forms();" value="Salveaza"/>
    <a href="<?=ROOT.'documente/index.php'?>"><i id="loading_save" class="spinner loading icon hide"></i><input type="button" class="ui teal button" id="go_to_documente"  value="Inchide"/></a>
</div>
<?php } else { ?>
    <script>
        $(function () {
            $('input, textarea').prop('disabled', true).prop('readonly', true).disable();
            $('select, .chosenInitThf').prop('disabled', true).trigger("chosen:updated");
        });
    </script>
<?php } ?>
<script>
<?php ThfGalleryEditor::javascript_settings(); ?>	
</script>
<script>

	


</script>

<?php index_footer();?>
