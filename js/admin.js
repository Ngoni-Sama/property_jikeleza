/*global $, jQuery, ajaxcalls_vars, document, control_vars, admin_js_vars,update_sortable_content,window*/
wpestate_set_theme_tab_visible2();
wpestate_set_theme_tab_visible();
jQuery(document).ready(function($) {
    "use strict";
    
     jQuery('.wpestate_notices .notice-dismiss').on('click',function(){
       
        var ajaxurl     = admin_js_vars.ajaxurl;
        var notice_type = $(this).parent().attr('data-notice-type');
        var nonce       = $('#wpestate_notice_nonce').val();
        
       
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'                    :   'wpestate_update_cache_notice',
                'notice_type'               :   notice_type,
                'security'                  :   nonce
            },
            success: function (data) {     

            
            },
            error: function (errorThrown) { 
              
            }
        });
    });
    
    $('#residence_generate_pins').on('click',function(event){
        event.preventDefault();
        $('#residence_generate_pins_mess').empty().text('We are gathering data. Please wait...');
        var  ajaxurl                   = admin_js_vars.ajaxurl;
        var nonce = jQuery('#wpestate_residence_generate_pins').val();
     
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action'            :   'wpresidence_generate_pins_redux',
                'security'          :   nonce,
             
            },
            success: function (data) {  
                 $('#residence_generate_pins_mess').empty().text('File is generated!');
            },
            error: function (errorThrown) {
               
            }
        });//end ajax      
    });
   
   
   
   
   
   
    jQuery('#add_feature2').on('click',function(event){
        event.preventDefault();
        var new_feature =jQuery('#new_feature').val();
        if (new_feature !== '') {
            //feature_list
           var  current_features    =  jQuery('#new_feature_all').val();
            if (current_features === '') {
                current_features    =   new_feature;
            } else {
                current_features    =   current_features + ',\n' + new_feature;
            }
           jQuery('#new_feature_all').val(current_features);
           jQuery('#new_feature').val('');
        }
    });
    
    jQuery('#add_status').on('click',function (event) {
        "use strict";
        event.preventDefault();
        var new_status = jQuery('#new_status').val();
        if (new_status !== '') {
            //status_list
            var current_status    =   jQuery('#status_list').val();

            if (current_status === '') {
                current_status    =   new_status;
            } else {
                current_status    =   current_status + ',\n' + new_status;
            }
            jQuery('#status_list').val(current_status);
            jQuery('#new_status').val('');
        }
    });
    

   jQuery('#add_field2').on('click',function(event){
        event.preventDefault();
        var newfield, field_name, field_label, field_order,drodown_values,field_type;
        newfield = '';
        field_name      =   jQuery('#field_name').val();
        field_label     =   jQuery('#field_label').val();
        field_type      =   jQuery('#field_type').val();
        field_order     =   parseInt(jQuery('#field_order').val(), 10);
        drodown_values  =   jQuery('#drodown_values').val();

        newfield =  '<div    class=field_row>';
        newfield += '<div    class=field_item><strong>Field Name</strong></br><input  type="text"   name="wpresidence_admin[wpestate_custom_fields_list][add_field_name][]"   value="' + field_name + '"  ></div>';
        newfield += '<div    class=field_item><strong>Field Label</strong></br><input  type="text"  name="wpresidence_admin[wpestate_custom_fields_list][add_field_label][]"  value="' + field_label + '"  ></div>';
        newfield += '<div    class=field_item><strong>Field Type</strong></br><input  type="text"   name="wpresidence_admin[wpestate_custom_fields_list][add_field_type][]"   value="' + field_type + '"   ></div>';
        newfield += '<div    class=field_item><strong>Field Order</strong></br><input  type="text"  name="wpresidence_admin[wpestate_custom_fields_list][add_field_order][]"  value="' + field_order + '"></div>';
        newfield += '<div    class=field_item><strong>Dropdwn Values</strong></br><textarea         name="wpresidence_admin[wpestate_custom_fields_list][add_dropdown_order][]">' + drodown_values + '</textarea></div>';
        newfield += '<a class="deletefieldlink" href="#">delete</a>';
        newfield += '</div>';

        jQuery('#custom_fields_wrapper').append(newfield);
        jQuery('#field_name').val('');
        jQuery('#field_label').val('');
        jQuery('#field_order').val('');
        jQuery('#drodown_values').val('');
    });
    
    jQuery('.deletefieldlink').on('click',function(event){
        event.preventDefault();
        parent_div = jQuery(this).parent();
        parent_div.remove();
    });



        $('#start_wprentals_setup').on( 'click', function() {
  
            $('#wpestate_start_wrapper').slideToggle();
        });

        $('.wpestate_start_wrapper_close').on( 'click', function() {
  
            $('#wpestate_start_wrapper').slideUp();
        }); 
            
        $('#button_start_notice').on( 'click', function() {
      
            $('#wpestate_start').slideUp();
            $('#wpestate_start_map').slideDown();
        });
        
        $('#button_map_set').on( 'click', function() {
      
            var ajaxurl, ssl_map_set, api_key;
            ssl_map_set     = jQuery('#ssl_map_set').val();
            api_key         = jQuery('#api_key').val();
            ajaxurl         = admin_js_vars.ajaxurl;
            var nonce = jQuery('#wpestate_setup_nonce').val();
 
            $.ajax({
                type:       'POST',
                url:        ajaxurl,
                data: {
                    'action'        :  'wpestate_ajax_start_map',
                    'ssl_map_set'   :  ssl_map_set, 
                    'api_key'       :  api_key,
                    'security'      :   nonce,
                },
                success: function (data) { 
                    $('#wpestate_start_map').hide();
                    $('#wpestate_general_settings').show();

                },
                error: function (errorThrown) {
                }
            });
        });
        
        $('#button_start_general_set').on( 'click', function() {
     
            var ajaxurl, general_country, measure_sys, currency_symbol,date_lang;
            general_country         = jQuery('#general_country').val();
            measure_sys             = jQuery('#measure_sys').val();
            currency_symbol         = jQuery('#currency_symbol').val();
            date_lang               = jQuery('#date_lang').val();
            ajaxurl                 = admin_js_vars.ajaxurl;
             var nonce = jQuery('#wpestate_setup_nonce').val();
             
            $.ajax({
                type:       'POST',
                url:        ajaxurl,
                data: {
                    'action'                 :  'wpestate_ajax_general_set',
                    'general_country'        :  general_country, 
                    'measure_sys'            :  measure_sys,
                    'currency_symbol'        :  currency_symbol,
                    'date_lang'              :  date_lang,
                    'security'               :  nonce,
                },
                success: function (data) {

                    $('#wpestate_general_settings').hide();
                    $('#wpestate_apperance_settings_quick').show();

                },
                error: function (errorThrown) {
                }
            });
        });
        
        
        $('#button_apperance_settings_set').on( 'click', function() {

            var ajaxurl,prop_unit, property_list_type_adv;
            prop_unit                 = jQuery('#prop_unit').val();
            property_list_type_adv    = jQuery('#property_list_type_adv').val();
            ajaxurl                   = admin_js_vars.ajaxurl;
            var nonce = jQuery('#wpestate_setup_nonce').val();
            $.ajax({
                type:       'POST',
                url:        ajaxurl,
                data: {
                    'action'                     :  'wpestate_ajax_apperance_set',
                    'property_list_type_adv'     :  property_list_type_adv, 
                    'prop_unit'                  :  prop_unit,
                    'security'                   :  nonce,
                },
                success: function (data) {

                    $('#wpestate_apperance_settings_quick').hide();
                    $('#wpestate_end').show();

                },
                error: function (errorThrown) {
                }
            });
        });
        
        
        $('#button_apperance_settings_prev').on( 'click', function() {

            $('#wpestate_apperance_settings_quick').slideUp();
            $('#wpestate_general_settings').slideDown();
        });
        
        $('#button_start_general_prev').on( 'click', function() {

            $('#wpestate_general_settings').slideUp();
            $('#wpestate_start_map').slideDown();
        });
        
        $('#button_map_prev').on( 'click', function() {

            $('#wpestate_start_map').slideUp();
            $('#wpestate_start').slideDown();
        });
        
            
    


        $('#wpestate_close_notice').on( 'click', function() {
            var nonce = jQuery('#wpestate_close_notice_nonce').val();
            var ajaxurl         = admin_js_vars.ajaxurl;
            $.ajax({
                type:       'POST',
                url:        ajaxurl,
                data: {
                    'action'        :  'wpestate_disable_licence_notifications',
                    'security'      :   nonce,
                },
                success: function (data) { 
                    jQuery('#license_check_wrapper').hide();
                },
                error: function (errorThrown) {
                }
            });
        });
            
            
            
            
            
        $('#check_ajax_license').on( 'click', function() {

            var ajaxurl= admin_js_vars.ajaxurl;
            var wpestate_license_key    = jQuery('#wpestate_license_key').val();
            var license_ajax_nonce      = jQuery('#license_ajax_nonce').val();
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'                    :   'wpestate_check_license_function',
                    'wpestate_license_key'      :   wpestate_license_key,
                    'security'                  :   license_ajax_nonce

                },
                success: function (data) {     
                
                    if(data==='ok'){
                        $('.license_check_wrapper').empty().text('Your copy of the theme is activated');
                    }else{
                        $('.notice_here').empty().text('The activation code is not correct!');
                    }

                },
                error: function (errorThrown) { 
               
                }
            });//end ajax   

        });
            
            
            
            
        $('#page_header_type').on('change', function(){

            var value=$(this).val();
            wpestate_show_heder_options(value);
               
        });
            
            
        function wpestate_show_heder_options(value){

            $('.header_admin_options').hide();

            if (value=='2'){
                $('.header_admin_options.image_header').show();
            }
            else if (value=='3'){
                $('.header_admin_options.theme_slider').show();
            }
            else if (value=='4'){
                $('.header_admin_options.revolution_slider').show();
            }
            else if (value=='5'){
                $('.header_admin_options.google_map').show();
            } 
            else if (value=='6'){
                $('.header_admin_options.video_header').show();
            }
        }
            
        $('#page_header_type').trigger('change');
            
        $('.attach_delete').on( 'click', function() {

            var curent,remove;
            var img_remove= jQuery(this).parent().attr('data-imageid');
            jQuery(this).parent().remove();

            jQuery('#property_uploaded_thumb_wrapepr .uploaded_thumb').each(function(){
                remove  =   jQuery(this).attr('data-imageid');
                curent  =   curent+','+remove; 

            });
            var nonce = jQuery('#wpestate_attach_delete').val();
            jQuery('#image_to_attach').val(curent); 
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            :   'wpestate_delete_file',
                    'attach_id'         :   img_remove,
                    'security'          :   nonce,
                    'isadmin'           :  1
                },
                success: function (data) {     
                },
                error: function (errorThrown) {  
                }
            });//end ajax   

        });
         
                
      
            
            
            
        $('#button_new_image').on( 'click', function(event) {

            event.stopPropagation();
            event.preventDefault();
            var  metaBox = $('#new_tabbed_interface');
            var imgContainer = metaBox.find( '.property_uploaded_thumb_wrapepr');

            var imgIdInput = metaBox.find( '#image_to_attach' ).val();
            var post_id=$(this).attr('data-postid');


            // Accepts an optional object hash to override default values.
            var frame = new wp.media.view.MediaFrame.Select({
                    // Modal title
                    title: 'Select Images',

                    // Enable/disable multiple select
                    multiple: true,

                    // Library WordPress query arguments.
                    library: {
                            order: 'DESC',
                            orderby: 'id',
                            type: 'image',
                    },

                    button: {
                            text: 'Set Image'
                    }
            });

            // Fires after the frame markup has been built, but not appended to the DOM.
            // @see wp.media.view.Modal.attach()
            frame.on( 'ready', function() { } );

            // Fires when the frame's $el is appended to its DOM container.
            // @see media.view.Modal.attach()
            frame.on( 'attach', function() {} );

            // Fires when the modal opens (becomes visible).
            // @see media.view.Modal.open()
            frame.on( 'open', function() {} );

            // Fires when the modal closes via the escape key.
            // @see media.view.Modal.close()
            frame.on( 'escape', function() {} );

            // Fires when the modal closes.
            // @see media.view.Modal.close()
            frame.on( 'close', function() {} );

            // Fires when a user has selected attachment(s) and clicked the select button.
            // @see media.view.MediaFrame.Post.mainInsertToolbar()
            frame.on( 'select', function() {
                    var attachment = frame.state().get('selection').toJSON();
                    var arrayLength = attachment.length;
                    for (var i = 0; i < arrayLength; i++) {
                        imgIdInput = metaBox.find( '#image_to_attach' ).val();
                        $( '#image_to_attach' ).val(imgIdInput+attachment[i].id+",")
                        imgContainer.append( '<div class="uploaded_thumb" data-imageid="'+attachment[i].id+'">\n\
                            <img src="'+attachment[i].sizes.thumbnail.url+'"  style="max-width:100%;"/>\n\
                            <a target="_blank" href="'+admin_js_vars.admin_url+'post.php?post='+attachment[i].id+'&action=edit" class="attach_edit"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a><a class="attach_delete"><i class="far fa-trash-alt" aria-hidden="true"></i></span></div>' );

                    }
            } );

            // Fires when a state activates.
            frame.on( 'activate', function() {} );

            // Fires when a mode is deactivated on a region.
            frame.on( '{region}:deactivate', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:deactivate:{mode}', function() {} );

            // Fires when a region is ready for its view to be created.
            frame.on( '{region}:create', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:create:{mode}', function() {} );

            // Fires when a region is ready for its view to be rendered.
            frame.on( '{region}:render', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:render:{mode}', function() {} );

            // Fires when a new mode is activated (after it has been rendered) on a region.
            frame.on( '{region}:activate', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:activate:{mode}', function() {} );

            // Get an object representing the current state.
            frame.state();


                // Get an object representing the previous state.
            frame.lastState();

                // Open the modal.
            frame.open();  
        });
        
        
        
        
        $('#button_new_image_video').on( 'click', function(event) {

            event.stopPropagation();
            event.preventDefault();
            var  metaBox = $('#new_tabbed_interface');
            var imgContainer = metaBox.find( '.property_uploaded_thumb_wrapepr');

            var imgIdInput = metaBox.find( '#image_to_attach' ).val();
            var post_id=$(this).attr('data-postid');


            // Accepts an optional object hash to override default values.
            var frame = new wp.media.view.MediaFrame.Select({
                    // Modal title
                    title: 'Select Images',

                    // Enable/disable multiple select
                    multiple: true,

                    // Library WordPress query arguments.
                    library: {
                            order: 'DESC',
                            orderby: 'id',
                            type: 'image',
                    },

                    button: {
                            text: 'Set Image'
                    }
            });

            // Fires after the frame markup has been built, but not appended to the DOM.
            // @see wp.media.view.Modal.attach()
            frame.on( 'ready', function() { } );

            // Fires when the frame's $el is appended to its DOM container.
            // @see media.view.Modal.attach()
            frame.on( 'attach', function() {} );

            // Fires when the modal opens (becomes visible).
            // @see media.view.Modal.open()
            frame.on( 'open', function() {} );

            // Fires when the modal closes via the escape key.
            // @see media.view.Modal.close()
            frame.on( 'escape', function() {} );

            // Fires when the modal closes.
            // @see media.view.Modal.close()
            frame.on( 'close', function() {} );

            // Fires when a user has selected attachment(s) and clicked the select button.
            // @see media.view.MediaFrame.Post.mainInsertToolbar()
            frame.on( 'select', function() {
                    var attachment = frame.state().get('selection').toJSON();
                    var arrayLength = attachment.length;
                    for (var i = 0; i < arrayLength; i++) {
                        imgIdInput = metaBox.find( '#image_to_attach' ).val();
                        $( '#image_to_attach' ).val(imgIdInput+attachment[i].id+",")
                        imgContainer.append( '<div class="uploaded_thumb" data-imageid="'+attachment[i].id+'">\n\
                            <img src="'+attachment[i].sizes.thumbnail.url+'"  style="max-width:100%;"/>\n\
                            <a target="_blank" href="'+admin_js_vars.admin_url+'post.php?post='+attachment[i].id+'&action=edit" class="attach_edit"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a><a class="attach_delete"><i class="far fa-trash-alt" aria-hidden="true"></i></span></div>' );

                    }
            } );

            // Fires when a state activates.
            frame.on( 'activate', function() {} );

            // Fires when a mode is deactivated on a region.
            frame.on( '{region}:deactivate', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:deactivate:{mode}', function() {} );

            // Fires when a region is ready for its view to be created.
            frame.on( '{region}:create', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:create:{mode}', function() {} );

            // Fires when a region is ready for its view to be rendered.
            frame.on( '{region}:render', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:render:{mode}', function() {} );

            // Fires when a new mode is activated (after it has been rendered) on a region.
            frame.on( '{region}:activate', function() {} );
            // and a more specific event including the mode.
            frame.on( '{region}:activate:{mode}', function() {} );

            // Get an object representing the current state.
            frame.state();


                // Get an object representing the previous state.
            frame.lastState();

                // Open the modal.
            frame.open();  
        });
        
        
        
        
        
        
        
    /*admin tabs*/
    $("#property_uploaded_thumb_wrapepr" ).sortable({
        revert: true,
        update: function( event, ui ) {
            var all_id,new_id;
            all_id="";
            $( "#property_uploaded_thumb_wrapepr .uploaded_thumb" ).each(function(){
                new_id = $(this).attr('data-imageid'); 
                if (typeof new_id != 'undefined') {
                    all_id=all_id+","+new_id; 
                }
            });
            $('#image_to_attach').val(all_id);
        },
    });

                    
                    
                    
    $('.property_tab_item').on( 'click', function() {
        var tab=$(this).attr('data-content');
        $('.property_tab_item').removeClass('active_tab');
        $('.property_tab_item_content ').removeClass('active_tab');
        $(this).addClass('active_tab');
        $('#'+tab).addClass('active_tab');       
    });
    
    
    estate_create_columns();
    wpestate_enable_unit_elements_actions();
    wpestate_elements_sortable();
    
    
    var picked_col;
    var picked_for_style;
    
    var custom_css_fields = [
            ['icon-image',      'texttip',      'icon-image'            ,''],
            ['custom-text',     'texttip',      'custom-text'           ,''],
            ['margin-right',    'numeric',      'margin-right'          ,'right'],
            ['margin-bottom',   'numeric',      'margin-bottom'         ,'bottom'],
            ['margin-top',      'numeric',      'margin-top'            ,'top'],
            ['margin-left',     'numeric',      'margin-left'           ,'left'],
            ['font-size',       'numeric',      'font-size'             ,''],
            ['font-color',      'texttip',      'color'                 ,''],
            ['back-color',      'texttip',      'background-color'      ,''],
            ['padding-top',     'numeric',      'padding-top'           ,''],
            ['padding-left',    'numeric',      'padding-left'          ,''],
            ['padding-bottom',  'numeric',      'padding-bottom'        ,''],
            ['padding-right',   'numeric',      'padding-right'         ,''],
            ['text-align',      'texttip',       'text-align'            ,''],
            ['extra_css',       'extra',        'extra_css'                      ,''],
    ];
    
    $('#save_custom_el_css').on( 'click', function() {

        var style               =   '';
        custom_css_fields.forEach (function(item, i){
            style= wpestate_custom_desing_set_attribute(picked_for_style,item[0],item[1],item[2],style,item[3]);
        });
        
        if( jQuery('#position-absolute').attr("checked")){
            picked_for_style.attr('data-position-absolute',1);
        }else{
            picked_for_style.attr('data-position-absolute',0);
        }
       
        picked_for_style.parent().removeAttr("data-fontsize").attr('data-fontsize',jQuery('#font-size').val() );
        picked_for_style.parent().removeAttr("data-mystyle").attr('data-mystyle',style);
        picked_for_style.parent().removeAttr("data-mystyle-class").attr('data-mystyle-class','unit_element_'+ Math.floor( (Math.random() * 100000) + 1) );
        
        
        $('#modal_el_options').hide();
        jQuery('#font-size').val('');
        jQuery('#margin-right').val('');
        jQuery('#margin-bottom').val('');
        jQuery('#margin-top').val('');
        jQuery('#margin-left').val('');
        jQuery('#position-absolute').removeAttr("checked");
       
    });
   
   
   
   
   
    
    function wpestate_custom_desing_set_attribute(picked_for_style,attr_name,attr_tip,attr_css,style,attr_css2){

        var new_name1='#'+attr_name;
        var attr_value = String( jQuery(new_name1).val() );

        if(attr_tip === 'numeric'){
            if( jQuery('#position-absolute').attr("checked") && ( attr_name==='margin-right' || attr_name==='margin-left' || attr_name==='margin-top' || attr_name==='margin-bottom' )  ){
                style=style+"position:absolute;";
                if( attr_value!=='' ){   
                    style=style+attr_css2+":"+attr_value+"px;";
                }
            }else{style=style;
                if( attr_value!=='' ){   
                    style=style+attr_css+":"+attr_value+"px;";
                }
            }

        } 

        if(attr_tip === 'texttip'){
            if(attr_name!=='icon-image' && attr_name!=='custom-text'){
                if( attr_value!=='' ){   
                    style=style+attr_css+":"+attr_value+";";
                }
            }
        }

        var new_name="data-"+attr_css;
        picked_for_style.removeAttr(new_name).attr(new_name,attr_value);


        if(attr_css==='icon-image' || attr_css==='custom-text' || attr_css==='font-size' || attr_css==='color' || attr_css==='text-align' || attr_css==='extra_css'){

            if(new_name==='data-custom-text'){
                attr_value=wpestate_replace_all_spaces(attr_value," ", "_"); 
            }

            picked_for_style.parent().removeAttr(new_name).attr(new_name,attr_value);
        }
        jQuery(new_name1).val('');
        return style;

    }        

   
        
    function wpestate_replace_all_spaces(target,search, replacement) {

        return target.replace(new RegExp(search, 'g'), replacement);
    }
        
        
  
        
    $('.prop_page_design_el_modal').on( 'click', function() {

        var tip, to_add;
        tip = $(this).attr('data-tip');
        to_add='<div class="design_element_col" data-tip="'+tip+'">'+tip+' <span class="custom_css_design"></span><span class="delete_element_design"></span></div>';
        picked_col.append(to_add);
        picked_col.parent().css('height','auto');
        $('#modal_el_pick').hide();
        wpestate_enable_unit_elements_actions();
    });  


    function wpestate_enable_unit_elements_actions(){

        jQuery('.custom_css_design').on( 'click', function(event) {
            event.stopPropagation();
            var acesta = $(this);
            custom_css_fields.forEach (function(item, i){
                var new_name1='#'+item[0];
                var new_name="data-"+item[2];
                jQuery(new_name1).val(    acesta.attr(new_name) ) ;        
            });

            if(  $(this).attr('data-position-absolute')==='1' ){
                jQuery('#position-absolute').attr("checked","checked");
            }

            var parent_tip=$(this).parent().attr('data-tip');
            jQuery('#custom-text-row,#icon-image-row').hide();

            if(parent_tip == 'featured_icon' ||  parent_tip == 'icon' || parent_tip == 'share' || parent_tip == 'compare'  || parent_tip=='link_to_page'){
                jQuery('#icon-image-row').show();
            }

            if(parent_tip == 'text' || parent_tip == 'featured_icon'  || parent_tip == 'share' || parent_tip == 'compare'  || parent_tip=='link_to_page'){
                jQuery('#custom-text-row').show();
            }

            if(parent_tip=='custom_div'){

                jQuery('.modal_el_options_content_element').hide();
                jQuery('#custom-text-row').find('label').text('css class');
                jQuery('#custom-text-row').show();
            }

            $('#modal_el_options').show();               
            picked_for_style=$(this);
        });


        jQuery('.design_element_col').on( 'click', function(event) {
            event.stopPropagation();

        });

        jQuery('.delete_element_design').unbind('click');
        jQuery('.delete_element_design').on( 'click', function(event) {
            event.stopPropagation();
            var parent = $(this).parent().remove();
        });
    }

     
    

    $('.add_me_new_row').on( 'click', function() {

        var parent,col_controls,to_append,to_append2;
        parent       =   $(this).parent().find('.property_page_content_wrapper');
        col_controls = '<div class="prop-col-control-wrapper"><div class="prop-col-control" data-separation="1/2+1/2">1/2</div>';
        col_controls += '<div class="prop-col-control" data-separation="1/3+1/3+1/3">1/3</div>';
        col_controls += '<div class="prop-col-control" data-separation="1/4+1/4+1/4+1/4">1/4</div>';
        col_controls += '</div>';

        to_append='<div class="prop-columns col-prop-12"><div class="add_prop_design_element">+</div></div><div class="delete_design_el" ></div>';
        to_append2='<div class="prop_full_width" >'+to_append+col_controls+'</div>';

        parent.append(to_append2);
        estate_create_columns();
    });


    
    
    
    
    function estate_create_columns(){

        // add elements
        $('.add_prop_design_element').unbind('click');
        $('.add_prop_design_element').on( 'click', function() {
            picked_col=$(this).parent();
            $('#modal_el_pick').show();
        });

        // separate into columns
        $('.prop-col-control').unbind('click');
        $('.prop-col-control').on( 'click', function() {
 
            var acesta          =   $(this);
            var parent          =   acesta.parent().parent();
            var separation_data =   $(this).attr('data-separation');
            var myArray         =   separation_data.split('+');
            var temp            =   '';
            var to_append       =   '';


            parent.find('.prop-columns').remove();
            for(var i=0;i<myArray.length;i++){
                temp = $.trim(myArray[i]);
                    if(temp!==''){
                        if(temp==='1/2'){
                            to_append='<div class="prop-columns col-prop-6 "><div class="add_prop_design_element">+</div></div>';
                        }else if(temp==='1/3'){
                            to_append='<div class="prop-columns col-prop-4 "><div class="add_prop_design_element">+</div></div>';
                        }else if(temp==='1/4'){
                            to_append='<div class="prop-columns col-prop-3"><div class="add_prop_design_element">+</div></div>';
                        }else if(temp==='2/3'){
                            to_append='<div class="prop-columns col-prop-8 "><div class="add_prop_design_element">+</div></div>';
                        }else if(temp==='2/4'){
                            to_append='<div class="prop-columns col-prop-6 "><div class="add_prop_design_element">+</div></div>';
                        }else if(temp==='3/4'){
                            to_append='<div class="prop-columns col-prop-9"><div class="add_prop_design_element">+</div></div>';
                        }else if(temp==='1/1'){
                            to_append='<div class="prop-columns col-prop-12"><div class="add_prop_design_element">+</div></div>';
                        }
                        parent.append(to_append);
                        estate_create_columns();
                    }
                }
            });  

            // delete row
            $(".delete_design_el").show().on( 'click', function() {
           
                var acest_del=$(this).parent().remove();
            });
    }

    /**/
    
    $('.property_page_content_wrapper').sortable({
        placeholder: 'block-placeholder',
        update: function (event, ui) {
            ui.item.addClass('block');
            estate_create_columns();
            update_sortable_content();
        }
    });


    function wpestate_elements_sortable(){

        $('.prop-columns').disableSelection();
        $('.prop-columns').sortable({
            items: 'div:not(.add_prop_design_element)',
            placeholder: 'block-placeholder',
                update: function (event, ui) {
                }
        });
    }


    $('#modal_el_pick_close,#modal_el_options_close').on( 'click', function() {

        $('#modal_el_pick').hide();
    });

    $('#modal_el_options_close').on( 'click', function() {
   
        $('#modal_el_options').hide();
    });

    
    
    
    
    $('#property_page_design_sidebar').on('change', function(event){ 
     
        event.preventDefault();
        var new_sidebar_value = $(this).val();

        if(new_sidebar_value==='1'){
            $('#property_page_content').removeClass('full_page');
            $('#property_page_sidebar_right').show();
            $('#property_page_sidebar_left').hide();


        } else if(new_sidebar_value==='2') {
            $('#property_page_sidebar_right').hide();
            $('#property_page_sidebar_left').show();
            $('#property_page_content').removeClass('full_page');


        }else{
            $('#property_page_sidebar_right').hide();
            $('#property_page_sidebar_left').hide();
            $('#property_page_content').addClass('full_page');

        }

    });

    

    // theme interface
 
    wpestate_theme_options_sidebar();
      
      
      
    $('.admin_top_bar_button').on( 'click', function(event) {
     
        event.preventDefault();
        var selected = $(this).attr('data-menu');
        var autoselect='';

        $('.admin_top_bar_button').removeClass('tobpbar_selected_option');
        $(this).addClass('tobpbar_selected_option');

        $('.theme_options_sidebar, .theme_options_wrapper_tab,.theme_options_tab').hide();
        $('#'+selected).show();
        $('#'+selected+'_tab').show();
        $('#'+selected+'_tab .theme_options_tab:eq(0)').show();


        localStorage.setItem('hidden_tab',selected);


        $('#'+selected+' li:eq(0)').addClass('selected_option');
        autoselect =  $('#'+selected+' li:eq(0)').attr('data-optiontab');

        localStorage.setItem('hidden_sidebar',autoselect);
        wpestate_theme_options_sidebar();
    });


   
    

    $('#wpestate_sidebar_menu li').on( 'click', function(event) {
     
        event.preventDefault();
        $('#wpestate_sidebar_menu li').removeClass('selected_option');
        $(this).addClass('selected_option');

        var selected = $(this).attr('data-optiontab');

        $('.theme_options_tab').hide();
        $('#'+selected).show();
        $('#hidden_sidebar').val(selected);


        localStorage.setItem('hidden_sidebar',selected);
        wpestate_theme_options_sidebar();

    });
     
     
    $( '.wpestate-megamenu-background-image' ).css( 'display', 'block' );
    $( ".wpestate-megamenu-background-image[src='']" ).css( 'display', 'none' );
    
    $('.edit-menu-item-wpestate-megamenu-check').on( 'click', function() {
      
        var parent_li_item = $( this ).parents( '.menu-item:eq( 0 )' );

        if( $( this ).is( ':checked' ) ) {
                parent_li_item.addClass( 'wpestate-megamenu' );
        } else 	{
                parent_li_item.removeClass( 'wpestate-megamenu' );
        }
        wpestate_update_megamenu_fields();
    });
    
    
    $('.load_back_menu').on( 'click', function() {

        var parent = $(this).parent().parent();
        var item_id = this.id.replace('wpestate-media-upload-', '');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        var formfield  = parent.find('#category_featured_image').attr('name');
        
        window.send_to_editor = function (html) {
            var   imgurl = $('img', html).attr('src');
            parent.find('#edit-menu-item-megamenu-background-'+item_id).val(imgurl);
            parent.find( '#wpestate-media-img-'+item_id ).attr( 'src', imgurl ).css( 'display', 'block' );
            var theid = $('img', html).attr('class');
            var thenum = theid.match(/\d+$/)[0];
            parent.find('#category_attach_id').val(thenum);
            tb_remove();
        };
        return false;
        
        
                              
    });

    
    $('.remove-megamenu-background').on( 'click', function() {
  
        var  item_id = this.id.replace( 'wpestate-media-remove-', '' );
        $( '#edit-menu-item-megamenu-background-'+item_id ).val( '' );
        $( '#wpestate-media-img-'+item_id ).attr( 'src', '' ).css( 'display', 'none' );
    });
    
    
    
    function wpestate_update_megamenu_fields() {

        var menu_li_items = $( '.menu-item');

        menu_li_items.each( function( i ) 	{

                var megamenu_status = $( '.edit-menu-item-wpestate-megamenu-check', this );

                if( ! $( this ).is( '.menu-item-depth-0' ) ) {
                        var check_against = menu_li_items.filter( ':eq(' + (i-1) + ')' );


                        if( check_against.is( '.wpestate-megamenu' ) ) {

                                megamenu_status.attr( 'checked', 'checked' );
                                $( this ).addClass( 'wpestate-megamenu' );
                        } else {
                                megamenu_status.attr( 'checked', '' );
                                $( this ).removeClass( 'wpestate-megamenu' );
                        }
                } else {
                        if( megamenu_status.attr( 'checked' ) ) {
                                $( this ).addClass( 'wpestate-megamenu' );
                        }
                }
        });
    }
    
    
    
    
    $('.category_featured_image_button').on( 'click', function() {
        var parent = $(this).parent();
        var formfield  = parent.find('#category_featured_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var imgurl = $('img', html).attr('src');
            parent.find('#category_featured_image').val(imgurl);
            var theid = $('img', html).attr('class');
            var thenum = theid.match(/\d+$/)[0];
            parent.find('#category_attach_id').val(thenum);
            tb_remove();
        };
        return false;
    });
  
    $('#new_membership').on( 'click', function() {
   
        var new_row=$('#sample_member_row').html();
        new_row='<div class="memebership_row">'+new_row+'</div>';
        $('#new_membership').before(new_row); 
        
    });
        
    
    
    $('.remove_pack').on( 'click', function() {     

        $(this).parent().remove();
    });
    
   $('.pin-upload').on( 'click', function() {

        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        var formfield=$(this).prev();
        window.send_to_editor = function(html) {
            var imgurl = $('img',html).attr('src');
            formfield.val(imgurl);
            tb_remove();
		};
           
    return false;
    });
     

    $('#global_header_button').on( 'click', function() {
    
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

        window.send_to_editor = function(html) {
            var imgurl = $('img',html).attr('src');
            $('#global_header').val(imgurl);
            tb_remove();
        };

        return false;
    });


    $('#footer_background_button').on( 'click', function() {
  
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

    window.send_to_editor = function(html) {
              var imgurl = $('img',html).attr('src');
              $('#footer_background').val(imgurl);
              tb_remove();
    };

    return false;
    });


    $('#logo_image_button').on( 'click', function() {
 
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

        window.send_to_editor = function(html) {
            var imgurl = $('img',html).attr('src');
            $('#logo_image').val(imgurl);
            tb_remove();
        };

        return false;
    });

    $('#stikcy_logo_image_button').on( 'click', function() {

        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

        window.send_to_editor = function(html) {
            var imgurl = $('img',html).attr('src');
            $('#stikcy_logo_image').val(imgurl);
            tb_remove();
        };

     return false;
    });
    
    
    $('#transparent_logo_image_button').on( 'click', function() {

        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

        window.send_to_editor = function(html) {
            var imgurl = $('img',html).attr('src');
            $('#transparent_logo_image').val(imgurl);
            tb_remove();
        };

        return false;
    });


    $('#mobile_logo_image_button').on( 'click', function() {

        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

        window.send_to_editor = function(html) {
            var imgurl = $('img',html).attr('src');
            $('#mobile_logo_image').val(imgurl);
            tb_remove();
        };

        return false;
    });


    $('#favicon_image_button').on( 'click', function() {
  
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function(html) {
               var  imgurl = $('img',html).attr('src');
                $('#favicon_image').val(imgurl);
                tb_remove();
        };
        return false;
    });


    $('#company_contact_image_button').on( 'click', function() {

        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function(html) {
            var imgurl = $('img',html).attr('src');
            $('#company_contact_image').val(imgurl);
            tb_remove();
        };
        return false;
    });


    $('#background_image_button').on( 'click', function() {

        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');	

        window.send_to_editor = function(html) {
                var imgurl = $('img',html).attr('src');
                $('#background_image').val(imgurl);
                tb_remove();
        };
        return false;
    });


    function wpestate_getUrlVars(){

        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }




	
    if ($(".admin_menu_list")[0]){	//if is our custom admin page
        // admin tab controls
        var fullUrl=wpestate_getUrlVars()["page"];
        var tab=(fullUrl.split("#"));
        var pick=tab[1];

        if(typeof tab[1] === 'undefined'){
            pick="tab1";
        }

        $(".tabadmin").each(function(){		
            if ($(this).attr("data-tab")==pick){
                $(this).addClass("active");
            }else{
                $(this).removeClass("active");
            }	
        });

        $(".admin_menu_list li").each(function(){		
            if ($(this).attr("rel")==pick){
                $(this).addClass("active");
            }else{
                $(this).removeClass("active")
            }	
        });    
    
    }	
 


    //admin color changes
    var my_colors = ['second_color','active_menu_font_color','splash_overlay_color','page_header_overlay_color_video','page_header_overlay_color','main_color','background_color','content_back_color','header_color','breadcrumbs_back_color','menu_items_color','breadcrumbs_font_color','font_color','link_color','headings_color','comments_font_color','coment_back_color','footer_back_color','footer_font_color','footer_copy_color','footer_copy_back_color','sidebar_widget_color','sidebar_heading_boxed_color','sidebar_heading_color','sidebar2_font_color','menu_font_color','menu_hover_back_color','menu_hover_font_color','agent_color','listings_color','blog_color','dotted_line','footer_top_band','top_bar_back','top_bar_font','adv_search_back_color','adv_search_font_color','box_content_back_color','box_content_border_color','hover_button_color','content_area_back_color','border_bottom_header_sticky_color','property_unit_color','border_bottom_header_color','unit_border_color','widget_sidebar_border_color','top_menu_hover_font_color','sticky_menu_font_color','menu_item_back_color','top_menu_hover_back_font_color','transparent_menu_font_color','transparent_menu_hover_font_color','map_controls_back','map_controls_font_color','sidebar_heading_background_color','sidebar_boxed_font_color','adv_back_color','adv_font_color','menu_border_color','user_dashboard_menu_color','user_dashboard_menu_hover_color','user_dashboard_menu_color_hover','user_dashboard_menu_back','user_dashboard_package_back','user_dashboard_package_color','user_dashboard_package_select','user_dashboard_buy_package','user_dashboard_content_back','user_dashboard_content_button_back','user_dashboard_content_color','mobile_header_background_color','mobile_header_icon_color','mobile_menu_font_color','mobile_item_hover_back_color','mobile_menu_backgound_color','mobile_menu_border_color','mobile_menu_hover_font_color'];
    for(let i=0, size=my_colors.length; i<size; i++){
    
        $('#' + my_colors[i] ).ColorPicker({ 
            onChange: function (hsb, hex, rgb) {
                $('#' + my_colors[i] + ' .sqcolor').css('background-color', '#' + hex);
                $('[name=' + my_colors[i] + ']' ).val( hex );
            }
        });	
    }

});



function wpestate_theme_options_sidebar(){

    var new_height;
    new_height = jQuery ('#wpestate_wrapper_admin_menu').height();
    jQuery ('#wpestate_sidebar_menu').height(new_height);
    
}


function  wpestate_set_theme_tab_visible2(){

    var current_url=window.location.href;
    var page_par=wpestate_findGetParameter('subpage');
    
    if(page_par==='logos_favicon_tab'){
        localStorage.setItem('hidden_tab','general_settings_sidebar');
        localStorage.setItem('hidden_sidebar','logos_favicon_tab');
    } 
  
    if(page_par==='custom_colors_tab'){
        localStorage.setItem('hidden_tab','design_settings_sidebar');
        localStorage.setItem('hidden_sidebar','custom_colors_tab');
    }
    
    if(page_par==='membership_settings_tab'){
        localStorage.setItem('hidden_tab','membership_settings_sidebar');
        localStorage.setItem('hidden_sidebar','membership_settings_tab');
    }
        
}

function wpestate_set_theme_tab_visible(){
 
    var show_tab        =   localStorage.getItem('hidden_tab');
    var show_sidebar    =   localStorage.getItem('hidden_sidebar');
    if(show_tab===null || show_tab===''){
        show_tab = 'general_settings_sidebar';
    }
    
    if(show_sidebar=== null || show_sidebar==''){
        show_sidebar = 'global_settings_tab';
    }
    
    if(show_tab!=='none'){    
        jQuery('.theme_options_sidebar, .theme_options_wrapper_tab').hide();
        jQuery('#'+show_tab).show();
        jQuery('#'+show_tab+'_tab').show();
        jQuery('.wrap-topbar div').removeClass('tobpbar_selected_option');
        jQuery('.wrap-topbar div[data-menu="'+show_tab+'"]').addClass('tobpbar_selected_option');
    }

    if(show_sidebar!=='none'){     
        jQuery('.theme_options_tab').hide();
        jQuery('#'+show_sidebar).show();
        jQuery('#wpestate_sidebar_menu li').removeClass('selected_option');
        jQuery('#wpestate_sidebar_menu li[data-optiontab="'+show_sidebar+'"]').addClass('selected_option');
        
    }
}




function wpestate_findGetParameter(parameterName) {
 
    var result = null,tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}