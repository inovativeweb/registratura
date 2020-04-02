<div id="contract" class="div_step hide">
	<div class="row">
		<div class="col-xs-10">
			<div class="main ui intro container">

				<h2 class="ui dividing header">
                        Contract <a class="anchor" id="preface"></a></h2>
			
				<br><br>
			</div>
		</div>

		<div class="col-xs-2">
			<a class="print_btn" id="pint_save" target="_blank" style="<?=strlen($vanzare['contract']) > 100 ? '' : 'display: none'?>" href="/pdf.php?doc=<?=$vanzare['idv']?>&contract"><i class="circular purple file pdf outline icon"></i></a>
			<a title="Editeaza" class="edit_btn" onmousedown="edit_contract(<?=$vanzare['idv']?>);"><i class="circular purple edit outline icon"></i></a>
			<a title="Salveaza" class="save_btn" style="display: none;" onmousedown="save_contract(<?=$vanzare['idv']?>);"><i class="circular purple save outline icon"></i></a>
			<!--<a href=""><i class="circular purple download outline icon"></i></a>-->

		</div>
	</div>
    <div class="row">
        <div class="col-xs-12" id="forma_contract">


	<?php

    if(strlen($vanzare['contract']) > 100) {
           echo  $vanzare['contract'];
    } else {
        if($vanzare['exclusivitate']=='nu' && $vanzare['consultanta'] > 0){
            echo contract_template($vanzare['idv'],1);
        }
        if($vanzare['exclusivitate']=='da' && $vanzare['consultanta'] > 0){
            echo contract_template($vanzare['idv'],2);
        }
        if($vanzare['exclusivitate']=='nu' && $vanzare['consultanta'] == 0){
            echo contract_template($vanzare['idv'],3);
        }
        if($vanzare['exclusivitate']=='da' && $vanzare['consultanta'] == 0){
            echo contract_template($vanzare['idv'],4);
        }


    }

    ?>
        </div>
    </div>
    <div id="forma_contract_val" style="display: none;">
    <textarea class="tinymce" rows="30" id="contract_val"></textarea>
    </div>
</div>
<script>
	$('#pint_save').mousedown(function(){
		save_contract(<?=$vanzare['idv']?>);
	});
	
	
    function save_contract(idv) {
       var new_val = tinymce.get('contract_val').getContent();
       $.post("",{"idv":idv,"new_text_contract":new_val},function (r) {
           ThfAjax(r);
            $('.print_btn').show();
            $('.edit_btn').show();
            $('.save_btn').hide();
            $('#forma_contract_val').hide();
            $('#forma_contract').html(new_val).show();
            $('[step=contract]').addClass('completed');
       });
    }
    function edit_contract(idv) {
        val = $('#forma_contract').html();
        $('.edit_btn').hide();
        $('.save_btn').show();
        $('#forma_contract').hide();
        $('#forma_contract_val').show();

        tinymce.get('contract_val').setContent(val);



    }
</script>