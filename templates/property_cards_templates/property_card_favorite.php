<?php
$current_user       =   wp_get_current_user();   
$userID                 =   $current_user->ID;
$user_option            =   'favorites'.intval($userID);
$curent_fav             =   get_option($user_option);

$favorite_class =   'icon-fav-off';
$fav_mes        =   esc_html__('add to favorites','wpresidence');

if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'icon-fav-on';   
    $fav_mes        =   esc_html__('remove from favorites','wpresidence');
    } 
}


            
print ' <span class="icon-fav '. esc_html($favorite_class).'" data-original-title="'.esc_attr($fav_mes).'" data-postid="'.intval($post->ID).'"></span>';
if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
    print '<span class="icon-fav icon-fav-on-remove" data-postid="'.esc_attr($post->ID).'"> '.esc_html($fav_mes).'</span>';
}
