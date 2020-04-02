<?php
require_once('config.php');

$save_pdf = false;



if(!isset($_GET['id_doc'])){redirect(307,'/');die;}
$_GET['id_doc']=@floor($_GET['id_doc']);



if(isset($_GET['template_contracte'])) {
    $id_doc = $_GET['id_doc'];
    $id_template = $_GET['id_template'];
    $docs = many_query("SELECT * FROM `documente_propietati` 
        LEFT JOIN template_contracte ON id = valoare
        WHERE id_doc = '". $id_doc ."' and cheie = 'template_doc_iesire' and valoare= $id_template") ;

    define('THF_PDF_TITLE', 'Contract '.$emitent['denumire'] . '-' . $document['nr_document']);
    define('PDF_MARGIN_TOP', 24); //Top margin.
    define ('PDF_MARGIN_HEADER', 5); //Header margin.
    define('PDF_MARGIN_FOOTER', 25); //Footer margin. define ('PDF_MARGIN_FOOTER', 10);
    define('PDF_MARGIN_BOTTOM', 29); // Bottom margin. define ('PDF_MARGIN_BOTTOM', 18);
    define ('PDF_PAGE_ORIENTATION', 'P'); //Page orientation (P=portrait, L=landscape).

    ob_start();
    echo $docs['json'];
    $html = ob_get_contents();
    ob_end_clean();
    $footer = '<hr>
            <span style="text-decoration: underline">CONTACT: Business Escrow</span>
            Adresa:                   Brasov, Str. Mihail Kogalniceanu, Nr. 18-20<br>
            Telefon:                                                                                 +40 799 977 707<br>
            Program: Luni – Vineri, 10:00am-4:00pm
            ';

}


if(isset($_GET['view'])){ echo $html;    echo $footer;    die; }

require_once('pdf_template.php');
?>