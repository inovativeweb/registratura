<div class="container-fluid">
    <div class="row">

<div class="col-xs-1"><input type="radio" value="ro" onclick="change_desc_teaser('ro',this)" name="lang" id='lang_ro'>&nbsp;<i class="ro flag"></i></div>
<div class="col-xs-1"><input type="radio" value="en" onclick="change_desc_teaser('en',this)"  name="lang" id='lang_en'>&nbsp;<i class="gb uk flag"></i></div>
    </div>
</div>

        <br>

<div id="teaser" class="div_step hide"></div>
    <script>
        function change_desc_teaser(lang_type,obj) {
            $(obj).prop('checked',true);
            $.post("/add_afacere/post.php",{"change_desc_teaser":lang_type,"vanzare_edit":<?=$_GET['edit']?>},function (r) {
                $('#teaser').html(r);
            });
          }

        $(function () {
            change_desc_teaser('en',$('#lang_en'));
        });
    </script>

