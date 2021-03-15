<?php
if( !function_exists('wpestate_how_many_pages') ):
    function wpestate_how_many_pages(){
        $args = array(
            'post_type'         => 'page',
            'post_status'       => 'any',
            'paged'             => -1,
        );

        $query = new WP_Query($args);

        $current_pages= $query->found_posts;
        wp_reset_postdata();
        wp_reset_query();
        return $current_pages;

    }
endif;

if( !function_exists('wpestate_ajax_apperance_set') ):
    function wpestate_ajax_apperance_set(){
        $args = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'any',
            'paged'             => -1,
        );

        $query = new WP_Query($args);

        $current_listed= $query->found_posts;
        wp_reset_postdata();
        wp_reset_query();
        return $current_listed;

    }
endif;


add_action( 'wp_ajax_wpestate_ajax_start_map', 'wpestate_ajax_start_map' );  
if( !function_exists('wpestate_ajax_start_map') ):
function wpestate_ajax_start_map(){ 
    check_ajax_referer( 'wpestate_setup_nonce', 'security' );
    $api_key           =   sanitize_text_field($_POST['api_key']) ;
    
    if(current_user_can('administrator')){
        Redux::setOption('wpresidence_admin','wp_estate_api_key', $api_key);
    }
    die();

}
endif;


add_action( 'wp_ajax_wpestate_ajax_general_set', 'wpestate_ajax_general_set' );  
if( !function_exists('wpestate_ajax_general_set') ):
function wpestate_ajax_general_set(){ 
    check_ajax_referer( 'wpestate_setup_nonce', 'security' );
    $general_country    =   sanitize_text_field($_POST['general_country']) ;
    $measure_sys        =   sanitize_text_field($_POST['measure_sys']) ;
    $currency_symbol    =   sanitize_text_field($_POST['currency_symbol']) ;
    $date_lang          =   sanitize_text_field($_POST['date_lang']) ;
    
    if(current_user_can('administrator')){
        Redux::setOption('wpresidence_admin','wp_estate_general_country', $general_country);
        Redux::setOption('wpresidence_admin','wp_estate_currency_symbol', $currency_symbol);
        Redux::setOption('wpresidence_admin','wp_estate_measure_sys', $measure_sys);
        Redux::setOption('wpresidence_admin','wp_estate_date_lang', $date_lang);
        
    }
    die();

    
}
endif; 


add_action( 'wp_ajax_wpestate_ajax_apperance_set', 'wpestate_ajax_apperance_set' );  
    if( !function_exists('wpestate_ajax_apperance_set') ):
    function wpestate_ajax_apperance_set(){ 
        check_ajax_referer( 'wpestate_setup_nonce', 'security' );
        $property_list_type_adv =   sanitize_text_field($_POST['property_list_type_adv']) ;
        $wpestate_prop_unit     =   sanitize_text_field($_POST['prop_unit']) ;


        if(current_user_can('administrator')){
            Redux::setOption('wpresidence_admin','wp_estate_property_list_type_adv', $property_list_type_adv);
            Redux::setOption('wpresidence_admin','wp_estate_prop_unit', $prop_unit);
        }
        die();


    }
endif; 