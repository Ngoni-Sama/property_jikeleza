/*global  jQuery, document ,control_vars,dashboard_vars*/

jQuery(document).ready(function ($) {
    "use strict";
    $('.mess_send_reply_button').on( 'click', function(event) {
    
        var messid, ajaxurl, acesta, parent, title, content, container, mesage_container;
        ajaxurl    =   control_vars.admin_url + 'admin-ajax.php';
        parent     =   $(this).parent().parent();
        mesage_container = parent.find('.mess_content');
        container  =   $(this).parent();
        messid     =   parent.attr('data-messid');
        acesta     =   $(this);
        title      =   parent.find('.subject_reply').val();
        content    =   parent.find('.message_reply_content').val();
        parent.find('.mess_unread').remove();
        acesta.text(dashboard_vars.sending);
        var nonce = jQuery('#wpestate_inbox_actions').val();
         
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_message_reply',
                'messid'            :   messid,
                'title'             :   title,
                'content'           :   content,
                'security'          :   nonce
            },
            success: function (data) {
                mesage_container.hide();
                container.hide();
            },
            error: function (errorThrown) {
           
            }
        });
    });
    
    
    $('.message_header').on( 'click', function() {
     
        var messid, ajaxurl, acesta, parent;
        ajaxurl =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent();
        messid  =   parent.attr('data-messid');
        acesta  =   $(this);
        $('.mess_content, .mess_reply_form').hide();
        $(this).parent().find('.mess_content').show();
        var nonce = jQuery('#wpestate_inbox_actions').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_booking_mark_as_read',
                'messid'            :   messid,
                'security'          :   nonce
            },
            success: function (data) {
                parent.find('.mess_unread').remove();
            },
            error: function (errorThrown) {
            }
        });
    });
    
    
     $('.mess_reply').on( 'click', function(event) {
  
        var messid, ajaxurl, acesta, parent;
        event.stopPropagation();
        ajaxurl =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent().parent().parent();
        messid  =   parent.attr('data-messid');
        acesta  =   $(this);
        $('.mess_content, .mess_reply_form').hide();
        parent.find('.mess_content').show();
        parent.find('.mess_reply_form').show();
        var nonce = jQuery('#wpestate_inbox_actions').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_booking_mark_as_read',
                'messid'            :   messid,
                 'security'          :   nonce
            },
            success: function (data) {
                parent.find('.mess_unread').remove();
            },
            error: function (errorThrown) {
            }
        });
    });
    
    
    $('.mess_send_reply_button2').on( 'click', function(event) {

        var messid, ajaxurl, acesta, parent;
        event.stopPropagation();
        ajaxurl =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent().parent().parent();
        acesta  =   $(this);
        $('.mess_content, .mess_reply_form').hide();
        parent.find('.mess_content').show();
        parent.find('.mess_reply_form').show();   
    });
    
    
    $('.mess_delete').on( 'click', function(event) {
 
        var messid, ajaxurl, acesta, parent;
        event.stopPropagation();
        ajaxurl =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent().parent().parent().parent();
        messid  =   parent.attr('data-messid');
        acesta  =   $(this);
     
        $(this).parent().parent().empty().addClass('delete_inaction').html(dashboard_vars.deleting);
        var nonce = jQuery('#wpestate_inbox_actions').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_booking_delete_mess',
                'messid'            :   messid,
                'security'          :   nonce
            },
            success: function (data) {
                parent.parent().remove();
                $('.mess_content, .mess_reply_form').hide();
            },
            error: function (errorThrown) {

            }
        });
    });
    
    
     jQuery('.woo_pay').on('click',function () {
        var pay_paypal, prop_id, book_id, invoice_id, is_featured, is_upgrade,ajaxurl,depozit,is_submit;
        prop_id     =   jQuery(this).attr('data-propid');
        book_id     =   jQuery(this).attr('data-bookid');
        invoice_id  =   jQuery(this).attr('data-invoiceid');
        depozit     =   jQuery(this).attr('data-deposit');
        is_featured =   0;
        is_upgrade  =   0;
        is_submit   =   0;
        
        if(jQuery(this).hasClass('woo_pay_submit')){
            is_submit=1;
        }
        ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
         jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'        :   'wpestate_woo_pay',
                    'invoiceid'     :   invoice_id,
                    'propid'        :   prop_id,
                    'book_id'       :   book_id,
                    'depozit'       :   depozit,
                    'is_submit'     :   is_submit
//                    'price_pack'    :   price_pack,
//                    'security'      :   nonce,
                },
                success: function (data) {
                    if(data!==false){
                     window.location.href= dashboard_vars.checkout_url;
                    }
                },
                error: function (errorThrown) {}
            });//end ajax  
    });
    
    
     
    jQuery('#wpestate_stripe_booking').on('click',function(){
        var modalid=jQuery(this).attr('data-modalid');
         
        jQuery('#'+modalid).show();
        jQuery('#'+modalid+' .wpestate_stripe_form_1').show();
           
        wpestate_start_stripe(0,modalid);
    });
    
    
    jQuery('.close_stripe_form').on('click',function(){
        jQuery('.wpestate_stripe_form_wrapper').hide();
        jQuery('.wpestate_stripe_form_1').hide();
    });
    
    
});