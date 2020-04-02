<?php
//die('xxxx');
if(!is_file('./config.php')){require_once('./setup.php');die;}
else{require_once('./config.php');}


//if(!isset($_COOKIE['test'])){echo '<img src="/1.png" /><br />'.date('Y-m-d H:i');die();}

/*$tmp=slug_language_detect();
define("DEF_LNG",$tmp['def_lng']);
define("SELECTED_HTML_LANG",$tmp['selected_html_lang']);
define("PRESLUG",$tmp['preslug']);
define("LROOT",$tmp['lroot']);
define("ISO_LNG",$tmp['iso']);
$_SERVER['REQUEST_URI_NEW']=$tmp['request_uri_new'];
$slug=$tmp['slug'];		//	if($slug==''){$slug='/';} //old vers
$work_table=$tmp['work_table'];
$blog_table=$tmp['blog_table'];
$blog_table='blog';*/



$slug=SLUG;		//	if($slug==''){$slug='/';} //old vers
$work_table=WORK_TABLE;
$blog_table=BLOG_TABLE;


header('Content-language: '.ISO_LNG);


$breadcrumb=array();
$breadcrumb[]=array(LROOT,$siteAlias);


if(is_db_table($th_mysql_cfg['tbl_prefix'].'headers')){
	$rows=multiple_query("SELECT * FROM `".$th_mysql_cfg['tbl_prefix'].'headers'."`");
	foreach($rows as $row){
		if($_SERVER['REQUEST_URI']==$row['slug']){
			if($row['header_code']==301 || $row['header_code']==307){
				redirect($row['header_code'],$row['new_slug']);
				}
			elseif($row['header_code']==404){theme_404();}
			elseif($row['header_code']==410){theme_404('Pagina inexistenta.',410);}
			else{break;}
			}
		}
	
	
	}



$thf_rewrite=false;
if(is_db_table($th_mysql_cfg['tbl_prefix'].'rewrite_link')){
	$rewrites=multiple_query("SELECT * FROM `".$th_mysql_cfg['tbl_prefix'].'rewrite_link'."` ORDER BY `id` DESC");
	foreach($rewrites as $rewrite){
		if(substr($slug,0,strlen($rewrite['rewrite']))==$rewrite['rewrite']){
			//echo $sub_slug.'~~'; die;
			//echo serialize(array('blog'=>'articol_blog.php','thf_categories'=>'blog.php',)); die;
			$sub_slug=substr($slug,strlen($rewrite['rewrite']));
			$sub_views=unserialize($rewrite['view']);
			$sub_slug_arr=explode('/',$sub_slug);
			
			if(is_array($sub_views)){
				foreach($sub_views as $view_tbl=>$view_file){				
					if($rewrite['explode_slug'] && is_array($sub_slug_arr) && count($sub_slug_arr)>0){
						$tquery='';
						foreach($sub_slug_arr as $ssav){
							if($ssav!=''){$tquery.="`slug`='".q($ssav)."' OR";}
							}
						$tquery=trim($tquery,' OR');
						}
					else{$tquery="`slug`='".q($sub_slug)."'";}
					if(strlen($tquery)<5){theme_404();die;}
					$page=many_query("SELECT * FROM `".$view_tbl."` WHERE (".$tquery.")  LIMIT 1 ");
					if(count($page)>1){
						if(isset($page['view']) && strlen($page['view'])>4){}
						else{$page['view']=$view_file;}
						//$work_table=$view_tbl;
						$thf_rewrite=true;
						break;
						}
					}
				if(count($page)>1){break;}
				}
			}
		}
	}

//prea(slug_language_detect());

if(!$thf_rewrite){
	$page=many_query("SELECT * FROM `".$work_table."` WHERE `slug`='".q($slug)."'  LIMIT 1 ");
	if(count($page)<6 && is_db_table($blog_table)){	$pageb=many_query("SELECT * FROM `".$blog_table."` WHERE `slug`='".q($slug)."' AND `category_id`='0' LIMIT 1 ");}
//	$pageb=many_query("SELECT * FROM `".$blog_table."` WHERE `slug`='".q($slug)."' AND `category_id`='0' LIMIT 1 "); ///?????????????? duplicat wtf dc?
	if(count($page)>5){
		$page_head=array(
			'title'=>$page['title'],
			'description'=>$page['meta_description'],
			'keywords'=>$page['meta_keywords'],
			);
		if(isset($page['view']) && $page['view']!='' && is_file(THF_THEME.'views/'.$page['view'])){ require_once( THF_THEME.'views/'.$page['view'] );}
		else{
			index_head();
			page_content();
			index_footer();
			}
		}
	elseif(isset($pageb) && count($pageb)>5){
		$page=$pageb;
		$page_head=array(
			'title'=>$page['title'],
			'description'=>$page['meta_description'],
			'keywords'=>$page['meta_keywords'],
			);
		require_once( THF_THEME.'views/articol_blog.php' );
		}
	else{theme_404();}
	}
elseif(isset($page['view']) && $page['view']!='' && is_file(THF_THEME.'views/'.$page['view'])){
	$page_head=array(
		'title'=>$page['title'],
		'description'=>$page['meta_description'],
		'keywords'=>$page['meta_keywords'],
		);
	require_once( THF_THEME.'views/'.$page['view'] );
	}
else{theme_404();}



?>