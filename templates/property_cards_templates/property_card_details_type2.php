<div class="property_listing_details">
    <?php
    $property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
    $property_rooms     =   get_post_meta($post->ID,'property_rooms',true);
    $property_bathrooms =   get_post_meta($post->ID,'property_bathrooms',true);
    $garage_no          =   get_post_meta($post->ID, 'property-garage', true) ;
    $prop_id            =   $post->ID;  
    ?>
    <?php 
        if($property_rooms!=''){
            print ' <span class="inforoom_unit_type2">'.esc_html($property_rooms).'</span>';
        }

        if($property_bathrooms!=''){
            print '<span class="infobath_unit_type2">'.esc_html($property_bathrooms).'</span>';
        }
        if ($garage_no != '') {
            print ' <span class="infogarage_unit_type2">'.esc_html($garage_no).'</span>';
        }
        if($property_size!=''){
            print ' <span class="infosize_unit_type2">'.$property_size.'</span>';//escaped above
        }

      ?>           
</div>