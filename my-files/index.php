<?php
require_once('../config.php');

$page_head=array(
    'meta_title'=>'My files',
    'trail'=>'my-files'

);


require_login();

index_head();

echo list_menu_myfiles();

index_footer();