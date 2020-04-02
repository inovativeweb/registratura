<?php
require_once('./config.php');
$page_head=array(
    'meta_title'=>'Clienti',
    'trail'=>'companii'
);


    if(isset($_GET['denumire'])){
        $string_cautare= " `denumire` LIKE '%".$_GET['denumire']."%' ";


        $data=multiple_query("SELECT * FROM companie WHERE $string_cautare AND tip_companie != 'e' ORDER BY denumire ASC LIMIT 1000 ");



companii_view($data,'');die;}
else {
    $data=multiple_query("SELECT * FROM companie WHERE tip_companie != 'e' ORDER BY denumire ASC LIMIT 1000 ");
}
index_head();?>
<div class="container-fluid"><div class="row"><div class="form-group">
 <form id="verificare" enctype="multipart/form-data">    
<div class="col-sm-3"><input type="text" class="form-control" name="denumire" placeholder="Cauta" value="" /></div>
</form>
<div align="right"><a href="companie_edit.php" class="btn btn-success iframe">Adauga client nou</a></div>

</div></div>
<div id="linii"><?php companii_view($data,'');?></div>
        
<script>
	continut_forma=null;
	setInterval(function(){
	if($('#verificare').serialize()!=continut_forma){
		continut_forma=$('#verificare').serialize();
		console.log(continut_forma);
		$.get('',continut_forma,function(data){
			$('#linii').html(data);
			});
		}
	},500);
	
</script>

<?php
index_footer();
?>