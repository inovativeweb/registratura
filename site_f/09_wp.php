<?php
//https://trade-x.ro/admin_bs23d/
//Cristian Uricariu
//Kk54EvnFuzY5x5)f

//wp_term_taxonomy   structura judete
//wp_terms
//wp_posts
//wp_postmeta



/*
$statusuri=array(
    0=>'Draft',
	1=>'Asteapta Aprobare',
	3=>'Publicat',
	5=>'In Escrow',
	7=>'Arhivat',
	9=>'Sters',
	);
*/ 


/*
INSERT INTO `wp_podsrel` (`id`, `pod_id`, `field_id`, `item_id`, `related_pod_id`, `related_field_id`, `related_item_id`, `weight`) VALUES (NULL, '60', '75', '6016', NULL, NULL, '6017', '0');

*/


/* metadata table
meta_id	post_id	meta_key	meta_value
35444	4201	_edit_lock	1540411804:47
35445	4201	_edit_last	9
35646	4201	_wpfp_afaceri_featured_post	1
35861	4201	_thumbnail_id	4270
35862	4201	nume_afacere_si_descriere_ascunsa	
35863	4201	motto_afacere	"A bottle of wine contains more philosophy than any other book in the world."
35864	4201	strada	Diaconul Coresi
35865	4201	nr	6
35866	4201	continuare_adresa	
35867	4201	cifra_de_afaceri	500000
35868	4201	profitul_annual	0
35869	4201	afacere_data	4/18/18
35870	4201	vanzator_finantare	
35871	4201	total_patrimoniu	0
35872	4201	goodwill	0
35873	4201	trademark	0
35874	4201	pret_vanzare	90000
35875	4201	materie_prima	598000
35876	4201	pret_inclus	0
35877	4201	numar_angajati	4
35878	4201	expansiune	
35879	4201	training	Yes
35880	4201	motivul_vanzari	Multiple businesses
35881	4201	telefon_companie	0744 317 613 
35882	4201	website	
35883	4201	social_media	https://www.facebook.com/Le-Sommelier-Brasov-310875502666361/
35884	4201	nume_firma	
35907	4201	_pods_imagine_afacere	a:1:{i:0;i:4270;}
42332	4201	identificator_unic_afacere	103
49856	4201	_pods_categorie_afacere	a:1:{i:0;i:56;}
49857	4201	categorie_afacere	56
49859	4201	_pods_judet	a:1:{i:0;i:145;}
49860	4201	judet	145
49862	4201	_pods_oras	a:1:{i:0;i:146;}
49863	4201	oras	146
49865	4201	imagine_afacere	4270
*/



function export_vanzare_to_wp($id_vanzare){

	$v = many_query("SELECT * FROM `vanzare`
  LEFT JOIN companie  on companie_vanzare = companie.id_companie
  WHERE idv='".q($id_vanzare)."' LIMIT 1");
	$judet=	one_query("select nume_judet from localizare_judete where id='".$v['judet_id']."'");
	$localitate=	one_query("select localitate from localizare_localitati where id='".$v['localitate_id']."'");
	if (!$v['data_publicare']) $v['data_publicare']=date("Y-m-d H:i:s");
	$atasamente=json_decode($v['atasamente']);

	
	$image_name=substr($atasamente[0],strrpos($atasamente[0],"/")+1,strlen($atasamente[0]));
	
	
	if($v['status']==3 || $v['post_ro'] || $v['post_en']){} //exista date pentru publicare / update linii wp
	else{return 'Date incomplete publicare';}
	
	
	$user_id=one_query("select wp_user_id from thf_users where id='".$v['uid']."'");
	if ($user_id>0){}
	else
	{
		$user_id=insert_update_user($v['uid']);
	}
	$wp_posts=array(
	//	'ID'=>NULL,
		'post_author'=>$user_id,
		'post_date'=>$v['data_publicare'],
		'post_date_gmt'=>gmdate('Y-m-d H:i:s',strtotime($v['data_publicare'])),
		'post_content'=>$v['descriere_publica'],	
		'post_title'=>h($v['denumire_afacere']), //LE SOMMELIER -WINE BAR &amp; BISTRO',  //titlu
		'post_status'=>(($v['status']==3 ) ?'publish':'draft'),		//auto-draft,draft,inherit,private,publish
		'comment_status'=>'closed',
		'ping_status'=>'closed',
		'post_password'=>NULL,
		'post_name'=>strtolower(s($v['denumire_afacere'])),
		'to_ping'=>NULL,
		'pinged'=>NULL,
		'post_modified'=>$v['last_update'],
		'post_modified_gmt'=>gmdate('Y-m-d H:i:s',strtotime($v['last_update'])),
		'post_content_filtered'=>'',
		'post_parent'=>0,
		'guid'=>'', ///?????self id
		'menu_order'=>0,
		'post_type'=>'afacere', //left join cheie parinte,,,
		'post_mime_type'=>NULL, //????null
		'comment_count'=>'0',
		'post_excerpt'=>NULL,
	);	
	
	thfQsdb('r53562busi_TradeX'); //select WP database
	$judet_id=one_query("select wt.term_id from wp_terms wt left join wp_term_taxonomy wtt on wt.term_id=wtt.term_id where wt.name='$judet' and wtt.taxonomy='judet'");
	if ($judet_id==0)
	{
		$judet_id=insert_qa('wp_terms',array("name"=>$judet,"slug"=>$judet,"term_group"=>0),$keys_to_exclude=array('id'),$setify_only_keys=array(),$return_query=false);
		$judet_id_en=insert_qa('wp_terms',array("name"=>$judet,"slug"=>$judet.'-en',"term_group"=>0),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
		insert_qa('wp_term_taxonomy',array("term_id"=>$judet_id,"taxonomy"=>"judet"),$keys_to_exclude=array('term_taxonomy_id'),$setify_only_keys=array(),$return_query=false);
		insert_qa('wp_term_relationships',array("object_id"=>$judet_id,"term_taxonomy_id"=>'284'),$keys_to_exclude=array(),$setify_only_keys=array(),$return_query=false);
	
	}
	$localitate_id=one_query("select wt.term_id from wp_terms wt left join wp_term_taxonomy wtt on wt.term_id=wtt.term_id where wt.name='$localitate' and wtt.taxonomy='oras' and parent='$judet_id'");
	if ($localitate_id==0)
	{
		$localitate_id=insert_qa('wp_terms',array("name"=>$localitate,"slug"=>$localitate,"term_group"=>0),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
		$localitate_id_en=insert_qa('wp_terms',array("name"=>$localitate,"slug"=>$localitate."-en","term_group"=>0),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
		$term_taxonomy_id_loc=insert_qa('wp_term_taxonomy',array("term_id"=>$localitate_id,"taxonomy"=>"oras","parent"=>$judet_id),$keys_to_exclude=array('term_taxonomy_id'),$setify_only_keys=array(),$return_query=false);
		insert_qa('wp_term_relationships',array("object_id"=>$localitate_id,"term_taxonomy_id"=>'284'),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
		
	//	insert_qa('wp_term_taxonomy',array("taxonomy"=>"term_translations","description"=>'a:2:{s:2:"ro";i:'.$localitate_id.';s:2:"en";i:'.$localitate_id_en.';}','count'=>2),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
	}
	
//	$id_afacere=one_query("select meta_value from wp_postmeta where meta_key='identificator_unic_afacere' order by meta_value desc limit 1");
//	$id_afacere=$id_afacere+1;
		
	thfQsdb('r53562busi_brokers'); //select database app
	$wp_posts_img=array(
	//	'ID'=>NULL,
		'post_author'=>9,
		'post_date'=>$v['data_publicare'],
		'post_date_gmt'=>gmdate('Y-m-d H:i:s',strtotime($v['data_publicare'])),
		'post_content'=>$atasamente[0],	
		'post_title'=>$atasamente[0], 
		'post_status'=>"inherit",		
		'comment_status'=>'open',
		'ping_status'=>'closed',
		'post_password'=>NULL,
		'post_name'=>strtolower(s($atasamente['0'])),
		'to_ping'=>NULL,
		'pinged'=>NULL,
		'post_modified'=>$v['last_update'],
		'post_modified_gmt'=>gmdate('Y-m-d H:i:s',strtotime($v['last_update'])),
		'post_content_filtered'=>'',
		'post_parent'=>0,
		'guid'=>'', 
		'menu_order'=>0,
		'post_type'=>'attachment', 
		'post_mime_type'=>'image/jpeg', 
		'comment_count'=>'0',
		'post_excerpt'=>NULL,
	);	


	
$wp_meta=array(
	"_edit_lock"=>"?",
	"_edit_last"=>"?",
	"_wpfp_afaceri_featured_post"=>$v['promovare_aprobata'],
    "_thumbnail_id"=>NULL,
	"nume_afacere_si_descriere_ascunsa"=>$v['descriere_ascunsa'],
	"strada"=>$v['adresa'],
	"nr"=>"?",
	"continuare_adresa"=>"?",
	"cifra_de_afaceri"=>$v['cifra_afaceri'],
	"profitul_annual"=>$v['profit_anual'],
	"afacere_data"=>$v['data_stabilire'],
	"vanzator_finantare"=>$v['tip_finantare'],
	"total_patrimoniu"=>$v['patrimoniu_imobiliar'],
	"goodwill"=>$v['fond_comercial'],
	"trademark"=>$v['marca_comerciala'],
	"pret_vanzare"=>$v['pret_vanzare'],
	"materie_prima"=>$v['inventariu_aprox'],
	"pret_inclus"=>"?",
	"numar_angajati"=>$v['nr_angajati'],
	"expansiune"=>$v['cifra_afaceri_anterior'],
	"training"=>$v['suport'],
	"motivul_vanzari"=>$v['motiv_vanzare'],
	"telefon_companie"=>$v['tel'],
	"website"=>$v['website'],
	"social_media"=>"?",
	"nume_firma"=>$v['denumire_afacere'],
	"_pods_imagine_afacere"=>NULL,
	"identificator_unic_afacere"=>$v['idv'],
	"_pods_categorie_afacere"=>"",
	"categorie_afacere"=>"?",
	"_pods_judet"=>"a:1:{i:0;i:".$judet_id.";}",
	"judet"=>$judet_id,
	"_pods_oras"=>"a:1:{i:0;i:".$localitate_id.";}",
	"oras"=>$localitate_id,
	"imagine_afacere"=>NULL,
	"_yoast_wpseo_focuskw_text_input"=>$v['focus_keyword'],
	"_yoast_wpseo_focuskw"=>$v['focus_keyword'],
	"_yoast_wpseo_metadesc"=>$v['meta_description'],
);


$term_taxonomy_id=283; //Ro language

	foreach(array('ro','en') as $lng){
		if(isset($wp_posts['ID'])){unset($wp_posts['ID']);}
		
		if($v['post_'.$lng]){ //update post din wp
		
		
			if ($lng=='en')
			{
				$wp_posts['post_content']=$v['descriere_publica_en'];
				$wp_meta['motivul_vanzari']=$v['motiv_vanzare_en'];
				$wp_posts['post_title']=$v['denumire_afacere_en'];
				$wp_meta['training']=$v['suport_en'];
				$wp_meta['_yoast_wpseo_focuskw_text_input']=$v['focus_keyword_en'];
				$wp_meta['_yoast_wpseo_focuskw']=$v['focus_keyword_en'];
				$wp_meta['_yoast_wpseo_metadesc']=$v['meta_description_en'];
				$wp_posts['post_name']=$wp_posts['post_name']."-en";
				$term_taxonomy_id=293;
			}
			
			$wp_posts['ID']=$v['post_'.$lng];
			thfQsdb('r53562busi_TradeX'); //select WP database
			//check image
			$current_img_id=many_query("select wp.guid,wp.id from wp_postmeta wm left join wp_posts wp on wm.meta_value=wp.ID  where wm.post_id='".$wp_posts['ID']."' and wm.meta_key='imagine_afacere'");
			$current_img=substr($current_img_id['guid'],strrpos($current_img_id['guid'],"/")+1,strlen($current_img_id['guid']));



			if ($current_img!=$image_name)
			{
				$path_to_file= '../../Trade-X.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_name;
				copy("../".$atasamente[0], $path_to_file);			
				$wp_posts_img['guid']='https://trade-x.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_name;
				update_qaf('wp_posts',$wp_posts_img,"ID='".$current_img_id['id']."'",'LIMIT 1');
				$att_meta_ser=meta_image($image_name);
				update_qaf('wp_postmeta',array("meta_value"=>date("Y").'/'.date('m').'/'.$image_name),"post_id='".$current_img_id['id']."' and meta_key='_wp_attached_file' ",'LIMIT 1');
				update_qaf('wp_postmeta',array("meta_value"=>$att_meta_ser),"post_id='".$current_img_id['id']."' and meta_key='_wp_attachment_metadata' ",'LIMIT 1');
				
			
						
									
			}
			
			$query_check=count_query("select count(*) from wp_postmeta where post_id='".$current_img_id['id']."' and meta_key='_wp_attachment_image_alt'" );
						
						if ($query_check==0)
						{
								insert_qa('wp_postmeta',array("post_id"=>$current_img_id['id'],"meta_key"=>'_wp_attachment_image_alt',"meta_value"=>$v['alt_text'.(($lng=='en')?"_en":"")]),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);
						}
						else
						{
							update_qaf('wp_postmeta',array("meta_value"=>$v['alt_text'.(($lng=='en')?"_en":"")]),"post_id='".$current_img_id['id']."' and meta_key='_wp_attachment_image_alt' ",'LIMIT 1');
					
						}
			

			//update wp_posts
			update_qaf('wp_posts',$wp_posts,"ID='{$wp_posts['ID']}'",'LIMIT 1');
			
			
			//update wp_meta
			foreach ($wp_meta as $key=>$value)
			{
				if ($value!=NULL)
					{
					if ($key=="_yoast_wpseo_focuskw_text_input" || $key=="_yoast_wpseo_focuskw" || $key=="_yoast_wpseo_metadesc")// added later 
					{
						$query_check=count_query("select count(*) from wp_postmeta where post_id='".$wp_posts['ID']."' and meta_key='".$key."'" );
						
						if ($query_check==0)
						{
								insert_qa('wp_postmeta',array("post_id"=>$wp_posts['ID'],"meta_key"=>$key,"meta_value"=>$value),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);
						}
						else
						{
							update_qaf('wp_postmeta',array("meta_value"=>$value),"post_id='".$wp_posts['ID']."' and meta_key='".$key."'",'LIMIT 1');	
						}
					}
					else
					{
							update_qaf('wp_postmeta',array("meta_value"=>$value),"post_id='".$wp_posts['ID']."' and meta_key='".$key."'",'LIMIT 1');						
					}		
						
			
					}
				
			}
			update_qaf('wp_podsrel',array("related_item_id"=>$judet_id),"field_id='70' and item_id='".$wp_posts['ID']."'",'LIMIT 1');				update_qaf('wp_podsrel',array("related_item_id"=>$localitate_id),"field_id='71' and item_id='".$wp_posts['ID']."'",'LIMIT 1');			
			update_qaf('wp_podsrel',array("related_item_id"=>$v['domeniu_activitate']),"field_id='72' and item_id='".$wp_posts['ID']."'",'LIMIT 1');				update_qaf('wp_podsrel',array("related_item_id"=>$localitate_id),"field_id='71' and item_id='".$wp_posts['ID']."'",'LIMIT 1');	
			
			
			
		}
		else{ //insert in wp
			thfQsdb('r53562busi_TradeX'); //select WP database
			
			if ($lng=='en')
			{
				$wp_posts['post_content']=$v['descriere_publica_en'];
				$wp_posts['post_title']=$v['denumire_afacere_en'];
				$wp_meta['motivul_vanzari']=$v['motiv_vanzare_en'];
				$wp_meta['training']=$v['suport_en'];
				$wp_meta['_yoast_wpseo_focuskw_text_input']=$v['focus_keyword_en'];
				$wp_meta['_yoast_wpseo_focuskw']=$v['focus_keyword_en'];
				$wp_meta['_yoast_wpseo_metadesc']=$v['meta_description_en'];
				$wp_posts['post_name']=$wp_posts['post_name']."-en";
				$term_taxonomy_id=293;
			}
			
			
			//insert main
			$last_insert=insert_qa('wp_posts',$wp_posts,$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);
			$ids[$lng]=$last_insert;
			insert_qa('wp_podsrel',array('pod_id'=>'60','field_id'=>'70','item_id'=>$last_insert,'related_item_id'=>$judet_id),$keys_to_exclude=array('id','related_pod_id','related_field_id','weight'),$setify_only_keys=array(),$return_query=false);
			insert_qa('wp_podsrel',array('pod_id'=>'60','field_id'=>'71','item_id'=>$last_insert,'related_item_id'=>$localitate_id),$keys_to_exclude=array('id','related_pod_id','related_field_id','weight'),$setify_only_keys=array(),$return_query=false);
			insert_qa('wp_podsrel',array('pod_id'=>'60','field_id'=>'72','item_id'=>$last_insert,'related_item_id'=>$v['domeniu_activitate']),$keys_to_exclude=array('id','related_pod_id','related_field_id','weight'),$setify_only_keys=array(),$return_query=false);
			
			//copy file
			if ($image_name!="")
			{
			$path_to_file= '../../Trade-X.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_name;
			copy("../".$atasamente[0], $path_to_file);			
				
			}
			
			
			//insert picture
			$wp_posts_img['post_parent']=$last_insert;

			$wp_posts_img['guid']='https://trade-x.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_name;
			$image_id=insert_qa('wp_posts',$wp_posts_img,$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);
			insert_qa('wp_podsrel',array('pod_id'=>'60','field_id'=>'75','item_id'=>$last_insert,'related_item_id'=>$image_id),$keys_to_exclude=array('id','related_pod_id','related_field_id','weight'),$setify_only_keys=array(),$return_query=false);
		    insert_qa('wp_postmeta',array("post_id"=>$image_id,"meta_key"=>'_wp_attached_file',"meta_value"=>date("Y").'/'.date('m').'/'.$image_name),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);			
			insert_qa('wp_postmeta',array("post_id"=>$image_id,"meta_key"=>'_wp_attachment_image_alt',"meta_value"=>$wp_posts['alt_text'.(($lng=='en')?"_en":"")]),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);	
			
			$att_meta_ser=meta_image($image_name);
		
			insert_qa('wp_postmeta',array("post_id"=>$image_id,"meta_key"=>'_wp_attachment_metadata',"meta_value"=>$att_meta_ser),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);			
		
			$wp_meta['_thumbnail_id']=$image_id;
			$wp_meta['_pods_imagine_afacere']="a:1:{i:0;i:".$image_id.";}";
			$wp_meta['imagine_afacere']=$image_id;
		
			
			
			//insert metadata
			foreach ($wp_meta as $key=>$value)
			{
				insert_qa('wp_postmeta',array("post_id"=>$last_insert,"meta_key"=>$key,"meta_value"=>$value),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);
			}
			
			//insert language
			insert_qa('wp_term_relationships',array("object_id"=>$last_insert,"term_taxonomy_id"=>$term_taxonomy_id,"term_order"=>"0"));

			
			//update post id
			thfQsdb('r53562busi_brokers'); //select database app
			update_qaf('vanzare',array('post_'.$lng=>$last_insert),"idv='{$v['idv']}'",'LIMIT 1');

		}		
	}
	

if (isset($ids['ro']))
{
thfQsdb('r53562busi_TradeX'); //select WP database
$wtt_id=insert_qa('wp_term_taxonomy',array("taxonomy"=>"post_translations","description"=>serialize(array("en"=>$ids['en'],"ro"=>$ids['ro'])),"parent"=>"0","count"=>2));
update_qaf('wp_term_taxonomy',array("term_id"=>$wtt_id),"term_taxonomy_id='".$wtt_id."'",'LIMIT 1');
insert_qa('wp_term_relationships',array("object_id"=>$ids['en'],"term_taxonomy_id"=>$wtt_id,"term_order"=>"0"));
insert_qa('wp_term_relationships',array("object_id"=>$ids['ro'],"term_taxonomy_id"=>$wtt_id,"term_order"=>"0"));
}

	thfQsdb('r53562busi_brokers'); //select database app
	return 'Publicat/updatat';
}

function meta_image($title)
{
	
$att_meta=unserialize('a:5:{s:5:"width";i:2480;s:6:"height";i:1748;s:4:"file";s:35:"2018/04/Le_Sommelier_pagina_310.jpg";s:5:"sizes";a:10:{s:9:"thumbnail";a:4:{s:4:"file";s:35:"Le_Sommelier_pagina_310-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:35:"Le_Sommelier_pagina_310-300x211.jpg";s:5:"width";i:300;s:6:"height";i:211;s:9:"mime-type";s:10:"image/jpeg";}s:12:"medium_large";a:4:{s:4:"file";s:35:"Le_Sommelier_pagina_310-768x541.jpg";s:5:"width";i:768;s:6:"height";i:541;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:36:"Le_Sommelier_pagina_310-1024x722.jpg";s:5:"width";i:1024;s:6:"height";i:722;s:9:"mime-type";s:10:"image/jpeg";}s:22:"wysija-newsletters-max";a:4:{s:4:"file";s:35:"Le_Sommelier_pagina_310-600x423.jpg";s:5:"width";i:600;s:6:"height";i:423;s:9:"mime-type";s:10:"image/jpeg";}s:21:"et-pb-post-main-image";a:4:{s:4:"file";s:35:"Le_Sommelier_pagina_310-400x250.jpg";s:5:"width";i:400;s:6:"height";i:250;s:9:"mime-type";s:10:"image/jpeg";}s:31:"et-pb-post-main-image-fullwidth";a:4:{s:4:"file";s:36:"Le_Sommelier_pagina_310-1080x675.jpg";s:5:"width";i:1080;s:6:"height";i:675;s:9:"mime-type";s:10:"image/jpeg";}s:21:"et-pb-portfolio-image";a:4:{s:4:"file";s:35:"Le_Sommelier_pagina_310-400x284.jpg";s:5:"width";i:400;s:6:"height";i:284;s:9:"mime-type";s:10:"image/jpeg";}s:28:"et-pb-portfolio-module-image";a:4:{s:4:"file";s:35:"Le_Sommelier_pagina_310-510x382.jpg";s:5:"width";i:510;s:6:"height";i:382;s:9:"mime-type";s:10:"image/jpeg";}s:28:"et-pb-portfolio-image-single";a:4:{s:4:"file";s:36:"Le_Sommelier_pagina_310-1080x761.jpg";s:5:"width";i:1080;s:6:"height";i:761;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}');

$att_meta['file']=date("Y").'/'.date('m').'/'.$title;
			$att_meta['sizes']['thumbnail']['file']=$title;
			$att_meta['sizes']['medium']['file']=$title;
			$att_meta['sizes']['medium_large']['file']=$title;
			$att_meta['sizes']['large']['file']=$title;
			$att_meta['sizes']['wysija-newsletters-max']['file']=$title;
			$att_meta['sizes']['et-pb-post-main-image']['file']=$title;
			$att_meta['sizes']['et-pb-post-main-image-fullwidth']['file']=$title;
			$att_meta['sizes']['et-pb-portfolio-image']['file']=$title;
			$att_meta['sizes']['et-pb-portfolio-module-image']['file']=$title;
			$att_meta['sizes']['et-pb-portfolio-image-single']['file']=$title;
			$att_meta_ser=serialize($att_meta);
			
	return $att_meta_ser;
}

function insert_update_user($uid)
{
	$user_br=many_query("select * from thf_users where id='".$uid."'");
	$judet=	one_query("select nume_judet from localizare_judete where id='".$user_br['judet_id']."'");
	$localitate=	one_query("select localitate from localizare_localitati where id='".$user_br['localitate_id']."'");
	if ($user_br['wp_user_id']==0)
	{
	thfQsdb('r53562busi_TradeX'); //select WP database
	
	//insert wp_user
		$wp_users=array(
					"user_login"=>$user_br['username'],
					"user_pass"=>"",
					"user_nicename"=>s($user_br['full_name']),
					"user_email"=>$user_br['mail'],
					"user_url"=>$user_br['website'],
					"user_registered"=>$user_br['create_date'],
					"user_status"=>"0",
					"display_name"=>$user_br['full_name']
					);
	$user_id=insert_qa('wp_users',$wp_users,$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);
	
	
	$atasamente_us=json_decode($user_br['atasamente']);
	$image_user=$user_id.substr($atasamente_us[0][0],strrpos($atasamente_us[0][0],"/")+1,strlen($atasamente_us[0][0]));


	$path_to_file_us= '../../Trade-X.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_user;
	if (file_exists("../".$atasamente_us[0][0]) && is_file("../".$atasamente_us[0][0]))
	{
	copy("../".$atasamente_us[0][0], $path_to_file_us);		
	}
	
			
	$wp_posts_img_us=array(
	//	'ID'=>NULL,
		'post_author'=>9,
		'post_date'=>$user_br['create_date'],
		'post_date_gmt'=>gmdate('Y-m-d H:i:s',strtotime($user_br['create_date'])),
		'post_content'=>$user_br['username'],	
		'post_title'=>$user_br['username'], 
		'post_status'=>"inherit",		
		'comment_status'=>'open',
		'ping_status'=>'closed',
		'post_password'=>NULL,
		'post_name'=>strtolower(s($user_br['username'])),
		'to_ping'=>NULL,
		'pinged'=>NULL,
		'post_modified'=>$user_br['create_date'],
		'post_modified_gmt'=>gmdate('Y-m-d H:i:s',strtotime($user_br['create_date'])),
		'post_content_filtered'=>'',
		'post_parent'=>0,
		'guid'=>'', 
		'menu_order'=>0,
		'post_type'=>'attachment', 
		'post_mime_type'=>'image/jpeg', 
		'comment_count'=>'0',
		'post_excerpt'=>NULL,
	);		
	
	$wp_posts_img_us['guid']='https://trade-x.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_user;
	$image_id_us=insert_qa('wp_posts',$wp_posts_img_us,$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);		insert_qa('wp_postmeta',array("post_id"=>$image_id_us,"meta_key"=>'_wp_attached_file',"meta_value"=>date("Y").'/'.date('m').'/'.$image_user),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);			
	insert_qa('wp_postmeta',array("post_id"=>$image_id_us,"meta_key"=>'_wp_attachment_image_alt',"meta_value"=>$image_user),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);	
	$att_meta_ser=meta_image($image_user);
	insert_qa('wp_postmeta',array("post_id"=>$image_id_us,"meta_key"=>'_wp_attachment_metadata',"meta_value"=>$att_meta_ser),$keys_to_exclude=array('ID'),$setify_only_keys=array(),$return_query=false);			
			
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"description","meta_value"=>$user_br['description']),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"description_en","meta_value"=>$user_br['description_en']),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"wp_user_level","meta_value"=>"0"),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);	
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"wpautbox_user_fields","meta_value"=>base64_encode('a:1:{s:4:"user";a:1:{s:5:"image";s:4:"'.$image_id_us.'";}}')),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);	
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"telefon_user","meta_value"=>$user_br['tel']),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);
	
	//add judet localitate
	
	
	$judet_id=one_query("select wt.term_id from wp_terms wt left join wp_term_taxonomy wtt on wt.term_id=wtt.term_id where wt.name='$judet' and wtt.taxonomy='judet'");
	if ($judet_id==0)
	{
		$judet_id=insert_qa('wp_terms',array("name"=>$judet,"slug"=>$judet,"term_group"=>0),$keys_to_exclude=array('id'),$setify_only_keys=array(),$return_query=false);
		$judet_id_en=insert_qa('wp_terms',array("name"=>$judet,"slug"=>$judet.'-en',"term_group"=>0),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
		insert_qa('wp_term_taxonomy',array("term_id"=>$judet_id,"taxonomy"=>"judet"),$keys_to_exclude=array('term_taxonomy_id'),$setify_only_keys=array(),$return_query=false);
		insert_qa('wp_term_relationships',array("object_id"=>$judet_id,"term_taxonomy_id"=>'284'),$keys_to_exclude=array(),$setify_only_keys=array(),$return_query=false);
	
	}
	$localitate_id=one_query("select wt.term_id from wp_terms wt left join wp_term_taxonomy wtt on wt.term_id=wtt.term_id where wt.name='$localitate' and wtt.taxonomy='oras' and parent='$judet_id'");
	if ($localitate_id==0)
	{
		$localitate_id=insert_qa('wp_terms',array("name"=>$localitate,"slug"=>$localitate,"term_group"=>0),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
		$localitate_id_en=insert_qa('wp_terms',array("name"=>$localitate,"slug"=>$localitate."-en","term_group"=>0),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
		$term_taxonomy_id_loc=insert_qa('wp_term_taxonomy',array("term_id"=>$localitate_id,"taxonomy"=>"oras","parent"=>$judet_id),$keys_to_exclude=array('term_taxonomy_id'),$setify_only_keys=array(),$return_query=false);
		insert_qa('wp_term_relationships',array("object_id"=>$localitate_id,"term_taxonomy_id"=>'284'),$keys_to_exclude=array('term_id'),$setify_only_keys=array(),$return_query=false);
	}
		
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"judet_user","meta_value"=>$localitate_id),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);	
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"oras_user","meta_value"=>$judet_id),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);	
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"_pods_judet_user","meta_value"=>"a:1:{i:0;i:".$judet_id.";}"),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);	
	insert_qa('wp_usermeta',array("user_id"=>$user_id,"meta_key"=>"pods_oras_user","meta_value"=>"a:1:{i:0;i:".$localitate_id.";}"),$keys_to_exclude=array('umeta_id'),$setify_only_keys=array(),$return_query=false);	
		insert_qa('wp_podsrel',array('pod_id'=>'1112','field_id'=>'1113','item_id'=>$user_id,'related_item_id'=>$judet_id),$keys_to_exclude=array('id','related_pod_id','related_field_id','weight'),$setify_only_keys=array(),$return_query=false);
			insert_qa('wp_podsrel',array('pod_id'=>'1112','field_id'=>'1114','item_id'=>$user_id,'related_item_id'=>$localitate_id),$keys_to_exclude=array('id','related_pod_id','related_field_id','weight'),$setify_only_keys=array(),$return_query=false);
			
	thfQsdb('r53562busi_brokers'); //select database app
	update_qaf('thf_users',array('wp_user_id'=>$user_id),"id='".$uid."'",'LIMIT 1');
	}
	else
	{
	thfQsdb('r53562busi_TradeX'); //select WP database
	$user_id=$user_br['wp_user_id'];
	$img_base64=one_query("select meta_value from wp_usermeta where user_id='".$user_id."' and meta_key='wpautbox_user_fields'");
	$img_id=unserialize(base64_decode($img_base64));

 	$wp_users=array(
					"user_login"=>$user_br['username'],
					"user_pass"=>"",
					"user_nicename"=>s($user_br['full_name']),
					"user_email"=>$user_br['mail'],
					"user_url"=>$user_br['website'],
					"user_registered"=>$user_br['create_date'],
					"user_status"=>"0",
					"display_name"=>$user_br['full_name']
					);
	$atasamente_us=json_decode($user_br['atasamente']);
	$image_user=$user_id.substr($atasamente_us[0][0],strrpos($atasamente_us[0][0],"/")+1,strlen($atasamente_us[0][0]));
	
	$path_to_file_us= '../../Trade-X.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_user;
	if (file_exists("../".$atasamente_us[0][0]) && is_file("../".$atasamente_us[0][0]))
	{
	copy("../".$atasamente_us[0][0], $path_to_file_us);		
	}
	
	
	update_qaf('wp_users',$wp_users,"ID='".$user_id."'",'LIMIT 1');
	update_qaf('wp_usermeta',array("meta_value"=>$user_br['description']),"user_id='".$user_id."' and meta_key='description'",'LIMIT 1');
	update_qaf('wp_usermeta',array("meta_value"=>$user_br['description_en']),"user_id='".$user_id."' and meta_key='description_en'",'LIMIT 1');
	$wp_posts_img_us=array(
	//	'ID'=>NULL,
		'post_author'=>9,
		'post_date'=>$user_br['create_date'],
		'post_date_gmt'=>gmdate('Y-m-d H:i:s',strtotime($user_br['create_date'])),
		'post_content'=>$user_br['username'],	
		'post_title'=>$user_br['username'], 
		'post_status'=>"inherit",		
		'comment_status'=>'open',
		'ping_status'=>'closed',
		'post_password'=>NULL,
		'post_name'=>strtolower(s($user_br['username'])),
		'to_ping'=>NULL,
		'pinged'=>NULL,
		'post_modified'=>$v['last_update'],
		'post_modified_gmt'=>gmdate('Y-m-d H:i:s',strtotime($user_br['create_date'])),
		'post_content_filtered'=>'',
		'post_parent'=>0,
		'guid'=>'', 
		'menu_order'=>0,
		'post_type'=>'attachment', 
		'post_mime_type'=>'image/jpeg', 
		'comment_count'=>'0',
		'post_excerpt'=>NULL,
	);		
	
	$wp_posts_img_us['guid']='https://trade-x.ro/wp-content/uploads/'.date("Y").'/'.date('m').'/'.$image_user;
	
	update_qaf('wp_posts',$wp_posts_img_us,"ID='".$img_id['user']['image']."'",'LIMIT 1');
	$att_meta_ser=meta_image($image_user);
	update_qaf('wp_postmeta',array("meta_value"=>date("Y").'/'.date('m').'/'.$image_user),"post_id='".$img_id['user']['image']."' and meta_key='_wp_attached_file' ",'LIMIT 1');
	update_qaf('wp_postmeta',array("meta_value"=>$att_meta_ser),"post_id='".$img_id['user']['image']."' and meta_key='_wp_attachment_metadata' ",'LIMIT 1');
	
	thfQsdb('r53562busi_brokers'); //select database app
	}

return $user_id;
}