<?php
require_once('./config.php');
if(isset($_GET['prestatori'])) {
    $page_head = array('meta_title' => 'Companii EDIT', 'trail' => 'prestatori|companie_edit');
} else {    $page_head = array('meta_title' => 'Companii EDIT', 'trail' => 'companii|companie_edit');
}
if(count($_POST)){
    if(!isset($_POST['tip_prestator'])){ $_POST['tip_prestator']=0;}
        if(strlen($_POST['nume']) or strlen($_POST['prenume'])){
            $_POST['denumire'] = $_POST['nume'].' '.$_POST['prenume'];
        }

    if(isset($_POST['id_companie_clienta']) and is_numeric($_POST['id_companie_clienta'])){
        update_qaf('companie',$_POST,'`id_companie`='.@floor($_POST['id_companie_clienta']),'LIMIT 1');
    }
	else{//insert
		$last_id=insert_qa('companie',$_POST);
        if(isset($_POST['from_document']) AND is_numeric($_POST['from_document'])) {
            update_query("UPDATE `documente` SET `id_companie_clienta` = '" . q($last_id) . "' WHERE `documente`.`id_doc` = '" . q($_POST['from_document']) . "';");
            if (isset($_GET['imputernicit'])) {
                update_query("UPDATE `documente` SET id_imputernicit = '" . q($last_id) . "' WHERE `documente`.`id_doc` = '" . q($_GET['from_document']) . "';");
            }
        }


		}
    die;
}





if(!isset($_GET['edit'])){ //INSERT FORM
iframe_head();
   if(isset($_GET['prestatori'])){
       prestatori_edit_insert($companie);
   } else {

       companie_edit_insert($companie,$_GET['from_document']);
   }
if($_GET['ifr']=='1'){iframe_footer();}
    else { iframe_footer();} }

else{
    if($_GET['ifr']=='1'){iframe_head();}//UPDATE_FORM
           else { index_head();}

    $companie=many_query("SELECT * FROM `companie` WHERE `id_companie`='".floor($_GET['edit'])."'  LIMIT 1 "); ?>
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
          <?php
          if(isset($_GET['prestatori'])){

              prestatori_edit_insert($companie);
          } else {

              companie_edit_insert($companie,$_GET['from_document']);
          }


         ?>
        </div><div class="col-sm-1"></div>


<?php
//companie_view(floor($_GET['edit']));
//echo '<br>';
//sold_view(floor($_GET['edit']));
//echo '<br>';
if($companie['tip_companie']=='f'){$tip='furnizor';}
if($companie['tip_companie']=='c'){$tip='client';}
//echo ''.sold(floor($_GET['edit']),$tip,false).'';

    if($_GET['ifr']=='1'){iframe_footer();}
    else { index_footer();}
 }

if(1 || !isset($_GET['prestatori'])) {
?>

<script>
    $(function(){
        reinatialize_semantic();
        //forms handler
/*
        setInterval(function () {
            save_companie();
        },30*1000);
*/
        $('form[bootstrapToggleBpg=true] input[type=checkbox][data-toggle][data-on][data-off]').change(function() {
            $(this).val( $(this).prop('checked')?$(this).attr('value-on'):$(this).attr('value-off') );
        }).prop('checked',function(){
            if($(this).val()==$(this).attr('value-off')){$(this).bootstrapToggle('off'); return false;}
            $(this).bootstrapToggle('on');	return true;
        });
      //  $('form[bootstrapToggleBpg=true] input[type=text][data-toggle][data-on][data-off]').attr('type','checkbox');
    });

</script>
<?php } ?>