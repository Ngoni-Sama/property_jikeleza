<?php
global $wpestate_options;
global $agent_wid;

if($agent_wid!=0){
    $thumb_id           = get_post_thumbnail_id($agent_wid);
    $preview            = wp_get_attachment_image_src(get_post_thumbnail_id($agent_wid), 'property_listings');
    $name               = get_the_title($agent_wid);
    $link               = esc_url( get_permalink($agent_wid) );
    $type=get_post_type($agent_wid);
     
    if( $type=='estate_agent' ){
        $agent_skype        = esc_html( get_post_meta($agent_wid, 'agent_skype', true) );
        $agent_phone        = esc_html( get_post_meta($agent_wid, 'agent_phone', true) );
        $agent_mobile       = esc_html( get_post_meta($agent_wid, 'agent_mobile', true) );
        $agent_email        = esc_html( get_post_meta($agent_wid, 'agent_email', true) );

        $agent_posit        = esc_html( get_post_meta($agent_wid, 'agent_position', true) );
        $agent_facebook     = esc_html( get_post_meta($agent_wid, 'agent_facebook', true) );
        $agent_twitter      = esc_html( get_post_meta($agent_wid, 'agent_twitter', true) );
        $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'agent_linkedin', true) );
        $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'agent_pinterest', true) );
        $agent_instagram    = esc_html( get_post_meta($agent_wid, 'agent_instagram', true) );
        $agent_urlc         = esc_html( get_post_meta($agent_wid, 'agent_website', true) );
    }else if( $type=='estate_agency' ){
        $agent_skype        = esc_html( get_post_meta($agent_wid, 'agency_skype', true) );
        $agent_phone        = esc_html( get_post_meta($agent_wid, 'agency_phone', true) );
        $agent_mobile       = esc_html( get_post_meta($agent_wid, 'agency_mobile', true) );
        $agent_email        = esc_html( get_post_meta($agent_wid, 'agency_email', true) );

        $agent_posit        = esc_html( get_post_meta($agent_wid, 'agency_position', true) );
        $agent_facebook     = esc_html( get_post_meta($agent_wid, 'agency_facebook', true) );
        $agent_twitter      = esc_html( get_post_meta($agent_wid, 'agency_twitter', true) );
        $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'agency_linkedin', true) );
        $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'agency_pinterest', true) );
        $agent_instagram    = esc_html( get_post_meta($agent_wid,  'agency_instagram', true) );
        $agent_urlc         = esc_html( get_post_meta($agent_wid, 'agency_website', true) );
    }else if($type=='estate_developer'){
        $agent_skype        = esc_html( get_post_meta($agent_wid, 'developer_skype', true) );
        $agent_phone        = esc_html( get_post_meta($agent_wid, 'developer_phone', true) );
        $agent_mobile       = esc_html( get_post_meta($agent_wid, 'developer_mobile', true) );
        $agent_email        = esc_html( get_post_meta($agent_wid, 'developer_email', true) );

        $agent_posit        = esc_html( get_post_meta($agent_wid, 'developer_position', true) );
        $agent_facebook     = esc_html( get_post_meta($agent_wid, 'developer_facebook', true) );
        $agent_twitter      = esc_html( get_post_meta($agent_wid, 'developer_twitter', true) );
        $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'developer_linkedin', true) );
        $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'developer_pinterest', true) );
        $agent_instagram    = esc_html( get_post_meta($agent_wid, ' developer_instagram', true) );
        $agent_urlc         = esc_html( get_post_meta($agent_wid, 'developer_website', true) );
    }
    
    
    $extra= array(
            'data-original'=>$preview[0],
            'class'	=> 'lazyload img-responsive',    
            );
    $thumb_prop    = get_the_post_thumbnail($agent_wid, 'property_listings',$extra);

    if($thumb_prop==''){
        $thumb_prop = '<img src="'.get_theme_file_uri('/img/default_user.png').'" alt="'.esc_html__('user image','wpresidence').'">';
    }
    
}else{
    
    $thumb_prop    =   get_the_author_meta( 'custom_picture',$agent_wid  );
    if($thumb_prop==''){
        $thumb_prop=get_theme_file_uri('/img/default-user.png');
    }
    
    $thumb_prop = '<img src="'.esc_url($thumb_prop).'" alt="'.esc_html__('user image','wpresidence').'">';
    
    $agent_skype         = get_the_author_meta( 'skype' ,$agent_wid );
    $agent_phone         = get_the_author_meta( 'phone'  ,$agent_wid);
    $agent_mobile        = get_the_author_meta( 'mobile'  ,$agent_wid);
    $agent_email         = get_the_author_meta( 'user_email' ,$agent_wid );
    $agent_pitch         = '';
    $agent_posit         = get_the_author_meta( 'title' ,$agent_wid );
    $agent_facebook      = get_the_author_meta( 'facebook',$agent_wid  );
    $agent_twitter       = get_the_author_meta( 'twitter' ,$agent_wid );
    $agent_linkedin      = get_the_author_meta( 'linkedin'  ,$agent_wid);
    $agent_pinterest     = get_the_author_meta( 'pinterest',$agent_wid  );
    $agent_instagram     = get_the_author_meta( 'instagram',$agent_wid  );
    $agent_urlc          = get_the_author_meta( 'website' ,$agent_wid );
    $link                =  esc_url( get_permalink() );
    $name                = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name');
    
}

$counter            = '';
$user_for_id = intval(get_post_meta($agent_wid,'user_meda_id',true));
if($user_for_id!=0){
$counter            =   count_user_posts($user_for_id,'estate_property',true);
}

$col_class=4;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}
           
?>

    <div class="agent_unit agent_unit_sidebar" data-link="<?php print esc_attr($link);?>">
        <div class="agent-unit-img-wrapper">
            <?php if($user_for_id!=0){ ?>
            <div class="agent_card_my_listings">
                <?php print intval($counter).' '; 
                    if($counter!=1){
                        esc_html_e('listings','wpresidence');
                    }else{
                        esc_html_e('listing','wpresidence');
                    }
                ?>
            </div>
             <?php } ?>
            
            <div class="prop_new_details_back"></div>
           <?php 
            print trim($thumb_prop); 
            ?>
        </div>    
            
        <div class="">
            <?php
            print '<h4> <a href="'.esc_url($link).'">'.esc_html($name).'</a></h4>
            <div class="agent_position">'. esc_html($agent_posit).'</div>';
           
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fas fa-phone"></i><a href="tel:'.esc_html($agent_phone).'">'.esc_html($agent_phone).'</a></div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fas fa-mobile-alt"></i><a href="tel:'.esc_html($agent_mobile).'">'.esc_html($agent_mobile).'</a></div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="far fa-envelope"></i> <a href="mailto:'.esc_html($agent_email).'">'.esc_html($agent_email). '</a></div>';
            }

            if ($agent_skype) {
                print '<div class="agent_detail"><i class="fab fa-skype"></i>' . esc_html($agent_skype). '</div>';
            }
            
            if ($agent_urlc) {
                print '<div class="agent_detail"><i class="fas fa-desktop"></i><a href="'.esc_url($agent_urlc).'" target="_blank">'.esc_html($agent_urlc).'</a></div>';
            }
                 
            ?>
         </div> 
    
        
        
    </div>
<!-- </div>    -->