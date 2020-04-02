<?php
require_once('../config.php');
$page_head=array(	'meta_title'=>'Inregistreaza datele',	'trail'=>'locuitori');
if( !$is_admin and isset($_GET['edit'])){
//    redirect(302,'https://gilg.ro');
    require_login();

}

if(!$is_admin and isset($_GET['edit'])){ redirect(303,LROOT);}

if(isset($_GET['edit'])){$user=many_query("SELECT * FROM `locuitori` WHERE `idl`='".floor($_GET['edit'])."'  LIMIT 1 ");}
if(isset($_POST['check_data'])){
    if(!isset($_GET['edit'])){
        if(count_query("SELECT COUNT(*) FROM locuitori WHERE telefon = '".$_POST['telefon']."' ") > 0) {
            echo $_POST['telefon'] . ' exista deja inregistrat';
            die;
        }
        if(count_query("SELECT COUNT(*) FROM locuitori WHERE  email = '".$_POST['email']."' ") > 0) {
            echo $_POST['email'] . ' exista deja inregistrat';
            die;
        }
    }

    die;
}

if(count($_POST)){

    $_POST['data_adaugat'] = date("Y-m-d H:i:s");
    if(isset($_POST['save_plata']) && is_numeric($_POST['save_plata'])){//update
        update_qaf('locuitori',$_POST,'`idl`='.@floor($_POST['save_plata']),'LIMIT 1');
       die('Updated');
    }
    else{//insert
            $last_id=insert_qa('locuitori',$_POST);
              echo "Creat";
            die;
    }
}
function locuitor_edit($user){ global $strazi,$organigrame;
    ?>
    <form action="" method="post" enctype="application/x-www-form-urlencoded" class="ui form " role="form" bootstraptoggle="true" serialize="false">
    <?php
    input_rolem('fullname','Nume Prenume',$user['fullname'],'Nume Prenume',true,array('attr'=>array('pattern'=>'.{5,}')));
    ?><div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <label>Selecteaza strada</label>
                <?php select_rolem('id_strada',$descriere='',$strazi,$user['id_strada'],$placeholder='',$echo_only_input=false,$extra=array());?>
            </div>
        </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <label>Functie in administratie</label>
                    <?php
                    $organigrame[0] = 'Fara functie';
                    select_rolem('id_organigrama',$descriere='',$organigrame,$user['id_organigrama'],$placeholder='',$echo_only_input=false,$extra=array());?>
                </div>
            </div>
        </div>


        <div class="three fields"><?php
    input_rolem('cnp','CNP',$user['cnp'],'CNP',false,array());
    input_rolem('serie_ci','Serie Nr CI',$user['serie_ci'],'Serie Nr CI',false,array());
    input_rolem('telefon','Telefon',$user['telefon'],'telefon',false,array());
            ?> </div>   <div class="three fields"><?php
    input_rolem('adresa','Adresa',$user['adresa'],'adresa',false,array());
     input_rolem('email','Email',$user['email'],'Email',false,array('type'=>'email'));

    echo '<br><br>';
        echo '<input type="hidden" value="'.$_GET['edit'].'" name="save_plata" />'


    ?> </div>
    </form>
    <button type="button" id="button_save" onmousedown="save_plata()" class="ui basic green button ">Salveaza</button>
    <?php
}
index_head();
?>
<div class="ui floating message red hide">
</div>
<?php
if(!isset($_GET['edit'])){ //INSERT FORM
        locuitor_edit();
    }   else{ //UPDATE FORM




        //prea($user);

        locuitor_edit($user);
   }


index_footer();


?>
<script>
    $(function () {
        $('#telefon, #email').change(function () {
            $.post('', {"check_data":"","telefon":$('#telefon').val(),"email":$('#email').val()}, function (r) {
                    if(r.length > 0){
                       alert(r);
                    }
            });
        })
    })
function save_plata() {
    var msg = '';
    if($('#fullname').val().length < 4){ msg = 'Introduceti numele<br>';}
    if($('#telefon').val().length < 4){ msg += 'Introduceti telefonul<br>';}
    if($('#adresa').val().length < 4){ msg += 'Introduceti Adresa valida<br>';}
    if($('#email').val().length < 4){ msg += 'Introduceti Email valid<br>';}
    if($('#id_strada').val() == 0){ msg += 'Selectati strada!<br>';}


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
                location.href = "/locuitori/index.php";
            }
            else if(r == 'Updated'){
                location.href = "/locuitori/index.php";
            }
        });
    }
}
</script>
