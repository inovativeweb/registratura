<?php require ('controller.php');

$page_head[ 'title' ] = 'Publica imobiliare.ro';
$page_head[ 'trail' ] = 'imobiliare.ro';



require_login();


index_head();


if(!count($vanzare)){
    die('Eroare! Afacere neselecatata!');
}

$ofertaxml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<oferta tip="apartament" versiune="3">
<id2>123456789</id2>
<idstr></idstr>
<judet>10</judet>
<localitate>13822</localitate>
<zona>750</zona>
<portal>1</portal>
<tiplocuinta>110</tiplocuinta>
<devanzare>1</devanzare>
<dataadaugare>1</dataadaugare>
<datamodificare>1</datamodificare>
<destinatie>466</destinatie>
<idnum></idnum>
<agent>51</agent>
<tipimobil>121</tipimobil>
<ansamblurezidential>0</ansamblurezidential>
<tipcompartimentare>26</tipcompartimentare>
<demisol>0</demisol><dotari>20 142 145</dotari>
<finisaje>55 56</finisaje>
<deinchiriat>0</deinchiriat>
<mansarda>0</mansarda>
<nrbucatarii>1</nrbucatarii>
<nrnivele>4</nrnivele>
<pretnegociabil>1</pretnegociabil>
<pretvanzare>125000</pretvanzare>
<monedavanzare>172</monedavanzare>
<patratecaroiaj>172</patratecaroiaj>
<etaj>47</etaj>   
<nrcamere>1</nrcamere>   
<tara>1048</tara>
<pretinchiriere>464000</pretinchiriere>
<monedainchiriere>172</monedainchiriere>
<vicii>
	<lang id="1048">Zm9hcnRlIHVyYXQ=</lang>
</vicii>
<pretinchiriereunitar>464000</pretinchiriereunitar>
<monedainchiriereunitar>172</monedainchiriereunitar>

<structurarezistenta>138</structurarezistenta>
<subsol>0</subsol>
<regimhotelier>0</regimhotelier>
<pretfaratva>0</pretfaratva>
<utilitati>21 22 28 32 34 44 91</utilitati>
<caroiaj>29085525</caroiaj>
<imagini nrimagini="1">
    <imagine dummy="False" latime="800" inaltime="600" pozitie="1">
      <descriere>YWljaSBhciBmaSBkZXNjcmllcmVhIGltYWdpbmlp</descriere>
      <blob>/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAoHBwgHBgoICAgLCgoLDhgQDg0NDh0VFhEYIx8lJCIfIiEmKzcvJik0KSEiMEExNDk7Pj4+JS5ESUM8SDc9Pjv/2wBDAQoLCw4NDhwQEBw7KCIoOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozv/wAARCAF3AWcDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD2aiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiql9f2emWrXV/dQ20C9ZJnCqPTk155rnxv0OwLR6TbS6lIvHmE+VH+BILH/AL5x70AenUV886h8avFV6HW1a0sEJ+Vood7qM9MuSCcd8D8Kwrj4keMbpWWTxBdKGHPlFYz+BUDH4UAfUdFfKUXjPxTHIrjxJqhIIPzXsjD8i2D9DWlb/FTxpbFSNbeQKclZYkYH2OVz+tAH03RXhek/HfVIWC6tpdtcqSPnt2MTAdzg5BP5V6T4c+InhvxM6Q2l75N04GLe4GxyeeB2Y8H7pNAHV0UUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAV5546+Kdh4XeSw0/be6ntOVz+7gPbcR1P8Asj8SOKx/ij8TZdLkfQdCnAuxxdXSkHyv9hf9r1Pbtz93xFmZ2LMSzE5JJySaANPXfEWqeI7v7Vqt29xIM7QeFjB7KBwB0/KsmiigAooooAKKKKACnqzIwZSVYHIIOCDTKKAPU/A3xeutLaPT/EUkl7ZkhUuessI6c93X/wAe69eBXuFtcQ3lvHc20qTQyqGSRGDKwPIII6ivjyvS/hT4/bQb9dG1Kdjpt04ETMci3kJ6+ysTz2B59aAPoGiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArg/if41PhXQxDaPt1S9ysBxny1GNz/UZwPc9wDXazTR28LzzOEjiUs7N0UAZJP4V8s+M/EUvirxRdao+4RO2yBT/BGOFH9T7k0AYryPLIzuxZ2JJYnJJPUk1FRRQAUUVZsbG51K9is7OFpriZgscajJYmgCtWlZaBrGpI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KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAP/2Q==</blob>
      <titlu>VW4gdGl0bHUgc3VnZXN0aXYgZGFyIG9wdGlvbmFsLi4u</titlu>
     </imagine>
</imagini>

</oferta>';

if(isset($_GET['json'])) {
    prea($types[$type]);
    prea($vanzare);
    prea($data);
    prea($nomenclator);


}

$type=(isset($_GET['type'])?$_GET['type']:"4");
$imob_db = many_query("SELECT * FROM `imobiliare` WHERE `type` = $type and id_vanzare = '".floor($_GET['company'])."' ");
$json = json_decode($imob_db['json'], true);
	
?>
<div class="row ">
<div class="col-xs-10" style="display: inline">
    <div class="ui icon message  purple div_msgXXX hide">
        <i class="close icon"></i>
        <h4>Info</h4>
    </div>
    </div>

<div class="col-xs-1" style="display: inline">
    <a colorboxiframe="" target="_blank" class="print_btn cboxElement" style="" href="/add_afacere/preview.php?edit=<?=$vanzare['idv']?>&amp;date_companie_vanzare"><i class="circular purple eye outline icon"></i></a>
</div>
</div>
<div class="ui icon message  red div_msg hide">
    <i class="close icon"></i>
    <i class="notched circle loading icon"></i>
    <div class="content">
        <div class="header">

        </div>
        <p class="raspuns_publicare">
    </div>
</div>
<br>
<div class="row">
    <div class="col-xs-12 col-sm-7">

<div class="ui three ordered top attached steps" id="add_publicare">

    <a class=" step <?=$step == 'harta' ? ' active ' : ''?>  <?=strlen($vanzare['caroiaj'])>0 ? ' completed' : ''?>" step="harta">
        <div class="content">
            <div class="title">
              Selecteaza pe harta

            </div>
        </div>
    </a>
    <a class="step <?=$step == 'verificare' ? ' active ' : '  '?>" step="verificare">
        <div class="content">
            <div class="title">Verifica datele</div>
        </div>
    </a>

    <a class="step <?=$step== 'publicat' ? ' active ' : '  '?>" step="publicat">
        <div class="content">
            <div class="title"></div>
            <input type="button" class="ui green basic button" style="margin-left: 100px" id="" onmousedown="publica();" value="Publica">
        </div>
    </a>
</div>
</div>
    <div class="col-xs-12 col-sm-5 raspuns_links">
        <?php if(strlen($vanzare['id_imobiliare']) == 9) { ?>
        <br>
            <?php if($is_admin) { ?>
       <a target="_blank" href="https://adminonline.imobiliare.ro/oferte/apartamente/vanzari/<?=$vanzare['id_imobiliare']?>"><input type="button" class="ui green teal button"  id=""  value="Adminonline.Imobiliare.ro"></a>
  <?php } ?>
        <a target="_blank" href="<?=$type != 4 ? 'https://www.imobiliare.ro' : 'https://www.spatiicomerciale.ro'?>/anunt/<?=$vanzare['id_imobiliare']?>"><input type="button" class="ui green red button"  id=""  value="Imobiliare.ro"></a>
        <?php } ?>
        <a  href="https://brokers.trade-x.ro/add_afacere/?edit=<?=$vanzare['idv']?>"><input type="button" class="ui green purple button"  id=""  value="Inapoi la <?=$vanzare['denumire']?>"></a>
    </div>
</div>

<br>

<div id="harta" class="div_step <?=$step=='harta' ? '' : ' hide'?>">
    <!-- <iframe src="/imobiliare.ro/api-publicare-anunturi/varianta-extensie-php5-soap/harta.php" frameborder="0" style="border: 0; min-height: 700px;" width="100%" height="100%"></iframe>-->
    <?php include ('./api-publicare-anunturi/varianta-extensie-php5-soap/harta.php'); ?>

</div>
<div id="verificare"  class="div_step <?=$step=='verificare' ? '' : ' hide'?>">
    <form action="<?=ROOT?>imobiliare.ro/" method="get" enctype="application/x-www-form-urlencoded" id="country_form" class="hide">
        <div class="ui buttons">
        <input type="hidden" value="<?=$_GET['status']?>" name="status">
        <input type="hidden" value="<?=$_GET['company']?>" name="company">
        <input type="hidden" value="<?=$type?>" name="type" id='type'>
        <?php foreach ($types as $t=>$val){  $i++;?>
            <button class="ui button <?=$type == $t ? 'positive' : ''?> " onclick="$('#input_<?=$t?>').prop('checked',true); $('#country_form').submit()">
                <input id="input_<?=$t?>" type="radio" value="<?=$t?>"  <?=$type == $t ? 'checked' : ''?> name="type" class="ui button <?=$type == $t ? 'positive' : ''?> ">
                <img src="/media/logo.png" style="width: 32px;" class="hide" >
                <?=$val?>
            </button>
            <?php echo ((($i>0 and $i<4) || $i < count($type)) ? ' <div class="or"></div>' : ''); ?>
        <?php } ?>
        </div>
    </form>

            <div class="row">
                <form action="" method="post" class="ui form " enctype="application/x-www-form-urlencoded" id="publica_form">
                     <div class="two fields">
                         <?php select_rolem( 'devanzare', 'De vanzare', $danu, (isset($json['devanzare']) ? $json['devanzare'] : '1'), 'Alege...', false, array() ); ?>
                         <?php	select_rolem( 'deinchiriat', 'De inchiriat', $danu, (isset($json['devanzare']) ? $json['devanzare'] : '0'), 'Alege...', false, array() ); ?>
                         
                     </div>
                     <div class="four fields" id="judete_loc_zone">
                             <?php	input_rolem( 'id2', 'ID2', $vanzare[ 'idv' ], '', false ); ?>

                         <div class="field">
                             <label>Judet: <?=$judet_tradex = $judete[$vanzare['judet_id']]?></label>
                             <select judet="" name="judet" id="judet"  style="" data-placeholder="" >
                                 <?php  foreach ($judete_imobiliare as $key=>$opt){ ?>
                                     <option value="<?=$key?>"
                                         <?php
                                         if(($judet_tradex == $opt ||
                                             (substr_count($judet_tradex, 'Bucuresti')
                                                 && substr_count($opt, 'Bucuresti')))){
                                            echo' selected';
                                         }
                                         elseif(isset($json['judet']) and $key == $json['judet'] ){
                                             echo  ' selected';
                                         }
                                         ?>><?=$opt?></option>
                                 <?php } ?>
                             </select>
                         </div>

                         <div class="field div_localitate">
                             <label>Localitate: <?=$localitate_tradex = $localitati[$vanzare['localitate_id']]?></label>
                             <select localitate="" name="localitate" id="localitate"  style="" data-placeholder="" >
                                 <?php  foreach ($localitati_imobiliare as $key=>$opt){ ?>
                                     <option value="<?=$key?>"
                                         <?php
                                         if(isset($json['localitate']) and $key == $json['localitate'] ){ echo  ' selected'; }
                                         else {

                                         echo ($localitate_tradex ==  $opt and $localitate_tradex!='Toate localitatile') ? ' selected' : ''; } ?>><?=$opt?></option>
                                 <?php } ?>
                             </select>
                         </div>
                         <div class="field div_zona">
                     <?php	select_rolem( 'zone', 'Zona ', $zone_imobiliare, '', 'Alege...', false, array() ); ?>
                         </div>
                     </div>

			<?php
			if ($type==0 )
			{
				
			?>
			<div class="two fields">
			<?php	select_rolem( 'destinatie', 'Destinatie', $values['destinatie'], (isset($json['destinatie']) ? $json['destinatie'] : ''), 'Alege...', false, array() ); ?>
            <?php	select_rolem( 'tipimobil', 'Tip imobil', $values['tipimobil'], (isset($json['tipimobil']) ? $json['tipimobil'] : ''), 'Alege...', false, array() ); ?>
            <?php	input_rolem( 'nrcamere', 'Numar camere', (isset($json['nrcamere']) ? $json['nrcamere'] : ''), '', false ); ?>
            <?php	select_rolem( 'tiplocuinta', 'Tip locuinta ', $values['tiplocuinta'], (isset($json['tiplocuinta']) ? $json['tiplocuinta'] : ''), 'Alege...', false, array() ); ?>
             </div>      
             <div class="three fields">
                        
            <?php	select_rolem( 'monedavanzare', 'Moneda vanzare', $values['monedavanzare'], (isset($json['tipimobil']) ? $json['tipimobil'] : ''), 'Alege...', false, array() ); ?>
            <?php	select_rolem( 'etaj', 'Etaj', $values['etaj'], (isset($json['etaj']) ? $json['etaj'] : ''), 'Alege...', false, array() ); ?>
            <?php	select_rolem( 'tara', 'Tara', $values['tara'], (isset($json['tara']) ? $json['tara'] : ''), 'Alege...', false, array() ); ?>

            </div>

             <div class="two fields">
             <div class="field">
             <label class="control-label">Dotari (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="dotari[]" multiple class="chosen-select">
             <?php
		
             foreach ($values['dotari'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['dotari'])?(in_array($k,$json['dotari'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

              <div class="field">
             <label class="control-label">Servicii (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="servicii[]" multiple class="chosen-select">
             <?php

             foreach ($values['servicii'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['servicii'])?(in_array($k,$json['servicii'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
            </div>
            </div>


             <div class="two fields">
             <div class="field">
             <label class="control-label">Utilitati (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="utilitati[]" multiple class="chosen-select">
             <?php

             foreach ($values['utilitati'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['utilitati'])?(in_array($k,$json['utilitati'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

            <div class="field">
             <label class="control-label">Finisaje (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="finisaje[]" multiple class="chosen-select">
             <?php

             foreach ($values['finisaje'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['finisaje'])?(in_array($k,$json['finisaje'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

            </div>
            <div class="four fields">
             <?php	input_rolem( 'anconstructie', 'An constructie', (isset($json['anconstructie']) ? $json['anconstructie'] : ''), '', false ); ?>
             <?php	select_rolem( 'tipcompartimentare', 'Tip compartimentare',$values['tipcompartimentare'], (isset($json['tipcompartimentare']) ? $json['tipcompartimentare'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'confort', 'Confort', $values['confort'], (isset($json['confort']) ? $json['confort'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'demisol', 'Demisol', $danu, (isset($json['demisol']) ? $json['demisol'] : ''), 'Alege...', false, array() ); ?>
             </div>

             <div class="four fields">

             <?php	select_rolem( 'mansarda', 'Mansarda', $danu, (isset($json['mansarda']) ? $json['mansarda'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'monedainchiriere', 'Moneda inchiriere', $values['monedainchiriere'], (isset($json['monedainchiriere']) ? $json['monedainchiriere'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'monedavanzaremp', 'Moneda vanzare mp', $values['monedavanzaremp'], (isset($json['monedavanzaremp']) ? $json['monedavanzaremp'] : ''), 'Alege...', false, array() ); ?>

             </div>

             <div class="four fields">
             <?php	input_rolem( 'nrbai', 'Nr bai', (isset($json['nrbai']) ? $json['nrbai'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrbalcoane', 'Nr balcoane', (isset($json['nrbalcoane']) ? $json['nrbalcoane'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrbalcoaneinchise', 'Nr balcoane inchise', (isset($json['nrbalcoaneinchise']) ? $json['nrbalcoaneinchise'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrbucatarii', 'Nr bucatarii', (isset($json['nrbucatarii']) ? $json['nrbucatarii'] : ''), '', false ); ?>
             </div>

             <div class="four fields">
             <?php	input_rolem( 'nrgaraje', 'Nr garaje', (isset($json['nrgaraje']) ? $json['nrgaraje'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrlocuriparcare', 'Nr locuri parcare', (isset($json['nrlocuriparcare']) ? $json['nrlocuriparcare'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrnivele', 'Nr nivele', (isset($json['nrnivele']) ? $json['nrnivele'] : ''), '', false ); ?>
             <?php	input_rolem( 'pretinchiriere', 'Pret inchiriere', (isset($json['pretinchiriere']) ? $json['pretinchiriere'] : ''), '', false ); ?>
             </div>

             <div class="four fields">
             <?php	select_rolem( 'pretnegociabil', 'Pret negociabil', $danu, (isset($json['pretnegociabil']) ? $json['pretnegociabil'] : ''), 'Alege...', false, array() ); ?>
             <?php	input_rolem( 'pretvanzare', 'Pret vanzare', (isset($json['pretvanzare']) ? $json['pretvanzare'] : $vanzare['pret_vanzare']), '', false ); ?>
             <?php	input_rolem( 'pretvanzaremp', 'Pret vanzare mp', (isset($json['pretvanzaremp']) ? $json['pretvanzaremp'] : ''), '', false ); ?>
             <?php	select_rolem( 'stadiuconstructie', 'Stadiu constructie', $values['stadiuconstructie'], (isset($json['stadiuconstructie']) ? $json['stadiuconstructie'] : ''), 'Alege...', false, array() ); ?>
             </div>
             
             <div class="four fields">
             <?php	select_rolem( 'structurarezistenta', 'Structura rezistenta', $values['structurarezistenta'], (isset($json['structurarezistenta']) ? $json['structurarezistenta'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'subsol', 'Subsol', $danu, (isset($json['subsol']) ? $json['subsol'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'regimhotelier', 'Regim hotelier', $danu, (isset($json['regimhotelier']) ? $json['regimhotelier'] : ''), 'Alege...', false, array() ); ?>
             <?php	input_rolem( 'suprafataconstruita', 'Suprafata construita', (isset($json['suprafataconstruita']) ? $json['suprafataconstruita'] : ''), '', false ); ?>

             </div>

             <div class="four fields">
              <?php	input_rolem( 'suprafatautila', 'Suprafata utila', (isset($json['suprafatautila']) ? $json['suprafatautila'] : ''), '', false ); ?>
              <?php	input_rolem( 'pretregimhotelier', 'Pret regim hotelier', (isset($json['pretregimhotelier']) ? $json['pretregimhotelier'] : ''), '', false ); ?>
             <?php	select_rolem( 'monedaregimhotelier', 'Moneda regim hotelier', $values['monedaregimhotelier'], (isset($json['monedaregimhotelier']) ? $json['monedaregimhotelier'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'pretfaratva', 'Pret fara tva', $danu, (isset($json['pretfaratva']) ? $json['pretfaratva'] : ''), 'Alege...', false, array() ); ?>

             </div>


             <div class="four fields">
             <?php	select_rolem( 'ansamblurezidential', 'Ansamblu rezidential', $danu, (isset($json['ansamblurezidential']) ? $json['ansamblurezidential'] : ''), 'Alege...', false, array() ); ?>
              <?php	select_rolem( 'comisionzero', 'Comision zero', $danu, (isset($json['comisionzero']) ? $json['comisionzero'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'portal', 'Portal', $danu, (isset($json['portal']) ? $json['portal'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'stadiuconstructie', 'Stadiu constructie', $values['stadiuconstructie'], (isset($json['stadiuconstructie']) ? $json['stadiuconstructie'] : ''), 'Alege...', false, array() ); ?>
             </div>
             <div class="four fields">
             <?php	input_rolem( 'prettranzactie', 'Pret tranzactie', (isset($json['prettranzactie']) ? $json['prettranzactie'] : ''), '', false ); ?>
             <?php	input_rolem( 'comisionvanzator', 'Comision vanzator', (isset($json['comisionvanzator']) ? $json['comisionvanzator'] : ''), '', false ); ?>
             <?php	input_rolem( 'pretinchiriereunitar', 'Pret inchiriere unitar', (isset($json['pretinchiriereunitar']) ? $json['pretinchiriereunitar'] : ''), '', false ); ?>
             <?php	input_rolem( 'monedainchiriereunitar', 'Moneda inchiriere unitar', (isset($json['monedainchiriereunitar']) ? $json['monedainchiriereunitar'] : ''), '', false ); ?>
             </div>
             <div class="four fields">
             <?php	input_rolem( 'linkextern', 'Link extern', (isset($json['linkextern']) ? $json['linkextern'] : ''), '', false ); ?>

            <div class="field">
             <label class="control-label">Alte detalii zona (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="altedetaliizona[]" multiple class="chosen-select">
             <?php

             foreach ($values['altedetaliizona'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['altedetaliizona'])?(in_array($k,$json['altedetaliizona'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

             </div>
      
      <?php
      }
      ?>
      
      	<?php
			if ($type==1)
			{
				
			?>
			<div class="two fields">
			<?php	select_rolem( 'destinatie', 'Destinatie', $valuesCv['destinatie'],(isset($json['destinatie']) ? $json['destinatie'] : ''), 'Alege...', false, array() ); ?>
            <?php	select_rolem( 'tipimobil', 'Tip imobil', $valuesCv['tipimobil'], (isset($json['tipimobil']) ? $json['tipimobil'] : ''), 'Alege...', false, array() ); ?>
            <?php	input_rolem( 'nrcamere', 'Numar camere', (isset($json['nrcamere']) ? $json['nrcamere'] : ''), '', false ); ?>
            <?php	select_rolem( 'tiplocuinta', 'Tip locuinta ', $valuesCv['tiplocuinta'], (isset($json['tiplocuinta']) ? $json['tiplocuinta'] : ''), 'Alege...', false, array() ); ?>
             </div>      
             <div class="three fields">
                        
            <?php	select_rolem( 'monedavanzare', 'Moneda vanzare', $valuesCv['monedavanzare'], (isset($json['monedavanzare']) ? $json['monedavanzare'] : ''), 'Alege...', false, array() ); ?>
            <?php	select_rolem( 'etaj', 'Etaj', $valuesCv['etaj'], (isset($json['etaj']) ? $json['etaj'] : ''), 'Alege...', false, array() ); ?>
            <?php	select_rolem( 'tara', 'Tara', $valuesCv['tara'], (isset($json['tara']) ? $json['tara'] : ''), 'Alege...', false, array() ); ?>

            </div>

             <div class="two fields">
             <div class="field">
             <label class="control-label">Dotari (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="dotari[]" multiple class="chosen-select">
             <?php

             foreach ($valuesCv['dotari'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['dotari'])?(in_array($k,$json['dotari'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

              <div class="field">
             <label class="control-label">Servicii (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="servicii[]" multiple class="chosen-select">
             <?php

             foreach ($valuesCv['servicii'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['servicii'])?(in_array($k,$json['servicii'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
            </div>
            </div>


             <div class="two fields">
             <div class="field">
             <label class="control-label">Utilitati (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="utilitati[]" multiple class="chosen-select">
             <?php

             foreach ($valuesCv['utilitati'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['utilitati'])?(in_array($k,$json['utilitati'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

            <div class="field">
             <label class="control-label">Finisaje (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="finisaje[]" multiple class="chosen-select">
             <?php

             foreach ($valuesCv['finisaje'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['finisaje'])?(in_array($k,$json['finisaje'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

            </div>
            <div class="four fields">
             <?php	input_rolem( 'anconstructie', 'An constructie', (isset($json['anconstructie']) ? $json['anconstructie'] : ''), '', false ); ?>
             <?php	select_rolem( 'tipcompartimentare', 'Tip compartimentare',$valuesCv['tipcompartimentare'], (isset($json['tipcompartimentare']) ? $json['tipcompartimentare'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'confort', 'Confort', $valuesCv['confort'], (isset($json['confort']) ? $json['confort'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'demisol', 'Demisol', $danu, (isset($json['demisol']) ? $json['demisol'] : ''), 'Alege...', false, array() ); ?>
             </div>

             <div class="four fields">

             <?php	select_rolem( 'mansarda', 'Mansarda', $danu, (isset($json['mansarda']) ? $json['mansarda'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'monedainchiriere', 'Moneda inchiriere', $valuesCv['monedainchiriere'], (isset($json['monedainchiriere']) ? $json['monedainchiriere'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'monedavanzaremp', 'Moneda vanzare mp', $values['monedavanzaremp'],(isset($json['monedavanzaremp']) ? $json['monedavanzaremp'] : ''), 'Alege...', false, array() ); ?>

             </div>

             <div class="four fields">
             <?php	input_rolem( 'nrbai', 'Nr bai', (isset($json['nrbai']) ? $json['nrbai'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrbalcoane', 'Nr balcoane', (isset($json['nrbalcoane']) ? $json['nrbalcoane'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrbalcoaneinchise', 'Nr balcoane inchise', (isset($json['nrbalcoaneinchise']) ? $json['nrbalcoaneinchise'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrbucatarii', 'Nr bucatarii', (isset($json['nrbucatarii']) ? $json['nrbucatarii'] : ''), '', false ); ?>
             </div>

             <div class="four fields">
             <?php	input_rolem( 'nrgaraje', 'Nr garaje', (isset($json['nrgaraje']) ? $json['nrgaraje'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrlocuriparcare', 'Nr locuri parcare', (isset($json['nrlocuriparcare']) ? $json['nrlocuriparcare'] : ''), '', false ); ?>
             <?php	input_rolem( 'nrnivele', 'Nr nivele', (isset($json['nrnivele']) ? $json['nrnivele'] : ''), '', false ); ?>
             <?php	input_rolem( 'pretinchiriere', 'Pret inchiriere', (isset($json['pretinchiriere']) ? $json['pretinchiriere'] : ''), '', false ); ?>
             </div>

             <div class="four fields">
             <?php	select_rolem( 'pretnegociabil', 'Pret negociabil', $danu, (isset($json['pretnegociabil']) ? $json['pretnegociabil'] : ''), 'Alege...', false, array() ); ?>
             <?php	input_rolem( 'pretvanzare', 'Pret vanzare', (isset($json['pretvanzare']) ? $json['pretvanzare'] : $vanzare['pret_vanzare']), '', false ); ?>
             <?php	input_rolem( 'pretvanzaremp', 'Pret vanzare mp', (isset($json['pretvanzaremp']) ? $json['pretvanzaremp'] : ''), '', false ); ?>
             <?php	select_rolem( 'stadiuconstructie', 'Stadiu constructie', $valuesCv['stadiuconstructie'], (isset($json['stadiuconstructie']) ? $json['stadiuconstructie'] : ''), 'Alege...', false, array() ); ?>
             </div>
             
             <div class="four fields">
             <?php	select_rolem( 'structurarezistenta', 'Structura rezistenta', $valuesCv['structurarezistenta'], (isset($json['structurarezistenta']) ? $json['structurarezistenta'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'subsol', 'Subsol', $danu, (isset($json['subsol']) ? $json['subsol'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'regimhotelier', 'Regim hotelier', $danu, (isset($json['regimhotelier']) ? $json['regimhotelier'] : ''), 'Alege...', false, array() ); ?>
             <?php	input_rolem( 'suprafataconstruita', 'Suprafata construita', (isset($json['suprafataconstruita']) ? $json['suprafataconstruita'] : ''), '', false ); ?>

             </div>

             <div class="four fields">
              <?php	input_rolem( 'suprafatautila', 'Suprafata utila', (isset($json['suprafatautila']) ? $json['suprafatautila'] : ''), '', false ); ?>
              <?php	input_rolem( 'pretregimhotelier', 'Pret regim hotelier', (isset($json['pretregimhotelier']) ? $json['pretregimhotelier'] : ''), '', false ); ?>
             <?php	select_rolem( 'monedaregimhotelier', 'Moneda regim hotelier', $valuesCv['monedaregimhotelier'], (isset($json['monedaregimhotelier']) ? $json['monedaregimhotelier'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'pretfaratva', 'Pret fara tva', $danu, (isset($json['pretfaratva']) ? $json['pretfaratva'] : ''), 'Alege...', false, array() ); ?>

             </div>


             <div class="four fields">
             <?php	select_rolem( 'ansamblurezidential', 'Ansamblu rezidential', $danu, (isset($json['ansamblurezidential']) ? $json['ansamblurezidential'] : ''), 'Alege...', false, array() ); ?>
              <?php	select_rolem( 'comisionzero', 'Comision zero', $danu, (isset($json['comisionzero']) ? $json['comisionzero'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'portal', 'Portal', $danu, (isset($json['portal']) ? $json['portal'] : ''), 'Alege...', false, array() ); ?>
             <?php	select_rolem( 'stadiuconstructie', 'Stadiu constructie', $valuesCv['stadiuconstructie'], (isset($json['stadiuconstructie']) ? $json['stadiuconstructie'] : ''), 'Alege...', false, array() ); ?>
             </div>
             <div class="four fields">
             <?php	input_rolem( 'prettranzactie', 'Pret tranzactie', (isset($json['prettranzactie']) ? $json['prettranzactie'] : ''), '', false ); ?>
             <?php	input_rolem( 'comisionvanzator', 'Comision vanzator', (isset($json['comisionvanzator']) ? $json['comisionvanzator'] : ''), '', false ); ?>
             <?php	input_rolem( 'pretinchiriereunitar', 'Pret inchiriere unitar', (isset($json['pretinchiriereunitar']) ? $json['pretinchiriereunitar'] : ''), '', false ); ?>
             <?php	input_rolem( 'monedainchiriereunitar', 'Moneda inchiriere unitar', (isset($json['monedainchiriereunitar']) ? $json['monedainchiriereunitar'] : ''), '', false ); ?>
             </div>
             <div class="four fields">
             <?php	input_rolem( 'linkextern', 'Link extern', (isset($json['linkextern']) ? $json['linkextern'] : ''), '', false ); ?>

            <div class="field">
             <label class="control-label">Alte detalii zona (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="altedetaliizona[]" multiple class="chosen-select">
             <?php

             foreach ($valuesCv['altedetaliizona'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['altedetaliizona'])?(in_array($k,$json['altedetaliizona'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

             </div>
      
      <?php
      }
      ?>
      <?php
      
      if ($type==3)
      {
	  	?>
	  	<div class="four fields">
	  	 <?php	select_rolem( 'tipteren', 'Tip teren', $valuesTr['tipteren'], (isset($json['tipteren']) ? $json['tipteren'] : ''), 'Alege...', false, array() ); ?>
         <?php	input_rolem( 'suprafatateren', 'Suprafata teren', (isset($json['suprafatateren']) ? $json['suprafatateren'] : ''), '', false ); ?>
         <?php	select_rolem( 'umsuprafatateren', 'UM suprafata teren', $valuesTr['umsuprafatateren'], (isset($json['umsuprafatateren']) ? $json['umsuprafatateren'] : ''), 'Alege...', false, array() ); ?>
        <?php	input_rolem( 'numelotparcele', 'Nume lot parcele', (isset($json['numelotparcele']) ? $json['numelotparcele'] : ''), '', false ); ?>
        </div>
        <div class="four fields">
	  	 <?php	input_rolem( 'frontstradal', 'Front stradal', (isset($json['frontstradal']) ? $json['frontstradal'] : ''), '', false ); ?>
         <?php	input_rolem( 'lotparcele', 'Lot parcele', (isset($json['lotparcele']) ? $json['lotparcele'] : ''), '', false ); ?>
        <?php	input_rolem( 'inclinatieteren', 'Inclinatie teren', (isset($json['inclinatieteren']) ? $json['inclinatieteren'] : ''), '', false ); ?>
        <?php	input_rolem( 'latimedrumacces', 'Latime drum acces', (isset($json['latimedrumacces']) ? $json['latimedrumacces'] : ''), '', false ); ?>
        </div>
        	<div class="four fields">
	  	 <?php	select_rolem( 'monedainchiriere', 'Moneda inchiriere', $valuesTr['monedainchiriere'], (isset($json['monedainchiriere']) ? $json['monedainchiriere'] : ''), 'Alege...', false, array() ); ?>
	  	 <?php	select_rolem( 'monedainchiriereunitar', 'Moneda inchiriere unitar', $valuesTr['monedainchiriereunitar'], (isset($json['monedainchiriereunitar']) ? $json['monedainchiriereunitar'] : ''), 'Alege...', false, array() ); ?>
	  	 <?php	select_rolem( 'monedavanzare', 'Moneda vanzare', $valuesTr['monedavanzare'], (isset($json['monedavanzare']) ? $json['monedavanzare'] : ''), 'Alege...', false, array() ); ?>
	  	 <?php	select_rolem( 'monedavanzaremp', 'Moneda vanzare mp', $valuesTr['monedavanzaremp'], (isset($json['monedavanzaremp']) ? $json['monedavanzaremp'] : ''), 'Alege...', false, array() ); ?>
        </div>
       	<div class="four fields">
       	<?php	input_rolem( 'nrfronturistradale', 'Nr fronturi stradale', (isset($json['nrfronturistradale']) ? $json['nrfronturistradale'] : ''), '', false ); ?>
       	<?php	input_rolem( 'pretinchiriere', 'Pret inchiriere', (isset($json['pretinchiriere']) ? $json['pretinchiriere'] : ''), '', false ); ?>
       	<?php	select_rolem( 'pretnegociabil', 'Pret negociabil', $danu, (isset($json['pretnegociabil']) ? $json['pretnegociabil'] : ''), 'Alege...', false, array() ); ?>
       	<?php	input_rolem( 'pretvanzare', 'Pret vanzare', (isset($json['pretvanzare']) ? $json['pretvanzare'] : $vanzare['pret_vanzare']), '', false ); ?>
        </div> 
       	<div class="four fields">
       	<?php	input_rolem( 'pretvanzaremp', 'Pret vanzare mp', (isset($json['pretvanzaremp']) ? $json['pretvanzaremp'] : ''), '', false ); ?>
       	<?php	input_rolem( 'suprafataconstruita', 'Suprafata construita', (isset($json['suprafataconstruita']) ? $json['suprafataconstruita'] : ''), '', false ); ?>
       	<?php	select_rolem( 'pretfaratva', 'Pret fara tva', $danu, (isset($json['pretfaratva']) ? $json['pretfaratva'] : ''), 'Alege...', false, array() ); ?>
       	<?php	select_rolem( 'uminchiriereunitar', 'UM inchiriere unitar', $valuesTr['uminchiriereunitar'], (isset($json['uminchiriereunitar']) ? $json['uminchiriereunitar'] : ''), 'Alege...', false, array() ); ?>
       	</div> 
       	<div class="four fields">
       	<?php	input_rolem( 'prettranzactie', 'pret tranzactie', (isset($json['prettranzactie']) ? $json['prettranzactie'] : ''), '', false ); ?>
       	<?php	input_rolem( 'pretinchiriereunitar', 'pret inchiriere unitar', (isset($json['pretinchiriereunitar']) ? $json['pretinchiriereunitar'] : ''), '', false ); ?>
       	<?php	select_rolem( 'umvanzareunitar', 'UM vanzare unitar', $valuesTr['umvanzareunitar'], (isset($json['umvanzareunitar']) ? $json['umvanzareunitar'] : ''), 'Alege...', false, array() ); ?>
       	<?php	input_rolem( 'comisionvanzator', 'comision vanzator', (isset($json['comisionvanzator']) ? $json['comisionvanzator'] : ''), '', false ); ?>
       	
       	</div> 
       	<div class="four fields">
       	<?php	input_rolem( 'procentocupareteren', 'Procent ocupare teren', (isset($json['procentocupareteren']) ? $json['procentocupareteren'] : ''), '', false ); ?>
       	<?php	input_rolem( 'coeficientutilizareteren', 'Coeficient utilizare teren', (isset($json['coeficientutilizareteren']) ? $json['coeficientutilizareteren'] : ''), '', false ); ?>
       	<?php	select_rolem( 'sursainformatiicoeficienti', 'Sursa informatii coeficienti', $valuesTr['sursainformatiicoeficienti'], (isset($json['sursainformatiicoeficienti']) ? $json['sursainformatiicoeficienti'] : ''), 'Alege...', false, array() ); ?>
       	<?php	input_rolem( 'regiminaltime', 'Regim inaltime', (isset($json['regiminaltime']) ? $json['regiminaltime'] : ''), '', false ); ?>
       	
       	</div> 
        
        
             <div class="two fields">
             <div class="field">
             <label class="control-label">Alte detalii zona (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="altedetaliizona[]" multiple class="chosen-select">
             <?php

             foreach ($valuesTr['altedetaliizona'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['altedetaliizona'])?(in_array($k,$json['altedetaliizona'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>
				      <div class="field">
             <label class="control-label">Alte caracteristici (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="altecaracteristici[]" multiple class="chosen-select">
             <?php

             foreach ($valuesTr['altecaracteristici'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['altecaracteristici'])?(in_array($k,$json['altecaracteristici'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
               </div>

          </div>
          	<div class="four fields">
            	<?php	select_rolem( 'constructiepeteren', 'Constructie pe teren', $danu, (isset($json['constructiepeteren']) ? $json['constructiepeteren'] : ''), 'Alege...', false, array() ); ?>
            	<?php	select_rolem( 'clasificareteren', 'Clasificare teren', $valuesTr['clasificareteren'], (isset($json['clasificareteren']) ? $json['clasificareteren'] : ''), 'Alege...', false, array() ); ?>
            	<?php	select_rolem( 'destinatie', 'Destinatie', $valuesTr['destinatie'], (isset($json['destinatie']) ? $json['destinatie'] : ''), 'Alege...', false, array() ); ?>
            	 <?php	input_rolem( 'linkextern', 'Link extern', (isset($json['linkextern']) ? $json['linkextern'] : ''), '', false ); ?>
            	 	
            	 </div>
        
             <div class="two fields">
             <div class="field">
             <label class="control-label">Utilitati (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="utilitati[]" multiple class="chosen-select">
             <?php

             foreach ($valuesTr['utilitati'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['utilitati'])?(in_array($k,$json['utilitati'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
              </div>
                <?php	select_rolem( 'tara', 'Tara', $valuesTr['tara'], '', 'Alege...', false, array() ); ?>
               
				
          </div>
        
   
	  	<?php
	  }
      ?> 
       
      <?php
      
      if ($type==4)
      {
      ?>
      <div class="four fields">
      <?php	select_rolem( 'tipimobil', 'Tip imobil', $valuesSp['tipimobil'], (isset($json['tipimobil']) ? $json['tipimobil'] : $vanzare['tipimobil']), 'Alege...', false, array() ); ?>
      <?php	input_rolem( 'anconstructie', 'An constructie', (isset($json['anconstructie']) ? $json['anconstructie'] : $vanzare['anconstructie']), '', false ); ?>
      <?php	select_rolem( 'stadiuconstructie', 'Stadiu constructie', $valuesSp['stadiuconstructie'], (isset($json['stadiuconstructie']) ? $json['stadiuconstructie'] : $vanzare['stadiuconstructie']), 'Alege...', false, array() ); ?>
       <?php	select_rolem( 'structurarezistenta', 'Structura rezistenta', $valuesSp['structurarezistenta'], (isset($json['structurarezistenta']) ? $json['structurarezistenta'] : $vanzare['structurarezistenta']), 'Alege...', false, array() ); ?>
      </div>
      <div class="four fields">
      <?php	input_rolem( 'suprafataconstruita', 'Suprafata construita', (isset($json['suprafataconstruita']) ? $json['suprafataconstruita'] : $vanzare['suprafataconstruita']), '', false ); ?>
      <?php	input_rolem( 'suprafatautila', 'Suprafata utila', (isset($json['suprafatautila']) ? $json['suprafatautila'] : $vanzare['suprafatautila']), '', false ); ?>
      <?php	input_rolem( 'suprafatateren', 'Suprafata teren', (isset($json['suprafatateren']) ? $json['suprafatateren'] : $vanzare['suprafatateren']), '', false ); ?>
      <?php	input_rolem( 'pretinchiriere', 'Pret inchiriere', (isset($json['pretinchiriere']) ? $json['pretinchiriere'] : $vanzare['pretinchiriere']), '', false ); ?>
      </div>
      <div class="four fields">
        <?php	input_rolem( 'nrnivele', 'Nr nivele', (isset($json['nrnivele']) ? $json['nrnivele'] : $vanzare['nrnivele']), '', false ); ?>
        <?php	input_rolem( 'nrincaperi', 'Nr incaperi', (isset($json['nrincaperi']) ? $json['nrincaperi'] : $vanzare['nrincaperi']), '', false ); ?>
         <?php	input_rolem( 'nrgrupurisanitare', 'Nr grupuri sanitare', (isset($json['nrgrupurisanitare']) ? $json['nrgrupurisanitare'] : $vanzare['nrgrupurisanitare']), '', false ); ?>
         <?php	input_rolem( 'nrparcari', 'Nr parcari', (isset($json['nrparcari']) ? $json['nrparcari'] : $vanzare['nrparcari']), '', false ); ?>
       
       </div>
        
      <div class="two fields">
       <div class="field">
             <label class="control-label">Utilitati(selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="utilitati[]" multiple class="chosen-select">
             <?php
			$tmpda=explode(',',$vanzare[ 'utilitati' ]);
             foreach ($valuesSp['utilitati'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['utilitati'])?(in_array($k,$json['utilitati'])?"selected":""):(in_array($k,$tmpda)?"selected":"")).">".$v."</option>";
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
                echo "<option value='".$k."' ".(isset($json['dotari'])?(in_array($k,$json['dotari'])?"selected":""):(in_array($k,$tmpda)?"selected":"")).">".$v."</option>";
              }
             ?>
              </select>
               </div>

      </div>
      <div class="two fields">
                   <div class="field">
             <label class="control-label">Servicii (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="servicii[]" multiple class="chosen-select">
             <?php
			$tmpda=explode(',',$vanzare[ 'servicii' ]);
             foreach ($valuesSp['servicii'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['servicii'])?(in_array($k,$json['servicii'])?"selected":""):(in_array($k,$tmpda)?"selected":"")).">".$v."</option>";
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
                echo "<option value='".$k."' ".(isset($json['altecaracteristici'])?(in_array($k,$json['altecaracteristici'])?"selected":""):(in_array($k,$tmpda)?"selected":"")).">".$v."</option>";
              }
             ?>
              </select>
               </div>


      </div>
      	<div class="four fields">
	  	 <?php	select_rolem( 'clasabirouri', 'Clasa birouri', $valuesSp['clasabirouri'], (isset($json['clasabirouri']) ? $json['clasabirouri'] : ''), 'Alege...', false, array() ); ?>
         
         
         <?php	select_rolem( 'tipspatiu', 'Tip spatiu', $valuesSp['tipspatiu'], (isset($json['tipspatiu']) ? $json['tipspatiu'] : ''), 'Alege...', false, array() ); ?>
         <?php	select_rolem( 'demisol', 'Demisol', $danu, (isset($json['demisol']) ? $json['demisol'] : ''), 'Alege...', false, array() ); ?>
	  	 
         <?php	input_rolem( 'numeimobil', 'Nume imobil', (isset($json['numeimobil']) ? $json['numeimobil'] : ''), '', false ); ?>
        </div>
        
        <div class="four fields">
        <?php	select_rolem( 'mansarda', 'Mansarda', $danu, (isset($json['mansarda']) ? $json['mansarda'] : ''), 'Alege...', false, array() ); ?>
	  	 <?php	input_rolem( 'inaltimespatiu', 'Inaltime spatiu', (isset($json['inaltimespatiu']) ? $json['inaltimespatiu'] : ''), '', false ); ?>
         <?php	input_rolem( 'latimevitrina', 'Latime vitrina', (isset($json['latimevitrina']) ? $json['latimevitrina'] : ''), '', false ); ?>
         <?php	input_rolem( 'nrgaraje', 'Nr garaje', (isset($json['nrgaraje']) ? $json['nrgaraje'] : ''), '', false ); ?>
       </div>
       
        	<div class="four fields">
	  	 <?php	select_rolem( 'monedainchiriere', 'Moneda inchiriere', $valuesSp['monedainchiriere'], (isset($json['monedainchiriere']) ? $json['monedainchiriere'] : ''), 'Alege...', false, array() ); ?>
	  	 <?php	select_rolem( 'monedainchiriereunitar', 'Moneda inchiriere unitar', $valuesSp['monedainchiriereunitar'], (isset($json['monedainchiriereunitar']) ? $json['monedainchiriereunitar'] : ''), 'Alege...', false, array() ); ?>
	  	 <?php	select_rolem( 'monedavanzare', 'Moneda vanzare', $valuesSp['monedavanzare'], (isset($json['monedavanzare']) ? $json['monedavanzare'] : ''), 'Alege...', false, array() ); ?>
	  	 <?php	select_rolem( 'monedavanzaremp', 'Moneda vanzare mp', $valuesSp['monedavanzaremp'], (isset($json['monedavanzaremp']) ? $json['monedavanzaremp'] : ''), 'Alege...', false, array() ); ?>
        </div>
      
        
        <div class="four fields">
         <?php	input_rolem( 'nrnivelesubterane', 'Nr nivele subterane', (isset($json['nrnivelesubterane']) ? $json['nrnivelesubterane'] : ''), '', false ); ?>
         <?php	input_rolem( 'nrterase', 'Nr terase', (isset($json['nrterase']) ? $json['nrterase'] : ''), '', false ); ?>
         
         <?php	input_rolem( 'pretinchiriereunitar', 'Pret inchiriere unitar', (isset($json['pretinchiriereunitar']) ? $json['pretinchiriereunitar'] : ''), '', false ); ?>
         <?php	select_rolem( 'etaj', 'Etaj', $valuesSp['etaj'], (isset($json['etaj']) ? $json['etaj'] : ''), 'Alege...', false, array() ); ?>
       </div>

        <div class="four fields">
        <?php	select_rolem( 'pretnegociabil', 'Pret negociabil', $danu, (isset($json['pretnegociabil']) ? $json['pretnegociabil'] : ''), 'Alege...', false, array() ); ?>
         <?php	input_rolem( 'pretvanzare', 'Pret vanzare', (isset($json['pretvanzare']) ? $json['pretvanzare'] : $vanzare['pret_vanzare']), '', false ); ?>
         <?php	input_rolem( 'pretvanzaremp', 'Pret vanzaremp', (isset($json['pretvanzaremp']) ? $json['pretvanzaremp'] : ''), '', false ); ?>
         
          <?php	input_rolem( 'suprafatacurte', 'Suprafata curte', (isset($json['suprafatacurte']) ? $json['suprafatacurte'] : ''), '', false ); ?>
         </div>
       
        <div class="four fields">
        
          <?php	input_rolem( 'suprafataterase', 'Suprafata terase', (isset($json['suprafataterase']) ? $json['suprafataterase'] : ''), '', false ); ?>	
        <?php	select_rolem( 'pretfaratva', 'Pret fara tva', $danu, (isset($json['pretfaratva']) ? $json['pretfaratva'] : ''), 'Alege...', false, array() ); ?>
        <?php	select_rolem( 'vitrina', 'Vitrina', $danu, (isset($json['vitrina']) ? $json['vitrina'] : ''), 'Alege...', false, array() ); ?>
         
         <?php	input_rolem( 'video', 'Video', (isset($json['video']) ? $json['video'] : ''), '', false ); ?>
         </div>
       
       
        <div class="four fields">
        <?php	select_rolem( 'comisionzero', 'Comision zero', $danu, (isset($json['comisionzero']) ? $json['comisionzero'] : ''), 'Alege...', false, array() ); ?>
        <?php	select_rolem( 'portal', 'Portal', $danu, (isset($json['portal']) ? $json['portal'] : ''), 'Alege...', false, array() ); ?>
        <?php	input_rolem( 'comisionvanzator', 'Comision vanzator', (isset($json['comisionvanzator']) ? $json['comisionvanzator'] : ''), '', false ); ?>
        <?php	select_rolem( 'tara', 'Tara', $valuesSp['tara'], (isset($json['tara']) ? $json['tara'] : ''), 'Alege...', false, array() ); ?>
         </div>
       
       <div class="two fields">

              <div class="field">
             <label class="control-label">Alte detalii zona (selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="altedetaliizona[]" multiple class="chosen-select">
             <?php

             foreach ($valuesSp['altedetaliizona'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['altedetaliizona'])?(in_array($k,$json['altedetaliizona'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
            </div>
            
              <div class="field">
             <label class="control-label">Finisaje(selectati tot ce se aplica)</label>
             <select data-placeholder="Alege ..." name="finisaje[]" multiple class="chosen-select">
             <?php

             foreach ($valuesSp['finisaje'] as $k=>$v)
             {
                echo "<option value='".$k."' ".(isset($json['finisaje'])?(in_array($k,$json['finisaje'])?"selected":""):"").">".$v."</option>";
              }
             ?>
              </select>
            </div>
            </div>
   
   
       <div class="two fields">
             
            </div>
      <?php
      }
      ?>     
              <?php
            // prea($vanzare);
             ?>
                    <hr>
             </form></div>
            </div>

<script>
    $(function () {
        $('.step').click(function () {
            $('#add_publicare .step').removeClass('active');
            $(this).addClass('active');
            $('.div_step').hide();
            $('#'+$(this).attr('step')).removeClass('hide').show();
        });
    });
    function publica() {
        if(!$.isNumeric($('#devanzare').val())){
            alert('Campul de vanzare trebuie selectat! ');
            return 0;
        }
        if(!$.isNumeric($('#deinchiriat').val())){
            alert('Campul de deinchiriat trebuie selectat! ');
            return 0;
        }
        
        if(!$.isNumeric($('#nrcamere').val()) && $('#type').val()<=1){
            alert('Campul numar camere trebuie selectat! ');
            return 0;
        }
        
        if($('#suprafatateren').val()=='' && $('#type').val()==3){
            alert('Campul suprafata teren trebuie completat ');
            return 0;
        }
        
        if($('#suprafatateren').val()=='' && $('#type').val()==3){
            alert('Campul suprafata teren trebuie completat ');
            return 0;
        }
        
        if($('#coeficientutilizareteren').val()=='' && $('#type').val()==3){
            alert('Trebuie completat coeficientul utilizare teren! ');
            return 0;
        }
        
        if($('#suprafatautila').val()=='' && $('#type').val()==4){
            alert('Campul suprafata utila trebuie completat! ');
            return 0;
        }
        
        if($('#pretvanzare').val()=='' && $('#type').val()==4){
            alert('Campul pret trebuie completat ');
            return 0;
        }
        if(($('#deinchiriat').val() == 465)){
            alert('Campul de Destinatie trebuie selectat! ');
            return 0;
        }
        msg_bst_thf_loading();
        $('.raspuns_publicare').html('');
        var form = $('#publica_form').serialize();
        $.post("/imobiliare.ro/api-publicare-anunturi/varianta-extensie-php5-soap/publica.php?publica=1&type=<?=$type;?>",form,function (r) {
            $('.div_msg').removeClass('hide');
            $('.raspuns_publicare').html(r);
            msg_bst_thf_loading_remove();
            $.post("",{"check_imobiliare_id":""},function (rr) {
                $('.raspuns_links').html(rr);
            });



        });

    }
function select_inits() {
    $('[name=judet]').change(function () {
        msg_bst_thf_loading();
        let select_modif=$(this);
        $(select_modif).closest('#judete_loc_zone').find('.div_localitate').html('');

        $.post('',{"judet_imobiliare":$(this).val(),"show_loc":1},function (data) {
            $(select_modif).closest('#judete_loc_zone').find('.div_localitate').html(data).trigger("chosen:updated");
            $(select_modif).closest('#judete_loc_zone').find('.div_zona').hide();
            select_inits();
            jQuery('body').dropdownChosen();
            msg_bst_thf_loading_remove();
        });
    });

    $('[name=localitate]').change(function () {
        msg_bst_thf_loading();
        let select_modif=$(this);
        $(select_modif).closest('#judete_loc_zone').find('.div_zona').html('');

        $.post('',{"localitate_imobiliare":$(this).val(),"show_loc":1},function (data) {
            $(select_modif).closest('#judete_loc_zone').find('.div_zona').html(data);
            $(select_modif).closest('#judete_loc_zone').find('.div_zona').show();
            select_inits();
            jQuery('body').dropdownChosen();
            msg_bst_thf_loading_remove();
        });
    });

}
    $(function () {
        <?php if(isset($_GET['publica'])){?>
        publica();
        <?php } ?>
        select_inits()
    });
</script>

