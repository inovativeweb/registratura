<div id="contract" class="div_step hide">
    	<div class="row">
		<div class="col-xs-10">
			<div class="main ui intro container">
                <select template_doc_iesire="" name="template_doc_iesire" id="template_doc_iesire" data-placeholder="">
                    <?php
                    $template_uri_doc_iesire_select[0] = 'Adauga Template';
                     foreach ($template_uri_doc_iesire_select as $id=>$nume){
                         $oldx = count_query("SELECT COUNT(*) FROM `documente_propietati` WHERE id_doc = '". $_GET[ 'edit' ] ."' AND valoare = '".$id."' and cheie = 'template_doc_iesire' ") ;
                            IF($oldx>0){continue;}
                         ?>
                    <option value="<?=$id?>" class="option_select_add"><?=$nume?></option>
                    <?php } ?>
                </select>
 <a class="anchor" id="preface"></a>
			
				<br><br>
			</div>
		</div>

		<div class="col-xs-2">
            <a title="Adauga template" class="add_btn" onmousedown="add_template(<?=$pid?>,'add','');"><i class="circular olive plus outline icon"></i></a>
			<!--<a href=""><i class="circular purple download outline icon"></i></a>-->

		</div>
	</div>
    <div class="row">
        <div class="col-xs-12" id="documente_iesire_parent">

	<?php
    echo list_doc_templates($pid);

    ?>
        </div>
    </div>

</div>
<script>

</script>