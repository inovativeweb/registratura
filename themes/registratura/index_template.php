<?php
//$breadcrumb[]=array('/','OnBreak.ro','alt title'); // link nume link descriere
function theme_404($title='404 Not Found',$code=404){
//	redirect($code=302,$location='/'); die;
	if($code==404){header('HTTP/1.0 404 Not Found',true,404);}
	else{header( "HTTP/1.1 410 Gone",true,410 );$title='HTTP/1.1 410 Gone'; }

	$page_head=array(
		'title'=>$title,
		);
	index_head();
	echo '<h1 align="center" style="margin-bottom:100px;">'.$title.'!</h1>
		  <h2 align="center" style="margin-bottom:300px;"><em>'.h($_SERVER['REQUEST_URI']).'</em></h2>';
	index_footer();
	die;
	}







function subFuncMenuSel($itemCode,$inclass=false){ global $page_head;
	if(in_array($itemCode,$page_head['trail'])){
		if(!$inclass){echo ' class="active"';}
		else{ echo ' active';}
		}
	}

function index_head(){
global $page,$users,$page_head,$breadcrumb,$work_table,$selected_html_lang,$siteAlias,$siteMotto,$siteDescription,$home_title,$thf_secret,$debug_thorr,$tipuri_documente,$document;



if(isset($page['updated_at'])){	header('Last-Modified: '.date('D, d M Y H:i:s T',strtotime($page['updated_at'])));	}



?><!DOCTYPE html>
<html lang="<?php echo ISO_LNG; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="follow" />
<!--
<link href='https://fonts.googleapis.com/css?family=Open+Sans&subset=latin,greek,latin-ext,greek-ext,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
-->
<?php



//if(isset($page_head['title']) && strlen($page_head['title'])>0){} else{$page_head['title']='Pizza Pazza Brasov comenzi ';}

if(strlen($page_head['meta_title'])>3) {echo '<title>'.h($page_head['meta_title']).'</title>'.PHP_EOL;}
else {									echo '<title>'.COMPANY.'</title>'.PHP_EOL; }
if(isset($page_head['description']) && strlen($page_head['description'])>0){echo '<meta name="description" content="'.h($page_head['description']).'" />'.PHP_EOL;}
else {echo '<meta name="description" content="" />'.PHP_EOL;}

if(isset($page_head['keywords']) && strlen($page_head['keywords'])>0){echo '<meta name="keywords" content="'.h($page_head['keywords']).'" />'.PHP_EOL;}
else {echo '<meta name="keywords" content="" />'.PHP_EOL;} ?>

<?php
generate_js_css_html_includes(array('thf','dropdownchosen','colorbox','tinymce','semantic','bootstraptoggle','bootstrap','jqueryuitime','fa4', 'formTools', 'bootstrap_fileinput',/*'jquerybootgrid',*/));
	
	
echo '<link rel="stylesheet" href="'.f(THEME.'js_css/general_marius.css').'" />';
echo '<link rel="stylesheet" href="'.f(THEME.'js_css/general_alex.css').'" />';
echo '<link rel="stylesheet" href="'.f(THEME.'js_css/general_cristi.css').'" />';
//echo '<link rel="stylesheet" href="'.f(THEME.'js_css/sidebar.min.css').'" />';
echo '<script src="'.f(THEME.'js_css/general_marius.js').'"></script>';
echo '<script src="'.f(THEME.'js_css/general_alex.js').'"></script>';
echo '<script src="'.f(THEME.'js_css/general_cristi.js').'"></script>';
//echo '<script src="'.f(THEME.'js_css/sidebar.min.js').'"></script>';
?>  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <?php
if(!isset($page_head['trail'])){$page_head['trail']='';}
$page_head['trail']=explode('|',$page_head['trail']);
?>

<link rel="shortcut icon" href="<?php echo MEDIA?>fav_ico.png" type="image/ico"/>
</head>
<body class="ury push_me_left_30percent">
<?php if(!$GLOBALS["login"]->is_logged_in() && substr_count($_SERVER['REQUEST_URI'],'/reset_pass/')<1){
    echo '<style>
	body{margin-top:15% !important; 
    height: 1200px; width: auto;   
    font-size: 14px;
    color: #393939;
    line-height: 1.5;}
	@media (min-width:1360px){  body{
		background: url("/media/login-background3.jpg");
		background-size: 100%;
		background-repeat: no-repeat; 
	} }</style>';
	$GLOBALS["login"]->sign_in_form(); index_footer(); die();}
	?>
<nav class="navbar navbar-default navbar-fixed-top hidden-md hidden-lg" style="height: 60px">
<div class="col-xs-12 " align="right"  id="mobile_menu_btn">

    <div class="col-xs-8" style="display: inline-block; float: left;">
        <div class="ui  image" align="center">
            <a style="margin:0; padding:0; width: 100%;" href="<?php echo LROOT; ?>">
                <img  id="logo_firma" src="<?=MEDIA?>logo.png" class="img img-responsive" style="max-height: 48px" /> </a>
        </div>
    </div>
    <a class="btn round border vfx" style="display: inline-block; float: right;"><i class="fa fa-bars" style="font-size:1.7em;"></i></a>
    <div class="clear"></div>
</div>
</nav>
<!--   MODAL   SEARCH -->


<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog" style=" top: 10%; width: 90%; margin-left: 5%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" >
                <div class="container-fluid">
                    <form id="" action="/cauta/" method="get" enctype="application/x-www-form-urlencoded">
                        <div class="row">
                            <div class="col-sm-10 col-xs-10">

                                <input name="search" id="search_in_modal" autofocus autocomplete="off" type="text" class="form-control" data-action="grow" placeholder="Cauta..." style="width:100%; font-size:3em; height: 100px">
                            </div>
                            <div class="col-xs-2 col-sm-1 text-right">
                                <button type="submit" title="Caută" class="close" style="opacity: 1"><i class="icon icon2-search-thin pink m3"></i></button>
                            </div>
                            <div class="col-sm-1">
                                <button title="Sterge textul" type="button" class="close" onmousedown="$('#search_in_modal').val('');">sterge</button></div>
                        </div>
                    </form>
                </div>
                <div id="modal_data_raspuns">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>

            </div>
        </div>
    </div>
</div>
<!--   MODAL    -->


<div id="pushed_body_thf">
<div class="container-fluid">



	<div style="height: 30px;" id="div_raspuns_mesaj" class="navbar-fixed-top"></div>
	<main style="min-height: 900px;">
		<div class="container-fluid">
			<div class="row">

				
				<div class="col-md-2 col-sm-12 vfx" id="side_bar_left">
					<div style="margin: 3em 0;"><?php if($GLOBALS["login"]->is_logged_in()){ side_bar_left(); } ?></div>
				</div>
			    <div id="document_preview"></div>
				<div class="col-md-10 col-sm-12 vfx" id="page_content">
				<div class="" style="margin: 45px 0;"></div>

<?php
    $GLOBALS['index_head'] = true;
}//end of index_header



function page_content(){ global $serie_contract,$page,$slug,$page_head,$breadcrumb,$work_table,$thf_secret,$parent_trail,$debug_thorr;
	echo '<h1>function page_content</h1><div class="clear"></div>';
}//end of index_content



function index_footer(){  global $access_level_login,$login_user,$serie_contract,$page,$slug,$page_head,$breadcrumb,$work_table,$debug_thorr, $statusuri; ?>
				</div>
			</div>
		</div>
	</main>





    <footer>
        <?php if($GLOBALS["login"]->is_logged_in()){ ?><?php if($GLOBALS['login']->get_user_level()==10 || 1){?>
            <div class="container-fluid">
            <div class="row">
            <div class="col-xs-12 navbar-default navbar navbar-bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>


            <td width="15%">Powered by<br /><a href="http://inovativeweb.ro" target="_blank">
                    <img src="/media/inovative_logo_2017_300.png" width="75" height="auto" /></a></td>
            <td width="50%">

            </td>
            <td width="25%"></td>

            <td><div align="right"><a href="mailto:support@inovativeweb.ro?Subject=Suport%20CMS" target="_top">Support</a></div></td><?php } ?>

            </tr>
            </table>
            </div>
            </div>
            </div>
        <?php } ?>
    </footer>
</div><!-- container fluid -->

</div>
<div id="pusher_dimmer_thf"></div>
<div id="push_sidebar_thf"><button type="button" class="close pushMeThfClose" aria-label="Close"></button></div>

</body>
</html>





<?php
$GLOBALS['index_head'] = true;					
$GLOBALS['index_footer'] = true;
}



function iframe_head(){ global $page,$slug,$page_head,$breadcrumb,$work_table,$selected_html_lang,$siteAlias,$siteMotto,$siteDescription,$home_title,$thf_secret,$debug_thorr;
?><!DOCTYPE html>
<html lang="<?php echo ISO_LNG; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
generate_js_css_html_includes(array('thf','dropdownchosen','colorbox','tinymce','semantic','bootstraptoggle','bootstrap','jqueryuitime','fa4', 'formTools', 'bootstrap_fileinput',/*'jquerybootgrid',*/));
			   
					   
echo '<link rel="stylesheet" href="'.f(THEME.'js_css/general_marius.css').'" />';
echo '<link rel="stylesheet" href="'.f(THEME.'js_css/general_alex.css').'" />';
echo '<link rel="stylesheet" href="'.f(THEME.'js_css/general_cristi.css').'" />';
echo '<script src="'.f(THEME.'js_css/general_marius.js').'"></script>';
echo '<script src="'.f(THEME.'js_css/general_alex.js').'"></script>';
echo '<script src="'.f(THEME.'js_css/general_cristi.js').'"></script>';
 ?>

  
  
<style>
html,body{margin:0; padding:0; height:100%; width:100%;}
</style>
</head><body class="ury">
<?php if(!$GLOBALS["login"]->is_logged_in()){$GLOBALS["login"]->sign_in_form(); iframe_footer(); die();} ?>
<?php }

function iframe_footer(){  global $page,$slug,$page_head,$breadcrumb,$work_table,$debug_thorr; ?></body></html><?php }

?>