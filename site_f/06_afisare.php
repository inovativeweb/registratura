<?php

function ro_date($date){
    return date("d-m-Y",strtotime($date));
}
function list_adresa_contract($adresa_cadastru){ global $tip_arteta,$mesaj_necompletat;
    if($adresa_cadastru['judet']!='Bucuresti') {?>
        <?php echo isset($adresa_cadastru['localitatea']) ? 'Loc. ' . $adresa_cadastru['localitatea'] : $mesaj_necompletat; ?>,

        Județul <?php echo isset($adresa_cadastru['judet']) ? $adresa_cadastru['judet'] : $mesaj_necompletat;
    } else {?>
        <?php echo isset($adresa_cadastru['judet']) ? 'Mun. ' .$adresa_cadastru['judet'] : $mesaj_necompletat; ?>,

         <?php echo isset($adresa_cadastru['localitatea']) ? $adresa_cadastru['localitatea'] : $mesaj_necompletat;
    }    echo ',   ' .$tip_arteta[$adresa_cadastru['tip_artera']].' '.$adresa_cadastru['strada']; ?>
    <?php echo strlen($adresa_cadastru['numar'])  ? 'nr. ' . $adresa_cadastru['numar'].', ' : ''; ?>
    <?php echo strlen($adresa_cadastru['bloc'])>0 ? 'bl. ' . $adresa_cadastru['bloc'].', ' : ''; ?>
    <?php echo strlen($adresa_cadastru['scara'])>0 ? 'sc. ' . $adresa_cadastru['scara'].', ' : ''; ?>
    <?php echo strlen($adresa_cadastru['etaj'])>0 ? 'et. ' . $adresa_cadastru['etaj'].', ' : ''; ?>
    <?php echo strlen($adresa_cadastru['ap'])>0 ? 'ap. ' . $adresa_cadastru['ap'].', ' : ''; ?>

<?php }


function side_bar_left(){  global  $login_user,$asociatii,$access_level_login;?>
    <div class="ui card hidden-xs hidden-sm" style="margin: 0;">
        <div class="ui raissed segment image" align="center">
            <a class="navbar-brandX" style="margin:0; padding:0; width: 100%;" href="<?php echo LROOT; ?>">
                <img  id="logo_firma" src="<?=MEDIA?>logo.png?<?=time()?>" style="height:50px;margin:0 auto;"/> </a>
        </div>
    </div>
	<div class="spacer15"></div>
        <div class="ui one column grid">
            <div class="column">
                <div class="ui fluid vertical steps">
                 <!--
                    <a href="/afaceri/">
                    <div class="step <?php subFuncMenuSel('afaceri_vanzare',true); ?>" step="afaceri_vanzare">
                        <div class="content">
                            <div class="title title2"><i class="circular purple tag icon"></i>Afaceri de vanzare  </div>
                            <div class="description"></div>
                        </div>
                    </div>
                    </a>
                    <a href="/cumparatori/">
                    <div class="step <?php subFuncMenuSel('cumparatori',true); ?>" step="cumparatori">
                        <div class="content">
                            <div class="title title2"><i class="circular olive dollar icon"></i>Cumparatori</div>
                            <div class="description"></div>
                        </div>
                    </div>
                    </a>
                    -->



                    <a href="<?=ROOT?>documente/">
                        <div class="step <?php subFuncMenuSel('documente',true); ?>" step="users">
                            <div class="content">
                                <div class="title title2"><i class="circular olive paperclip  icon"></i>Documente</div>
                                <div class="description"></div>
                            </div>
                        </div>
                    </a>
                    <a href="<?=ROOT?>locuitori/">
                    <div class="step <?php subFuncMenuSel('locuitori',true); ?>" step="users">
                        <div class="content">
                            <div class="title title2"><i class="circular green user  icon"></i>Locuitori</div>
                            <div class="description"></div>
                        </div>
                    </div>
                    </a>
                    <a href="<?=ROOT?>organigrama/">
                        <div class="step <?php subFuncMenuSel('organigrama',true); ?>" step="organigrama">
                            <div class="content">
                                <div class="title title2"><i class="circular purple laravel  icon"></i>Organigrama</div>
                                <div class="description"></div>
                            </div>
                        </div>
                    </a>
                    <a href="<?=ROOT?>companii/">
                        <div class="step <?php subFuncMenuSel('companii',true); ?>" step="companii">
                            <div class="content">
                                <div class="title title2"><i class="circular orange building  icon"></i>Companii</div>
                                <div class="description"></div>
                            </div>
                        </div>
                    </a>
                    <a href="<?=ROOT?>calendar/">
                        <div class="step <?php subFuncMenuSel('calendar',true); ?>" step="lista_to_do">
                            <div class="content">
                                <div class="title title2"><i class="circular blue calendar alternate outline icon"></i>Programari</div>
                                <div class="description"></div>
                            </div>
                        </div>
                    </a>
                    <a href="<?=ROOT?>tasks/">
                    <div class="step <?php subFuncMenuSel('lista_to_do',true); ?>" step="lista_to_do">

                            <div class="content">
                                <div class="title title2"><i class="circular teal tasks alternate outline icon"></i>Lista ToDo</div>
                                <div class="description"></div>
                            </div>
                    </div>
                    </a>
                    <a href="<?=ROOT?>new-jobs/">
                        <div class="step <?php subFuncMenuSel('new_jobs',true); ?>" step="new_jobs">

                            <div class="content">
                                <div class="title title2"><i class="circular yellow tasks alternate outline icon"></i>Cereri noi</div>
                                <div class="description"></div>
                            </div>
                        </div>
                    </a>



                </div>
            </div>

        </div>
    <?php
    $user = many_query("SELECT * FROM `thf_users` WHERE id='".$GLOBALS['login']->get_uid()."' LIMIT 1"); 
    $poze=ThfGalleryEditor::get_poze_produs($user['atasamente']);
    //prea($poze);
	?>
           <div class="ui card">
            <div class="ui  image">
                <?php
            
                if(isset($poze[0][0])){?>
                <img src="<?=f($poze[0][0])?>" class="visible content">
                <?php }  ?>
                <?php foreach ($poze as $k=>$img) {?>
               <!-- <img src="<?=$img[0]?>" class="<?=$k != 0 ? 'hidden' : 'visible'?> content"> -->
                <?php } ?>
            </div>
            <div class="content">
                <a class="header" href="/useri/user_edit.php?edit=<?=$user['id']?>"><?=$user['full_name']?></a>
                <div class="meta">
                    <span><?=$asociatii[$user['asoc_id']]['nume']?></span>
                   <br> <span class="date">Ultima logare acum<?=actualizat_acum_time(strtotime($user['last_login']),60*60*24*10)?></span>
                </div>
            </div>
            <div class="extra content">
                <a>
                    <i class="tag icon"></i>
                </a>
            </div>
        </div>

    <div class="ui card">
        <div class="content align center">
            <a href="<?php echo ROOT . 'my-files/vanzari.php' ?>">
                <div class="content text-centers">
                    <div class="title title2"><i class="circular gray file alternate outline icon"></i>&nbsp;My files</div>
                    <div class="description"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="ui card">
        <div class="content align center">
            <a onmousedown="global_search();">
                <div class="content text-centers">
                    <div class="title title2"><i class="circular gray search alternate outline icon"></i>&nbsp;Cauta</div>
                    <div class="description"></div>
                </div>
            </a>
        </div>
    </div>
	<?php

	if ($user['access_level']>9)
	{
	
	?>
    <div class="ui card">
        <div class="content align center">
            <a href="<?php echo ROOT . 'contracte' ?>">
                <div class="content text-centers">
                    <div class="title title2"><i class="circular gray cog alternate outline icon"></i>&nbsp;Setari</div>
                    <div class="description"></div>
                </div>
            </a>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="ui card ">
            <div class="content align center active">
                    <a href="<?php echo $GLOBALS["login"]->get_logout_href(); ?>">
                        <div class="content text-centerSSS <?php subFuncMenuSel('lista_to_do',true); ?> ">
                            <div class="title title2"><?php echo $GLOBALS["login"]->get_name(); ?>&nbsp;<span class="glyphicon glyphicon-log-in circular icon" style="color:red;"></span></div>
                            <div class="description"></div>
                        </div>
                    </a>


            </div>
    </div>


	<?php }

function list_menu_myfiles()
{ ?>

    <div class="ui top attached tabular menu">
        <div class="<?=substr_count($_SERVER['REQUEST_URI'],'vanzari') ? 'active' : ''?> item"> <a href="<?= LROOT ?>my-files/vanzari.php"><i class="circular purple tag icon"></i>Vanzari</a></div>
        <div class="<?=substr_count($_SERVER['REQUEST_URI'],'cumparatori') ? 'active' : ''?> item"> <a href="<?= LROOT ?>my-files/cumparatori.php"><i class="circular olive dollar icon"></i>Cumparatori</a></div>
        <div class="<?=substr_count($_SERVER['REQUEST_URI'],'general') ? 'active' : ''?> item"> <a href="<?= LROOT ?>my-files/general.php"><i class="circular blue file icon"></i>General files</a></div>
    </div>

    <?php
}

function show_teaser($selected_lng,$vanzare_edit){ global $vanzari_all,$valuesSp,$judete,$localitati,$companii_all,$domenii_afacere;

    $vanzare = $vanzari_all[$vanzare_edit];
    $teaser['ro']['descriere_publica']=$vanzare['descriere_publica'];
    $teaser['en']['descriere_publica']=$vanzare['descriere_publica_en'];

    $teaser['ro']['motiv_vanzare']=$vanzare['motiv_vanzare'];
    $teaser['en']['motiv_vanzare']=$vanzare['motiv_vanzare_en'];

    $teaser['ro']['post']=$vanzare['post_ro'];
    $teaser['en']['post']=$vanzare['post_en'];

    $teaser['ro']['denumire_afacere']=$vanzare['denumire_afacere'];
    $teaser['en']['denumire_afacere']=$vanzare['denumire_afacere_en'];

    $teaser['ro']['suport']=$vanzare['suport'];
    $teaser['en']['suport']=$vanzare['suport_en'];

    $teaser['ro']['focus_keyword']=$vanzare['focus_keyword'];
    $teaser['en']['focus_keyword']=$vanzare['focus_keyword_en'];

    $teaser['ro']['meta_description']=$vanzare['meta_description'];
    $teaser['en']['meta_description']=$vanzare['meta_description_en'];

    $teaser['ro']['alt_text']=$vanzare['alt_text'];
    $teaser['en']['alt_text']=$vanzare['alt_text_en'];

?>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <h1><?=($teaser[$selected_lng]['denumire_afacere']);?></h1><?php
                //prea($vanzare);
                $poza='';
                $tmp=@json_decode($vanzare['atasamente']);
                if(is_array($tmp)){ foreach($tmp as $poza){break;} }
                if($poza){
                    echo '<img src="'.$poza.'" class="img-thumbnail img-responsive" style="max-width:400px" /><br>';
                }
                ?></td>
            <td>

            </td>
        </tr></table>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="8" width="569" align="left" valign="top">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="8" width="569"><?=$selected_lng == 'ro'? 'Denumire Afacere' :'Business Name'?> </td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td colspan="8"><?=($teaser[$selected_lng]['denumire_afacere']);?></td>
        </tr>
        <tr>
            <td colspan="8"><?=$selected_lng == 'ro'? 'Domeniul de activitate' :'Field of activity'?> </td>
        </tr>
        <tr>
            <td colspan="8"><?php
                $tmpda=explode(',',$vanzare[ 'domeniu_activitate' ]);
                foreach($domenii_afacere as $dai=>$da){
                    if(!$dai || !in_array($dai,$tmpda)){continue;}
                    echo '&bull; '.h($da).'<br>';
                }
                ?></td>
        </tr>
        <tr>
            <td colspan="8" width="569" align="left" valign="top">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="8" width="569"><?=$selected_lng == 'ro'? 'Descriere Publica' :'Description Publish'?> </td>
                    </tr>
                </table></td>
        </tr>
        <tr>
            <td colspan="8" width="569">
                <?=($teaser[$selected_lng]['descriere_publica']);?>
            </td>
        </tr>
        <tr>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Cifra de Afaceri Anuala (in lei)' :'Annual Business Turnover'?></td>
            <td><?=h($vanzare['cifra_afaceri']);?></td>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Profitul Annual ** (in lei)' :'Annual Profit'?></td>
            <td><?=h($vanzare['profit_anual']);?></td>
        </tr>
        <tr>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Afacerea    Stabilita in Data de' :'Business Established On'?></td>
            <td>&nbsp;</td>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Finanțarea    Vânzătorului/Bănci' :'Financing - Seller / Banking'?></td>
            <td width="569"></td>
        </tr>
        <tr>
            <td colspan="4"><?=h($vanzare['data_stabilire']);?></td>
            <td colspan="4"><?=h($vanzare['tip_finantare']);?></td>
        </tr>
        <tr>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Preț de Vânzare (in EUR)' :'Selling Price (in EUR)'?></td>
            <td><?=h($vanzare['pret_vanzare']);?></td>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Patrimoniu Imobiliar&nbsp;(Eur)' :'Real Estare Value (Eur)'; ?></td>
            <td><?=h($vanzare['patrimoniu_imobiliar']);?></td>
        </tr>
        <tr>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Fond comercial (Goodwill) ' :'Goodwill'?> (Eur)</td>
            <td><?=h($vanzare['fond_comercial']);?></td>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Marcă comercială (Trademark) ' :' Trademark'?></td>
            <td><?=h($vanzare['marca_comerciala']);?></td>
        </tr>
        <tr>
            <td colspan="4"><?=$selected_lng == 'ro'? 'Inventar Aproximativ' :'Approx Inventory'?></td>
            <td colspan="3"><?=$selected_lng == 'ro'? 'Inclus in Pret' :'Included in Price'?></td>
            <td><?=h($vanzare['inventar_inclus_in_pret']);?></td>
        </tr>
        <tr>
            <td colspan="4" width="569" align="left" valign="top">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="4" width="313"><?=$selected_lng == 'ro'? 'Motivul Vânzări ' :'The Reason of Sale'?></td>
                    </tr>
                </table></td>
            <td colspan="4"><?=$selected_lng == 'ro'? 'Cifra de afaceri din anii anteriori' :'Turnover of Previous Years'?></td>
        </tr>
        <tr>
            <td colspan="4"><?=h($teaser[$selected_lng]['motiv_vanzare']);?></td>
            <td colspan="4"><?=h($vanzare['cifra_afaceri_anterior']);?></td>
        </tr>
        <tr>
            <td colspan="4" width="569" align="left" valign="top">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="4" width="313"><?=$selected_lng == 'ro'? 'Suport si Training ' :'Support and Training'?></td>
                    </tr>
                </table></td>
            <td colspan="4"><?=$selected_lng == 'ro'? 'Număr de Angajați' :'Number of Employees'?></td>
        </tr>
        <tr>
            <td colspan="4"><?=h($teaser['suport']);?></td>
            <td colspan="4"><?=h($vanzare['nr_angajati']);?></td>
        </tr>
    </table>


    <?php
    if($vanzare['tipimobil'] && $vanzare['anconstructie']){ ?>
        <table  cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="7">Date    Suplimentare Imobiliare &amp; Spatii Comerciale **</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Tip Imobil</td>
                <td>&nbsp;</td>
                <td>An constructie</td>
                <td>&nbsp;</td>
                <td>Stadiu constructie</td>
                <td>&nbsp;</td>
                <td>Structura rezistenta</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><?=h($valuesSp['tipimobil'][$vanzare['tipimobil']]);?></td>
                <td>&nbsp;</td>
                <td><?=h($vanzare['anconstructie']);?></td>
                <td>&nbsp;</td>
                <td><?=h($valuesSp['stadiuconstructie'][$vanzare['stadiuconstructie']]);?></td>
                <td>&nbsp;</td>
                <td><?=h($valuesSp['structurarezistenta'][$vanzare['structurarezistenta']]);?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Suprafata    construita</td>
                <td>&nbsp;</td>
                <td>Suprafata utila</td>
                <td>&nbsp;</td>
                <td>Suprafata teren</td>
                <td>&nbsp;</td>
                <td>Pret inchiriere</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><?=h($vanzare['suprafataconstruita']);?></td>
                <td>&nbsp;</td>
                <td><?=h($vanzare['suprafatautila']);?></td>
                <td>&nbsp;</td>
                <td><?=h($vanzare['suprafatateren']);?></td>
                <td>&nbsp;</td>
                <td><?=h($vanzare['pretinchiriere']);?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Nr nivele</td>
                <td>&nbsp;</td>
                <td>Nr incaperi</td>
                <td>&nbsp;</td>
                <td>Nr grup. Sanitare</td>
                <td>&nbsp;</td>
                <td>Nr parcari </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><?=h($vanzare['nrnivele']);?></td>
                <td colspan="2"><?=h($vanzare['nrincaperi']);?></td>
                <td colspan="2"><?=h($vanzare['nrgrupurisanitare']);?></td>
                <td colspan="2"><?=h($vanzare['nrparcari']);?></td>
            </tr>
            <tr>
                <td colspan="2">Utilitati</td>
                <td colspan="2">Dotari</td>
                <td colspan="2">Servicii</td>
                <td colspan="2">Alte caracteristici</td>
            </tr>
            <tr>
                <td colspan="2"><?php
                    $tmpda=explode(',',$vanzare[ 'utilitati' ]);
                    foreach($valuesSp['utilitati'] as $dai=>$da){
                        if(!$dai || !in_array($dai,$tmpda)){continue;}
                        echo '&bull; '.h($da).'<br>';
                    }
                    ?></td>
                <td colspan="2"><?php
                    $tmpda=explode(',',$vanzare[ 'dotari' ]);
                    foreach($valuesSp['dotari'] as $dai=>$da){
                        if(!$dai || !in_array($dai,$tmpda)){continue;}
                        echo '&bull; '.h($da).'<br>';
                    }
                    ?></td>
                <td colspan="2"><?php
                    $tmpda=explode(',',$vanzare[ 'servicii' ]);
                    foreach($valuesSp['servicii'] as $dai=>$da){
                        if(!$dai || !in_array($dai,$tmpda)){continue;}
                        echo '&bull; '.h($da).'<br>';
                    }
                    ?></td>
                <td colspan="2"><?php
                    $tmpda=explode(',',$vanzare[ 'altecaracteristici' ]);
                    foreach($valuesSp['altecaracteristici'] as $dai=>$da){
                        if(!$dai || !in_array($dai,$tmpda)){continue;}
                        echo '&bull; '.h($da).'<br>';
                    }
                    ?></td>
            </tr>

        </table>
    <?php }

    $bb=many_query("SELECT * FROM `thf_users` WHERE id='".$vanzare['uid']."' LIMIT 1");

    //prea($poze_broker);
    foreach(ThfGalleryEditor::get_poze_produs($bb['atasamente']) as $pid=>$plnk){
        if($pid>-1){
            if(is_string($plnk)){
                echo '<img src="'.$plnk.'" class="img-thumbnail img-responsive" /><br>';
            }
            elseif(is_array($plnk)){
                foreach($plnk as $plinka){
                    echo '<img src="'.$plinka.'" class="img-thumbnail img-responsive" /><br>';
                    break;
                }
            }
        }
        break;
    }

    ?>


    <table  cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="4">Date    Contact Business Broker*</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><?=$selected_lng == 'ro'? 'Nume':'Name'?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?=$selected_lng == 'ro'? 'Adresa':'Address'?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?=$selected_lng == 'ro'? 'Judet':'County'?></td>
            <td><?=$selected_lng == 'ro'? 'Oras':'City'?></td>
        </tr>
        <tr>
            <td><?=h($bb['full_name']);?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?=h($companii_all[$bb['id_companie_user']]['adresa']);?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?=h($judete[$companii_all[$bb['id_companie_user']]['judet_id']]);?></td>
            <td><?=h($localitati[$companii_all[$bb['id_companie_user']]['localitate_id']]);?></td>
        </tr>
        <tr>
            <td><?=$selected_lng == 'ro'? 'Telefon':'Phone'?></td>
            <td>&nbsp;</td>
            <td colspan="6">Email</td>
        </tr>
        <tr>
            <td><?=h($vanzare['tel']);?></td>
            <td>&nbsp;</td>
            <td colspan="6"><?=h($bb['mail']);?></td>
        </tr>
    </table>
<?php }

function list_menu_settings()
{ ?>

        <div class="ui top attached tabular menu">
            <div class="<?=substr_count($_SERVER['REQUEST_URI'],'organigrama_edit') ? 'active' : ''?> item"> <a href="<?= LROOT ?>organigrama/organigrama_edit.php">Organigrama</a></div>
            <div class="<?=substr_count($_SERVER['REQUEST_URI'],'definitii') ? 'active' : ''?> item"> <a href="<?= LROOT ?>definitii.php">Definitii</a></div>
            <div class="<?=substr_count($_SERVER['REQUEST_URI'],'contracte') ? 'active' : ''?> item"> <a href="<?= LROOT ?>contracte/">Contracte</a></div>

        </div>

    <?php
}

function date_companie($id,$nl='<br />'){ $out='';
    $c=many_query("SELECT * FROM `companie` WHERE `id_companie`='".q($id)."'");
    $co=many_query("SELECT * FROM `conturi` WHERE `cont_sters`=0 AND `id_companie_cont`='$c[id_companie]' ORDER BY `default_cont` DESC, `nume_banca` ASC LIMIT 2");
    $a=many_query("SELECT * FROM `adrese` WHERE `adresa_stearsa`=0 AND `id_companie_adresa`='$c[id_companie]' ORDER BY `default_adrese` DESC, `adresa` ASC");
    //echo $c['cui']; die;
    $out.='<strong style="color:'.COLOR2.'">'.h($c['denumire'] ).'</strong>'.$nl;
    $out.='&bull;CIF :'.h($c['cui'] ? ' '.$c['cui'] : '').$nl;
    $out.='&bull;Reg. Com. : '.h($c['reg_com']).$nl;
    $out.='&bull;Adresa : '.h($a['adresa']).$nl;
    $out.=h($a['tara']).' '.h($a['localitatea']).' Judetul :'.h($a['judet']).$nl;
    if($c['cap_social']){$out.='CAP.SOCIAL: '.h($c['cap_social']).$nl;
    }
    if(count($co)){
        $out.='&bull;Banca : '.h($co['nume_banca']).' '.h($co['sucursala']).$nl;
        $out.=h($co['cont']).' '.h($co['moneda']).$nl;
    }
    return $out;
}
function list_files($id_doc){
    global $path;
    $file_name = array();
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
    //  echo $path;
    $dirs = get_all_subdirs(THF_UPLOAD, 0, 4);
    $file = array();
    $greatest_time = 0;
    if (isset($dirs[@floor($id_doc)])) {
        $dir = get_dir_filelist($path);
    } else {
        $dir = array();
    }
    foreach ($dir as $fila) {
        $mtime = s(($path . $fila));//		$greatest_time=max($greatest_time,$mtime);
        $file[$mtime] = $fila;
        //$file[]=$fila;
        $file_name[] = $fila;

    }  ?>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Filename</th>
            <th>Upload date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($file) && count($file)){
        foreach($file as $fname){
        if($fila==$fname ){echo '<strong>';}?>

        <?php echo ' <tr id="'.md5($fname).'">
                 <td>
			<a target="blank" href="'.UPLOAD.''.$_GET['edit'].'/'.$fname.'" colorboxiframe="{&quot;iframe&quot;:true, &quot;width&quot;:&quot;90%&quot;, &quot;height&quot;:&quot;90%&quot;}" class="cboxElement" >'.$fname.'</a>'.
            '<span style="color:gray;"></td>'.
            '<td>'.date('Y-m-d H:i:s',filemtime($path.$fname)).'</span></a>'.'</td>'.
            '<td>'.('<a style="right:10px;"  onClick="if(confirm(\' Are you sure you want to delete?\')){delete_file(\''.$fname.'\',\''.md5($fname).'\')}">'.
                '<span style="color:red;" class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>').'</td>'.


            '</tr>';
        if($fila==$fname){echo '</strong>';}
        }
        }
        ?></table></div>

<?php }


function adresa_livrare($id,$nl='<br />'){ $out='';
    $c=many_query("SELECT * FROM `companie` WHERE `id_companie`='".q($id)."'");
    $co=many_query("SELECT * FROM `conturi` WHERE `cont_sters`=0 AND `id_companie_cont`='$c[id_companie]' ORDER BY `default_cont` DESC, `nume_banca` ASC LIMIT 2");
    $a=many_query("SELECT * FROM `adrese` WHERE `adresa_stearsa`=0 AND `id_companie_adresa`='$c[id_companie]' ORDER BY `default_adrese` DESC, `adresa` ASC");
    $out.=h($a['adresa']).$nl;
    $out.=h($a['tara']).' '.h($a['localitatea']).' '.h($a['judet']).$nl;
    return $out;
}

function list_adresa($ida){ global $tip_arteta;
    $a = many_query("SELECT * FROM `adrese` WHERE ida = '".$ida."' ");
   // prea($a);
   // $judet = one_query("SELECT nume_judet FROM `localizare_judete` WHERE id = '".$a['judet']."' ");
    return
        trim( ($a['judet'] ? ' ' . $a['judet'].', ':' ')).
        ($a['sector'] ? '' .$a['sector'].', ':' ').
        ($a['localitatea'] ? ' ' .$a['localitatea'].', ':'').
        ($a['tip_artera'] ? $tip_arteta[$a['tip_artera']].' ':'').
        ($a['strada'] ? $a['strada'].', ':'').
        ($a['numar'] ? ' nr. ' .$a['numar'].', ':'').
        ($a['bloc'] ? ' bl. ' .$a['bloc'].', ':'').
        ($a['scara'] ? ' sc, ' .$a['scara'].', ':'').
        ($a['etaj'] ? ' et. ' .$a['etaj'].', ':'').
        ($a['ap'] ? ' ap. ' .$a['ap'].', ':'').
        (strlen($a['nr_cf_cad'])>0 ? $a['nr_cf_cad'].', ':'');
}


function lista_conturi($id_companie_cont){
    $conturi=multiple_query("SELECT  * FROM  `conturi` 
WHERE  `conturi`.`id_companie_cont` ='".$id_companie_cont."' AND `conturi`.`cont_sters`=0
ORDER BY  `conturi`.`default_cont` DESC ",'idc');
    if(!$conturi){$conturi=array();}
    echo ' <div class="form-group">
    <label class="control-label col-sm-2" for="tip_companie">Conturi<br />
		<a href="'.ROOT.'conturi_add.php?id_companie_cont='.$id_companie_cont.'" class="btn btn-success pull-right iframe" title="Adauga un cont nou"><span class="glyphicon glyphicon-plus"></span></a>	
		</label>
    <div class="col-sm-10"><ul class="list-group" id="lista_conturi">';
    foreach($conturi as $idc=>$cont){
        echo '<li class="list-group-item"><a href="conturi_add.php?edit='.$cont['idc'].'" class="iframe" id="iban'.$cont['idc'].'" title="Editeaza acest cont">'.formatare_txt_cont($cont).'</a>
		<a class="btn btn-danger btn-xs pull-right" onclick="conturi_del_tab('.$cont['idc'].');"><span class="glyphicon glyphicon-remove"></span></a></li>';
    }
    echo '</ul>
	<div class="alert alert-danger" role="alert" id="conturi_del_tab"> <button type="button" class="close" onclick="$(this).parent().hide(\'fast\');" ><span aria-hidden="true">×</span></button> <h4>Esti sigur ca doresti sa stergi urmatorul cont?</h4> <p class="message_to_del">...</p>
	<p><button type="button" class="btn btn-danger cont_to_del" onclick="dell_cont(this);" cont="0">Sterge</button> <button type="button" class="btn btn-default" onclick="$(this).parent().parent().hide(\'fast\');">Anuleaza</button> </p> </div>
	</div>
  </div>'."\r\n";
}

function lista_adrese($id_companie,$print_only_li=false){
    $conturi=multiple_query("SELECT  * FROM  `adrese` 
WHERE  `adrese`.`id_companie_adresa` ='".$id_companie."' AND `adrese`.`adresa_stearsa`=0
ORDER BY  `adrese`.`default_adrese` DESC ",'ida');
    if(!$conturi){$conturi=array();}
    if(!$print_only_li){echo ' <div class="form-group">
    <label class="control-label col-sm-2" for="tip_companie">Adrese<br />
		<a href="adrese_add.php?id_companie_adresa='.$id_companie.'" class="btn btn-success pull-right iframe" title="Adauga o adresa noua"><span class="glyphicon glyphicon-plus"></span></a>
		</label>
    <div class="col-sm-10"><ul class="list-group" id="lista_adrese">';}
    foreach($conturi as $idc=>$cont){
        echo '<li class="list-group-item"><a href="adrese_add.php?edit='.$cont['ida'].'" class="iframe" id="adresa'.$cont['ida'].'" title="Editeaza acesta adresa">'.formatare_txt_adresa($cont).'</a>
		 <a class="btn btn-danger btn-xs pull-right" onclick="adrese_del_tab('.$cont['ida'].');"><span class="glyphicon glyphicon-remove"></span></a>
		</li>';
    }
    if(!$print_only_li){echo '</ul>
	<div class="alert alert-danger" role="alert" id="adrese_del_tab"> <button type="button" class="close" onclick="$(this).parent().hide(\'fast\');" ><span aria-hidden="true">×</span></button> <h4>Esti sigur ca doresti sa stergi adresa urmatoare?</h4> <p class="message_to_del">...</p>
	<p><button type="button" class="btn btn-danger adresa_to_del" onclick="dell_adresa(this);" adresa="0">Sterge</button> <button type="button" class="btn btn-default" onclick="$(this).parent().parent().hide(\'fast\');">Anuleaza</button> </p> </div>
	</div>
  </div>'."\r\n";}
}


function companii_view($data,$tip){
    echo '<table class="table table-striped table-hover table-responsive">
  <tr class="violet">
    <th scope="col">Id</th>
	<th scope="col">Tip</th>
    <th scope="col">Companie</th>
    <th scope="col">CUI</th>
    <th scope="col">Reg.Com</th>
    '.($tip!='prestator' ? '<th scope="col">Sold</th>':'').'
    <th scope="col">Cont</th>
    <th scope="col">Moneda</th>
  </tr>
';
    foreach($data as $row){
        $cont=many_query("SELECT  `conturi`. * 
FROM  `conturi` 
WHERE  `conturi`.`id_companie_cont` ='".$row['id_companie']."'
ORDER BY  `conturi`.`default_cont` DESC 
LIMIT 1");
        if(!$cont){$cont=array();}
        $row=array_merge($row,$cont);

        if($tip!='prestator') { echo '<tr class="genSelTlist" onClick="window.location='."'companie_edit.php?edit=$row[id_companie]'".';">'; }
        if($tip=='prestator') { echo '<tr class="genSelTlist" onClick="window.location='."'companie_edit.php?prestatori&edit=$row[id_companie]'".';">'; }
        echo '<td>'.h($row['id_companie']).'</td>';
        echo '<td>'.h($pateneri_rolem[$row['tip_companie']]).'</td>';
        echo '<td>'.h($row['denumire']).'</td>';
        echo '<td>'.h($row['cui']).'</td>';
        echo '<td>'.h($row['reg_com']).'</td>';
        if($tip!='prestator') {
            echo '<td>';
            if ($row['tip_companie'] == 'f') {
                echo sold($row['id_companie'], 'furnizor', true);
            }
            if ($row['tip_companie'] == 'c') {
                echo sold($row['id_companie'], 'client', true);
            }
            echo '</td>';
        }
        //echo '<td>'.h($row['nume_banca'].' '.$row['sucursala']).'</td>';
        echo '<td>'.h($row['cont']).'</td>';
        echo '<td>'.h($row['moneda']).'</td>';
        echo '</tr>'."\r\n";
    }

    echo '</table>'; }


function check_nr($tip){
    if($tip==''){return 0;}
    $facturi = multiple_query("SELECT nr_document FROM `documente` WHERE `serie_document` = '".$tip."' and nr_document > 90 ORDER BY `documente`.`nr_document` ASC",'nr_document');

    $ultimul_nr = one_query("SELECT nr_document FROM `documente` WHERE `serie_document` = '".$tip."' ORDER BY `documente`.`nr_document` DESC ");
    $i=0; $nr_lipsa = array();
    for($i=0;$i < $ultimul_nr;$i++){
        if($facturi[$i]['nr_document'] == $i) {}
        else {$nr_lipsa[] = $i;}
    }

    if(count($nr_lipsa)){
        echo 'Numere lipsa: '.$tip.' <span style="color: red;"> ';
        foreach ($nr_lipsa as $k) {
            echo $k.',';
        }
        echo '</span>'; }
    ?>
    Ultimul numar serie  : <?=$tip . ' ' .$ultimul_nr;
}

function tabel_fise($data=array()){
    global $statusuri, $culoare_status,$service, $is_admin,$userId,$culori_statusuri;


    // table table-striped table-hover table-condensed table-responsive
    echo '<table class="table table-striped table-hover table-responsive ui violet table">';
    //	<th scope="col" width="5%">#ID</th>
    echo '<tr class="violet">
		<th scope="col" width="5%">Numar</th>
		<th scope="col" width="5%">Serie</th>
		<th scope="col" width="10%">Nume client<br>Beneficiar</th>
		<th scope="col" width="10%">Persoana de contact</th>
		<th scope="col" width="10%">Adresa proiect</th>
		<th scope="col" width="10%">Data creat / preluat<br></th>
		<th scope="col" width="10%">Data masurat</th>
		<th scope="col" width="10%">Data predat acte</th>
		<th scope="col" width="10%">Data OCPI</th>
		<th scope="col" width="10%">Data ridicat OCPI</th>
		<th scope="col" width="10%">Data predat beneficiar</th>
		<th scope="col">Avans</th>
		<th scope="col">Rest</th>
		<th scope="col">Status</th>
		<th scope="col">Deschide<br>modificare</th>
		
	 </tr>';
    /* $fise = array(
      array('id' => '1','shop' => '1','preluat_de_uid' => '1','update_by_uid' => '0','data_preluare' => '2016-10-10 05:00:00','status' => '0','nume_prenume_client' => 'nume cl','telefon_client' => '67890','echipament' => 'echip','accesorii' => 'acces','stare_echipament' => 'stare','sn_echipament' => 'sn','data_iesire_service' => '2016-10-11 00:00:00')
    ); */
    $link_edit = 'ondblclick="window.location='."'/documente_edit.php?edit=";
    $link_click = 'onmousedown="window.location='."'/documente_edit.php?edit=";
    $link_click = '';
      //  prea($data);
    foreach ($data as $row){
          
        if($row['prioritate']==1){ $color_prioritate = 'red';}
        if($row['prioritate']==2){ $color_prioritate = 'orange';}
        if($row['prioritate']==3){ $color_prioritate = 'greenyellow';} ?>

        <tr class="genSelTlist">
          <!--  <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['id_doc']?></td> -->
            <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['nr_document'];?></td>
            <td <?=$link_click.$row['id_doc'].'\'"'?>><?=' '.$row['serie_document'];?></td>

            <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['denumire'];?></td>
            <td <?=$link_click.$row['id_doc'].'\'"'?>></td>
            <td <?=$link_click.$row['id_doc'].'\'"'?>><?php echo formatare_txt_adresa($row);?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['data_afisata'];?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['data_masurat']=='0000-00-00'? '' : $row['data_masurat']?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['data_predat_acte']=='0000-00-00'? '' : $row['data_predat_acte']?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['data_ocpi']=='0000-00-00'? '' : $row['data_ocpi']?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['data_ridicat_ocpi']=='0000-00-00'? '' : $row['data_ridicat_ocpi']?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['data_predat_beneficiar']=='0000-00-00'? '' : $row['data_predat_beneficiar']?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['avans_achitat']; ?></td>
       <td <?=$link_click.$row['id_doc'].'\'"'?>><?=$row['rest_de_plata']; ?></td>
       <td title="<?=$statusuri[$row['status_proiect']]?>" <?=$link_click.$row['id_doc'].'\'"'?>><div id="status_color" class="ui <?=$culori_statusuri[$row['status_proiect']]?> message"></td>
            <td <?=$link_click.$row['id_doc'].'\'"'?>><a href="<?=ROOT . 'documente_edit.php?edit='.$row['id_doc'];?>"><i class="circular edit sign icon purple"></i></a></td>
        </tr>

    <?php }
    echo '</table>';
   // prea($data);
}


function actualizat_acum_time($last_update,$time_to_update)
{ if($last_update=='' and $last_update < 1000){ return 0;}
    $last_update = time() - $last_update;
    $last_update > $time_to_update ? $color = 'red' : $color = 'green';
    $mint = $last_update / 60; //
    //echo time().' - '.$update_time.'<br>';
    //echo time()-$update_time.'<br>';
    //echo date('H:i:s');

    $zile = floor($mint / (60 * 24));
    $ore = floor(($mint - $zile * 60 * 24) / 60);
    $min = floor($mint % 60);
    //  $sec = floor($min % 60);

    //echo 'Actualizat acum '.$mint.' minute';
    echo '<span style="color: ' . $color . '">&nbsp;&nbsp; ';
    if ($zile) {
        echo ($zile < 2 ? ' ' : $zile . ' zile') . ',';
    }
    if ($ore) {
        echo ($ore < 2 ? 'o ora' : $ore . ' ore si ') . '';
    }
    if ($min) {
        echo($min < 2 ? ' un minut' : $min . ' minute');
    }
    if($min < 1){ echo '';}
    //  if ($sec) { echo($sec < 2 ? ' o secunda' : $sec . ' secunde');  }
    echo '</span>';
}
?>