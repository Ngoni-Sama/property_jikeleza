/*global $, jQuery, ajaxcalls_vars, document, control_vars, window,plupload,ajax_vars*/ 
var current_no_up;
jQuery(document).ready(function($) {
    "use strict";
    wpestate_delete_binder();
    wpestate_caption_setter();
    var array_cut;
    var should_warn=0;
    current_no_up=  parseInt( $('.uploaded_images ').length,10);
    array_cut=0;
 
    //wpestate_allow_upload(current_no_up,ajax_vars.max_images);
  
    if (typeof(plupload) !== 'undefined') {
            var uploader = new plupload.Uploader(ajax_vars.plupload);
            uploader.init();
            uploader.bind('FilesAdded', function (up, files) {
            
                //current_no_up=current_no_up+ajax_vars.max_images;
            
                
                if(ajax_vars.max_images>0){ // if is not unlimited
                    if(current_no_up===0){
                        array_cut=ajax_vars.max_images;
                        if(files.length>ajax_vars.max_images){
                            current_no_up=array_cut;
                        }else{
                            current_no_up=files.length;
                        }
                    }else{
                        if (current_no_up>=ajax_vars.max_images){
                            array_cut=-1;
                        }else{
                            array_cut=ajax_vars.max_images-current_no_up;
                            if(files.length>array_cut){
                                current_no_up=current_no_up+array_cut;
                            }else{
                                current_no_up=current_no_up+files.length;
                            }
                          
                        }
                    }
                  
              
                    if(array_cut>0 ){
                        up.files.slice(0,array_cut);
                        files.slice(0,array_cut);   
                        var i = array_cut;
                        while (files.length>array_cut){
                            up.files.pop();
                            files.pop();  
                            should_warn=1;
                        }
                    }
                    
                    if(should_warn===1){
                        $('.image_max_warn').remove();
                        $('#imagelist').before('<div class="image_max_warn" style="width:100%;float:left;">'+ajax_vars.warning_max+'</div>');
                        
                    }
                    
                    if( array_cut==-1 ){
                        $('.image_max_warn').remove();
                        $('#imagelist').before('<div class="image_max_warn" style="width:100%;float:left;">'+ajax_vars.warning_max+'</div>');
                        files=[];
                        up=[];
                        return;
                    }

                }
                
                $.each(files, function (i, file) {
                        $('#aaiu-upload-imagelist').append(
                        '<div id="' + file.id + '">' +
                        file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                        '</div>');
                });

                up.refresh(); // Reposition Flash/Silverlight
                uploader.start();
               
            });

            uploader.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " b").html(file.percent + "%");
            });

            // On erro occur
            uploader.bind('Error', function (up, err) {
                $('#aaiu-upload-imagelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );   
                up.refresh(); // Reposition Flash/Silverlight
            });



            uploader.bind('FileUploaded', function (up, file, response) {
                var result = $.parseJSON(response.response);
                $('#image_warn').remove();
                $('#' + file.id).remove();
                
           
                
                if (result.success) {               
                   
                    $('#profile-image').attr('src',result.html);
                    $('#profile-image').attr('data-profileurl',result.html);
                    $('#profile-image').attr('data-smallprofileurl',result.attach);
                    
                    var all_id=$('#attachid').val();
                    all_id=all_id+","+result.attach;
                    $('#attachid').val(all_id);
                            
                    if (result.html!==''){
                        if(ajax_vars.is_floor === '1'){
                            $('#no_plan_mess').remove();
                            $('#imagelist').append('<div class="uploaded_images floor_container" data-imageid="'+result.attach+'"><input type="hidden" name="plan_image_attach[]" value="'+result.attach+'"><input type="hidden" name="plan_image[]" value="'+result.html+'"><img src="'+result.html+'"  /><i class="deleter  far fa-trash-alt"></i>'+to_insert_floor+'</div>');
                    
                        }else{
                            $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+result.html+'"  /><i class="deleter far fa-trash-alt"></i><i class="fas fa-font image_caption_button"></i><div class="image_caption_wrapper"><input data-imageid="'+result.attach+'" type="text" class="image_caption form_control" name="image_caption" value=""></div>');
                        }
                        
                    }else{
                        $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+ajax_vars.path+'/img/pdf.png"  /><i class="deleter  far fa-trash-alt"></i> </div>');
                    
                    }
                    if(jQuery().sortable) {
                        $( "#imagelist" ).sortable({
                        revert: true,
                        update: function( event, ui ) {
                            var all_id,new_id;
                            all_id="";
                            $( "#imagelist .uploaded_images" ).each(function(){
                                
                                new_id = $(this).attr('data-imageid'); 
                                if (typeof new_id != 'undefined') {
                                    all_id=all_id+","+new_id; 
                                   
                                }
                               
                            });
                          
                            $('#attachid').val(all_id);
                        },
                    });
                    }
                       
                    wpestate_delete_binder();
                    wpestate_caption_setter();
                    wpestate_thumb_setter();
                   
                }else{
                    if (result.image){ 
                        $('#imagelist').before('<div id="image_warn" style="width:100%;float:left;">'+ajax_vars.warning+'</div>');
                        $('#imagelist-profile').before('<div id="image_warn" style="width:100%;float:left;">'+ajax_vars.warning+'</div>');
                        current_no_up=current_no_up-1;
                    }
                }
            });
            
            
            jQuery('#aaiu-uploader').on( 'click', function(e) {
                e.preventDefault();
                uploader.splice();
                uploader.refresh();
            });
     
            $('#aaiu-uploader2').on( 'click', function(e) {
                uploader.start();
                e.preventDefault();
            });
                  
            $('#aaiu-uploader-floor').on( 'click', function(e) {
                e.preventDefault();
                $('#aaiu-uploader').trigger('click');
            });      
            uploader.splice();
            uploader.refresh();
                     
 }
    uploader.splice();
    uploader.refresh();
 });


 
 
 
function wpestate_thumb_setter(){
    "use strict";
    jQuery('#imagelist img').dblclick(function(){
    
        jQuery('#imagelist .uploaded_images .thumber').each(function(){
            jQuery(this).remove();
        });

        jQuery(this).parent().append('<i class="fa thumber fa-star"></i>');
        jQuery('#attachthumb').val(   jQuery(this).parent().attr('data-imageid') );
    });   
 }
 
 

function wpestate_delete_binder(){      
    "use strict";
    jQuery('#imagelist i.fa-trash-alt').unbind('click');
    jQuery('#imagelist i.fa-trash-alt').on( 'click', function(event) {
        var curent='';
        var remove='';
        var img_remove= jQuery(this).parent().attr('data-imageid');
        var nonce = jQuery('#wpestate_image_upload').val();
        current_no_up=current_no_up-1;
                       
        jQuery(this).parent().remove();

        jQuery('#imagelist .uploaded_images').each(function(){
            remove  =   jQuery(this).attr('data-imageid');
            curent  =   curent+','+remove; 
         
        });
        jQuery('#attachid').val(curent); 
          
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_delete_file',
                'attach_id'         :   img_remove,
                'security'          :   nonce,
                
            },
            success: function (data) {     
            },
            error: function (errorThrown) {
            }
        });//end ajax     
      
    });
           
 }
 
 
 function wpestate_caption_setter(){
    "use strict";
    jQuery('.image_caption_button').unbind('click');
    jQuery('.image_caption_button').on( 'click', function(event) {
        jQuery(this).toggleClass('active_caption');
        jQuery(this).parent().find('.image_caption_wrapper').toggle();
    });
     
    jQuery('.image_caption').unbind('change');
    jQuery('.image_caption').on('change', function(){ 
        
        var img_caption= jQuery(this).attr('data-imageid');
        var caption = jQuery(this).val();
        var nonce = jQuery('#wpestate_image_upload').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_image_caption',
                'attach_id'         :   img_caption,
                'caption'           :   caption,
                'security'             :   nonce
                
            },
            success: function (data) {  
            
            },
            error: function (errorThrown) {  
            }
        });//end ajax     
      
    });
           
 }
 
 
to_insert_floor='<div class=""><p class="meta-options floor_p">\n\
                <label for="plan_title">'+control_vars.plan_title+'</label><br />\n\
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="" />\n\
            </p>\n\
            \n\
            <p class="meta-options floor_full"> \n\
                <label for="plan_description">'+control_vars.plan_desc+'</label><br /> \n\
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" ></textarea> \n\
            </p>\n\
             \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_size">'+control_vars.plan_size+'</label><br /> \n\
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="" /> \n\
            </p> \n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_rooms">'+control_vars.plan_rooms+'</label><br /> \n\
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_bath">'+control_vars.plan_bathrooms+'</label><br /> \n\
                <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_price">'+control_vars.plan_price+'</label><br /> \n\
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="" /> \n\
            </p> \n\
    </div>';