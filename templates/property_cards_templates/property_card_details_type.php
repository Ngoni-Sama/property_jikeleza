<?php

$property_rooms         =   get_post_meta($post->ID, 'property_bedrooms', true);
if($property_rooms!=''){
    $property_rooms =   floatval($property_rooms);
}

$property_bathrooms     =   get_post_meta($post->ID, 'property_bathrooms', true) ;
if($property_bathrooms!=''){
    $property_bathrooms =   floatval($property_bathrooms);
}

$property_size = wpestate_get_converted_measure( $post->ID, 'property_size' );
?>

<div class="property_listing_details">
    <?php 
        if($property_rooms!=''){
            print ' <span class="inforoom">'.esc_html($property_rooms).'</span>';
        }

        if($property_bathrooms!=''){
            print '<span class="infobath">'.esc_html($property_bathrooms).'</span>';
        }

        if($property_size!=''){
            print ' <span class="infosize">'.($property_size).'</span>';
        }

        echo '<a href="'.esc_url($link).'" target="'.esc_attr(wpresidence_get_option('wp_estate_unit_card_new_page','')).'"  class="unit_details_x">'.esc_html__('full info','wpresidence').'</a>';
    ?>
</div>