<?php
require_once('./config.php');
$page_head=array(	'meta_title'=>'Conturi EDIT');

if(count($_POST)){
	if(isset($_POST['remove']) && is_numeric($_POST['remove'])){
		update_qaf('conturi',array('cont_sters'=>1),'`idc`='.@floor($_POST['remove']),'LIMIT 1'); die('k');
		}
	if(isset($_GET['edit']) && is_numeric($_GET['edit'])){//update
		if($_POST['default_cont'] && $_POST['id_companie_cont']){
			update_qaf('conturi',array('default_cont'=>'0'),'`id_companie_cont`='.@floor($_POST['id_companie_cont']),' ');
			}
		update_qaf('conturi',$_POST,'`idc`='.@floor($_GET['edit']),'LIMIT 1',array('idc','id_companie_cont'));  ?>
<script>
parent.$('#iban<?php echo $_GET['edit']; ?>').html('<?php echo formatare_txt_cont($_POST); ?>');
parent.default_glipth_show('.default_cont','#iban<?php echo $_GET['edit']; ?>');
parent.$.colorbox.close();
</script>
<?php die;	redirect(303);
		}
	elseif(isset($_GET['id_companie_cont']) && is_numeric($_GET['id_companie_cont'])){//insert	
		$last_id=insert_qa('conturi',$_REQUEST,array('idc')); ?>
<script>
parent.$('#lista_conturi').append('<li class="list-group-item"><a href="/conturi_add.php?edit=<?php echo $last_id; ?>" class="iframe" id="iban<?php echo $last_id; ?>"  title="Editeaza acest cont"><?php echo formatare_txt_cont($_POST); ?></a></li>');
parent.$.colorbox.close();
parent.$("#iban<?php echo $last_id; ?>").colorbox({iframe:true, width:"80%", height:"75%"});
</script><?php die;
		redirect(303,'?edit='.$last_id);
		}
	else{e500('Nu exista nici un id de companie la care sa se asigneze acest cont.');}
	}

iframe_head();

if(!isset($_GET['edit'])){ //INSERT FORM
	if(isset($_GET['id_companie_cont']) && is_numeric($_GET['id_companie_cont'])){}
	else{e500('Nu exista nici un id de companie la care sa se asigneze acest cont.');}
 ?>
<form action="" method="post" enctype="application/x-www-form-urlencoded" class="form-horizontal" role="form">
<?php
//id_nume descriere valoare placeholder required
input_rolem('nume_banca','Nume Banca','','Denumire banca');
input_rolem('sucursala','Sucursala','','Denumire sucursala');
input_rolem('cont','Cont','','IBAN');

//id_nume descriere lista selectat placeholder
select_rolem('moneda','Moneda',$monede,'','Alege moneda');
input_send_rolem('Adauga','btn-success');

?></form>
<?php }





else{ //UPDATE FORM 
$cont=many_query("SELECT * FROM `conturi` WHERE `idc`='".floor($_GET['edit'])."'  LIMIT 1 ");

?><form action="" method="post" enctype="application/x-www-form-urlencoded" class="form-horizontal" role="form" bootstrapToggle="true" serialize="false">
<!--	<input type="hidden" name="idc" value="<?php echo h($cont['idc']); ?>" />-->
<input type="hidden" name="id_companie_cont" value="<?php echo h($cont['id_companie_cont']); ?>" />
<?php
//id_nume descriere valoare placeholder required
input_rolem('nume_banca','Nume Banca',$cont['nume_banca'],'Denumire banca');
input_rolem('sucursala','Sucursala',$cont['sucursala'],'Denumire sucursala');
input_rolem('cont','Cont',$cont['cont'],'IBAN');

//id_nume descriere lista selectat placeholder
select_rolem('moneda','Moneda',$monede,$cont['moneda'],'Alege moneda');
checkbox_rolem('default_cont','Cont prestabilit',$cont['default_cont'],'',false);
//select_rolem('default_cont','Cont prestabilit',array(0=>'Cont Secundar',1=>'Cont Principal'),$cont['default_cont'],'Prestabilit');

input_send_rolem('Salveaza','btn-success');

?></form><?php }

iframe_footer();
?>