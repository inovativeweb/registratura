<?php 
function list_companii($rows){ global $judete,$localitati;
 echo '<table class="table table-striped  single line table-hover table-responsive ui orange  table  THFsortable">
  <tr class="">
	<th scope="col">ID</th> 
    <th scope="col">Denumire</th>
	<th scope="col">Adresa</th>
    <th scope="col">Judet</th>  
    <th>Oras</th>
    <th scope="col">Telefon</th>
    <th scope="col">Email</th>
  </tr>';
	
$total = 0;
foreach($rows as $row){
  //  prea($row);
    $link = 'onClick="window.location='."'/companii/companie_edit.php?edit=$row[id_companie]'".';"';
    echo '<tr class="genSelTlist" row="'.$row['id_companie'].'">';
    echo '<td '.$link.'>'.h($row['id_companie']).'</td>';
    echo '<td '.$link.'>'.h($row['denumire']).'</td>';
      echo '<td  '.$link.'>' . h($row['adresa']) . '</td>';
        echo '<td  '.$link.'>' . $judete[$row['judet_id']] . '</td>';
        echo '<td  '.$link.'>' . $localitati[$row['localitate_id']] . '</td>';
        echo '<td  '.$link.'>' . h($row['tel']) . '</td>';
        echo '<td  '.$link.'>' . h($row['email']) . '</td>';
        echo '<td ><a href="#" onclick="delete_companie('.$row['id_companie'].')" title="Sterge"><i  class="circular trash alternate orange icon"></i></a></td>';
      
     ?>

    <?php echo '</tr>'."\r\n";

}
echo '</table>';
}


