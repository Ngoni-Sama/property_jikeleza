<?php 
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$parent_userID          =   wpestate_check_for_agency($userID);
$user_login             =   $current_user->user_login;
$user_pack              =   get_the_author_meta( 'package_id' , $parent_userID );
$user_registered        =   get_the_author_meta( 'user_registered' , $parent_userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $parent_userID );
$images                 =   '';
$counter                =   0;
$unit                   =   esc_html( wpresidence_get_option('wp_estate_measure_sys', '') );
$paid_submission_status = esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
?> 


    <?php                        
    if( $paid_submission_status == 'membership'){
    
       print'
       <div class="submit_container">    
       <div class="submit_container_header">'.esc_html__('Membership','wpresidence').'</div>'; 
       wpestate_get_pack_data_for_user($parent_userID,$user_pack,$user_registered,$user_package_activation);
       print'</div>'; // end submit container
    }
    if( $paid_submission_status == 'per listing'){
        $price_submission               =   floatval( wpresidence_get_option('wp_estate_price_submission','') );
        $price_featured_submission      =   floatval( wpresidence_get_option('wp_estate_price_featured_submission','') );
        $submission_curency_status      =   esc_html( wpresidence_get_option('wp_estate_submission_curency','') );
        print'<div class="submit_container">
        <div class="submit_container_header">'.esc_html__('Paid submission','wpresidence').'</div>';
        print'<div class="user_dashboard_box">';
        print '<p class="full_form-nob">'.esc_html__( 'This is a paid submission.','wpresidence').'</p>';
        print '<p class="full_form-nob">'.esc_html__( 'Price: ','wpresidence').'<span class="submit-price">'.$price_submission.' '.$submission_curency_status.'</span></p>';
        print '<p class="full_form-nob">'.esc_html__( 'Featured (extra): ','wpresidence').'<span class="submit-price">'.$price_featured_submission.' '.$submission_curency_status.'</span></p>';
        print'</div>'; // end submit container
        print'</div>';
     }
    ?>