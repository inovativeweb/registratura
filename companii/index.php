<?php
require_once('../config.php');
require_once('functions.php');
$page_head=array(
    'meta_title'=>'companii',
    'trail'=>'companii'

);


require_login();


if (isset($_POST['delete_companie']))
{
	delete_query( 'delete from companie where id_companie="' . $_POST[ 'id_companie' ] . '"' );
	die();
}

if(in_array($userId,array(2,70)) and $userId>0){
    $can_edit = true;
} else {
    $can_edit = false;
}
if($GLOBALS['login']->get_user_level()<10){ redirect(303,LROOT);}

$search_sql = "";
if ( isset( $_SESSION[ 'cauta_companii' ] ) and !isset( $_REQUEST[ 'cauta_companii' ]) and !strlen($_REQUEST[ 'cauta_companii' ])  ) {
    $_REQUEST[ 'cauta_companii' ] = $_SESSION[ 'cauta_companii' ];
} else {
    unset( $_SESSION[ 'cauta_companii' ] );
}


if ( isset( $_REQUEST[ 'cauta_companii' ] )and $_REQUEST[ 'cauta_companii' ]and strlen( trim( $_REQUEST[ 'cauta_companii' ] ) ) ) {
    foreach ( explode( ' ', $_REQUEST[ 'cauta_companii' ] ) as $word ) {
        if ( strlen( $word ) > 0 ) {
            $search_words[] = $word;
        }
    }
    $_SESSION[ 'cauta_companii' ] = $_REQUEST[ 'cauta_companii' ];
}
if ( isset( $search_words ) ) {
    foreach ( $search_words as $word ) {
        $search_sql .= ( $search_sql ? " AND " : "" ) . ( "denumire LIKE '%" . q( $word ) . "%'   " );
    }
}

$search_sql = ( $search_sql ? " ( \r\n $search_sql \r\n ) " : "" );

$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . $search_sql;

$where_sql = ( $where_sql ? "\r\n WHERE " . $where_sql . " " : "" );


$rows=multiple_query("SELECT * FROM `companie` $where_sql ORDER BY `denumire` ASC");

if ( isset( $_POST[ 'search_companii' ] ) ) {
    list_companii( $rows );
    die();
}




index_head();
?>
  <div class="container-fluid">
    <div class='row'>

    <div class="col-sm-8">
        <form action="" method="post" enctype="application/x-www-form-urlencoded" id='search_companii'>
            <label for="validation_status">Cauta <i class="search icon"></i></label>
            <input name="search_companii" type="hidden" value="1">
            <input class="cauta form-control" placeholder="Cauta" value="<?php echo @$_SESSION['cauta_companii']?>" type="text" id="cauta_companii" name="cauta_companii">
        </form>
    </div>
    <div class="col-sm-4">
        <div align="right"><a href="/companii/companie_edit.php" class="ui basic orange button ">Adauga companie</a></div><br />
        </div>
    </div>
    <div class="ui list" id="lista_companii">
    <?php list_companii($rows);?>
</div>


<?php


// table table-striped table-hover table-condensed table-responsive





?>
<script>
var form_hash = '';

        $( function () {

            form_hash = $( '#search_companii' ).serialize();

            setInterval( function () {

                if ( !$.active && form_hash != $( '#search_companii' ).serialize() ) { //check if ajax request is in progress and form has changed
                    msg_bst_thf_loading();
                    form_hash = $( '#search_companii' ).serialize();
                    //console.log( form_hash );
                    $.post( '', form_hash, function ( data ) {
                        //console.log( data );

                        $( '#lista_companii' ).html( data );
                        form_hash = $( '#search_companii' ).serialize();
                        msg_bst_thf_loading_remove();
                    } );
                }
            }, 750 );
	});
	
function delete_companie(id_companie)
{
	if ( confirm( "Sigur vrei sa stergi aceasta inregistrare?" ) ) {
			$.post( '', {
				id_companie: id_companie,
				delete_companie: "1"
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
