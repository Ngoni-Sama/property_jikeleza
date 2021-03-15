<?php
$social_facebook    =  esc_html( wpresidence_get_option('wp_estate_facebook_link','') );
$social_tweet       =  esc_html( wpresidence_get_option('wp_estate_twitter_link','') );
$social_google      =  esc_html( wpresidence_get_option('wp_estate_google_link','') );
$linkedin_link      =  esc_html ( wpresidence_get_option('wp_estate_linkedin_link','') );
$pinterest_link     =  esc_html ( wpresidence_get_option('wp_estate_pinterest_link','') );
$instagram_link     =   esc_html ( wpresidence_get_option('wp_estate_instagram_link','') );  
?>

<div class="header_social">

<?php
if($social_facebook!=''){
    print '<a href="'.esc_url($social_facebook).'" class="social_facebook" target="_blank"></a>';
}

if($social_tweet!=''){
    print '<a href="'.esc_url($social_tweet).'" class="social_tweet" target="_blank"></a>';
}

if($social_google!=''){
    print '<a href="'.esc_url($social_google).'" class="social_google" target="_blank"></a>';
}

if($linkedin_link!=''){
    print '<a href="'.esc_url($linkedin_link).'" class="social_linkedin" target="_blank"></a>';
}

if($pinterest_link!=''){
    print '<a href="'.esc_url($pinterest_link).'" class="social_pinterest" target="_blank"></a>';
}

if($instagram_link!=''){
    print '<a href="'.esc_url($instagram_link).'" class="social_instagram" target="_blank"></a>';
}
?>
</div>    