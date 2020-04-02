<?php
require ('../config.php');
// Atentie: Partea de generare hash trebuie sa fie privata
// Pentru apelarea metodelor pe mediul de test, trebuie sa va inregistrati user de API pe platforma de test http://testapp.fgo.ro


$SecretKey = "D407EC42E29D1ED45718081CCA44FF3E";
$codUnic = "40582668";
$idf = $_REQUEST['idf'];

if(isset($_GET['stergere_fgo'])) {
    $url = 'https://api.fgo.ro/v1/factura/stergere';
    $numar_fact = $_REQUEST['numar'];
    $serie_fact = $_REQUEST['serie'];
    $hash = strtoupper(SHA1($codUnic . $SecretKey . $numar_fact));
    $data_send = array(
        'CodUnic' => $codUnic,
        'Hash' => $hash,
        'Numar' => $numar_fact,
        'Serie' => $serie_fact,

    );
}
if(isset($_GET['generare_fgo'])) {

    $judete_fgo = "{\"Success\":true,\"List\":[{\"Nume\":\"Gorj\",\"Cod\":\"GJ\"},{\"Nume\":\"Salaj\",\"Cod\":\"SJ\"},{\"Nume\":\"Calarasi\",\"Cod\":\"CL\"},{\"Nume\":\"Timis\",\"Cod\":\"TM\"},{\"Nume\":\"Arad\",\"Cod\":\"AR\"},{\"Nume\":\"Bihor\",\"Cod\":\"BH\"},{\"Nume\":\"Buzau\",\"Cod\":\"BZ\"},{\"Nume\":\"Suceava\",\"Cod\":\"SV\"},{\"Nume\":\"Maramures\",\"Cod\":\"MM\"},{\"Nume\":\"Teleorman\",\"Cod\":\"TR\"},{\"Nume\":\"Brasov\",\"Cod\":\"BV\"},{\"Nume\":\"Ilfov\",\"Cod\":\"IF\"},{\"Nume\":\"Arges\",\"Cod\":\"AG\"},{\"Nume\":\"Bucuresti\",\"Cod\":\"B\"},{\"Nume\":\"Mures\",\"Cod\":\"MS\"},{\"Nume\":\"Neamt\",\"Cod\":\"NT\"},{\"Nume\":\"Harghita\",\"Cod\":\"HR\"},{\"Nume\":\"Prahova\",\"Cod\":\"PH\"},{\"Nume\":\"Galati\",\"Cod\":\"GL\"},{\"Nume\":\"Bacau\",\"Cod\":\"BC\"},{\"Nume\":\"Giurgiu\",\"Cod\":\"GR\"},{\"Nume\":\"Hunedoara\",\"Cod\":\"HD\"},{\"Nume\":\"Bistrita-Nasaud\",\"Cod\":\"BN\"},{\"Nume\":\"Constanta\",\"Cod\":\"CT\"},{\"Nume\":\"Botosani\",\"Cod\":\"BT\"},{\"Nume\":\"Alba\",\"Cod\":\"AB\"},{\"Nume\":\"Valcea\",\"Cod\":\"VL\"},{\"Nume\":\"Dolj\",\"Cod\":\"DJ\"},{\"Nume\":\"Vaslui\",\"Cod\":\"VS\"},{\"Nume\":\"Satu Mare\",\"Cod\":\"SM\"},{\"Nume\":\"Olt\",\"Cod\":\"OT\"},{\"Nume\":\"Sibiu\",\"Cod\":\"SB\"},{\"Nume\":\"Caras-Severin\",\"Cod\":\"CS\"},{\"Nume\":\"Mehedinti\",\"Cod\":\"MH\"},{\"Nume\":\"Tulcea\",\"Cod\":\"TL\"},{\"Nume\":\"Ialomita\",\"Cod\":\"IL\"},{\"Nume\":\"Vrancea\",\"Cod\":\"VN\"},{\"Nume\":\"Braila\",\"Cod\":\"BR\"},{\"Nume\":\"Cluj\",\"Cod\":\"CJ\"},{\"Nume\":\"Dambovita\",\"Cod\":\"DB\"},{\"Nume\":\"Covasna\",\"Cod\":\"CV\"},{\"Nume\":\"Iasi\",\"Cod\":\"IS\"}]}";
    $judete_fgo = (json_decode($judete_fgo, true)['List']);
    foreach ($judete_fgo as $k => $j) {
        $judete_fgo_key[$j['Nume']] = $j['Cod'];
    }


    $url = 'https://api.fgo.ro/v1/factura/emitere';

    $promovari = multiple_query("SELECT * FROM `thf_facturi`
    LEFT JOIN thf_users on thf_users.id = thf_facturi.uid
    ORDER BY idf DESC", 'idf');
    $data = $promovari[$idf];
//prea($data);
    if ($data['id_asociatie'] > 0) {
        $tmp = many_query("SELECT * FROM `asociatii` WHERE id = '" . $data['id_asociatie'] . "' ");
        $client['denumire'] = $tmp['nume_asociatie'];
        $client['cui'] = $tmp['cui_asociatie'];
        $client['reg_com'] = $tmp['reg_com_asociatie'];
        $client['adresa'] = $tmp['adresa_asociatie'];
        $client['banca'] = $tmp['banca_asociatie'];
        $client['iban'] = $tmp['cont_iban_asociatie'];
        $client['judet'] = $judete[$tmp['judet_id']];
        $client['localitate'] = $localitati[$tmp['localitate_id']];
    } else {
        $tmp = many_query("SELECT * FROM `companie` WHERE id_companie = '" . $data['id_companie_user'] . "' ");
        $client['denumire'] = $tmp['denumire'];
        $client['cui'] = $tmp['cui'];
        $client['reg_com'] = $tmp['reg_com'];
        $client['adresa'] = $tmp['adresa'];
        $client['banca'] = $tmp['banca'];
        $client['iban'] = $tmp['cont_iban'];
        $client['judet'] = $judete[$tmp['judet_id']];
        $client['localitate'] = $localitati[$tmp['localitate_id']];
    }
//------------------------------------------------------------------------------


    $clientDenumire = $client['denumire'];
    $hash = strtoupper(SHA1($codUnic . $SecretKey . $clientDenumire));
//------------------------------------------------------------------------------

    $data_send = array(
        'CodUnic' => $codUnic,
        'Hash' => $hash,
        'Client[Denumire]' => $clientDenumire,
        'Client[CodUnic]' => $client['cui'],
        'Client[Tip]' => 'PJ',
        'Client[NrRegCom]' => $client['reg_com'],
        'Client[Judet]' => $judete_fgo_key[$client['judet']],
        'Client[Adresa]' => $client['localitate'] . ', ' . $client['adresa'],
        'Text' => '',
        'Explicatii' => 'Explicatii factura',
        'Valuta' => 'RON',
        'TipFactura' => 'Factura',
    );

    $repere = json_decode($data['repere'], true);
    $cereri_promovare_aprobate = multiple_query("SELECT * FROM `promovari_active` WHERE idv='" . $data['idvf'] . "' ", 'idp');
//  prea($data); die;
    $i = 0;
    foreach ($repere as $idp => $reper) {
        $data_send['Continut[' . $i . '][Denumire]'] = $reper['denumire'] . ' (Valabil pana in date de: ' . date('d-m-Y', strtotime($cereri_promovare_aprobate[$idp]['valabilitate'])) . ')';
        $data_send['Continut[' . $i . '][PretUnitar]'] = $reper['pret_unitar'];
        $data_send['Continut[' . $i . '][UM]'] = 'Buc';
        $data_send['Continut[' . $i . '][NrProduse]'] = $reper['cantitatea'];
        $data_send['Continut[' . $i . '][CotaTVA]'] = 0;
        //  prea($reper);
        $i++;
    }

}


        //prea($data_send); die;
// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data_send)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

$rasp = json_decode($result,true);
if(isset($_GET['generare_fgo'])) {
    if ($rasp['Success'] == 1) {
        update_query("UPDATE `thf_facturi` SET `link_factura` = '" . q($rasp['Factura']['Link']) . "', `nr_factura` = '" . q($rasp['Factura']['Numar']) . "', `serie_factura` = '" . q($rasp['Factura']['Serie']) . "' WHERE `thf_facturi`.`idf` = '" . floor($idf) . "' ");
    }
}

if(isset($_GET['stergere_fgo'])) {
    if ($rasp['Success'] == 1) {
        update_query("UPDATE `thf_facturi` SET `link_factura` = '', `nr_factura` = '0', `serie_factura` = '' WHERE `thf_facturi`.`idf` = '" . floor($idf) . "' ");
    }
}
header('Content-Type: application/json');
echo json_encode($rasp);