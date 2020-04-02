<?php
require_once('./config.php');
/****  UPDATE DOCIMENT FILES  ****/

$path=THF_UPLOAD.''.@floor($_GET['edit']).'/';
if(isset($_POST['list_files'])) {
    $path=THF_UPLOAD.''.@floor($_POST['list_files']).'/';
}


if(isset($_GET['dell_id'])){
    unlink($path.$_GET['dell_id']);
    die('Deleted');
}

//$uploads_dir = $_GET['edit'];
$uploads_dir =$path;

if(count($_FILES) and isset($_GET['file_upload'])){
    $uploads_dir.$_FILES['file']['name'].': '.(move_uploaded_file($_FILES['file']['tmp_name'],$uploads_dir.$_FILES['file']['name'])?'OK':"error").'<br />';
   //echo list_files($_GET['edit']);
    die;
}

if(isset($_POST['list_files']) ){
    echo list_files($_POST['list_files']);
    die();
}
//prea(json_encode($file_name,true));die;
if(count($file_name) && $document['has_incoming']!=json_encode($file_name,true)){
    update_qaf('documente',array('has_incoming'=>json_encode($file_name,true)),'`id_doc`='.@floor($_GET['edit']),'LIMIT 1',array('id_doc'));
}

/*
if(count($_FILES)){
  $uploads_dir = $path;
  echo $uploads_dir.'/'.$_FILES['file']['name'].': '.(move_uploaded_file($_FILES['file']['tmp_name'],$uploads_dir.'/'.$_FILES['file']['name'])?'OK':"error").'<br />';


      $info = pathinfo($_FILES['excel']['name']);
      $file_name =  basename($info['filename'],'.'.$info['extension']);
//		$file_name =  basename($file,'.'.$info['extension']);
      //upload_files_new($file_name='',$upload_dir='upload/pics',$alowed='jpg',$camp='userfile',$max_size=5242880,$perm=0775)
      upload_files_new($file_name,$path,'pdf|doc|docx|jpg|jpeg|png|xls|xlsx','excel');
      $_SESSION['upload_report']=array(
          'nume_fila_upl'=>$nume_fila_upl,
          'nume_orig_fila'=>$nume_orig_fila,
          'messages'=>$messages,
          );
  echo '<li>'.$file_name.'</li>';

}
*/
//////////////////////






