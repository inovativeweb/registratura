<?php

if (!$GLOBALS['has_config']) {require ('../config.php'); }
if (!$has_controller) {require (THF_PATH . '/documente/controller.php'); }

//require (THF_PATH . '/documente/controller.php');


$pid=floor($_GET['edit']);  // 333


$istoric = multiple_query("select * from documente_istoric left join documente on id_doc = idd where id_doc = $pid ORDER by data_generare desc");





$page_head['title']='Istoric';
$page_head['trail']='documente';
if (!$GLOBALS['has_config']) {
    index_head();
}
?><div id="istoric" class="div_step hide">
    <table class="table table-striped single line table-hover table-responsive ui olive table  THFsortable">
        <tbody><tr class="">

            <th scope="col"><span title="Sort this column">Nr document<br>Tip</span></th>
            <th scope="col"><span title="Sort this column">Data</span></th>
            <th scope="col"><span title="Sort this column">Status <br> </span></th>
            <th scope="col"><span title="Sort this column">Alocat <br> </span></th>

            <th scope="col"><span title="Sort this column">Continut</span></th>
        </tr>
        <?php foreach ($istoric as $id=>$dat){ //prea($dat);
            $id_doc = $dat['id_doc'];?>
        <tr>
            <td><?=$dat['nr_doc'] . '<br>' . $dat['tip']?><p style="color: grey">#<?=$dat['idi']?></p></td>
            <td><?=$statusuri[$dat['status_istoric']]?></td>
            <td>
                <?=date("d-m-Y",strtotime($dat['data_doc']))?>
                <p style="color: darkgrey">Acum <?=actualizat_acum_time(strtotime($dat['data_generare']),60*60*24*30)?></p>
            </td>
            <td><?php echo show_locuitor_icon_functie($dat['id_alocat'])?></td>
        <td width="50%"><div style="max-height: 150px; overflow-y: scroll"><?=nl2br($dat['html'])?></div></td>
        </tr>
    <?php } ?>
        </tbody>
    </table>
    </div>
<?php

if (!$GLOBALS['has_config']) {
    index_footer();
}