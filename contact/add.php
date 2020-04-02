<?php
require_once('../config.php');

if(count($_POST)){
	if(isset($_POST['et_pb_contact_name_0'])){$_POST['et_pb_contact_name_1']=$_POST['et_pb_contact_name_0'];}
	if(isset($_POST['et_pb_contact_email_0'])){$_POST['et_pb_contact_email_1']=$_POST['et_pb_contact_email_0'];}
	if(isset($_POST['et_pb_contact_message_0'])){$_POST['et_pb_contact_message_1']=$_POST['et_pb_contact_message_0'];}
	echo insert_qa('form_contact',$_POST,array('id','contactat_de_broker_id','contactat_de_broker_pe',));
	die();
}
/*
et_pb_contact_name_0: Nistor Alexandru Marius
et_pb_contact_email_0: djthorr@gmail.com
tel: +40742601660
industrie: aero
oras: oras
judet: bv
interesat_sa: vand
suma_disponibila: 5555
et_pb_contact_message_0: sr sdg sdg sdgh sdh dfh dfh dfh hd fh df
et_pb_contactform_submit_0: et_contact_proccess
et_pb_contactform_validate_0: 
et_pb_contact_captcha_0: 10
_wpnonce-et-pb-contact-form-submitted-0: a10c96af8a
_wp_http_referer: /despre-noi/contact/
et_pb_contact_email_fields_0: [{"field_id":"et_pb_contact_name_0","original_id":"name","required_mark":"required","field_type":"input","field_label":"Nume"},{"field_id":"et_pb_contact_email_0","original_id":"email","required_mark":"required","field_type":"email","field_label":"Adresa de email"},{"field_id":"et_pb_contact_message_0","original_id":"message","required_mark":"required","field_type":"text","field_label":"Mesajul tau"}]
et_pb_contact_email_hidden_fields_0: [""]
*/
if(0){?><script><?php }
header("content-type: text/javascript; charset=utf-8");
?>
(function($){
	$(function(){
		$('form.et_pb_contact_form>p:nth-child(2)').after(
			'<div>'+
			
				'<p class="et_pb_contact_field et_pb_contact_field_half">'+
					'<input type="text" class="input" placeholder="Telefon" name="tel">'+
				'</p>'+
			
				'<p class="et_pb_contact_field et_pb_contact_field_half">'+
					'<input type="text" class="input" placeholder="Industrie/Activitate" name="industrie">'+
				'</p>'+	
			
				'<p class="et_pb_contact_field et_pb_contact_field_half">'+
					'<input type="text" class="input" placeholder="Oras" name="oras">'+
				'</p>'+
			
				'<p class="et_pb_contact_field et_pb_contact_field_half">'+
					'<input type="text" class="input" placeholder="Judet" name="judet">'+
				'</p>'+
						
				'<p class="et_pb_contact_field et_pb_contact_field_half">'+
					'<input type="text" class="input" placeholder="Interesat sa" name="interesat_sa">'+
				'</p>'+			

				'<p class="et_pb_contact_field et_pb_contact_field_half">'+
					'<input type="text" class="input" placeholder="Suma disponibila" name="suma_disponibila">'+
				'</p>'+	
			
			'</div>'
		);
		$('#et_pb_contact_name_1').attr('placeholder','Nume');
		$('#et_pb_contact_email_1').attr('placeholder','Adresa de email');
		
		$('form.et_pb_contact_form').attr('action','//brokers.trade-x.ro/contact/add.php');
		
	});
})(jQuery);
	
//	add custom script with theme config widget < sc ript src="https://brokers.trade-x.ro/contact/add.php">< / script>
