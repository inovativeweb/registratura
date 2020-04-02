<?php
require ('../config.php');

$tabel='form_contact';
if(isset($_POST['rezerva']) AND is_numeric($_POST['rezerva'])){

    update_query(" UPDATE `$tabel` SET `contactat_de_broker_id` = '".$user_id_login."',`contactat_de_broker_pe`= '".date("Y-m-d")."' WHERE `$tabel`.`id` = '".$_POST['rezerva']."' LIMIT 1");

    ThfAjax::status( true, 'Rezervat cu succes pentru 14 zile' );
    ThfAjax::json();
}


$select_list['judet']=explode(',',one_query("SELECT GROUP_CONCAT(DISTINCT judet ORDER BY judet) FROM $tabel "));
$select_list['oras']=explode(',',one_query("SELECT GROUP_CONCAT(DISTINCT oras ORDER BY oras) FROM $tabel "));



if(isset($_POST['dell_jobs_cumparator'])){
	update_query(" UPDATE `$tabel` SET `deleted` = '1' WHERE `$tabel`.`id` = '".$_POST['dell_jobs_cumparator']."' LIMIT 1");
	ThfAjax::status(true,'Actualizat...');
	ThfAjax::redirect(true); //tell java to reaload client page
	ThfAjax::json();	
}


//////// PAGINATE +FETCH LOGIC ///////////////
$where_sql='';
$order="\r\n ORDER BY id DESC";
$curent_page=isset($_REQUEST['pag'])?floor($_REQUEST['pag']):1;
$curent_page=$curent_page<1?1:$curent_page;
if(isset($_POST['searchPhrase'])){
	if($_POST['judet']){ $where_sql .= ($where_sql ? "\r\r AND " : "") . " judet ='".q($_POST['judet'])."' "; }
	if($_POST['oras']){ $where_sql .= ($where_sql ? "\r\r AND " : "") . " oras ='".q($_POST['oras'])."' "; }
	
	
	
	if(isset($_POST['searchPhrase']) && strlen($_POST['searchPhrase'])){
		$as=[];
		$description=multiple_query("DESCRIBE `$tabel`",'Field'); // prea($bulk); die();
		foreach($description as $key=>$v){$as[]=" `$tabel`.`$key`";}
		
		$str_cautare=$_POST['searchPhrase'];
		$str_exclude=array('	',"\r","\n",'   ','  ');
		foreach($str_exclude as $e){$str_cautare=str_replace($e,' ',$str_cautare);}
		$str_cautare=explode(' ',trim($str_cautare));

	//	$concat=array();
	//	foreach($description as $key=>$v){$concat[]='`documente`.`'.$key.'`';}
		$concat=implode(', ',$as);

		foreach($str_cautare as $k=>$p){
			if($p!=''){
				$where_sql.=($where_sql!=''? ' AND':'')." CONCAT_WS( ' ', $concat ) LIKE '%".q($p)."%' \r\n";
				}
			}
		}
	
	$where_sql = ( $where_sql ?
		"\r\n WHERE " . $where_sql . " AND deleted=0 " :
		$where_sql );

	
}
if(!$where_sql){
	$where_sql=" WHERE deleted=0 ";
}


$main_sql=" FROM `$tabel` $where_sql ";
$count_sql = "SELECT COUNT(*) ".$main_sql;



$results_per_page=50;
$total_results = floor( count_query( $count_sql ) );
$nb_pages = ceil( $total_results / $results_per_page );
$nb_pages = ( $nb_pages < 1 ? 1 : $nb_pages );
$curent_page = min( $curent_page, $nb_pages ); //switch page failsafe if overbuffer



$select_sql = "SELECT * ".$main_sql."\r\n $order \r\n ".thf_paginate_limit_sql( $total_results, $curent_page, $results_per_page );


//////// PAGINATE +FETCH LOGIC ///////////////

$form_contact=multiple_query($select_sql,'id');

$page_details = array(
	'curent_page' => $curent_page,
	'total_results' => $total_results,
	'nb_pages' => $nb_pages,
	'results_per_page' => $results_per_page,
	'sql' => $select_sql,
	//'sql' =>'',
);

if(isset($_POST['searchPhrase'])){
	ob_start();
	list_new_jobs($form_contact,$page_details);
	$page_details[ 'table' ] = ob_get_contents();
	ob_end_clean();
	json_encode_header( $page_details, 1 );
	die();
}








function list_new_jobs($form_contact,$page_details){
	global $users,$vanzari,$cumparatori,$is_admin;
	$spacer=' &nbsp;&nbsp; '; ?>
	    <table class="ui table table-striped table-hover table-responsive  yellow line">
        <thead>
        <tr>
            <th width="1%">#</th>
            <th>Nume</th>
            <th>Interesat sa?</th>
            <th>Industrie/ Activitate</th>
            <th>Suma disponibila</th>
            <th>Data</th>
            <th>Rezervat</th>
            <th>Adauga...</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($form_contact as $id=>$c){ ?>
            <tr class="<?=($c['contactat_de_broker_id'] == 0 ? 'negative' : 'positive') ?> mesaje">
                <td>
                    <?php

        ?><?=h($id);?><br></td>
                <td><?=h($c['et_pb_contact_name_1']);?>
                    <?=($c['tel']?'<br>Tel: '.h($c['tel']):'');?>
                    </td>
                <td><?=h($c['interesat_sa']);?></td>
                <td><?=h($c['industrie']);?></td>
                <td><?=h($c['suma_disponibila']);?></td>
                <td><?=h(substr($c['contact_datetime'],0,10));?></td>
                <td><?php
					if($c['contactat_de_broker_id']> 0) {
                        echo 'Rezervata in data de ' . ro_date($c['contactat_de_broker_pe']) .'<br> de ' . $users[$c['contactat_de_broker_id']]['full_name'].'<br>';
					}
                    if(is_numeric($c['vanzator_asociat']) and $c['vanzator_asociat']>0){
                        echo '<a href="'.ROOT.'add_afacere/?edit='.$c['vanzator_asociat'].'">Vanzarea creata : <strong>' . $vanzari[$c['vanzator_asociat']]['denumire'] . '</strong></a> ';
                    }
                    if(is_numeric($c['cumparator_asociat']) and $c['cumparator_asociat']>0){
                        echo '<a href="/cumparatori/add_cumparator.php?edit='.$c['cumparator_asociat'].'"> Cumparator creat :  <strong>' . $cumparatori[$c['cumparator_asociat']]['full_name'] . '</strong></a>';
                    }
					?>
                    <a href="./edit.php?id=<?=h($id);?>"><i class="circular yellow edit outline icon"></i></a>
                </td>
				<td id="raspuns_forma_contact_<?=$id?>">
                    <?php if($c['contactat_de_broker_id'] == 0) { ?>
                        <p onmousedown="rezerva(<?=$id?>)"><i class="bullseye yellow icon"></i> rezerva</p>
                        <p ></p>
                    <?php }  else {
                        //echo 'Rezervata in data de ' . ro_date($c['contactat_de_broker_pe']) .'<br> de ' . $users[$c['contactat_de_broker_id']]['full_name'].'<br>';
						if($c['vanzator_asociat'] == 0 and $c['cumparator_asociat']==0){ ?>
                          <a class="ui purple basic " onmousedown="add_afacere('1',<?=$id?>);" style="cursor: pointer;"><i class="circular purple tag icon"></i> Adauga afacere</a><br>
                          <a class="ui olive basic " onclick="add_cumparator(<?=$id?>)" style="cursor: pointer;"><i class="circular olive dollar icon"></i> Adauga cumparator</a><br>
                          
                          
                           
                           <!-- <button class="ui purple basic button" onmousedown="add_afacere('1',<?=$id?>);">Adauga afacere</button>
                            <button class="ui olive basic button" onclick="add_cumparator(<?=$id?>)">Adauga cumparator</button>-->

                        <?php }
						if($is_admin){ ?><a class="ui red basic " onclick="dell_jobs_cumparator(<?=$id?>)" style="cursor: pointer;"><i class="circular red eraser icon"></i> Sterge cerere</a><?php }
                    } ?>
                </td>
            </tr>
            <tr class="positive mesaje_detaliate vfx hidden">
                <td colspan="8">
                    <?=($c['tel']?'Tel: '.h($c['tel']).$spacer:'');?>
                    <?=($c['et_pb_contact_email_1']?'E-mail: '.h($c['et_pb_contact_email_1']).$spacer:'');?>
                    <?=($c['oras'] || $c['judet']?'Adresa: ':'');?>
                    <?=($c['oras']?h($c['oras']):'');?>
                    <?=($c['oras'] && $c['judet'] ?', ':'');?>
                    <?=($c['judet']?h($c['judet']):'');?>
                    <?=($c['oras'] || $c['judet']?$spacer:'');?>
                    <?=($c['et_pb_contact_message_1']?'<br><p><strong>MESAJ:</strong> '.h($c['et_pb_contact_message_1']).'</p>':'');?>

                </td>
                

            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="7"></th>
            <th><em><?php echo 'Pag '.$page_details['curent_page'].'/'.$page_details['nb_pages'].' ('.$page_details['total_results'].' rezultate)'; ?></em></th>
        </tr>
        </tfoot>
    </table>
<?php }
