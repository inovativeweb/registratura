<?php
if (!$GLOBALS['has_config']) {require ('../config.php'); }
require (THF_PATH . '/documente/controller.php');


$page_head=array(
    'meta_title'=>'documente',
    'trail'=>'documente'
);

if(!$GLOBALS['index_head']){
    $from_afaceri = true;
    index_head();
}



  //  generate_js_css_html_includes(array('dropdownchosen','bootstrap','colorbox'));

 ?>
    <style>
        .bstrc .togglex input[type="radio"]:checked + .label-text::before{ color: rgb(163, 51, 200); }
    </style>
<script src="<?=ROOT;?>documente/java.js?<?=time()?>" type="text/javascript"></script>
   <div class="container-fluid">
   <div class='row'>
       <div class="col-sm-4">
           <form action="" method="post" enctype="application/x-www-form-urlencoded" id="cms_filters_cump">
               <div class="row">
                   <input type='hidden' name='search_cump' id='search_cump' value='1'>
                   <label for="validation_status">Cauta <i class="search icon"></i></label>
                   <input class="cauta form-control" placeholder="Cauta" value="<?=@$_SESSION['cauta']?>" type="text" id="cauta"  name="cauta">

                   <input name="ajax" type="hidden" value="1">
               </div>


           </form>
       </div>
       <div class="col-sm-1">
           <label><br><a target="" title="Resetare filtre" href="<?=ROOT?>documente/index.php?reset"><i class="retweet olive circular icon" aria-hidden="true" style="padding-left: .4em !important!"></i></a></label><br>
       </div>
       <div class="col-sm-5"></div>
   <div class="col-sm-2">
       <br>
  	<button class="ui olive basic button" onclick="add_document_nou(<?php echo ($GLOBALS['index_head']?$pid:"0") ?>)">Adauga document</button>
    </div>




        </div>
    </div>


    <script>
    
    function add_cumparator(idv) {
        console.log(idv);
        	<?php
  	if($from_afaceri)
  		{
	?>

   window.location.href='/documente/add_cumparator.php?edit=0&idv='+idv;
	<?php		
	}
	else
	{
	?>
		$.post("/documente/index.php", {"add_cumparator_display": "","idv":idv}, function (data) {
			data='<div align="center"><button type="button" onclick="reload_cumparatori()" class="btn btn-link">Inapoi la lista de cumparatori</button></div>'+data;
			$("#cumparatori_tab").html(data);
			     $('select').chosen();
		
			         $('[name=judet_id]').change(function () {
        let select_modif = $(this);
        
        $.post('/post.php', {"judet_id": $(this).val(), "show_loc": 1}, function (data) {
        	
            $(select_modif).closest('.localitati_judete').find('[name=localitate_id]').html(data).trigger("chosen:updated");
        
        //    $('.div_localitate_id select').html(data).trigger("chosen:updated");

            //	$(select_modif).closest('.localitati_judete').find('[name=localitate_id]').dropdown();
        });
    });

			//window.location.href = "/cumparatori/add_cumparator.php?edit=" + data;
		})	
	<?php
	}
	?>
}

	
	function delete_cumparator( id ) {
		if ( confirm( "Sigur vrei sa stergi aceasta inregistrare?" ) ) {
			$.post( '/documente/post.php', {
				cumparator_id: id,
				delete_cumparator: "1"
			}, function ( data ) {
				alert( "Inregistrare stearsa" );
				window.location.reload();
			} );

		}
	}
		
    var page_details=<?php echo json_encode($page_details); ?>;

    var form_hash='';
    update_nr_pagini(page_details);
    $(function () {
		$('form').submit(function(e){
			e.preventDefault();
			e.stopPropagation();
		});
		
        $( document ).tooltip();
        form_hash=$('#cms_filters_cump').serialize();
       
        setInterval(function(){

            if(!$.active && form_hash!=$('#cms_filters_cump').serialize()){ //check if ajax request is in progress and form has changed
                msg_bst_thf_loading();
                
                form_hash=$('#cms_filters_cump').serialize();
                //console.log(form_hash);
                $.post('/documente/index.php',form_hash,function(data){

                   // console.log(data);
                    $('#full_table_cumparatori').html(data.table);
                    console.log
                    data.table='';
                    update_nr_pagini(data);
                  //  initialize_actions();
					 msg_bst_thf_loading_remove();
                });
            }
        },750);

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

 function go_to_documente(id,tr){
     window.location.href='/documente/add_document.php?edit='+id;


  
 }

function go_to_task(nume_afacere,nume_cumparator)
{
	$("a[step='to_do_tab']").click();
	$(".add_task_field").val("Afacere:"+nume_afacere+" - Cumparator:"+nume_cumparator);
	$('.add_task_field').keyup();
}
</script>



<hr />
<div class="container-fluid"><div class="row">
        <div id="full_table_cumparatori" class="col-xs-12"><?php 		
			list_documente($date_cumparatori); ?></div>
    </div></div>



<?php
if(!$GLOBALS['index_head']) {
    index_footer();
}