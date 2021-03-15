<?php 
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));

if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='pending'  ){
    echo '<div class="user_dashboard_app">'.esc_html__('Your account is pending approval. Please wait for admin to approve it. ','wpresidence').'</div>';
}
if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='disabled' ){
    echo '<div class="user_dashboard_app">'.esc_html__('Your account is disabled.','wpresidence').'</div>';
}
?>

<div class="user_tab_menu">

    <ul class="user_dashboard_links">
       <?php wpestate_generate_user_menu(); ?>
    </ul>
</div>