<?php
function edit_task( $task_id ) {
	global $tasks,$repeta_task;
	$task = $tasks[ $task_id ];
	
	
	?>
	<div align="right"><button type="button" class="close pushMeThfClose" aria-label="Close"><span aria-hidden="true">× </span></button></div>
	<form id="edit_task">
		<input type="hidden" name="save_task" value="<?=$task_id;?>"/>
		<div class="container-fluid colpadsm">
			<div class="row">
				<div class="col-xs-2">
                    <label class="form_control">Inchide</label>
					<div class="ui huge checkbox" style="width: 0; height: 0; overflow: visible; position: relative; bottom: -16px;" >
						<input name="completed" <?=$task[ 'completed']> 0 ? ' checked' : ''?> type="checkbox" />
						<label></label>
					</div>
				</div>
				<div class="col-xs-10">
					<input value="<?=$task['task_name']?>" name="task_name" class="form-control line_input_alex" type="text">
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
                    <label class="form_control">Descriere</label>
					<textarea class="form-control line_textarea_alex" name="task_description"><?=$task['task_description']?></textarea>
				</div>
			</div>	

            <div class="row">
                <div class="col-xs-12">
                    <?php 	select_rolem( 'repeta_task', 'Repeta ', $repeta_task, $task[ 'repeta_task' ], 'Alege...', false, array() ); ?>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-12">
                    <label class="form_control">Deadline</label>
					<input name="deadline" value="<?=$task['deadline']?>" class="form-control line_input_alex" dateTimePicker type="text"/>
				</div>
			</div>
            <div class="row">
                <div class="col-xs-12">
                    <label class="form_control">Ora</label>
                    <input name="task_time" value="<?=$task['task_time']?>" class="form-control line_input_alex"  type="time"/>
                </div>
            </div>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-4">
					<div class="ui teal basic button" onmousedown="save_task_edit(<?=$task_id?>)">Inchide</div>
				</div>
			</div>
		</div>
	</form>
	
	<script>
	<?php ThfGalleryEditor::javascript_settings(); ?>	
	</script>	
	<div class="container-fluid"><div class="row"><div class="col-xs-12">
		<!--<h3>Atasamente:</h3>-->
		<form action="/tasks/?save_task=<?=$task_id;?>" method="post" enctype="multipart/form-data" class="ThfGalleryEditorForm">
			<?php  //prea($target_row);
			ThfGalleryEditor::pics_layout_frontend(ThfGalleryEditor::get_poze_produs($task[ThfGalleryEditor::$coloana_upload]));
			?>
			<!--<input type="hidden" name="save_task" value="<?=$task_id;?>"/>-->
		</form>
	</div></div></div>

	<?php
}


function create_recursive_task($task_post,$last_id){  global $user_id_login;
    $q = 0;$i=0;
    $task_post[ 'adauga_task' ] = strlen($task_post[ 'adauga_task' ]) ? $task_post[ 'adauga_task' ] : $task_post['task_name'];
    $dead_line = $task_post['deadline'];
    if($task_post['repeta_task'] == 1){             //repeta task
        for($i=1;$i<300;$i++){
            $insert_task_children = array(
                'task_name' => $task_post[ 'adauga_task' ],
                'task_time' => $task_post[ 'task_time' ],
                'user_id' => $user_id_login,
                'repeta_task' => ($task_post['repeta_task']),
                'deadline' => date("Y-m-d",strtotime($dead_line."+ ".$i." days ")),
                'task_parinte' => $last_id
            );
            insert_qa( "task", $insert_task_children );
        }
    }

    if($task_post['repeta_task'] == 3){
        for($i=1;$i<50;$i++){
            $q = $q+7;
            $insert_task_children = array(
                'task_name' => $task_post[ 'adauga_task' ],
                'task_time' => $task_post[ 'task_time' ],
                'user_id' => $user_id_login,
                'repeta_task' => ($task_post['repeta_task']),
                'deadline' => date("Y-m-d",strtotime($dead_line."+ ".$q." days ")),
                'task_parinte' => $last_id
            );
            insert_qa( "task", $insert_task_children );
        }
    }

    if($task_post['repeta_task'] == 4){
        for($i=1;$i<25;$i++){
            $q = $q+14;
            $insert_task_children = array(
                'task_name' => $task_post[ 'adauga_task' ],
                'task_time' => $task_post[ 'task_time' ],
                'user_id' => $user_id_login,
                'repeta_task' => ($task_post['repeta_task']),
                'deadline' => date("Y-m-d",strtotime($dead_line."+ ".$q." days ")),
                'task_parinte' => $last_id
            );
            insert_qa( "task", $insert_task_children );
        }
    }


    if($task_post['repeta_task'] == 5){
        for($i=1;$i<12;$i++){
            $q = $q+30;
            $insert_task_children = array(
                'task_name' => $task_post[ 'adauga_task' ],
                'task_time' => $task_post[ 'task_time' ],
                'user_id' => $user_id_login,
                'repeta_task' => ($task_post['repeta_task']),
                'deadline' => date("Y-m-d",strtotime($dead_line."+ ".$q." days ")),
                'task_parinte' => $last_id
            );
            insert_qa( "task", $insert_task_children );
        }
    }

    if($task_post['repeta_task'] == 7){
        for($i=1;$i<3;$i++){
            $q = $q+364;
            $insert_task_children = array(
                'task_name' => $task_post[ 'adauga_task' ],
                'task_time' => $task_post[ 'task_time' ],
                'user_id' => $user_id_login,
                'repeta_task' => ($task_post['repeta_task']),
                'deadline' => date("Y-m-d",strtotime($dead_line."+ ".$q." days ")),
                'task_parinte' => $last_id
            );
            insert_qa( "task", $insert_task_children );
        }
    }
}


function list_un_task( $task ) { global $icon_type_task;
    $titlu = '';
    $files = json_decode($task['files'],true);
        foreach ($files as $k=>$name){
            $titlu .= $name . ' | ';
        }
	?>
	<div class="ui three column stackable aligned grid first_div segment" onmousedown="edit_task('<?=$task['task_id']?>');">
		<div class="column left add_task">
            <a class="ui gray left ribbon label">
                <?=$task['deadline']?>
            </a>
			<div class="ui checkbox">
				<input type="checkbox" <?=$task[ 'completed']> 0 ? ' checked' : ''?> name="fun">
				<label>
                    <i class="<?=$icon_type_task[$task['type_task']]?>"></i>
					<?=$task['task_name']?>
				</label>
			</div><br>
			<span style="color:#00b5ad"><?=$task['completed'] > 0 ? $task['completed'] : ''?></span>
		</div>

		<div class="column left hidden-xs hidden-sm">
			<div class="ui vertical divider left"></div>
		</div>

		<div class="column right">
            <a class="ui teal right ribbon label ">
                <?=date("H:i", strtotime($task['task_time']));?>
            </a>
			<div class="aligned right text-right selectable icon note_icon fa fa-file-text-o" style="color: <?=count($files) > 0 ? '#00b5ad' : ''?>" title="<?=$titlu?>"><?=count($files) > 0 ? count($files) : ''?></div>&nbsp;&nbsp;
			<div class="aligned right text-right icon fa fa-star-o" style="font-size:22px;color:<?=$task['favorit']? 'orange' : ''?>" title="Star task" favorite="<?=$task['favorit']?>" onmousedown="set_favorite('<?=$task['task_id']?>',this)"></div>&nbsp;&nbsp;
		</div>

	
	</div>
	<?php } ?>