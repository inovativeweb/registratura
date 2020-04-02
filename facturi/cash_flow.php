<?php
require ('../config.php');
$page_head=array(	'meta_title'=>'Cash flow',	'trail'=>'cash_flow');
if(!$GLOBALS["login"]->is_logged_in()){redirect(303,LROOT.'login.php');}
if($GLOBALS["login"]->get_user_level()<10){redirect(303,LROOT.'login.php');}
get_rights('cash');

$sql = "SELECT * FROM thf_companii WHERE 1 ";
$companii = multiple_query($sql);
foreach ($companii as $key=>$val){
    $list .= $val['idc'].',';
}
$list = trim($list,",");


    $sql = "SELECT * FROM `thf_date_facturare` 
    LEFT JOIN thf_facturi ON idcf = idc
     WHERE idcf IN ".'('.$list.')';

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
                <td><?php echo $tipuri_abonamente[$val['tip_abonament']];
                       $extras = explode(',',$val['extraoptiuni']) ;
                    foreach ($extras as $vall){  echo '<br>'.$extra[$vall];  } ?></td>
                <td><?php echo $val['valoarea'].' lei'?></td>
                <td><?php  echo '<a href="'.ROOT.'facturi/print_out.php?idf='.$val['idf'].'">List</a>';?></td>

            </tr>
 <?php //factura($val['idf']);
    }   ?>

    </tbody>
    </table>
    </div>







   <?php side_menu_end();
index_footer();?>