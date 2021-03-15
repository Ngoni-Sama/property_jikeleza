<?php
/////////////////////////////////////////////////////////////////////////////////////////////////
//// add weekly interval
/////////////////////////////////////////////////////////////////////////////////////////////////
add_filter( 'cron_schedules', 'wpestate_add_weekly_cron_schedule' );

if( !function_exists('wpestate_add_weekly_cron_schedule') ): 
    function wpestate_add_weekly_cron_schedule( $schedules ) {
        $schedules['weekly'] = array(
            'interval' => 604800, // 1 week in seconds
            'display'  => esc_html__( 'Once Weekly','wpresidence' ),
        );

        return $schedules;
    }
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule user_checks
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_estate_schedule_user_check') ): 
    function wp_estate_schedule_user_check(){
        $paid_submission_status    = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
        if($paid_submission_status == 'membership' ){
            //  wpestate_check_user_membership_status_function();
            wp_clear_scheduled_hook('wpestate_check_for_users_event');
            wpestate_setup_daily_user_schedule();  
        }
    }
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule daily USER check
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_setup_daily_user_schedule') ): 
    function  wpestate_setup_daily_user_schedule(){
        if ( ! wp_next_scheduled( 'wpestate_check_for_users_event' ) ) {
            //daily
            wp_schedule_event( time(), 'twicedaily', 'wpestate_check_for_users_event');
        }
    }
endif;
add_action( 'wpestate_check_for_users_event', 'wpestate_check_user_membership_status_function' );




/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule daily pin generation
/////////////////////////////////////////////////////////////////////////////////////////////////

//add_action( 'wp', 'setup_wpestate_cron_generate_pins_daily' );

if( !function_exists('setup_wpestate_cron_generate_pins_daily') ): 
    function setup_wpestate_cron_generate_pins_daily() {
            if ( ! wp_next_scheduled( 'prefix_wpestate_cron_generate_pins_daily' ) ) {
                    wp_schedule_event( time(), 'daily', 'prefix_wpestate_cron_generate_pins_daily');
            }
    }
endif;
setup_wpestate_cron_generate_pins_daily();
add_action( 'prefix_wpestate_cron_generate_pins_daily', 'wpestate_cron_generate_pins' );



if( !function_exists('wpestate_cron_generate_pins') ): 
    function wpestate_cron_generate_pins(){
        if ( wpresidence_get_option('wp_estate_readsys','') =='yes' ){

            $path=wpestate_get_pin_file_path();
            if ( file_exists ($path) && is_writable ($path) ){
                //  wpestate_listing_pins();
                   wpestate_listing_pins_for_file();
            }

        }
    }
endif;




/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule alerts
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_estate_schedule_email_events') ): 
    function wp_estate_schedule_email_events(){
        $show_save_search            =   wpresidence_get_option('wp_estate_show_save_search','');
        $search_alert                =   intval( wpresidence_get_option('wp_estate_search_alert','') );
       
        //  update_option('wpestate_cron_saved_search','none');
        if($show_save_search=='yes'){

            if ($search_alert==0){ // is daily
                wpestate_setup_daily_schedule();  
            }else {//is weekly
                wpestate_setup_weekly_schedule();
            }

        }else{
                wp_clear_scheduled_hook('wpestate_check_for_new_listings_event');
                update_option('wpestate_cron_saved_search','none');

        }

    }
endif;



/////////////////////////////////////////////////////////////////////////////////////////////////
//// schedule daily event
/////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_setup_daily_schedule') ): 
    function  wpestate_setup_daily_schedule(){
        $schedule =   get_option('wpestate_cron_saved_search',true);
        if ( ! wp_next_scheduled( 'wpestate_check_for_new_listings' ) && $schedule!='daily'  ) {
            wp_clear_scheduled_hook('wpestate_check_for_new_listings_event');
            wp_schedule_event( time(), 'daily', 'wpestate_check_for_new_listings_event');
            update_option('wpestate_cron_saved_search','daily');
        }
    }
endif;


/////////////////////////////////////////////////////////////////////////////////////////////////
////schedule weekly event
/////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_setup_weekly_schedule') ): 
    function wpestate_setup_weekly_schedule(){
        $schedule =   get_option('wpestate_cron_saved_search',true);
        if ( ! wp_next_scheduled( 'wpestate_check_for_new_listings' ) && $schedule!='weekly' ) {
            //weekly hourly
            wp_clear_scheduled_hook('wpestate_check_for_new_listings_event');
            wp_schedule_event( time(), 'weekly', 'wpestate_check_for_new_listings_event');
            update_option('wpestate_cron_saved_search','weekly');
        }

    }
endif;
add_action( 'wpestate_check_for_new_listings_event', 'wpestate_check_for_new_listings' );

/////////////////////////////////////////////////////////////////////////////////////////////////
//// check for new listings
/////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_check_for_new_listings') ): 
    function wpestate_check_for_new_listings(){
      
                
        $date_query_array=wpestate_get_alert_period();
        $args = array(
            'post_type'       => 'estate_property',
            'post_status'     => 'publish',
            'posts_per_page'  => -1,
            'date_query'      => $date_query_array

        );
        $prop_selection =   new WP_Query($args);

        if ($prop_selection->have_posts()){    
            // we have new listings - we should compare searches

            wpestate_saved_search_checks();
        }else{

        }
        
    }
endif;


/////////////////////////////////////////////////////////////////////////////////
// 
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_saved_search_checks') ): 
    function wpestate_saved_search_checks(){
   
           $args = array(
                    'post_type'        => 'wpestate_search',
                    'post_status'      =>  'any',
                    'posts_per_page'   => -1 ,
                );
            $prop_selection = new WP_Query($args);

            if($prop_selection->have_posts()){ 

                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    $post_id=get_the_id();
                    $arguments      =   get_post_meta($post_id, 'search_arguments', true) ;
                    $meta_arguments =   get_post_meta($post_id, 'meta_arguments', true) ;
                    $user_email     =   get_post_meta($post_id, 'user_email', true) ;
                    $mail_content   =   wpestate_compose_send_email($arguments,$meta_arguments);
                 
                    
                    
                    if($user_email!='' && $mail_content!=''){
                        $arguments=array(
                            'matching_submissions' => $mail_content
                        );
                        
                        wpestate_select_email_type($user_email,'matching_submissions',$arguments);
                        
                    }

                endwhile;

            }

    }
endif;


/////////////////////////////////////////////////////////////////////////////////
// compose alert email
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_compose_send_email') ): 
    function wpestate_compose_send_email($args,$meta_arguments){
        $mail_content=''; 
        $arguments  = objectToArray( json_decode($args) );
        $metas      = objectToArray( json_decode($meta_arguments) );

        $arguments['date_query']=     $date_query_array=wpestate_get_alert_period();

    
        unset($arguments['post__in']);
     
        if(!empty($metas) ){
            $meta_ids = wpestate_add_meta_post_to_search($metas);
            if(!empty($meta_ids)){
                $arguments['post__in']=$meta_ids;
            }
        }
        
        $prop_selection = new WP_Query($arguments);
        if($prop_selection->have_posts()){ 

            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                $post_id=get_the_id();
                $mail_content .= get_the_permalink($post_id)."\r\n";
            endwhile;
            $mail_content .='';    
        }else{
            $mail_content='';   
        }
        wp_reset_postdata();
        wp_reset_query();


        return $mail_content;
    }

endif;


/////////////////////////////////////////////////////////////////////////////////
// convert object to array
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('objectToArray') ): 
    function objectToArray ($object) {
        if(!is_object($object) && !is_array($object))
            return $object;

        return array_map('objectToArray', (array) $object);
    }
endif;

/////////////////////////////////////////////////////////////////////////////////
// get email alert period
/////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_alert_period') ): 
    function wpestate_get_alert_period(){
         $search_alert            =   wpresidence_get_option('wp_estate_search_alert','');


        if( $search_alert==0 ){ // is daly
            $today = getdate();
            $date_query_array=  array(
                                    'after' => '1 day ago'
                                );

        }else{ // is weekly
            $date_query_array=  array(
                                    'after' => '1 week ago'
                                );
        }

        return $date_query_array;
    }
endif;






function estate_parse_curency(){
    $base                =   esc_html( wpresidence_get_option('wp_estate_currency_label_main') );
    $custom_fields = wpresidence_get_option( 'wpestate_currency', '');    
    
    $i=0;
    if( !empty($custom_fields)){    
        while($i< count($custom_fields) ){
            $symbol=$custom_fields[$i][0];
            $custom_fields[$i][2]=  wpestate_currencyconverterapi_load_data($base, $symbol);
            
            $i++;
        }
    }
    $cur_code=array();
    $cur_label=array();
    $cur_value=array();
    $cur_positin=array();
    $redux_currency=array();
    
    
    foreach($custom_fields as $field){
        $cur_code[]=$field[0];
        $cur_label[]=$field[1];
        $cur_value[]=$field[2];
        $cur_positin[]=$field[3];
    }
    
    $redux_currency['add_curr_name']=$cur_code;
    $redux_currency['add_curr_label']=$cur_label;
    $redux_currency['add_curr_value']=$cur_value;  
    $redux_currency['add_curr_order']=$cur_positin;

    Redux::setOption('wpresidence_admin','wpestate_currency', $redux_currency);

}


function wpestate_currencyconverterapi_load_data($base, $symbol){
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
        require_once (ABSPATH . '/wp-admin/includes/file.php');
        WP_Filesystem();
    }
      
    $apikey= trim( wpresidence_get_option('wp_estate_currencyconverterapi_api',''));    
    $link='https://free.currencyconverterapi.com/api/v6/convert?q='.$base.'_'.$symbol.'&compact=y&apiKey='.$apikey;
    $data = (array)json_decode($wp_filesystem->get_contents($link));
  
    return( $data[$base.'_'.$symbol]->val);
}



function wp_estate_enable_load_exchange(){
     if ( ! wp_next_scheduled( 'wpestate_load_exchange_action' ) ) {
            //daily
            wp_schedule_event( time(), 'daily', 'wpestate_load_exchange_action');
        }
}
add_action( 'wpestate_load_exchange_action', 'estate_parse_curency' );
?>