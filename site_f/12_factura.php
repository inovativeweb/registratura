<?php


function factura ($idf,$proforma=false,$save_pdf=true){  global $promovari,$promovari_db,$user_login,$judete,$localitati;
ob_start();
   
    $promovari  = multiple_query("SELECT * FROM `thf_facturi`

 LEFT JOIN thf_users on thf_users.id = thf_facturi.uid

ORDER BY idf DESC",'idf');
    $data = $promovari[$idf];

    if($data['id_asociatie'] > 0){
        $tmp = many_query("SELECT * FROM `asociatii` WHERE id = '".$data['id_asociatie']."' ");
        $client['denumire'] = $tmp['nume_asociatie'];
        $client['cui'] = $tmp['cui_asociatie'];
        $client['reg_com'] = $tmp['reg_com_asociatie'];
        $client['adresa'] = $tmp['adresa_asociatie'];
        $client['banca'] = $tmp['banca_asociatie'];
        $client['iban'] = $tmp['cont_iban_asociatie'];
        $client['judet'] = $judete[$tmp['judet_id']];
        $client['localitate'] = $localitati[$tmp['localitate_id']];
    } else {
        $tmp = many_query("SELECT * FROM `companie` WHERE id_companie = '". $data['id_companie_user']."' ");
        $client['denumire'] = $tmp['denumire'];
        $client['cui'] = $tmp['cui'];
        $client['reg_com'] = $tmp['reg_com'];
        $client['adresa'] = $tmp['adresa'];
        $client['banca'] = $tmp['banca'];
        $client['iban'] = $tmp['cont_iban'];
        $client['judet'] = $judete[$tmp['judet_id']];
        $client['localitate'] = $localitati[$tmp['localitate_id']];
    }


?>
<table width="100%" height="500" border="0" align="center" cellpadding="5" cellspacing="2">
    <tr>
        <td><!-- FURNIZOR-->
            <table width="351" border="0" align="left" cellpadding="1" cellspacing="1">

                <tr>
                    <td  colspan="2"><strong>Furnizor :  </strong> <h3>Business Escrow SRL</h3>

                    </td>
                </tr>

                <tr>
                    <td colspan="2"><span >C.I.F.: 37445849<br>Reg.Com.: J08/941/2017
                            </span></td>
                </tr>
                <tr>
                    <td colspan="2"><span>Localitatea: Brasov<br>Judet: Brasov<br>Mihail Kogălniceanu Nr. 18-20
                            <?php echo $cui_f; ?> <?php echo $nrc_f; ?>
                            </span></td>
                </tr>
                <tr>
                    <td colspan="2"><span>ING Bank<br>RO48INGB0XXXXXXXXXXXXXXXXXXXXXXX
                            </span></td>
                </tr>





            </table>
        </td>
        <td><!-- NUMAR FACTURA-->
            <table width="200" border="0"  style=""  align="center" cellpadding="5" cellspacing="1"  class="table_border2">
                <tbody>
                <tr>
                    <td>
                        <img style="width: 200px" src="<?php echo 'https://trade-x.ro/wp-content/uploads/2017/12/Logo_Business_Escrow.png' ?>" alt="logo" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" >
                            <tbody>


                            <tr>
                                <td colspan="2"><div align="center"><h2 class="style1"><?php if($proforma){ echo 'PROFORMA';} else {echo 'FACTURA';}?></h2></div></td>
                            </tr>
                            <tr>
                                <td><div align="left">Seria :</div></td>
                                <td><div align="left"> <strong>TRDX</strong></div></td>
                            </tr>
                            <tr>
                                <td><div align="left">Nr.: </div></td>
                                <td><div align="left"><strong> <?php

                                            //   prea($data); die;

                                           echo $data['idf'] ;

                                            ?>

                                        </strong></div></td>
                            </tr>
                            <tr>
                                <td><div align="left">Data :</div></td>
                                <td><div align="left"> <strong><?php echo  date("d-m-Y", strtotime($data['data']));?></strong></div></td>
                            </tr>
                            <tr>
                                <td valign="top"><div align="right"></div></td>
                                <td><div align="left"><strong>
                                        </strong></div></td>
                            </tr>
                            <tr>
                                <td valign="top"><div align="right"></div></td>
                                <td><div align="left"><strong></strong></div></td>
                            </tr>


                            </tbody></table></td>
                </tr>
                </tbody></table>
        </td>
        <td> <!-- CLIENT-->

            <table width="351" border="0" align="left" cellpadding="1" cellspacing="1" style="padding-left:25px" >
                <tr>
                    <td colspan="2"><strong>Cumparator: </strong><h3><?php echo $client['denumire']?></h3></td>
                </tr>


                <tr>
                    <td colspan="2"><span >C.I.F.: <?php echo $client['cui']?><br>Reg.Com.: <?php echo $client['reg_com']?></span></td>
                </tr>
                <tr>
                    <td colspan="2"><span><?php echo ''.'Adresa :'.$client['adresa'].'<br />'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td  colspan="2"><?=$client['banca'] .' '. $client['iban']?></td>
                </tr>
                <tr>
                    <td  colspan="2"><?=$client['localitate'] .', '. $client['judet']?></td>
                </tr>

            </table>
        </td>
    </tr>
</table>



<table width="100%" height="500" border="0" align="center" cellpadding="5" cellspacing="2" bgcolor="black">

    <tr class="">
        <td height="32" width="10%" bgcolor="#F8F8F8" ><div align="center"><strong>Nr.<br />crt.</strong></div></td>
        <td bgcolor="#F8F8F8" width="40%" ><div align="center"><strong>Denumirea produselor<br />sau a serviciilor </strong></div></td>
        <td bgcolor="#F8F8F8" width="10%"><div align="center"><strong>U.M.</strong></div></td>
        <td bgcolor="#F8F8F8" width="10%" ><div align="center"><strong>Cantitate</strong></div></td>
        <td bgcolor="#F8F8F8" width="10%"><div align="center"><strong>Pret unitar<br />(fara T.V.A.)</strong></div></td>
        <td bgcolor="#F8F8F8" width="10%"><div align="center"><strong>Valoarea</strong></div></td>
        <td bgcolor="#F8F8F8" width="10%"><div align="center"><strong>T.V.A.</strong></div></td>
    </tr>

    <?php
        $repere = json_decode($data['repere'],true);
  //  prea($data); die;
    foreach ($repere as $idp=>$reper){
        if($reper['cantitatea'] == 0){ continue;}
        ?>
        <tr>
            <td bgcolor="#FFFFFF"><div align="center" class="text_produse"><?php echo 1; ?></div></td>
            <td bgcolor="#FFFFFF"><div align="left" class="text_produse"><?php

          $parinteX = one_query("SELECT parinte FROM `promovari` WHERE idp = '".$reper['idp']."' ");
                    if($parinteX>0){
                        $parinte = $promovari_db[$parinteX]['nume_promovare'];
                    }

                   echo $parinte .' '. $reper['denumire'] . ' '?>
                </div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="center">BUC</div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="center"> <?=$reper['cantitatea']?> </div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="left"><?php echo h(round_decimal($reper['pret_unitar']),2)?></div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="right"> <?php echo h(round_decimal($reper['valoarea'] ),2)?></div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="right">0</div></td>
        </tr>
    <?php } ?>
    <?php if (strlen($data['linie2'])){?>
        <tr>
            <td bgcolor="#FFFFFF"><div align="center" class="text_produse"><?php echo 2; ?></div></td>
            <td bgcolor="#FFFFFF"><div align="left" class="text_produse"><?php  echo h($data['linie2'].' ');  ?>
                </div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="center">BUC</div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="center"> - 1 </div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="left"><?php echo h(round_decimal($data['valoare_linie2'],2))?></div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="right"> <?php echo h(round_decimal($data['valoare_linie2'],2))?></div></td>
            <td bgcolor="#FFFFFF" class="text_produse"><div align="right">0</div></td>
        </tr>
    <?php } ?>





    <tr>
        <td height="100%" valign="top" bgcolor="#FFFFFF">
            <input id="autocomplete_query" name="autocomplete_query" type="text" placeholder="Denumire produs/serviciu" >
            <div id="view_fixer_autocomplete">
                <div id="container_autocomplete_result_list"></div>
            </div>
        </td>
        <td bgcolor="#FFFFFF"><?php //prea($_SESSION); prea($dbf); ?></td>
        <td bgcolor="#FFFFFF" class="text_produse">&nbsp;</td>
        <td bgcolor="#FFFFFF" class="text_produse">&nbsp;</td>
        <td bgcolor="#FFFFFF" class="text_produse">&nbsp;</td>
        <td bgcolor="#FFFFFF" class="text_produse">&nbsp;</td>
        <td bgcolor="#FFFFFF" class="text_produse">&nbsp;</td>
    </tr>

    <tr>
        <td colspan="4" rowspan="2" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left">
                <tr>
                    <td class="table_border_r" width="31%" valign="top" style="background-image:url(stampila150.png); background-repeat:no-repeat">Semnatura si stampila furnizorului <br /><br />
                        <br /> <br /><br />

                        Intocmit de<br />                    CI: <br />
                    </td>


                    <td width="2%" valign="middle" >&nbsp;</td>
                    <td width="67%" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="0">
                            <tr>
                                <td>Date privind expeditia </td>
                            </tr>
                            <tr>
                                <td>Numele delegatului: Posta</td>
                            </tr>
                            <tr>
                                <td>Buletinul/cartea de identitate: -                        </td>
                            </tr>
                            <tr>
                                <td>eliberat(a) -</td>
                            </tr>
                            <tr>
                                <td>Mijlocul de transport nr. -</td>
                            </tr>
                            <tr>
                                <td>Expedierea s-a efectuat in prezenta noastra la</td>
                            </tr>
                            <tr>
                                <td>data de <?php echo date('d-m-Y'); ?> ora <?php echo date('H:i'); ?></td>
                            </tr>
                            <tr>
                                <td>Semnaturile:</td>
                            </tr>
                        </table></td>
                </tr>
            </table></td>
        <td height="43" bgcolor="#FFFFFF" align="center" ><strong>Total</strong></td>
        <td bgcolor="#FFFFFF" class="text_produse">
            <div align="right"><?php echo  round_decimal($data['valoarea'],2);?></div></td>
        <td bgcolor="#FFFFFF" class="text_produse">
            <div align="right"> <?php echo  0;?>




            </div></td>
    </tr>
    <tr>
        <td height="30" valign="top" bgcolor="#FFFFFF" align="center">Semnaturi<br>de primire:</td>
        <td  colspan="2"  valign="middle" bgcolor="#FFFFFF" ><div align="center" ><strong>Total de plata:<br />
                    <br />
                    <?php echo  round_decimal($data['valoarea']-$data['valoare_linie2'],2);?>&nbsp;lei</strong></div>
        </td>
    </tr>
</table>


<div align="right">www.trade-x.ro</div>


<?php
$html=ob_get_contents();
ob_end_clean();
return $html;
}


function generate_pdf($html,$title = NULL,$save_pdf = true,$idf){
    require_once(THF_PATH.'facturi/template_fisa.php');
  //  return $pdf_filename;
}