<?php
require_once('./config.php');
$page_head=array(	'meta_title'=>'Curs EDIT',	'trail'=>'curs|curs_edit');


if(count($_POST)){
	if(isset($_GET['edit']) && is_numeric($_GET['edit'])){//update
		update_qaf('curs',$_POST,'`id_curs`='.@floor($_GET['edit']),'LIMIT 1',array('id_curs','data_curs','moneda_curs'));
?>
<script>
parent.$.colorbox.close();
parent.window.location='/curs.php';
</script><?php die;		
		redirect(303,'/curs.php');
		}
	else{//insert
		if(count_query("SELECT COUNT(*) FROM `curs` WHERE `data_curs`='".q($_POST['data_curs'])."' AND `moneda_curs`='".q($_POST['moneda_curs'])."' ")==0){
			$last_id=insert_qa('curs',$_POST);
			}
		 ?>
<script>
parent.window.location='/curs.php';
</script><?php die;			
		//redirect(303,'/curs_edit.php?edit='.$last_id);
		}
	}







if(!isset($_GET['edit'])){ //INSERT FORM
iframe_head();
 ?>
<form action="" method="post" enctype="application/x-www-form-urlencoded" class="form-horizontal" role="form">
<?php
// value="'.h(date('Y-m-d')).'" 
echo '<div class="form-group">
    <label class="control-label col-sm-2" for="data_curs">Data</label>
    <div class="col-sm-10">
      <input type="text" class="form-control data_curs" name="data_curs" id="data_curs" placeholder="Data" value="'.h(date('Y-m-d', (date('H')<14?time()-3600*15:time()) )).'" required readonly onChange="sugestie_curs()" />
    </div>
  </div>';
  
input_rolem_decimal('valoare_curs','Valoare curs','','Introduceti cursul',4);
input_rolem_decimal('curs_ref','Curs Referinta','','Cursul de referinta',1);
select_rolem('moneda_curs','Moneda',$monede,'EURO','Alege...');

//input_send_rolem('Adauga','btn-success');
echo '<div class="form-group"> <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-success">Adauga</button> <a href="http://www.cursbnr.ro/" target="_blank" class="btn btn-primary pull-right">www.cursbnr.ro</a></div></div>';

?></form><script>
$(function () {
	$('input.data_curs').datepicker({dateFormat:'yy-mm-dd',	minDate: -5, 	maxDate: 0});
	$('#moneda_curs').chosen().change(function(){sugestie_curs();});
//	$('#moneda_curs').on('change', function(evt, params) {		sugestie_curs();	});
	
	setTimeout(function(){sugestie_curs();},1000);
	});
</script><?php iframe_footer();  }





else{ //UPDATE FORM 
iframe_head();
$curs=many_query("SELECT * FROM `curs` WHERE `id_curs`='".floor($_GET['edit'])."'  LIMIT 1 "); ?>
<form action="" method="post" enctype="application/x-www-form-urlencoded" class="form-horizontal" role="form">

<?php
//id_nume descriere lista selectat placeholder


 //id_nume descriere valoare placeholder required
//input_rolem('data_curs','Data','','Data');
echo '<div class="form-group">
    <label class="control-label col-sm-2" for="data_curs">Data</label>
    <div class="col-sm-10">
      <input type="text" class="form-control data_curs" name="data_curs" id="data_curs" placeholder="Data" value="'.h($curs['data_curs']).'" required readonly onChange="sugestie_curs()" />
    </div>
  </div>';
  
input_rolem_decimal('valoare_curs','Valoare curs',$curs['valoare_curs'],'Introduceti cursul',4);
input_rolem_decimal('curs_ref','Curs Referinta',$curs['curs_ref'],'Cursul de referinta',1);
$monede=array($curs['moneda_curs']=>$curs['moneda_curs']);
select_rolem('moneda_curs','Moneda',$monede,$curs['moneda_curs'],'Alege...');
echo '<div class="form-group"> <div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-success">Salveaza</button> <a href="http://www.cursbnr.ro/" target="_blank" class="btn btn-primary pull-right">www.cursbnr.ro</a></div></div>';
//input_send_rolem('Salveaza','btn-success');
?>
</form><?php iframe_footer(); } ?>