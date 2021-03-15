<?php

//mimic the actuall admin-ajax
define('DOING_AJAX', true);
if (!isset( $_POST['action']))
    die('-1 bis');

//make sure you update this line 
//to the relative location of the wp-load.php
require_once('../../../wp-load.php'); 

//Typical headers
header('Content-Type: text/html');
send_nosniff_header();
//Disable caching
header('Cache-Control: no-cache');
header('Pragma: no-cache');


$action = esc_attr(trim($_POST['action']));


$allowed_actions = array(
    'wpestate_property_modal_listing_details',
    'wpestate_property_modal_listing_details_second',
    'wpestate_custom_ondemand_pin_load',
    'wpestate_load_recent_items_sh',
    'wpestate_ajax_filter_listings',
    'wpestate_custom_adv_ajax_filter_listings_search',
    'wpestate_classic_ondemand_pin_load_type2_tabs'
    
);

if(in_array($action, $allowed_actions)){
   // print '-->wpestate_ajax_handler'.'_'.$action;
    
    if(is_user_logged_in())
        do_action('wpestate_ajax_handler'.'_'.$action);
    else
        do_action('wpestate_ajax_handler_nopriv'.'_'.$action);
}
else{
    die('-1');
} 