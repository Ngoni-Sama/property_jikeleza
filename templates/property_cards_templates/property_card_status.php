<div class="status-wrapper">
    <?php
    $property_action            =   get_the_terms($post->ID, 'property_action_category');  
    if(isset($property_action[0])){
        $property_action_term = $property_action[0]->name;
        print '<div class="action_tag_wrapper '.esc_attr($property_action_term).' ">'.wp_kses_post($property_action_term).'</div>';
    }                      
    print wpestate_return_property_status($post->ID,'unit');      ?> 
</div>