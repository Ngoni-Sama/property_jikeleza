/*global $, jQuery, document, window */

jQuery(document).ready(function ($) {
  
    
 
   
     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase lsitings
    ///////////////////////////////////////////////////////////////////////////////
    $('#save_prop_design').on( 'click', function(event) {
  
        var acesta,content,sidebar_right,sidebar_left,content_to_parse,use_unit;
        
        use_unit =0;
        if( $('#wpresidence_admin_wpestate_uset_unit').is(":checked") ){
            use_unit = 1;
        }
        content = $('#property_page_content .property_page_content_wrapper').html();
        var nonce=$('#wpestate_save_prop_design').val();
      
      
        acesta=$(this);
        acesta.empty().text('saving....');
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
            data: {
                'action'        :   'wpestate_save_property_page_design',
                'content'       :   content,
                'use_unit'      :   use_unit,
                'security'      :   nonce,
            },
            success: function (data) {
                acesta.empty().text('saved....');
            },
            error: function (errorThrown) {
               
            }
        });//end ajax  
        
        
    })
    
    
    
    $('#activate_pack_listing').on( 'click', function(event) {
        var item_id, invoice_id,ajaxurl,type;
        
        item_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        type        = $(this).attr('data-type');
        ajaxurl     =   admin_control_vars.ajaxurl;
        
        var nonce = jQuery('#wpestate_activate_pack_listing').val();
    
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        :   'wpestate_activate_purchase_listing',
                'item_id'       :   item_id,
                'invoice_id'    :   invoice_id,
                'type'          :   type,
                'security'      :   nonce,
           
        },
        success: function (data) {  
            jQuery("#activate_pack_listing").remove();
            jQuery("#invnotpaid").remove(); 
          
           
        },
        error: function (errorThrown) {}
    });//end ajax  
        
    });
    
     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase
    ///////////////////////////////////////////////////////////////////////////////
    
     $('#activate_pack').on( 'click', function(event) {
        var item_id, invoice_id,ajaxurl;
        
        item_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        ajaxurl     =   admin_control_vars.ajaxurl;
        var nonce = jQuery('#wpestate_activate_pack').val();
    
      
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_activate_purchase',
            'item_id'       :   item_id,
            'invoice_id'    :   invoice_id,
            'security'      :   nonce
           
        },
        success: function (data) {   
            jQuery("#activate_pack").remove();
            jQuery("#invnotpaid").remove(); 
           
        },
        error: function (errorThrown) {}
    });//end ajax  
        
    });

 
    
    
    
  
    ///////////////////////////////////////////////////////////////////////////////
    /// upload custom image on page - jslint checked
    ///////////////////////////////////////////////////////////////////////////////
    
    
   
    
    var formfield, imgurl;
    $('#splash_video_mp4_button').on( 'click', function(event) {
     
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#splash_video_mp4').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
    
      
    $('#splash_video_webm_button').on( 'click', function(event) {
       
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#splash_video_webm').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
    
      
    $('#splash_video_ogv_button').on( 'click', function(event) {
    
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#splash_video_ogv').val(mediaUrl);
            tb_remove();
        };
        return false;
    });



    $('#splash_video_cover_img_button').on( 'click', function(event) {
     
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#splash_video_cover_img').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    

    $('#splash_image_button').on( 'click', function(event) {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#splash_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
     $('#wp_estate_splash_overlay_image_button').on( 'click', function(event) {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#wp_estate_splash_overlay_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    
    $('#page_custom_image_button').on( 'click', function(event) {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#page_custom_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    $('#page_custom_video_cover_image_button').on( 'click', function(event) {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#page_custom_video_cover_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    
    
    $('#page_custom_video_button').on( 'click', function(event) {
        formfield = $('#page_custom_video').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
          
            if(mediaUrl===''){
               mediaUrl = jQuery(html).attr("href");
            }
            jQuery('#page_custom_video').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
     
    $('#property_custom_video_button').on( 'click', function(event) {
        formfield = $('#property_custom_video').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
          
            if(mediaUrl===''){
               mediaUrl = jQuery(html).attr("href");
            }
            jQuery('#property_custom_video').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
    
    
    
     $('#page_custom_video_webbm_button').on( 'click', function(event) {
     
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#page_custom_video_webbm').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
     $('#page_custom_video_ogv_button').on( 'click', function(event) {
       
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#page_custom_video_ogv').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
    
    $('.deleter_floor').on( 'click', function(event) {
       $(this).parent().remove();
    });
   
    jQuery(".floorbuttons").on( 'click', function(event) {
        var parent = jQuery(this).parent();
        formfield  = parent.find("#plan_image").attr("name");
        tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
        window.send_to_editor = function (html) {

            imgurl = jQuery("img", html).attr("src");
            var theid = jQuery("img", html).attr("class");

            var thenum = theid.match(/\d+$/)[0];

            parent.find("#plan_image").val(imgurl);
            parent.find("#plan_image_attach").val(thenum);
            tb_remove();
        };
        return false;
    });
    
    $('#add_new_plan').on( 'click', function(event) {
        var to_insert;
      
        to_insert='<div class="plan_row"><p class="meta-options floor_p">\n\
                <label for="plan_title">'+admin_control_vars.plan_title+'</label><br />\n\
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="" />\n\
            </p>\n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_description">'+admin_control_vars.plan_desc+'</label><br /> \n\
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" ></textarea> \n\
            </p>\n\
             \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_size">'+admin_control_vars.plan_size+'</label><br /> \n\
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="" /> \n\
            </p> \n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_rooms">'+admin_control_vars.plan_rooms+'</label><br /> \n\
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_bath">'+admin_control_vars.plan_bathrooms+'</label><br /> \n\
                <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_price">'+admin_control_vars.plan_price+'</label><br /> \n\
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="" /> \n\
            </p> \n\
            \n\<p class="meta-options floor_p image_plan"> \n\
                <label for="plan_image">'+admin_control_vars.plan_image+'</label><br /> \n\
                <input id="plan_image" type="text" size="36" name="plan_image[]" value="" /> \n\
                <input id="plan_image_button" type="button"   size="40" class="upload_button button floorbuttons" value="Upload Image" /> \n\
                <input type="hidden" id="plan_image_attach" name="plan_image_attach[]" value="">\n\
            </p> \n\
    </div>';
        
        $('#plan_wrapper').append(to_insert);
        
        $('.floorbuttons').unbind('click');
        
        
        
        $('.floorbuttons').on( 'click', function(event) {
            var parent = $(this).parent();
            formfield  = parent.find('#plan_image').attr('name');
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            window.send_to_editor = function (html) {
                
               imgurl = $('img', html).attr('src');
               var theid = $('img', html).attr('class');
               var thenum = theid.match(/\d+$/)[0];
       
                parent.find('#plan_image').val(imgurl);
                parent.find('#plan_image_attach').val(thenum);
                tb_remove();
            };
            return false;
        });
        
        //alert('plan'); 
    });
	
	
	// agent custom parameters processing

	$('body').on('click', '.add_custom_parameter', function(){
		var cloned = $('.cliche_row').clone();
		cloned.removeClass('cliche_row');
		
		
		$('input', cloned).val();
		$('.add_custom_data_cont').append( cloned );
	})	
	$('body').on('click', '.remove_parameter_button', function(){
		var pnt = $(this).parents( '.single_parameter_row' );
		pnt.fadeOut(500, function(){
			pnt.replaceWith('');
		})
		
	})

	// agent custom parameters processing END
    
});
