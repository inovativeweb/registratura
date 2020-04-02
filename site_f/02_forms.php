<?php

function input_rolem_column($name,$descriere='',$valoare='',$placeholder='',$required=true,$extra=array(),$echo_only_input=false){
	if(!isset($extra['type'])){$extra['type']='text';}
	if(!isset($extra['class'])){$extra['class']='';}
	if(!$echo_only_input){echo '<div id="div_'.$name.'" class="column " '.$name.'>
    <label id="label_'.$name.'" for="'.$name.'">'.h($descriere).'</label>';}
	echo '<input type="'.$extra['type'].'" class="form-control'.($extra['class']?' '.$extra['class']:'').'" name="'.$name.'" id="'.$name.'" '.($placeholder?' placeholder="'.h($placeholder).'"':'').' value="'.h($valoare).'" '.($required?'required':'').' ';
	if(isset($extra['attr']) && is_array($extra['attr'])){
		foreach($extra['attr'] as $k=>$v){
			echo $k.($v? (substr($v,0,1)=='{'?"='$v'":'="'.$v.'"') :NULL).' ';
		}
	}
	echo ' />';
	if(!$echo_only_input){echo ' </div>'."\r\n";}
}

function input_rolem($name,$descriere='',$valoare='',$placeholder='',$required=true,$extra=array(),$echo_only_input=false){
	if(!isset($extra['type'])){$extra['type']='text';}
	if(!isset($extra['class'])){$extra['class']='';}
	if(!$echo_only_input){echo '<div id="div_'.$name.'" class=" field " '.$name.'>
    <label id="label_'.$name.'" for="'.$name.'">'.h($descriere).'</label>';}
    echo '<input type="'.$extra['type'].'" class=" '.$name.' form-control'.($extra['class']?' '.$extra['class']:'').'" name="'.$name.'" id="'.$name.'" '.($placeholder?' placeholder="'.h($placeholder).'"':'').' value="'.h($valoare).'" '.($required?'required':'').' ';
	  if(isset($extra['attr']) && is_array($extra['attr'])){
		  foreach($extra['attr'] as $k=>$v){
			  echo $k.($v? (substr($v,0,1)=='{'?"='$v'":'="'.$v.'"') :NULL).' ';
			  }
		  }
	  echo ' />';
	  if(!$echo_only_input){echo ' </div>'."\r\n";}
	}
function input_rolem_decimal($name,$descriere='',$valoare='',$placeholder='',$zecimale=1,$readonly=false){ 
	echo '<div class="form-group" '.$name.'>
    <label class="control-label col-sm-2" for="'.$name.'">'.h($descriere).'</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" name="'.$name.'" id="'.$name.'" placeholder="'.h($placeholder).'" value="'.h($valoare).'" required step="'.(1/pow(10,$zecimale)).'" '.($readonly?'readonly':'').' />
    </div>
  </div>'."\r\n";
	}
function select_rolem_semantic($name,$descriere='',$lista=array(),$selectat=NULL,$placeholder='',$echo_only_input=false,$extra=array()){
	if(!isset($extra['class'])){$extra['class']='';}

	if(!$echo_only_input){echo ' 
			<div class="field" '.$name.'>
									<label for="'.$name.'">'.$descriere.'</label>';
	}echo '<select '.$name.' name="'.$name.'" id="'.$name.'"  '.($extra['class']?'class=" ui search dropdown" '.$extra['class'].'"':' class="ui search dropdown"').' ';
	if(isset($extra['attr']) && is_array($extra['attr'])){
		foreach($extra['attr'] as $k=>$v){
			echo $k.($v? (substr($v,0,1)=='{'?"='$v'":'="'.$v.'"') :NULL).' ';
		}
	}
	echo '>'."\r\n";
	foreach($lista as $k=>$v){
		echo '<option value="'.h($k).'" '.(
			is_array($selectat) && in_array($k,$selectat)?' selected="selected"':
				!is_array($selectat) && $selectat==$k?' selected="selected"':''
			).'>'.h($v).'</option>'."\r\n";
	}
	echo '</select>';
	if(!$echo_only_input){echo '</div>';}
}


function select_rolem($name,$descriere='',$lista=array(),$selectat=NULL,$placeholder='',$echo_only_input=false,$extra=array()){
	if(!isset($extra['class'])){$extra['class']='';}
	echo '<div class="field ">';
	if(!$echo_only_input){echo '<label class="control-label">'.h($descriere).'</label>';}
	echo '<select '.$name.' name="'.$name.'" id="'.$name.'" data-placeholder="'.h($placeholder).'" '.($extra['class']?'class="'.$extra['class'].'"':'').' ';
	if(isset($extra['attr']) && is_array($extra['attr'])){
		foreach($extra['attr'] as $k=>$v){
			echo $k.($v? (substr($v,0,1)=='{'?"='$v'":'="'.$v.'"') :NULL).' ';
		}
	}
	echo '>'."\r\n";
	foreach($lista as $k=>$v){
		echo '<option value="'.h($k).'" '.(
			is_array($selectat) && in_array($k,$selectat)?' selected="selected"':
				!is_array($selectat) && $selectat==$k?' selected="selected"':''
			).'>'.h($v).'</option>'."\r\n";
	}
	echo '</select>';
	if(!$echo_only_input){echo '';}
	echo '</div>';
}

function checkbox_rolem($name,$descriere='',$valoare='',$data_toggle='',$required=false,$echo_only_input=false){
	if($data_toggle===-1){	$data_toggle=' data-toggle="toggle" data-on="<span class=\'glyphicon glyphicon-star\'></span> DA" data-off="NU"  value-on="0" value-off="1" data-onstyle="success" data-offstyle="default" data-width="82"  data-size="small"  ';}
	elseif(!$data_toggle){	$data_toggle=' data-toggle="toggle" data-on="<span class=\'glyphicon glyphicon-star\'></span> DA" data-off="NU"  value-on="1" value-off="0" data-onstyle="success" data-offstyle="default" data-width="82"  data-size="small"  ';}
	
	if(!$echo_only_input){echo '<div class="form-group"><label class="control-label col-sm-2" for="'.$name.'">'.h($descriere).'</label><div class="col-sm-10">';}
    echo '<input type="checkbox" class="form-control" name="'.$name.'" id="'.$name.'"  value="'.h($valoare).'" '.$data_toggle.' '.($required?'required':'').'  />';
	if(!$echo_only_input){echo '</div></div>'."\r\n";}
	}
function input_send_rolem($txt='Salveaza',$class='btn-success',$echo_only_input=false,$name=''){
	if(!$echo_only_input){echo '<div class="form-group"> <div class="col-sm-offset-2 col-sm-10">';}
	echo '<button type="submit" '.($name?'name="'.$name.'"':'').' class="btn '.$class.'">'.$txt.'</button>';
	if(!$echo_only_input){echo ' </div> </div>';}
	}


function draggable_filter_input_hand($name,$descriere='',$valoare='',$placeholder='',$required=true,$extra=array(),$operators=array(),$default_operator='',$select_list=array()){

	if(!isset($extra['type'])){$extra['type']='text';}
	if(!isset($extra['class'])){$extra['class']='';}
	if(count($operators)<1){$operators=array('=','>','<','like%.%','like%.','like.%',);}
	if($default_operator && !in_array($default_operator,$operators)){$operators[]=$default_operator;}
	if(!$default_operator){$default_operator=$operators[0];}
	
	$op=array(
		'='=>'equal to',
		'!='=>'not egual to',
		'like%.%'=>'contains',
		'notlike%.%'=>'does not contain',
		'like'=>'like',
		'like.%'=>'starts with',
		'like%.'=>'ends with',
		'>'=>'>',
		'<'=>'<',
		);


	echo '<li>            
            <div class="hari"><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span></div>
            <div class="hale"><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span></div>
			<div class="input-group">                
                <div class="input-group-btn">
                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.h($descriere).'  <span class="filter_operator">'.h($op[$default_operator]).'</span></button>
                <ul class="dropdown-menu dropdown-menu-left filter_operator_menu">';
				foreach($op as $o=>$v){	echo (in_array($o,$operators)?'<li><a operator="'.h($o).'">'.h($v).'</a></li>':'');  }			
				
   			echo'</ul></div>';
			if(count($select_list)){ echo '<div style="margin-top:4px; margin-left:4px;">';
				select_rolem($name,$descriere,$select_list,$valoare,$placeholder,true,$extra);
				echo '</div>';
				}
			else{$extra['class']=' input-sm';	input_rolem($name,$descriere,$valoare,$placeholder,$required,$extra,true);}
            echo '<input type="hidden" value="'.h($default_operator).'" name="operator_'.h($name).'" />
                </div>
			<div class="clear"></div>
            </li>';
	}


function textarea_rolem($name,$descriere='',$valoare='',$placeholder='',$required=true,$extra=array(),$echo_only_input=false){
	if(!isset($extra['class'])){$extra['class']='';}
	if(!$echo_only_input){echo '<div class="field">
    <label class="control-label" for="'.$name.'"><i class="globe icon"></i>'.h($descriere).'</label>';
    }
    echo '<textarea class="form-control'.($extra['class']?' '.$extra['class']:'').'"  name="'.$name.'" id="'.$name.'" '.($placeholder?' placeholder="'.h($placeholder).'"':'').'  '.($required?'required':'').' ';
	  if(isset($extra['attr']) && is_array($extra['attr'])){
		  foreach($extra['attr'] as $k=>$v){
			  echo $k.($v? (substr($v,0,1)=='{'?"='$v'":'="'.$v.'"') :NULL).' ';
			  }
		  }
	  echo '>'.h($valoare).'</textarea>';
	  if(!$echo_only_input){echo ' </div>'."\r\n";}
	}



?>