<?php
require_once('../config.php');

$page_head=array(
    'meta_title'=>'Setari',
    'trail'=>'setari'

);


require_login();

index_head();

echo list_menu_settings();

index_footer();