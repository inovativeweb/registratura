<?php require ('config.php');


$last_update = one_query("SELECT value FROM `thf_server` WHERE var = 'tasks_email_date' ");


$task_email = multiple_query("SELECT * FROM `task` t 
          LEFT JOIN thf_users u ON t.user_id = u.id
          WHERE task_id = '26'
 ");
//prea($task_email);

if(isset($_GET['fetch']) || ($last_update + 60*60*23 - time()) < 0){
    foreach ($users as $user_id=>$u) {
    $tasks = multiple_query("SELECT * FROM `task` t 
          WHERE 
          user_id = $user_id
          and deadline >= '".date("Y-m-d")."'
          AND task_id = '26'
          ORDER BY t.deadline ASC");

        $email['text'] = '';
    if(!count($tasks)){ continue; }
    foreach($tasks as $tt=>$task){
        $email['text'] .= '<tr><td>'.$task['task_name'].'</td><td>'.$task['task_description'].'</td><td>'.date("d-m-Y",strtotime($task['deadline'])).'</td></tr>';
    }
    $body = '<table border="1"><tr><th>Nume Task</th><th>Descriere</th><th>Deadline</th></tr></r></th><tr>'.$email['text'].'</tr></table>';
          echo $u['mail'] . '<br>';
          echo ($body);
         echo thf_mail($u['mail'],'support@trade-x.ro','Lista TODO din '.date("d-m-Y"),$body,$file_path='','support@trade-x.ro',$is_html=true);
    }



    update_query("UPDATE `thf_server` SET `value` = '".time()."' WHERE `thf_server`.`var` = 'tasks_email_date';");
}
