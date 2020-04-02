<?php
require_once('./config.php');

require_login();

$page_head=array(
    'meta_title'=>'Cereri promovare',
    'trail'=>'promovari'

);
/*
$idf = 22;
$html = factura($idf,true);
generate_pdf($html,$title = NULL,$save_pdf = true,$idf);
*/
$six_monts = date("Y-m-d",strtotime('+6 months'));

if(isset($_POST['save_promovare'])){
    prea($_POST);
    delete_query("DELETE FROM `promovari_active` WHERE `promovari_active`.`idv` = '".$_POST['idvf']."' ");
    foreach($_POST['promovat_until'] as $idp=>$date){
        $insert = array(
             'idp'=>$idp,
             'valabilitate'=>$date,
             'idv'=>$_POST['idvf'],
             'idfa'=>$_POST['idf'],
             'activ'=>isset($_POST['promovare_aprobata'][$idp]) ? '1' : '0',
        );
        insert_qa("promovari_active",$insert);
    }
 //   file_get_contents("https://trade-x.ro/wp-admin/admin-ajax.php?action=wpfc_delete_current_page_cache&path=/afaceri-de-vanzare/&_=1561987244576"); // delete_cache
    DIE;
   // update_query("UPDATE vanzare set promovare_aprobata = '".q($_POST['promovare_aprobata'])."',`promovat_until` = '".q($_POST['promovat_until'])."' WHERE idv = '".q($_POST['idv'])."' ");
    ThfAjax::status(true,'Salvat cu succes');
    ThfAjax::json();

}
if(isset($_POST['idd'])){
    $idd = $_POST['idd'];
    unset($_POST['idd']);
    if(is_numeric($idd)){ //update
        // prea($_POST);
        update_qa("definitii",$_POST," idd = '".$idd."' ",' LIMIT 1',false);
        ThfAjax::status(true,'Actualizat');
    } else {
        if(!strlen($_POST['tip'])){ThfAjax::status(true,'Completeaza tip'); }
        elseif(!strlen($_POST['cheie'])){ThfAjax::status(true,'Completeaza cheie'); }
        elseif(!strlen($_POST['text'])){ThfAjax::status(true,'Completeaza text'); }
        else{
            insert_qa("definitii",$_POST);
            ThfAjax::status(true,'Adaugat');
            ThfAjax::redirect('r');
        }
    }
    ThfAjax::json();
}


$cereri_promovare = multiple_query("SELECT * FROM `thf_facturi` 
 # LEFT JOIN thf_users on thf_users.id = thf_facturi.uid
 WHERE status > 0 || thf_facturi.idf IN (SELECT idfa FROM `promovari_active` )
 ORDER BY idf DESC");


if($GLOBALS['login']->get_user_level()<10){ redirect(303,LROOT);}

index_head();

echo list_menu_settings();
?>
<div class="container-fluid">
    <table class="table">
        <thead>
        <tr>
            <th>IdVanzare</th>
            <th>Vanzare</th>
            <th>Companie</th>
            <th>User</th>
            <th>Valoarea</th>
            <th>Status</th>
            <th>Genereaza<br>proforma</th>
            <th>Factura</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($cereri_promovare as $k=>$p) {
            $repere = json_decode($p['repere'],true);
            $cereri_promovare_aprobate = multiple_query("SELECT * FROM `promovari_active` WHERE idv='".$p['idvf']."' ",'idp');
            ?>
            <tr>
                <td><a target="_blank" href="/add_afacere/?edit=<?=$p['idvf'];?>">#<?=$p['idvf'];?></a></td>
                <td><?=$companii_all[$p['idvf']]['denumire']?></td>
                <td><?=($p['id_asociatie'] > 0 ? 'Asociatie:':'Broker:').'<br>'?>
                    <?=$p['id_asociatie'] > 0 ? $asociatii[$p['id_asociatie']]['nume_asociatie'] :  one_query("SELECT denumire FROM `companie` WHERE id_companie = '". $p['id_companie_user']."' ");?></td>
                <td><?=$users[$p['uid']]['full_name']?></td>
                <td><?=$p['valoarea'];?></td>
                <td><form>
                        <input type="hidden" name="idf" value="<?=$p['idf'];?>" />
                        <input type="hidden" name="idvf" value="<?=$p['idvf'];?>" />
                        <input type="hidden" name="save_promovare" value="" />
                    <ul class="list-group">
                    <?php foreach ($repere as $idp=>$reper){?>
                        <li class="list-group-item">
                            <input type="checkbox" name="promovare_aprobata[<?=$idp?>]" <?=$cereri_promovare_aprobate[$idp]['activ'] > 0 ? ' checked' : '';?> />
                            <?=$reper['denumire'] .' - '. $reper['cantitatea'] . ' luni'?>

                            <input style="width: 130px;" type="text" class="form-control" name="promovat_until[<?=$idp?>]" datetimepicker
                                   value="<?=isset($cereri_promovare_aprobate[$idp]['valabilitate']) ? $cereri_promovare_aprobate[$idp]['valabilitate'] :  date("Y-m-d",strtotime("+ ".$reper['cantitatea']." months"))?>" ></li>
                    <?php } ?>
                        <li class="list-group-item"><a onclick="salveaza_promovare(this)" class="ui basic green button " id="anuleaza_promovare">Salveaza</a>
                        <p>Actualizat : <?=$cereri_promovare_aprobate[$idp]['last_update']?></p></li>
                    </ul>
                    </form>

                </td>

                <td><a target="_blank" href="<?=ROOT?>facturi/print_out.php?idf=<?=$p['idf']?>"><i class="circular purple file pdf outline icon"></i></a></td>
                <td><?PHP if($p['nr_factura']>0) { ?>
                    <a target="_blank" href="<?=$p['link_factura']?>">
                       <?=$p['nr_factura'] > 0 ? $p['serie_factura'] .' '. $p['nr_factura'] : ''?>
                        <br><i TITLE="Tipareste Factura Fiscala"  class="circular green file pdf outline icon"></i></a>
                        <i onclick="stergere_fgo('<?=$p['idf']?>',this)" serie="<?=$p['serie_factura']?>" numar="<?=$p['nr_factura']?>" title="Sterge documetul din FGO" class="circular red trash alternate outline icon"></i>
                    <?php } else { ?>
                    <a TITLE="Genereaza Factura Fiscala" target="_blank" onclick="gen_factura_fgo('<?=$p['idf']?>',this)">
                        <i class="circular red file pdf outline icon"></i></a>
                    <?php } ?>
                </td>
           </tr>
        <?php } ?>
        </tbody>
    </table>

    <script>

        function stergere_fgo(idf,obj) {
            if(confirm('Esti sigur ca doresti sa stergi acest documet din FGO?')) {
                $.get("/fgo/", {
                    "stergere_fgo": "",
                    "idf": idf,
                    "serie": $(obj).attr('serie'),
                    "numar": $(obj).attr('numar')
                }, function (r) {
                    location.reload();
                })
            }
        }

function gen_factura_fgo(idf,obj) {
    $.get("/fgo/",{"generare_fgo" : "", "idf":idf},function (r) {
        if(!r.Success){
            ThfAjax(r.Message);
        } else {
            location.reload();
        }


    })
}
function salveaza_promovare(obj) {
   var form = $(obj).closest('form').serialize();
   $.post("",form,function (r) {
       location.reload();
   })
}
    </script>

<?php index_footer();?>

