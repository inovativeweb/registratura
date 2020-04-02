<?php
function list_filters($filtre){ global $users_list,$statusuri ?>
    <form action="" method="post" enctype="application/x-www-form-urlencoded" id="cms_filters">
    <div class="col-sm-4">
        <?php
        $statusuri['-1'] = 'Toate';
        ksort($statusuri);

        select_rolem('status','Status',$statusuri,'-1','');
        ?>
    </div>
            <div class="col-sm-4">


    <div class="field">
        <label for="validation_status">Cauta <i class="search icon"></i></label>
        <input class="cauta form-control" placeholder="Cauta" value="<?=@$_SESSION['cauta']?>" type="text" id="cauta"  name="cauta">

    </div>
    </div>

    <div class="col-sm-3">
        <?php

        $domenii_afacere=array(""=>"Selecteaza..") + $filtre['domenii_afacere'];
        select_rolem('domeniu_activitate','Domeniu de Activitate',$domenii_afacere,$_SESSION['domeniu_activitate'],'');

        ?>
    </div>
    <div class="localitati_judete">
    <div class="col-sm-2">
        <?php

		$judete=array(""=>"Selecteaza...")+$filtre['judete'];

       select_rolem( 'judet_id', 'Judetul ', $judete, $_SESSION[ 'judet_id' ], '', false, array() );
        ?>
    </div>
    </div>
    <div class="col-sm-2 div_localitate_id">
        <?php
        select_rolem( 'localitate_id', 'Oras ', $filtre['localitati'], $_SESSION[ 'localitate_id' ], 'Alege...', false, array() ); ?>
    </div>
	<div class="col-sm-2">
        <?php
        		$users_list=array(""=>"Selecteaza..")+$users_list;
        select_rolem( 'business_broker', 'Broker ', $users_list, $_SESSION[ 'business_broker' ], 'Alege...', false, array() ); ?>
    </div>

        <div class="col-sm-1">
 		<label for="pret">Pret</i></label>
        <input class="cauta form-control" placeholder="Min" value="<?=@$_SESSION['min']?>" type="text" id="min"  name="min">
        </div>
       <div class="col-sm-1">
           <label for="pret">Max</i></label>
                <input class="cauta form-control" placeholder="Max" value="<?=@$_SESSION['max']?>" type="text" id="max"  name="max">
       </div>
        <div class="col-sm-3">
                    <?php $sort['idv DESC'] = 'Cele mai noi';
                    select_rolem('sort','Sorteaza',$sort,$_SESSION['sort'],''); ?>
                 </div>
            <div class="col-sm-2"><?php
                $pag[1]='Pag 1.'; select_rolem('pag','Pagina',$pag,'',''); ?>
         </div>
            <div class="col-sm-2">
                <input name="ajax" type="hidden" value="1">
                <div class="ui form" validation_status="">
                    <div class="results"></div>
                </div>
            </div>
</form>
<?php }

function list_documente($data){ global $vanzari;

    if(!isset($_GET['print_afaceri'])){
    ?>
    <table class="table table-striped  line table-hover table-responsive ui purple table " >
        <?php } else { ?>
         <table border="1" cellpadding="2" cellspacing="2">
         <?php } ?>
    <thead>
    <tr>
          <th>id</th>
        <th width="10%">Titlu Publicare<br> Afacere</th>
        <th width="10%">Domeniu de Activitate</th>
        <th width="10%">Pret de Vanzare €</th>
        <th width="10%">Cifra de Afaceri<br> Anuala Ron</th>
        <th>Oras</th>
        <th>Judet</th>
        <th>Business Broker</th>
        <th>Telefon</th>
        <th>Data Publicarii</th>
        <th width="10%">Status Afacere</th>
    </tr></thead>
        <tbody>

        <?php
        $i = 0;
        foreach ($data as $id_doc=>$doc){$i++;


            ?>
            <tr class='tr_select' <?php echo (1 || has_right($doc[ 'idv'],'vanzare')?"onmousedown=\"go_to_afacere(".$doc['idv'].",this);\" style='cursor:pointer;'":"")  ?> class="<?=($doc['status']=='draft') ? 'negative' : 'positive';?> list_row"  id="tr_data_<?=$id_doc?>" id_prd="<?=$id_doc;?>">
                <?php
                list_one_row_afaceri($doc);?>
            </tr>
            <?php //if(isset($_GET['print_afaceri']) and $i == 8){ echo ' @pbreaky@';}?>

            <tr id="tr_id_prd_<?=$id_doc?>" style="display: none;">
                <td colspan="6" id="raspuns_<?=$id_doc?>">
                    <hr style="border: 1px solid black">
                </td>
            </tr>

        <?php } ?>
        </tbody>
    </table>

<?php }

function show_status($json){
    $data  = json_decode($json,true);
    $val = $data['date_afacere'];
    if(!isset($val)){return;}
          if($val < 51){$color = 'red'; }
           else if($val < 85){$color = '#FFD700'; }
            else if($val > 84) { $color = 'green'; }
 ?><strong title="Date afacere: <?=$val?>%">
          <span style="color: <?=$val > 24 ? $color : 'gray' ?>">■</span>
          <span style="color:<?=$val > 49 ? $color : 'gray' ?>">■</span>
          <span style="color:<?=$val > 74 ? $color : 'gray' ?>">■</span>
          <span style="color:<?=$val > 85 ? $color : 'gray' ?>">■</span>
      </strong>
    <?php
        $val = $data['editare_im'];
    if(!isset($val)){return;}
          if($val < 51){$color = 'red'; }
           else if($val < 85){$color = '#FFD700'; }
            else if($val > 84) { $color = 'green'; }
    ?>&nbsp;&nbsp;<strong title="Editare IM: <?=$val?>%">
          <span style="color: <?=$val > 24 ? $color : 'gray' ?>">■</span>
          <span style="color:<?=$val > 49 ? $color : 'gray' ?>">■</span>
          <span style="color:<?=$val > 74 ? $color : 'gray' ?>">■</span>
          <span style="color:<?=$val > 85 ? $color : 'gray' ?>">■</span>
      </strong>
    <?php
}

function list_one_row_afaceri($data){ global $companii,$users, $localitati, $judete,$culori_statusuri,$statusuri,$from_cumparatori,$domenii_afacere,$pid;
   // prea($data['procente']);
  $companie_vanzare = $companii[$data['companie_vanzare']];
    $reprezentant_vanzare = $companii[$data['reprezentant_vanzare']];
   $style = ($_GET['print_afaceri'] ? ' style="border:1px solid black"' : ' ');
    ?>
   <td <?=$style?>>
   <?php $img = json_decode($data['atasamente'],true);
   if(strlen($img[0])) { ?>
   <img src="<?=$img[0]?>" class="logo_img" style="max-width: 90px;" />
   <?php } ?>
      <p style="color: grey;">#<?=$data['idv']?></p>
      <p>
      <?=show_status($data['procente']);?>

</p>
   </td>
    <td <?=$style?>><?=$data['denumire_afacere']?><br>
        <?php
        $color = '';
        if($data['promovare_aprobata'] > 0 and $data['promovat_until'] > 0){
            $color = 'purple';
                $title = 'Afacerea este promovata';
        }
        if($data['promovare_aprobata'] == 0 and $data['promovat_until'] > 0){
            $color = 'gray';
             $title = 'Pentru promovare se asteapta confirmarea platii';
            $cerere_promovare = one_query("SELECT idf FROM `thf_facturi` WHERE idvf = '".$data['idv']."' ");
            $link = '<a title="Printeaza proforma" target="_blank" href="/facturi/print_out.php?idf='.$cerere_promovare.'"><i class="circular purple file pdf outline icon"></i></a>';
        }
        if(strlen($color)){ ?>
        <i style="color: <?=$color;?>" title="<?=$title?>" class="angle rss icon" ></i><?=$link?>
            <?php } ?>
<hr>
    </td><?php
    $domenii = '';
    if(strlen($data['domeniu_activitate'])>0){
    $domeniiX = explode(',',$data['domeniu_activitate']);

    foreach ($domeniiX as $dd=>$dom){
    $domenii .= '&bull;' . $domenii_afacere[$dom] . "<br>";
    }
    }
    ?>
    <td <?=$style?>><?=($domenii)?></td>
    <td <?=$style?>><?=$data['pret_vanzare']?></td>
    <td <?=$style?>><?=$data['cifra_afaceri']?></td>
    <td <?=$style?>><?=$localitati[$companie_vanzare['localitate_id']]?></td>
    <td <?=$style?>><?=$judete[$companie_vanzare['judet_id']]?></td>

    <td <?=$style?>><?=$users[$data['uid']]['full_name']?></td>
    <td <?=$style?>><?=$users[$data['uid']]['tel']?></td>
    <td <?=$style?>><?=($data['data_publicare']==""?"":date("d-m-Y",strtotime($data['data_publicare'])))?></td>
    <td <?=$style?> <?=$data['id_doc'].'\'"'?> class='for_delete'>
        <div id="status_color" style="padding: 0; text-align: center" class="col-xs-6 ui <?=$culori_statusuri[$data['status']]?> message"><?=$statusuri[$data['status']]?></div>
        
        <div class="col-xs-6">
         <?php if(has_right($data[ 'idv'],'vanzare')){  ?>
           <!--  <a title="Editeaza" href="<?=ROOT . 'add_afacere/?edit='.$data['idv'];?>"><i class="circular edit sign icon purple"></i></a> -->
	     		<?php
	     		if ($from_cumparatori)
	     		{
					?>
					<a href='#' onclick="delete_from_cumparator(<?php echo $data[ 'idv'];?>,<?php echo $pid;?>)" title='Sterge'><i  class="circular trash alternate purple icon"></i></a>
					<?php
				}
				else
				{
					
				
	     		?>
        		<a href='#' onclick="delete_afacere(<?php echo $data[ 'idv'];?>)" title='Sterge'><i  class="circular trash alternate purple icon"></i></a>
        <?php	
				}	
         } ?>
        </div>
    </td>

<?php }

