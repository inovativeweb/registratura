<?php
if (!$GLOBALS['has_config']) {require ('../config.php'); }
require (THF_PATH . '/afaceri/controller.php');

$page_head=array(
    'meta_title'=>'Afacerile mele',
    'trail'=>'afaceri_vanzare'
);
$from_cumparatori=true;
if(!$GLOBALS['index_head']){
    $from_cumparatori = false;
    index_head();
}


 ?>
<script>


</script>
<script src="<?=ROOT;?>afaceri/java.js?<?=time()?>" type="text/javascript"></script>
<?php if(0){ ?>
    <form action="" method="post" enctype="application/x-www-form-urlencoded" id="cms_filters">
        <div class="ui grid">
            <div class="three column row">
                <div class="column">        <label for="validation_status">Cauta <i class="search icon"></i></label>

                    <input class="cauta form-control" placeholder="Cauta" value="<?=@$_SESSION['cauta']?>" type="text" id="cauta"  name="cauta">
                </div>
                <div class="column"></div>
                <div class="column right right floated left aligned">
						<?php
					if ($from_cumparatori)
						{
						?>
						aa
                    <button class="ui purple basic button" onmousedown="add_afacere(<?php echo ($GLOBALS['index_head']?$pid:"0") ?>);">Asigneaza afacere</button>
                    <?php	
						}
						else
						{
							
						?>
						bbb
                    <button class="ui purple basic button" onmousedown="add_afacere(<?php echo ($GLOBALS['index_head']?$pid:"0") ?>);">Adauga afacere</button>
                    <?php
						}
                    ?>
                    <br>

                </div>

            </div>

        </div>
        <div class="ui relaxed grid">
            <div class="five column row">
                <div class="column">     <?php
                    $statusuri[-1] = 'Toate';
                    select_rolem('status','Status',$statusuri,$_SESSION['status'],'');
                    ?>
                </div>

                <div class="column">     <?php $sort['idv DESC'] = 'Cele mai noi';   select_rolem('sort','Sorteaza',$sort,$_SESSION['sort'],''); ?></div>
                <div class="column">     <?php
                    $statusuri[-1] = 'Toate';
                    select_rolem('status','Status',$statusuri,$_SESSION['status'],'');
                    ?></div>
                <div class="column"> <?php  $pag[1]='Pag 1.'; select_rolem('pag','Pagina',$pag,'',''); ?></div>
                <div class="column"><a target="" title="Resetare filtre" href="<?=ROOT?>afaceri/?reset"><i class="retweet purple circular icon" aria-hidden="true"></i></a></div>

            </div>
        </div>

    </form>

<?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">

                <br>
                <?php
                if ($from_cumparatori)
						{
					 select_rolem( 'id_afacere', 'Afaceri ', $afaceri_select, '', '', false, array() );
                ?>
                 </div>
                 <div class="col-sm-4">
                 <br/> <br/>
                 <button class="ui purple basic button" onmousedown="assign_afacere(<?php echo $pid; ?>);">Asigneaza afacere</button>
                    <?php	
						}
						else
						{
							
						?>
                <button class="ui purple basic button" onmousedown="add_afacere(<?php echo ($GLOBALS['index_head']?$pid:"0") ?>);">Adauga afacere</button>
 					<?php
						}
                    ?>
            </div>
            <?php
            if (!$from_cumparatori)
            {
                list_filters($filtre);
			?>


            <div class="col-sm-1">
                <label><br><a target="" title="Resetare filtre" href="<?=ROOT?>afaceri/?reset"><i class="retweet purple circular icon" aria-hidden="true"></i></a></label><br>
            </div>
           
            <div class="col-sm-1">
                <label><br>
                    <a target="_blank" class="print_btn" style="" onclick="print_pdf()"><i class="circular purple file pdf outline icon"></i></a>
                  </label><br>
            </div>
             <?php
}
            ?>
        </div>
    </div>

    <script>

		
		
		
		
    var page_details=<?php echo json_encode($page_details); ?>;

    var form_hash='';
    update_nr_pagini(page_details);
    $(function () {
        $( document ).tooltip();
        form_hash=$('#cms_filters').serialize();
        setInterval(function(){

            if(!$.active && form_hash!=$('#cms_filters').serialize()){ //check if ajax request is in progress and form has changed
                msg_bst_thf_loading();
                form_hash=$('#cms_filters').serialize();
                $.post('/afaceri/index.php',form_hash,function(data){

                    //console.log(data.table);
                    $('#full_table_comenzi').html(data.table);
                    data.table='';
                    update_nr_pagini(data);
                    initialize_actions();
                    msg_bst_thf_loading_remove();
                });
            }
        },750);
        initialize_actions();
       <?php
        if(isset($_GET['reset'])){
        unset($_SESSION);
        ?>
              $('#cauta').val('');
              $('#status').val('0');
              $('#status_buton_buy').val('0');
              $('#validation_status').val('0');
        <?php }
        if(0 and isset($_GET['view_prd_id']) and is_numeric($_GET['view_prd_id'])){?>
           setTimeout(function () {
               $('#cauta').val('<?=$_GET['view_prd_id']?>');
           },500);

        <?php } ?>
        
        
    });

function print_pdf()
{
    form_hash=$('#cms_filters').serialize();
    $.post('/afaceri/index.php?print=1',form_hash,function(r){
            postare = r.resultate_id_vanzare;
            window.location = "/pdf.php?print_afaceri="+postare;
        //console.log(data.table);
      //  $('#full_table_comenzi').html(data.table);
      //  data.table='';
      //  update_nr_pagini(data);
        initialize_actions();
        msg_bst_thf_loading_remove();
    });

}
	function delete_afacere( id ) {
		if ( confirm( "Sigur vrei sa stergi aceasta inregistrare?" ) ) {
			$.post( 'index.php', {
				vanzator_id: id,
				delete_afacere: "1"
			}, function ( data ) {
				alert( "Inregistrare stearsa" );
				window.location.reload();
			} );

		}
	}
 
 	function delete_from_cumparator( id,idc ) {
		if ( confirm( "Sigur vrei sa stergi aceasta inregistrare de la acest cumparator?" ) ) {
			$.post( 'index.php', {
				vanzator_id: id,
				idc:idc,
				delete_afacere_cump: "1"
			}, function ( data ) {
				alert( "Inregistrare stearsa" );
				  $('#full_table_comenzi').html(data.table);
			} );

		}
	}
 function go_to_afacere(id,tr){
  $(tr).find('td:not(.for_delete)').mouseup(function(){
   window.location.href='/add_afacere/?edit='+id;
   });
  
 }
 
</script>



<hr />
<div class="container-fluid"><div class="row">

        <div id="full_table_comenzi" class="col-xs-12"><?php list_documente($data_documente); ?></div>
    </div></div>



<?php

//index_footer();