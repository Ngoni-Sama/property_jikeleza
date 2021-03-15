<?php
$link           =   esc_url ( get_permalink($prop_id) );
$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'full');

$realtor_details=wpestate_return_agent_details($prop_id);
?>

<div class="featured_article_type2 featured_prop_type4">
    <div class="featured_img_type2" style="background-image:url(<?php echo esc_attr($preview[0]);?>)">

        <div class="featured_gradient"></div>
        <div class="featured_article_type2_title_wrapper">
            <div class="featured_article_label"><?php esc_html_e('Featured Property','wpresidence');?></div>
            <a href="<?php echo esc_url($link);?>"><h2><?php echo get_the_title($prop_id);?></h2></a>
            <div class="featured_read_more">
                <a href="<?php echo esc_url ( get_permalink($prop_id) );?>">
                    <?php esc_html_e('discover more','wpresidence');?>
                </a> 
                <i class="fas fa-angle-right"></i>
            </div> 
             
            <div class='featured_property_type4_agent_wrapper'>
                <a href="<?php echo esc_url($realtor_details['link']);?>" class="featured_property_type4_agent" style="background-image:url('<?php echo esc_url($realtor_details['realtor_image']); ?>');" ></a>
                <a href="<?php echo esc_url($realtor_details['link']);?>" class="featured_property_type4_agent_name" ><?php echo esc_html($realtor_details['realtor_name']); ?></a>
            </div>
               
               
        </div>        
    </div>
</div>