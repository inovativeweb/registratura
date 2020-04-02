<?php
require ('./controller.php');



$page_head['trail']='new_jobs';
index_head();
?>
<div class="container-fluidddd">
	<form action="" method="post" enctype="application/x-www-form-urlencoded" id="fillerForm">
		<div class="row">
			<div class="col-sm-2">&nbsp;<br>
				<a href="./edit.php" class="ui yellow basic button">Adauga Job</a>
			</div>
			
			<div class="col-sm-2">
				<div class="field "><label class="control-label">Judetul </label>
					<select name="judet" data-placeholder="" >
						<option value="" selected="selected">Selecteaza..</option>
						<?php foreach($select_list['judet'] as $str){ echo '<option value="'.h($str).'">'.h($str).'</option>'; } ?>
					</select>

				</div>
			</div>
			<div class="col-sm-2">
				<div class="field "><label class="control-label">Localitate </label>
					<select name="oras" data-placeholder="Alege..." >
						<option value="" selected="selected">Selecteaza..</option>
						<?php foreach($select_list['oras'] as $str){ echo '<option value="'.h($str).'">'.h($str).'</option>'; } ?>
					</select>

				</div>
			</div>
			<div class="col-sm-2">
				<div class="field "><label class="control-label" for="pag">Pagina</label>
					<select name="pag" data-placeholder="" >
						<?php for($i=1;$i<=$nb_pages;$i++){ echo '<option value="'.$i.'">Pag '.$i.' din '.$nb_pages.'</option>';} ?>
					</select>
				</div>
			</div>

			<div class="col-sm-3">
				<label for="searchPhrase">Cauta <i class="search icon"></i></label>
				<input class="cauta form-control" placeholder="Cauta" value="" type="text" name="searchPhrase">
			</div>
			<div class="col-sm-1">
				<label><br><a title="Resetare filtre" onClick="resetFilters();"><i class="retweet olive circular icon" aria-hidden="true" style="padding-left: .4em !important!"></i></a></label><br>
			</div>

		</div>
	</form>
</div>
<div id="results_container" style="margin-top: 1em;">
	<?php list_new_jobs($form_contact,$page_details); ?>
</div>


<script>
	var form_hash=$('#fillerForm').serialize();
	setInterval(function(){
		if(form_hash!=$('#fillerForm').serialize() && !$.active){
			form_hash=$('#fillerForm').serialize();
			$.post('',form_hash,function(r){
				if(typeof r.table !=='undefined'){
					$('#results_container').html(r.table);
					update_nr_pagini(r);
				}
				else{alert(r);}
			});
			
		}
	},500);
	$('#fillerForm').submit(function(e){
		e.preventDefault();
	});
	
	function resetFilters(){
		$('[name=searchPhrase]').val('');
		$('select[name=pag]').val(1);
		$('select[name=pag]').trigger("chosen:updated");
		$('select[name=oras]').val('');
		$('select[name=oras]').trigger("chosen:updated");
		$('select[name=judet]').val('');
		$('select[name=judet]').trigger("chosen:updated");
	}
	
	function rezerva(idf) {
		$.post("",{"rezerva":idf},function (r) {
			$('#raspuns_forma_contact_'+idf).html('Rezervata');
			ThfAjax(r);
		})
	}
	function update_nr_pagini(data_json ){
		var obj= $('select[name=pag]');
		var new_options='';
		for(i=1;i<=data_json.nb_pages;i++){
			new_options+='<option value="'+i+'">Pag '+i+' din '+data_json.nb_pages+'</option>';
		}
	  //  console.log(data_json);
	    obj.attr('title','Nr. Rezultate: '+data_json.total_results+'; Se afisaza '+data_json.results_per_page+' randuri pe pagina.');
		//$('[for=pag]').html(data_json.total_results+' rezultate <small>('+data_json.results_per_page+'/pag)</small>');
		
		obj.html(new_options); //.removeClass('chosenInitThf').next().remove();
		obj.val(data_json.curent_page);

		obj.trigger("chosen:updated");
		//jQuery('body').dropdownChosen();
	}
</script>


<?php
index_footer();
?>