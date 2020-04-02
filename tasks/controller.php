<?php

require_login();


if(isset($_GET['task_id'])){
    $tasksget[$_GET['task_id']] = $tasks[$_GET['task_id']];
    $tasks = $tasksget;
}
  
ThfGalleryEditor::$layout = array(
	'container_class' => 'container-fluid',
	'row_class' => 'colpadsm',
	//'row_class'=>'sortableRowConnected colpadsm',
	'col_class' => 'col-xs-6',
	'img_wrap_class' => 'CoverRatio4_3',
	'file_wrap_class' => 'ThfGalleryFileWrap',
	'img_class' => 'img-thumbnail',
	'remove_class' => 'ThfGalleryEditorRemove',
);

ThfGalleryEditor::$ajax_upload=true;	
ThfGalleryEditor::$max_files=10;	
ThfGalleryEditor::$accept = 'jpg|jpeg|png|pdf|txt|doc|docx|xls|xlsx';
ThfGalleryEditor::$web_path=UPLOAD.'task_files/';
ThfGalleryEditor::$sv_path=THF_ROOT.UPLOAD.'task_files/';
ThfGalleryEditor::$file_name_policy='*i*';
ThfGalleryEditor::$overwritePolicy='r';
ThfGalleryEditor::$coloana_upload='files';
//ThfGalleryEditor::$id=floor($pid); //specifica ce id are produsul pentru a putea urca asincron poze si file
$tablename='task';




if ( isset( $_POST[ 'edit_task' ] ) ) {
	ThfGalleryEditor::$id=floor($_POST[ 'edit_task' ]);
    edit_task($_POST[ 'edit_task' ]);
    die;
}

if ( isset( $_POST[ 'save_task' ] ) and is_numeric($_POST[ 'save_task' ])) {
    $_POST['completed'] = $_POST['completed']=='on' ? date('Y-m-d') : '0000-00-00';
    $pid = $_POST[ 'save_task' ];
    unset($_POST[ 'save_task' ]);
	$target_row = $tasks[ $pid ];

	ThfGalleryEditor::$id=floor($pid);
	$old_task = $target_row;

	if($old_task['repeta_task'] != $_POST[ 'repeta_task' ] and $old_task['task_parinte']>0){
                //prea($_POST); die;
        delete_query("DELETE FROM task WHERE `task`.`task_parinte` = '".floor($old_task['task_parinte'])."' " );
        create_recursive_task($_POST,$pid);
    } elseif ($old_task['task_parinte']>0){
            update_qa("task",$_POST," task_parinte = " .floor($old_task['task_parinte'])," ");
    } else {
        update_qa("task",$_POST," task_id = " .floor($pid)," limit 1");
    }

    ThfAjax::status( true, 'Task salvat cu succes!' );
    ThfAjax::json();
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_REQUEST[ 'save_task' ])){	//prea($_FILES);	prea($_POST); die;
	ThfAjax::$out['show_time']=2000;
    $pid = $_REQUEST[ 'save_task' ];
	$target_row = $tasks[ $pid ];
	ThfGalleryEditor::$id=floor($pid);	

	ThfGalleryEditor::$database_pics=( is_numeric($pid) && $pid>0 ?json_decode($target_row[ThfGalleryEditor::$coloana_upload],true) : array() );//load existing stored pictures
	ThfGalleryEditor::actionFileController(); //unlinks files fron the drive and updates ThfGalleryEditor::$database_pics
	ThfGalleryEditor::uploadController();
	//ThfGalleryEditor::resize_uploaded_pics($resize_policy,$remove_original_pic=false);

	$_POST[ThfGalleryEditor::$coloana_upload]=json_encode( array_merge(ThfGalleryEditor::$database_pics , ThfGalleryEditor::$new_pics) );	

	if(is_numeric($pid)){ //update
		//prea($_FILES);	prea($_POST); die;
		update_qaf($tablename,$_POST,"`task_id`='$pid'",'LIMIT 1', $keys_to_exclude=array('task_id'), $setify_only_keys=array(), $return_query=false);
		ThfAjax::status( true, 'Task salvat cu succes!' );
//			if(count($_POST)>2){ThfAjax::redirect('?id='.$pid);}
//		redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.floor($pid));
	}
/*	elseif($pid=='i'){ //insert
		//$_POST[ThfGalleryEditor::$coloana_upload]=json_encode(ThfGalleryEditor::$new_pics);
		$id=insert_qa($tablename,$_POST,array('id'));
		ThfAjax::status(true,'Inserted successfully!'); 
		ThfAjax::redirect('?id='.$id);
		//redirect(303,'/locations/contracts.php?locations='.$location_id.'#c'.$id);
	}*/
	ThfAjax::json(); //generate upload report
}





if ( isset( $_POST[ 'list_tasks' ] ) and is_numeric($_POST[ 'list_tasks' ])) {
    foreach ($tasks as $task_id=>$task) {
        echo '<div id="task_row_'.$task_id.'">';
        echo list_un_task($task);
        echo '</div>';
    }
    die;
}

if ( isset( $_POST[ 'set_favorit' ] ) ) {
        update_query("UPDATE `task` SET `favorit` = '".q($_POST[ 'set_favorit' ]) ."' WHERE `task`.`task_id` = '".floor($_POST[ 'task_id' ] )."';");
        die;
}






if ( isset( $_POST[ 'get_emails' ] ) ) {
    $emails = multiple_query("SELECT * FROM `address_book_user` WHERE user_id = '".$login_user."' and email LIKE '%". $_POST[ 'get_emails' ]."%' ");
    foreach ($emails as $k=>$v){
        echo ' <li class="list-group-item ul_list_search">'.$v['email'].'</li>';
    }
    die;
}
if ( isset( $_POST[ 'send_email_task' ] ) ) {
    $email = strtolower($_POST[ 'send_email_task' ]) ;
   // prea($_POST);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $status = true;
        $raspuns = thf_mail($email,'support@trade-x.ro',$_POST[ 'subiect_email' ],$_POST[ 'descriere_email' ],'','support@trade-x.ro',true);
        if(!count_query("SELECT COUNT(*) FROM `address_book_user` WHERE email = '".$email."' and user_id = '".$login_user."' ")){
            insert_qa("address_book_user",array('email'=>$email,'user_id'=>$login_user));
        }
    } else {
        $msg =( "$email nu este o adresa de email valida! <br>");
        $status = false;
    }

    $msg .= $raspuns ? 'Email trimis cu succes!' : 'A aparut o eroare, va rugam sa reincercati!';


    //ThfAjax::redirect('/add_afacere/?edit=' . $pid . '#to_do_tab');
    ThfAjax::status($status, ($msg));
    ThfAjax::json();
}



if ( isset( $_POST[ 'adauga_task' ] ) ) {
    $insert = array(
        'task_name' => $_POST['adauga_task'],
        'type_task' => $_POST['type_task'],
        'user_id' => $user_id_login,
        'typetask_id' => $_POST['typetask_id'],
        'repeta_task' => (isset($_POST['repeta_task']) and $_POST['repeta_task'] > 0) ? $_POST['repeta_task'] : '0',
        'deadline' => ($_POST['deadline'] >= (date("Y-m-d")) ? $_POST['deadline'] : date("Y-m-d", strtotime("+2 day"))),
    );


       // prea($insert); prea($_POST); prea($_SERVER);die;

    $last_id = insert_qa("task", $insert);
    if ((isset($_POST['repeta_task']) and $_POST['repeta_task'] > 0)) {


        create_recursive_task($_POST, $last_id);
    }

        if (isset($_POST['auto_create'])) {
            echo $last_id;
            die;
        } else {
            if(is_numeric($pid) and $pid > 0) {
                ThfAjax::redirect('/add_afacere/?edit=' . $pid . '#to_do_tab');
            } else {
              //  ThfAjax::redirect('/');
            }
            ThfAjax::status(true, 'Task adaugat cu succes!');
            ThfAjax::json();
        }
    }

