function update_nr_pagini(data_json ){
    var obj= $('select[name=pag]');
    var new_options='';
    var label_txt = $('[for=pag]');
    for(i=1;i<=data_json.nb_pages;i++){
        new_options+='<option value="'+i+'">Pag '+i+' din '+data_json.nb_pages+'</option>';
    }
    console.log(data_json);
    obj.html(new_options);
    obj.attr('title','Nr. Rezultate: '+data_json.total_results+'; Se afisaza '+data_json.results_per_page+' randuri pe pagina.');
    label_txt.html(data_json.total_results+'&nbsp;rezultate <small>('+data_json.results_per_page+'/pag)</small>');
    obj.val(data_json.curent_page);
    reinatialize_semantic();
}

function change_pret_input(id) {
    var achizitie = $('#pret_achizitie_'+id).val();
    var pret_emag = $('#pret_emag_'+id).val();
    var adaos = $('#adaos_'+id).val();
    $('#pret_emag_'+id).val(parseFloat(achizitie) + parseFloat(adaos));
}
function change_pret_emag(id) {
    var achizitie = $('#pret_achizitie_'+id).val();
    var pret_emag = $('#pret_emag_'+id).val();
    var adaos = $('#adaos_'+id).val();
    var comision = $('#comision_'+id).attr('comision');
    $('#pret_emag_'+id).val(parseFloat(achizitie) + parseFloat(adaos)+parseFloat(comision));
}
function change_pret_adaos(id) {
    var achizitie = $('#pret_achizitie_'+id).val();
    var pret_emag = $('#pret_emag_'+id).val();
    var adaos = $('#adaos_'+id).val();
    var comision = $('#comision_'+id).attr('comision');
    $('#adaos_'+id).val(parseFloat(pret_emag) - parseFloat(achizitie) - parseFloat(comision));
}

function save_prd_api(id_prd) {
   msg_bst_thf_loading();
    var new_price = $('[new_price_id_prd='+id_prd+']').val();
    var new_stoc = $('#stoc_'+id_prd).val();
    var numar_zile_livrare = $('#livrare_zile_data_'+id_prd).val();
    console.log(numar_zile_livrare);
    $.post("./get_emag_api.php", {"save_prd_api": id_prd,"sale_price":new_price,"stoc":new_stoc,"numar_zile_livrare":numar_zile_livrare}, function (data) {
        $('#tr_id_prd_' + id_prd).show();
        $('#raspuns_'+id_prd).html(data);
        $.post("./controller.php",{"get_row_data":id_prd},function (row) {
            $('#tr_data_'+id_prd).removeAttr('class').attr('class', '');
            $('#tr_data_'+id_prd).html(row);
            var stoc_emag = $('#stoc_emag_'+id_prd).attr('stoc_emag');
            if(stoc_emag > 0){$('#tr_data_'+id_prd).addClass('positive')}
            else {$('#tr_data_'+id_prd).addClass('negative')}

            // $('.name_prd').css('max-width','355px');
            // $('#tr_data_'+id_prd).css('width','100%');
            initialize_actions();
            msg_bst_thf_loading_remove();
        });

    });
}


function save_all_rows() {
    msg_bst_thf_loading();
    var jsonObj = {}

    $('[name=set_buy_first]').each(function () {
        if($(this).is(':checked')){
            id_prd = $(this).attr('row');
            new_stoc = $('#stoc_'+id_prd).val();
            new_price = $('#pret_emag_'+id_prd).val();
            jsonObj[id_prd] = new_price+'_'+new_stoc ;
        }
    });
   // console.log(jsonObj);

    //console.log(jsonObj);
    $.post("./get_emag_api.php",{"save_multiple_prd":jsonObj},function (idss) {
        msg_bst_thf_loading_remove();
        reinatialize_semantic();
    });
}

function get_all_prd_api(id_prd) {
    msg_bst_thf_loading();
    var jsonObj = {}

    $('.list_row').each(function () {
        id_prd = $(this).attr('id_prd');
        var newID = id_prd;
        var newValue = id_prd;
        jsonObj[newID] = newValue ;
    });
    //console.log(jsonObj);
    $.post("./get_emag_api.php",{"get_all_active_prod":jsonObj},function (idss) {
        $.post("./index.php",{"ajax":"1","list_ids_row":idss},function (data) {

            $('#full_table_comenzi').html(data.table);
            data.table='';
            update_nr_pagini(data);
            initialize_actions();
            msg_bst_thf_loading_remove();
            reinatialize_semantic();
        });
    });
}


function get_prd_api(id_prd) {
    msg_bst_thf_loading();
$.post("./get_emag_api.php",{"get_active_prod":id_prd},function (data) {
    $('#tr_id_prd_'+id_prd).show();
    $('#raspuns_'+id_prd).html(data);
            $.post("./controller.php",{"get_row_data":id_prd},function (row) {
                $('#tr_data_'+id_prd).removeAttr('class').attr('class', '');
                    $('#tr_data_'+id_prd).html(row);
                var stoc_emag = $('#stoc_emag_'+id_prd).attr('stoc_emag');
                if(stoc_emag > 0){$('#tr_data_'+id_prd).addClass('positive')}
                else {$('#tr_data_'+id_prd).addClass('negative')}

               // $('.name_prd').css('max-width','355px');
               // $('#tr_data_'+id_prd).css('width','100%');
                initialize_actions();
                msg_bst_thf_loading_remove();
                reinatialize_semantic();
            });

});
}
function cancel_all_rows() {
    $("[name=set_buy_first]").prop('checked', false);
    show_hide_save_row();
}

function show_hide_save_row(){
    if($("[name=set_buy_first]:checked").length > 0){
        $('.change_hide').removeClass('hide');
    } else {
        $('.change_hide').addClass('hide');
    }
}
function initialize_actions() {
    $('[name=set_buy_first]').change(function () {
        var id = $(this).attr('row');
        var checked = $("[row=" + id + "]:checked").length;
        $('#pret_emag_'+id).val($('#best_offer_sale_price_'+id).text());
        show_hide_save_row();
        change_pret_adaos(id);

    });
}

function emag(idp,cod) {
    $('#'+idp).hide();
    $.post('/get_emag.php',{"idp":idp,"cod":cod},function (data) {
        if(data=='<span style="color:green"> <span class="glyphicon glyphicon-ok"></span> &nbsp;Produs asociat! : </span>'){
            //   $('#link_'+idp).show().attr('href','http://www.emag.ro/laptop-le07ari/pd/'+data+'/').html('<span style="color:green;" class="fa-plus " aria-hidden="true"></span>');
            $('#link_'+idp).show().attr('href','http://www.emag.ro/laptop-le07ari/pd/'+data+'/').html('<span style="color:green;" class="glyphicon glyphicon-ok"></span>');
        }
        else {
            $('#red_'+idp).addClass('fa fa-times');
            //  $('#link_'+idp).show().html('<span style="color:red;" class="fa fa-times" aria-hidden="true"></span>');}
            $('#link_'+idp).show().html(' <span style="color:red;" class="glyphicon glyphicon-remove"></span>');}

        $('#raspuns_emag_insert_'+idp).html('<br>'+data+'<br>');
    })
}

function change_doc_status_front(idp){
    $.post("/cms/controller.php",{'add_update_status_documentare_emag':idp, "status_nou":"0"}, function(raspuns){
        $('#color_doc_'+idp).css('color',raspuns);
    });
}
