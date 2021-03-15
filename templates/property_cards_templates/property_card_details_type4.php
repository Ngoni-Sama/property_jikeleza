<?php
$property_size      =   wpestate_get_converted_measure( $post->ID, 'property_size' );
$property_bedrooms     =   get_post_meta($post->ID,'property_bedrooms',true);
$property_bathrooms =   get_post_meta($post->ID,'property_bathrooms',true);
$prop_id            =   $post->ID;  
?>


 <div class="property_listing_details">
    <?php get_template_part('templates/property_cards_templates/property_card_price'); ?>

    <?php 
        if($property_bedrooms!=''){
            print '<div class="inforoom_unit_type4">'.esc_html__('Bedrooms','wpresidence').'<span>'.esc_html($property_bedrooms).'</span></div>';
        }

        if($property_bathrooms!=''){
            print '<div class="infobath_unit_type4">'.esc_html__('Baths','wpresidence').'<span>'.esc_html($property_bathrooms).'</span></div>';
        }

        if($property_size!=''){
            print '<div class="infosize_unit_type4">'.esc_html__('Size','wpresidence').'<span>'.trim($property_size).'</span></div>';//escaped above
        }

      ?>
</div>

<div class="property_listing_details4_grid_view">
    <?php
    if($property_bedrooms!=''){
        print '<div class="infobath_unit_type4">'.esc_html($property_bedrooms).' '.esc_html__('Bedrooms','wpresidence').'</div>';
    }

    if($property_bathrooms!=''){
        print '<div class="infosize_unit_type4">'.esc_html($property_bathrooms).' '.esc_html__('Baths','wpresidence').'</div>';
    }

    if($property_size!=''){
        print '<div class="infosize_unit_type4">'.$property_size.'</div>';//escaped above
    }

    ?>
</div>

 <?php global $align_class;
         if ($align_class=='the_list_view') {?>
                <div class="listing_details the_list_view" style="display:block;">
                    <?php   
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
                    ?>
                </div>   
        
                <div class="listing_details half_map_list_view" >
                    <?php   
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),60,$post->ID);
                    ?>
                </div>   

                <div class="listing_details the_grid_view" style="display:none;">
                    <?php 
                        echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),110,$post->ID);
                    ?>
                </div>
            <?php
            }else{
            ?>
                <div class="listing_details the_grid_view">
                    <?php
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),120,$post->ID);
                    ?>
                </div>

                <div class="listing_details the_list_view">
                    <?php
                        echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
                    ?>
                </div>
            <?php } ?>   
        