<?php
require_once( '../config.php' );


$anunturi_promovate=multiple_query("SELECT GROUP_CONCAT(CONCAT(post_ro,' , ',post_en) SEPARATOR ', ') as total_posts FROM `vanzare` where promovare_aprobata='1' and promovat_until>=".date("Y-m.d")." and (post_ro>0 or post_en>0) ");

$anunturi_nepromovate=multiple_query("SELECT GROUP_CONCAT(CONCAT(post_ro,' , ',post_en) SEPARATOR ', ') as total_posts FROM `vanzare` where (promovare_aprobata='0' or promovat_until<".date("Y-m.d").") and (post_ro>0 or post_en>0) ");

thfQsdb('r53562busi_TradeX'); //select WP database
echo $anunturi_promovate[0]['total_posts'];
update_query("UPDATE `wp_postmeta` SET `meta_value`='1' WHERE post_id in (".$anunturi_promovate[0]['total_posts'].") and meta_key='_wpfp_afaceri_featured_post '");
update_query("UPDATE `wp_postmeta` SET `meta_value`='0' WHERE post_id in (".$anunturi_nepromovate[0]['total_posts'].") and meta_key='_wpfp_afaceri_featured_post '");
thfQsdb('r53562busi_brokers'); //select database app

//export_vanzare_to_wp(33);
?>