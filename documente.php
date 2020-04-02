<?php
require_once('./config.php');
$page_head=array(
	'meta_title'=>'Proiecte',
	'trail'=>'documente'
	);

/*
if(count($_POST)){
    $_POST['id_user_emitere']= $GLOBALS['login']->get_user_prop('id');
    $_POST['id_user_modificare']=$GLOBALS['login']->get_user_prop('id');
    $_POST['data_afisata']=date('Y-m-d');
    $_POST['produse']='{}';

     $last_id=insert_qa('documente',$_POST);
    redirect(303,ROOT.'documente_edit.php?edit='.$last_id);
   // die;
}
*/

//$GLOBALS["login"]->sign_in_form_stand_alone();
$fise=array();

if($GLOBALS["login"]->is_logged_in()){



        $item_sql='';

        if(isset($_GET['search_box']) && strlen(trim($_GET['search_box']))>1 ){

            $str_cautare=$_GET['search_box'];
            $str_cautare2=$_GET['search_box'];
            $str_exclude=array('	',"\r","\n",'   ','  ');
            foreach($str_exclude as $e){$str_cautare=str_replace($e,' ',$str_cautare);}
            $str_cautare=explode(' ',trim($str_cautare));
            foreach($str_cautare as $k=>$p){
                if($p!=''){
                    $coloane = array();
                    $coloane += multiple_query("DESCRIBE documente",'Field');
                 //  $coloane += multiple_query("DESCRIBE adrese",'Field');
                  //  $coloane += multiple_query("DESCRIBE companie",'Field');
                    foreach ($coloane as $c){ $col[]='`'.$c['Field'].'`'; }
                    $col=implode(',',$col);
                    $item_sql.="  CONCAT_WS(".$col.") LIKE '%".q($p)."%' ";
                    $item_sql.="  or CONCAT_WS(' ',ai.adresa, ai.localitatea, ai.judet, ai.tara, ai.telefon, ai.email, ai.strada) LIKE '%".q($p)."%' ";
                    $item_sql.="  or  CONCAT_WS(' ',ap.adresa, ap.localitatea, ap.judet, ap.tara, ap.telefon, ap.email, ap.strada)  LIKE '%".q($p)."%' ";
                    $item_sql.="  or  CONCAT_WS(' ',ad.adresa, ad.localitatea, ad.judet, ad.tara, ad.telefon, ad.email, ad.strada)  LIKE '%".q($p)."%' ";
                    $item_sql.="  or CONCAT_WS(' ',ci.nume, ci.prenume, ci.denumire, ci.cui, ci.cnp) LIKE '%".q($p)."%' ";
                    if(strlen($item_sql)){
                       // $item_sql.= " or `adresa_i` LIKE '%".q($p)."%' ";
                       // $item_sql.= " or `adresa_d` LIKE '%".q($p)."%' ";
                       // $item_sql.= " or `companie_i` LIKE '%".q($p)."%' ";
                    }
                    //	$item_sql.=" AND CONCAT_WS(',',`id`,`data_preluare`,`nume_prenume_client`,`telefon_client`,`echipament`,`accesorii`,`stare_echipament`,`sn_echipament`,`data_iesire_service`,`piese`,`obs` ) LIKE '%".q($p)."%' ";
                }
            }
        }
        else{$item_sql='1';}


        $status_sql='';
        if(isset($_GET['statusuri']) && is_numeric($_GET['statusuri']) && $_GET['statusuri']>-1){
            $status_sql=" AND `status_proiect`='".floor($_GET['statusuri'])."' ";
        }
        $having = " having `adresa_i` LIKE '%".q($str_cautare2)."%' ";
        $having .= " or `adresa_d` LIKE '%".q($str_cautare2)."%' ";
        $having .= " or `companie_i` LIKE '%".q($str_cautare2)."%' ";

         $sql="SELECT c.*,d.*,a.*
          FROM `documente` as d 
        LEFT JOIN companie as c on c.id_companie = d.id_companie_clienta
        LEFT JOIN companie as ci on ci.id_companie = d.id_companie_clienta
        LEFT JOIN adrese as a on a.ida = d.id_adrese_destinatar
        LEFT JOIN adrese as ai on ai.ida = d.id_adresa_imputernicit
        LEFT JOIN adrese as ad on ad.ida = d.id_adresa_domiciuliu
        LEFT JOIN adrese as ap on ap.ida = d.id_adrese_destinatar
        WHERE $item_sql $status_sql ORDER BY `nr_document` DESC LIMIT 100";


        $fise=multiple_query($sql);
        if(isset($_GET['search_box'])){ tabel_fise($fise);   die();}

}
index_head();
    foreach(explode(',',$shopIds) as $i=>$sid){
        echo $i?', ':'';
        echo h($service[$sid]['nume']);
    }
    echo '</strong></span>';
    $search_box='<input type="text" id="search_box" value="" class="form-control" placeholder="Cauta in proiecte..." />';
    $add_fisa='<select id="statusuri" class="form-control"><option value="all">Toate Statusurile</option>';
    foreach($statusuri as $i=>$name){
        $add_fisa.='<option value="'.$i.'">'.$name.'</option>';
    }
    $add_fisa.='</select>';
//	$add_fisa.='<a href="/fise_edit.php" class="btn btn-success iframe pull-right">Adauga Fisa</a>';

?>



<?php
    echo '<div class="container-fluid"><div class="row">';
    echo ($select?'<div class="form-group col-sm-3">'.$select.'</div>':'');
    echo '<div class="form-group col-sm-'.($select?3:6).'">'.$search_box.'</div>';
    echo '<div class="form-group col-sm-2">'.$add_fisa.'</div>';
    echo '<div class="form-group col-sm-2">'.'<strong> </strong>'.$rezultat.'</div>';?>
    <div class="col-xs-2">
        <?php
        $facturi = multiple_query("SELECT nr_document FROM `documente` WHERE `serie_document` = 'C' and nr_document > 400 ORDER BY `documente`.`nr_document` ASC",'nr_document');

        $ultimul_nr = one_query("SELECT nr_document FROM `documente` WHERE `serie_document` = 'C' and nr_document > 0 ORDER BY `documente`.`nr_document` DESC ");
        $i=1; $nr_lipsa = array();
        for($i=400;$i < $ultimul_nr;$i++){
            if($facturi[$i]['nr_document'] == $i) {}
            else {$nr_lipsa[] = $i;}
        }

        if(count($nr_lipsa)){
            echo 'Numere lipsa: <span style="color: red;"> ';
            foreach ($nr_lipsa as $k) {
                echo $k.',';
            }
            echo '</span>'; }
        ?>
        <br>Urmatorul nr seria C : <?=$ultimul_nr+1;?>
    </div>
  <?php  echo '</div>';
    echo '</div><br>';

    ?>
    <div id="tabel_fise">
    <?php if(isset($_SESSION['client_selectat']['select_magazin']) && $_SESSION['client_selectat']['select_magazin'] > -2 ) {}
    else{   tabel_fise($fise);    } ?>



<script>
    var refiltreaza=0;
    function filtreaza(){
        refiltreaza=0;
        $.get('',{'select_magazin':$('#select_magazin').val(),'search_box':$('#search_box').val(),'statusuri':$('#statusuri').val()},function(data){
            $('#tabel_fise').html(data);

            jQuery('#tabel_fise').find('[datePickerIso]').each(function(){
                var settings={"dateFormat":'yy-mm-dd'}; // {"minDate": -5,"maxDate": 0} use propper json syntax or errors!
                if(jQuery(this).attr('datePickerIso').length){ settings= jQuery.extend(settings,jQuery.parseJSON(jQuery(this).attr('datePickerIso'))); }
                jQuery(this).datepicker(settings);
            });
            jQuery('#tabel_fise').find('[dateTimePicker]').each(function(){
                var settings={"dateFormat":"yy-mm-dd",	"timeFormat": "HH:mm:ss"}; // {"minDate": -5,"maxDate": 0} use propper json syntax or errors!
                if(jQuery(this).attr('dateTimePicker').length){ settings= jQuery.extend(settings,jQuery.parseJSON(jQuery(this).attr('dateTimePicker'))); }
                jQuery(this).datetimepicker(settings);
            });
            jQuery('#tabel_fise').find('[timePickerIso]').each(function(){
                var settings={"timeFormat": "HH:mm:ss"}; // {"minDate": -5,"maxDate": 0} use propper json syntax or errors!
                if(jQuery(this).attr('timePickerIso').length){ settings= jQuery.extend(settings,jQuery.parseJSON(jQuery(this).attr('timePickerIso'))); }
                jQuery(this).timepicker(settings);
            });
      });
    }

    $(function(){
        var old_cauta = $('#search_box').val();


        $('#search_box').blur(function(){filtreaza();}).
        keypress(function( event ) {
            refiltreaza++;
            if ( event.which == 13 ) {event.preventDefault(); filtreaza();}
        });
       setInterval(function(){
            if(old_cauta !=$('#search_box').val()){
                filtreaza();
            }
            if(refiltreaza){filtreaza();}
        },500); 
        $('#select_magazin,#statusuri').change(function(){filtreaza();});

        <?php if(isset($_SESSION['client_selectat']['select_magazin']) && $_SESSION['client_selectat']['select_magazin'] > -2 ) { ?>
        filtreaza();
        <?php } ?>


    });
</script>
<?php index_footer();  ?>