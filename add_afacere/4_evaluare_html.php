<?php
$evaluare=many_query("SELECT * FROM `evaluare` WHERE `idv` = '".q($_GET['edit'])."' LIMIT 1");
?>
<div id="evaluare_tab" class="div_step hide">
    <?php
    if(!has_right($_GET['edit'],'vanzare') and $access_level_login < 9) {

        $rezultat = evaluare_html_tab_vanzare($_GET['edit'], 'en'); ?>
    <div clas='row'>
        <div class="col-xs-11"></div>
        <div class="col-xs-1">
        <a target="_blank" class="print_btn" style="" href="/pdf.php?doc=<?=$_GET['edit']?>&evaluare_companie_vanzare"><i class="circular purple file pdf outline icon"></i></a>
            </div>
        <?php
        echo($rezultat[0]);
    } else {    ?>
    <div>
	<style>#evaluare_tab .table td{vertical-align:middle;}</style>
	<div clas='row'>
		<div class="col-xs-11"></div>
		<div class="col-xs-1">
                    <a target="_blank" class="print_btn" style="" href="/pdf.php?doc=<?=$_GET['edit']?>&evaluare_companie_vanzare"><i class="circular purple file pdf outline icon"></i></a>
                </div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="main ui intro container">

				<h2 class="ui dividing header">
                        Evaluare <a class="anchor" id="preface"></a></h2>
			
				<p>
					TradeX aplică un multiplu de EBITDA pentru a determina valoarea afacerea dvs. În general, Afacerile mici si mijloci se tranzacționează între 3x și 5x EBITDA. Diferența dintre multiple este rezultatul unei varietăți de caracteristici specifice afacerii dvs.
					
				</p>
			</div>
		</div>
		<div class="col-xs-12">

		<form method="post" enctype="application/x-www-form-urlencoded" id="evaluare_tab_form" class="ui form vanzare_edit_insert" role="form" bootstraptoggle="true">
			<input type="hidden" name="evaluare_tab_form" value="<?=$vanzare['idv'];?>" >
			<table class="table table-hover table-responsive table-striped">
				<tbody>
					<tr>
						<td width="80%">
							<h4>Care este EBITDA anual al Afacerii?</h4>
							<p>Introduceți o valoare de la 0 până la 5 milioane Euro (sub 1 milion: 0,XX - Exemplu 0,20 pt 200.000)</p>
						</td>
						<td><input class="form-control" type="number" value="<?=h($evaluare['ebid_anual']?round($evaluare['ebid_anual'],4):'');?>" name="ebid_anual" min="0.0001" step="0.0001"></td>
					</tr>
					<tr>
						<td>
							<h4>Care este rata de creștere anuala a veniturilor Afacerii?</h4>
							<p>Introduceți o valoare cuprinsă între 0% și 50%</p>
						</td>
						<td>
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" required="" type="number" step="1" min="0" max="50" name="rata_crestere_ebid" value="<?=h($evaluare['rata_crestere_ebid']);?>">
									<span class="input-group-addon" style="font-weight:bolder;">%</span> 
								</div>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Care este marja EBITDA (ca procent din venituri)?</h4>
							<p>Introduceți o valoare cuprinsă între 0% și 50%</p>
						</td>
						<td>
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" value="<?=h($evaluare['marja_ebid']);?>" required="" type="number" step="1" min="0" max="50" name="marja_ebid">
									<span class="input-group-addon" style="font-weight:bolder;">%</span> 
								</div>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Cheltuielile de capital - fonduri utilizate pentru achiziționarea, modernizarea și menținerea activelor fizice (ca procent din EBITDA)?</h4>
							<p>Introduceți o valoare între 0% și 30%</p>
						</td>
						<td>
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" value="<?=h($evaluare['cheltuieli_ebid']);?>" required="" type="number" step="1" min="0" max="30" name="cheltuieli_ebid">
									<span class="input-group-addon" style="font-weight:bolder;" >%</span> 
								</div>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Procentajul veniturilor reprezentate de clientul de top?</h4>
							<p>Introduceți o valoare cuprinsă între 0% și 50%</p>
						</td>
						<td>
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" value="<?=h($evaluare['venituri_cl_ebid']);?>"  name="venituri_cl_ebid" required="" type="number" step="1" min="0" max="50" >
									<span class="input-group-addon" style="font-weight:bolder;" >%</span> 
								</div>
							</div>							
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Procentajul veniturilor reprezentate de cei 5 clienți de top împreună?</h4>
							<p>Introduceți o valoare cuprinsă între 0% și 75%</p>
						</td>
						<td>
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" value="<?=h($evaluare['venituri_top_ebid']);?>"  required="" type="number" step="1" min="0" max="75" name="venituri_top_ebid">
									<span class="input-group-addon" style="font-weight:bolder;">%</span> 
								</div>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Aceasta Afacerea practica prețuri/tarife premium față de concurenții?</h4>
						</td>
						<td class="bstrc" style="font-size: 1.2em; text-align: center;">
							<div class="form-check">
								<label class="togglex">
									<input name="practica_preturi_ebitd" type="radio" value="1" <?=($evaluare['practica_preturi_ebitd']==='1'?'checked':'')?>>
									<span class="label-text">Da</span>
								</label>
								&nbsp; &nbsp; 
								<label class="togglex">
									<input name="practica_preturi_ebitd" type="radio" value="0" <?=($evaluare['practica_preturi_ebitd']==='0'?'checked':'')?>>
									<span class="label-text">Nu</span>
								</label>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Este Afacerea o firmă de servicii profesionale?  (contabilitate, publicitate, etc.)</h4>
						</td>
						<td class="bstrc" style="font-size: 1.2em; text-align: center;">
							<div class="form-check">
								<label class="togglex">
									<input name="servicii_profesionale_editd" type="radio" value="1" <?=($evaluare['servicii_profesionale_editd']==='1'?'checked':'')?> >
									<span class="label-text">Da</span>
								</label>
								&nbsp; &nbsp; 
								<label class="togglex">
									<input name="servicii_profesionale_editd" type="radio" value="0" <?=($evaluare['servicii_profesionale_editd']==='0'?'checked':'')?>>
									<span class="label-text">Nu</span>
								</label>
							</div>
						</td>					</tr>
					
					<tr>
						<td>
							<h4>Este Vanzatorul și/sau partenerii de afacere critici pentru afacere?</h4>
						</td>
						<td class="bstrc" style="font-size: 1.2em; text-align: center;">
							<div class="form-check">
								<label class="togglex">
									<input name="critic_ebitd" type="radio" value="1"  <?=($evaluare['critic_ebitd']==='1'?'checked':'')?>>
									<span class="label-text">Da</span>
								</label>
								&nbsp; &nbsp; 
								<label class="togglex">
									<input name="critic_ebitd" type="radio" value="0"  <?=($evaluare['critic_ebitd']==='0'?'checked':'')?>>
									<span class="label-text">Nu</span>
								</label>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Multiplu aproximativ EBITDA =</h4>
						</td>
						<td>
						<span class="multiplu_aproximativ_ebitd">
							necalculat
						</span>
						<input type="hidden" name="multiplu_aproximativ_ebitd" class="multiplu_aproximativ_ebitd" value="0">
						</td>
					</tr>
					
					<tr>
						<td>
							<h4>Valoarea aproximativă a companiei (în milioane Euro) =</h4>
						</td>
						<td>
							<span class="val_aprox_companie">
								necalculats
							</span>
							<input type="hidden" name="val_aprox_companie" class="val_aprox_companie" value="0">
						</td>
					</tr>
					
				</tbody>
			</table>

		</form>
		</div>
	</div>
</div>

    <?php } ?>
</div>

<script>
function evaluare_companie(){
	var form=$('#evaluare_tab form'); //	console.log(form.serialize());

	var E7=parseFloat(form.find('[name=ebid_anual]').val());  //e7
	var E9=parseInt(form.find('[name=rata_crestere_ebid]').val())/100; //e9 
	var E11=parseInt(form.find('[name=marja_ebid]').val())/100;  //e11
	var E13=parseInt(form.find('[name=cheltuieli_ebid]').val())/100;  //e13
	var E15=parseInt(form.find('[name=venituri_cl_ebid]').val())/100;  //e15
	var E17=parseInt(form.find('[name=venituri_top_ebid]').val())/100;  //e17
	
	var E19=parseInt(form.find('[name=practica_preturi_ebitd]:checked').val());  //e19
	var E20=parseInt(form.find('[name=servicii_profesionale_editd]:checked').val()); //e20
	var E21=parseInt(form.find('[name=critic_ebitd]:checked').val());  //e21
	
	var E22=2.69+0.75*E7+2*E9; //=2.69+0.75*E7+2*E9
	var E23=(E11===0?E22-0.3:E22-0.3+2*E11); //=IF(E11=0, E22-0.3, E22-0.3+2*E11)
	var E24=(E13===0?E23+0.3:E23+0.3-2*E13); //=IF(E13=0, E23+0.3, E23+0.3-2*E13)
	var E25=(E15===0?E24+0.4:E24+0.4-2*E15); //=IF(E15=0, E24+0.4, E24+0.4-2*E15)
	var E26=(E17===0?E25+0.35:E25+0.35-E17); //=IF(E17=0, E25+0.35, E25+0.35-E17)
	var E27=(E19===1?E26+0.2:E26-0.2); //=IF(E19="DA", E26+0.2, E26-0.2)
	var E28=(E20===1?E27-1:E27); //=IF(E20="DA", E27-1, E27)
	var E29=(E21===1?E28-0.5:E28); //=IF(E21="DA", E28-0.5, E28)
	if(0){
		console.log(E7);
		console.log(E9);
		console.log(E11);
		console.log(E13);
		console.log(E15);
		console.log(E17);
		console.log(E19);
		console.log(E20);
		console.log(E21);
		console.log(E22);
		console.log(E23);
		console.log(E24);
		console.log(E25);
		console.log(E26);
		console.log(E27);
		console.log(E28);
		console.log(E29);
	}
	
	var multiplu_aproximativ_ebitd= Math.round( E29*100)/100;
	var val_aprox_companie=Math.round(E7*E29*100)/100;
	form.find('span.multiplu_aproximativ_ebitd').html(multiplu_aproximativ_ebitd);
	form.find('input.multiplu_aproximativ_ebitd').val(multiplu_aproximativ_ebitd);
	form.find('span.val_aprox_companie').html(val_aprox_companie);
	form.find('input.val_aprox_companie').val(val_aprox_companie);	
}
$(function(){
	evaluare_companie();
	$('#evaluare_tab form').find('input,textarea,select').change(function(){
		evaluare_companie();
	});
});
</script>












