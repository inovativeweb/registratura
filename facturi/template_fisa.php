<?php if(!defined('THF_PATH')){die('metoda incorecta apelare');}

define ('K_BLANK_IMAGE', '_blank.png');
define ('PDF_PAGE_FORMAT', 'A4');
define ('PDF_PAGE_ORIENTATION', 'P'); //Page orientation (P=portrait, L=landscape).
define ('PDF_CREATOR', 'TCPDF');
define ('PDF_AUTHOR', $siteAlias);
define ('PDF_HEADER_TITLE', THF_PDF_TITLE);
define ('PDF_HEADER_STRING', "http://inovativeweb.ro");
define ('PDF_UNIT', 'mm'); // Document unit of measure [pt=point, mm=millimeter, cm=centimeter, in=inch].

define ('PDF_MARGIN_HEADER', 5); //Header margin.
define ('PDF_MARGIN_FOOTER', 15); //Footer margin. define ('PDF_MARGIN_FOOTER', 10);

define ('PDF_MARGIN_BOTTOM', 5); // Bottom margin. define ('PDF_MARGIN_BOTTOM', 18);

define ('PDF_MARGIN_LEFT', 10); // Left margin.
define ('PDF_MARGIN_TOP', 24); //Top margin.
define ('PDF_MARGIN_RIGHT', 5); //Right margin.

define ('PDF_FONT_NAME_MAIN', 'times'); //Default main font name.
define ('PDF_FONT_SIZE_MAIN', 8); //Default main font size.

define ('PDF_FONT_NAME_DATA', 'times'); //Default data font name.
define ('PDF_FONT_SIZE_DATA', 8); // Default data font size.

define ('PDF_FONT_MONOSPACED', 'courier'); //Default monospaced font name.
define ('PDF_IMAGE_SCALE_RATIO', 1.25); //Ratio used to adjust the conversion of pixels to user units.
define('HEAD_MAGNIFICATION', 1.1); //Magnification factor for titles.
define('K_CELL_HEIGHT_RATIO', 1.25);  //Height of cell respect font height.
define('K_TITLE_MAGNIFICATION', 1.3); //Title magnification respect main font size.
define('K_SMALL_RATIO', 2/3); //Reduction factor for small font.
define('K_THAI_TOPCHARS', true); //Set to true to enable the special procedure used to avoid the overlappind of symbols on Thai language.

//If true allows to call TCPDF methods using HTML syntax
//IMPORTANT: For security reason, disable this feature if you are printing user HTML content.
define('K_TCPDF_CALLS_IN_HTML', true);
 
//If true and PHP version is greater than 5, then the Error() method throw new exception instead of terminating the execution.
define('K_TCPDF_THROW_EXCEPTION_ERROR', false);

require_once(THF_FUNC.'tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
	public $thf_header='Header default...';
	public $thf_footer='Footer default...';
	 
	public function Header() { //Page header 		
		$this->SetFont('dejavusans', '', 8);
		$tmp=$this->thf_header;
		//if($this->getAliasNumPage()==2 ){return;}
		$this->writeHTML( $tmp, true, false, true, false, '');
		}

	// Page footer
	public function Footer() { //Page header
		//$this->SetY(-PDF_MARGIN_BOTTOM); // Position at 15 mm from bottom
		$this->SetFont('dejavusans', 'I', 8);		
//		$this->writeHTML($this->GetY(), true, false, true, false, '');
		$tmp=$this->thf_footer;
		$tmp=str_replace('[pag_curenta]','PAG:'.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),$tmp);
		$this->writeHTML( $tmp , true, false, true, false, '');

//		$this->writeHTML( 'PAG:'.$this->getAliasNumPage().' / '.$this->getAliasNbPages() , true, false, true, false, '');
		// writeHTML ($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
	}
}


// create new PDF document
//$header=explode('<!--header-->',$html);	$html=$header[1]; 	$header=$header[0]; 
//$footer=explode('<!--footer-->',$html);	$html=$footer[0];   $footer=$footer[1];	
$header = '';
$footer = '';
//echo $header; echo $html; echo $footer; die;

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->thf_header = $header;
$pdf->thf_footer = $footer;

$pdf->setFontSubsetting(false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('seficho.com '.date('Y'));
$pdf->SetTitle(THF_PDF_TITLE);
$pdf->SetSubject(THF_PDF_TITLE);
$pdf->SetKeywords(THF_PDF_TITLE);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('dejavusans', '', 8);


// add a page
$pdf->AddPage();
//$pdf->AddPage("L");
//$pdf->SetPrintHeader(false);
//if($user['spatiu_header']=='a'){$pdf->SetY(36);} else{$pdf->SetY(30);}
$nr_pag=$pdf->getAliasNbPages(); @$nr_pag++; @$nr_pag--;
$html=str_replace('[nrtpg]',$nr_pag,$html);
//echo $html; die;
//$html='<h1>OKK</h1>';

$pbreaky=35; //estimare lungime continut care o sa urmeze; o pagina a4 are inaltimea totala de 300 unitati din care se scad headere si footere si paddinguri

if(isset($pbreaky) && substr_count($html,'@pbreaky@')){
	$html=explode('@pbreaky@',$html);
	//prea($html);die;
/*	$pdf->writeHTML($html[0], true, false, true, false, '');
//	$pdf->writeHTML($pdf->GetY(), true, false, true, false, '');
	if($pdf->GetY()>=(285-$pbreaky)){$pdf->AddPage();}
	$pdf->writeHTML($html[1], true, false, true, false, '');
//	$pdf->writeHTML($pdf->GetY(), true, false, true, false, ''); */


	foreach($html as $i=>$htm){
		if($i>0){
			if($i==2){
			
				$pdf->AddPage('L');}
			else { $pdf->AddPage();}
			}
		$pdf->writeHTML($htm, true, false, true, false, '');
		}

	}
else{$pdf->writeHTML($html, true, false, true, false, '');}

$pdf->lastPage();// reset pointer to the last page


$pdf_filename=THF_UPLOAD.'PROFORME/'.('proforma-'.(isset($_GET['idf']) ? $_GET['idf'] : $idf).'.pdf');


$pdf->Output($pdf_filename, 'F');//Close and output PDF document
 $cale='http://'.$_SERVER['SERVER_NAME'].ROOT.'dms/PROFORME/'.'proforma-'.$_GET['idf'].'.pdf';
//$pdf->Output(s(THF_PDF_TITLE.'_'.date('Y-m-d').'.pdf'), 'I');

if(!$save_pdf) {
    $content = file_get_contents($cale);
    header('Content-type: application/pdf');
//header('Content-Disposition: attachment; filename=filename.pdf');
    echo $content;
}

    


?>