<?php

//require ('../imobiliare.ro/controller.php');

//add
$nomenclatorX = file_get_contents(THF_PATH . 'imobiliare.ro/nomenclator.txt');
$nomenclator = explode(PHP_EOL,$nomenclatorX);


foreach ($nomenclator as $k=>$field){
    if(!strlen($field) || substr_count($field,'--')){continue ;}
  //   prea($field);
    $tmp = explode('|',$field);
   
    if($tmp[1] == 'localitati' || $tmp[1] == 'zone'){
    	
        $data[$tmp[0]][$tmp[1]][$tmp[3]]['denumire'] = $tmp[4];
        $data[$tmp[0]][$tmp[1]][$tmp[3]]['id'] = $tmp[3];
        $data[$tmp[0]][$tmp[1]][$tmp[3]]['parinte'] = $tmp[2];
    } else {
        $data[$tmp[0]][$tmp[1]][$tmp[2]]['denumire'] = $tmp[3];
        $data[$tmp[0]][$tmp[1]][$tmp[2]]['id'] = $tmp[2];
    }
}
$danu=array(''=>'Selecteaza','0'=>"Nu",'1'=>"Da");
ksort($danu);


foreach ($data['spatii'] as $tip=>$val)
{
	foreach ($val as $key=>$opt)
		{
			$valuesSp[$tip][$key]=$opt['denumire'];
		}
		
}


unset($valuesSp['altecaracteristici']['431']);
unset($valuesSp['altecaracteristici']['432']);
unset($valuesSp['altedetaliizona']['421']);
unset($valuesSp['dotari']['393']);
unset($valuesSp['finisaje']['366']);
unset($valuesSp['servicii']['415']);
unset($valuesSp['utilitati']['350']);



if(!isset($_GET['lang'])){$_GET['lang'] = 'ro';}

$default_txt = '&bull;	Introducere  
&bull;	Prezentarea generală a afacerii, inclusiv tipul de afacere, data fondări, istoric scurt, vânzări și câștiguri
&bull;	Zona geografică și locația afacerii (descriere fara amanunte!)
&bull;	Puncte tari, Poziția pe piață, Performanta financiara
&bull;	Conținutul vânzării (entitatea sau activele comerciale, valoarea activelor, valoarea inventarului, altele incluziuni sau excluderi)';
?>
<style>
    .header { color: purple !important; }
</style>
<div id="date_afacere" class="div_step">

    <?php
    if(!has_right($_GET['edit'],'vanzare') and $access_level_login < 9) { ?>
        <div class='row'>
            <div class="col-xs-11"></div>
            <div class="col-xs-1">
                <a target="_blank" class="print_btn" style="" href="/pdf.php?doc=<?=$_GET['edit']?>&date_companie_vanzare"><i class="circular purple file pdf outline icon"></i></a>
            </div>
        </div>
        <?php $rezultat = descriere_html_tab_vanzare($_GET['edit'], 'en');
	        echo($rezultat[0]);
    } else {    ?>
	<div class="ui">
        <form action="" method="get" enctype="application/x-www-form-urlencoded" id="country_form">
            <div class="row">
                <input type="hidden" name="edit" value="<?=$_GET['edit'];?>" />

                <div class="col-xs-1"><input type="radio" value="ro" checked onclick="change_desc('ro')" name="lang" id='lang'>&nbsp;<i class="ro flag"></i></div>
                <div class="col-xs-1"><input type="radio" value="en" onclick="change_desc('en')"  name="lang" id='lang'>&nbsp;<i class="gb uk flag"></i></div>
                <div class="col-xs-7"></div>
                <div class="col-xs-1" style="display: inline"><a title="Preview" colorboxIframe target="_blank" class="print_btn preview_btn"  style="" href="preview.php?edit=<?=$_GET['edit']?>&date_companie_vanzare"><i class="circular purple eye outline icon"></i></a></div>
              	<div class="col-xs-1" style="display: inline">
                    <a title="Print" target="_blank" class="print_btn" style="" href="/pdf.php?doc=<?=$_GET['edit']?>&date_companie_vanzare"><i class="circular purple file pdf outline icon"></i></a>
                </div>
            </div>
        </form>
		<br>


        <!-- FORMA VANZARE-->
        <form action="/post.php" method="post" enctype="application/x-www-form-urlencoded" id="forma_vanzare" class="ui form vanzare_edit_insert" role="form" bootstraptoggle="true">
            <input type="hidden" name="edit_vanzare" value="<?=$vanzare['idv']?>"/>

            <div id="div_denumire_afacere_ro" class=" field " denumire_afacere="">
                <label id="label_denumire_afacere" for="denumire_afacere">Denumire Afacere **&nbsp;<i class="ro flag"></i> </label>
                <input class="form-control" name="denumire_afacere" id="denumire_afacere" placeholder="(generala pt listare ascunsa, specific pt listare cu Brand)" value="<?=$vanzare['denumire_afacere']  ?>" type="text">
            </div>
            <div id="div_denumire_afacere_en" style='display:none' class=" field " denumire_afacere="">
                <label id="label_denumire_afacere" for="denumire_afacere">Denumire Afacere **&nbsp;<i class="gb uk flag"></i> </label>
                <input class="form-control" name="denumire_afacere_en" id="denumire_afacere_en" placeholder="(generala pt listare ascunsa, specific pt listare cu Brand)" value="<?=$vanzare['denumire_afacere_en']  ?>" type="text">
            </div>
            <div class="two fields">
                <?php
              //  select_rolem( 'imagine_afacere', 'Imagine afacere: Vânzătorul** ', array( "da" => "Da", "nu" => "Nu" ), $vanzare[ 'imagine_afacere' ], 'Alege...', false, array() );
              //  input_rolem( 'cand_se_face', 'Când se pot face?**', $vanzare[ 'cand_se_face' ], '', false );
                ?>
            </div>
            <div class="field">
                <label class="control-label">Domeniul de activitate **</label>
                <select name="domeniu_activitate[]" data-placeholder="Select..." multiple><?php
                    $tmpda=explode(',',$vanzare[ 'domeniu_activitate' ]);
                    foreach($domenii_afacere as $dai=>$da){
                        if(!$dai){continue;}
                        echo '<option value="'.$dai.'" '.(in_array($dai,$tmpda)?'selected':'').' >'.h($da).'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="ui form">

                <div class="field" id='descriere_publica_ro'>
                    <label>Descriere Publica **&nbsp;<i class="ro flag"></i></label>
                    <textarea class="tinymce" placeholder="" name="descriere_publica"><?=h($vanzare['descriere_publica']);?></textarea>
                </div>


                <div class="field" style='display:none' id='descriere_publica_en'>
                    <label>Publish Description **&nbsp;<i class="gb uk flag"></i></label>
                    <textarea class="tinymce" placeholder="" name="descriere_publica_en"><?=h($vanzare['descriere_publica_en']);  ?></textarea>
                </div>

                <div class="field ascuns">
                    <label>Descriere Ascunsa *</label>
                    <textarea  name="descriere_ascunsa"><?=h($vanzare['descriere_ascunsa'])?></textarea>
                </div>
            </div>
            <?php
            //prea($tmpda);

            //	select_rolem( 'domeniu_activitate', 'Domeniul de activitate **',$domenii_afacere, $vanzare[ 'domeniu_activitate' ], '' );
            ?>
            <div class="two fields">
                <?php
                input_rolem( 'cifra_afaceri', 'Cifra de Afaceri Anuala ** (in lei)	', $vanzare[ 'cifra_afaceri' ], '', false );
                input_rolem( 'profit_anual', 'Profitul Anual **   (in lei)', $vanzare[ 'profit_anual' ], '', false );
                ?>
            </div>
            <div class="two fields">
                <?php
                input_rolem( 'data_stabilire', 'Afacerea Stabilita in Data de **', $vanzare[ 'data_stabilire' ], '', false,array("attr"=>array("dateTimePicker"=>"")) );
                input_rolem( 'tip_finantare', 'Finanțarea Vânzătorului/Bănci **', $vanzare[ 'tip_finantare' ], '', false );
                ?>
            </div>
            <div class="two fields">
                <?php
                input_rolem( 'pret_vanzare', 'Preț de Vânzare ** (in EUR)', $vanzare[ 'pret_vanzare' ], '', false );
                input_rolem( 'patrimoniu_imobiliar', 'Patrimoniu Imobiliar ** (in EUR)', $vanzare[ 'patrimoniu_imobiliar' ], '', false );
                ?>
            </div>
            <div class="two fields">
                <?php
                input_rolem( 'fond_comercial', 'Fond comercial (Goodwill) **	(in EUR)', $vanzare[ 'fond_comercial' ], '', false );
                input_rolem( 'marca_comerciala', 'Marcă comercială (Trademark) ** (in EUR)', $vanzare[ 'marca_comerciala' ], '', false );
                ?>
            </div>
            <div class="two fields">
                <?php
                input_rolem( 'inventariu_aprox', 'Inventar Aproximativ ** (in lei)', $vanzare[ 'inventariu_aprox' ], '', false );
                select_rolem( 'inventar_inclus_in_pret', ' Inclus in Pret*', array(""=>"Nespecificat", "da" => "Da", "nu" => "Nu" ), $vanzare[ 'inventar_inclus_in_pret' ], 'Alege...', false, array() );
                ?>
            </div>
            <div class="two fields">
                <div id="div_motiv_vanzare_ro" class=" field " motiv_vanzare="">
                    <label id="label_motiv_vanzare" for="motiv_vanzare">Motivul Vânzări ** <i class="gb ro flag"></i> </label>
                    <input class="form-control" name="motiv_vanzare" id="motiv_vanzare" value="<?=$vanzare[ 'motiv_vanzare' ]?>" type="text">
                </div>

                <div id="div_motiv_vanzare_en" style='display:none'  class=" field " motiv_vanzare="">
                    <label id="label_motiv_vanzare" for="motiv_vanzare">Motivul Vânzări ** <i class="gb uk flag"></i> </label>
                    <input class="form-control" name="motiv_vanzare_en" id="motiv_vanzare_en" value="<?=$vanzare[ 'motiv_vanzare_en' ]?>" type="text">
                </div>

                <?php
                //input_rolem( 'motiv_vanzare', 'Motivul Vânzări **', $vanzare[ 'motiv_vanzare' ], '', false );
                input_rolem( 'cifra_afaceri_anterior', 'Cifra de afaceri din anii anteriori (in lei) **', $vanzare[ 'cifra_afaceri_anterior' ], '', false );
                ?>
            </div>
            <div class="two fields">
            <div id="div_suport_ro" class=" field " suport="">
                    <label id="label_suport" for="suport">Suport si Training ** <i class="gb ro flag"></i> </label>
                    <input class="form-control" name="suport" id="suport" value="<?=$vanzare[ 'suport' ]?>" type="text">
                </div>

                <div id="div_suport_en" style='display:none'  class=" field " suport="">
                    <label id="label_suport" for="suport">Support and Training ** <i class="gb uk flag"></i> </label>
                    <input class="form-control" name="suport_en" id="suport_en" value="<?=$vanzare[ 'suport_en' ]?>" type="text">
                </div>
                <?php
                input_rolem( 'nr_angajati', 'Număr de Angajați **', $vanzare[ 'nr_angajati' ], '', false );
               // input_rolem( 'acte_adaugare', 'Acte/Documente de Adăugat *	', $vanzare[ 'acte_adaugare' ], '', false, array("class"=>"ascuns") );

            //   PREA($vanzare);
                ?>
            </div>
            
                    <div class="main ui intro container">
                        <h4 class="ui dividing header">
                            SEO
                            <a class="anchor" id="preface"></a></h4>
                    </div>
 
            
			<div class="three fields">
			<div id="div_alt_text_ro" class=" field " suport="">
                    <label id="label_alt_text" for="alt_text">Alt text poza ** <i class="gb ro flag"></i> </label>
                    <input class="form-control" name="alt_text" id="alt_text" value="<?=$vanzare[ 'alt_text' ]?>" type="text">
                </div>

                <div id="div_alt_text_en" style='display:none'  class=" field " suport="">
                    <label id="label_alt_text" for="alt_text">Alt text poza ** <i class="gb uk flag"></i> </label>
                    <input class="form-control" name="alt_text_en" id="alt_text_en" value="<?=$vanzare[ 'alt_text_en' ]?>" type="text">
                </div>
                
                <div id="div_focus_keyword_ro" class=" field " suport="">
                    <label id="label_focus_keyword" for="focus_keyword">Focus keyword ** <i class="gb ro flag"></i> </label>
                    <input class="form-control" name="focus_keyword" id="focus_keyword" value="<?=$vanzare[ 'focus_keyword' ]?>" type="text">
                </div>

                <div id="div_focus_keyword_en" style='display:none'  class=" field " suport="">
                    <label id="label_focus_keyword" for="focus_keyword">Focus keyword ** <i class="gb uk flag"></i> </label>
                    <input class="form-control" name="focus_keyword_en" id="focus_keyword_en" value="<?=$vanzare[ 'focus_keyword_en' ]?>" type="text">
                </div>
                
                <div id="div_meta_description_ro" class=" field " suport="">
                    <label id="label_meta_description" for="meta_description">Meta description ** <i class="gb ro flag"></i> </label>
                    <input class="form-control" name="meta_description" id="meta_description" value="<?=$vanzare[ 'meta_description' ]?>" type="text">
                </div>

                <div id="div_meta_description_en" style='display:none'  class=" field " suport="">
                    <label id="label_meta_description" for="meta_description">Meta description ** <i class="gb uk flag"></i> </label>
                    <input class="form-control" name="meta_description_en" id="meta_description_en" value="<?=$vanzare[ 'meta_description_en' ]?>" type="text">
                </div>
            
            </div>
<?php
$promovati_active = (get_promovare_activa($_GET['edit']));
$promovati_tip_imobiliare_active = false;
foreach ($promovati_active as $kkkk=>$ddddd){
    if(in_array($kkkk,$promovati_tip_imobiliare)){
        $promovati_tip_imobiliare_active = true;
    }
}
?>

            <div class="row">
                <div class="col-xs-7 col-sm-7 raspuns_links">
                    <div class="checkbox">
                        <label class="<?=$promovati_tip_imobiliare_active ? '' : ' hide'?>">
                            <input type="checkbox" disabled name="promovat_imobiliare" value="1" <?=$promovati_tip_imobiliare_active ? ' checked' : ''?>>
                            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                            Promoveaza imobiliare.ro &  Spatii Comerciale
                        </label>
                    </div>
                </div>
                <div class="col-xs-5 col-sm-5 raspuns_links imobiliare_zone <?=$promovati_tip_imobiliare_active ? ' ' : ' hide'?>">
                    <br>
                    <div class="" style="display: <?=strlen($vanzare['id_imobiliare']) ? ' none' : ' '?>"> <?php if(($vanzare['status']) == 3) { ?><a title="Publica anuntul " class="ui green  button publica_imobiliare_btn" onclick="save_all_forms_vanzare()"  style="">Publica</a><?php } ?></div>
                    <div class="" style="display: <?=strlen($vanzare['id_imobiliare']) ? ' inline' : ' none'?>"> <?php if(($vanzare['status']) == 3) { ?><a title="Editeaza anuntul Imobiliare.ro" target="_blank" class="ui  basic button"  style="" href="<?=ROOT?>imobiliare.ro/?company=<?=$_GET['edit']?>">Edit</a><?php } ?></div>

                    <!--  <a target="_blank" href="https://adminonline.imobiliare.ro/oferte/apartamente/vanzari/<?=$vanzare['id_imobiliare']?>"><input type="button" class="ui green teal button" id="" value="Vezi pe adminonline.Imobiliare.ro"></a>  -->
                    <a target="_blank" href="https://www.spatiicomerciale.ro/anunt/<?=$vanzare['id_imobiliare']?>" class="<?=strlen($vanzare['id_imobiliare']) ? ' ' : ' hide'?>"><input type="button" class="ui green red button" id="" value="Vezi pe Imobiliare.ro"></a>
                </div>
            </div>
            <div id="" class="imobiliare_zone <?=$promovati_tip_imobiliare_active ? '' : ' hide'?>">

          <div class="row">
                <div class="col-sm-12">

                    <div class="main ui intro container">
                        <h2 class="ui dividing header">
                            Date Suplimentare  Spatii Comerciale **

                            <a class="anchor" id="preface"></a></h2>
                    </div>
                </div>
            </div>


            <div class="four fields ascuns">
              <?php	select_rolem( 'tipimobil', 'Tip imobil', array(""=>"Neselectat") + $valuesSp['tipimobil'], $vanzare[ 'tipimobil' ], 'Alege...', false, array() ); ?>
              <?php	input_rolem( 'anconstructie', 'An constructie', $vanzare[ 'anconstructie' ], '', false ); ?>
              <?php	select_rolem( 'stadiuconstructie', 'Stadiu constructie',  array(""=>"Neselectat") + $valuesSp['stadiuconstructie'], $vanzare[ 'stadiuconstructie' ], 'Alege...', false, array() ); ?>
              <?php	select_rolem( 'structurarezistenta', 'Structura rezistenta',  array(""=>"Neselectat") + $valuesSp['structurarezistenta'], $vanzare[ 'structurarezistenta' ], 'Alege...', false, array() ); ?>
              
            </div>
            <div class="four fields ascuns">
            <?php	input_rolem( 'suprafataconstruita', 'Suprafata construita', $vanzare[ 'suprafataconstruita' ], '', false ); ?>
            <?php	input_rolem( 'suprafatautila', 'Suprafata utila', $vanzare[ 'suprafatautila' ], '', false ); ?>
            <?php	input_rolem( 'suprafatateren', 'Suprafata teren', $vanzare[ 'suprafatateren' ], '', false ); ?>
            <?php	input_rolem( 'pretinchiriere', 'Pret inchiriere', $vanzare[ 'pretinchiriere' ], '', false ); ?>
            </div>
            <div class="four fields ascuns">
            <?php	input_rolem( 'nrnivele', 'Nr nivele', $vanzare[ 'nrnivele' ], '', false ); ?>
            <?php	input_rolem( 'nrincaperi', 'Nr incaperi', $vanzare[ 'nrincaperi' ], '', false ); ?>
            <?php	input_rolem( 'nrgrupurisanitare', 'Nr grupuri sanitare', $vanzare[ 'nrgrupurisanitare' ], '', false ); ?>
         <?php	input_rolem( 'nrparcari', 'Nr parcari', $vanzare[ 'nrparcari' ], '', false ); ?>
         
            </div>
            <div class="two fields ascuns"> 
            
              <div class="field">
             <label class="control-label">Utilitati(selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="utilitati[]" multiple class="chosen-select">
             <?php


 			$tmpda=explode(',',$vanzare[ 'utilitati' ]);
             foreach ($valuesSp['utilitati'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(in_array($k,$tmpda)?"selected":"").">".$v."</option>";
              }
             ?>
              </select>
            </div>
            <div class="field">
             <label class="control-label">Dotari (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="dotari[]" multiple class="chosen-select">
             <?php
			$tmpda=explode(',',$vanzare[ 'dotari' ]);
             foreach ($valuesSp['dotari'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(in_array($k,$tmpda)?"selected":"").">".$v."</option>";
              }
             ?>
              </select>
               </div>
            </div>
            <div class="two fields ascuns">
			<div class="field">
             <label class="control-label">Servicii (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="servicii[]" multiple class="chosen-select">
             <?php
			$tmpda=explode(',',$vanzare[ 'servicii' ]);
             foreach ($valuesSp['servicii'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(in_array($k,$tmpda)?"selected":"").">".$v."</option>";
              }
             ?>
              </select>
               </div>
               <div class="field">
             <label class="control-label">Alte caracteristici (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="altecaracteristici[]" multiple class="chosen-select">
             <?php
			$tmpda=explode(',',$vanzare[ 'altecaracteristici' ]);
             foreach ($valuesSp['altecaracteristici'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(in_array($k,$tmpda)?"selected":"").">".$v."</option>";
              }
             ?>
              </select>
               </div>
            </div>
</div>




            <div class="row">
                <div class="col-sm-9">
                    <div class="main ui intro container">
                        <h2 class="ui dividing header">
                            Date Contract *
                            <a class="anchor" id="preface"></a></h2>
                    </div>
                </div>
            </div>
            <div class="four fields ascuns">
                <?php
                select_rolem( 'exclusivitate', 'Exclusivitate*', array(""=>"Neselectat", "da" => "Da", "nu" => "Nu" ), $vanzare[ 'exclusivitate' ], 'Alege...', false, array() );
                input_rolem( 'consultanta', 'Consultanta, Pachet IM *', $vanzare[ 'consultanta' ], '', false );
                input_rolem( 'comision', 'Comision *', $vanzare[ 'comision' ], '', false );
                select_rolem( 'la_site', ' Listare ascunsa*', array(""=>"Neselectat", "da" => "Da", "nu" => "Nu" ), $vanzare[ 'la_site' ], 'Alege...', false, array() );
                ?>
                <div class="ui two column centered grid">
                    <!-- <div class="column"> Listare ascunsa*</div> -->

                    <div class="two column centered row">

                        <?php
                        //   select_rolem('la_nume','Cu nume',array("da"=>"Da","nu"=>"Nu"),$vanzare['la_nume'],'Alege...',false,array());
                        ?>

                        <div class="column">
                            <?php

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>




        <?php companie_edit_insert($vanzare['companie_vanzare'],$from_doc,'adauga_vanzare', 'Date Afacere *');?>


		<br>
		<?php companie_edit_insert($vanzare['reprezentant_vanzare'],$from_doc,'reprezentant_vanzare','Date vanzator*');?>

	</div>
	
    <?php } ?>
</div>