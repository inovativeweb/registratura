<?php
require_once('./config.php');

require_login();

$page_head=array(
    'meta_title'=>'Definitii',
    'trail'=>'definitii'

);



if(isset($_POST['idd'])){
    $idd = $_POST['idd'];
    unset($_POST['idd']);
    if(is_numeric($idd)){ //update
       // prea($_POST);
        update_qa("definitii",$_POST," idd = '".$idd."' ",' LIMIT 1',false);
		ThfAjax::status(true,'Actualizat'); 
    } else {
        if(!strlen($_POST['tip'])){ThfAjax::status(true,'Completeaza tip'); }
        elseif(!strlen($_POST['cheie'])){ThfAjax::status(true,'Completeaza cheie'); }
        elseif(!strlen($_POST['text'])){ThfAjax::status(true,'Completeaza text'); }
        else{
			insert_qa("definitii",$_POST);
			ThfAjax::status(true,'Adaugat'); 
			ThfAjax::redirect('r');
			}
    }
	ThfAjax::json();
}


if($GLOBALS['login']->get_user_level()<10){ redirect(303,LROOT);}

index_head();

echo list_menu_settings();
?>
<div class="ui bottom attached active tab segment"> <?php

$data = multiple_query("SELECT * FROM `definitii`",'idd');

function list_definitie($idd){
    $data = many_query("SELECT * FROM `definitii` WHERE idd = '".$idd."' "); ?>
    <form id="edit_definitie_<?=$idd?>">
    <div class="row">
        <div class="col-xs-6">
            <input class="form-control"  type="hidden" name="idd" value="<?=$idd?>">
			<div class="form-group">
				<label>Tip:</label>
				<input type="email" class="form-control" name="tip" value="<?=$data['tip']?>">
			</div>

			<div class="form-group">
				<label>Cheie:</label>
				<input type="email" class="form-control" name="cheie" value="<?=$data['cheie']?>">
			</div>
                          
			<div class="form-group">
				<button type="button" class="ui green button" style="margin-top: 10px;" onmousedown="save_definitie('<?=$idd?>')"><?=!is_numeric($idd) ? 'Adauga' : 'Salveaza'?></button>
            	<p style="color: red" id="raspuns_id_<?=$idd;?>"></p>
			</div>
        </div>
        <div class="col-xs-6"><label>Text definitie:</label><textarea class="form-control"  cols="100" rows="10" name="text" style="resize: both"><?=$data['text']?></textarea></div>

    </div>
    </form>
    <hr>
<?php }  ?>
<div class="container-fluid">
    <?php
    list_definitie('');
   
    foreach ($data as $idd=>$v){
        list_definitie($idd);
    }

    ?>
</div>
</div>
<script>
    function save_definitie(idd) {
        $.post("",$('#edit_definitie_'+idd).serialize(),function (data) {
			ThfAjax(data);
           
        })
    }
</script>
<?php index_footer();?>

