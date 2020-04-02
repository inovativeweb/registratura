<?php
require_once( '../config.php' );
require_once( 'functions.php' );
$page_head = array(
    'meta_title' => 'Organigrama edit',
    'trail' => 'organigrama_edit'

);
if ( $GLOBALS[ 'login' ]->get_user_level() < 10 ) {
    redirect( 303, LROOT );
}



if ( isset( $_POST[ 'functie' ] ) ) {
    if($_POST['id']){
        if(count($_FILES)){
            $uploads_dir =  THF_ROOT . UPLOAD . 'organigrama/';
            $file_name = $_POST['id'].'.jpg';
            $r = move_uploaded_file($_FILES['file_logo']['tmp_name'],$uploads_dir.$file_name);
        }
        update_qaf('organigrama',$_POST,"ido='".floor($_POST['id'])."'",$limit='LIMIT 1', $keys_to_exclude=array('id'), $setify_only_keys=array(), $return_query=false);
    }
    else{
        $last_id = insert_qa( 'organigrama', $_POST );
    }
    redirect();
}

$search_sql = "";
if ( isset( $_SESSION[ 'cauta' ] )and!isset( $_REQUEST[ 'cauta' ] ) ) {
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
        $search_sql .= ( $search_sql ? " AND " : "" ) . ( "functie LIKE '%" . q( $word ) . "%'   " );
    }
}

$search_sql = ( $search_sql ? " ( \r\n $search_sql \r\n ) " : "" );

$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . $search_sql;

$where_sql = ( $where_sql ? "\r\n WHERE " . $where_sql . " " : "" );



$rows = multiple_query( "SELECT * from organigrama $where_sql  ORDER BY functie ASC" );

if ( isset( $_POST[ 'search_filiale' ] ) ) {
    list_filiale( $rows );
    die();
}


if ( isset( $_POST[ 'delete_filiala' ] ) ) {
    update_query( "UPDATE `organigrama` SET `deleted` = '1' WHERE `organigrama`.`ido` '" . $_POST[ 'filiala_id' ] . "' " );

}

index_head();
// table table-striped table-hover table-condensed table-responsive

echo list_menu_settings();
?>
    <div class="ui bottom attached active tab segment">
    <div class="container-fluid">
        <div class='row'>

            <div class="col-sm-8">
                <form action="" method="post" enctype="application/x-www-form-urlencoded" id='search_filiale'>
                    <label for="validation_status">Cauta <i class="search icon"></i></label>
                    <input name="search_filiale" type="hidden" value="1">
                    <input class="cauta form-control" placeholder="Cauta" value="<?php echo @$_SESSION['cauta']?>" type="text" id="cauta" name="cauta">
                </form>




                <div class="ui list" id='lista_filiale'>
                    <?php
                    list_filiale( $rows );
                    ?>
                </div>
            </div>

            <div class='col-sm-12'>
                <form action="" method="post" enctype="application/x-www-form-urlencoded" class="form-inline">
                    <div class="form-group" style="margin-top: 25px;">
                        <input type="text" class='form-control' name='functie' placeholder="nume functie">
                        <input type='submit' class='ui mini primary button' name='adauga' value='Adauga' >
                    </div>
                </form>
            </div>


        </div>
    </div>
    <script>
        var form_hash = '';

        $( function () {

            form_hash = $( '#search_filiale' ).serialize();

            setInterval( function () {

                if ( !$.active && form_hash != $( '#search_filiale' ).serialize() ) { //check if ajax request is in progress and form has changed
                    msg_bst_thf_loading();
                    form_hash = $( '#search_filiale' ).serialize();
                    //console.log( form_hash );
                    $.post( '', form_hash, function ( data ) {
                        //console.log( data );

                        $( '#lista_filiale' ).html( data );
                        form_hash = $( '#search_filiale' ).serialize();
                        msg_bst_thf_loading_remove();
                    } );
                }
            }, 750 );

        } );


        function edit_row( id ) {
            $.post( '/organigrama/controller.php', {
                "edit_row_filiala": id
            }, function ( r ) {
                $( '#raspuns_' + id ).html( r );
                input_actions();
            } );

        }

        function delete_row( id ) {
            if ( confirm( "Sigur vrei sa stergi aceasta inregistrare?" ) ) {
                $.post( '', {
                    filiala_id: id,
                    delete_filiala: "1"
                }, function ( data ) {
                    alert( "Inregistrare stearsa" );
                    window.location.reload();
                } );

            }
        }
    </script>


<?php
index_footer();
?>