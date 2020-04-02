<div id="date_document" class="div_step">

<div class="ui top attached tabular menu">
    <div class="tab_item item active" tip="locuitor" onclick="toggle_tab_documente(this)">Date persoane</div>
    <div class="tab_item item " tip="companie"  onclick="toggle_tab_documente(this)">Date juridice</div>

</div>
<div class="ui bottom attached active tab segment">
<div id="" class=" div_locuitor">
       <div class="ui ">
        <br><?php

               if(!count($expeditori)){
                      expeditor_destinatar_edit_insert($expeditori, $from_doc, 'form_adauga_expeditor', 'Date expeditor');
               }
                foreach ($expeditori as $idl=>$v) {
                    expeditor_destinatar_edit_insert($v, $from_doc, 'form_adauga_expeditor', 'Date expeditor');
                    }

               if(!count($destinatari)){
                   expeditor_destinatar_edit_insert($destinatari, $from_doc, 'form_adauga_destinatar', 'Date destinatar');
               }
               foreach ($destinatari as $idl=>$v) {
                   expeditor_destinatar_edit_insert($v, $from_doc, 'form_adauga_destinatar', 'Date destinatar');
               } ?>
       </div>
    </div>


    <div id="" class=" div_companie hide">


    <?php
    if(!count($companie_expeditor)){
        companie_edit($v,'Date juridice expeditor','forma_companie_expeditor');
    }
    foreach ($companie_expeditor as $idc=>$v) {
        companie_edit($v,'Date juridice expeditor','forma_companie_expeditor');

    } ?>
    <hr>
    <?php
    if(!count($companie_destinatar)){
        companie_edit($v,'Date juridice destinatar','forma_companie_destinatar');
    }
    foreach ($companie_destinatar as $idc=>$v) {
        companie_edit($v,'Date juridice destinatar','forma_companie_destinatar');


    } ?>

</div>
</div>
</div>

