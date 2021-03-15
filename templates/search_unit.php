<?php
global $custom_advanced_search;  
global $adv_search_what;
global $adv_search_how;
global $adv_search_label;
?>
<div class="search_unit_wrapper">
    <h4> <?php the_title(); ?> </h4>
    <a class="delete_search" data-searchid="<?php print intval($post->ID); ?>"><?php esc_html_e('delete search','wpresidence');?></a>
    <?php  
    $search_arguments=  get_post_meta($post->ID, 'search_arguments', true) ;
    $search_arguments_decoded= (array)json_decode($search_arguments,true);

    $meta_arguments=  get_post_meta($post->ID, 'meta_arguments', true) ;
    $meta_arguments = (array)json_decode($meta_arguments,true);
  
    print '<div class="search_param"><strong>'.esc_html__('Search Parameters: ','wpresidence').'</strong>';
    wpestate_show_search_params_new($meta_arguments,$search_arguments_decoded,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
    print '</div>';
  
    ?>
</div>