<?php


function getMessage($text,$array){ //USED EVERYWHERE
    if(is_string($array)){$array = json_decode($array,true);}

    $array['nl']='<br />';//replace ###nl### with <br>
    foreach ($array as $key=>$value){
        $text = str_replace("###".$key."###",$value,$text);
    }
    return $text;
}


$key_template = array(
			'prestator_srl' =>$comp['denumire'] ,
			'prestator_cui' =>$comp['cui'] ,
			'prestator_adresa' => $comp['adresa'],
			'prestator_localitate' => $localitati[$comp['localitate_id']],
			'prestator_rg_com' =>$comp['reg_com'] ,
			'prestator_tel' => $comp['tel'],
			'prestator_cont_bancar' => $comp['cont_iban'],
			'prestator_la_banca' => $comp['banca'],
			'prestator_reprezentant_legal' => $prestator['full_name'],
			'prestator_reprezentant_email' => $prestator['mail'],
 			'beneficiar_srl' => $comp['denumire'],
			'beneficiar_cui' => $comp['cui'],
			'beneficiar_adresa' => $comp['adresa'],
			'beneficiar_localitate' => $localitati[$comp['localitate_id']],
			'beneficiar_rg_com' => $comp['reg_com'],
			'beneficiar_tel' => $comp['tel'],
			'beneficiar_cont_bancar' => $comp['cont_iban'],
			'beneficiar_la_banca' => $comp['banca'],
			'beneficiar_reprezentant_legal' => $vanzator['denumire'],
			'beneficiar_reprezentant_email' => $vanzator['email'],
			'asociatie_denumire' => $asociatii['nume_asociatie'],
			'asociatie_cui' => $asociatii['cui_asociatie'],
			'asociatie_reg_com' => $asociatii['reg_com_asociatie'],
			'asociatie_adresa' => $asociatii['adresa_asociatie'],
			'asociatie_localitate' =>$localitati[ $asociatii['localitate_id']],
			'asociatie_judet' =>$judete[ $asociatii['judet_id']],
			'asociatie_cont_iban' => $asociatii['cont_iban_asociatie'],
			'asociatie_banca' => $asociatii['banca_asociatie'],
			'asociatie_tel' => $asociatii['tel_asociatie'],
			'asociatie_email' => $asociatii['email_asociatie'],
			'asociatie_website' => $asociatii['website_asociatie'],
			'comision' => $vanzare['comision'],
			'denumire_afacere'=>$vanzare['denumire_afacere'],
			'cumparator_full_name' => $cumparator['full_name'],
			'cumparator_adresa' => $cumparator['adresa'],
			'cumparator_localitate' => $localitati[$cumparator['localitate_id']],
			'cumparator_judet' => $judete[$cumparator['judet_id']],
			'cumparator_tel' => $cumparator['tel'],
			'cumparator_email' => $cumparator['email'],
			'cumparator_ocupatie' => $cumparator['ocupatie'],
			
			
		);
	
	$text="  ###prestator_srl### , cu sediul în ###prestator_localitate###, Str. ###prestator_strada###, Nr. ###prestator_strada_nr###, având număr de ordine în Registrul Comerțului ###prestator_rg_com###, CUI ###prestator_cui###, cont bancar ###prestator_cont_bancar###, deschis la ###prestator_la_banca###, reprezentata legal  de ###prestator_reprezentant_legal### numita în continuare ";
//	echo $text=getMessage($text,$array);



function get_contract_template_values($id_doc){ //fara param pt toate
    if($id_doc==0){
        $key = multiple_query("SELECT * FROM `documente_propietati` WHERE 1 GROUP by cheie");
    } else {
        $key = multiple_query("SELECT * FROM `documente_propietati` WHERE id_doc = $id_doc ");
    }
    $key_template = array();
    foreach ($key as $k=>$jsonX){
        $json = json_decode($jsonX['json'],true);
        if(is_array($json)) {
            foreach ($json as $nume_camp => $valoare) {
                if ($id_doc==0) {
                    $key_template[$jsonX['cheie'] . '.' . $nume_camp] = $jsonX['cheie'] . '.' . $nume_camp;
                } else {
                    $key_template[$jsonX['cheie'] . '.' . $nume_camp] = $valoare;
                }
            }
        }
    }
    if($id_doc==0) {
        $key_template['document.nr_doc'] = 'document.nr_doc';
        $key_template['document.data_doc'] = 'document.data_doc';
    } else {
        $key = many_query("SELECT * FROM `documente` WHERE idd = $id_doc ");
        $key_template['document.nr_doc']=$key['nr_doc'];
        $key_template['document.data_doc']=$key['data_doc'];
    }
    return $key_template;

}




function contract_template($id_doc,$id_template)
{
global $localitati,$judete;
    $text = one_query("SELECT text FROM `template_contracte` WHERE id=$id_template");
    $key_template = get_contract_template_values($id_doc);
	return $text=getMessage($text,$key_template);

}

function contract($id_doc){
	$vanzare=many_query("SELECT * FROM `vanzare` WHERE `idv`='".q($id_doc)."'  LIMIT 1");
$data = $document;
$comp = many_query("SELECT * FROM companie WHERE id_companie = '" . $vanzare['companie_vanzare'] . "' ");

$repr = many_query("SELECT * FROM companie WHERE id_companie = '" . $vanzare['reprezentant_vanzare'] . "' ");
$loc_jud=many_query("select * from localizare_localitati ll left join 
			localizare_judete lj on ll.parinte=lj.id where ll.id='".$emitent['localitate_id']."' ");
			
	 ?>
    <p><span style="text-decoration: underline;">CONTRACT&nbsp; DE </span></p>
    <p><span style="text-decoration: underline;">PRESTARI SERVICII, ASISTENTA, CONSULTANTA SI INTERMEDIERE</span></p>
    <p><span style="text-decoration: underline;">Nr.&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; /_&nbsp;.&nbsp; .2018</span></p>
    <p>&nbsp;</p>
    <p>&nbsp; I.PARTILE CONTRACTULUI</p>
    <p>&nbsp;&nbsp;&nbsp; SC Business Escrow srl&nbsp;, cu sediul &icirc;n Brașov, Str. Mihail Kogălniceanu, Nr. 18-20, av&acirc;nd număr de ordine &icirc;n Registrul Comerțului J08/941/25.04.2017, CUI 37445849, cont bancar RO30BTRLRONCRT0393040401, deschis la Banca Transilvania, reprezentata legal&nbsp; de Dan Crivat numita &icirc;n continuare &rsquo;&rsquo;PRESTATOR&rsquo;&rsquo;, denumit in continuare &rdquo;AGENTIA&rdquo; sau &bdquo;<span style="text-decoration: underline;">AGENTIA ESCROW</span>&rsquo;&rsquo;.</p>
    <p>si</p>
    <p>SC <?php echo $comp['denumire'];  ?>, cu sediul &icirc;n <?php echo $comp['adresa'].' ,'.$loc_jud['localitate'].' '.$loc_jud['nume_judet'];  ?>, tel <?php echo $comp['tel'];  ?>, &icirc;nregistrată la Registrul Comerțului sub nr.<?php echo $comp['reg_com'];  ?>, cod unic de &icirc;nregistrare <?php echo $comp['cui'];  ?>, cont nr. <?php echo $$comp['cont'];  ?> deschis la <?php echo $comp['banca'];  ?>, reprezentata de <?php echo $repr['denumire'];  ?>, &icirc;n calitate de Administrator, numita &icirc;n continuare &ldquo;BENEFICIAR&rdquo;, denumit in continuare &rdquo;BENEFICIARUL&rdquo;</p>
    <p>In conformitate cu dispozițiile Codului Civil, &icirc;ncheiem prezenta &icirc;nțelegere, astfel după cum urmează:</p>
    <p>&nbsp;</p>
    <p>&nbsp; II. OBIECTUL CONTRACTULUI. DEFINITII</p>
    <p>Prin prezentul contract, AGENTIA ESCROWse angajează sa asiste, sa ofere consultanta, sa promoveze si sa identifice cumpărători, in vederea transferului Afacerii Beneficiarului la cel mai bun preț posibil si in condițiile cele mai avantajoase, așa cum aceasta este definita in prezentul articol.</p>
    <p>Afacerea, individualizata ca fiind &bdquo;<?php echo $vanzare['denumire_afacere'];  ?>&rdquo;, reprezintă o activitate economica independenta&nbsp; in cadrul patrimoniului Beneficiarului, reprezintă un fond de comerț care cuprinde, fără a se limita la: active corporale si necorporale (drept de proprietate imobiliar, drepturi de folosința, echipamente, stocuri, mărci &icirc;nregistrate, know-how, creanțe), pasive (datorii scadente sau nescadente), personal angajat si colaborări, clientela si servicii,&nbsp; etc.., activitate comerciala prezenta pe piața si căreia i se poate atribui o cifra de afaceri.</p>
    <p>Business Broker- In desfășurarea activităților sus-menționate Agenția va colabora cu agenți specializați (angajați sau colaboratori externi), care vor fi desemnați de comun acord cu Beneficiarul pentru gestionarea prezentului contract.</p>
    <p>Memorandumul de Informare reprezintă un centralizator al tuturor informațiilor despre Afacere care include, dar fără&nbsp; a se limita la: Descriere, Locație (amplasare, vad comercial, clienți), Viziune, Strategie, Operațiuni, Produs/serviciu, Mediul de piață, Planuri și proiecții viitoare, Informații financiare, Prețul, Posibila finanțare si alte informații particulare Afacerii care ar putea atrage un Cumpărător.</p>
    <p>Teaser-ulreprezintă o sinteza realizata din Memorandumul de Informare cu scopul precis de a mediatiza Afacerea Beneficiarului, fără a dezvălui identitatea Afaceri sau a acestuia.</p>
    <p>Transfer al Afacerii&ndash; reprezintă operațiunea prin care in baza sumei agreate de Beneficiar, Afacerea acestuia, așa cum a fost definita anterior intra in patrimoniul unui Cumpărător, in termeni si condițiile agreate de ambele parți. Operațiunea se realizează prin intermediul AGENTIEI ESCROWcu un Cont Escrow pentru fiecare Transfer in parte.</p>
    <p>Acord de Confidențialitate reprezintă convenția parților potrivit căreia, pe toata durata raporturilor contractuale si după &icirc;ncetarea acestora, pentru o perioada de timp agreata, sa nu transmită date sau informații de care au luat cunoștința in timpul executării contractului, in condițiile stabilite expres au implicit in baza legii.</p>
    <p>&nbsp;</p>
    <p>&nbsp; III.DURATA CONTRACTULUI</p>
    <p>Contractul intra &icirc;n vigoare la data semnării lui de către ambele parți si este valabil pe o perioada de 9 luni de la data semnări acestuia.</p>
    <p>In situația in care obiectivul contractului, respectiv transferul Afacerii nu se realizează in intervalul de timp stabilit, contractul &icirc;ncetează in condițiile art.XI de mai jos, fără a avea &icirc;nsă vreun efect asupra obligațiilor deja scadente &icirc;ntre parți, cu excepția situației in care p&acirc;rțile &icirc;l prelungesc prin Act Adițional.&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp; IV. PLATA SI MODALITATI DE PLATĂ A PRETULUI CONTRACTUAL</p>
    <p>&nbsp;Pentru serviciile prestate, Agenția va incasa un comision stabilit de comun acord cu Beneficiarul, astfel:</p>
    <p>&nbsp;1) suma de _____ RON va fi achitata cu titlul de avans si reprezenta comisionul aferent ETAPA I&nbsp; A COLABORARII &ndash; Pregătirea Afacerii- , identificata in prezentul Contract la art.VI, pct. 1-1prestator_ Acest comision se achita in procent de 50% la semnarea contractului iar diferența odată cu &icirc;ncheierea Etapei I Pregătirea Afacerii, identificata in prezentul Contract la art.VI pct. 1-11</p>
    <p>&nbsp;2) un comision de succesin cuantum de ___% din Prețul agreat si plătit de către Cumpărător, care va fi datorat de Beneficiar in situația transferului si &icirc;ncheierii efective a Contractului de V&acirc;nzare Cumpărare a Afacerii cu un client gestionat de către Agenție, <span style="text-decoration: underline;">comisionul fiind aferent </span><span style="text-decoration: underline;">ETAPEI II A COLABORARII &ndash; Asistarea Personalizata a Beneficiarului de către un Business a Broker</span><span style="text-decoration: underline;">, identificata in prezentul Contract la art.VI pct.12-19.</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;3)&nbsp; un comision de succesin cuantum de ___% din Prețul agreat si plătit de către un Cumpărător, care va fi datorat de Beneficiar in situația transferului si &icirc;ncheierii efective a Contractului de V&acirc;nzare Cumpărare a Afacerii cu un client gestionat de către Agenție comisionul fiind aferent ETAPEI III TRANSFERUL AFACERII, identificata in prezentul Contract la art.VI pct.20-24.</p>
    <p>Pentru oricare dintre comisioanele sus-menționate, plata se face in baza unei Facturi emise de către Agenție. Plata contravalorii facturii se va face &icirc;n termen de 10 zile calendaristice de la facturare.</p>
    <p>Neexecutarea obligației de plata a comisionului asumata de către Beneficiar potrivit prezentului contract atrage obligația acestuia de a plăti penalități &icirc;n cuantum de 0,5%pe zi de &icirc;nt&acirc;rziere. Cuantumul total al penalităților nu este limitat la valoarea comisionului scadent.</p>
    <p>&nbsp;</p>
    <p>&nbsp; V. DERULAREA CONTRACTULUI SI OBLIGATIILE PARTILOR</p>
    <p><span style="text-decoration: underline;">Obligațiile AGENTIEI</span></p>
    <p>Agenția este obligata sa respecte toate obligațiile contractuale care &icirc;i incumbă şi care sunt detaliate &icirc;n prezentul contract.</p>
    <p>Agenția&nbsp; &icirc;și va &icirc;ndeplini obligațiile contractuale, in vederea realizării obiectului contractului, cu diligenta unui bun profesionist.</p>
    <p>Atribuțiile Agenției in relația cu Beneficiarul sunt următoarele, realiz&acirc;nd-se in etape distincte, după cum urmează:</p>
    <p>&nbsp;</p>
    <p>ETAPA I&nbsp; A COLABORARII &ndash; Pregătirea Afacerii</p>
    <p>1) Identifica Afacerea Beneficiarului și face demersurile necesare pregătirii acesteia pentru procesul de transfer și contactul cu un potențial Cumpărător.</p>
    <p>2 ) Asista si &icirc;ndruma&nbsp; Beneficiarul pe parcursul&nbsp; &icirc;ntregului proces de transfer al Afacerii și recomanda soluții de &icirc;mbunătățire a acesteia.</p>
    <p>&nbsp;3) Pregătește &icirc;mpreuna cu Beneficiarul documentele necesare transferului Afacerii. In acest sens prezinta Beneficiarului un chestionar de prezentare a Afacerii și alte formulare de evaluare a Afacerii care sunt necesare operațiunii de evaluare si transfer a acesteia.</p>
    <p>4) Pe baza informaților obținute de la Beneficiar, elaborează un Memorandum de Informare (MI) care cuprinde informații realiste despre Afacere, document care urmează a fi pus la dispoziția potențialilor cumpărători.</p>
    <p>5) Creează un Centralizator cu informațiile financiare generale ale Afacerii.</p>
    <p>6) Pregătește &icirc;mpreuna cu Beneficiarul Anexele Contractului de V&acirc;nzare/Cumpărare cu privire la:</p>
    <p>&nbsp; a) Autorizații, Avize, Aprobări necesare pentru funcționare</p>
    <p>&nbsp; b) Totalul creanțelor / Lista completă a datoriilor</p>
    <p>&nbsp; c) Lista furnizorilor de utilități necesare funcționarii</p>
    <p>&nbsp; c) Lista salariaților cu identificarea postului, atribuțiilor, retribuiții, modul de &icirc;ncadrare etc</p>
    <p>&nbsp; d) Inventarul Mijloacelor Fixe (Active Corporale) și Materiile Prime</p>
    <p>&nbsp; e) Valorile Imobiliare și/sau Contractele de &Icirc;nchiriere</p>
    <p>&nbsp; f) Orice alte informații in funcție de particularitățile Afacerii</p>
    <p>7) Atunci c&acirc;nd este nevoie și Beneficiarul solicita sau aproba la sugestia Agentului (după caz), va sugera profesioniști necesari: analiști financiari, contabili, avocați, agenți imobiliari, firme și persoane specializate &icirc;n toate domeniile de consultanță necesare. Aceștia vor negocia condițiile de colaborare, inclusiv retribuirea lor, direct cu Beneficiarul care va fi asistat de Agent.</p>
    <p>8) Consiliază Beneficiarul si realizează &icirc;mpreuna cu acesta o evaluare a prețului de v&acirc;nzare al Afacerii. Dacă este nevoie sau cerut de Beneficiar, se poate apela la serviciile unui expert evaluator specialitatea evaluări societăți comerciale. Acesta va negocia condițiile de colaborare, inclusiv retribuirea lor, direct cu Beneficiarul care va fi asistat de Agent.</p>
    <p>9) Asistă Beneficiarul, dacă acesta o dorește, &icirc;n procesul de precalificare a Afacerii la o posibilă finanțare cu o unitate bancara in vederea creșterii vandabilității Afacerii prin identificarea mai facila a unui cumpărător.</p>
    <p>10) Pornind de la varianta extinsă a Memorandum de Informare (MI), elaborează o varianta concise/sintetica&nbsp; denumita Teaser,&nbsp; care va fi promovata/mediatizată in vederea identificării unui potențial cumpărător.</p>
    <p>11) Pregătește materialele de prezentare necesare ale Afacerii propuse spre v&acirc;nzare si se consulta cu Beneficiarul pentru aprobarea lor.</p>
    <p>&nbsp;</p>
    <p>ETAPA II A COLABORARII &ndash; Asistarea Personalizata a Beneficiarului de către un Business a Broker</p>
    <p>12) Afișează Afacerea spre v&acirc;nzare, pe site-ul de specialitate și alte metode necesare de promovare. Actualizează baza de date și platforma online de v&acirc;nzări de cate ori este nevoie.</p>
    <p>13) Prospectează piața pentru a identifica potențiali clienți. Se asigură că aceștia sunt preselectați astfel &icirc;nc&acirc;t să fie calificați din punct de vedere financiar pentru a cumpăra Afacerea.</p>
    <p>14) In situația in care un potențial cumpărător dorește mai multe informații despre Afacere, programează semnarea de către cumpărător a Acordului de Confidențialitate&nbsp; pentru primirea pachetului Memorandum de Informare (MI).</p>
    <p>15) Programează &icirc;nt&acirc;lnirile de prezentare a Afacerii. Asistă Beneficiarul (şi eventual echipa sa de specialiști) &icirc;n prezentarea Afacerii şi &icirc;n relația acestuia cu cumpărătorul.</p>
    <p>16) Prezinta Beneficiarului, potențialii cumpărători identificați și ofertele acestora. Asista Beneficiarul la selecția celei mai bune oferte.</p>
    <p>17) După selectarea cumpărătorului, asistă Beneficiarului (şi eventual echipa sa de specialiști) &icirc;n relația cu acesta şi &icirc;n procesul de Due-Dilligence al acestuia.</p>
    <p>&nbsp;18) Asistă Beneficiarul la negocierea condițiilor și a prețului.</p>
    <p>&nbsp;19) După &icirc;ncheierea negocierilor cu un acord &icirc;ntre cele doua părți, asistă V&acirc;nzătorul &icirc;n procesul de transfer efectiv al Afacerii prin Agenția Escrow p&acirc;nă la semnarea documentelor finale de v&acirc;nzare cumpărare.</p>
    <p>&nbsp;</p>
    <p>ETAPA III&nbsp; A COLABORARII &ndash; Transferul Afacerii</p>
    <p>20) Agenția Escrow va servi ca un deținător neutru de informații și documente, reprezent&acirc;nd link-ul de comunicații cu părțile implicate &icirc;n transfer și facilitează &icirc;nchiderea tranzacției, cu respectarea confidențialității asumate in mod expres.</p>
    <p>21) Asigură respectarea condițiilor stabilite de părți, pregătește documentele de transfer necesare, Antecontracte, Contacte si alte documente legale si/sau fiscale necesare, se ocupă de detaliile administrative necesare, termenii Contractului de v&acirc;nzare/cumpărare și toate condițiile tranzacției;</p>
    <p>22) Protejează at&acirc;t interesele Beneficiarului c&acirc;t și pe cele ale Cumpărătorului, scopul prestării de servicii fiind acela de transfer efectiv al Afacerii;</p>
    <p>23) Agenția elaborează Centralizatorul Financiar cu distribuirea fondurilor conform instrucțiunilor celor doua parți si aprobate de acestea.</p>
    <p>24) Agenția Escrow funcționează ca un intermediar si nu răspunde pentru realitatea si veridicitatea datelor si informațiilor privind Afacerea, puse la dispoziție de către beneficiar, care si le asuma in mod expres.&nbsp;</p>
    <p>&nbsp;</p>
    <p>Obligațiile BENEFICIARULUI</p>
    <p>Beneficiarul este obligat să respecte si sa &icirc;ndeplinească cu buna credința toate obligațiile care sunt detaliate in prezentul contract, precum si obligațiile care rezulta ca urmare a demersurilor normale efectuate de către PRESTATOR in &icirc;ndeplinirea obiectului contractual.</p>
    <p>Beneficiarului ii revin următoarele obligații principale, indiferent de Etapele colaborării, identificate anterior:</p>
    <p>Sa ofere la timp si complet toate informațiile, documentele si relațiile necesare solicitate de&nbsp; către Agent, in vederea pregătirii si promovării spre v&acirc;nzare a Afacerii, potrivit celor menționate in cuprinsul obligațiilor Agentului.</p>
    <p>Sa răspunde din punct de vedere legal de corectitudinea si realitatea datelor si informațiilor puse la dispoziția Agentului si terților in legătura cu Afacerea.</p>
    <p>Sa participe in mod activ si cu responsabilitate la &icirc;ntreaga procedura reglementata de prezentul contract,</p>
    <p>Sa respectare clauzele de exclusivitate si confidențialitate asumate in prezentul contract, precum si prin eventualele Acte Adiționale.</p>
    <p>Sa achite Agentului comisionul convenit, cu respectarea termenelor scadente precum si sa suporte eventualele cheltuieli generate de promovarea Afacerii, in condițiile stabilite in prealabil cu Agentul</p>
    <p>&nbsp;</p>
    <p>&nbsp;&nbsp; VI. RASPUNDERI</p>
    <p>Partea care provoacă prejudicii patrimoniale sau nepatrimoniale celeilalte p&acirc;rți este responsabilă pentru repararea integrală a acestor prejudicii. Agenția nu este răspunzătoare pentru acele &icirc;nt&acirc;rzieri, omiteri sau greșeli care au fost cauzate prin acțiuni sau omisiuni culpabile ale Beneficiarului.</p>
    <p>In situația in care Beneficiarul &icirc;nțelege sa &icirc;ncalce principiile bunei-credințe si folosindu-se de informațiile primite, de serviciile oferite si contactelor stabilite prin intermediul Agenției, &icirc;ncheie direct un Contract de V&acirc;nzare Cumpărare cu un cumpărător identificat in condițiile prezentului articol, va fi obligat sa achite comisionul convenit potrivit art. IV din prezentul contract.</p>
    <p>Obligația plații comisionului subzista si in situația in care Contractul de V&acirc;nzare Cumpărare &icirc;ncheiat in condițiile alin.2 din prezentul articol se realizează de către Beneficiar prin persoane interpuse, fizice sau juridice at&acirc;t in ceea ce &icirc;l privește pe el cat si in ceea ce &icirc;l privește pe Cumpărător.</p>
    <p>&nbsp;</p>
    <p>&nbsp;&nbsp; VII.&nbsp;CLAUZA DE CONFIDENTIALITATE</p>
    <p>In orice situație,&nbsp;Agenția păstrează confidențialitatea datelor culese pe parcursul derulării prezentului contract. Toate informațiile confidențiale sunt proprietatea Beneficiarului, iar Agenția nu are nici un drept, direct sau implicit, asupra informațiilor confidențiale.</p>
    <p>Informațiile confidențiale sunt secrete comerciale sau alte informații care includ, dar fără&nbsp; a se limita la, idei, concepte, secrete profesionale, tehnici, proiecte, specificații tehnice, documente financiare, planuri strategice, planuri de marketing/ financiare/ de afaceri, comisioane, numele angajaților, clienților sau furnizorilor, precum şi alte informații tehnice, financiare sau de afaceri, grafice, informații scrise sau sub orice alta formă materiala dezvăluite de către partea care deține informațiile confidențiale, indiferent daca se specifica sau nu ca acestea sunt &ldquo;confidențiale&rdquo; sau &ldquo;proprietatea&rdquo; acesteia.</p>
    <p>Informațiile confidențiale nu includ informațiile pe care PRESTATORUL dovedește &icirc;n ca:</p>
    <p>a) le deținea &icirc;nainte ca acestea sa-i fie dezvăluite de către Beneficiar, fără obligația de a le trata drept confidențiale;</p>
    <p>b) le-a obținut pe o cale licita, alta dec&acirc;t &icirc;n legătura cu prezentul contract;</p>
    <p>c) erau publice la data dezvăluirii de Beneficiar sau au devenit publice din alt motiv dec&acirc;t culpa Agentului, dar numai &icirc;ncep&acirc;nd de la data dezvăluirii.</p>
    <p>&nbsp;</p>
    <p>&nbsp;&nbsp; VIII: CLAUZA DE EXCLUSIVITATE</p>
    <p>Beneficiarul acorda prin semnarea prezentului contract un drept exclusivitate Agentului cu privire la activitățile ce fac obiectul acestuia. Beneficiarul se obliga pe &icirc;ntreaga perioada contractuala sa nu &icirc;ncheie nici un fel de contracte de prestări servicii cu terți prestatori av&acirc;nd ca obiect transferul Afacerii.</p>
    <p>&Icirc;ncălcarea acestei obligații de către Beneficiar da posibilitatea Agenției de a rezilia contractul si de a solicita daune interese.</p>
    <p>De comun acord părțile stabilesc valoarea daunelor interese la suma de 5000 EURO.</p>
    <p>&nbsp;</p>
    <p>&nbsp; IX. FORTA MAJORA SI CAZUL FORTUIT</p>
    <p>Nici una din p&acirc;rțile prezentului contract nu va fi responsabila pentru neexecutarea la termen si/sau in mod necorespunzător, total sau parțial, a oricăreia din obligațiile care &icirc;i incumba, daca neexecutarea obligației respective a fost cauzata de un eveniment imprevizibil la data &icirc;ncheierii contractului si ale cărui consecințe sunt de ne&icirc;nlăturat de către partea care &icirc;l invoca, cu condiția ca evenimentul imprevizibil provocat sa fie comunicat cocontractantului in termen de 5 zile de la apariția lui, &icirc;mpreuna cu confirmarea Camerei de Comerț si Industrie a Rom&acirc;niei. Sunt considerate asemenea evenimente: războiul, restricțiile legale, grevele, calamitățile naturale si orice alt eveniment care excedă controlul p&acirc;rții care &icirc;l invocă. Menținerea cazului de forță majora mai mult de 2 luni, poate conduce la &icirc;ncetarea contractului la cererea oricărei parți.</p>
    <p>&nbsp;</p>
    <p>&nbsp; X. INCETAREA CONTRACTULUI</p>
    <p>Prezentul contract &icirc;ncetează de plin drept, fără a fi necesara intervenția instanței judecătorești &icirc;n cazul &icirc;n care:</p>
    <p>- a expirat durata contractuală prevăzută la art. III si părțile nu au &icirc;nțeles sa &icirc;l prelungească prin Act Adițional;</p>
    <p>- a intervenit acordul de voința al parților, exprimat &icirc;n scris, &icirc;n vederea stingerii raportului contractual &icirc;n curs;</p>
    <p>- una dintre parți nu execută o obligație esențiala pentru contract, fiind notificata in acest sens de cealaltă parte;</p>
    <p>- denunțare unilaterala, de către oricare dintre parți, cu obligația de a notifica cealaltă parte cu cel puțin 30 zile &icirc;nainte;</p>
    <p>- a intervenit un caz de forța majora.</p>
    <p>Pentru ne&icirc;ndeplinirea culpabila a obligațiilor asumate contractual, creditorul obligației neexecutate poate solicita rezilierea contractului şi acordarea de daune interese pentru acoperirea integrală a prejudiciului suferit. Rezilierea va opera de &icirc;ndată, prin simpla notificare a celeilalte parți, fără alte formalități sau intervenția instanței de judecata.</p>
    <p>&Icirc;ncetarea contractului, din oricare motiv, nu va avea nici un efect asupra obligațiilor deja scadente intre parți.</p>
    <p>&nbsp;</p>
    <p>&nbsp; XI. COMUNICARILE DINTRE PARTI</p>
    <p>Comunicare intre parți, referitoare la &icirc;ndeplinirea prezentului contract, se poate realiza in oricare dintre următoarele metode:</p>
    <p>in scris, trimisa prin posta, cu confirmare de primire sau prin intermediul executorului judecătoresc, la adresele indicate in prezentul contract.</p>
    <p>prin e-mail la următoarele adrese de corespondenta: - pentru Agent: <span style="text-decoration: underline;"><a>Dan.Crivat@Trade-X.ro</a></span>&nbsp; pentru Beneficiar:<?php echo $comp['email']; ?>&nbsp; In cazuri urgente, comunicările intre parți se pot face si prin telefon, cu condiția confirmării in scris a acesteia.</p>
    <p>In cazuri urgente, comunicările intre parți se pot face si prin telefon, cu condiția confirmării in scris a acesteia.</p>
    <p>Orice schimbare a datelor de contact&nbsp; va fi adusa la cunoștința celeilalte parți in termen de maxim 3 zile de la momentul intervenirii acesteia.</p>
    <p>&nbsp;</p>
    <p>&nbsp; XII. LITIGII</p>
    <p>Eventualele litigii privind executarea sau interpretarea prezentului contract se vor soluționa pe cale amiabilă.</p>
    <p>In cazul &icirc;n care nu se va reuși soluționarea pe cale amiabilă a litigiilor, p&acirc;rțile convin ca soluționarea oricăror litigii sunt de competenta instanțelor judecătorești de la sediul Agenției.</p>
    <p>&nbsp;</p>
    <p>&nbsp;&nbsp; XIII. PREVEDERI FINALE</p>
    <p>Orice modificare a prezentului contract se va realiza prin act adițional, semnat de ambele parți.</p>
    <p>Prezentul contract reprezintă voința parților si &icirc;nlătura orice &icirc;nțelegere verbala dintre acestea, anterioara sau ulterioara &icirc;ncheierii lui.</p>
    <p>&nbsp;</p>
    <p>.................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.................................................&nbsp;</p>
    <p>&nbsp;&nbsp;&nbsp;BENEFICIAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PRESTATOR</p>
<?php }


function descriere_html_tab_vanzare($idv,$lng='enXXX'){ global $logo;

	$vanzare = many_query("SELECT * FROM `vanzare`
  LEFT JOIN companie  on companie_vanzare = companie.id_companie 
  WHERE idv='".@floor($idv)."' LIMIT 1");
	$date_vanzator= many_query("SELECT * FROM `companie` WHERE id_companie ='{$vanzare['reprezentant_vanzare']}' LIMIT 1"); //

	if(!$vanzare || !$date_vanzator){die('Invalid command!');}
	        //prea($date_vanzator); prea($vanzare); die;
	
	
    global $tip_forma_juridica, $judete,$localitati,$tip_act_identitate;
	
	$tip_act_identitate[0]='';
	//$descriere=trim(($lng=='en'? $vanzare['descriere_publica_en']:$vanzare['descriere_publica']));
	$descriere=$vanzare['descriere_publica'];
	if($descriere){
		//$descriere='<strong>'.($lng=='en'? 'Publish Description':'Descriere Publica').'</strong><br>'.$descriere;
		$descriere='<strong>Descriere Publica</strong><br>'.$descriere;
	}

	$poza2='http://brokers.trade-x.ro/media/Logo_Business_Escrow.png';
	$media=json_decode($vanzare['atasamente']);
    if(count($media)) {
        foreach ($media as $f) {
            if (in_array(substr($f, -4), explode(',', '.jpg,jpeg,.png'))) {
                $poza2 = 'http://brokers.trade-x.ro' . $f;
                break;
            }
        }
    }
	
	
	
	
	
	
	
    $html=$header=$footer='';
    ob_start(); ?>
    <style>
        .input{padding: 6px;  border-radius: 6px; margin: 10px;border-bottom: 1px solid #CCCCCC; }
    </style>
	<?php
		if (has_right($idv,'vanzare'))
		{
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
        <tr>
            <td><img src="<?=$logo?>"> </td>
            <td colspan="2"><strong style="font-size: 24px; text-align: center;">Date companie</strong></td>
            <td><strong>CUI</strong><div class="input"><?=$vanzare['cui']?></div></td>
        </tr>
        <tr>
            <td><strong>Denumire</strong><div class="input"><?=$vanzare['denumire']?></div></td>
            <td><strong>Adresa</strong><div class="input"><?=$vanzare['adresa']?></div></td>
            <td><strong>Judetul</strong><div class="input"><?=$judete[$vanzare[ 'judet_id' ]]?></div></td>
            <td><strong>Oras</strong><div class="input"><?=$localitati[$vanzare[ 'localitate_id' ]]?></div></td>
        </tr>

        </tbody>
    </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
			<tr>
				<td><strong>Registrul Comertului</strong><div class="input"><?=$vanzare['reg_com']?></div></td>
				<td><strong>Banca</strong><div class="input"><?=$vanzare['banca']?></div></td>
				<td><strong>Cont IBAN</strong><div class="input"><?=$vanzare['cont_iban']?></div></td>
			</tr>
			
			<tr>
				<td><strong>Telefon</strong><div class="input"><?=$vanzare['tel']?></div></td>
				<td><strong>Email</strong><div class="input"><?=$vanzare['email']?></div></td>
				<td><strong>Website</strong><div class="input"><?=$vanzare['website']?></div></td>
			</tr>
			
			<tr>
				<td><strong>Tip act de identitate </strong><div class="input"><?=$tip_act_identitate[$vanzare['tip_act_identitate']]?></div></td>
				<td><strong>Serie</strong><div class="input"><?=$vanzare['serie_ci']?></div></td>
				<td><strong>Numar</strong><div class="input"><?=$vanzare['numar_ci']?></div></td>
			</tr>
						
		</tbody>
    </table>
  
    <?php
		}

	 ?>
	<?php if($descriere){?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
			<tr>
				<td>
				<div class="input"><?=$descriere?></div>
				</td>
			</tr>
        </tbody>
    </table>
   <?php } ?>
   
  	<?php if(has_right($idv,'vanzare')){?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
			<tr>
				<td>
				<div class="input"><?=$vanzare['descriere_ascunsa']?></div></td>
			</tr>
        </tbody>
    </table>
   <?php } ?> 
     
 
   <?php
		if (has_right($idv,'vanzare'))
		{
	?>
     <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
        <tr>
            <td><img src="<?=$poza2;?>" style="height:50px;"> </td>
            <td colspan="2"><strong style="font-size: 24px; text-align: center;">Date vanzator</strong></td>
            <td><strong>CUI</strong><div class="input"><?=$date_vanzator['cui']?></div></td>
        </tr>
        <tr>
            <td><strong>Denumire</strong><div class="input"><?=$date_vanzator['denumire']?></div></td>
            <td><strong>Adresa</strong><div class="input"><?=$date_vanzator['adresa']?></div></td>
            <td><strong>Judetul</strong><div class="input"><?=$judete[$date_vanzator[ 'judet_id' ]]?></div></td>
            <td><strong>Oras</strong><div class="input"><?=$localitati[$date_vanzator[ 'localitate_id' ]]?></div></td>
        </tr>

        </tbody>
    </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
			<tr>
				<td><strong>Registrul Comertului</strong><div class="input"><?=$date_vanzator['reg_com']?></div></td>
				<td><strong>Banca</strong><div class="input"><?=$date_vanzator['banca']?></div></td>
				<td><strong>Cont IBAN</strong><div class="input"><?=$date_vanzator['cont_iban']?></div></td>
			</tr>
			
			<tr>
				<td><strong>Telefon</strong><div class="input"><?=$date_vanzator['tel']?></div></td>
				<td><strong>Email</strong><div class="input"><?=$date_vanzator['email']?></div></td>
				<td><strong>Website</strong><div class="input"><?=$date_vanzator['website']?></div></td>
			</tr>
			
			<tr>
				<td><strong>Tip act de identitate </strong><div class="input"><?=$tip_act_identitate[$date_vanzator['tip_act_identitate']]?></div></td>
				<td><strong>Serie</strong><div class="input"><?=$date_vanzator['serie_ci']?></div></td>
				<td><strong>Numar</strong><div class="input"><?=$date_vanzator['numar_ci']?></div></td>
			</tr>
						
		</tbody>
    </table>   
    <?php
		}
	 ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
			<tr>
				<td colspan="2"><strong>Denumire Afacere ** </strong><div class="input"><?=$vanzare['denumire_afacere']?></div></td>
			</tr>
			
			<tr>
				<td><strong>Imagine afacere: Vânzătorul </strong><div class="input"><?=ucwords($vanzare[ 'imagine_afacere' ]);?></div></td>
				<td><strong>Când se pot face?</strong><div class="input"><?=$vanzare['cand_se_face']?></div></td>
			</tr>
			
			<tr>
				<td colspan="2"><strong>Domeniul de activitate **</strong><div class="input"><?=$vanzare['domeniu_activitate']?></div></td>
			</tr>
			
			<tr>
				<td><strong>Cifra de Afaceri Anuala **  </strong><div class="input"><?=($vanzare[ 'cifra_afaceri' ]);?></div></td>
				<td><strong>Profitul Annual **</strong><div class="input"><?=$vanzare['profit_anual']?></div></td>
			</tr>
			<tr>
				<td><strong>Afacerea Stabilita in Data de ** </strong><div class="input"><?=($vanzare[ 'data_stabilire' ]);?></div></td>
				<td><strong>Finanțarea Vânzătorului/Bănci **</strong><div class="input"><?=$vanzare['tip_finantare']?></div></td>
			</tr>
			<tr>
				<td><strong>Preț de Vânzare ** </strong><div class="input"><?=($vanzare[ 'pret_vanzare' ]);?></div></td>
				<td><strong>Patrimoniu Imobiliar **</strong><div class="input"><?=$vanzare['patrimoniu_imobiliar']?></div></td>
			</tr>
			<tr>
				<td><strong>Fond comercial (Goodwill) **  </strong><div class="input"><?=($vanzare[ 'fond_comercial' ]);?></div></td>
				<td><strong>Marcă comercială (Trademark) **</strong><div class="input"><?=$vanzare['marca_comerciala']?></div></td>
			</tr>
			<tr>
				<td><strong>Inventar Aproximativ ** </strong><div class="input"><?=ucwords($vanzare[ 'inventariu_aprox' ]);?></div></td>
				<td><strong>Număr de Angajați **</strong><div class="input"><?=$vanzare['nr_angajati']?></div></td>
			</tr>
			<tr>
				<td><strong>Motivul Vânzări ** </strong><div class="input"><?=($vanzare[ 'motiv_vanzare' ]);?></div></td>
				<td><strong>Cifra de afaceri din anii anteriori **</strong><div class="input"><?=$vanzare['cifra_afaceri_anterior']?></div></td>
			</tr>
			<tr>
				<td><strong>Suport si Training ** </strong><div class="input"><?=($vanzare[ 'suport' ]);?></div></td>
				<?php
			if (has_right($idv,'vanzare'))
				{
			?>
				<td><strong>Acte/Documente de Adăugat * </strong><div class="input"><?=$vanzare['acte_adaugare']?></div></td>
			<?php
				}
			?>
			</tr>
		</tbody>
    </table>   
                      
   <?php
		if (has_right($idv,'vanzare'))
		{
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
			<tr>
				<td><strong>Exclusivitate</strong><div class="input"><?=ucwords($vanzare['exclusivitate'])?></div></td>
				<td><strong>Consultanta, Pachet IM *</strong><div class="input"><?=$vanzare['consultanta']?></div></td>
				<td><strong>Comision *</strong><div class="input"><?=$vanzare['comision']?></div></td>
			</tr>
			
			<tr>
				<td><strong>Listare ascunsa?</strong></td>
				<td><strong>Listare cu nume?</strong><div class="input"><?=ucwords($vanzare['la_nume'])?></div></td>
				<td><strong>Listare pe site?</strong><div class="input"><?=ucwords($vanzare['la_site'])?></div></td>
			</tr>
						
		</tbody>
    </table>    
   <?php
		}
	?>
    <?php
    $html=ob_get_contents();
    ob_end_clean();
    return array($html,$header,$footer);
}


function evaluare_html_tab_vanzare($idv){ global $logo;

	$nume_afacere=one_query("SELECT denumire from vanzare
									LEFT JOIN companie on vanzare.companie_vanzare=companie.id_companie and tip_companie='c'
									WHERE idv='".@floor($idv)."' LIMIT 1");
	$evaluare = many_query("SELECT * FROM `evaluare`
   where idv='".@floor($idv)."' LIMIT 1");
	
    $html=$header=$footer='';
    ob_start(); ?>
    <style>
        .input{padding: 6px;  border-radius: 6px; margin: 10px;border-bottom: 1px solid #CCCCCC; }
    </style>



    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
        <tr>
            <td><img src="<?=$logo?>"> </td>
            <td colspan="2"><strong style="font-size: 24px; text-align: center;">Evaluare <?=$nume_afacere;?></strong></td>
        </tr>
        </tbody>
    </table>
    <hr/>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
			<tr>
			<td >TradeX aplică un multiplu de EBITDA pentru a determina valoarea afacerea dvs. În general, Afacerile mici si mijloci se tranzacționează între 3x și 5x EBITDA. Diferența dintre multiple este rezultatul unei varietăți de caracteristici specifice afacerii dvs.
			</td>
			</tr>
		</tbody>
    </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tbody>
		  <tr>
			<td style="width:80%"><strong>Care este EBITDA anual al Afacerii?</strong>
			<br/>
			Introduceți o valoare de la 0 până la 5 milioane Euro (sub 1 milion: 0,XX - Exemplu 0,20 pt 200.000)
			</td>
			<td style="width:20%">
		<div class='input'><?=$evaluare['ebid_anual'];?></div>
			</td>	
			</tr>
		  <tr>
			<td><strong>Care este rata de creștere anuala a veniturilor Afacerii?</strong>
			<br/>
			Introduceți o valoare cuprinsă între 0% și 50%</td>
			<td>
		<div class='input'><?=$evaluare['rata_crestere_ebid'];?> %</div>
			</td>	
			</tr>
		  <tr>
			<td><strong>Care este marja EBITDA (ca procent din venituri)?</strong>
			<br/>
			Introduceți o valoare cuprinsă între 0% și 50%</td>
			<td>
		<div class='input'><?=$evaluare['marja_ebid'];?> %</div>
			</td>	
			</tr>
		  <tr>
			<td><strong>Cheltuielile de capital - fonduri utilizate pentru achiziționarea, modernizarea și menținerea activelor fizice (ca procent din EBITDA)?</strong>
			<br/>
			Introduceți o valoare între 0% și 30%</td>
			<td>
		<div class='input'><?=$evaluare['cheltuieli_ebid'];?> %</div>
			</td>	
			</tr>
		  <tr>
			<td><strong>Procentajul veniturilor reprezentate de clientul de top?</strong>
			<br/>
			Introduceți o valoare cuprinsă între 0% și 50%</td>
			<td>
		<div class='input'><?=$evaluare['venituri_cl_ebid'];?> %</div>
			</td>	
			</tr>
		  <tr>
			<td><strong>Procentajul veniturilor reprezentate de cei 5 clienți de top împreună?</strong>
			<br/>
			Introduceți o valoare cuprinsă între 0% și 75%</td>
			<td>
		<div class='input'><?=$evaluare[' venituri_top_ebid '];?> %</div>
			</td>	
			</tr>
		  <tr>
			<td><strong>Aceasta Afacerea practica prețuri/tarife premium față de concurenții?</strong>
			</td>
			<td>
					<?=($evaluare['practica_preturi_ebitd']==='1'?"Da":'Nu')?>
			</td>	
			</tr>
		  <tr>
			<td><strong>Este Afacerea o firmă de servicii profesionale? (contabilitate, publicitate, etc.)</strong>
			</td>
			<td>
		<?=($evaluare['servicii_profesionale_editd']==='1'?"Da":'Nu')?>
			</td>	
			</tr>
		  <tr>
			<td><strong>Este Vanzatorul și/sau partenerii de afacere critici pentru afacere?</strong>
			</td>
			<td>
				<?=($evaluare['critic_ebitd']==='1'?"Da":'Nu')?>
			</td>	
			</tr>
		  <tr>
			<td><strong>Multiplu aproximativ EBITDA </strong>
			</td>
			<td>
		<div class='input'><?=$evaluare['multiplu_aproximativ_ebitd'];?> %</div>
			</td>	
			</tr>
		  <tr>
			<td><strong>Valoarea aproximativă a companiei (în milioane Euro) </strong>
			</td>
			<td>
		<div class='input'><?=$evaluare['val_aprox_companie'];?> %</div>
			</td>	
			</tr>
		</tbody>
    </table> 
	    
   
    <?php
    $html=ob_get_contents();
    ob_end_clean();
    return array($html,$header,$footer);
}
