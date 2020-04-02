<?php
require ('controller.php');
$page_head = array( 'meta_title' => 'Contul meu',
	'trail' => 'Useri');



if ($access_level_login<2 && ($_GET[ 'edit' ]=='i' || floor($_GET[ 'edit' ]!=$_GET[ 'edit' ])) ){redirect(307,'/');die('low access can`t insert');} //low access can't insert

if (isset($_POST['check_mail']))
{
	$check_user = multiple_query("SELECT * FROM `thf_users` WHERE  mail='".$_POST['mail']."' and id<>'".$_POST['id_user']."' ");
	if (count($check_user)>0)
	{
		echo "Duplicate email address";
	}
	
	die();
}


if ( isset( $_GET[ 'edit' ] ) && $_GET[ 'edit' ] != 'i' ) {
	$user = many_query( "SELECT * FROM `thf_users`  WHERE `id`='" . floor( $_GET[ 'edit' ] ) . "'  LIMIT 1 " );
	$pid = floor( $user[ 'id' ] );
	if($access_level_login<$user['access_level'] || $access_level_login<2 && $pid!=$user_id_login){redirect(307,'/');die('lower access lvl or broker attpempt to access other id');}
	
	$loc = multiple_query( "select * from localizare_localitati where parinte  = '" . $user[ 'judet_id' ] . "' " );
	foreach ( $loc as $k => $v ) {
		$localitati[ $v[ 'id' ] ] = $v[ 'localitate' ];
	}
	if ( !$user ) {
		die( 'Invalid user' );
	}
} else {
	$pid=0;
	$user = array( 'atasamente' => null );
} //insert




ThfGalleryEditor::$ajax_upload = true;
ThfGalleryEditor::$max_files = 2;
ThfGalleryEditor::$accept = 'jpg|jpeg|png';
ThfGalleryEditor::$web_path = UPLOAD . 'thf_users/';
ThfGalleryEditor::$sv_path = THF_ROOT . UPLOAD . 'thf_users/';
ThfGalleryEditor::$file_name_policy = '*i*';
ThfGalleryEditor::$overwritePolicy = 'r';
ThfGalleryEditor::$id = floor( $pid ); //specifica ce id are produsul pentru a putea urca asincron poze si file





if ( count( $_POST ) || $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
	$tablename = 'thf_users';
	ThfAjax::$out[ 'show_time' ] = 2000;
            //prea($_POST);
	if(!strlen($_POST['pass'])){    $_POST['pass'] = 'tradex';}

	ThfGalleryEditor::$database_pics = ( is_numeric( $pid ) && $pid > 0 ? json_decode( $user[ 'atasamente' ], true ) : array() ); //load existing stored pictures
	ThfGalleryEditor::actionFileController(); //unlinks files fron the drive and updates ThfGalleryEditor::$database_pics
	ThfGalleryEditor::uploadController();
	ThfGalleryEditor::resize_uploaded_pics( $resize_policy, $remove_original_pic = false );

	$_POST[ 'atasamente' ] = json_encode( array_merge( ThfGalleryEditor::$database_pics, ThfGalleryEditor::$new_pics ) );

	if ( isset($_POST[ 'access_level' ]) ) {
		$_POST[ 'access_level' ] = min($_POST[ 'access_level' ],$access_level_login);
	}

	if ( isset($_POST[ 'pass' ]) && strlen( $_POST[ 'pass' ] ) != 32 ) {
		$_POST[ 'pass' ] = md5( $_POST[ 'pass' ] );
	}
	
	
	if ( isset( $_GET[ 'edit' ] ) && is_numeric( $_GET[ 'edit' ] ) ) { //update
	
		update_qaf( 'thf_users', $_POST, '`id`=' . @floor( $_GET[ 'edit' ] ), 'LIMIT 1' );
		insert_update_user($_GET[ 'edit' ]);
		ThfAjax::status( true, 'Updated successfully!' );
		ThfAjax::json();
	} else { //insert
		
			$last_id = insert_qa( 'thf_users', $_POST );
			$_POST['date_created']=date("Y-m-d H:i:s");
			insert_update_user($last_id);
			ThfAjax::status( true, 'Inserted successfully!' );
			//header("'user_edit?edit=' . $last_id");
			 echo "<script>window.top.location.href = \"user_edit.php?edit=".$last_id."\";</script>"; 
			ThfAjax::redirect( 'user_edit.php?edit=' . $last_id );
			//ThfAjax::json();
		
	}
}



				$rolx=array();
				foreach($rol as $rol_int=>$rol_str){
					if($rol_int && $access_level_login>=$rol_int){
						$rolx[$rol_int]=$rol_str;
					}
				}


if ( !isset( $_GET[ 'edit' ] ) ) { //INSERT FORM 
	iframe_head();
	?>
    <div class="container-fluid">
	<form action="" method="post" enctype="multipart/form-data"  class="form-horizontal ui form users_form uri " role="form" id='add_user_form'>
	<div class="ui error message"><i class="close icon"></i></div>

<h4 class="ui horizontal divider header">
  <i class="address card icon brown"></i>
  Date personale
</h4>
		<div class="ui form">
			<div class="two fields">
				<?php
				
				input_rolem( 'full_name', 'Nume Prenume', $user[ 'full_name' ], 'Nume Prenume', false, array()   );
				//input_rolem( 'username', 'Username', $user[ 'username' ], 'utilizator', false, array() );
				if(is_numeric($_GET['edit'])) {
                    input_rolem('pass', 'Parola criptata', $user['pass'], 'Minim 6 caractere. .', false, array());
                }
				?>
			</div>
		</div>

		<div class="ui form">
			<div class="three fields">
				<?php
				input_rolem( 'mail', 'Email', $user[ 'mail' ], 'Email', false, array( 'type' => 'email' ) );
				input_rolem( 'tel', 'Telefon', $user[ 'tel' ], 'Tel', false, array() );
				input_rolem( 'website', 'Website', $user[ 'website' ], 'Website', false, array() );
				?>
			</div>
		</div>

		<div class="ui form localitati_judete">
			<div class="two fields">
	<?php
	$judete=array(""=>"Selecteaza judet") + $judete; 
	
				select_rolem( 'judet_id', 'Judetul', $judete, $user[ 'judet_id' ], 'Alege..', false, array() );
				select_rolem( 'localitate_id', 'Oras ', $localitati, $user[ 'localitate_id' ], 'Alege...', false, array() );
				?>
			</div>
		</div>
		<div class="ui form">
			<div class="two fields">
				<?php

				input_rolem( 'job_title', 'Job title', $user[ 'job_title' ], 'Job title', false, array() );
				input_rolem( 'company', 'Company', $user[ 'company' ], 'Company', false, array() );
				?>
			</div>
		</div>
		<div class="ui form">
			<div class="two fields">
				<?php

				select_rolem('asoc_id','Biroul de Brokeraj',($access_level_login<=2?array($asoc_id_login=>$asoc[$asoc_id_login]):$asoc),$user['asoc_id'],'Alege...');
				select_rolem('access_level','Rol',$rolx,$user['access_level'],'Alege...');

				?>
			</div>
		</div>


     <div class="ui form align center">
         <div class="field" align="center">
  		<button type="button" onclick="add_user('add_user_form','0')" name='Salveaza' class="ui brown basic button">Adauga</button>
		</div>
		</div>


	</form>
    </div>
	<?php

}

else { //UPDATE FORM
    if(!isset($_GET['type'])){$_GET['type'] = 'personale';}
	index_head();	?>
	<script>
		<?php ThfGalleryEditor::javascript_settings(); ?>
	</script>
	<div class="ui top attached tabular menu">
		<div class="<?=($_GET['type'] == 'personale' ? ' active ' :'')?>item"> <a href="/useri/user_edit.php?type=personale&edit=<?=$_GET['edit']?>"><i class="address card icon brown"></i>Date personale</a></div>
		<div class="<?=($_GET['type'] == 'companie' ? ' active ' :'')?>item"> <a href="/useri/user_edit.php?type=companie&edit=<?=$_GET['edit']?>"><i class="circular olive dollar icon"></i>Datele companiei mele</a></div>
	</div>
	<?php if($_GET['type'] == 'personale'){?>
<div class="ui bottom attached active tab segment">
	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal ThfGalleryEditorForm ui form users_form" role="form" bootstraptoggle="true" serialize="false" id='users_from'  >
<div class="ui error message"></div>
		<div class="ui form">
			<div class="two fields">
				<?php

				input_rolem( 'full_name', 'Nume Prenume', $user[ 'full_name' ], 'Nume Prenume', false );
			//	input_rolem( 'username', 'Username', $user[ 'username' ], 'utilizator', false );
				input_rolem( 'pass', 'Parola criptata', $user[ 'pass' ], 'Minim 6 caractere. Pentru o parola noua, modifica si salveaza.', false, array( 'attr' => array( 'title' => 'Pentru o parola noua, modifica si salveaza.' ) ) );
				?>
			</div>
		</div>

		<div class="ui form">
			<div class="three fields">
				<?php
				input_rolem( 'mail', 'Email', $user[ 'mail' ], 'Email', false, array( 'type' => 'email' ) );
				input_rolem( 'tel', 'Telefon', $user[ 'tel' ], 'Tel', false, array() );
				input_rolem( 'website', 'Website', $user[ 'website' ], 'Website', false, array() );
				?>
			</div>
		</div>

		<div class="ui form localitati_judete">
			<div class="two fields">
	<?php

				select_rolem( 'judet_id', 'Judetul', $judete, $user[ 'judet_id' ], 'Alege..', false, array() );
				select_rolem( 'localitate_id', 'Oras ', $localitati, $user[ 'localitate_id' ], 'Alege...', false, array() );
				?>
			</div>
		</div>
		<div class="ui form">
			<div class="two fields">
				<?php

				input_rolem( 'job_title', 'Job title', $user[ 'job_title' ], 'Job title', false, array() );
				input_rolem( 'company', 'Company', $user[ 'company' ], 'Company', false, array() );
				?>
			</div>
		</div>
		<div class="ui form">
			<div class="two fields">
				<?php
				if ($access_level_login>9)
				{
					select_rolem('asoc_id','Biroul de Brokeraj',$asoc,$user['asoc_id'],'Alege...');
					select_rolem('filiala_id','Filiala',$filiale,$user['filiala_id'],'Alege...');
					select_rolem('access_level','Rol',$rolx,$user['access_level'],'Alege...');
				}
				else
				{
					
					?>
					
					
				<div class="field "><label class="control-label">Asociatie</label>
				<?php echo $asoc[$user['asoc_id']]?$asoc[$user['asoc_id']]:'-'; ?>
				</div><div class="field "><label class="control-label">Rol</label>
				<?php echo $rol[$user['access_level']]; ?>
			
		</div>
					
					<?php
				}
				
				?>
			</div>
		</div>
		<h4 class="ui horizontal divider header">
  <i class="tag icon brown"></i>
  Descriere si poza
	<input type="radio" value="ro" checked onclick="change_desc_user('ro');" name="lang_user" id='lang'>&nbsp;<i class="ro flag"></i>
    <input type="radio" value="en" onclick="change_desc_user('en');"  name="lang_user" id='lang'>&nbsp;<i class="gb uk flag"></i>
</h4>

	
	
<div class="ui grid">
  <div class="eight wide column" id='description'>
			<textarea class="tinymce"  name='description'  rows="5"><?php echo $user['description']; ?></textarea>
		</div>
	<div class="eight wide column" id='description_en' style='display:none'>
			<textarea class="tinymce" id='description_en' name='description_en'  rows="5"><?php echo $user['description_en']; ?></textarea>
		</div>
<div class="eight wide column">
			<?php  //prea($produs);
		$poze=ThfGalleryEditor::get_poze_produs($user['atasamente']);
		ThfGalleryEditor::pics_layout_frontend($poze);
		?>
</div>			
		</div>
	<br/><br/>	

<div class="ui grid">
  
<div class="twelve wide column">
  		
		
  	
</div>
  <div style="position:fixed; bottom:5px; right:5px; padding: 3px; z-index:1000;" class="ui brown message">

    <button type="button" onclick="add_user('users_from','<?php echo $user['id']  ?>')" name='Salveaza' class="ui green button">Salveaza</button>
    <a href="index.php"><i id="loading_save" class="spinner loading icon hide"></i><input type="button" class="ui teal button" id="go_to_documente"  value="Inchide"/></a>
</div>
</div>

	</form>
</div>
		<?php }
	if($_GET['type'] == 'companie') { ?>
<div class="ui bottom attached active tab segment">
	<?php companie_edit_insert($user['id_companie_user'],$from_doc,'adauga_companie_user', 'Date companie');?>
</div>


		<script>
            $(function () {

                $( '#forma_adauga_companie_user' )
                    .submit( function( e ) {
                        msg_bst_thf_loading();
                        e.preventDefault();
                        $.ajax( {
                            url: '/useri/user_edit.php?id_user_companie=<?=$user['id_companie_user'];?>&edit=<?=$_GET['edit']?>',
                            type: 'POST',
                            data: new FormData( this ),
                            cache: false,
                            contentType: false,
                            processData: false
                        } ).done(function (r) {
                            ThfAjax(r);

                            date = new Date().getTime();
                            $('#logo_companie_user').attr('src','/dms/useri_companii/<?=$_GET['edit']?>.jpg?'+date);
                            msg_bst_thf_loading_remove();
                        });
                    } );
            });

			function save_companie_user(user_id,id_user_companie) {

			    $.post("/useri/user_edit.php?id_user_companie="+id_user_companie+"&edit="+user_id,$('#forma_adauga_companie_user').serialize(),function (r) {
			    	ThfAjax(r);
				});
			}
			
			
		</script>

	<?php } ?>
	<script>
	
		    $(function () {
		    	if ($("#access_level").val()==3)
		    	{
					$("#asoc_id").parent().hide();	
				}
				else
				{
					$("#filiala_id").parent().hide();
				}
        $("#access_level").chosen().change(function(){
					if ($("#access_level").val()==3)
		    	{
					$("#asoc_id").parent().hide();	
					$("#filiala_id").parent().show();
				}
				else
				{
					$("#asoc_id").parent().show();
					$("#filiala_id").parent().hide();
				}
			});
		    	
			});
			
			
		function change_desc_user(lg)
	{
          	if (lg=='ro')
          	{
				$('#description').css("display","block");
				$('#description_en').css("display","none");
			}
			else
			{
				$('#description').css("display","none");
				$('#description_en').css("display","block");
			}
    };
  
</script>
	<?php
	index_footer();
}

?>

<script>
  function add_user(form_id,id_user)
			{
			
				
				  $.post("",{"mail" : $('#'+form_id+' input[name=mail]').val(),'check_mail':1,'id_user':id_user},function (r) {
				        //    $('#save_companie_btn').css('color','white');
					       if (r=='Duplicate email address')
					       	{
					       		$("#"+form_id).find("#div_mail").addClass("error");
					       		$("#"+form_id).find(".message").show();
					       		$("#"+form_id).find(".error.message").html('<ul class="list"><li>Duplicate email addres</li></ul>');
					       		
							}
							else
							{
								//console.log("submit");
								$("#"+form_id).submit();
							}
				        });
			}
</script> 