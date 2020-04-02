<?php

function list_useri( $rows ) {
	global $rol, $asociatii, $access_level_login,$users_all;
	?>
	<table class="table table-striped single line table-hover table-responsive ui brown table " id="users_table">
		<thead>
			<tr>
				<th>Poza</th>
				<th>Nume Prenume</th>
				<th>Biroul de Brokeraj</th>
				<th>Rol</th>
				<th>Oras</th>
				<th>Judet</th>
				<th>Telefon<br/>Email</th>
				<th>Nr afaceri <br> Nr cumparatori</th>
				<?=$access_level_login>9 ? '<th>Activitate</th>':'';?>

			</tr>
		</thead>
		<tbody>
			
				<?php
				foreach ( $rows as $row ) {
					$pictures = json_decode( $row[ 'atasamente' ] );
					?>
			<tr <?=(has_right_user($row['id'],$row['asoc_id'])?'onmousedown="go_to_users('.$row['id'].',this);" style="cursor:pointer"':"")?>  >
				<td>
                    <?php if(strlen($pictures[0][0])){ ?>
					<img src="<?php echo f($pictures[0][0]); ?>" class="logo_img" >
                        <?php } ?>
				</td>
				<td class='for_delete'>
					<?php echo h($row['full_name']); ?>
					<?=(has_right_user($row['id'],$row['asoc_id'])?'<a href="#" onclick="delete_row('.$row['id'].')" title="Sterge"><i  class="circular trash alternate brown icon"></i></a>':"")?>
				</td>
                <td>
                    <?php echo $asociatii[$row['asoc_id']]['nume_asociatie']  ?>
                </td>
				<td>
					<?php echo $rol[$row['access_level']]; ?>
				</td>
				<td>
					<?php echo h($row['localitate']); ?>
				</td>
				<td>
					<?php echo h($row['judet']); ?>
				</td>
				<td>
					<?php echo h($row['tel']); ?>
					<br/>
					<?php echo h($row['mail']); ?>
				</td>
				<td>
					<?php echo '<span style="color:#a333c8 !important; font-size: 1.5em;">'. h($row['afaceri_vanzare']) . '</span>' ?>
					<?php
					$count = count_query("SELECT COUNT(*) FROM cumparatori WHERE business_broker = '".floor($row['id'])."' ");
					echo $count > 0 ? '<span style="color: #b5cc18  !important;font-size: 1.5em;">' . $count . '</span>' : ''?>
				</td>
				<?php if($access_level_login>9){
					$tmp  = $users_all[$row['id']];

					$activitate = ' Ultima logare: '. $tmp['last_login'] . '<br>';
					$activitate .= $tmp['login_attempts'] > 0 ? ' Login_attempts with bad password: '. $tmp['login_attempts'] . '<br>' : '';
					$activitate .= ' Cont confirmat pe email: '. ($tmp['confirmed']>0 ? 'DA' : 'NU') . '<br>' ;
					$activitate .= ' '. ($tmp['blocked_by_admin']>0 ? 'BLOCAT ADMIN <br>' : '')  ;
					$activitate .= ' '. strlen($tmp['ip'])>0 ? ' LAST IP LOGIN '.$tmp['ip'].'<br>' : ''  ;
				}
				echo '<td><div class="ui raised segment">    '.$activitate.'     </div>   </td>'; ?>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>


	<?php
}

function edit_asociatii( $data ) {
global $judete,$localitati,$filiale;
	?>
	<form action="" method="post" enctype="multipart/form-data" id="edit_asociatii_<?=@$data['id']?>" class="ui form" role="form" bootstraptoggle="true">
		<input type="hidden" name="id" value="<?=@$data['id']?>">
		<div class="ui form">
			<div class="two fields">
			<?php
			input_rolem( 'nume_asociatie', 'Denumire', @$data[ 'nume_asociatie' ], 'Nume asociatie', false );
			input_rolem( 'adresa_asociatie', 'Adresa', @$data[ 'adresa_asociatie' ], 'Adresa', false );
			?>
			</div>
			<div class="two fields">
			<?php
			$judete=array(""=>"Selecteaza judet") + $judete; 
			select_rolem( 'judet_id', 'Judetul', $judete, @$data[ 'judet_id' ], 'Alege..', false, array() );
			select_rolem( 'localitate_id', 'Oras ', $localitati, @$data[ 'localitate_id' ], 'Alege...', false, array() );
			?>
			</div>
			<div class="two fields">
			<?php
			input_rolem( 'reg_com_asociatie', 'Nr inregistrare', @$data[ 'reg_com_asociatie' ], 'REG.Com', false );
			input_rolem( 'cui_asociatie', 'Cui', @$data[ 'cui_asociatie' ], 'C.U.I.', false );
			?>
			</div>
			<div class="two fields">
			<?php
			 input_rolem('cont_iban_asociatie', 'Cont IBAN', @$data['cont_iban'], '', false);
   			 input_rolem('banca_asociatie', 'Banca', @$data['banca'], '', false);
			?>
			</div>
			<div class="two fields">
			<?php
			 input_rolem('tel_asociatie','Telefon',@$data['tel'],'',false);
             input_rolem('email_asociatie','Email',@$data['email'],'',false);
			?>
			</div>
			<div class="two fields">
			<?php
			input_rolem('website_asociatie','Website',@$data['website'],'',false);
			select_rolem( 'filiala_id', 'Filiala ', $filiale, @$data[ 'filiala_id' ], 'Alege...', false, array() );
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
		<input class="btn" type="button" onclick="$('#edit_asociatii_<?=@$data['id']?>').remove()" value="Anuleaza"/>
	</form>

	<?php
}


function edit_filiale( $data ) {
global $judete,$localitati;
	?>
	<form action="" method="post" enctype="multipart/form-data" id="edit_filiale_<?=@$data['id']?>" class="ui form" role="form" bootstraptoggle="true">
		<input type="hidden" name="id" value="<?=@$data['id']?>">
		<div class="ui form">
			<div class="two fields">
			<?php
			input_rolem( 'nume_filiala', 'Denumire', @$data[ 'nume_filiala' ], 'Nume filiala', false );
			input_rolem( 'adresa_filiala', 'Adresa', @$data[ 'adresa_filiala' ], 'Adresa', false );
			?>
			</div>
			<div class="two fields">
			<?php
			$judete=array(""=>"Selecteaza judet") + $judete; 
			select_rolem( 'judet_id', 'Judetul', $judete, @$data[ 'judet_id' ], 'Alege..', false, array() );
			select_rolem( 'localitate_id', 'Oras ', $localitati, @$data[ 'localitate_id' ], 'Alege...', false, array() );
			?>
			</div>
			<div class="two fields">
			<?php
			input_rolem( 'reg_com_filiala', 'Nr inregistrare', @$data[ 'reg_com_filiala' ], 'REG.Com', false );
			input_rolem( 'cui_filiala', 'Cui', @$data[ 'cui_filiala' ], 'C.U.I.', false );
			?>
			</div>
			<div class="two fields">
			<?php
			 input_rolem('cont_iban_filiala', 'Cont IBAN', @$data['cont_iban'], '', false);
   			 input_rolem('banca_filiala', 'Banca', @$data['banca'], '', false);
			?>
			</div>
			<div class="two fields">
			<?php
			 input_rolem('tel_filiala','Telefon',@$data['tel'],'',false);
             input_rolem('email_filiala','Email',@$data['email'],'',false);
			?>
			</div>
			<div class="two fields">
			<?php
			input_rolem('website_filiala','Website',@$data['website'],'',false);
             
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



function list_asociatii( $rows ) {

	foreach ( $rows as $k => $each_row ) {
		$each_row_description=$each_row;
		$id = $each_row_description['id'];
        unset($each_row_description['id']);
		?>


		<div class="item">
            <div class="left floated content">
                <?php if(is_file(THF_UPLOAD . 'firme_management/' .$id .'.jpg')){?>
                <img src="<?=f(UPLOAD . 'firme_management/' .$id .'.jpg');?>" class="logo_img" width="100" />
                <?php } ?>
            </div>
			<div class="right floated content">
				<a onclick="edit_row(<?php echo $each_row['id']?>)"><i  class=" edit sign icon  outline icon"></i></a>
			</div>
			<div class="right floated content">
				<a onclick="delete_row(<?php echo $each_row['id']?>)"><i  class="trash alternate outline icon"></i></a>
			</div>
			
			<div class="content" title="<?=implode("; ",$each_row_description);?>">
				<i class="building outline purple icon"></i>
				<?php
				echo $each_row[ 'nume_asociatie' ];
				?>
			</div>
		</div>
		<div id="raspuns_<?=$each_row['id'];?>"></div>

		<?php
	}

}

function list_filiale( $rows ) {

	foreach ( $rows as $k => $each_row ) {
		$each_row_description=$each_row;
		$id = $each_row_description['id'];
        unset($each_row_description['id']);
		?>


		<div class="item">
            <div class="left floated content">
                <?php if(is_file(THF_UPLOAD . 'filiale_management/' .$id .'.jpg')){?>
                <img src="<?=f(UPLOAD . 'filiale_management/' .$id .'.jpg');?>" class="logo_img" width="100" />
                <?php } ?>
            </div>
			<div class="right floated content">
				<a onclick="edit_row(<?php echo $each_row['id']?>)"><i  class=" edit sign icon  outline icon"></i></a>
			</div>
			<div class="right floated content">
				<a onclick="delete_row(<?php echo $each_row['id']?>)"><i  class="trash alternate outline icon"></i></a>
			</div>
			
			<div class="content" title="<?=implode("; ",$each_row_description);?>">
				<i class="building outline purple icon"></i>
				<?php
				echo $each_row[ 'nume_filiala' ];
				?>
			</div>
		</div>
		<div id="raspuns_<?=$each_row['id'];?>"></div>

		<?php
	}

}
?>