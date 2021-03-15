<div class="property_categories_type1_wrapper">
    <?php
    $property_category   =  get_the_term_list($post->ID, 'property_category', '', ', ', '') ;
    $property_action     =  get_the_term_list($post->ID, 'property_action_category', '', ', ', '');   
    ?>

    <?php print wp_kses_post($property_category).' '.esc_html__('in','wpresidence').' '.wp_kses_post($property_action);?>
</div>  