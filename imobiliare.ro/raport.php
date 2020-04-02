<?php require ('controller.php');

$page_head[ 'title' ] = 'Raport imobiliare.ro';
$page_head[ 'trail' ] = 'imobiliare';



require_login();

$imob_db = multiple_query("SELECT * FROM `imobiliare`  ",'idm');


index_head();
echo list_menu_settings();
?>
    <table class="table table-striped single line table-hover table-responsive ui red table ">
        <thead>
        <tr class="violet">
            <th>Id</th>
            <th>Vanzare</th>
            <th>Tip</th>
            <th>Imobiliare.ro</th>
             <th>Info</th>
            <th>Data publicat</th>
        </tr>
        </thead>
        <tbody>
<?php
foreach ($imob_db as $idm=>$data) {
    $json = json_decode($data['json'], true);
    ?>
<tr>
    <td><?=$idm?></td>

    <td><a target="_blank" href="/add_afacere/?edit=<?=$data['id_vanzare']?>"><?=$vanzari_all[$data['id_vanzare']]['denumire']?></a></td>
    <td><?=$types_imobiliare[$data['type']]?></td>
    <td>   <a target="_blank" href="https://adminonline.imobiliare.ro/oferte/spatii/<?=$data['id_imobiliare']?>"><input type="button" class="ui green teal button" id="" value="Vezi pe adminonline.Imobiliare.ro"></a>
        <br> <br>
            <a target="_blank" href="https://www.spatiicomerciale.ro/anunt/<?=$data['id_imobiliare']?>"><input type="button" class="ui green red button" id="" value="Vezi pe Imobiliare.ro"></a>

    </td>
    <td>
        <i class="ui eye icon blue big" onclick="show_info(this,'<?=$idm; ?>')"></i><br>
        <div class="hide info_<?=$idm?>"><?php prea($json)?>
    </td>
    <td>
        <?=ro_date($data['last_updated'])?>
    </td>
</tr><?php  } ?>
        </tbody>
        </table>
<script>
    function show_info(obj,idm) {
        if($(obj).hasClass('eye')){
            $('.info_'+idm).removeClass('hide');
            $(obj).removeClass('eye').addClass('delete');
        } else {
            $('.info_'+idm).addClass('hide');
            $(obj).removeClass('delete').addClass('eye');
        }
        
    }
</script>
<?php
index_footer();
