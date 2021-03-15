<?php
global $wpestate_options;
global $notes;
global $post;
$thumb_id           = get_post_thumbnail_id($post->ID);
$preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$name               = get_the_title();
$link               =  esc_url( get_permalink() );
$agent_posit        = esc_html( get_post_meta($post->ID, 'agent_position', true) );
$agent_phone        = esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       = esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        = esc_html( get_post_meta($post->ID, 'agent_email', true) );
$agent_skype        = esc_html( get_post_meta($post->ID, 'agent_skype', true) );
$agent_facebook     = esc_html( get_post_meta($post->ID, 'agent_facebook', true) );
$agent_twitter      = esc_html( get_post_meta($post->ID, 'agent_twitter', true) );
$agent_linkedin     = esc_html( get_post_meta($post->ID, 'agent_linkedin', true) );
$agent_pinterest    = esc_html( get_post_meta($post->ID, 'agent_pinterest', true) );
$agent_instagram    = esc_html( get_post_meta($post->ID, 'agent_instagram', true) );

$extra= array(
        'data-original'=>$preview[0],
        'class'	=> 'lazyload img-responsive',    
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);
if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_theme_file_uri('/img/default_user.png').'" alt="'.esc_html__('user image','wpresidence').'">';
}

$col_class=4;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}           
?>

    <div class="agent_unit agent_unit_featured" data-link="<?php print esc_attr($link);?>">
        <?php 
        print '<div class="agent-unit-img-wrapper"><div class="prop_new_details_back"></div>';
        print trim($thumb_prop); 
        print '</div>';
        ?>

        <div class="">
            <?php
            print '<h4> <a href="' . esc_url($link). '">' .esc_html($name). '</a></h4>
            <div class="agent_position">'. esc_html($agent_posit) .'</div>';
            print '<div class="agent_featured_details">';
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fas fa-phone"></i>' .esc_html( $agent_phone) . '</div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fas fa-mobile-alt"></i>' .esc_html( $agent_mobile ). '</div>';
            }
            if ($agent_email) {
                print '<div class="agent_detail"><i class="far fa-envelope"></i> ' . esc_html($agent_email) . '</div>';
            }
            
           
            print '</div>';
            
            print '<div class="agent_unit_social"><div class="social-wrapper featured_agent_social">';
     
                if($agent_facebook){
                    print ' <a href="'. esc_url( $agent_facebook).'"><i class="fab fa-facebook-f"></i></a>';
                }

                if($agent_twitter){
                    print ' <a href="'.esc_url($agent_twitter).'"><i class="fab fa-twitter"></i></a>';
                }
                
                if($agent_linkedin){
                    print ' <a href="'.esc_url($agent_linkedin).'"><i class="fab fa-linkedin-in"></i></a>';
                }
                
                if($agent_pinterest){
                     print ' <a href="'. esc_url($agent_pinterest).'"><i class="fab fa-pinterest-p"></i></a>';
                }
                if($agent_instagram){
                    print ' <a href="'. esc_url($agent_instagram).'"><i class="fab fa-instagram"></i></a>';
                }
         
            print '</div></div>';
            
            print '<div class="featured_agent_notes">'.esc_html($notes).'</div>';
            print '<a class="see_my_list_featured" href="'.esc_url($link).'" target="_blank">
                    <span class="featured_agent_listings wpresidence_button">'.esc_html__('My Listings','wpresidence').'</span>
                </a>';
          
            ?>
        </div> 

    </div>
<!-- </div>    -->