<?php
require( 'controller.php' );

$page_head = array(
	'meta_title' => 'Useri',
	'trail' => 'Useri'

);


index_head();


?>
<div class="container-fluid">
	<div class="row">


		<?php
		if ( $access_level_login > 1 ) { ?>
		<div class="col-sm-2 right">
			<BR><a href="user_edit.php" class="ui brown basic button iframe">Adauga broker</a>
		</div>

		<?php } ?>
		<div class="col-sm-6 right"></div>
		<div class="col-sm-4">
			<form action="" method="post" enctype="application/x-www-form-urlencoded" id="cms_filters">

				<label for="validation_status">Cauta <i class="search icon"></i></label>
				<input name="ajax" type="hidden" value="1">
				<input class="cauta form-control" placeholder="Cauta" value="<?php echo @$_SESSION['cauta']?>" type="text" id="cauta" name="cauta">

			</form>
		</div>
	</div>

</div>

<?php

?>

<script>
	var form_hash = '';

	$( function () {
		$('form').submit(function(e){
			e.preventDefault();
			e.stopPropagation();
		});
		form_hash = $( '#cms_filters' ).serialize();

		setInterval( function () {

			if ( !$.active && form_hash != $( '#cms_filters' ).serialize() ) { //check if ajax request is in progress and form has changed
				msg_bst_thf_loading();
				form_hash = $( '#cms_filters' ).serialize();
				$.post( 'controller.php', form_hash, function ( data ) {
					//console.log( data );
					$( '#table_useri' ).html( data );
					$( ".iframe" ).colorbox( {
						iframe: true,
						width: "80%",
						height: "75%"
					} );
					msg_bst_thf_loading_remove();
				} );
			}
		}, 750 );

	} );





	function delete_row( id ) {
		if ( confirm( "Sigur vrei sa stergi aceasta inregistrare?" ) ) {
			$.post( 'controller.php', {
				user_id: id,
				delete_user: "1"
			}, function ( data ) {
				alert( "Inregistrare stearsa" );
				window.location.reload();
			} );

		}
	}
	
	 function go_to_users(id,tr){
  $(tr).find('td:not(.for_delete)').mouseup(function(){
   window.location.href='user_edit.php?edit='+id;
   });
  
 }
</script>
<hr/>
<div class="container-fluid">
	<div class="row">
		<div id="table_useri" class="col-xs-12">
			<?php list_useri($rows); ?>
		</div>
	</div>
</div>
<?php
index_footer();
?>