<div id="oferta" class="div_step hide">
	<div class="row">
		<div class="col-xs-10">
			<div class="main ui intro container">

				<h2 class="ui dividing header">
                        Oferta de Asistare in Vederea Vânzării Afacerii  <a class="anchor" id="preface"></a></h2>
			
				<br><br>
			</div>
		</div>

		<div class="col-xs-2">
			<a class="print_btn" id="pint_save" target="_blank" style="<?=strlen($vanzare['oferta']) > 100 ? '' : 'display: none'?>" href="/pdf.php?doc=<?=$vanzare['idv']?>&oferta"><i class="circular purple file pdf outline icon"></i></a>
			<a title="Editeaza" class="edit_btn" onmousedown="edit_oferta(<?=$vanzare['idv']?>);"><i class="circular purple edit outline icon"></i></a>
			<a title="Salveaza" class="save_btn" style="display: none;" onmousedown="save_oferta(<?=$vanzare['idv']?>);"><i class="circular purple save outline icon"></i></a>
			<!--<a href=""><i class="circular purple download outline icon"></i></a>-->

		</div>
	</div>
    <div class="row">
        <div class="col-xs-12" id="forma_oferta">


	<?php

    if(strlen($vanzare['oferta']) > 100) {
           echo  $vanzare['oferta'];
    } else {
    	 echo contract_template($vanzare['idv'],7);
       

    }

    ?>
        </div>
    </div>
    <div id="forma_oferta_val" style="display: none;">
    <textarea class="tinymce" rows="30" id="oferta_val"></textarea>
    </div>
</div>
<script>
	$('#pint_save').mousedown(function(){
		save_oferta(<?=$vanzare['idv']?>);
	});
	
	
    function save_oferta(idv) {
       var new_val = tinymce.get('oferta_val').getContent();
       $.post("",{"idv":idv,"new_text_oferta":new_val},function (r) {
           ThfAjax(r);
            $('.print_btn').show();
            $('.edit_btn').show();
            $('.save_btn').hide();
            $('#forma_oferta_val').hide();
            $('#forma_oferta').html(new_val).show();
            $('[step=oferta]').addClass('completed');
       });
    }
    function edit_oferta(idv) {
        val = $('#forma_oferta').html();
        $('.edit_btn').hide();
        $('.save_btn').show();
        $('#forma_oferta').hide();
        $('#forma_oferta_val').show();

        tinymce.get('oferta_val').setContent(val);



    }
</script>