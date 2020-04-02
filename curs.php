<?php
require_once('./config.php');
$page_head=array(
	'meta_title'=>'Curs valutar',
	'trail'=>'configurare|curs'

	);
index_head();
//http://openapi.ro/api/exchange/all.json?date=2016-04-02
//prea(json_decode(file_get_contents('http://openapi.ro/api/exchange/all.json'),true));
echo '<div align="right"><a href="/curs_edit.php" class="btn btn-success iframe">Adauga Curs Valutar</a></div><br />';


$rows=multiple_query("SELECT * FROM `curs` ORDER BY `data_curs` DESC, `moneda_curs` ASC");
// table table-striped table-hover table-condensed table-responsive
echo '<table class="table table-striped table-hover table-responsive">
  <tr class="info">
    <th scope="col">Data</th>
    <th scope="col">Moneda</th>
    <th scope="col">Valoare</th>
    <th scope="col">Curs referinta</th>
  </tr>
';
foreach($rows as $row){	
	echo '<tr class="genSelTlist iframe" href="/curs_edit.php?edit='.$row['id_curs'].'">';
	echo '<td>'.h($row['data_curs']).'</td>';
	echo '<td>'.h($row['moneda_curs']).'</td>';
	echo '<td>1 RON = '.h($row['valoare_curs'].' '.$row['moneda_curs']).'</td>';
	echo '<td>1 RON = '.h($row['curs_ref'].' '.$row['moneda_curs']).'</td>';
	echo '</tr>'."\r\n";	
	}
echo '</table>';


//index_footer();
?>