<?php

class ThfGalleryEditor_ury extends ThfGalleryEditor
{
    private static $img_extensions=array('jpg','jpeg','png','gif','ico','tiff');


    public static function pics_layout_frontend_lista($poze=array(),$ajax_request=0){
        //$poze['ordine']='full size webpath';  OR 	$poze['ordine'][0]='full size webpath';	AND	$poze['ordine'][1]='thumb webpath';
        /*		<div class="container">
        <div class="row colpadsm sortableRow">
            <div class="col-xs-6 col-md-4 col-lg-3">
                <div class="imgCoverContainer CoverRatio4_3">
                    <img class="img-thumbnail sortableObjDragger" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/14179/object-fit.jpg">
                    <div class="editArea noTextSelect">
                        <span class="glyphicon glyphicon-move txt_shadow" style="float: left;">Drag</span>
                        <i class="fa fa-times txt_shadow_bk pointer ThfGalleryEditorRemove" style="color: red;"> Remove</i>
                        </div>
                </div>
            </div>
        </div>
    </div> */
        if(!self::$id){self::$ajax_upload=false;} //nu se pot incarca file asincron pentru ca nu am un id de produs definit. Fac thumbnail-uri in front end... si trimit toata forma

        if(!$ajax_request){
            echo (self::$layout['container_class']?'<div class="'.self::$layout['container_class'].'">':'');
            echo '<div class="row sortableRow ThfGalleryEditor '.self::$layout['row_class'].'">';

            // <input accept="file_extension|audio/*|video/*|image/*|media_type">
            $accept=explode('|',self::$accept);
            foreach($accept as &$a){$a='.'.$a;}

        }
        foreach($poze as $i=>$poza){

            if(is_array($poza)){ $thumb=$poza[1]; $big=$poza[0]; } //$thumb=$poza[count($poza)-1]
            else{ $thumb=$poza; $big=$poza; }
            $ext=pathinfo($big);	$ext=explode('?',@$ext['extension']); $ext=strtolower($ext[0]);
            $is_image=in_array($ext,self::$img_extensions)?1:0;
            $wrap_class=$is_image?self::$layout['img_wrap_class']:self::$layout['file_wrap_class'];
            $path = h($poza);
            $file_fa='fa fa-file-o';
            $fa4=array(
                'fa fa-file-image-o'=>self::$img_extensions,
                'fa fa-file-word-o'=>array('doc','docx','odt','rtf'),
                'fa fa-file-archive-o'=>array('zip','rar','gz','tgz','7z','zipx'),
                'fa fa-file-pdf-o'=>array('pdf'),
                'fa fa-file-powerpoint-o'=>array('ppt','pptx'),
                'fa fa-file-text-o'=>array('txt','msg'),
                'fa fa-file-excel-o'=>array('xls','xlsx','xlsb','csv','xlr'),
                'fa fa-file-audio-o'=>array('aif','iff','m3u','m4a','mid','mp3','mpa','wav','wma',),
                'fa-file-video-o'=>array('3g2','3gp','asf','avi','flv','m4v','mov','mp4','mpg','rm','srt','swf','vob','wmv','mkv',),
            );
            foreach($fa4 as $file_fax=>$exts){
                if(in_array($ext,$exts)){$file_fa=$file_fax; break;}
            }
            $has_prev = false;
            if($is_image || in_array($ext,array('pdf','txt'))) {
                $has_prev = true;
            }
            echo '<div class="one_row_div col-xs-12 '.($i<0?' ThfGalleryEditorDefaultPic':'').'">'.
          //  echo '<div class="ddd '.self::$layout['col_class'].($i<0?' ThfGalleryEditorDefaultPic':'').'">'.
//					($i<0 || $is_image?'':'<span class="ThfGalleryEditorSlotTitle" title="'.h(basename($big)).'">' .h(basename($big)). '</span>').
                //href="'.$big.'" target="_blank"
                '<div class="imgCoverContainer sortableObjDragger '.$wrap_class.'" '.($i<0 ?'':'pathHash="'.md5($big).'"').'>'.
                ($is_image?
                    '<a href="'.f($big).'" colorbox rel="ggg" title="'.h(basename($big)).'">'.
                    '<img class="'.self::$layout['img_class'].'" src="'.f($thumb).'" href="'.f($big).'" colorboxpicxx title="'.h(basename($big)).'">'
                    .'</a>':
                    '<span class="ThfGalleryEditorSlotTitle" title="'.h(basename($big)).'"><i class="'.$file_fa.'" style="font-size:1.9em;"></i> &nbsp;
							<a path="'.$path.'" onclick="open_frame_side(this);"  >' .h(basename($big)). '</a></span>'
                ).

                ($i<0 ? '':'
							<div class="editArea noTextSelect">' .
                                 ($has_prev ? '<i title="Preview" class="icon pointer ui eye alternate circular blue outline icon " path="'.$path.'" onclick="open_frame_side(this);"  style="color: #4183c4;"></i>' : '').
                                 (1 ? '<i title="OCR" class="pointer ui file alternate circular olive outline icon" path="'.base64_encode($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$path).'" onclick="read_ocr(this);"  style="color: #4183c4;"></i>' : '').
								'<i class="fa fa-times  pointer '.self::$layout['remove_class'].'" style="color: red;"></i>
							</div>').
                '</div>
				</div>';

        }
        if(!$ajax_request){ //upload area

            //  echo '<div class="'.self::$layout['col_class'].'">
            echo '<div class="col-xs-12">										
					<div class="ThfGalleryEditorDropZone vfx">
						<div class="ThfGalleryEditorDropZoneTitle noTextSelect">Drag &amp; drop files here …<br>Max upload size: '.file_size('',ThfUpload::get_upload_max_filesize()).'</div>
					</div>
			
					
					
					<div class="bstBrowseWrapper noTextSelect" style="height:0; overflow:visible;">
						<div class="bstBrowsePlaceholder">Select files...</div>
						<div class="bstBrowseBtn">
							<div class="btn btn-primary btn-file">
								<i class="glyphicon glyphicon-folder-open"> Browse…</i>
								<input type="file" name="ThfGalleryEditorPics[]" class="ThfGalleryEditorPics" multiple '.
                (count(self::$accept)?'accept="'.implode(',',$accept).'"':'').' />
							</div>
						</div>
					</div>
				</div>';
            echo (self::$layout['container_class']?'</div>':'');
            echo '</div>';
        }

    }


    public static function uploadController_ury(){
        self::integrity_check();


        if(count($_FILES)){
            ThfAjax::$out['show_time']=4000; //js response class

            ThfUpload::check_files_integrity();
            ThfUpload::$overwritePolicy=self::$overwritePolicy; //r=rename, o=overwrite

            $accept=self::$accept;
            if(!is_array($accept)){$accept=explode('|',$accept);}
            ThfUpload::$alowed=$accept;

            ThfUpload::$FILES=array();
            ThfUpload::liniarize_class_files(array('ThfGalleryEditorPics'=>$_FILES['ThfGalleryEditorPics']));//only ThfGalleryEditorPics
            ThfUpload::upload_files(self::$file_name_policy,self::$sv_path.self::$id.'/');
            foreach(ThfAjax::$out['data']['upload'] as $k=>$file_report){
                if($file_report['error']<1){
                    self::$new_pics[]=$file_report['web_path'];
                    ob_start();
                    self::pics_layout_frontend_lista(array($file_report['web_path']),1);
                    ThfAjax::$out['data']['upload'][$k]['thumb']=ob_get_contents();
                    ob_end_clean();
                }
            }

            //prea(ThfUpload::$FILES);die;
            //ThfAjax::$out['data']['upload'][]=array('web_path'=>self::$FILES[$input_name]['web_path'],'name'=>self::$FILES[$input_name]['name'],'error'=>self::$FILES[$input_name]['error']);

            //ThfUpload::upload_one('ThfGalleryEditorPics', self::$file_name_policy , self::$web_path.self::$id.'/');
            //ThfAjax::status(true,'Saved successfully!');
            //ThfAjax::redirect('/administration/locations/contracts.php?locations='.$location_id.'#c'.floor($_POST['id']));
        }

    }
}


new ThfGalleryEditor_ury();