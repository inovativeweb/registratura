<?php



function edit_filiale( $data ) {
global  $organigrame,$organigrame_all,$departamente;
	?>
	<form action="" method="post" enctype="multipart/form-data" id="edit_filiale_<?=@$data['id']?>" class="ui form" role="form" bootstraptoggle="true">
		<input type="hidden" name="id" value="<?=@$data['ido']?>">
		<div class="ui form">
			<div class="three fields">
			<?php
            unset($organigrame[$data[ 'ido' ]]);
            $organigrame[0] = 'Fara Functie';
			input_rolem( 'functie', 'Denumire', @$data[ 'functie' ], 'Functie', false );
            select_rolem( 'parinte', 'Superior', $organigrame, @$data[ 'parinte' ], 'Alege..', false, array() );
            select_rolem( 'departament', 'Departament', $departamente, @$data[ 'departament' ], 'Alege..', false, array() );
			?>
			</div>
		</div>
		<?php
		
		
		if(is_numeric($data['id'])){?>
        <div class="field">
            <div class="ui action input">
                <input type="text" class="upload_file_input" placeholder="Upload logo JPG" readonly>
                <input type="file" name="file_logo" style="display: none" accept="image/jpeg">
                <div class="ui icon button upload_file_input2">
                    <i class="attach icon"></i>
                    <img src="<?=MEDIA?>jpg.png" width="16" height="16"/>
                </div>
            </div>
        </div>
            <?php } ?>
		<input class="btn" type="submit" value="Salveaza"/>
		<input class="btn" type="button" onclick="$('#edit_filiale_<?=@$data['id']?>').remove()" value="Anuleaza"/>
	</form>

	<?php
}




function list_filiale( $rows ) {

	foreach ( $rows as $k => $each_row ) {
        if($each_row['deleted']){ continue;}
		$each_row_description=$each_row;
		$id = $each_row_description['ido'];
        unset($each_row_description['ido']);
		?>


		<div class="item">
            <div class="left floated content">
                <?php if(is_file(THF_UPLOAD . 'organigrama/' .$id .'.jpg')){?>
                <img src="<?=f(UPLOAD . 'organigrama/' .$id .'.jpg');?>" class="logo_img" width="100" />
                <?php } ?>
            </div>
			<div class="right floated content">
				<a onclick="edit_row(<?php echo $each_row['ido']?>)"><i  class=" edit sign icon  outline icon"></i></a>
			</div>
			<div class="right floated content">
				<a onclick="delete_row(<?php echo $each_row['ido']?>)"><i  class="trash alternate outline icon"></i></a>
			</div>
			
			<div class="content" title="<?=implode("; ",$each_row_description);?>">
				<i class="building outline purple icon"></i>
				<?php
				echo $each_row[ 'functie' ];
				?>
			</div>
		</div>
		<div id="raspuns_<?=$each_row['ido'];?>"></div>

		<?php
	}

}
?>