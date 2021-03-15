<?php
global $align;
global $is_shortcode;
global $row_number_col;
global $wpestate_options;
$col_data       =   wpestate_return_unit_class($wpestate_no_listins_per_row,$wpestate_options['content_class'],$align,$is_shortcode,$row_number_col,$wpestate_property_unit_slider);
$title          =   get_the_title();
$link           =   esc_url( get_permalink() );
$main_image     =   wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'listing_full_slider');
?>  

<div class="<?php echo esc_html($col_data['col_class']);?> listing_wrapper property_unit_type3" 
    data-org="<?php echo esc_attr($col_data['col_org']);?>"   
    data-main-modal="<?php echo esc_attr($main_image[0]); ?>"
    data-modal-title="<?php echo esc_attr($title);?>"
    data-modal-link="<?php echo esc_attr($link);?>"
    data-listid="<?php echo intval($post->ID);?>" > 
    
  
    <div class="property_listing property_unit_type3 <?php echo wpestate_interior_classes($wpestate_uset_unit); ?> " 
         data-link="<?php   if(  $wpestate_property_unit_slider==0){ echo esc_url($link);}?>">

        <?php 
        if ($wpestate_uset_unit==1){
            wpestate_build_unit_custom_structure($wpestate_custom_unit_structure,$post->ID,$wpestate_property_unit_slider);
        } else{?>
                <div class="listing-unit-img-wrapper">
                    <div class="featured_gradient"></div>
                    <?php get_template_part('templates/property_cards_templates/property_card_slider');?>
                    <?php get_template_part('templates/property_cards_templates/property_card_tags'); ?>
                    <?php get_template_part('templates/property_cards_templates/property_card_actions_type_default'); ?>
                    
                </div>
    
                <div class="info_container_unit_3">
                    <?php get_template_part('templates/property_cards_templates/property_card_price_type3'); ?>
                    <?php get_template_part('templates/property_cards_templates/property_card_details_type3'); ?>
                    <?php get_template_part('templates/property_cards_templates/property_card_adress_type3'); ?>
              
                </div>
        
                <div class="property_location_unit_type3">
                    <?php get_template_part('templates/property_cards_templates/property_card_agent_details'); ?>
                    <div class="unit_type3_details">
                        <a href="<?php echo  esc_url($link); ?>"><?php echo esc_html__( 'details', 'wpresidence' )?></a>
                    </div>
                </div>        
        <?php
        }// end if custom structure
        ?>
    </div>             
</div>