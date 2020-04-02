<?php
require_once( '../config.php' );
require_once( 'functions.php' );
$page_head = array(
    'meta_title' => 'Contracte template',
    'trail' => 'contracte'

);
require_login();
if ( $GLOBALS[ 'login' ]->get_user_level() < 10 ) {
    redirect( 303, LROOT );
}


if ( isset( $_POST[ 'edit_row' ] )AND is_numeric( $_POST[ 'edit_row' ] ) ) {
    edit_contracte(many_query( "SELECT * from template_contracte WHERE id='".floor($_POST[ 'edit_row' ])."' LIMIT 1" )  );
    die();
}

if ( isset( $_POST[ 'nume_contract' ] ) ) {
    if($_POST['id']){
        update_qaf('template_contracte',$_POST,"id='".floor($_POST['id'])."'",$limit='LIMIT 1', $keys_to_exclude=array('id'), $setify_only_keys=array(), $return_query=false);
    }
    else{
        $last_id = insert_qa( 'template_contracte', $_POST );
    }
    redirect();
}

$search_sql = "";


$rows = multiple_query( "SELECT * from template_contracte $where_sql  ORDER BY nume_contract ASC" );

if ( isset( $_POST[ 'search_asoc' ] ) ) {
    list_asociatii( $rows );
    die();
}


if ( isset( $_POST[ 'delete_asoc' ] ) ) {
    delete_query( 'delete from template_contracte where id="' . $_POST[ 'asoc_id' ] . '"' );

}

index_head();
// table table-striped table-hover table-condensed table-responsive

echo list_menu_settings();
?>
    <div class="ui bottom attached active tab segment">
    <div class="container-fluid">
        <div class='row'>

            <div class='col-sm-10'>
                <form action="" method="post" enctype="application/x-www-form-urlencoded" class="form-inline">
                    <div class="form-group" style="margin-top: 25px;">
                        <input type="text" class='form-control cauta' name='nume_contract' placeholder="Nume contract">
                        <input type='submit' class='ui mini primary button' name='adauga' value='Adauga' >
                    </div>
                </form>
            </div>
            <div class="col-sm-8">
             <div class="" id='lista_asociatii'>  <br>
                    <?php
                    list_contracte( $rows );
                    ?>
                </div>
            </div>

        </div>
    </div>
    <input type='hidden' name='copy_help' id='copy_help'>
    <script>
        var form_hash = '';

        $( function () {

            form_hash = $( '#search_asociatii' ).serialize();

            setInterval( function () {

                if ( !$.active && form_hash != $( '#search_asociatii' ).serialize() ) { //check if ajax request is in progress and form has changed
                    msg_bst_thf_loading();
                    form_hash = $( '#search_asociatii' ).serialize();
                    //console.log( form_hash );
                    $.post( '', form_hash, function ( data ) {
                        //console.log( data );

                        $( '#lista_asociatii' ).html( data );
                        form_hash = $( '#search_asociatii' ).serialize();
                        msg_bst_thf_loading_remove();
                    } );
                }
            }, 750 );

	
		
        } );

function copy_key(obj)
{
	console.log(obj);

}



  function change_values(sel_val,id_form)
  {
  			$(".list_items_"+id_form).hide();
			$("."+sel_val).show();
  }
  
        function edit_row( id ) {
            $.post( '', {
                "edit_row": id
            }, function ( r ) {
                $( '#raspuns_' + id ).html( r );
                utils_init();
                tinymce_init();
            } );

        }

function utils_init()
{
	$(".all_list_items").click(function(){
		var aux = document.createElement("textarea");
		var txt =$(this).html();
		$(aux).val(txt);
	    document.body.appendChild(aux);
	    aux.select();
	    document.execCommand("copy");
	    document.body.removeChild(aux);
	});
    $(".all_list_items").mouseenter(function(){
        $('.border_documente').removeClass('border_documente');
                $(this).addClass('border_documente');
    });
    $(".all_list_items").mouseleave(function(){
        $('.border_documente').removeClass('border_documente');

    });
}
        function delete_row( id ) {
            if ( confirm( "Sigur vrei sa stergi aceasta inregistrare?" ) ) {
                $.post( '', {
                    asoc_id: id,
                    delete_asoc: "1"
                }, function ( data ) {
                    alert( "Inregistrare stearsa" );
                    window.location.reload();
                } );

            }
        }
    </script>

<?php

index_footer();