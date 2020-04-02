<div id="due_diligence" class="div_step hide">
<form action="/post.php" method="post" enctype="application/x-www-form-urlencoded" id="forma_due_diligence" class="ui" role="form" bootstrapToggle="true">
 <input type='hidden' name='edit_cumparator' id='edit_cumparator' value='<?php echo $cumparator['idc']; ?>'>
       <div class="ui ">
       	<table class="table table-striped fixed line table-hover table-responsive ui olive table "
           xmlns="http://www.w3.org/1999/html">
        <thead>
        <tr>
     
        <th width="40%">Pentru Verificarea afacerii</th>
        <th width="20%">Se aplică afacerii?	</th>
        <th width="20%">Acțiunea de urmat:</th>
        <th width="20%">Adauga To Do</th>
     
        </tr></thead>
        <tbody>

        <?php

        foreach ($due_diligence_text as $k=>$value){ ?>
            <tr class=" list_row" >
                 
                <td id="text_list_<?=$k;?>"><?=$value['text']?></td>
   				<td  class="bstrc" style="font-size: 1.2em; text-align: center;">
                    <input type="hidden" name="task_id_<?php echo $k; ?>" value="<?=$due_diligence[$k]['task_id']?>">
                    <span style="display: none;" id="text_task_<?php echo $k; ?>"><?=$cumparatori[$_GET['edit']]['full_name'] . ': '.$value['text'] . ' '?></span>
   				<div class="form-check">
								<label class="togglex">
									<input name="q_<?php echo $k; ?>" type="radio" value="1" <?php echo ($due_diligence[$k]['se_aplica']==1?"checked":""); ?>>
									<span class="label-text">Da</span>
								</label>
								&nbsp; &nbsp; 
								<label class="togglex">
									<input name="q_<?php echo $k; ?>" type="radio" value="0" <?php echo ($due_diligence[$k]['se_aplica']==0?"checked":""); ?>>
									<span class="label-text">Nu</span>
								</label>
							</div>	
   				</td>
   				<td>
   				<?php
   				
					input_rolem('action_'.$k,'',$due_diligence[$k]['actiune'],'',false,"",true);
   				?>	
   				</td>
                <td id="row_actiune_<?=$k?>">

                    <?php if(is_numeric($due_diligence[$k]['task_id'])  and $due_diligence[$k]['task_id'] == 0) { ?>
                        <p onmousedown="create_task_list_due('<?=$k?>');">
                            Add

                        </p>
                    <?php } else {?>
                        <i title="" class="circular teal calendar alternate outline icon"></i><?=$tasks[$due_diligence[$k]['task_id']]['deadline']?>
                    <?php } ?>
                </td>
                
            </tr>

        <?php } ?>
        </tbody>
    </table>	
  </div>
 </form>
</div>
<script>
    function create_task_list_due(row) {
        text = $('#text_task_'+row).text() + $('#action_'+row).val();
        $.post("/tasks/",{"adauga_task":text,"auto_create":""},function (r) {

            ThfAjax({
                "status": true,
                "msg": "Salvat",
            });
            $('[name=task_id_'+row+']').val(r);
            save_form_diligence();
            $('#row_actiune_'+row).html('<i class="circular teal calendar alternate outline icon"></i>');
            // ThfAjax(r);
        });
    }
</script>