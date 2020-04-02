function update_nr_pagini(data_json ){
    var obj= $('select[name=pag]');
    var new_options='';
    var label_txt = $('[for=pag]');
    for(i=1;i<=data_json.nb_pages;i++){
        new_options+='<option value="'+i+'">Pag '+i+' din '+data_json.nb_pages+'</option>';
    }
  //  console.log(data_json);
    obj.html(new_options);
   // obj.attr('title','Nr. Rezultate: '+data_json.total_results+'; Se afisaza '+data_json.results_per_page+' randuri pe pagina.');
    label_txt.html(data_json.total_results+' rezultate <small>('+data_json.results_per_page+'/pag)</small>');
    obj.val(data_json.curent_page);
    reinatialize_semantic();
}

function save_text_db(obj) {
   var ocr_text = $('[name=descriere_publica]').val();
    $.post('/post.php',{
        "ocr_text":ocr_text,
        "file_hash":$(obj).attr('path'),
        "doc_id":$('#idd').val()
    },function (r) {
        msg_bst_thf_loading_remove();
        $('.loading_proceseaza').addClass('hide');
    });
}


function recursively_ajax(active_num,end_num,obj){
    if (active_num > end_num) {
        save_text_db(obj);
        return };
    $('#counter_ocr').html(':  ' + $('[name=descriere_publica]').val().length + ' caractere. ' + '  <span style=""> Pagina ' + active_num+' din '+parseInt(end_num)+'</span>');
    var  number  = 0;
    $.ajax({
        type:"GET",
        url: "/post.php",
        data: {"pagina":active_num,"process_file":$(obj).attr('path'),"doc_id":$('#idd').val()},
        success: function(r){
                $('[name=descriere_publica]').val($('[name=descriere_publica]').val() + r);
                tinymce.get('descriere_publica').setContent($('[name=descriere_publica]').val());
                tinyMCE.triggerSave();
            $('#ocr_progress').progress({
                text: {
                    active  : 'Adding {value} of {total} photos',
                    success : '{total} Photos Uploaded!'
                },
                percent: active_num/end_num*100
            });
            number += recursively_ajax(active_num+1,end_num,obj);
        }
    });
    return number;
}


function read_ocr(obj){
    $('[step=continut]').trigger('click');
    $('#descriere_publica_ro').removeClass('hide');
    $('.loading_proceseaza').removeClass('hide');
    $('.one_row_div').removeClass('border_documente');
    $(obj).closest('.one_row_div').addClass('border_documente');
    $('[name=descriere_publica]').val('');
    tinymce.get('descriere_publica').setContent($('[name=descriere_publica]').val());
    tinyMCE.triggerSave();
   // msg_bst_thf_loading();

    $.get('/post.php',{"process_file":$(obj).attr('path'),"doc_id":$('#idd').val()},function (r) {
        if(r.indexOf('###pagini') > -1 ){ // pagina control nr de pagini
            pagini = r.replace('###pagini','').replace("###",'');
            $('#counter_ocr').html(pagini + ' pagini');
            $('#ocr_progress').attr('data-value',1).attr('data-total',pagini);
            recursively_ajax(1,pagini,obj);
           // tinymce.get('descriere_publica').setContent(r.replace("\n",'<br>').replace("\n",'<br>').replace("\n",'<br>').replace("\n",'<br>').replace("\n",'<br>'));
            //tinyMCE.triggerSave();

        } else {

            $('[name=descriere_publica]').val(r);
            tinymce.get('descriere_publica').setContent(r.replace("\n",'<br>').replace("\n",'<br>').replace("\n",'<br>').replace("\n",'<br>').replace("\n",'<br>'));
            tinyMCE.triggerSave();
          //  msg_bst_thf_loading_remove();
            $('.loading_proceseaza').addClass('hide');

        }

    })
}
function save_all_document_forms()
{
    if (0 && $("#edit_document").val()==0) // anulat
    {
        $.post("./index.php", {"add_document": ""}, function (data) {
            $(".forma_expeditor").find("#edit_document").val(data);
            save_form();

            //window.location.href = "/cumparatori/add_cumparator.php?edit=" + data;
        })
    }
    else
    {
        save_form();
     //   save_form_diligence();
    }

}

function verificari_forma() {
    msg = '';
    $('input[type=text]').css('background-color','white');
    $('form').each(function () {
        if($(this).find('[name=fullname]').length > 0 && $(this).find('[name=fullname]').val().length < 4){
            msg = 'Numele nu este valid!';
            $(this).find('[name=fullname]').css('background-color','#ffe6e6');
        }
        if($(this).find('[name=cnp]').length > 0 && $(this).find('[name=cnp]').val().length != 13){
            msg += '<P>CNP nu este valid!</P>';
            $(this).find('[name=cnp]').css('background-color','#ffe6e6');
        }

    })
    if(msg.length > 0){
        r = {"redirect":null,"status":true,"msg":msg,"callback":null,"callback_params":null,"click":false,"show_time":3000,"class":"alert-danger","data":[]};
        ThfAjax(r);
        $('#loading_save').addClass('hide');
        return false;
    } else {
        return true;
    }

}


function save_form() {

    msg = '';
    var forms = {};

    $('#loading_save').removeClass('hide');
    if (!verificari_forma()){ return;}

    tinyMCE.triggerSave();
   // alert(tinymce.get('continut_document'));

     forms.expeditor = $('.form_adauga_expeditor').serialize();
     forms.destinatar = $('.form_adauga_destinatar').serialize();
     forms.companie_destinatar = $('.forma_companie_destinatar').serialize();
     forms.companie_expeditor = $('.forma_companie_expeditor').serialize();
     forms.document_edit_insert = $('.document_edit_insert').serialize();
     forms.continut_document_data = $('.continut_document_form').serialize();
    document_iesireA = [];
    if($('.forma_row_iesire').length > 0) {
        $('.forma_row_iesire').each(function () {
            document_iesireA.push($(this).serialize());
        })
        forms.document_iesire = document_iesireA;
    }
    $.post("./post.php?edit="+$('#idd').val(),forms,function (r) {
        $('#loading_save').addClass('hide');
        ui_ordered_steps_completion();
        ThfAjax(r);
    });
}


function toggle_tab_documente(obj) {
    var tip = $(obj).attr('tip');
    $('.tab_item').removeClass('active');
    $(obj).addClass('active');
    if(tip == 'locuitor'){
        $('.div_locuitor').removeClass('hide');
        $('.div_companie').addClass('hide');
    } else {
        $('.div_companie').removeClass('hide');
        $('.div_locuitor').addClass('hide');
    }

}


function save_form_diligence()
{   var param = $('#forma_due_diligence').serialize();
    //console.log(param);
    $.post("./post.php",(param),function (r) {

        //   ThfAjax(r);
    });
}

function fill_locuitor_data(idl,obj) {
    msg_bst_thf_loading();
    let form=$(obj).closest('form');
    $.post("/documente/?edit="+$('#idd').val(),{"get_locuitor_data":idl,"formtype":form.attr('formtype'),"formname":form.attr('formname')},function (r) {
        form.parent().html(r);
        $('select').chosen();
        full_name_init();
        input_actions();
        msg_bst_thf_loading_remove();
        //$('.ul_list_search_div').html('');
    });


}


function full_name_init() {
    $('.fullname').keyup(function () {
        let form2=$(this).closest('form');
        $(this).trigger("chosen:updated");
        if ($(this).val().length > 1) {
            $.post("/documente/?edit="+$('#idd').val(), {"get_full_name": $(this).val()}, function (r) {
                if(!r) {
                    $(form2).find('[name=idl]').val('');
                }
                $(form2).find('.ul_list_search_div').html(r)
                $(form2).find('.ul_list_search').click(function () {
                    $(form2).find('.fullname').val($(this).text());
                    $(form2).find('.ul_list_search_div').html('');
                });
            })
        }
    });
}

function record_istoric(msg,obj){
    if(!confirm(msg)){ return;}
    save_all_document_forms();
    $.post('./post.php', {"alocat_la": $('#alocat_la').val(), "doc_id": $('#idd').val(),"status":$('#status').val()}, function (data) {
        var numes = $( "#alocat_la option:selected" ).text();
        var span1 = '<span style="font-size: 0.8em; color: grey">';
        var span2 = ' </span>';
        var i = '<i class="circular purple laravel  icon"></i>';
        nume = numes.split('(')[0];
        $('.alocat_h').html(nume + i +'<br>'+span1 +' - '+ numes.split('(')[1].replace(')','')+' - '+span2);

        ThfAjax(r);
    });
}


$( function () {
    full_name_init();
    $('#data_doc').change(function () {
        record_istoric('Esti sigur ca doresti sa schimbi data acestui document?');
    });
    $('#status').change(function () {
        record_istoric('Esti sigur ca doresti sa schimbi statusul acestui document?');
    });

    $('#alocat_la').change(function () {
        record_istoric('Esti sigur ca doresti sa aloci acest document?');
    });


    $(function () {
        jQuery("[name=cui]").blur(function(){
            var cui=jQuery(this).val();
            form =jQuery(this).closest('form');
            cui=cui.replace("r", ""); cui=cui.replace("R", "");
            cui=cui.replace("o", ""); cui=cui.replace("O", "");
            cui=cui.trim();
            //alert(cui);
            jQuery.post('https://inovativeweb.ro/api/anaf_api.php?cui_anaf_api='+cui, function(r) {
                var jd = JSON.parse(r)
                if(jd!=null){
                    if(jd.denumire!=null){form.find('[name=denumire]').val(jd.denumire).css('background-color','#e6f9ff');}
                    if(form.find('[name=reg_com]').val().length<2 && jd.registration_id!=null){form.find('[name=reg_com]').val(jd.registration_id).css('background-color','#e6f9ff');}
                    if(jd.adresa!=null){form.find('[name=adresa]').val(jd.adresa).css('background-color','#e6f9ff');}
                  //  if(jQuery('#oras').val().length<2 && jd.city!=null){jQuery('#oras').val(jd.city);}
                    if(form.find('[name=tel]').val().length<2 && jd.phone!=null){form.find('[name=tel]').val(jd.phone).css('background-color','#e6f9ff');}
                   // if(jQuery('#judet').val().length<2 && jd.state!=null){jQuery('#judet').val(jd.state);}
                }
            });
        });
    });

    $('#selecteaza_cumparator').change(function () {
        window.location = "./add_cumparator.php?edit="+$(this).val();
    });
    if(window.location.hash.length>1){
        $('[step='+window.location.hash.substr(1)+']').trigger('click');}
    else{
        $( '[step=date_cumparator]' ).addClass( 'active' );
    }

} );

function view_contract(obj) {
    //$('.list_lows').addClass('hide');
    //$('.forma_row_iesire').find('i').removeClass('blue').addClass('olive');
    var id_template = $(obj).closest('form').find('[name=id_template]').val();
    var id_doc = $(obj).closest('form').find('[name=id_doc]').val();

    if($('#view_template_'+id_doc+'_'+id_template).hasClass('hide')){   //este ascuns

        $('#view_template_'+id_doc+'_'+id_template).removeClass('hide');
        $(obj).find('i').removeClass('olive').addClass('blue');
    } else {
        $('#view_template_'+id_doc+'_'+id_template).addClass('hide');
        $(obj).find('i').removeClass('blue').addClass('olive');
    }
}

function edit_contract(obj) {
    var id_template = $(obj).closest('form').find('[name=id_template]').val();
    var id_doc = $(obj).closest('form').find('[name=id_doc]').val();
    if($('#text_documente_iesire_'+id_doc+'_'+id_template).hasClass('hide')){  // este ascuns
        $('#text_documente_iesire_'+id_doc+'_'+id_template).removeClass('hide');
        $(obj).find('i').removeClass('olive').addClass('blue');
    } else {
        $('#text_documente_iesire_'+id_doc+'_'+id_template).addClass('hide');
        $(obj).find('i').removeClass('blue').addClass('olive');
    }
}

function pdf_contract(obj) {
    msg_bst_thf_loading();
    var id_template = $(obj).closest('form').find('[name=id_template]').val();
    var id_doc = $(obj).closest('form').find('[name=id_doc]').val();
    var frame = $(obj).closest('form').find('iframe.iframe_pdf');
    if($('#pdf_documente_iesire_'+id_doc+'_'+id_template).hasClass('hide')){  //ascuns
        frame.attr('src','/pdf.php?id_doc='+id_doc+'&id_template='+id_template+'&template_contracte');
        $('#pdf_documente_iesire_'+id_doc+'_'+id_template).removeClass('hide');
        $(obj).find('i').removeClass('olive').addClass('blue');
    } else {
        frame.removeAttr('src');
        $('#pdf_documente_iesire_'+id_doc+'_'+id_template).addClass('hide');
        $(obj).find('i').removeClass('blue').addClass('olive');
    }
    msg_bst_thf_loading_remove();
}


function add_template(id_doc,action_template,id_template) {
    if(action_template == 'add') {
        var id_template = $('#template_doc_iesire').val();
        if (id_template < 1) {
            alert('Selecteaza un template!');
            return;
        }
    }
    var nume_form = $('.form_documente_iesire_'+id_doc+'_'+id_template).find('.header').text();
    if(action_template == 'delete') {
       if(!confirm('Esti sigur ca doresti sa stergi acest template?')){ return;}
    }
    $.post("/documente/post.php",{
        "id_doc":id_doc,
        "id_template":id_template,
      "action_template":action_template
    },function (r) {
      $('#documente_iesire_parent').html(r);
        $('.option_select_add').closest('select').prepend('<option value="'+id_template+'" class="option_select_add">'+nume_form+'</option>');
        jQuery('#template_doc_iesire').trigger("chosen:updated");
        tinymce_init ();
    });
}
function save_contract(id_doc,id_template) {
    var new_val = tinymce.get('contract_val').getContent();
    $.post("/documente/post.php",{"id_doc":id_doc,"id_template":id_template,"new_text_contract":new_val},function (r) {
        //ThfAjax(r);
        $('.print_btn').show();
        $('.edit_btn').show();
        $('.save_btn').hide();
        $('#forma_contract_val').hide();
        $('#forma_contract').html(new_val).show();
        $('[step=contract]').addClass('completed');
    });
}
