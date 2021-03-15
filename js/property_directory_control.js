var sliderTimerScroll;
var sliderAjaxDelayScroll =400;
var with_clear=1;



function wpestate_increase_pagination(){
    var page = parseInt( jQuery('#property_dir_pagination').val() );
    page    =   page+1;
    jQuery('#property_dir_pagination').val(page);            
    wpestate_directory_filtering();
}



jQuery(document).ready(function(){
  
    
    jQuery('#directory_load_more').on( 'click', function(event) {
        var is_done = parseInt (jQuery('#property_dir_done').val()) ;

        if(is_done === 0){
            with_clear=0;
            wpestate_increase_pagination();
        }else{

        }
    });
    
    
 
    jQuery( "#slider_price_widget" ).slider({
        change: function( event, ui ) {
             wpestate_directory_filtering();
        }
    });
  

    jQuery("#slider_property_size_widget").slider({
        range: true,
        min: parseFloat( directory_vars.dir_min_size),
        max: parseFloat( directory_vars.dir_max_size),
        values: [directory_vars.dir_min_size, directory_vars.dir_max_size ],
        slide: function (event, ui) {
            jQuery("#property_size_low" ).val(ui.values[0]);
            jQuery("#property_size_max").val(ui.values[1]);
          
          

            jQuery("#property_size").html(  ui.values[0] +" "+directory_vars.measures_sys+ " "+control_vars.to+" " + ui.values[1]+" "+directory_vars.measures_sys);
            wpestate_directory_filtering();
        }
    });

    jQuery("#slider_property_lot_size_widget").slider({
        range: true,
        min:   parseFloat( directory_vars.dir_min_lot_size),
        max:   parseFloat( directory_vars.dir_max_lot_size),
        values: [ directory_vars.dir_min_lot_size,  directory_vars.dir_max_lot_size ],
        slide: function (event, ui) {
            jQuery("#property_lot_size_low" ).val(ui.values[0]);
            jQuery("#property_lot_size_max").val(ui.values[1]);
            jQuery("#property_lot_size").html(  ui.values[0]+" "+directory_vars.measures_sys+ " "+control_vars.to+" " + ui.values[1] +" "+ directory_vars.measures_sys);
            wpestate_directory_filtering();
        }
    });


    jQuery("#slider_property_rooms_widget").slider({
        range: true,
        min:  parseFloat( directory_vars.dir_rooms_min),
        max:  parseFloat( directory_vars.dir_rooms_max),
        values: [directory_vars.dir_rooms_min, directory_vars.dir_rooms_max ],
        slide: function (event, ui) {
            jQuery("#property_rooms_low" ).val(ui.values[0]);
            jQuery("#property_rooms_max").val(ui.values[1]);
            jQuery("#property_rooms").text(  ui.values[0] + " "+control_vars.to+" " + ui.values[1] );
            wpestate_directory_filtering();
        }
    });


    jQuery("#slider_property_bedrooms_widget").slider({
        range: true,
        min:  parseFloat( directory_vars.dir_bedrooms_min),
        max:  parseFloat( directory_vars.dir_bedrooms_max),
        values: [directory_vars.dir_bedrooms_min, directory_vars.dir_bedrooms_max ],
        slide: function (event, ui) {
            jQuery("#property_bedrooms_low" ).val(ui.values[0]);
            jQuery("#property_bedrooms_max").val(ui.values[1]);
            jQuery("#property_bedrooms").text(  ui.values[0] + " "+control_vars.to+" " + ui.values[1] );
            wpestate_directory_filtering();
        }
    });


    jQuery("#slider_property_bathrooms_widget").slider({
        range: true,
        min:  parseFloat( directory_vars.dir_bedrooms_min),
        max:  parseFloat( directory_vars.dir_bedrooms_max),
        values: [directory_vars.dir_bedrooms_min, directory_vars.dir_bedrooms_max ],
        slide: function (event, ui) {
            jQuery("#property_bathrooms_low" ).val(ui.values[0]);
            jQuery("#property_bathrooms_max").val(ui.values[1]);
            jQuery("#property_bathrooms").text(  ui.values[0] + " "+control_vars.to+" " + ui.values[1] );
            wpestate_directory_filtering();
        }
    });
//    
    
    jQuery('.extended_search_check_wrapper_directory input[type="checkbox"]').on( 'click', function(event) {
        wpestate_directory_filtering();
    });


    jQuery('.listing_filters_head_directory li').on( 'click', function(event) {
        var pick, value, parent;

        pick = jQuery(this).text();
        value = jQuery(this).attr('data-value');
        parent = jQuery(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value',value);
        parent.find('input:hidden'). val(value);
        wpestate_directory_filtering(); 
    });
    
    jQuery('.directory_sidebar  li').on( 'click', function(event) {
        wpestate_directory_filtering();
    });

    jQuery('#property_status,#property_keyword').on('change', function(){ 
        wpestate_directory_filtering();
    });

});
var sliderTimer;
var    sliderAjaxDelay =500;


function wpestate_directory_filtering(){   
    if (sliderTimer) {
        clearTimeout(sliderTimer); /* if already a timeout, clear it */
    }
    sliderTimer = setTimeout(wpestate_directory_filtering_action, sliderAjaxDelay);
}

function wpestate_directory_filtering_action(){
    with_clear=parseInt(with_clear);
    
    if(parseInt(with_clear)==1){
        jQuery('#property_dir_pagination').val('1');
        jQuery('#property_dir_done').val('0');
        jQuery('#directory_load_more').removeClass('no_more_list')
    }
    
    var ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    
   // jQuery('#gmap-loading').show();
    var postid          =   parseFloat(jQuery('#adv-search-1').attr('data-postid'), 10);
    var action          =   jQuery('#sidebar-adv_actions').attr('data-value');
    var category        =   jQuery('#sidebar-adv_categ').attr('data-value');
    var city            =   jQuery('#sidebar-advanced_city').attr('data-value');
    var area            =   jQuery('#sidebar-advanced_area').attr('data-value');
    var county          =   jQuery('#sidebar-advanced_county').attr('data-value');
    var min_price       =   parseFloat(jQuery('#price_low_widget').val(), 10);
    var price_max       =   parseFloat(jQuery('#price_max_widget').val(), 10);
    var min_size        =   parseFloat(jQuery('#property_size_low').val(), 10);
    var max_size        =   parseFloat(jQuery('#property_size_max').val(), 10);
    var min_lot_size    =   parseFloat(jQuery('#property_lot_size_low').val(), 10);
    var max_lot_size    =   parseFloat(jQuery('#property_lot_size_max').val(), 10);
    var min_rooms       =   parseFloat(jQuery('#property_rooms_low').val(), 10);
    var max_rooms       =   parseFloat(jQuery('#property_rooms_max').val(), 10);
    var min_bedrooms    =   parseFloat(jQuery('#property_bedrooms_low').val(), 10);
    var max_bedrooms    =   parseFloat(jQuery('#property_bedrooms_max').val(), 10);
    var min_bathrooms   =   parseFloat(jQuery('#property_bathrooms_low').val(), 10);
    var max_bathrooms   =   parseFloat(jQuery('#property_bathrooms_max').val(), 10);
    var status          =   jQuery('#property_status').val();
    var keyword         =   jQuery('#property_keyword').val();
    var order           =   jQuery('#a_filter_order_directory').attr('data-value');
    var pagination      =   jQuery('#property_dir_pagination').val();

    
    var all_checkers = '';
    jQuery('.extended_search_check_wrapper_directory  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
        }
    });

    if(parseInt(with_clear)==1){
        jQuery('#listing_ajax_container').empty();
       
    }
    jQuery('.pagination_nojax').hide();
    jQuery('#listing_loader').show();
    
     var nonce = jQuery('#wpestate_ajax_filtering').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_classic_ondemand_directory',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'county'            :   county,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'postid'            :   postid,
            'min_size'          :   min_size,
            'max_size'          :   max_size,
            'min_lot_size'      :   min_lot_size,
            'max_lot_size'      :   max_lot_size,
            'min_rooms'         :   min_rooms,
            'max_rooms'         :   max_rooms,
            'min_bedrooms'      :   min_bedrooms,
            'max_bedrooms'      :   max_bedrooms,
            'min_bathrooms'     :   min_bathrooms,
            'max_bathrooms'     :   max_bathrooms,
            'status'            :   status,
            'keyword'           :   keyword,
            'all_checkers'      :   all_checkers,
            'order'             :   order,
            'pagination'        :   pagination,
            'security'          :   nonce
            
        },
        success: function (data) { 
        
            var no_results = parseInt(data.no_results);
            var per_page = parseInt (jQuery('#property_dir_per_page').val());
            
            if (no_results !==0){
                jQuery('#listing_ajax_container').append(data.cards);
                if(no_results<=per_page){
                    jQuery('#property_dir_done').val('1');
                    jQuery('#directory_load_more').text(directory_vars.no_more).addClass('no_more_list');
                }
                
            }else{
                jQuery('#property_dir_done').val('1');
                jQuery('#directory_load_more').text(directory_vars.no_more).addClass('no_more_list');
            }
        
            
        
            
            jQuery('#listing_loader').hide();
            wpestate_restart_js_after_ajax();
            with_clear=1;
        },
        error: function (errorThrown) {
        }
    });//end ajax     
    
}