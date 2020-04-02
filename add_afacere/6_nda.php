<div id="nda_tab" class="div_step hide">
<div class="row">
		<div class="col-xs-10">
			<div class="main ui intro container">

				<h2 class="ui dividing header">
                        ACORD DE CONFIDENTIALITATE  <a class="anchor" id="preface"></a></h2>
			
				<br><br>
			</div>
		</div>

		<div class="col-xs-2">
			<a class="print_btn" id="pint_save" target="_blank" style="<?=strlen($vanzare['nda']) > 100 ? '' : 'display: none'?>" href="/pdf.php?doc=<?=$vanzare['idv']?>&nda"><i class="circular purple file pdf outline icon"></i></a>
			<a title="Editeaza" class="edit_btn" onmousedown="edit_nda(<?=$vanzare['idv']?>);"><i class="circular purple edit outline icon"></i></a>
			<a title="Salveaza" class="save_btn" style="display: none;" onmousedown="save_nda(<?=$vanzare['idv']?>);"><i class="circular purple save outline icon"></i></a>
			<!--<a href=""><i class="circular purple download outline icon"></i></a>-->

		</div>
	</div>
    <div class="row">
        <div class="col-xs-12" id="forma_nda">


	<?php

    if(strlen($vanzare['nda']) > 100) {
           echo  $vanzare['nda'];
    } else {
        
            echo contract_template($vanzare['idv'],6);
    }

    ?>
        </div>
    </div>
    <div id="forma_nda_val" style="display: none;">
    <textarea class="tinymce" rows="30" id="nda_val"></textarea>
    </div>
</div>
<script>
	$('#pint_save').mousedown(function(){
		save_nda(<?=$vanzare['idv']?>);
	});
	
	
    function save_nda(idv) {
       var new_val = tinymce.get('nda_val').getContent();
       $.post("",{"idv":idv,"new_text_nda":new_val},function (r) {
           ThfAjax(r);
            $('.print_btn').show();
            $('.edit_btn').show();
            $('.save_btn').hide();
            $('#forma_nda_val').hide();
            $('#forma_nda').html(new_val).show();
            $('[step=nda]').addClass('completed');
       });
    }
    function edit_nda(idv) {
        val = $('#forma_nda').html();
        $('.edit_btn').hide();
        $('.save_btn').show();
        $('#forma_nda').hide();
        $('#forma_nda_val').show();

        tinymce.get('nda_val').setContent(val);



    }
</script>