<?php
if(!isset($_skip_thf)){$_skip_thf=false;}

define("SIMPLEH",true); //global function h to h_xml
$siteAlias='Registratura';
$siteMotto='';
$siteDescription=$siteAlias.' '.$siteMotto;

$debug_thorr=1;

$host=$_SERVER['HTTP_HOST'];

if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'){}
else{header("HTTP/1.1 301 Moved Permanently",true,301); header("Location: https://".$host.$_SERVER['REQUEST_URI']); die;}


/*
[12:33, 25.10.2018] Cristi Uricariu: Username: r53562busi
									 Password: hg41p=U6,1FN
[12:34, 25.10.2018] Cristi Uricariu: server 89.33.26.176
[21:09, 25.10.2018] Nistor Alexandru: http://brokers.trade-x.ro/


//https://trade-x.ro/admin_bs23d/
//Cristian Uricariu
//Kk54EvnFuzY5x5)f

*/


//$subdir='/facturi';// $subdir='/v2';
$active_theme_name='registratura';
$subdir='';

define("COMPANY",'Registratura');
define("ROOT", $subdir."/" );
define("JSLIB", $subdir."/jslib/" );
define("THEMES", $subdir."/themes/" );
define("THEME", THEMES.$active_theme_name.'/' );
define("UPLOAD", $subdir."/dms/" );
define("CMS", $subdir."/cms/" );
define("MEDIA", $subdir."/media/" );

define("COLOR","#a9daec");
define("COLOR2","#DE2666");

/*
define( 'API_URI', 'http://wsia.imobiliare.ro/index.php?wsdl' );
define( 'API_USER', 'X36V' );
define( 'API_KEY', '89cn23489fn32r' );
*/

//define( 'API_URI', 'http://wsia.imobiliare.ro/index.php?wsdl' );
//define( 'API_USER', 'XB0Q' );
//define( 'API_KEY', 'nd5GDMdN39JYjeGS' );



//--------------ERRORS ------------

error_reporting(0);
//ini_set("display_errors", 0);



//--------------ERRORS ------------


$sv=$_SERVER['DOCUMENT_ROOT'];

define("THF_ROOT", $sv );
define("THF_PATH", $sv.ROOT );
define("THF_FUNC", "/home/itrepair/thorr_f/" );
//define("THF_FUNC", $sv . "/thorr_f/" );

define("THF_JSLIB", THF_PATH."jslib/jslib.php" );
define("THF_THEMES", THF_PATH."themes/" );
define("THF_THEME", THF_THEMES.$active_theme_name.'/' );

define("THF_CMS", THF_PATH."cms/" );
define("THF_MEDIA", THF_PATH."media/" );


$thf_secret["unique_key"]="ghdshdfsafhfghdf"; //no not change this or login will fail! this key is used to reencript login passwords!
$thf_secret["cms_cookie"]="hfghdffsfahfghdf";
$thf_secret["login_cookie"]="thf_login";
$cname='switch';

define("THF_UPLOAD", THF_PATH."dms/" );


//

$admin_mail = "support@inovativeweb.ro";
// #1 MYSQL SERVER AND DATABASE CONFIG
$th_mysql_cfg=array(
	"tbl_prefix"=>"thf_",
	"auto_connect"=>true,
	"database_name"=>"itrepair_registratura",
	"username"=>"itrepair_registr",
	"pass"=>"&B?t,Q-Wi4#Y",
    "host"=>"localhost",
	"admin_mail"=>"support@inovativeweb.ro",
	"set_utf8_default_connection_charset"=>true,	//for compatibility reasons
	"auto_disconnect_on_script_finish"=>true,	//register shutdown function
	"db_connection_err_msg"=>"Temporary Mentenance Procedures! Database connection timeout.",
	"select_db_err_msg"=>"Temporary Mentenance Procedures! Database selection timeout.",
	"connection_res"=>false,	//do not modify! used for connection resource and register shutdown function over sql server
	);
date_default_timezone_set("Europe/Bucharest");



$thf_mail_cfg=array(
  /*  'support@trade-x.ro'=>array(
        'send'=>array(	// SMTP: Necriptat[STARTLS pe portul 587]; criptar[SSL/TLS pe portul 465] //SEND
            'from_name'=>'Trade-X',
            'Host'=>'mail.trade-x.ro',
            'SMTPSecure'=>'ssl',//tls // ssl
            'Port'=>'465',//587

           //  'Port'=>'25',  'SMTPSecure'=>'tls',//tls // ssl 

            'SMTPAuth'=>true,
            'Username'=>'support@trade-x.ro',
            'Password'=>'KXqm0ol[r=Q@',
            //'Password'=>'Seficho2017',
            'SMTPAutoTLS'=>true, //Whether to enable TLS encryption automatically if a server supports it, even if `SMTPSecure` is not set to 'tls'. Be aware that in PHP >= 5.6 this requires that the server's certificates are valid.
            'CharSet'=>'utf-8',
            'SMTPDebug'=>'0', //0,1,2
//			'Debugoutput' => 'THFlogErrorMailer', //decomenteaza numai daca intelegi ce face functia asta
            'SMTPOptions'=>array( 'ssl' => array(  'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) )
        ),
    ),*/
);



if(!$_skip_thf){
	require_once(THF_FUNC."thf_main.php");
	require_once(THF_THEME."index_template.php");
	register_thf_constants(); // de apelat in config.php inainte de $GLOBALS['login']
	$GLOBALS["login"]=new ThfLogin(array(
		'login_type'=>1,
		'keep_login_max'=>2160,
		'master_pass'=>'Trad3xBrasov',
		'autocomplete'=>false, 
		'reset_pass'=>array(1,2),
		'formr'=>array('send_mail_from'=>'support@trade-x.ro'),
		'formreset'=>array('formreset'=>'support@trade-x.ro'),
	));
	$GLOBALS["login"]->signin();
	
	//$GLOBALS["cms"]=new ThfLogin(array());
	
	//$GLOBALS["login"]->force_expire_all_cookies();
	}
$login_user = @floor($GLOBALS['login']->get_uid());

$user_login=$GLOBALS['login']->get_user();
$asoc_id_login=$user_login['asoc_id'];
$access_level_login=$user_login['access_level'];
$user_id_login=$user_login['id'];

include ('data_fetch.php');
$GLOBALS['has_config']=true;
$is_admin = $access_level_login >9 ? true : false;

function isMobile() {return 0;
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
