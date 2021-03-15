<?php
get_header();

$wpestate_options        =   wpestate_page_details('');

$filtred        =   0;
$show_compare   =   1;
$compare_submit =   wpestate_get_template_link('compare_listings.php');


// get curency , currency position and no of items per page
$current_user = wp_get_current_user();
global $custom_post_type;
global $col_class;

$wpestate_currency           =   esc_html( wpresidence_get_option('wp_estate_currency_symbol','') );
$where_currency     =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol','') );
$prop_no            =   intval( wpresidence_get_option('wp_estate_prop_no','') );
$userID             =   $current_user->ID;
$user_option        =   'favorites'.$userID;
$curent_fav         =   get_option($user_option);

$wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
$prop_unit_class    =   '';
$align_class        =   '';
if($wpestate_prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}
$col_class=4;
if($wpestate_options['content_class']=='col-md-12'){
    $col_class=3;
}
$transient_appendix =   '_taxonomy_';

$taxonmy    = get_query_var('taxonomy');
$term       = get_query_var( 'term' );





$custom_post_type = 'estate_property';

if( $taxonomy == 'property_category_agent' || 
    $taxonomy == 'property_action_category_agent' || 
    $taxonomy == 'property_city_agent' || 
    $taxonomy == 'property_area_agent' ||
    $taxonomy == 'property_county_state_agent'){

    $custom_post_type = 'estate_agent';
}else if(        
    $taxonomy == 'category_agency' || 
    $taxonomy == 'action_category_agency' || 
    $taxonomy == 'city_agency' || 
    $taxonomy == 'area_agency' ||
    $taxonomy == 'county_state_agency'){
    
    $custom_post_type = 'estate_agency';
    
}else if(  $taxonomy == 'property_county_state_developer' || 
    $taxonomy == 'property_category_developer' || 
    $taxonomy == 'property_action_developer' || 
    $taxonomy == 'property_city_developer' ||
    $taxonomy == 'property_area_developer'){

    $custom_post_type = 'estate_developer';
    
}







$tax_array  = array(
                'taxonomy'  => $taxonmy,
                'field'     => 'slug',
                'terms'     => $term
                );
 
$mapargs = array(
            'post_type'  => 'estate_property',
            'nopaging'   => true,
            'tax_query'  => array(
                                  'relation' => 'AND',
                                  $tax_array
                               )
           );




$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$transient_appendix.=$taxonmy.'_'.$custom_post_type.'_'.$term.'_prop_'.$prop_no.'paged_'.$paged;

if($custom_post_type =='estate_agent' ||  $custom_post_type =='estate_agency' || $custom_post_type =='estate_developer'){
     $args = array(
                  'post_type'         => $custom_post_type,
                  'post_status'       => 'publish',
                  'paged'             => $paged,
                  'posts_per_page'    => $prop_no ,
                  'tax_query'  => array(
                       'relation' => 'AND',
                       $tax_array
                    )
                );	

    $prop_selection = new WP_Query($args);
    $counter = 0;
    $mapargs = array(
                  'post_type'         => 'estate_property',
                  'post_status'       => 'publish',
                  'paged'             => $paged,
                  'posts_per_page'    => $prop_no ,
                  'meta_key'          => 'prop_featured',
                  'orderby'           => 'meta_value',
                  'order'             => 'DESC',
                  
                );
   }else{

    $args = array(
                  'post_type'         => 'estate_property',
                  'post_status'       => 'publish',
                  'paged'             => $paged,
                  'posts_per_page'    => $prop_no ,
                  'meta_key'          => 'prop_featured',
                  'orderby'           => 'meta_value',
                  'order'             => 'DESC',
                  'tax_query'  => array(
                       'relation' => 'AND',
                       $tax_array
                    )
                );	

 
    $prop_selection = wpestate_return_filtered_by_order($args);

    $counter = 0;
    $mapargs=$args;
  
    
}




$property_list_type_status =    esc_html(wpresidence_get_option('wp_estate_property_list_type',''));
 

if($custom_post_type =='estate_agent' ||  $custom_post_type =='estate_agency' || $custom_post_type =='estate_developer'){
    include( locate_template('templates/normal_map_core.php') ); 
}else{
    if ( $property_list_type_status == 2 ){
        include( locate_template('templates/half_map_core.php'));
    }else{
        include( locate_template('templates/normal_map_core.php' ) ) ; 
    }
}



wp_reset_query();               
wp_reset_postdata();



if (wp_script_is( 'googlecode_regular', 'enqueued' )) {
    if($custom_post_type =='estate_property'){
        $mapargs                    =   $args; 
    }
    $max_pins                   =   intval( wpresidence_get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*$prop_no;
    $mapargs['fields']          =   'ids';
  
    
    $transient_appendix.='_maxpins'.$max_pins.'_offset_'.($paged-1)*$prop_no;
    $selected_pins  =   wpestate_listing_pins($transient_appendix,1,$mapargs,1);//call the new pins   
   
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
                array('markers2'          =>  $selected_pins,
                      'taxonomy'          =>  $taxonmy,
                      'term'              =>  $term));

}
get_footer(); 
?>