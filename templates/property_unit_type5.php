<?php
global $align;
global $is_shortcode;
global $row_number_col;
global $wpestate_property_unit_slider;
global $wpestate_options;


$col_data       =   wpestate_return_unit_class($wpestate_no_listins_per_row,$wpestate_options['content_class'],$align,$is_shortcode,$row_number_col,$wpestate_property_unit_slider);
$title          =   get_the_title();
$link           =   esc_url( get_permalink() );
$main_image     =   wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'listing_full_slider');
?>  


<div class="<?php echo esc_html($col_data['col_class']);?> listing_wrapper   property_unit_type5 " 
        data-org="<?php echo esc_attr($col_data['col_org']);?>"   
        data-main-modal="<?php echo esc_attr($main_image[0]); ?>"
        data-modal-title="<?php echo esc_attr($title);?>"
        data-modal-link="<?php echo esc_attr($link);?>"
     
        data-listid="<?php echo intval($post->ID);?>" > 
    
    <div class="property_unit_type5_content_wrapper property_listing"    data-link="<?php echo esc_attr($link);?>">
        
        <?php get_template_part('templates/property_cards_templates/property_card_tags'); ?>
        
        <div class="featured_gradient"></div>
        
        <?php get_template_part('templates/property_cards_templates/property_card_slider_type5'); ?>
        
        
        <div class="property_unit_type5_content_details">
            <?php get_template_part('templates/property_cards_templates/property_card_price'); ?>
            
            <?php get_template_part('templates/property_cards_templates/property_card_title'); ?>
            <?php get_template_part('templates/property_cards_templates/property_card_details_type5'); ?>
        </div>
        
        
    </div>
    
</div>