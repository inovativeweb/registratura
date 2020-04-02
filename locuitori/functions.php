<?php 
function list_locuitori($rows){  global $strazi;
  echo '<table class="table table-striped single line table-hover table-responsive ui green table  THFsortable">
  <tr class="">

    <th scope="col">ID</th> 
    <th scope="col">Nume Prenume</th> ';

        echo '<th scope="col">Telefon</th>
    <th scope="col">Email</th>  
    <th>Strada</th>
    <th scope="col">Adresa<br>Firma</th>';

	echo '</tr> ';
$total = 0;
foreach($rows as $row){
    //  prea($row);
    $link = 'onClick="window.location='."'/locuitori/locuitor_edit.php?edit=$row[idl]'".';"';
    echo '<tr class="genSelTlist" row="'.$row['idl'].'">';
    echo '<td '.$link.'>'.h($row['idl']).'</td>';
    echo '<td '.$link.'>'.h($row['fullname']).'</td>';
    echo '<td  '.$link.'>' . h($row['telefon']) . '</td>';
    echo '<td  '.$link.'>' . h($row['email']) . '</td>';
    echo '<td>';
    select_rolem('strada',$descriere='',$strazi,$row['id_strada'],$placeholder='',$echo_only_input=false,$extra=array());
    echo '<p style="color:green" id="raspuns_select_'.$row['idl'].'"></p>';
    echo '</td>';
    echo '<td  '.$link.'>' . h($row['adresa']) . '<br>'.h($row['date_firma']).'</td>';
    echo '<td><a href="#" onclick="delete_locuitor('.$row['idl'].')" title="Sterge"><i  class="circular trash alternate green icon"></i></a></td>';
    ?>

    <?php echo '</tr>'."\r\n";

}
echo '</table>';
}