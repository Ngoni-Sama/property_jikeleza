<div class="property_address_type1_wrapper">
    <?php
    $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
    $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
    $property_address   =   get_post_meta($post->ID,'property_address',true);

    print '<i class="fas fa-map-marker-alt"></i>';
    if($property_address!=''){
        print '<span class="property_address_type1">'.esc_html($property_address).', </span>';
    }
    if($property_area!=''){
        print '<span class="property_area_type1">'.wp_kses_post($property_area).', </span>';
    }

    if($property_city!=''){
        print '<span class="property_city_type1">'.wp_kses_post($property_city).'</span>';
    }

    ?>
</div>