<?php
require ('./controller.php');

$page_head['trail']='new_jobs';
$table='form_contact';
$table_id='id';



if(isset($_REQUEST[$table_id])){
	$data=many_query("SELECT * FROM `$table` WHERE `$table_id`='".q($_REQUEST[$table_id])."' LIMIT 1");
}
else{
	$data=many_query("SELECT * FROM `$table` LIMIT 1");//nu merge pt randuri goale daca cells este gol si el
	foreach($data as $cn=>$v){$data[$cn]=NULL;}
}




if(count($_POST)){
	//insert_update($tablename,$a,$keys_to_exclude=array('id'),$setify_only_keys=array(),$return_query=false)
	//redirect($code=302,$location='',$strip_params=false,$build_query=array())
	if(!isset($_POST['cancel'])){
		insert_update($table,$_REQUEST,array(),array(),false);
	}
	redirect($code=303,'/new-jobs/',$strip_params=false,$build_query=array());
}

$cells=array(
	'et_pb_contact_name_1'=>'Nume contact',
	'et_pb_contact_message_1'=>'Mesaj',
	'et_pb_contact_email_1'=>'Email',
);
foreach($data as $cn=>$v){
	if(!isset($cells[$cn])){$cells[$cn]=ucwords(str_replace('_',' ',$cn));}
}
unset($cells['contactat_de_broker_id']);
unset($cells['contactat_de_broker_pe']);
unset($cells['vanzator_asociat']);
unset($cells['cumparator_asociat']);
unset($cells['contact_datetime']);

index_head();
?>
<div class="container-fluid">
	<form action="" method="post" enctype="application/x-www-form-urlencoded" ><?php 
		$row_start='<div class="row colpadsm">';
		$row_end='</div >';
		foreach($cells as $name=>$title){
			if($name==$table_id){
				continue;
			}
			else{ echo $row_start; ?>
					<div class="col-md-4 col-sm-6 col-xs-12">
					<label class="control-label"><?=h($title)?></label>
						<input class="form-control" value="<?=h($data[$name])?>" type="text" name="<?=h($name)?>" <?php
						echo (in_array($name,array('contactat_de_broker_pe'))?'datePickerIso':'');
						echo (in_array($name,array('contact_datetime'))?'dateTimePicker':'');
						?>/></input>
					</div>
				
			<?php echo $row_end; }
			
		}
		echo $row_start; ?>
					<div class="col-md-2 col-sm-3 col-xs-6" align="right">
						<input type="submit" class="ui red button" value="Anuleaza" name="cancel">
					</div>
					<div class="col-md-2 col-sm-3 col-xs-6"  align="right">
						<input type="submit" class="ui green button" value="Salveaza">
					</div>
		<?php
		echo $row_end;
		?>

	</form>
</div>

<script>

</script>


<?php
index_footer();
?>