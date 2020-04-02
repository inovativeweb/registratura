<?php
require ('../config.php');
$page_head=array(	'meta_title'=>'Comenzi online',	'trail'=>'comenzi_online');
if(!$GLOBALS["login"]->is_logged_in()){redirect(303,LROOT.'login.php');}

get_rights('comenzi');
if(isset($_POST['abonament_end']) and isset($_POST['idc_abonament_end']) and is_numeric($_POST['idc_abonament_end']) and $_POST['idc_abonament_end']>0){
    update_query("UPDATE thf_companii SET abonament_end = '".q($_POST['abonament_end'])."' WHERE idc = '".q($_POST['idc_abonament_end'])."' ");
    echo 'Salvat!';
    die;
}

if(isset($_POST['abonament_start']) and isset($_POST['idc_abonament_start']) and is_numeric($_POST['idc_abonament_start']) and $_POST['idc_abonament_start']>0){
    update_query("UPDATE thf_companii SET abonament_start = '".q($_POST['abonament_start'])."' WHERE idc = '".q($_POST['idc_abonament_start'])."' ");
    echo 'Salvat!';
    die;
}

if(isset($_POST['id']) and isset($_POST['text'])){
    update_query("UPDATE thf_comenzi_online SET observatii_interne = '".q($_POST['text'])."' WHERE id = '".q($_POST['id'])."' ");
    echo 'Salvat!';
    die;
}


$sql = "SELECT * FROM thf_companii WHERE uid = '".$GLOBALS["login"]->get_uid()."' AND draft=0 ";
$companii = multiple_query($sql);

foreach ($companii as $key=>$val){
    $list .= $val['idc'].',';
}
$list = trim($list,",");


    $sql = "SELECT * FROM thf_comenzi_online
    LEFT JOIN thf_date_facturare ON idcf = idc
     WHERE 1 ORDER BY id DESC";

    $facturi = multiple_query($sql);


    index_head();
    side_menu_start();?>


    <div class="container-fluid">
    <table class="table">
    <thead>
    <tr>
        <th>Data</th>
        <th>Numar</th>
        <th>Nume</th>
        <th>Plata</th>
        <th>Descriere</th>
        <th>Valoarea</th>
        <th>Note</th>
        <th>Genereaza<br>factura</th>

    </tr>
    </thead>
    <tbody>
<?php foreach ($facturi as $key=>$val){

    ?>

            <tr align="center">
                <td><?php echo $val['last_modf_c']?></td>
                <td><?php echo $val['id']?></td>
                <td><?php echo $val['nume'].'<br>';
                    $user = many_query("SELECT * FROM thf_users WHERE id = '".$val['uid']."'  ");
                    $companie = date_companie($val['idcf']); ?>
                    <a href="/useri/user_edit.php?edit=<?php echo $val['uid']?>" target="_blank"><?php echo $user['full_name']?></a><br>
                    <a href="tel:<?php echo $user['telefon']?>"><?php echo $user['telefon']?></a><br>
                    <a href="mailto:<?php echo $user['mail']?>"><?php echo $user['mail']?></a><br>
                    <a href="<?php echo ROOT.$companie['props']['nume']['slug']?>" target="_blank"><?php echo $companie['nume']?></a>
                </td>
                <td><?php
                    echo $val['plata'] == 'card' ? '<span style="color:blue">Plata card</span>':'';
                    echo $val['plata'] == 'transfer' ? '<span style="color:orange">Transfer bancar</span>':'';

                    ?><br>
                    <?php
                    /*
                    if($val['transfer_bancar_reusit']=='n'){

                    if($val['plata']<2 || $val['plata']=='magazin'|| $val['plata']=='plata_op'|| $val['plata']=='ramburs'){}

                    else{echo '<em style="color:blue;">Clientul completeaza datele cardului...<br />Asteapta 5 minute...</em><br />';}

                    }

                    else{//transfer bancar

                    if(isset($statusuri_plata_card[$val['transfer_bancar_reusit']])){$tmp=$statusuri_plata_card[$val['transfer_bancar_reusit']];}

                    else{$tmp=array('c'=>'orange','m'=>'!!!EROARE!!!');}

                    ?><span style="color:<?php echo $tmp['c']; ?>; font-weight:bold; font-size:12px;">Transfer bancar #<?php echo h($val['referinta']).'<br />';

                        echo $tmp['m'];

                        ?></span><br /><?php }
                    */


                    echo '<span style="color: '.($val['transfer_bancar_reusit']=='Approved'?'green':'red').'">'.$val['transfer_bancar_reusit'].'</span><br>';
                    if ($val['transfer_bancar_reusit']=='Approved' && $val['romcard_sales']==NULL) { ?>
                        <input type="button"
                               style=" background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;"
                               value="Autorizeaza" onclick="window.open('<?php echo SITE;?>/plateste/index.php?raspuns=sales&id=<?php echo $val['id'];?>&rrn=<?php echo $val['romcard_RRN'];?>')" />
                    <?php }

                    if ($val['transfer_bancar_reusit']=='Approved' && $val['romcard_sales']!=4) { ?>
                        <input type="button"
                               style=" background-color: orange; /* Green */
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;"
                               value="Anuleaza" onclick="window.open('<?php echo SITE;?>/plateste/index.php?raspuns=anulare&company=<?php echo $val['idcf'];?>&id=<?php echo $val['id'];?>&rrn=<?php echo $val['romcard_RRN'];?>')" />
                    <?php }

                    if(is_numeric($val['romcard_sales'])){
                        if($val['romcard_sales']==0 && $val['transfer_bancar_reusit']!='Tranzatie stornata'){
                            echo '<h3 style="color:green">'.$status_plata_romcard[$val['romcard_sales']].'</h3>';
                        }   else {
                            echo '<h3>'.$status_plata_romcard[$val['romcard_sales']].'</h3>';
                        }
                    }
                   if(is_file(THF_PATH.'uploads/PDF/proforma-'.$val['proforma_id'].'.pdf')) {
                    ?><a href="<?=ROOT.'uploads/PDF/proforma-'.$val['proforma_id'].'.pdf'?>"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                    <?php } ?>
                </td>


                <td><?php echo $tipuri_abonamente[$val['tip_abonament']];
                       $extras = explode(',',$val['extraoptiuni']) ;
                    foreach ($extras as $vall){  echo '<br>'.$extra[$vall];  } ?>
                    <span style="color:red;"><?php echo '<br>'.$val['linie2'].($val["valoare_linie2"]>0 ? ' ('.$val["valoare_linie2"].' lei)':'');?></span>
                </td>
                <td><?php echo ($val['valoarea']-$val['valoare_linie2']).' lei'?></td>
                <td><textarea cols="20" rows="2" style="resize: vertical" name="observatii_interne" id="observatii_interne_<?php echo $val['id']?>" onblur="save_obs('<?php echo $val['id']?>')"><?php echo $val['observatii_interne']?></textarea>
                <span style="color: green;" id="raspuns_<?php echo $val['id']?>"></span></td>
        <?php if($val['factura'] == 0) { ?>
                <td>

                    <i class="fa fa-file-pdf-o fa-2x" onmousedown="gen_factura(<?php echo $val['id']?>)" aria-hidden="true"></i>
                </td>
        <?php } else { ?>
            <td><i class="fa fa-check fa-2x" aria-hidden="true"></i></td>
         <?php } ?>
            </tr>
 <?php //factura($val['idf']);
    }   ?>

    </tbody>
    </table>
    </div>







   <?php side_menu_end();
index_footer();?>
<script>
    function save_obs(id) {
       var txt =  $('#observatii_interne_'+id).val();
        $.post('',{'text':txt,'id':id},function (data) {
           $('#raspuns_'+id).text(data);
           $('#raspuns_'+id).hide('blind', 1000);
        })
    }
</script>
