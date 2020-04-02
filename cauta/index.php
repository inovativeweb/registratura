<?php require ('../config.php');


require_login();

$where_sql="";
$tabel='vanzare';

$vanzare = (tableFieldsListWildcard($tabel,'','',array('idv')));
$cumparatori = (tableFieldsListWildcard('cumparatori','','',array('idc')));
$companie = (tableFieldsListWildcard('companie','','',array('id_companie')));
$loc = (tableFieldsListWildcard('localizare_localitati','','',array('id')));
$jud = (tableFieldsListWildcard('localizare_judete','','',array('id')));
$thf_users = (tableFieldsListWildcard('thf_users','','',array('id')));
//search in all fields
$concatWs = " CONCAT_WS(' ', ".$vanzare .', '.$companie .', '.$jud .', '.$thf_users .', '.$loc." ) ";
$concatWs2 = " CONCAT_WS(' ', ".$cumparatori .', '.$jud .', '.$loc." ) ";
$concatWs3 = " CONCAT_WS(' ', ".$thf_users .', '.$jud .', '.$loc." ) ";



if(isset($_REQUEST['q'])  and $_REQUEST['q'] and strlen(trim($_REQUEST['q']))){
    foreach(explode(' ',$_REQUEST['q']) as $word){
        if(strlen($word)>0){$search_words[] = $word;  }
    }
}
foreach($search_words as $word){
    $search_sql.=($search_sql?" AND ":"").( $concatWs."LIKE '%".q($word)."%'   " );
    $search_sql2.=($search_sql2?" AND ":"").( $concatWs2."LIKE '%".q($word)."%'   " );
    $search_sql3.=($search_sql3?" AND ":"").( $concatWs3."LIKE '%".q($word)."%'   " );
}
$search_sql=($search_sql?" ( \r\n $search_sql \r\n ) ":"");
$search_sql2=($search_sql2?" ( \r\n $search_sql2 \r\n ) ":"");
$search_sql3=($search_sql3?" ( \r\n $search_sql3 \r\n ) ":"");







$where_sql.=($where_sql?"\r\r AND " :"").$search_sql;
$where_sql2.=($where_sql2?"\r\r AND " :"").$search_sql2;
$where_sql3.=($where_sql3?"\r\r AND " :"").$search_sql3;

$where_sql=($where_sql             ?        "\r\n WHERE ".$where_sql ." "       :   " WHERE   1 ");
$where_sql2=($where_sql2             ?        "\r\n WHERE ".$where_sql2 ." "       :   " WHERE   1 ");
$where_sql3=($where_sql3             ?        "\r\n WHERE ".$where_sql3 ." "       :   " WHERE   1 ");


  $sql = "
          SELECT * FROM `vanzare` 
        LEFT JOIN companie  on companie_vanzare = companie.id_companie
        LEFT JOIN localizare_localitati ON companie.localitate_id = localizare_localitati.`id`
        LEFT JOIN localizare_judete on companie.judet_id = localizare_judete.`id`
        LEFT JOIN thf_users  ON vanzare.reprezentant_vanzare = thf_users.`id`
        $where_sql
";

  $sql2 = "
  SELECT * FROM `cumparatori`
      LEFT JOIN localizare_localitati ON cumparatori.localitate_id = localizare_localitati.`id`
        LEFT JOIN localizare_judete on cumparatori.judet_id = localizare_judete.`id`
       
        $where_sql2
  ";
$sql3 = "
  SELECT thf_users.*,localizare_localitati.localitate,localizare_judete.nume_judet FROM `thf_users`
      LEFT JOIN localizare_localitati ON thf_users.localitate_id = localizare_localitati.`id`
        LEFT JOIN localizare_judete on thf_users.judet_id = localizare_judete.`id`
        $where_sql3
  ";
        $data=multiple_query($sql);
            foreach ($data as $k=>$val){
                if(!has_right($val['idv'],'vanzare')){ unset($data[$k]); }
            }
         $data2=multiple_query($sql2);
            foreach ($data2 as $k=>$val){
                if(!has_right($val['idc'],'cumparator')){ unset($data2[$k]); }
            }
         $data3=multiple_query($sql3);
            foreach ($data3 as $k=>$val){
                if(!in_array($val['id'],return_users_agentie($user_id_login))){ unset($data3[$k]); }
            }
?>
    <div class="ui horizontal divided list">
        <div class="item">
            <i class="circular purple tag icon"></i>
            <div class="content">
                <div class="header">Afaceri de vanzare</div>
                <p><?=count($data)?>&nbsp;rezultate</p>
            </div>
        </div>
    </div>
        <div class="ui link list"><?php
                foreach ($data as $k=>$d){
                            echo '<a href="'.ROOT.'add_afacere/?edit='.$d['idv'].'" target="_blank" class="item"><strong>'.$d['denumire'].' </strong> '.$d['nume_judet'].' '.$d['localitate'].' '.$d['full_name'].' '.'</a>';
                } ?>
        </div>

    <div class="ui horizontal divided list">
        <div class="item">
            <i class="circular olive dollar icon"></i>
            <div class="content">
                <div class="header">Cumparatori</div>
                <p><?=count($data2)?>&nbsp;rezultate</p>
            </div>
        </div>
    </div>
    <div class="ui link list"><?php
        foreach ($data2 as $k=>$d){
            echo '<a href="'.ROOT.'cumparatori/add_cumparator.php?edit='.$d['idc'].'" target="_blank" class="item"><strong>'.$d['full_name'].' </strong> '.$d['nume_judet'].' '.$d['localitate'].' '.' '.'</a>';
        } ?>
    </div>

    <div class="ui horizontal divided list">
        <div class="item">
            <i class="circular brown user secret icon"></i>
            <div class="content">
                <div class="header">Business brockeri</div>
                <p><?=count($data3)?>&nbsp;rezultate</p>
            </div>
        </div>
    </div>
    <div class="ui link list"><?php
        foreach ($data3 as $k=>$d){
            echo '<a href="'.ROOT.'useri/user_edit.php?edit='.$d['id'].'" target="_blank" class="item"><strong>'.$d['full_name'].' </strong> '.$d['nume_judet'].' '.$d['localitate'].' '.' '.'</a>';
        } ?>
    </div>
        <?php

//prea($data);

