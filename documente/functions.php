<?php
function list_doc_templates($id_doc){
    $docs = multiple_query("SELECT * FROM `documente_propietati` 
        LEFT JOIN template_contracte ON id = valoare
        WHERE id_doc = '". $id_doc ."' and cheie = 'template_doc_iesire' ") ;
    foreach ($docs as $k=>$data){
        $id_template = $data['valoare'];
        $cheie_dec = $id_doc.'_'.$id_template;
        ?>
        <form  method="post" enctype="application/x-www-form-urlencoded" class="ui form form_documente_iesire_<?=$cheie_dec?> forma_row_iesire" role="form" bootstraptoggle="true">
            <div class="ui form">
                <div class="ui segment">
                    <h2 class="ui right floated header"><?=$data['nume_contract']?>
                        <input type="hidden" name="id_template" value="<?=$id_template?>">
                        <input type="hidden" name="id_doc" value="<?=$id_doc?>">
                    <div class="ui right floated text-right">
                        <a title="Vizualizeaza" class="view_btn" onmousedown="view_contract(this);"><i class="circular small olive eye outline icon"></i></a>
                        <a title="Editeaza" class="edit_btn" onmousedown="edit_contract(this);"><i class="circular olive small edit outline icon"></i></a>
                        <a class="print_btn" id="pint_save"  onmousedown="pdf_contract(this);"><i class="circular small olive file pdf outline icon"></i></a>
                        <a class="dell_btn" id="pint_save" onmousedown="add_template(<?=$id_doc?>,'delete','<?=$id_template?>');"><i class="circular small red trash outline icon"></i></a>
                    </div>
               </h2>
                    <div class="ui clearing divider"></div>


                    <div id="view_template_<?=$cheie_dec?>" class="hide list_lows">
                        <?=$data['json']?>
                    </div>

                    <div id="text_documente_iesire_<?=$cheie_dec?>" class="hide list_lows">
                        <textarea class="tinymce" name="text_documente_template" rows="30"> <?=$data['json']?></textarea>
                    </div>
                    <div id="pdf_documente_iesire_<?=$cheie_dec?>" class="hide list_lows">
                        <iframe style="width: 100%; height: 1300px;" class="iframe_pdf" scrolling="yes" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </form>
    <?php }
}

function expeditor_destinatar_edit_insert( $cumparator = array(), $from_doc, $type, $name ) {
    global $judete, $localitati,$from_afaceri;

    $idc = $cumparator[ 'idl' ];

    // prea($companie);?>
    <div>
    <form action="" method="post" enctype="application/x-www-form-urlencoded" formtype="<?=$type?>" formname="<?=$name?>" class="ui form cumparator_edit_insert <?=$type?>" role="form" bootstrapToggle="true">


        <div class="row">
            <div class="col-sm-12">
                <div class="main ui intro container">

                    <h2 class="ui dividing header">
                        <?=$name . '#'.$idc?>
                        <a class="anchor" id="preface"></a>
                    </h2>
                </div>
            </div>

        </div>
        <div class="two fields">
            <input type='hidden' name='idl' id='idl' value='<?php echo $idc ; ?>'>
            <?php   input_rolem('fullname','Numele prenume:',$cumparator['fullname'],'',false);
            input_rolem('cnp','CNP',$cumparator['cnp'],'',false);
            ?>
        </div>
        <div class="row " id="">
            <ul class="list-group list ul_list_search_div" style="z-index: 1200"></ul>
        </div>
        <div class="three fields localitati_judete">
            <?php input_rolem('adresa','Adresa',$cumparator['adresa'],'str, nr',false);
            select_rolem( 'judet_id', 'Judetul ', $judete, $cumparator[ 'judet_id' ], '', false, array() );
            ?>

            <?php
            select_rolem( 'localitate_id', 'Oras ', $localitati, $cumparator[ 'localitate_id' ], 'Alege...', false, array() ); ?>
        </div>
        <div class="two fields">
            <?php  input_rolem('telefon','Telefon',$cumparator['telefon'],'',false);
            input_rolem('email','Email',$cumparator['email'],'',false);

            ?>

        </div>





    </form>
    </div>
    <?php
}


function list_documente( $data ) {
    global $vanzari;
    ?>
    <table class="table table-striped fixed single line table-hover table-responsive ui olive table " xmlns="http://www.w3.org/1999/html">
        <thead>
        <tr>

            <th width="4%">Nr</th>
            <th>Din data</th>
            <th>Expeditor</th>
            <th>Destinatar</th>
            <th width="25%">Atasamente</th>
            <th width="30%">Documente iesire</th>
            <th>View</th>
            <th width="10%"></th>
        </tr>
        </thead>
        <tbody>

        <?php
        $i = 0;
        foreach ( $data as $id_doc => $doc ) {
            $i++;
            ?>
            <tr class=" list_row"  id="tr_data_<?=$id_doc?>" id_prd="<?=$id_doc;?>">
                <?php list_one_row($doc);?>
            </tr>

        <?php } ?>
        </tbody>
    </table>
    <script>
    </script>

    <?php
}



function list_one_row( $data ) {
    global $localitati, $judete,$statusuri,$user_id_login,$is_admin,$culoare_status;
    $doc = get_document_data($data['idd']);
  //  prea($doc);
    $atasamente = json_decode($doc['doc']['atasamente'],true);

    ?>
    <td>
        <?=$data['nr_doc']?><br>
        <span style="color: darkgrey"><?=$data['idd']?></span>
    </td>
    <td>
        <?=ro_date($data['data_doc']);?>
        <p style="color: <?=$culoare_status[$data[ 'status' ]]?>"><?=$statusuri[$data[ 'status' ]]?></p>
    </td>
    <td>
        <?php foreach ($doc['expeditor'] as $idl=>$expt){ ?>
            <?=$expt['fullname'] . show_locuitor_icon($idl);?>
        <p><a href="tel:<?=$expt['telefon']?>"><?=$expt['telefon']?></a><br><a href="mailto:<?=$expt['email']?>"><?=$expt['email']?></a></p>
        <?php } ?>
    </td>
    <td>
        <?php foreach ($doc['destinatar'] as $idl=>$expt){ ?>
            <?=$expt['fullname'] . show_locuitor_icon($idl);?>
          <a href="tel:<?=$expt['telefon']?>"><?=$expt['telefon']?></a><br><a href="mailto:<?=$expt['email']?>"><?=$expt['email']?></a><br>
        <?php } ?>
    </td>
<td>
    <?php

    if (count($atasamente)){
        foreach ($atasamente as $k=>$file){
        $ext=pathinfo($file);
        $myArray = (explode('/',$file));
        $lastElement = end($myArray);
        $ext=explode('?',@$ext['extension']); $ext=strtolower($ext[0]); ?>
    <div class="one_row_div">
   <i class="fa fa-eye  pointer" path="<?=$file?>" onclick="open_frame_side(this);"  style="color: #4183c4;"></i>
            <?=get_file_icon_type($ext) . $lastElement?></div><br>
        <?php }
    }
        ?>
</td>
    <td>
        <?php
        $id_doc = $data['idd'];
    $docs = multiple_query("SELECT * FROM `documente_propietati` 
        LEFT JOIN template_contracte ON id = valoare
        WHERE id_doc = '". $id_doc ."' and cheie = 'template_doc_iesire' ") ;
    foreach ($docs as $kkk=>$doc_iesire) { ?>
        <div class="one_row_div">
        <i class="fa fa-eye eye pointer" path="<?='/pdf.php?id_doc='.$id_doc.'&id_template='.$doc_iesire['valoare'].'&template_contracte'?>"
           onclick="open_frame_side(this);" style="color: #4183c4;"></i>
        <?=$doc_iesire['nume_contract']?>
        </div><br>
    <?php }?></td>
<td>  <p <?php echo (has_right($doc[ 'idd'],'cumparator')?"onmousedown=\"go_to_documente(".$data['idd'].",this);\" style='cursor:pointer;'":"")  ?>><i class="fa fa-edit  pointer"></i></p>
</td>
    <td class='for_delete'>
           <?php   if ( has_right($doc[ 'idd'],'documente')) { ?>

            <a href='#' onclick="delete_cumparator(<?php echo $data[ 'idd'];?>)" title='Sterge'><i  class="circular trash alternate olive icon"></i></a>

        <?php } ?>
        </a>
    </td>

    <?php
}