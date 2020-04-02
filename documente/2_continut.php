<div id="continut" class="div_step hide">
    <form  method="post" enctype="application/x-www-form-urlencoded" class="ui form continut_document_form" role="form" bootstraptoggle="true">
        <div class="ui form">

            <div class="field hide" id='descriere_publica_ro'>
                <div class="ui indicating progress" data-value="1" data-total="20" id="ocr_progress">
                    <div class="bar"></div>
                    <div class="label">Adaugare pagini</div>
                </div>
                <label  class="ui teal" style="color: #b5cc18!important">Rezultat procesare OCR &nbsp;<div class="ui inline hide loading_proceseaza" >&nbsp;&nbsp;Proceseaza&nbsp;&nbsp;<div class="ui active inline loader "></div></div>
                    <span id="counter_ocr"></span><span id="label_ocr_data_raspuns"></span></label>
                <a class="ui button basic  red " style="float: right; z-index: 6000; position: relative" onclick="$('#descriere_publica_ro').addClass('hide')"> Close </a>
                <textarea class="tinymce" placeholder="" name="descriere_publica"><?=get_document_data($pid)['continut_document_ocr'];?></textarea>
            </div>
            <div class="field" id='continut_document_div'>
                <label>Continut document&nbsp;</label>
                <textarea class="tinymce" placeholder="" id="continut_document" name="continut_document"><?=get_document_data($pid)['continut_document'];?></textarea>
            </div>

        </div>
    </form>
</div>

