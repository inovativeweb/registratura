<?php
define('DS',                    DIRECTORY_SEPARATOR);
define('PS',                    PATH_SEPARATOR);

define('DEBUG',                 false);

// check http://httpd.apache.org/docs/current/mod/mod_env.html,
// if you want to deploy it to development ENV, just set add SetEnv RUNTIME_ENVIROMENT DEV into .htaccess
if (isset($_SERVER['RUNTIME_ENVIROMENT']) && $_SERVER['RUNTIME_ENVIROMENT'] == 'DEV') {
    defined('IS_TEST') || define("IS_TEST",   true);
} else {
    defined('IS_TEST') || define('IS_TEST', false);
}

$_SERVER["REQUEST_SCHEME"] = isset($_SERVER["REQUEST_SCHEME"]) ? $_SERVER["REQUEST_SCHEME"] : 'http';
$_SERVER["SERVER_PORT"] = isset($_SERVER["SERVER_PORT"]) ? $_SERVER["SERVER_PORT"] : '80';

if (IS_TEST) {
    define("BPG_HOST",      "http://localhost/");
    define("BPG_HOST_CN",   "http://localhost/");
} else {
    define("BPG_HOST",				"{$_SERVER["REQUEST_SCHEME"]}://ares.b-p-g.org:{$_SERVER["SERVER_PORT"]}/");
    define("BPG_HOST_CN",			"{$_SERVER["REQUEST_SCHEME"]}://ares.b-p-g.org:{$_SERVER["SERVER_PORT"]}/"); // change it to 40.120 after CN server OK (DMS sync ok)
}


define('BASE_PATH', 			dirname(dirname(dirname(__FILE__))).'\\');		// for windows only

if (!IS_TEST) {
    define('CONVERT_IMAGICK',			'"C:\\Program Files (x86)\\ImageMagick\\convert.exe" ');	// ImageMagick install path
    define('CONVERT_ANTIWORD',			'"C:\\xampp\\htdocs\\administration\\java\\php\\util\\antiword\\antiword.exe" ');
    define('CONVERT_TESSERACT',			'"c:\\xampp\\htdocs\\administration\\java\\php\\util\\Tesseract-OCR\\tesseract.exe" ');	// tesseract path
    define('CONVERT_OPENOFFICE_JAVA',	'java.exe -jar c:\\xampp\\htdocs\\administration\\java\\DocConvertor_fat.jar 192.168.10.50 8100 %s %s 2>&1');

    define('CONVERT_GHOST',				'"C:\\Program Files (x86)\\gs\\gs9.15\\bin\\gswin32c.exe" ');

    define('SITE_PATH',					'administration/dms/');
    define('LIBREOFFICE',				'"C:\\Program Files (x86)\\LibreOffice 5\\program\\soffice.exe" ');
} else {
    define('CONVERT_IMAGICK',				'convert.exe ');	// ImageMagick install path
    define('CONVERT_ANTIWORD',				'"C:\\antiword\\antiword.exe" ');	// antiword install path, the path must be 'C:/antiword/antiword.exe' ??
    define('CONVERT_TESSERACT',				'"'.BASE_PATH.'administration\\plugin\\Tesseract-OCR\\tesseract.exe" ');	// tesseract path
    define('CONVERT_OPENOFFICE_SERVICE',	'"C:\\Program Files (x86)\\OpenOffice.org 3\\program\\soffice" -headless -accept="socket,host=0.0.0.0,port=8100;urp;" -nofirststartwizard');
    define('CONVERT_OPENOFFICE_JAVA',		'java.exe -jar '.dirname(BASE_PATH).'\\java\\DocConvertor_fat.jar localhost 8100 %s %s 2>&1');
    define('CONVERT_GHOST',					'gswin32c.exe ');

    define('CMD_TIF_SEPARATE',				CONVERT_IMAGICK.' %s %s');			// convert test8.tif[0,2] test8-1.tif
    define('CMD_PDF_SEPARATE',				CONVERT_GHOST.' -q -dQUIET -dUseCIEColor -dSAFER -dBATCH -dNOPAUSE -dPDFSETTINGS=/screen -sDEVICE=jpeg -dJPEGQ=60 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r144  -sOutputFile=test%03d.jpg %s');

    define('SITE_PATH',				'administration/dms/');
    define('LIBREOFFICE',				'"soffice.exe" ');
}
define('HTDOCS',				$_SERVER['DOCUMENT_ROOT']);		// for linux or windows
define('ROOT_PATH',				$_SERVER['DOCUMENT_ROOT'].'/'.SITE_PATH);		// for linux or windows

define('WEB_PATH',				'');

define('FILE_PATH',             BPG_HOST.'dms_files/');
define('FILE_PATH_CN',          BPG_HOST_CN.'dms_files/');

define('LOG_FILE',				ROOT_PATH.'log.txt');
define('EMAIL_ERR_LOCK',		ROOT_PATH.'email_err_lock');

define('ADMIN_PATH',			ROOT_PATH.'administration/');
define('UPLOAD_PATH',			ROOT_PATH.'../../dms_files/');
//define('UPLOAD_PATH',			ROOT_PATH.'dms_files/');
define('RAW_MAIL_PATH',         UPLOAD_PATH . 'raw_mail/');
define('RAW_MAIL_BACKUP_PATH',  'F:/raw_mails');

define('UPLOAD_MAX_SIZE',		600*1024*1024);			// 150M, can be edit in file '.htaccess'

define('DOWNLOAD_TMP_PATH',		UPLOAD_PATH.'download_tmp/');
define('CONVERT_PATH',			UPLOAD_PATH.'convert/');
define('NO_RESIZE_IMAGE_PATH',  UPLOAD_PATH.'non-resize-backup/');
define('TMP_RESIZE_PDF_PATH',   UPLOAD_PATH.'tmp_resize_pdf/');

define('CONVERT_PDF2TEXT',		'"'.BASE_PATH.'administration\\plugin\\pdftotext.exe" ');	// pdftotext path
define('CONVERT_PDF2SWF',		'"'.BASE_PATH.'administration\\plugin\\SWFTools\\pdf2swf.exe" ');
define('CONVERT_JPEG2SWF',		'"'.BASE_PATH.'administration\\plugin\\SWFTools\\jpeg2swf.exe" ');
define('CONVERT_GBK2UTF8',		'"'.BASE_PATH.'administration\\plugin\\iconv.exe" -f %s -t utf-8 "%s" > "%s"');		// to convert the encoding of file from gbk to utf-8


define('CONVERT_IMAGICK_PAR',	' -size 600x721 -geometry 600x721 ');

define('UPLOAD_PATH_STATIC',	ROOT_PATH.'../../dms_files/');

define('CONVERT_PATH_STATIC',	UPLOAD_PATH_STATIC.'convert/');
define('TMP_SEP_PATH_STATIC',	UPLOAD_PATH_STATIC.'tmp_separate/');

define('LIB_PATH',				ADMIN_PATH.'libs/');
define('CONFIG_PATH',			ADMIN_PATH.'configs/');
define('SMARTY_PATH',			LIB_PATH.'Smarty/');
define('EMAIL_PATH',			$_SERVER['DOCUMENT_ROOT'] .'/administration/mail/');
define('EMAIL_MAX_ATTACHMENT',	5);		// the max number of email attachment.
//define('EMAIL_ATTACHMENT_PATH',	UPLOAD_PATH_STATIC.'attachment/');
// 2017.01.13 change to new folder
define('EMAIL_ATTACHMENT_PATH', realpath(UPLOAD_PATH_STATIC.'new_attachment') . "\\");

define('PLUGIN_PATH',			ADMIN_PATH.'plugin/');
define('MODE_PATH',				ADMIN_PATH.'mode/');
define('INTERFACE_PATH',		ADMIN_PATH.'interface/');
define('COOKIE_PATH',			'/administration/');
define('COOKIE_EXPIRE',			60*60);		// cookie expire time, half one hour (3600s)
define('SESSION_USER_NAME',		'bpg_userinfo');
define('DOMAIN',				'');
define('NAME_CHECK_TIMES',		500);		// the times to check duplicate name;

define('FILE_EDIT_EXPIRE',		30*60);		// the expire time of edit file, 30 minutes.

define('FILE_MYSQL_TEXT_LEN',	256*256-1);	// the length of text type in mysql is 65536-1.

define('PERCENTAGE_MISSPELL',	0.24);

define('MISSPELL_CHECK_SIZE', 	100*1024);

define('VORSCHUSS_DEFAULT_AMOUNT',250);

//a.nistor : hulei fix. revet to 3 custom language based dictionaries and custom name dictionary that servers all languages
// spell addition //English (International)//Romanian//German//
define('SPELL_FILE_PATH_GENERAL_NAMES',	ADMIN_PATH.'share/scripts/dictionaries/custom.names.txt');
define('SPELL_FILE_PATH_GENERAL',	ADMIN_PATH.'share/scripts/dictionaries/custom.txt');
define('SPELL_FILE_PATH_EN',	ADMIN_PATH.'share/scripts/dictionaries/custom.txt');
define('SPELL_FILE_PATH_DE',	ADMIN_PATH.'share/scripts/dictionaries/custom.German.txt');
define('SPELL_FILE_PATH_RO',	ADMIN_PATH.'share/scripts/dictionaries/custom.Romanian.txt');

define("SALT", '.P0vR!EZ~_*R9"CQ');

define("PHP_ERROR_LOG", 'C:\xampp\htdocs\php_error.log');