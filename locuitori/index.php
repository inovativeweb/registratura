<?php
require_once('../config.php');
require_once('functions.php');
$page_head=array(
    'meta_title'=>'locuitori',
    'trail'=>'locuitori'

);

if (isset($_POST['delete_locuitor']))
{
	delete_query( 'delete from locuitori where idl="' . $_POST[ 'idl' ] . '"' );
	die();
}

if(isset($_POST['save_strada']) and is_numeric($_POST['save_strada'])){
    update_query("UPDATE `locuitori` SET `id_strada` = '".$_POST['save_strada']."' WHERE `locuitori`.`idl` = '".$_POST['idl']."' ;");
    echo 'Salvat!';
    die;
}
if(isset($_POST['approve_plata']) and is_numeric($_POST['approve_plata'])){
    update_query("UPDATE `locuitori` SET `is_confirmed` = '".$_POST['is_approved']."', is_confirmed_date = '".date("Y-m-d H:i:s")."' WHERE `locuitori`.`idl` = '".$_POST['approve_plata']."' ;");
    echo '<p id="raspuns_is_approved_' . $row['idl'] . '" style="color: ' . ($_POST['is_approved'] < 1 ? 'red' : 'green') . '">' . ($_POST['is_approved'] > 0 ? 'CONFIRMAT : ' . date("Y-m-d H:i:s") : 'NECONFIRMAT') . '</p>';
    die;
}

require_login();

if(in_array($userId,array(2,70)) and $userId>0){
    $can_edit = true;
} else {
    $can_edit = false;
}
if($GLOBALS['login']->get_user_level()<10){ redirect(303,LROOT);}


$search_sql = "";
if ( isset( $_SESSION[ 'cauta' ] ) and !isset( $_REQUEST[ 'cauta' ]) and !strlen($_REQUEST[ 'cauta' ])  ) {
    $_REQUEST[ 'cauta' ] = $_SESSION[ 'cauta' ];
} else {
    unset( $_SESSION[ 'cauta' ] );
}


if ( isset( $_REQUEST[ 'cauta' ] )and $_REQUEST[ 'cauta' ]and strlen( trim( $_REQUEST[ 'cauta' ] ) ) ) {
    foreach ( explode( ' ', $_REQUEST[ 'cauta' ] ) as $word ) {
        if ( strlen( $word ) > 0 ) {
            $search_words[] = $word;
        }
    }
    $_SESSION[ 'cauta' ] = $_REQUEST[ 'cauta' ];
}
if ( isset( $search_words ) ) {
    foreach ( $search_words as $word ) {
        $search_sql .= ( $search_sql ? " AND " : "" ) . ( "fullname LIKE '%" . q( $word ) . "%'   " );
    }
}

$search_sql = ( $search_sql ? " ( \r\n $search_sql \r\n ) " : "" );

$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . $search_sql;

$where_sql = ( $where_sql ? "\r\n WHERE " . $where_sql . " " : "" );


$rows=multiple_query("SELECT * FROM `locuitori` $where_sql  ORDER BY `fullname` ASC");

if ( isset( $_POST[ 'search_locuitori' ] ) ) {
    list_locuitori( $rows );
    die();
}

index_head();
// table table-striped table-hover table-condensed table-responsive
?>

    <div class="container-fluid">
    <div class='row'>

    <div class="col-sm-8">
        <form action="" method="post" enctype="application/x-www-form-urlencoded" id='search_locuitori'>
            <label for="validation_status">Cauta <i class="search icon"></i></label>
            <input name="search_locuitori" type="hidden" value="1">
            <input class="cauta form-control" placeholder="Cauta" value="<?php echo @$_SESSION['cauta']?>" type="text" id="cauta" name="cauta">
        </form>
    </div>
    <div class="col-sm-4">
        <div align="right"><a href="/locuitori/locuitor_edit.php" class="ui basic green button ">Adauga locuitor</a></div><br />
        </div>
    </div>
    <div class="ui list" id="lista_locuitori">
    <?php list_locuitori($rows);?>
</div>



<script>
    var form_hash = '';

        $( function () {

            form_hash = $( '#search_locuitori' ).serialize();

            setInterval( function () {

                if ( !$.active && form_hash != $( '#search_locuitori' ).serialize() ) { //check if ajax request is in progress and form has changed
                    msg_bst_thf_loading();
                    form_hash = $( '#search_locuitori' ).serialize();
                    //console.log( form_hash );
                    $.post( '', form_hash, function ( data ) {
                        //console.log( data );

                        $( '#lista_locuitori' ).html( data );
                        form_hash = $( '#search_locuitori' ).serialize();
                        msg_bst_thf_loading_remove();
                    } );
                }
            }, 750 );



        //  $('.raspuns_header').html('<h2>Suma estimata : <?=$suma . ' lei, Colectat :' . $total?> lei</h2>')
        $('[name=strada]').change(function () {
            var idl = $(this).closest('tr').attr('row');
            $.post('',{"idl":idl,"save_strada":$(this).val()},function (raspuns) {
                $('#raspuns_select_'+idl).html(raspuns);
            });
        });
    })
    function approve_plata(id) {
        var approve_plata_status = $('#is_approved_'+id).is(':checked') ? 1:0;
        $.post('',{"approve_plata":id,"is_approved":approve_plata_status},function (raspuns) {
            $('#raspuns_is_approved_'+id).html(raspuns);
        });
    }
    function delete_locuitor(idl)
{
	if ( confirm( "Sigur vrei sa stergi aceasta inregistrare?" ) ) {
			$.post( '', {
				idl: idl,
				delete_locuitor: "1"
			}, function ( data ) {
				alert( "Inregistrare stearsa" );
				window.location.reload();
			} );

		}
	console.log(id_companie);
}
</script>
<?php

index_footer();
