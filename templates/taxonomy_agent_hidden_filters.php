<?php
global $current_adv_filter_search_label;
global $current_adv_filter_category_label;
global $current_adv_filter_city_label;
global $current_adv_filter_area_label;
global $wpestate_prop_unit;

$current_name      =   '';
$current_slug      =   '';
$listings_list     =   '';
if( !is_tax() ){
    $show_filter_area  =   get_post_meta($post->ID, 'show_filter_area', true);
}
$current_adv_filter_search_meta     = 'Types';
$current_adv_filter_category_meta   = 'Categories';
$current_adv_filter_city_meta       = 'Cities';
$current_adv_filter_area_meta       = 'Areas';
$current_adv_filter_county_meta     = 'States';       
if( is_tax() ){
    $show_filter_area = 'yes';
    $current_adv_filter_search_label    =esc_html__('Types','wpresidence');
    $current_adv_filter_category_label  =esc_html__('Categories','wpresidence');
    $current_adv_filter_city_label      =esc_html__('Cities','wpresidence');
    $current_adv_filter_area_label      =esc_html__('Areas','wpresidence');
    $current_adv_filter_county_label    =esc_html__('States','wpresidence');
    
    $taxonmy                            = get_query_var('taxonomy');
    $term                               = single_cat_title('',false);
    
    
    
    if ($taxonmy == 'property_city_agent'){
        $current_adv_filter_city_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_city_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_area_agent'){
        $current_adv_filter_area_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_area_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_category_agent'){
        $current_adv_filter_category_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_category_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_action_category_agent'){
        $current_adv_filter_search_label    =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_search_meta     =   sanitize_title($term);
    }
     if ($taxonmy == 'property_county_state'){
        $current_adv_filter_county_label    =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_county_meta     =   sanitize_title($term);
    }
    
}
?>

<div data-toggle="dropdown" id="second_filter_action" class="hide" data-value="<?php print esc_attr( $current_adv_filter_search_meta);?>"><?php print esc_html($current_adv_filter_search_label);?></div>           
<div data-toggle="dropdown" id="second_filter_categ" class="hide" data-value="<?php  print esc_attr( $current_adv_filter_category_meta);?>"><?php print esc_html($current_adv_filter_category_label);?></div>           
<div data-toggle="dropdown" id="second_filter_cities" class="hide" data-value="<?php print esc_attr( $current_adv_filter_city_meta);?>"><?php print esc_html($current_adv_filter_city_label);?></div>           
<div data-toggle="dropdown" id="second_filter_areas"  class="hide" data-value="<?php print esc_attr( $current_adv_filter_area_meta);?>"><?php print esc_html($current_adv_filter_area_label);?></div>           
<div data-toggle="dropdown" id="second_filter_county"  class="hide" data-value="<?php print esc_attr( $current_adv_filter_county_meta);?>"><?php print esc_html($current_adv_filter_county_label);?></div>    