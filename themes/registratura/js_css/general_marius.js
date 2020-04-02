
	$( function() {
		
		
		
		$('.users_form')
  .form({
    name: {
        identifier: 'full_name',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga nume'
          }
        ]
      },
      
      username: {
        identifier: 'username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga username'
          }
        ]
      },
         pass: {
        identifier: 'pass',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga parola'
          },
          {
            type   : 'minLength[6]',
            prompt : 'Parola tebuie sa contina minim {ruleValue} caractere'
          }
        ]
      
    },
        mail: {
        identifier: 'mail',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga email'
          }
        ]
      },
         tel: {
        identifier: 'tel',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga telefon'
          }
        ]
      },
        judet_id: {
        identifier: 'judet_id',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga judet'
          }
        ]
      },
        localitate_id: {
        identifier: 'localitate_id',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga localitate'
          }
        ]
      },


      rol: {
        identifier: 'rol',
        rules: [
          {
            type   : 'empty',
            prompt : 'Adauga rol'
          }
        ]
      },
        
       
   

  })
;

    $('#users_from').api({
        action: '',
         method: 'post',
        serializeForm: false,
        dataType: 'text',
        onSuccess: function() {
            // todo
        },
        onInvalid: function() {
		
        }
      
    });
	
	});
	
function add_document_nou(id_forma) {
	$.post("/documente/post.php", {"add_document": "","id_forma":id_forma}, function (data) {
        //console.log(data);
		window.location.href = "/documente/add_document.php?edit=" + data;
	});
}


function validate_fields()
{

		$('#forma_adauga_vanzare #div_cont_iban').removeClass('error');
		$('#forma_reprezentant_vanzare #div_tel').removeClass('error');
		$('#forma_adauga_vanzare #div_tel').removeClass('error');
		$('#forma_reprezentant_vanzare #div_email').removeClass('error');
		$('#forma_adauga_vanzare #div_email').removeClass('error');
		$('#forma_reprezentant_vanzare #div_website').removeClass('error');
		$('#forma_adauga_vanzare #div_website').removeClass('error');
		$('#div_cifra_afaceri').removeClass('error');
		$('#div_profit_anual').removeClass('error');
		
		$('#div_pret_vanzare').removeClass('error');
		$('#div_patrimoniu_imobiliar').removeClass('error');
		$('#div_fond_comercial').removeClass('error');
		$('#div_marca_comerciala').removeClass('error');
		$('#div_nr_angajati').removeClass('error');
		$('#div_cifra_afaceri_anterior').removeClass('error');
		
	msg_error="";
	var re_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var re_website = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
	phone=$('#forma_reprezentant_vanzare input[name=tel]').val();
	phone_v=$('#forma_adauga_vanzare input[name=tel]').val();
	email=$('#forma_reprezentant_vanzare input[name=email]').val();
	email_v=$('#forma_adauga_vanzare input[name=email]').val();
	website=$('#forma_reprezentant_vanzare input[name=website]').val();
	website_v=$('#forma_adauga_vanzare input[name=website]').val();
	
	cont_iban_v=$('#forma_adauga_vanzare input[name=cont_iban]').val();
	cifra_afaceri=$('input[name=cifra_afaceri]').val();
	profit_anual=$('input[name=profit_anual]').val();
	
	pret_vanzare=$('input[name=pret_vanzare]').val();
	patrimoniu_imobiliar=$('input[name=patrimoniu_imobiliar]').val();
	fond_comercial=$('input[name=fond_comercial]').val();
	marca_comerciala=$('input[name=marca_comerciala]').val();
	nr_angajati=$('input[name=nr_angajati]').val();
	cifra_afaceri_anterior=$('input[name=cifra_afaceri_anterior]').val();
	
	if (phone!="" && !( phone.length>=10 && phone.length<13 && phone.match(/^[0-9]+$/) != null ))
	{
		msg_error+="Formatul numarului de telefon (Date vanzator) nu este corect<br/>";
		$('#forma_reprezentant_vanzare #div_tel').addClass('error');
	}
	if (phone_v!="" && !( phone_v.length>=10 && phone_v.length<13 && phone_v.match(/^[0-9]+$/) != null ))
	{
		msg_error+="Formatul numarului de telefon (Date companie) nu este corect<br/>";
		$('#forma_adauga_vanzare #div_tel').addClass('error');
	}
	if (email!="" && !re_email.test(email))
	{
		msg_error+="Formatul email-ului (Date vanzator) nu este corect<br/>";
		$('#forma_reprezentant_vanzare #div_email').addClass('error');
	}
	if (website!="" && !re_website.test(website))
	{
		msg_error+="Formatul website-ului (Date vanzator) nu este corect<br/>";
		$('#forma_reprezentant_vanzare #div_website').addClass('error');
	}
	if (website_v!="" && !re_website.test(website_v))
	{
		msg_error+="Formatul website-ului (Date companie) nu este corect<br/>";
		$('#forma_adauga_vanzare #div_website').addClass('error');
	}
	if (email_v!="" && !re_email.test(email_v))
	{
		msg_error+="Formatul email-ului (Date companie) nu este corect<br/>";
		$('#forma_adauga_vanzare #div_email').addClass('error');
	}
	
	if (cont_iban_v!="" && cont_iban_v.length!=24)
	{
		msg_error+="Formatul IBAN (Date companie) nu este corect<br/>";
		$('#forma_adauga_vanzare #div_cont_iban').addClass('error');
	}
	if (cifra_afaceri!="" && !$.isNumeric(cifra_afaceri))
	{
		msg_error+="Cifra de afaceri trebuie sa fie un numar!<br/>";
		$('#div_cifra_afaceri').addClass('error');
	}
	if (profit_anual!="" && !$.isNumeric(profit_anual))
	{
		msg_error+="Profitul anual trebuie sa fie un numar!<br/>";
		$('#div_profit_anual').addClass('error');
	}
	if (pret_vanzare!="" && !$.isNumeric(pret_vanzare))
	{
		msg_error+="Pret vanzare trebuie sa fie un numar!<br/>";
		$('#div_pret_vanzare').addClass('error');
	}
	if (patrimoniu_imobiliar!="" && !$.isNumeric(patrimoniu_imobiliar))
	{
		msg_error+="Patrimoniul imobiliar trebuie sa fie un numar!<br/>";
		$('#div_patrimoniu_imobiliar').addClass('error');
	}
	if (fond_comercial!="" && !$.isNumeric(fond_comercial))
	{
		msg_error+="Fondul comercial trebuie sa fie un numar!<br/>";
		$('#div_fond_comercial').addClass('error');
	}
	if (marca_comerciala!="" && !$.isNumeric(marca_comerciala))
	{
		
		msg_error+="Marca comerciala trebuie sa fie un numar!<br/>";
		$('#div_marca_comerciala').addClass('error');
	}
	if (nr_angajati!="" && !$.isNumeric(nr_angajati))
	{
		msg_error+="Numar angajati trebuie sa fie un numar!<br/>";
		$('#div_nr_angajati').addClass('error');
	}
	if (cifra_afaceri_anterior!="" && !$.isNumeric(cifra_afaceri_anterior))
	{
		msg_error+="Cifra de afaceri din anii anteriori trebuie sa fie un numar!<br/>";
		$('#div_cifra_afaceri_anterior').addClass('error');
	}
	
if (msg_error!="")
{
		ThfAjax({ redirect: null, status: false, msg: msg_error, callback: null, callback_params: null, click: false, show_time: 3000, class: null, data: [] });
		return false;
}
else
{
	
	return true;
}	
	
}
