<?php
$property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '');
$property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');

if( $property_city!='' || $property_area!='' ){
    print '<div class="property_location_image"> 
        <span class="property_marker"></span>';
        
        if($property_area!=''){
            print wp_kses_post($property_area).', ';
        }
        
        if($property_city!=''){
            print wp_kses_post($property_city);
        }

    print '</div>';
}