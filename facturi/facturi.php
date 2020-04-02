<?php
require ('../config.php');
$page_head=array(	'meta_title'=>'Facturi',	'trail'=>'facturi');
if(!$GLOBALS["login"]->is_logged_in()){redirect(303,LROOT.'login.php');}
get_rights('facturi');


if(isset($_POST['id_comanda']) and isset($_POST['id_comanda']) and is_numeric($_POST['id_comanda']) and $_POST['id_comanda']>0){
    $comanda = many_query("SELECT * FROM thf_comenzi_online WHERE id = '".$_POST['id_comanda']."' ");
    $insert = array(
        'idcf'=>$comanda['idcf'],
        'uid'=>$comanda['uid'],
        'data'=>date('Y-m-d'),
        'linie2'=>$comanda['linie2'],
        'valoare_linie2'=>$comanda['valoare_linie2'],
        'valoarea'=>$comanda['valoarea'],
        'tip_abonament'=>$tipuri_abonamente[$comanda['tip_abonament']],
        );
    $extrass = explode(',',$comanda['extraoptiuni']) ;
    foreach ($extrass as $valll){  $insert['extraoptiuni'].= $extra[$valll].' | ';  }
    $insert['extraoptiuni'] = trim($insert['extraoptiuni'],' | ');
      insert_qa("thf_facturi",$insert);

        update_query("UPDATE thf_comenzi_online SET factura = 1 WHERE id = '".q($_POST['id_comanda'])."' ");
        update_query("UPDATE thf_companii SET notificat_10zile = 0 WHERE idc = '".q($comanda['idcf'])."' ");
        echo 'Salvat!';
        die;


    }







if($GLOBALS["login"]->get_user_level()==10) {
    $sql = "SELECT * FROM thf_companii WHERE draft = 0 ";
} else {
    $sql = "SELECT * FROM thf_companii WHERE uid = '".$GLOBALS["login"]->get_uid()."' AND draft=0 ";
}
$companii = multiple_query($sql);
if(!count($companii)) { $list = 0; }
foreach ($companii as $key=>$val){
    $list .= $val['idc'].',';
}

$list = trim($list,",");
$sql = "SELECT * FROM `thf_date_facturare` 
    LEFT JOIN thf_facturi as fact ON fact.idcf = idc 
     WHERE fact.idcf IN ".'('.($list).')'." ORDER BY fact.idf DESC ";

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
        <th>Descriere</th>
        <th>Valoarea</th>
        <th>Printeaza</th>

    </tr>
    </thead>
    <tbody>
<?php foreach ($facturi as $key=>$val){

    ?>

            <tr align="center">
                <td><?php echo $val['data']?></td>
                <td><?php echo $prefix_facturi+$val['idf']?></td>
                <td><?php echo $val['nume']?></td>
                <td><?php echo $val['tip_abonament'].'<br>'.$val['extraoptiuni'].'<br>'.($val['linie2'].($val['valoare_linie2']>0 ? ' ('.$val['valoare_linie2'].' lei)':''));?></td>
                <td><?php echo $val['valoarea']-$val['valoare_linie2'].' lei'?></td>
                <td><?php  echo '<a href="'.ROOT.'facturi/print_out.php?idf='.$val['idf'].'">List</a>';?></td>

            </tr>
 <?php //factura($val['idf']);
    }   ?>

    </tbody>
    </table>
    </div>







   <?php side_menu_end();
index_footer();?>