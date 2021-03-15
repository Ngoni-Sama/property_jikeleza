 <div class="listing_actions">
     
<?php

    $current_user           =   wp_get_current_user();   
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
    
    print wpestate_share_unit_desing($post->ID);
    $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');?>
    <span class="share_list"  data-original-title="<?php esc_attr_e('share','wpresidence');?>" ></span>
    <?php if( !isset($remove_fav)  ){ ?>
        <span class="icon-fav <?php echo esc_attr($favorite_class);?>" data-original-title="<?php print esc_attr($fav_mes); ?>" data-postid="<?php echo intval($post->ID); ?>"></span>
    <?php } ?>
    <span class="compare-action" data-original-title="<?php  esc_attr_e('compare','wpresidence');?>" data-pimage="<?php if( isset($compare[0])){echo esc_attr($compare[0]);} ?>" data-pid="<?php echo intval($post->ID); ?>"></span>

</div>