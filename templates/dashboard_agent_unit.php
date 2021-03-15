<?php
global $wpestate_options;

$thumb_id           =   get_post_thumbnail_id($post->ID);
$preview            =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$agent_skype        =   esc_html( get_post_meta($post->ID, 'agent_skype', true) );
$agent_phone        =   esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       =   esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        =   esc_html( get_post_meta($post->ID, 'agent_email', true) );
$agent_posit        =   esc_html( get_post_meta($post->ID, 'agent_position', true) );
$post_status        =   get_post_status($post->ID);
$name               =   get_the_title();
$link               =   esc_url( get_permalink() );
$edit_link          =   wpestate_get_template_link('user_dashboard_add_agent.php');
$edit_link          =   esc_url_raw(add_query_arg( 'listing_edit', $post->ID, $edit_link )) ;
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
<div class="col-md-4 listing_wrapper">
    <div class="agent_unit" data-link="<?php print esc_attr($link);?>">
        <div class="agent-unit-img-wrapper">
            <div class="prop_new_details_back"></div>
            <?php 
                print trim($thumb_prop); 
            ?>
        </div>    
            
        <div class="">
            <?php
            print '<h4> <a href="'.esc_url( $link).'">'.esc_html($name).'</a></h4>
            <div class="agent_position">'.esc_html($agent_posit).'</div>';
           
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fas fa-phone"></i>'.esc_html($agent_phone ).'</div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fas fa-mobile-alt"></i>'.esc_html($agent_mobile).'</div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="far fa-envelope"></i> '. esc_html($agent_email).'</div>';
            }

            if ($agent_skype) {
                print '<div class="agent_detail"><i class="fab fa-skype"></i>'.esc_html($agent_skype).'</div>';
            }
            
            print '<div class="agent_detail"><strong>'.esc_html__('user id:','wpresidence').'</strong>  '.     get_post_meta($post->ID, 'user_meda_id',true ). '</div>';
            ?>
        </div> 
    
         <?php
        $defaults = array(
            'echo'   => false,
        );
        ?>
        <div class="agent_control_bar ">
          
                <a  data-original-title="<?php esc_attr_e('Edit Agent','wpresidence');?>"   class="dashboad-tooltip" href="<?php  print esc_url($edit_link);?>"><i class="fas fa-pen-square editprop"></i></a>
                <a  data-original-title="<?php esc_attr_e('Delete Agent','wpresidence');?>" class="dashboad-tooltip" onclick="return confirm(' <?php echo esc_html__('Are you sure you wish to delete ','wpresidence').the_title_attribute($defaults); ?>?')" href="<?php print esc_url_raw(add_query_arg( 'delete_id', $post->ID,  wpestate_get_template_link('user_dashboard_agent_list.php')   ) );?>"><i class="fas fa-times deleteprop"></i></a>  
                <?php
                    if( $post_status == 'publish' ){ 
                        print ' <span  data-original-title="'.esc_attr__('Disable Agent','wpresidence').'" class="dashboad-tooltip disable_listing disable_agent disabledx" data-postid="'.intval($post->ID).'" ><i class="fas fa-pause"></i></span>';
                    }else if($post_status=='disabled') {
                        print ' <span  data-original-title="'.esc_attr__('Enable Agent','wpresidence').'" class="dashboad-tooltip disable_listing disable_agent" data-postid="'.intval($post->ID).'" ><i class="fas fa-play"></i></span>';
                    }
                ?>               
         
        </div>
    </div>
</div>