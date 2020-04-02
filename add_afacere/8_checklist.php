<div id="checklist" class="div_step hide">
    <form action="/post.php" method="post" enctype="application/x-www-form-urlencoded" id="forma_checklist" class="ui" role="form" bootstrapToggle="true">
        <input type='hidden' name='edit_vanzare_checklist' id='edit_vanzare_checklist' value='<?php echo $vanzare['idv']; ?>'>
        <div class="ui ">
            <table class="table table-striped fixed line table-hover table-responsive ui purple table "
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

                foreach ($ckeck_list_text as $k=>$value){ ?>
                    <tr class=" list_row" >
                        <td id="text_list_<?=$k;?>"><?=$value['text']?>
                            <input type="hidden" name="task_id_<?php echo $k; ?>" value="<?=$check_list[$k]['task_id']?>">
                            <span style="display: none;" id="text_task_<?php echo $k; ?>"><?=$companii[$vanzari[$_GET['edit']]['companie_vanzare']]['denumire'] . ': '.$value['text'] . ' '?></span>
                        </td>
                        <td  class="bstrc" style="font-size: 1.2em; text-align: center;">
                            <div class="form-check">
                                <label class="togglex">
                                    <input name="q_<?php echo $k; ?>" type="radio" value="1" <?php echo ($check_list[$k]['se_aplica']==1?"checked":""); ?>>
                                    <span class="label-text">Da</span>
                                </label>
                                &nbsp; &nbsp;
                                <label class="togglex">
                                    <input name="q_<?php echo $k; ?>" type="radio" value="0" <?php echo ($check_list[$k]['se_aplica']==0?"checked":""); ?>>
                                    <span class="label-text">Nu</span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <?php

                            input_rolem('action_'.$k,'',$check_list[$k]['actiune'],'',false,"",true);
                            ?>
                        </td>
                        <td id="row_actiune_<?=$k;?>">
                            <?php if(is_numeric($check_list[$k]['task_id'])  and $check_list[$k]['task_id'] == 0) { ?>
                          <p onmousedown="create_task_list_checklist('<?=$k?>','<?=$value['qid'].'_'.$value['idc']?>');">
                              Creaza task

                          </p>
                            <?php } else {?>
                               <a target="_blank" href="<?='/tasks/?task_id=' . $check_list[$k]['task_id']?>"><i title=""  class="circular teal tasks alternate outline icon"></i><?=$tasks[$check_list[$k]['task_id']]['deadline']?></a>
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
    function create_task_list_checklist(row) {
        text = $('#text_task_'+row).text() + $('#action_'+row).val();
            $.post("/tasks/",{"adauga_task":text,"auto_create":""},function (r) {
                ThfAjax('Task creat cu succes!');
                $('[name=task_id_'+row+']').val(r);
                save_form('#forma_checklist');
                $('#row_actiune_'+row).html('<a target="_blank" href="/tasks/?task_id='+r+'"><i class="circular teal tasks  alternate outline icon"></i></a>');
               // ThfAjax(r);
            });
    }
</script>