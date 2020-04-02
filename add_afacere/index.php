<?php
require_once( '../config.php' );

$page_head[ 'title' ] = 'Adauga afacere';
$page_head[ 'trail' ] = 'afaceri_vanzare';
require_login();
require ('controller.php');



index_head();
?>
<style>
    .bstrc .togglex input[type="radio"]:checked + .label-text::before{ color: rgb(163, 51, 200); }

    <?php if(!has_right($_GET['edit'],'vanzare')){ ?>
    .percent { display: none !important;}
    <?php } ?>


/*.sortableObjDragger.logo_vanzare{border: thin solid blue;}*/
.sortableObjDragger.logo_vanzare:after{ content: ''; font-family: FontAwesome; color: yellow; width: 0; height: 0; position: absolute; right: 20px; top: 5px; z-index: 3; text-shadow:1px 1px 1px #888; }
	span.red{color:red;}
</style>
<script>
	setInterval(function(){
		$('.sortableObjDragger.logo_vanzare').removeClass('logo_vanzare');
		$($('.sortableObjDragger:visible')[0]).addClass('logo_vanzare');
	},500);	
</script>
   
   
<div class="container-fluid">
    <div class="row">


<?php if(1) { ?>
<div class="ui ordered steps" id="add_afac" style="width: 100%; height: 60px;">
	<a class="active completed step" step="date_afacere">
		<div class="content">
			<div class="title">Date afacere</div>
		</div>
	</a>
	<?php if(has_right($_GET['edit'],'vanzare')){  ?>
	<a class="step" step="oferta" valid="<?=strlen($vanzare['oferta']);?>">
		<div class="content">
			<div class="title">Oferta</div>
		</div>
	</a>
    <?php }  ?>
    <?php if(has_right($_GET['edit'],'vanzare')){  ?>
	<a class="step" step="contract" valid="<?=strlen($vanzare['contract']);?>">
		<div class="content">
			<div class="title">Contract</div>
		</div>
	</a>
	<a class="step" step="teaser">
        <div class="content" >
            <div class="title">Teaser</div>
        </div>
    </a>
    <a class="step" step="evaluare_tab">
		<div class="content" >
			<div class="title">Evaluare</div>
		</div>
	</a>
    <?php }  ?>
	<a class="step " step="editare_im">
		<div class="content">
			<div class="title"><?=has_right($_GET['edit'],'vanzare') ? 'Editeaza' : 'Vizualizeaza'?> IM</div>
		</div>
	</a>
	
    <?php if(has_right($_GET['edit'],'vanzare')){  ?>
	<a class="step" step="cumparatori_tab" >
		<div class="content">
			<div class="title">Cumparatori</div>
			
		</div>
	</a>

	<a class="step" step="nda_tab">
		<div class="content" >
			<div class="title">NDA</div>
		</div>
	</a>
    <a class="step" step="to_do_tab">
        <div class="content" >
            <div class="title">To do</div>
        </div>
    </a>
<?php
if (0)
{
?>
    <a class="step" step="checklist">
        <div class="content" >
            <div class="title">Checklist</div>
        </div>
    </a>
<?php
}
?>    
    <?php } ?>
</div>
        <?php } ?>
        </div>
    </div>



<div class="col-sm-9 col-md-9" id="ui_tabs_afacere">        <br><br><?php

	include('1_date_afacere_html.php');
	include('2_contract_html.php');
	include('3_editare_im_html.php');
	include('4_evaluare_html.php');
	include('5_cumparatori.php');
	include('6_nda.php');
	include('7_to_do.php');
	include('8_checklist.php');
	include('9_oferta_html.php');
	include('10_teaser.php');
?></div>

<?php   if(has_right($_GET['edit'],'vanzare')){   ?>

<div class="col-sm-3 col-md-3">

<br><br>
	<div class="ui card grid">
		<div class="column">
            <h2 style="color: #a333c8"><?=$afaceri_select[$_GET['edit']];?></h2>
            <br>
            <?php
            select_rolem( 'selecteaza_compania', 'Schimba afacerea ', $afaceri_select, $_GET['edit'],'' );

			$statusuri_f=$statusuri;
            if(has_right($_GET['edit'],'vanzare') and $access_level_login == 1){
/*
    [0] => Draft
    [1] => Asteapta Aprobare
    [3] => Publicat
    [5] => In Escrow
    [7] => Arhivat
*/	
                $statusuri_f=array(
                    0=>'Draft',
                    1=>'Asteapta Aprobare'
                );
				$statusuri_f[$vanzare['status']]=$statusuri[$vanzare['status']];
				// prea($statusuri_f);
            }
											 
            select_rolem('status','Status',$statusuri_f,$vanzare['status'],''); ?>

                <br>

            <?php $is_admin ?  select_rolem( 'business_broker', 'Broker ', $users_list, $vanzare['uid'], 'Alege...', false, array() ) : '';?>
            <br>
            <?php if(0){?>
            <form action="" method="post" enctype="multipart/form-data" id="promoveaza_form">
                <div class="ui left floated compact segment raspuns_actiune_promovare">
                    <?php
                    if($vanzare['promovat_until'] == 0 and $vanzare['promovare_aprobata'] == 0) { ?>
                        <div class="ui fitted slider checkbox ">
                            <input type="hidden" value="<?=$_GET['edit']?>" name="idv">
                            <input type="hidden"  name="promoveaza">
                            <input id="promoveaza" name="promovat_until" type="checkbox" <?=$vanzare['promovat_until'] > 0 ? 'checked' : ''?>>

                        </div>  <label>Promoveaza</label>
                    <?php }
                    if($vanzare['promovat_until'] > 0 and $vanzare['promovare_aprobata'] > 0 ) {?>
                        <label style="color: <?=$vanzare['promovat_until'] > 0 ? 'green' : 'gray'?>" id="promovat_nume"><?=$vanzare['promovat_until'] > 0 ? 'Promovat':'Nepromovat'?></label>
                        <p id="data_promovat" style="color:gray"><?=$vanzare['promovat_until'] > 0 ? 'pana in data de ' . ro_date($vanzare['promovat_until']) : '' ?></p>
                    <?php }
                    if($vanzare['promovat_until'] > 0 and $vanzare['promovare_aprobata'] == 0) { ?>
                        <label style="color: orange" id="">Promovarea va fi aprobata dupa confirmarea platii</label>
                    <?php   }?>
                </div>
            </form>
            <hr>
            <?php } ?>
            <h2>Atasamente media afacere</h2>
			<form action="" method="post" enctype="multipart/form-data" class="ThfGalleryEditorForm">
                <input type="hidden" name="atasamente_media" />
				<!-- 2-->
				<?php  //prea($vanzare);
                $poze=ThfGalleryEditor::get_poze_produs($vanzare['atasamente']);
                ThfGalleryEditor::pics_layout_frontend($poze);
                ?>
			</form>


		</div>
	</div>

    <?php if(1 || $login_user == 2) {
        $promovare_data = many_query("SELECT * FROM `thf_facturi` WHERE idvf = '".floor($_GET['edit'])."' order by idf DESC");
        $total = 0;
        $promovare_activa = get_promovare_activa(floor($_GET['edit']));
        $repere = json_decode($promovare_data['repere'],true); ?>
        <br><br>
        <div class="ui card grid raised">
            <div class="column">
                <h2 style="color: #a333c8">Promovare Vanzare Afacere</h2>
                <form id="form_promovare">
                    <input type="hidden" name="auto_save_promovare">
                    <input type="hidden" name="idvf" value="<?=$_GET['edit']?>">
                    <input type="hidden" name="uid" value="<?=$login_user?>">
                    <input type="hidden" name="idf" value="<?=$promovare_data['idf']?>">
                    <ul class="list-group">
                        <?php
                        foreach ($promovari_db as $idp=>$promo){
                            $is_active_promo_copii = 0;
                            $data_valabilitate = '';
                            $copii = multiple_query("SELECT * FROM `promovari` WHERE parinte = $idp ",'idp');

                            $total +=  isset($repere[$idp]['cantitatea']) ? $repere[$idp]['cantitatea']*$repere[$idp]['pret_unitar'] : 0;
                            $variante = array();
                                    if($promo['parinte'] > -1) { continue; }
                            if(!count($copii)) {
                                    $is_active_promo = (isset($promovare_activa[$idp])) ? true : false;
                                    $varianteX = explode(',', $promo['variante']);
                                    $data_valabilitate = $promovare_activa[$idp]['valabilitate'];
                                    foreach ($varianteX as $k) {
                                        $variante[$k] = $unitati_masura_promovari[$k];
                                    }   $selected = $repere[$idp]['cantitatea'];
                            }
                            else {
                                $variante = array('0'=>' Alege');

                                foreach ($copii as $id_copil=>$copil) {
                                    $limita = '';

                                    if(isset($promovare_activa[$id_copil])) {
                                        $is_active_promo_copii++;
                                        $data_valabilitate = $promovare_activa[$id_copil]['valabilitate'];
                                    }
                                    if(isset($repere[$id_copil])){ $selected =  $repere[$id_copil]['idp']; }
                                    if(limita_promovari($id_copil) != '-1' and limita_promovari($id_copil) < 1){ continue;}
                                    if($is_admin){
                                        $limita =  limita_promovari($id_copil) . ' disp';
                                    } else {
                                        $limita = '';
                                    }
                                    $variante[$id_copil] = $copil['nume_promovare'] .' - '. $unitati_masura_promovari[$copil['variante']] . ' (' . $copil['pret_promovare'].'lei/luna ) ' . $limita;
                                    //prea($is_active_promo_copii);   prea($copil);   prea($idp);

                                }
                                // prea($repere); prea($selected); prea($variante[$id_copil]);

                            }

                            $is_active_promo = $is_active_promo_copii > 0 ? true : $is_active_promo;
                            $color_select = $is_active_promo ? 'green' : 'black';
                            ?>
                            <li class="list-group-item">
                                <strong style="color: <?=$promo['deleted'] < 1 ? $color_select : 'grey'?>"><?=$promo['nume_promovare']?></strong>
                                <br><i style="color:grey"><?=$is_active_promo ? '<i class="ui icon green circle check"></i>Activa pana in data de: '.date("d/m/Y",strtotime($data_valabilitate)) : ($promo['deleted'] < 1 ?
                                        '' : ' in curand')?></i>
                                <?php

                        //$promo['pret_promovare'] . ' lei'
                                select_rolem( 'select_'.$idp, '', $variante,$selected,'','',$promo['deleted'] < 1 ? '':array('attr'=> array('disabled'=>'disabled')) );
                                // prea($promo);?>
                            </li>
                        <?php } ?>
                        <li class="list-group-item">
                            <?php   select_rolem( 'id_asociatie', 'Servici suportate de ', array('0'=>'Business Broker', $asoc_id_login=>'Agentie'),$promovare_data['id_asociatie'],'' );?>
                        </li>
                        <li class="list-group-item"><p id="total_costuri_promovare" style="font-size: 1.4em; color: <?=$total>0 ? 'green' : 'black'?>"><?=' Total de plata: '.$total.' Lei'?></p></li>
                        <?php
                       // prea($promovare_data);
                        if(is_numeric($promovare_data['idf']) and $promovare_data['status'] > 0){?>
                            <li class="list-group-item li_pdf">
                                <a target="_blank" href="<?=ROOT?>facturi/print_out.php?idf=<?=$promovare_data['idf']?>"><i class="circular red file pdf outline icon"></i> Descarca proforma</a>
                            </li>
                        <?php }
                        if(strlen($promovare_data['link_factura'])){
                        ?>
                        <li class="list-group-item">
                            <a target="_blank" href="<?=$promovare_data['link_factura']?>"><i class="circular green file pdf outline icon"></i> Descarca Factura fiscala</a>
                        </li>
                        <?php } ?>
                        <li class="list-group-item">
                            <a onclick="comanda_promovare('1')" class="ui purple button <?=$promovare_data['status'] == 0 && $total>0 ? '' : 'hide'?>" id="promovare_buy">Comanda</a>
                            <a onclick="comanda_promovare('0')" class="ui red button <?=$promovare_data['status'] > 0 ? '' : 'hide'?>" id="anuleaza_promovare">Anuleaza</a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    <?php } ?>
</div>



<div style="position:fixed; bottom:5px; right:5px; padding: 3px; z-index:1000;" class="ui violet message">
	<span style="color: purple; font-size: 0.9em" id="date_companie_h3"></span>
	<input type="button" class="ui green button" id="save_all_button" onmousedown="save_all_forms_vanzare();" value="Salveaza"/>
	<a href="<?=ROOT.'afaceri/'?>"><i id="loading_save" class="spinner loading icon hide"></i><input type="button" class="ui teal button" id="go_to_documente"  value="Inchide"/></a>
</div>



<?php } else {  ?>
    <script>
        $(function () {
           $('.ascuns').css("display","none");
             $('#div_acte_adaugare').css("display","none");
            $('input, textarea').prop('disabled', true).prop('readonly', true);
            $('select, .chosenInitThf').prop('disabled', true).trigger("chosen:updated");
            
        });
    </script>
    <?php } ?>
<script>
	<!-- 1 -->
	<?php ThfGalleryEditor::javascript_settings(); ?>
</script>
<script>
    $(function () {
        $('#form_promovare').find('select').change(function () {
            calcul_promovari();
        });
       <?php
       if (isset($_GET['tab']) && $_GET['tab']=='cumparatori')
       	{
       		?>
			$("a[step='cumparatori_tab']").click();
			<?php
		}
       ?> 
        
    });

    function comanda_promovare(new_status) {
        calcul_promovari();
        $.post("/post.php",{"comanda_promovare":"","idvf":"<?=$_GET['edit']?>","status":new_status},function (r) {
            if(new_status == '1') {
                $('#anuleaza_promovare').removeClass('hide');
                $('#promovare_buy').addClass('hide');
                location.reload();
                //$('#total_costuri_promovare').append(' Serviciile au fost comandate! Vei primi pe email proforma');
            }
            if(new_status == '0') { // anuleaza
                $('.li_pdf').addClass('hide');
                $('#anuleaza_promovare').addClass('hide');
                $('#promovare_buy').removeClass('hide');
            }
        });

    }
    function calcul_promovari() {
        var form = $('#form_promovare').serialize();
        $.post("/post.php",form,function (r) {
            $('#total_costuri_promovare').html(' Total de plata: ' + r + ' Lei');
            if(r > 0){
                $('#total_costuri_promovare').css('color','green');
                $('#promovare_buy').removeClass('hide');
            } else {
                $('#total_costuri_promovare').css('color','black');
                $('#promovare_buy').addClass('hide');
            }
        })
    }
    
    function reload_cumparatori()
    {
    	window.location.href='/add_afacere/?edit='+<?=$_GET['edit']?>+"&tab=cumparatori";
    	
	}
    function save_all_forms_vanzare() {
    	
    id_afacere=<?=$_GET['edit']?>;	
    if (id_afacere>0)
    	{
			if(validate_fields())
			    {
			   	
			   		$('#loading_save').removeClass('hide');
			        save_form('#forma_adauga_vanzare');
			        save_form('#forma_checklist');
			        save_form('#forma_reprezentant_vanzare');
			        save_form('#forma_cumparator');
			        save_form('#forma_editare_im');
			        save_form('#evaluare_tab_form');
			        save_form('#country_form');
			        save_form('.percent_step');
			        save_vanzare();		
				}
		}
	else
		{
			 $.post("/afaceri/index.php", {"add_afacere": "","id_forma":0,"idc":0}, function (data) {
        //	window.location.href = "/add_afacere/?edit=" + data;
       
   				     $('#loading_save').removeClass('hide');
			        save_form('#forma_adauga_vanzare',data);
			        save_form('#forma_checklist',data);
			        save_form('#forma_reprezentant_vanzare',data);
			        save_form('#forma_cumparator',data);
			        save_form('#forma_editare_im',data);
			        save_form('#evaluare_tab_form',data);
			        save_form('#country_form',data);
				 	save_form('.percent_step',data);
			        save_vanzare(data);
  		  });
		}	
    	
    
    

    }
    function save_vanzare(idv_new=0) {
        tinyMCE.triggerSave();
        var param = $('#forma_vanzare').serialize();
        if($('[name=descriere_publica_en]').length){
            param = param + '&descriere_publica_en=' +encodeURIComponent($('[name=descriere_publica_en]').val()) +'&descriere_ascunsa='+encodeURIComponent($('[name=descriere_ascunsa]').val());
        }
        if($('[name=descriere_publica]').length){
            param = param + '&descriere_publica=' +encodeURIComponent($('[name=descriere_publica]').val()) +'&descriere_ascunsa='+encodeURIComponent($('[name=descriere_ascunsa]').val());
        }
		param=param+"&idv_new="+idv_new;
        $.post("",(param),function (r) {
            $('#loading_save').addClass('hide');
            console.log(r);
            ThfAjax(r);
        });
    }
    function save_form(type,idv_new=0) {
        $('#save_companie_btn').css('color','yellow');
        $.post("",$(type).serialize()+"&idv_new="+idv_new,function (r) {
            $('#save_companie_btn').css('color','white');
          //  ThfAjax(r);
        });
    }
	function change_desc(lg)
	{
			var old_link =  'preview.php?edit=<?=$_GET['edit']?>&date_companie_vanzare';
			var selected_lang = $('#lang:checked').val();
                  $('a.preview_btn').attr('href',old_link + '&lang='+selected_lang);

          	if (lg=='ro')
          	{
				$('#descriere_publica_ro').css("display","block");
				$('#descriere_publica_en').css("display","none");
				$('#div_denumire_afacere_ro').css("display","block");
				$('#div_denumire_afacere_en').css("display","none");
				$('#div_motiv_vanzare_en').css("display","none");
				$('#div_motiv_vanzare_ro').css("display","block");
				$('#div_suport_en').css("display","none");
				$('#div_suport_ro').css("display","block");
				$('#div_alt_text_en').css("display","none");
				$('#div_alt_text_ro').css("display","block");
				$('#div_focus_keyword_en').css("display","none");
				$('#div_focus_keyword_ro').css("display","block");
				$('#div_meta_description_en').css("display","none");
				$('#div_meta_description_ro').css("display","block");
			}
			else
			{
				$('#descriere_publica_ro').css("display","none");
				$('#descriere_publica_en').css("display","block");
				$('#div_denumire_afacere_ro').css("display","none");
				$('#div_denumire_afacere_en').css("display","block");
				$('#div_motiv_vanzare_en').css("display","block");
				$('#div_motiv_vanzare_ro').css("display","none");
				$('#div_suport_en').css("display","block");
				$('#div_suport_ro').css("display","none");
				$('#div_alt_text_en').css("display","block");
				$('#div_alt_text_ro').css("display","none");
				$('#div_focus_keyword_en').css("display","block");
				$('#div_focus_keyword_ro').css("display","none");
				$('#div_meta_description_en').css("display","block");
				$('#div_meta_description_ro').css("display","none");
			}
    };
	
    $( function () {
        setTimeout(function () {
            var alerta_marime='';
            $('.ThfGalleryEditor img[href]').each(function(i,o){
                if(i == 0){ $(this).closest('.col-xs-6').removeClass('col-xs-6').addClass('col-xs-12'); }

                var href=$(this).attr('href');
                var newing=$('<img src="'+href+'" />').get(0);
                var width=newing.naturalWidth;
                var height=newing.naturalHeight;
                var old_title = $(this).attr('title');
                $(this).attr('title',old_title + ' '+width + 'X'+height + 'px');
                if(width<400 || height<300){
                  $(this).parent().parent().parent().prepend('<p class="poza_mica" style="z-index: 1200; color:red; position:absolute">Imagine prea mica</p>');
                    if(alerta_marime.length<1){
                        alerta_marime+='Lista poze cu dimensiuni mici: ';
                    }
                    alerta_marime+= '"'+$(this).attr('title')+'"; ';
                }
            });

            if(alerta_marime.length>2){
            //	alerta_marime='<div class="col-xs-12"><span class="red">'+alerta_marime+'</span></div>';
            //	$('.ThfGalleryEditor').append(alerta_marime);
            }

        },1500);
        $('#promoveaza').change(function () {
            msg_bst_thf_loading();
            if($('#promoveaza').is(':checked')){
                    if(!confirm('Doresti sa promovezi aceasta afacere? vei primi pe email informatiile despre plata')){

                        msg_bst_thf_loading_remove();
                        return 0; }
                        else {
                        $.post("", $('#promoveaza_form').serialize(), function (r) {
                            ThfAjax(r);
                            $('#promovat_nume').text('Promovat').css('color', 'green');
                        });
                    }
                    } else {
                $.post("", $('#promoveaza_form').serialize(), function (r) {
                    ThfAjax(r);
                    $('#promovat_nume').text('Nepromovat').css('color', 'gray');
                });
                    $('#data_promovat').text('');
                }
                $('.raspuns_actiune_promovare').html('  <label style="color: orange" id="">Promovarea va fi aprobata dupa confirmarea platii</label>');
            msg_bst_thf_loading_remove();
        });


        $('#business_broker').change(function () {
            $.post("",{"business_broker" : $(this).val(),"idv" : <?=$_GET['edit']?>},function (r) {

                ThfAjax(r);
            });
        });




        $('.publica_imobiliare_btn').click(function () {
            var link = '<?=ROOT?>imobiliare.ro/?publica&company=<?=$_GET['edit']?>';
            var msg = '';
            $('label').css('color', 'black');
            msg += check_input_mandatory_integer('#suprafataconstruita');
            msg += check_input_mandatory_integer('#nrincaperi');
            msg += check_input_mandatory_integer('#anconstructie');
            msg += check_input_mandatory_integer('#suprafatautila');
            msg += check_input_mandatory_integer('#nrnivele');
            msg += check_input_mandatory('#tipimobil');
            msg += check_input_mandatory('#stadiuconstructie');
            msg += check_input_mandatory('#structurarezistenta');

            if(msg.length) {
                alert(msg + ' sunt obligatorii inaintea publicarii!');
                return 0;
            } else {
                window.location.href = link;
            }
    });
function check_input_mandatory_integer(selector) {
            if ($(selector).val() ==  0) {
                    var label = $(selector).prev('label').text();
                    $(selector).prev('label').css('color', 'red');
                    return label + ',';
                } else {
                    return '';
                }
        }

function check_input_mandatory(selector) {
    if(selector == '#inventar_inclus_in_pret'){
        if($('#inventariu_aprox').val().length < 1){
            return 'Inventar inclus in Pret';
        } else {
            return '';
        }
    } else {
        if ($(selector).val().length < 1 || $(selector).val() == '') {
            var label = $(selector).prev('label').text();
            $(selector).prev('label').css('color', 'red');
            return label + ',';
        } else {
            return '';
        }
    }
}

        $('[name=promovat_imobiliare]').change(function () {
            if($(this).prop('checked')){
                $('.imobiliare_zone').removeClass('hide');
            } else {
                $('.imobiliare_zone').addClass('hide');
            }
        });
        $('#status').change(function () {

           var msg = '';
            tinyMCE.triggerSave();
            if($(this).val() > 0) {
                $('label').css('color', 'black');
                msg += check_input_mandatory('#profit_anual');
                msg += check_input_mandatory('#cifra_afaceri');
                msg += check_input_mandatory('#data_stabilire');
                msg += check_input_mandatory('#pret_vanzare');
                msg += check_input_mandatory('#inventar_inclus_in_pret');
                msg += check_input_mandatory('#motiv_vanzare');
                msg += check_input_mandatory('#suport');
                msg += check_input_mandatory('#nr_angajati');
                msg += check_input_mandatory('#consultanta');
                msg += check_input_mandatory('#comision');
                msg += check_input_mandatory('#exclusivitate');
                msg += check_input_mandatory('#la_site');
                msg += check_input_mandatory('#denumire');
                msg += check_input_mandatory('#adresa');
                msg += check_input_mandatory('#denumire');
                msg += check_input_mandatory('#alt_text');
                msg += check_input_mandatory('#focus_keyword');
                msg += check_input_mandatory('#meta_description');
                msg += check_input_mandatory('#forma_adauga_vanzare [judet_id]');
                msg += check_input_mandatory('#forma_adauga_vanzare [localitate_id]');
                msg += check_input_mandatory('#forma_adauga_vanzare #reg_com');
                msg += check_input_mandatory('#forma_adauga_vanzare #cont_iban');
                msg += check_input_mandatory('#forma_adauga_vanzare #banca');
                msg += check_input_mandatory('#forma_reprezentant_vanzare #denumire');
                msg += check_input_mandatory('#forma_reprezentant_vanzare #tel');
                msg += check_input_mandatory('#forma_reprezentant_vanzare #email');
            }
            
            var words = $('#descriere_publica').val().split(' ');
            var words_at = $('#alt_text').val().split(' ');
           
            var words_fk = $('#focus_keyword').val().split(' ');
            var words_md = $('#meta_description').val().split(' ');
            
            if(words.length < 120 && $('#status').val() > 0) {
                alert("Descrierea publica trebuie sa aiba minim 120 de cuvinte!");
                $('#status').val(0);    $('#status').trigger("chosen:updated");
                return 0;
            } else if(words_at.length < 2 && $('#status').val() > 0) {
                alert("Alt text poza trebuie sa aiba minim 2 cuvinte!");
                $('#status').val(0);    $('#status').trigger("chosen:updated");
                return 0;
            } else if(words_fk.length < 2 && $('#status').val() > 0) {
                alert("Focus keyword trebuie sa aiba minim 2 cuvinte!");
                $('#status').val(0);    $('#status').trigger("chosen:updated");
                return 0;
            } else if(words_md.length < 2 && $('#status').val() > 0) {
                alert("Meta description trebuie sa aiba minim 2 cuvinte!");
                $('#status').val(0);    $('#status').trigger("chosen:updated");
                return 0;
            } else if($('#status').val() > 0 && ($('.poza_mica').length > 0 || $('.imgCoverContainer').find('img').length < 7)){
                alert("Inainte de publicare afacerea trebuie sa aiba minim 7 poze cu o rezolutie de minim 400x300 pixeli!");
                $('#status').val(0);    $('#status').trigger("chosen:updated");
                return 0;
            }
            else if($('#status').val() > 0 && msg.length){
                alert(msg + ' sunt obligatorii inaintea publicarii!');
                $('#status').val(0);    $('#status').trigger("chosen:updated");
                return 0;
            }


            else {
                $.post("", {"change_status": $(this).val(), "idv": <?=$_GET['edit']?>}, function (r) {

                    ThfAjax(r);
                });
            }
        });


        $('#selecteaza_compania').change(function () {
            window.location = "/add_afacere/?edit="+$(this).val();
        });
		if(window.location.hash.length>1){
			$('[step='+window.location.hash.substr(1)+']').trigger('click');
			console.log($('[step='+window.location.hash.substr(1)+']'));
		}
		else{
			$( '[step=afaceri_vanzare]' ).addClass( 'active' );
		}
		
		
	} );
</script>
<br>
<?php index_footer();?>