<?php
require( '../config.php' );

require_login();

require_once( 'functions.php' );

if(isset($_REQUEST['id_user_companie'])) {
    if(count($_FILES)){
        $uploads_dir =  THF_ROOT . UPLOAD . 'useri_companii/';
        $file_name = $_GET['edit'].'.jpg';
        $r = move_uploaded_file($_FILES['file_logo']['tmp_name'],$uploads_dir.$file_name);
    }
    unset($_POST['from_document']);

   // prea($_POST);
	if (is_numeric($_GET['id_user_companie']) and $_GET['id_user_companie'] > 0) {        //update
		update_qaf('companie', $_POST, '`id_companie`=' . @floor($_POST['edit_companie']), 'LIMIT 1');
		ThfAjax::status(true, 'Compania salvata cu succes!');
      //  ThfAjax::redirect( '?edit=' . $_GET['edit'] );
		ThfAjax::json();
	} else {           																	 //insert
		$last_id = insert_qa('companie', $_POST);
		update_query("UPDATE `thf_users` SET `id_companie_user` = '$last_id' WHERE `thf_users`.`id` = '".floor($_GET['edit'])."' ;");
		ThfAjax::status(true, 'Compania creata cu succes!');
      //  ThfAjax::redirect( '?edit=' . $_GET['edit'] );
		ThfAjax::json();
	}

}



if ( isset( $_POST[ 'edit_row' ] )AND is_numeric( $_POST[ 'edit_row' ] ) ) {
	edit_asociatii(many_query( "SELECT * from asociatii WHERE id='".floor($_POST[ 'edit_row' ])."' LIMIT 1" )  );
	die();
}


if ( isset( $_POST[ 'edit_row_filiala' ] )AND is_numeric( $_POST[ 'edit_row_filiala' ] ) ) {
	edit_filiale(many_query( "SELECT * from filiale WHERE id='".floor($_POST[ 'edit_row_filiala' ])."' LIMIT 1" )  );
	die();
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
		$search_sql .= ( $search_sql ? " AND " : "" ) . ( "full_name LIKE '%" . q( $word ) . "%'   " );
	}
}

if ( $access_level_login <= 2 ) {
//	$search_sql .= ( $search_sql ? " AND " : "" ) . ( "asoc_id='" . $asoc_id_login . "'   " );
}
if ( $access_level_login == 1 ) {
//	$search_sql .= ( $search_sql ? " AND " : "" ) . ( "tu.id='" . $user_id_login . "'   " );
}
$search_sql = ( $search_sql ? " ( \r\n $search_sql \r\n ) " : "" );

$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . $search_sql;

//$where_sql .= ( $where_sql ? "\r\r AND " : "" ) . " tu.access_level<='{$access_level_login}' ";

$where_sql = ( $where_sql ? "\r\n WHERE " . $where_sql . " " : "" );



$rows = multiple_query( "SELECT tu.id,tu.full_name,tu.username,tu.access_level,ll.localitate,
lj.nume_judet as judet,tu.mail,tu.tel,tu.website,tu.job_title,tu.company,tu.atasamente,tu.asoc_id,
(SELECT COUNT(*) FROM vanzare where uid = tu.id) as afaceri_vanzare
 FROM `thf_users` tu 
left join localizare_judete lj on tu.judet_id=lj.id 
left join localizare_localitati ll on tu.localitate_id=ll.id $where_sql  ORDER BY tu.id ASC" );



$asoc = array( "" => "Alege" );
$asoc_query = multiple_query( "select * from asociatii order by nume_asociatie asc" );
foreach ( $asoc_query as $k => $v ) {
	$asoc[ $v[ 'id' ] ] = $v[ 'nume_asociatie' ];
}



if ( isset( $_REQUEST[ 'ajax' ] ) ) { //call ajax data



	list_useri( $rows );


	die();

}

if ( isset( $_POST[ 'delete_user' ] ) ) {
	delete_query( 'delete from thf_users where id="' . $_POST[ 'user_id' ] . '"' );
	die();
}

function has_right_user($user_id,$assoc_id)
{
	global $user_id_login,$asoc_id_login,$access_level_login;
	if ($access_level_login>9 || ($access_level_login==2 && $assoc_id==$asoc_id_login) || ($access_level_login==1 && $user_id==$user_id_login))
	{
		return true;
	}
	else
	{
		return false;	
	}
	
}
?>