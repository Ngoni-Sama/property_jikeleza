<?php
$company_name       =   esc_html( stripslashes( wpresidence_get_option('wp_estate_company_name', '') ) );
$company_picture    =   esc_html( stripslashes( wpresidence_get_option('wp_estate_company_contact_image', 'url') ) );
$company_email      =   esc_html( stripslashes( wpresidence_get_option('wp_estate_email_adr', '') ) );
$mobile_no          =   esc_html( stripslashes( wpresidence_get_option('wp_estate_mobile_no','') ) );
$telephone_no       =   esc_html( stripslashes( wpresidence_get_option('wp_estate_telephone_no', '') ) );
$fax_ac             =   esc_html( stripslashes( wpresidence_get_option('wp_estate_fax_ac', '') ) );
$skype_ac           =   esc_html( stripslashes( wpresidence_get_option('wp_estate_skype_ac', '') ) );

if (function_exists('icl_translate') ){
    $co_address      =  esc_html( icl_translate('wpestate','wp_estate_co_address_text', ( wpresidence_get_option('wp_estate_co_address') ) ) );
}else{
    $co_address      = esc_html( stripslashes ( wpresidence_get_option('wp_estate_co_address', '') ) );
}

$facebook_link      =   esc_html( wpresidence_get_option('wp_estate_facebook_link', '') );
$twitter_link       =   esc_html( wpresidence_get_option('wp_estate_twitter_link', '') );
$google_link        =   esc_html( wpresidence_get_option('wp_estate_google_link', '') );
$linkedin_link      =   esc_html ( wpresidence_get_option('wp_estate_linkedin_link','') );
$pinterest_link     =   esc_html ( wpresidence_get_option('wp_estate_pinterest_link','') );
$instagram_link     =   esc_html ( wpresidence_get_option('wp_estate_instagram_link','') );  


$wp_opening_hours_1         =   esc_html ( wpresidence_get_option('wp_opening_hours_1','') );  
$wp_opening_hours_value_1   =   esc_html ( wpresidence_get_option('wp_opening_hours_value_1','') );  
$wp_opening_hours_2         =   esc_html ( wpresidence_get_option('wp_opening_hours_2','') );  
$wp_opening_hours_value_2   =   esc_html ( wpresidence_get_option('wp_opening_hours_value_2','') );  
$wp_opening_hours_3         =   esc_html ( wpresidence_get_option('wp_opening_hours_3','') );  
$wp_opening_hours_value_3   =   esc_html ( wpresidence_get_option('wp_opening_hours_value_3','') );  
?>

<div class="contact_map_container">
    <h4><?php esc_html_e('How To Find Us','wpresidence'); ?></h4>
    
       <?php      
            if ($telephone_no) {
                print '<div class="agent_detail contact_detail"><i class="fas fa-phone"></i><a href="tel:' . esc_html($telephone_no) . '">'; print esc_html( $telephone_no ). '</a></div>';
            }

            if ($company_email) {
                print '<div class="agent_detail contact_detail"><i class="far fa-envelope"></i>'; print '<a href="mailto:'.esc_html($company_email).'">' .esc_html( $company_email ). '</a></div>';
            }

           
            if ($co_address) {
                print '<div class="agent_detail contact_detail"><i class="fas fa-home"></i></i>';print  esc_html( $co_address ). '</div>';
            }
        ?>
    <h4><?php esc_html_e('Opening Hours','wpresidence'); ?></h4>
        
    <?php 
    if ($wp_opening_hours_1) {
        print '<div class="agent_detail contact_detail">'.esc_html($wp_opening_hours_1).' <span>'.esc_html( $wp_opening_hours_value_1 ). '</span></div>';
    }
    
    if ($wp_opening_hours_2) {
        print '<div class="agent_detail contact_detail">'.esc_html($wp_opening_hours_2).' <span>'.esc_html( $wp_opening_hours_value_2 ). '</span></div>';
    }
    
    if ($wp_opening_hours_3) {
        print '<div class="agent_detail contact_detail">'.esc_html($wp_opening_hours_3).' <span>'.esc_html( $wp_opening_hours_value_3 ). '</span></div>';
    }
    
    
    
    ?>
        
</div>
