function add_afacere(idc,id_forma) {
	//if (idc>0)
	//	{
		  $.post("/afaceri/index.php", {"add_afacere": "","id_forma":id_forma,"idc":idc}, function (data) {
        	window.location.href = "/add_afacere/?edit=" + data;
  		  });			
	//	}
//	else
//		{
//			window.location.href = "/add_afacere/?edit=0";
//		}
  
}

function assign_afacere(idc) {
	if (confirm("Esti sigur ca vrei sa asignezi aceasta afacere?"))
	 msg_bst_thf_loading();
	id_afacere=$('#id_afacere').val();
    $.post("/cumparatori/index.php", {"assign_afacere": "","id_afacere":id_afacere,"idc":idc}, function (data) {
      $('#full_table_comenzi').html(data.table);
      msg_bst_thf_loading_remove();
    });
}






function close_frame_side(){
    $('#side_bar_left').show();
    $('.one_row_div').removeClass('border_documente');
    $('.eye').removeClass('big').css('color','#4183c4').attr('onclick','open_frame_side(this)');
    $('#page_content').attr('class','').addClass('col-md-10 col-sm-10 vfx');
    $('#document_preview').html('');
}

function open_frame_side(obj){
    $('.one_row_div').removeClass('border_documente');
    $(obj).closest('.one_row_div').addClass('border_documente');
    path = $(obj).attr('path');
    if(typeof  path.split('/')[4] !== 'undefined') {
        var file = path.split('/')[4].toUpperCase();
    } else { file = path; }
    console.log(file);
    $(obj).css('color','green').attr('onclick','close_frame_side()');
    $('#side_bar_left').hide();
    $('#page_content').attr('class','').addClass('col-md-6 col-sm-6 vfx');
    $('#document_preview').attr('class','').addClass('col-md-6 col-sm-6 vfx');
    iframe = '<br><a class="ui button basic  red " style="float: right" onclick="close_frame_side()"> Close </a><span><h1 style="color: orange">'+file+'</h1></span><iframe style="width: 100%; height: 1300px;" scrolling="yes" src="'+path+'" frameborder="0"></iframe><a class="ui button basic  red " onclick="close_frame_side()"> Close </a>';
    $('#document_preview').html(iframe);
}





function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}



function showHideInputs(){
    $('form').each(function(){





    });
}

function edit_task(task_id) {
    $('.first_div').removeClass('teal');
    $('#task_row_'+task_id).find('.first_div').addClass('teal');
    $.post("/tasks/",{"edit_task":task_id},function (r) {
        //   $('#sidebar_raspuns').html(r);
        //   $('#sidebar_open').trigger('click');
        //   jQuery("body").jqueryuitime();

        $('#push_sidebar_thf').html(r);
        pushMeThf.open();
        pushMeThf.closeSidebarHook();
            $('#repeta_task').chosen();
        jQuery("#push_sidebar_thf").jqueryuitime();
        ThfGalleryEditor.init();
        reinatialize_semantic();
    });

}



function set_favorite(task_id,obj) {
    new_val = $(obj).attr('favorite')==0 ? 1 : 0;
    $.post("/tasks/",{"task_id" : task_id,"set_favorit":new_val},function (r) {
        $.post("/tasks/",{"list_tasks":task_id},function (r2) {
            $('#lista_tasks').html(r2);
        });
    });

}
function save_task_edit(task_id) {
    $.post("/tasks/",$('#edit_task').serialize(),function (r) {
        pushMeThf.close();
        ThfAjax(r);
        if($('.fc-event-container').length){ window.location.reload();}
        else {
            $.post("/tasks/", {"list_tasks": task_id}, function (r2) {
                $('#lista_tasks').html(r2);

            });
        }

    });
}




function send_email_task_js() {
    var activeEditor = tinyMCE.get('content');
        $('#descriere_email').val(activeEditor);
    tinyMCE.triggerSave();
    if($('#subiect_email').val().length < 1){
        alert('Completati subiectul emailului!');
        return 0;
    }
    if( $('#descriere_email').val().length < 1){
        alert('Completati continutul emailului!');
        return 0;
    }
    $.post("/tasks/",$('#send_email_task_form').serialize(),function (r) {
        ThfAjax(r);
        $('#send_mail_btn,#more_send_mail').addClass('hidden');
        $('.send_mail_field').val('');
    });
}
function adauga_task() {
    $.post("/tasks/",{"type_task" : $("#type_task").val(),"typetask_id" : $("#typetask_id").val(),"adauga_task":$('.add_task_field').val(),"deadline":$('[name=deadline]').val(),"repeta_task":$('#repeta_task').val(),"task_time":$('[name=task_time]').val()},function (r) {
        ThfAjax(r);
        $('#adauga_task_btn,#more_adauga_task').addClass('hidden');
        $.post("/tasks/",{"list_tasks":0},function (r2) {
            $('#lista_tasks').html(r2);
        });
    })
}


function global_search() {
	$('#myModalLabel').text('Cautare globala');
	$('#search_modal').modal('show');


    global_search_text = $('#search_in_modal').val();
    setInterval(function () {
        if (!$.active && global_search_text != $('#search_in_modal').val()) { //check if ajax request is in progress and form has changed

            global_search_text = $('#search_in_modal').val();
            if(global_search_text.length > 2) {
                msg_bst_thf_loading();
                $.post('/cauta/', {"q": global_search_text}, function (data) {
                    $('#modal_data_raspuns').html(data);
                    msg_bst_thf_loading_remove();
                
                });
            }
        }
    }, 500);
}





function create_proiect() {
	$.post("post.php", {"create_proiect": ""}, function (data) {
		window.location.href = "documente_edit.php?edit=" + data;
	});
}




function create_task_list(row) {
    text = $('#text_list_'+row).html();
    $.post("/tasks/",{"adauga_task":text,"auto_create":""},function (r) {
        $('.message').removeClass('error').addClass('positive');

        ThfAjax({
            "status": true,
            "msg": "Task creat!",
        });
        $('[name=task_id_'+row+']').val(r);
        save_form('#forma_checklist');
        // ThfAjax(r);
    });
}


function input_actions(){

    $('[name=judet_id]').change(function () {
        let select_modif = $(this);
        $.post('/post.php', {"judet_id": $(this).val(), "show_loc": 1}, function (data) {
            $(select_modif).closest('.localitati_judete').find('[name=localitate_id]').html(data).trigger("chosen:updated");
            $('.div_localitate_id select').html(data).trigger("chosen:updated");

            //	$(select_modif).closest('.localitati_judete').find('[name=localitate_id]').dropdown();
        });
    });

    $(".upload_file_input,.upload_file_input2").click(function() {
        $(this).parent().find("input:file").click();
    });

    $('input:file', '.ui.action.input')
        .on('change', function(e) {
            var name = e.target.files[0].name;
            $('.upload_file_input', $(e.target).parent()).val(name);
        });


    $('.logo_img').dblclick(
        function () {
            $(this).css('width','460px').css('height','345px');
        }
    );
    $('.logo_img').click(
        function () {
            $(this).css('width','90px').css('height','68px');
        }
    );


    return 0;
	$('#forma_adauga_vanzare').find('#div_cnp').hide();
	if($('#tip_beneficiar').val() == 'f'){
		$('#forma_reprezentant_vanzare .cui').addClass('hide');
		$('#forma_reprezentant_vanzare .cnp').removeClass('hide');
		$('#forma_reprezentant_vanzare #label_denumire').text('Nume prenume');
	} else {
		$('#forma_reprezentant_vanzare .cui').removeClass('hide');
		$('#forma_reprezentant_vanzare .cnp').addClass('hide');
		$('#forma_reprezentant_vanzare #label_denumire').text('Denumirea');
	}
}
function reinatialize_semantic(){
    $('.ui.sidebar').sidebar({
        context: $('.bottom.segment')
    }).sidebar('attach events', '.menu .item');
            //sidebar('push page', ' page');
	$('.ui.checkbox').checkbox();
	input_actions();
	//if(!$('[judet_id]').val().length){
	//	$('[judet_id]').prepend('<option disabled selected>Selecteaza un judet</option>');
	//}

	$('select.dropdown')
		.dropdown()
	;
	$( "#tabs" ).tabs();
    $( document ).tooltip();
}
$(function () {
    $('#tip_beneficiar').change(function () {
        input_actions();
    });
    $('.step').click(function () {
        $('#add_afac .step').removeClass('active');
        $(this).addClass('active');
        $('.div_step').hide();
        $('#' + $(this).attr('step')).removeClass('hide').show();
        ui_ordered_steps_completion();
    });





    $(".iframe").colorbox({iframe: true, width: "80%", height: "75%"});

    $('form[bootstrapToggle=true] input[type=checkbox][data-toggle][data-on][data-off]').change(function () {
        $(this).val($(this).prop('checked') ? $(this).attr('value-on') : $(this).attr('value-off'));
    }).prop('checked', function () {
        if ($(this).val() == $(this).attr('value-off')) {
            $(this).bootstrapToggle('off');
            return false;
        }
        $(this).bootstrapToggle('on');
        return true;
    });
    $('form[bootstrapToggle=true][serialize=false]').submit(function (event) {
        $('form[bootstrapToggle=true] input[type=checkbox][data-toggle][data-on][data-off]').attr('type', 'text');
    });


    $('.add_task_field').keyup(function () {
      /*
        if ($(this).val().length > 1) {
            $.post("",{"get_emails":$(this).val()},function (r) {
                $('.ul_list_search_div').html(r)
            })
        }*/
        if ($(this).val().length > 0) {
            $('#adauga_task_btn,#more_adauga_task').removeClass('hidden');
        } else {
            $('#adauga_task_btn,#more_adauga_task').addClass('hidden');
        }
    });

    $('.ul_list_search').click(function () {
        $('.send_mail_field').val($(this).text());
        $('.ul_list_search_div').html('');
    });



    $('.send_mail_field').keyup(function () {
        $(this) . trigger("chosen:updated");
        if ($(this).val().length > 1) {
            $.post("/tasks/",{"get_emails":$(this).val()},function (r) {
                $('.ul_list_search_div').html(r)
                $('.ul_list_search').click(function () {
                    $('.send_mail_field').val($(this).text());
                    $('.ul_list_search_div').html('');
                });
            })
        }


        if($(this).val().length > 0){
            $('#send_mail_btn,#more_send_mail').removeClass('hidden');
        } else {
            $('#send_mail_btn,#more_send_mail').addClass('hidden');
            $('.ul_list_search_div').html('');
        }
    });

});




	$( function() {
		reinatialize_semantic();
        $('.message .close')
            .on('click', function() {
                $(this)
                    .closest('.message')
                    .transition('fade')
                ;
            })
        ;
	} );



	$('form[bootstrapToggle=true] input[type=checkbox][data-toggle][data-on][data-off]').change(function() {
		$(this).val( $(this).prop('checked')?$(this).attr('value-on'):$(this).attr('value-off') );
	}).prop('checked',function(){
		if($(this).val()==$(this).attr('value-off')){$(this).bootstrapToggle('off'); return false;}
		$(this).bootstrapToggle('on');	return true;
	});
	$('form[bootstrapToggle=true][serialize=false]').submit(function(event){
		$('form[bootstrapToggle=true] input[type=checkbox][data-toggle][data-on][data-off]').attr('type','text');
	});


$(document).ready(function(){




    var widthh =  $('.add_afacere_slider' ).width() / 3;
    $('.add_afacere_slider').bxSlider({

        controls:false,
        pager: true,
        slideWidth: widthh-20,
        slideHeight : 80,
        //  minSlides: 3,
        maxSlides: 3,
        moveSlides: 3,
        pager: true,
        slideMargin: 1
    });
    $('.step').click(function(){
        $('.content').removeClass('border_purple');
        $(this).find('.content_mobile').addClass('border_purple');
    });


});