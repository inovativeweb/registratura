$(function(){
	$('#mobile_menu_btn>a').click(function(){
		$('#side_bar_left,#page_content').toggleClass('side_bar_left_open');
	});
});

$(function(){
	$('tr.mesaje').click(function(){
		$(this).next().toggleClass('hidden');
	});
/*	$('tr.mesaje>td:nth-child(-n+6)').click(function(){
		$(this).parent().next().toggleClass('hidden');
	});*/
});



function dell_jobs_cumparator(iddd){
	if(!confirm('Esti sigur ca vrei sa stergi aceasta intrare?')){return false;}
	$.post('',{dell_jobs_cumparator:iddd},function(r){
		ThfAjax(r);
	});
}



/*
[22:29, 5.10.2018] Cristi Uricariu: <div class="ui positive message">
  <i class="close icon"></i>
  <div class="header">
    You are eligible for a reward
  </div>
  <p>Go to your <b>special offers</b> page to see now.</p>
</div>
[22:35, 5.10.2018] Cristi Uricariu: https://semantic-ui.com/collections/message.html

*/

function msg_bst_gen_thf_remove(){	jQuery('#msg_bst_gen_thf').fadeOut(500,function(){	jQuery('#msg_bst_gen_thf').remove(); });	}
function msg_bst_gen_thf(msg,cls,completef,completef_args,show_time){
	if (typeof(msg)==='undefined' || !msg){var msg='Error!';}
	if (typeof(cls)==='undefined' || !cls){var cls='alert-danger';}
	if(cls==='alert-success'){cls='positive';}
	if(cls==='alert-danger' || cls==='negative'){cls='error';}
	
	
	if (typeof(completef)==='undefined' || !completef){var completef=null;}
	if (typeof(completef_args)==='undefined' || !completef_args){var completef_args=null;}
	if (typeof(show_time)==='undefined' || !show_time){var show_time=2700;}
	msg_bst_gen_thf_click(msg,cls,completef,completef_args);
	if(cls!='alert-danger' && cls!='error'){//alerts should be readable!
		setTimeout( function(){
			jQuery("#msg_bst_gen_thf").trigger('click');
			//msg_bst_gen_thf_remove();
		} , show_time);
	}

}

function msg_bst_gen_thf_click(msg,cls,completef,completef_args){
	if (typeof(msg)==='undefined' || !msg){var msg='Error!';}
	if (typeof(cls)==='undefined' || !cls){var cls='alert-danger';}
	if(cls==='alert-success'){cls='positive';}
	if(cls==='alert-danger' || cls==='negative'){cls='error';}
	
	if (typeof(completef)==='undefined' || !completef){var completef=null;}
	if (typeof(completef_args)==='undefined' || !completef_args){var completef_args=null;}
	
	jQuery('#msg_bst_gen_thf').remove();
	//jQuery("body").prepend('<div id="msg_bst_gen_thf"><button type="button" class="close">Ã—</button><div class="alert '+cls+'">'+msg+'</div></div>');
	jQuery("#div_raspuns_mesaj").html('<div id="msg_bst_gen_thf"><div class="ui '+cls+' message"><i class="close icon"></i><div class="header"></div><p>'+msg+'</p></div></div>');
	if(msg.length>50){jQuery('#msg_bst_gen_thf').css('padding','20%').css('text-align','left');}
	if(msg.length>100){jQuery('#msg_bst_gen_thf').css('padding','15%');}
	if(msg.length>250){jQuery('#msg_bst_gen_thf').css('padding','5%');}
	jQuery("#msg_bst_gen_thf").fadeIn(300).css('cursor','pointer').click(function(){
		msg_bst_gen_thf_remove();
		if(completef){
			if(completef_args!==null){window[completef](completef_args);}
			else{window[completef]();}
			}
		});
	jQuery("#msg_bst_gen_thf .close").click(function(){msg_bst_gen_thf_remove();});
	}


function ui_ordered_steps_completion(){

	$('#add_afac').find('[step]').each(function(i,s){
		let target_id=$(s).removeClass('completed').attr('completed','-1').attr('step');
		//console.log(s);
		if(typeof $(s).attr('valid') !=='undefined'  && parseInt($(s).attr('valid'))>0 ){
            $(s).addClass('completed').attr('completed',100);
		}
		else if($('#'+target_id).length>0){
			//console.log($('#'+target_id)[0]);
			var inputs=$('#'+target_id).find('input[type=text]:not(.chosen-search-input),input[type=email],input[type=number] ,input[type=date],select,textarea:not([name=descriere_publica])');
			//if(i===3){	console.log(inputs);}
			var percent=(inputs.length>0?0:100);
			var validated=0;
			inputs.each(function(j,inp){
				//console.log($(inp).attr('type'));
				if(i!=3 && $(inp).val() != null && $(inp).val().length>0){
					validated+=1;
				} else if($(inp).val() != null && i===3 &&  $(inp).val() > 0){
					validated+=1;
				}
				//else{console.log(inp);}
			});
			if(inputs.length>0){
				percent=Math.round(validated*100/inputs.length);
			}
			$(s).attr('completed',percent).find('.percent').remove();
			$(s).find('.percent_step').remove();
			$(s).append('<input type="hidden" name="percent_step['+$(s).attr('step')+']" value="'+percent+'" class="percent_step" />');
			
			if(percent>99 &&  i!=4 && i!=5 && i!=6){	$(s).addClass('completed');	}
			if($(s).find('.percent').length<1 && percent<100){
				$(s).find('.content').append('<span class="percent">'+percent+'%</span>');
			}
		}
	});

}

function init_ui_ordered_steps_completion(){
	ui_ordered_steps_completion();
	
	$('#ui_tabs_afacere').find('input[type],select,textarea').change(function(){
		ui_ordered_steps_completion();
	});
}
$(function(){
	setTimeout(function(){
		init_ui_ordered_steps_completion();
	},150);
	
});

