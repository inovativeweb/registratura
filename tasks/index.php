<?php
if (!$GLOBALS['has_config']) {require ('../config.php'); }
require (THF_PATH . '/tasks/controller.php');

$page_head[ 'title' ] = 'ToDo';
$page_head[ 'trail' ] = 'lista_to_do';

if(!$GLOBALS['index_head']){
    index_head();
}

?>

<div class="row">

    <div class="col-sm-6 col-md-6">
        <form action="" method="post" enctype="application/x-www-form-urlencoded" id="send_email_task_form">
        <div class="ui two column stackable  grid segment" style="height: 80px;">
            <div class="column aligned left">
                <label></label>
                    <input value="" name="send_email_task" class="line_input send_mail_field" placeholder="Trimite email catre..." />


            </div>
            <div class="column aligned right text-right">
                <div class="ui teal basic button hidden" id="send_mail_btn" onmousedown="send_email_task_js()">Trimite email</div>
                <br>
            </div>
        </div>
        <div class="row " id="">
            <ul class="list-group list ul_list_search_div" style="z-index: 1200"></ul>
        </div>
        <div class="row hidden" id="more_send_mail">

            <div class="col-sm-12 ui  stackable grid segment">
                <input name="subiect_email"  class="form-control line_input_alex" id="subiect_email" type="text" placeholder="Subiect...">
            </div>
            <div class="col-sm-12">
               <textarea class="tinymce" placeholder="" name="descriere_email" id="descriere_email"  aria-hidden="true"></textarea>
            </div>
        </div>
        </form>
    </div>


    <div class="col-sm-6 col-md-6">
        <div class="ui two column stackable  grid segment" style="height: 80px;">
            <div class="column aligned left">
                <label>
                    <input value="" class="line_input add_task_field" placeholder="Creaza un task" /><?=$task['deadline']?></label>
            </div>
            <div class="column aligned right text-right">
                <div class="ui teal basic button hidden" id="adauga_task_btn" onmousedown="adauga_task()">Adauga</div>
                <br>
            </div>
        </div>
        <div class="row hidden" id="more_adauga_task">
        <div class="col-sm-4">
            <?php 	select_rolem( 'repeta_task', 'Repeta ', $repeta_task, $task[ 'repeta_task' ], 'Alege...', false, array() );
            ?>

        </div>
        <div class="col-sm-4">
            <label>Deadline</label>
            <input name="deadline" value="<?=date("Y-m-d",strtotime('+1 day'))?>" class="form-control line_input_alex" dateTimePicker type="text"/>
        </div>
            <div class="col-sm-4">
                <label>Ora</label>
                <input name="task_time" value="<?=date("H:i")?>" class="form-control line_input_alex"  type="time"/>
            </div>
            <input type="hidden" name="typetask_id" id="typetask_id" />
            <input type="hidden" name="type_task" id="type_task" />

        </div>
    </div>
</div>
<div id="lista_tasks">
<?php

if(substr_count($_SERVER['REQUEST_URI'],'add_afacere')){
    $type_task = 'v';
    $typetask_id = $_GET['edit'];
} else if(substr_count($_SERVER['REQUEST_URI'],'add_cumparator')){
    $type_task = 'c';
    $typetask_id = $_GET['edit'];
} else {
    $type_task = 'g';
    $typetask_id = 0;
}


foreach ($tasks as $task_id=>$task) {
    if(($type_task != 'g' and ($type_task != $task['type_task'] || $task['typetask_id'] != $typetask_id) || $task['completed'] > 0)){
        continue;
    }
   // prea($task);
    echo '<div id="task_row_'.$task_id.'">';
    echo list_un_task($task);
    echo '</div>';
}
?>
</div>


<script>
    jQuery(function(){
        $('#type_task').val('<?=$type_task?>');
        $('#typetask_id').val('<?=$typetask_id?>');

        pushMeThf.auto_create();	});
    //	jQuery(function(){		pushMeThf.auto_demo();	});

</script>
<?php
if(!$GLOBALS['index_footer']) {
   // index_footer();
}