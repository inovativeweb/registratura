<?php function list_contracte( $rows ) {
    echo '<div class="ui middle aligned divided list">';
    foreach ( $rows as $k => $each_row ) {
        $each_row_description=$each_row;
        unset($each_row_description['id']);

        ?> <div class="item">
            <div class="content">
                <i class=" file alternate outline icon"></i>
                <?php
                echo $each_row[ 'nume_contract' ];
                ?>
            </div>
            <div class="right floated content">
                <a onclick="edit_row(<?php echo $each_row['id']?>)"><i  class=" edit sign icon  outline icon"></i></a>
            </div>
            <div class="right floated content">
                <a onclick="delete_row(<?php echo $each_row['id']?>)"><i  class="trash alternate outline icon"></i></a>
            </div>

            <div id="raspuns_<?=$each_row['id'];?>"></div>
        </div>


        <?php }
    echo '</div>';
}

function edit_contracte( $data ) {
	$key_template=get_contract_template_values(0);

    ?>

    <form action="" method="post" enctype="application/x-www-form-urlencoded" id="edit_asociatii_<?=@$data['id']?>" class="ui form" role="form" bootstraptoggle="true">
        <div class="col-sm-10">
        <input type="hidden" name="id" value="<?=@$data['id']?>">
        <?php
        input_rolem( 'nume_contract', 'Nume contract', @$data[ 'nume_contract' ], 'Nume contract', false );
        ?>
        <div class="field" id='descriere_publica_ro'>
            <label>Text </label>
            <textarea class="tinymce" placeholder="" name="text"><?=$data['text'];?></textarea>
        </div>
        <input class="btn" type="submit" value="Salveaza"/>
        <input class="btn" type="button" onclick="$('#edit_asociatii_<?=@$data['id']?>').remove()" value="Anuleaza"/>

    </div>
    <div class="col-sm-2">
        <h2>Valori disponibile</h2>
        <?php
        $types=array();
        foreach ($key_template as $v=>$k){
        	$val=explode(".",$v)[0];
        	if (!isset($types[$val])) $types[$val]=$val;
		}
        ?>
        <select name='val_type_<?=@$data['id']?>' id='val_type_<?=@$data['id']?>' onchange="change_values(this.value,<?=@$data['id']?>)" style="width:200px">
        <option value="" disabled="" selected>Alege..</option>
        <?php
        foreach ($types as $k=>$v)
        	{
				echo "<option value='".$v."_".@$data['id']."'>".ucfirst(str_replace("_"," ",$v))."</option>";
			}
        ?>
        </select>
        <br/><br/>
        <ul title="Click to copy">
        <?php  foreach ($key_template as $v=>$k){  ?>
            <li class='<?=explode(".",$v)[0]."_".@$data['id']?> list_items_<?=@$data['id']?> all_list_items' style='display:none' >###<?=$v;?>###</li>
        <?php } ?>
        </ul>
    </div>
    </form>
    <?php
}

