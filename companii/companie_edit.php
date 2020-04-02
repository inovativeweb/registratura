<?php
require_once('../config.php');
require_once('functions.php');
$page_head=array(	'meta_title'=>'Inregistreaza datele',	'trail'=>'companie');
if( !$is_admin and isset($_GET['edit'])){
//    redirect(302,'https://gilg.ro');
    require_login();

}

if(!$is_admin and isset($_GET['edit'])){ redirect(303,LROOT);}

if(isset($_GET['edit'])){$user=many_query("SELECT * FROM `companie` WHERE `id_companie`='".floor($_GET['edit'])."'  LIMIT 1 ");}
if(isset($_POST['check_data'])){
    if(!isset($_GET['edit'])){
        if(count_query("SELECT COUNT(*) FROM companie WHERE tel = '".$_POST['tel']."' ") > 0) {
            echo $_POST['telefon'] . ' exista deja inregistrat';
            die;
        }
        if(count_query("SELECT COUNT(*) FROM companie WHERE  email = '".$_POST['email']."' ") > 0) {
            echo $_POST['email'] . ' exista deja inregistrat';
            die;
        }
    }

    die;
}

if(count($_POST)){

    $_POST['data_adaugat'] = date("Y-m-d H:i:s");
    if(isset($_POST['save_companie']) && is_numeric($_POST['save_companie'])){//update
        update_qaf('companie',$_POST,'`id_companie`='.@floor($_POST['save_companie']),'LIMIT 1');
       die('Updated');
    }
    else{//insert
            $last_id=insert_qa('companie',$_POST);
              echo "Creat";
            die;
    }
}

index_head();
?>
<div class="ui floating message red hide">
</div>
<?php
if(!isset($_GET['edit'])){ //INSERT FORM
        companie_edit(array(),'Date companie','form_companie');
    }   else{ //UPDATE FORM

		companie_edit($_GET['edit'],'Date companie','form_companie');
   }


index_footer();


?>
<script>
    $(function () {
        $('#tel, #email').change(function () {
            $.post('', {"check_data":"","tel":$('#tel').val(),"email":$('#email').val()}, function (r) {
                    if(r.length > 0){
                       alert(r);
                    }
            });
        })
    });
    
function save_insert_companie() {
	console.log("1");
    var msg = '';
    if($('#denumire').val().length < 4){ msg = 'Introduceti denumirea companiei<br>';}
    if($('#reg_com').val().length < 4){ msg += 'Introduceti Registrul comertului<br>';}
    if($('#adresa').val().length < 4){ msg += 'Introduceti Adresa valida<br>';}
    if($('#cont_iban').val().length < 4){ msg += 'Introduceti Cont IBAN<br>';}
    if($('#banca').val().length < 4){ msg += 'Introduceti Banca<br>';}
    if($('#email').val().length < 4){ msg += 'Introduceti Email valid<br>';}
    if($('#tel').val().length < 4){ msg += 'Introduceti Telefon valid<br>';}
    
    if(msg.length > 0){
        $('.message').removeClass('hide').html(msg);
        return 0;

    }else {
        form = $('form').serialize();
        $('.message').addClass('hide').html('');
        $.post('', form, function (r) {
            if(r == 'Creat'){
              $('h3').remove();
              $('form').remove();
              $('#button_save').remove();
                location.href = "index.php";
            }
            else if(r == 'Updated'){
                location.href = "index.php";
            }
        });
    }
    
}
</script>
