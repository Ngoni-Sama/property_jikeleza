<?php
$slides             =   '';
$title              =   get_the_title($prop_id);
$link               =   get_permalink($prop_id);
$property_bathrooms =   get_post_meta($prop_id, 'property_bathrooms', true);
$property_rooms     =   get_post_meta($prop_id, 'property_bedrooms', true);
$property_size      =   wpestate_get_converted_measure( $prop_id, 'property_size' ) ;
$price              =   floatval( get_post_meta($prop_id, 'property_price', true) );
$price_label        =   '<span class="price_label">'.esc_html ( get_post_meta($prop_id, 'property_label', true) ).'</span>';
$price_label_before =   '<span class="price_label price_label_before">'.esc_html ( get_post_meta($prop_id, 'property_label_before', true) ).'</span>';

if ($price != 0) {
    $price = wpestate_show_price($prop_id,$wpestate_currency,$where_currency,1);  
}else{
    $price=$price_label_before.$price_label;
}

$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured');
if($preview[0]==''){
    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
}
    
$property_bathrooms =   get_post_meta($prop_id, 'property_bathrooms', true);
$property_rooms     =   get_post_meta($prop_id, 'property_bedrooms', true);
$property_city      =   get_the_term_list($prop_id, 'property_city', '', ', ', '') ;
$property_area      =   get_the_term_list($prop_id, 'property_area', '', ', ', '');
$property_action    =   get_the_term_list($prop_id, 'property_action_category', '', ', ', '');  
$property_category  =   get_the_term_list($prop_id, 'property_category', '', ', ', '');  
$property_size      =   wpestate_get_converted_measure( $prop_id ,'property_size' );
?>
        
    <!-- sections -->
    <section class="section <?php echo esc_attr($initial_section); ?>">
            <div class="section__content">
                <h2 class="section__title"><a href="<?php echo get_the_permalink();?>"><?php echo esc_html($title); ?> </a> </h2>
                    <p class="section__description">
                        <span class="section_price"><?php echo wp_kses_post($price); ?> </span>
                        <span class="section__description-inner"><?php echo wpestate_strip_excerpt_by_char(get_the_excerpt(),270,$prop_id);?></span>
                    </p>
                    
            </div>
            <div class="section__img">
                    
                
                    <div class="section__img-inner" style="background-image: url(<?php echo esc_url($preview[0]); ?>)">     
                       
                    </div>
                
                 <div class="section__expander">
                            
                            <ul class="section__facts">
                                    <?php 

                                    ?>
                                    <li class="section__facts-item">
                                            <h3 class="section__facts-title"><?php esc_html_e('category','wpresidence');?></h3>
                                            <span class="section__facts-detail"><?php echo wp_kses_post($property_category).' '.esc_html__('in','wpresidence').' '.wp_kses_post($property_action); ?></span>
                                    </li>
                                    <li class="section__facts-item">
                                            <h3 class="section__facts-title"><?php esc_html_e('location','wpresidence');?></h3>
                                            <span class="section__facts-detail"><?php echo wp_kses_post($property_city).', '.wp_kses_post($property_area);?></span>
                                    </li>
                                    <li class="section__facts-item">
                                        <span class="section__facts-detail"><?php echo intval($property_rooms).' '.esc_html__('Rooms','wpresidence');?></span>
                                    </li>
                                    <li class="section__facts-item">
                                        <span class="section__facts-detail"><?php echo intval($property_bathrooms).' '.esc_html__('Bathrooms','wpresidence');?></span>
                                    </li>
                                    <li class="section__facts-item">
                                        <span class="section__facts-detail"><?php echo esc_html__('Size','wpresidence').' '.trim($property_size);?></span>
                                    </li>

                            </ul>
                        </div>
            </div>
           
         
    </section><!--/ section --> 
<?php    

?>
