<?php


//de mutat in itrepair/thor_f si redenumit
function insert_update2($tablename,$a,$keys_to_exclude=array('id'),$setify_only_keys=array(),$return_query=false){
    $a=form_data_prepare($tablename,$a,$keys_to_exclude,$setify_only_keys);
    if(is_array($a) && count($a)>0 && is_string($tablename) && strlen($tablename)>0){

        foreach(table_indexes($tablename) as $index){// exclude keys from update command
            if($index['Non_unique']<1 && !in_array($index['Column_name'],$keys_to_exclude)){
                $keys_to_exclude[]=$index['Column_name'];
            }

        }
        $u=form_data_prepare($tablename,$a,$keys_to_exclude,$setify_only_keys);
        //prea($a); prea($u);f
        if(!is_array($u) || count($u)<1){return false;}

        $q="INSERT INTO `$tablename` ".setify_query($a)."
		ON DUPLICATE KEY UPDATE ".substr(setify_query($u),4);
        if($return_query){return $q;}

        if(!mysql_query($q)){global $debug_thorr;
            if($debug_thorr==1){debug_print_backtrace();die('update query eror: '.$q.' | '.mysql_error());}else{e500();} }	else{return @mysql_affected_rows();}
        //return insert_query($q);
    }
    else{	return false;	}
}

function companie_edit($companie=array(),$label,$form_name){
    global $tip_forma_juridica, $judete,$localitati,$tip_act_identitate;
    $cfg_select_normal_bool_srl=' data-toggle="toggle" data-on="PFA" value-on="1" data-off="SRL" value-off="0" data-onstyle="success" data-offstyle="success" data-width="80"  data-size="mini"  ';

    if(!is_array($companie) and is_numeric($companie)){
        $idc = $companie;
        $companie = many_query("SELECT * FROM `companie` WHERE `id_companie`='".floor($companie)."'  LIMIT 1 ");
    } else { $idc = $companie['id_companie']; }
    // prea($companie);?>
    <form enctype="multipart/form-data" method="post" id="forma_companie" class="ui form vanzare_edit_insert ascuns <?=$form_name?>" role="form" bootstrapToggle="true">

        <input type="hidden" name="id_companie_user" value="<?php echo $idc;?>">
        <input type="hidden" name="id_companie" value="<?php echo $idc;?>">
        <input type="hidden" name="tip_companie" value="u" />


        <input type="hidden" name="edit_companie" value="<?php echo $idc;?>">
        <div class="row">
            <div class="col-sm-9">
                <div class="main ui intro container">
                    <h2 class="ui dividing header">
                        <?=strlen($label) ? $label : 'Date companie';?>
                        <a class="anchor" id="preface"></a></h2>
                </div>
            </div>

            <div class="col-sm-3">
                <div id="div_cui" class="field cui" cui="">
                    <label id="label_cui" for="cui"> CUI*</label><input type="text" class="form-control" name="cui" id="cui" placeholder="" value="<?=$companie['cui']?>">
                </div>

            </div>
        </div>
        <div class="four fields localitati_judete">
            <?php   input_rolem('denumire', 'Denumire*' ,$companie['denumire'],'',false);
            input_rolem('adresa','Adresa*',$companie['adresa'],'',false);
            select_rolem( 'judet_id', 'Judetul** ',array(""=>"Neselectat") + $judete, $companie[ 'judet_id' ], '', false, array() );
            select_rolem( 'localitate_id', 'Oras** ', array(""=>"Neselectat") + $localitati, $companie[ 'localitate_id' ], 'Alege...', false, array() ); ?>
        </div>
        <div class="three fields">
            <?php

            input_rolem('reg_com', 'Registrul Comertului*', $companie['reg_com'], 'Registrul Comertului', false);
            input_rolem('cont_iban', 'Cont IBAN*', $companie['cont_iban'], '', false);
            input_rolem('banca', 'Banca*', $companie['banca'], '', false);
            ?>
        </div>
        <div class="three fields">
            <?php  input_rolem('tel','Telefon',$companie['tel'],'',false);
            input_rolem('email','Email',$companie['email'],'',false);
            input_rolem('website','Website',$companie['website'],'',false);
            echo '<input type="hidden" value="'.$_GET['edit'].'" name="save_companie" />'
            ?>

        </div>

        <div class="four fields">




            <div class="field hide">
                <div class="ui action input">
                    <input type="text" class="upload_file_input" placeholder="Upload logo JPG" readonly>
                    <input type="file" name="file_logo" style="display: none" accept="image/jpeg">
                    <div class="ui icon button upload_file_input2">
                        <i class="attach icon"></i>
                        <img src="<?=MEDIA?>jpg.png" width="16" height="16"/>
                    </div>
                </div>
            </div>
            <div style="position:fixed; bottom:5px; right:5px; padding: 3px; z-index:1000;" class="ui brown message">

                <button type="button" id="button_save" onmousedown="save_insert_companie()" class="ui basic green button ">Salveaza</button>
                <a href="index.php"><i id="loading_save" class="spinner loading icon hide"></i><input type="button" class="ui teal button" id="go_to_documente"  value="Inchide"/></a>
            </div>
            <div class="field hide"><img class="logo_img" src="/dms/useri_companii/<?= $_GET['edit']?>.jpg" width="100" id="logo_companie_user"/> </div>

        </div>





    </form>


<?php }

function companie_edit_insert($companie=array(),$from_doc,$type,$name){
    global $tip_forma_juridica, $judete,$localitati,$tip_act_identitate;
    $cfg_select_normal_bool_srl=' data-toggle="toggle" data-on="PFA" value-on="1" data-off="SRL" value-off="0" data-onstyle="success" data-offstyle="success" data-width="80"  data-size="mini"  ';

    if(!is_array($companie) and is_numeric($companie)){
        $idc = $companie;
        $companie = many_query("SELECT * FROM `companie` WHERE `id_companie`='".floor($companie)."'  LIMIT 1 ");
    } else { $idc = $companie['id_companie']; }
     // prea($companie);?>
    <form enctype="multipart/form-data" method="post" id="forma_<?=$type;?>" class="ui form vanzare_edit_insert ascuns" role="form" bootstrapToggle="true">
    <?php
    if($type == 'adauga_vanzare'){?>
        <input type="hidden" name="tip_companie" value="c" />
        <input type="hidden" name="reprezentant_vanzare" value="<?php echo $idc;?>">
        <?php }
    if($type == 'reprezentant_vanzare'){  ?>
        <input type="hidden" name="companie_vanzare" value="<?php echo $idc;?>">
        <input type="hidden" name="tip_companie" value="r" />
    <?php }
    if($type == 'adauga_companie_user'){  ?>
    <input type="hidden" name="id_companie_user" value="<?php echo $idc;?>">
    <input type="hidden" name="tip_companie" value="u" />
    <?php } ?>
        <?php
    /*
    if($type != 'adauga_vanzare'){?>
        <input type="hidden" name="companie_vanzare" value="<?php echo $idc;?>">
        <input type="hidden" name="tip_companie" value="r" />
            <?php } else {?>
        <input type="hidden" name="tip_companie" value="c" />
        <input type="hidden" name="reprezentant_vanzare" value="<?php echo $idc;?>">
    <?php } ?>
*/
    ?>
        <input type="hidden" name="from_document" value="<?php echo $from_doc;?>">
        <input type="hidden" name="edit_companie" value="<?php echo $idc;?>">
        <div class="row">
        <div class="col-sm-<?=$type=='adauga_vanzare' ? '9':'9'?>">
        <div class="main ui intro container">
            <h2 class="ui dividing header">
                <?=$name;?>
                <a class="anchor" id="preface"></a></h2>
        </div>
        </div>
            <?php if($type != 'adauga_vanzare'){
                echo '<input type="hidden" name="tip_f" value="c" />';?>
                <!--
         <div class="col-sm-<?=$type=='adauga_vanzare' ? '6':'6'?>">
             <div class="is_client field"><?php select_rolem('tip_beneficiar','Tip vanzator',$tip_forma_juridica,$companie['tip_beneficiar'],'',false,array()); ?></div>
         </div>
         -->
        <?php } else { echo '<input type="hidden" name="tip_f" value="f" />';}?>
         <div class="col-sm-3">
             <div id="div_cui" class="field cui" cui="">
                 <label id="label_cui" for="cui"><?=$type != 'reprezentant_vanzare' ? 'CUI*' : 'CNP*'?></label><input type="text" class="form-control" name="cui" id="cui" placeholder="" value="<?=$companie['cui']?>">
             </div>
             <!--
             <div id="div_cnp" class="field <?=$companie['tip_f'] == 'f' ? 'hidexxx' : ''?> cnp" cnp="">
                 <label id="label_cnp" for="cui">CNP</label><input type="text" class="form-control" name="cnp" id="cnp" placeholder="CNP" value="<?=$companie['cnp']?>">
             </div>

         -->
         </div>
        </div>
        <div class="four fields localitati_judete">
<?php   input_rolem('denumire',($type!='reprezentant_vanzare' ?  'Denumire*' : 'Nume prenume*' ),$companie['denumire'],'',false);
            input_rolem('adresa','Adresa*',$companie['adresa'],'',false);
            select_rolem( 'judet_id', 'Judetul** ',array(""=>"Neselectat") + $judete, $companie[ 'judet_id' ], '', false, array() );
            select_rolem( 'localitate_id', 'Oras** ', array(""=>"Neselectat") + $localitati, $companie[ 'localitate_id' ], 'Alege...', false, array() ); ?>
        </div>
        <div class="three fields">
<?php
if($type!='reprezentant_vanzare') {
    input_rolem('reg_com', 'Registrul Comertului*', $companie['reg_com'], 'Registrul Comertului', false);
    input_rolem('cont_iban', 'Cont IBAN*', $companie['cont_iban'], '', false);
    input_rolem('banca', 'Banca*', $companie['banca'], '', false);
}?>
    </div>
        <div class="three fields">
           <?php  input_rolem('tel','Telefon',$companie['tel'],'',false);
            input_rolem('email','Email',$companie['email'],'',false);
            input_rolem('website','Website',$companie['website'],'',false);
            ?>

        </div>

        <div class="four fields <?=$companie['tip_f'] != 'f' ? '' : 'hide'?>">
            <?php
            if($type=='reprezentant_vanzare') {
                select_rolem('tip_act_identitate', 'Tip act de identitate ', $tip_act_identitate, ($companie['tip_act_identitate'] ? $companie['tip_act_identitate'] : 0), 'Alege...', false, array());
                input_rolem('serie_ci', 'Serie*', $companie['serie_ci'], '', false);
                input_rolem('numar_ci', 'Numar*', $companie['numar_ci'], '', false);
            }
    if($type == 'adauga_companie_user'){  ?>


            <div class="field">
                <div class="ui action input">
                    <input type="text" class="upload_file_input" placeholder="Upload logo JPG" readonly>
                    <input type="file" name="file_logo" style="display: none" accept="image/jpeg">
                    <div class="ui icon button upload_file_input2">
                        <i class="attach icon"></i>
                        <img src="<?=MEDIA?>jpg.png" width="16" height="16"/>
                    </div>
                </div>
            </div>
        <div style="position:fixed; bottom:5px; right:5px; padding: 3px; z-index:1000;" class="ui brown message">

            <button type="submit"  class="ui green button">Salveaza</button>
            <a href="index.php"><i id="loading_save" class="spinner loading icon hide"></i><input type="button" class="ui teal button" id="go_to_documente"  value="Inchide"/></a>
        </div>
        <div class="field"><img class="logo_img" src="/dms/useri_companii/<?= $_GET['edit']?>.jpg" width="100" id="logo_companie_user"/> </div>
        <?php } ?>
        </div>





</form>


<?php }

function get_document_data($id_doc){ global $documente;

    $tmp = multiple_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc and cheie = 'expeditor' ");

    $results = array();
    foreach ($tmp as $k=>$v){ $json = json_decode($v['json'],true); $results[$v['valoare']] = $json;}
    $data['expeditor']=$results;

    $results = array();
    $tmp = multiple_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc and cheie = 'destinatar' ");
    foreach ($tmp as $k=>$v){ $json = json_decode($v['json'],true); $results[$v['valoare']] = $json;}
    $data['destinatar']=$results;

    $results = array();
    $tmp = multiple_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc and cheie = 'companie_destinatar' ");
    foreach ($tmp as $k=>$v){ $json = json_decode($v['json'],true); $results[$v['valoare']] = $json;}
    $data['companie_destinatar']=$results;

    $results = array();
    $tmp = multiple_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc and cheie = 'template_doc_iesire' ");
    foreach ($tmp as $k=>$v){ $results[$v['valoare']] = $v;}
    $data['documente_iesire']=$results;



    $results = array();
    $tmp = multiple_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc and cheie = 'companie_expeditor' ");
    foreach ($tmp as $k=>$v){ $json = json_decode($v['json'],true); $results[$v['valoare']] = $json;}
    $data['companie_expeditor']=$results;

    $tmp = many_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc and cheie = 'continut_document_ocr' ");
    $data['continut_document_ocr']=$tmp['json'];

    $tmp = many_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc and cheie = 'continut_document' ");
    $data['continut_document']=$tmp['json'];

    $results = array();
    $data['intrare'] = many_query("SELECT * FROM `documente_istoric` WHERE id_doc = $id_doc and tip = 'intrare' ORDER by idi DESC ");
    $data['iesire'] = many_query("SELECT * FROM `documente_istoric` WHERE id_doc = $id_doc and tip = 'iesire' ORDER by idi DESC ");
    $data['doc'] = $documente[$id_doc];
    return $data;
}


function get_file_icon_type($ext){
     $img_extensions=array('jpg','jpeg','png','gif','ico','tiff');
    $fa4=array(
        'fa fa-file-image-o'=>$img_extensions,
        'fa fa-file-word-o'=>array('doc','docx','odt','rtf'),
        'fa fa-file-archive-o'=>array('zip','rar','gz','tgz','7z','zipx'),
        'fa fa-file-pdf-o'=>array('pdf'),
        'fa fa-file-powerpoint-o'=>array('ppt','pptx'),
        'fa fa-file-text-o'=>array('txt','msg'),
        'fa fa-file-excel-o'=>array('xls','xlsx','xlsb','csv','xlr'),
        'fa fa-file-audio-o'=>array('aif','iff','m3u','m4a','mid','mp3','mpa','wav','wma',),
        'fa-file-video-o'=>array('3g2','3gp','asf','avi','flv','m4v','mov','mp4','mpg','rm','srt','swf','vob','wmv','mkv',),
    );
    foreach($fa4 as $file_fax=>$exts){
        if(in_array($ext,$exts)){$file_fa=$file_fax; break;}
    }
    return '<i class="'.$file_fa.'" style="font-size:1em;"></i> ';
}


function show_locuitor_icon_functie($idl)
{
    global $locuitori_all;
    if($idl > 0 ) {
        echo $locuitori_all[$idl]['fullname'] . '<p style="font-size: 0.8em; color: grey"> - '.$locuitori_all[$idl]['functie'].' - </p>';
        echo show_locuitor_icon($idl);
    } else {
    echo 'Nealocat';}

}
function show_locuitor_icon($idl){ global $locuitori_all;
    $tmp =$locuitori_all[$idl];
    if($tmp['id_organigrama'] > 0 ){
        $icon = '<i class="circular purple laravel  icon"></i>';
    } else {
        $icon = '<i class="circular green user  icon"></i>';
    }

    return $icon;
}

?>