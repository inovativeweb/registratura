<?php
require_once( '../config.php' );
error_reporting (0);
$page_head[ 'title' ] = 'Adauga afacere';
$page_head[ 'trail' ] = 'afaceri_vanzare';
require_login();
require ('controller.php');
//die("Not yet implemented");
$data = ($vanzari[$_GET['edit']]);

if(!isset($_GET['lang'])){ $_GET['lang'] = 'ro'; }

$img = json_decode($data[atasamente],true);


//prea($data);
//prea($domenii_afacere);
?>
<link rel='stylesheet' id='validate-engine-css-css'  href='https://trade-x.ro/wp-content/plugins/wysija-newsletters/css/validationEngine.jquery.css?ver=2.8.1' type='text/css' media='all' />
<link rel='stylesheet' id='wp-block-library-css'  href='https://trade-x.ro/wp-includes/css/dist/block-library/style.min.css?ver=5.0.3' type='text/css' media='all' />
<link rel='stylesheet' id='css-wpautbox-tab-css'  href='https://trade-x.ro/wp-content/plugins/Archive/lib/css/jquery-a-tabs.css' type='text/css' media='all' />
<link rel='stylesheet' id='css-wpautbox-css'  href='https://trade-x.ro/wp-content/plugins/Archive/lib/css/wpautbox.css' type='text/css' media='all' />
<link rel='stylesheet' id='wpautbox-elusive-icon-css'  href='https://trade-x.ro/wp-content/plugins/Archive/includes/ReduxFramework/ReduxCore/assets/css/vendor/elusive-icons/elusive-icons.css?ver=5.0.3' type='text/css' media='all' />
<link rel='stylesheet' id='contact-form-7-css'  href='https://trade-x.ro/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=5.0' type='text/css' media='all' />
<link rel='stylesheet' id='wcjp-frontend.css-css'  href='https://trade-x.ro/wp-content/plugins/custom-css-js-php/assets/css/wcjp-frontend.css?ver=5.0.3' type='text/css' media='all' />
<link rel='stylesheet' id='wpfp_afaceri-public-style-css'  href='https://trade-x.ro/wp-content/plugins/featured-post-creative-afaceri/assets/css/wpfp_afaceri-public.css?ver=1.1' type='text/css' media='all' />
<link rel='stylesheet' id='wpfp-public-style-css'  href='https://trade-x.ro/wp-content/plugins/featured-post-creative/assets/css/wpfp-public.css?ver=1.1' type='text/css' media='all' />
<link rel='stylesheet' id='custom-article-cards-css'  href='https://trade-x.ro/wp-content/plugins/divi-100-article-card/assets/css/style.css?ver=20160602' type='text/css' media='all' />
<style id='custom-article-cards-inline-css' type='text/css'>
    .divi-100-article-card .et_pb_blog_grid .article-card__category,
    .divi-100-article-card .et_pb_blog_grid .article-card__date { background-color: #c16a10; }
    .divi-100-article-card .et_pb_blog_grid .article-card__sub-title { color: #c16a10; }
</style>
<link rel='stylesheet' id='parent-style-css'  href='https://trade-x.ro/wp-content/themes/Divi/style.css?ver=5.0.3' type='text/css' media='all' />
<link rel='stylesheet' id='child-style-css'  href='https://trade-x.ro/wp-content/themes/Divi-child/style.css?ver=1.0.0' type='text/css' media='all' />
<link rel='stylesheet' id='divi-fonts-css'  href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&#038;subset=latin,latin-ext' type='text/css' media='all' />
<link rel='stylesheet' id='et-gf-montserrat-css'  href='https://fonts.googleapis.com/css?family=Montserrat:400,700&#038;subset=latin' type='text/css' media='all' />
<link rel='stylesheet' id='et-gf-open-sans-css'  href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&#038;subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' type='text/css' media='all' />
<link rel='stylesheet' id='divi-style-css'  href='https://trade-x.ro/wp-content/themes/Divi-child/style.css?ver=3.0.9' type='text/css' media='all' />
<link rel='stylesheet' id='et-shortcodes-css-css'  href='https://trade-x.ro/wp-content/themes/Divi/epanel/shortcodes/css/shortcodes.css?ver=3.0.9' type='text/css' media='all' />
<link rel='stylesheet' id='et-shortcodes-responsive-css-css'  href='https://trade-x.ro/wp-content/themes/Divi/epanel/shortcodes/css/shortcodes_responsive.css?ver=3.0.9' type='text/css' media='all' />
<link rel='stylesheet' id='magnific-popup-css'  href='https://trade-x.ro/wp-content/themes/Divi/includes/builder/styles/magnific_popup.css?ver=3.0.9' type='text/css' media='all' />


<article id="post-3825" class="et_pb_post post-3825 afacere type-afacere status-publish has-post-thumbnail hentry">
    <div class="et_post_meta_wrapper">
        <h1 class="entry-title">   <?=$_GET['lang'] != 'en' ? $data['denumire_afacere'] : $data['denumire_afacere_en'];?></h1>

        <p class="post-meta"></p>
    </div> <!-- .et_post_meta_wrapper -->

    <div class="entry-content">
        <div class="afacere">
            <div class="nume_afacere">
                <h1>
                    <?=$_GET['lang'] != 'en' ? $data['denumire_afacere'] : $data['denumire_afacere_en'];?>
                </h1>
            </div>
            <div class="ID">ID afacere: <?=$data['idv']?></div>
            <!-- se doreste o singura imagine arsociata informatiilor listate, in locul galeriei -->
            <div class="image"><img style="max-height: 300px; width: auto" src="<?=$img[0]?>" class="attachment-large size-small" alt="<?=$data['denumire_afacere']?>"></div>

            <div class="info_generale">
                <div class="span12">
                    <div class="linie date_financiare">
                        <div class="span6 specs">
                            <p class="price selling finan"><span class="title"> <?=$_GET['lang'] == 'en' ? 'Sale price:' : 'Pret de vanzare:'?><strong> <?=number_format($data['pret_vanzare'], 2, ',', '.')?> EUR</strong></span></p>
                        </div>
                        <div class="span6 specs">
                            <p class="price selling finan"><span class="title"> <?=$_GET['lang'] == 'en' ? 'Annual sales:' : 'CA Anuala:' ?></span><strong><?=number_format($data['cifra_afaceri'], 2, ',', '.')?> RON</strong></p>
                        </div>
                    </div>
                    <div class="linie">
                        <div class="span6 specs">
                            <p class="finan"><span class="title"> <?=$_GET['lang'] == 'en' ? 'Total Real Estate Value:' : 'Total Patrimoniu Imobiliar:'?><strong><?=(is_numeric($data['patrimoniu_imobiliar'])&& ($data['patrimoniu_imobiliar']>0))? number_format($data['patrimoniu_imobiliar'], 2,',','.'): '-' ?> EUR</strong></span></p>
                        </div>
                        <div class="span6 specs">
                            <p class="finan"><span class="title"> <?=$_GET['lang'] == 'en' ? 'Annual Profit:' : 'Profitul anual: '?><strong><?=number_format($data['profit_anual'], 2, ',', '.')?> RON</strong></span></p>

                        </div>
                    </div>
                </div>
            </div>
            <!-- se doreste afisare descrierii scurte pt vizitatorii site-lui -->
            <?php
            if ($_GET['lang'] == 'ro') {
                ?>
                <div class="descriere_lunga"><strong>SCURTA DESCRIERE: </strong>
                    <?= $data['descriere_publica'] ?>
                </div>

                <?php
            } else  { ?>
                <div class="descriere_lunga"><strong>SHORT DESCRIPTION: </strong>
                <?= $data['descriere_publica_en'] ?>
                </div>
            <?php }  ?>


            <div class="tabel_info">

                <div class="motto"><hr><p><?=$_GET['lang'] == 'ro' ? 'Informatii detaliate' :'Detailed information'?></p></div>
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td><?=$_GET['lang'] == 'ro' ? 'Domeniul de activitate:' :'Detailed information'?></td>
                        <td><?=$domenii_afacere[explode(',', $data['domeniu_activitate'])[0]]?></td>
                    </tr>
                    <tr>
                        <td><?=$_GET['lang'] == 'ro' ? 'Afacere stabilita in data de:' :'Business established in:'?></td>
                        <td><?=ro_date($data['data_stabilire'])?></td>
                    </tr>
                    <tr>
                        <td><?=$_GET['lang'] == 'ro' ? 'Finantarea vanzatorului/banci:' :'Seller Financing / Banking:'?></td>
                        <td><?=$data['tip_finantare']?></td>
                    </tr>
                    <tr>
                        <td><?=$_GET['lang'] == 'ro' ? 'Inventarul inclus in pret?' :'Inventory included in the price?'?></td>
                        <td>
                           
                            <?=
                            $_GET['lang'] == 'ro' ?  ($data['inventar_inclus_in_pret'] == 'da' ? 'Da': 'Nu')

                            :

                                ($data['inventar_inclus_in_pret'] == 'da'  ? 'Yes': 'No')?>
                        </td>
                    </tr>
                    <tr>
                        <td><?=$_GET['lang'] == 'ro' ? 'Numar de angajati:' :'Number of Employees:'?></td>
                        <td><?=$data['nr_angajati']?></td>
                    </tr>
                    <tr>
                        <td><?=$_GET['lang'] == 'ro' ? 'Suport si training:' :'Support and training:'?></td>
                        <td><?= $_GET['lang'] == 'en' ?  $data['suport_en'] :  $data['suport']?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="info_uzuale">
                    <?= $_GET['lang'] == 'ro'  ? 'Datele si informatille prezentate pe site au fost furnizate de catre vanzatori/reprezentantii societatilor comerciale detinatoare a afacerilor. Business Escrow SRL, nu a verificat independent niciuna dintre informatiile furnizate de catre acestia si nu isi asuma nicio responsabilitate pentru exactitatea sau legalitatea acestora.'
                     :
                    'The data and information presented on the site were provided by the sellers / representatives of the business companies owning the business. Business Escrow SRL has not independently verified any of the information provided by them and assumes no responsibility for the accuracy or legality of such information.'?>
                </div>
            </div>




        </div>					</div> <!-- .entry-content -->

</article>