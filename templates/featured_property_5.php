<?php
$link               =   esc_url ( get_permalink($prop_id) );
$wpestate_currency  =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$realtor_details    =   wpestate_return_agent_details($prop_id);
$property_size      =   wpestate_get_converted_measure( $prop_id, 'property_size' );
$property_bedrooms  =   get_post_meta($prop_id,'property_bedrooms',true);
$property_bathrooms =   get_post_meta($prop_id,'property_bathrooms',true);
?>

<div class="featured_article_type2 featured_prop_type5">
  
  <?php  wpestate_header_masonry_gallery($prop_id,'yes');?>
    
    
        <div class="featured_gradient"></div>
        <div class="featured_article_type5_title_wrapper">
            <div class="featured_article_label">
                 <?php  wpestate_show_price($prop_id,$wpestate_currency,$where_currency); ?>
            </div>
            
            <a href="<?php echo esc_url($link);?>"><h2><?php echo get_the_title($prop_id);?></h2></a>
            
            
            <div class="property_unit_type5_content_details_second_row">
                <?php 
                    if($property_bedrooms!=''){
                        print '<div class="inforoom_unit_type5">'.esc_html($property_bedrooms).' '.esc_html__('BD','wpresidence').'</div>';
                    }

                    if($property_bathrooms!=''){
                        print '<div class="inforoom_unit_type5">'.esc_html($property_bathrooms).' '.esc_html__('BA','wpresidence').'<span></span></div>';
                    }

                    if($property_size!=''){
                        print '<div class="inforoom_unit_type5">'.trim($property_size).'</div>';//escaped above
                    }

                ?>
            </div>
            
            
            <div class="featured_type5_excerpt">
            <?php echo wpestate_strip_excerpt_by_char(get_the_excerpt(),130,$prop_id,'...');?>
            </div>
             

            
            <div class="featured_read_more_5">
                <a href="<?php echo esc_url ( get_permalink($prop_id) );?>">
                    <?php esc_html_e('discover more','wpresidence');?>
                    <i class="fas fa-angle-right"></i>
                </a> 
              
            </div> 
               
        </div>        
   
</div>