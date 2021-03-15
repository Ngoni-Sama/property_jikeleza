<?php
// Template Name: Properties list half
// Wp Estate Pack 
if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}
get_header();
$wpestate_options           =   wpestate_page_details($post->ID);
$filtred                    =   0;
$compare_submit             =   wpestate_get_template_link('compare_listings.php');
$current_user               =   wp_get_current_user();
$wpestate_currency          =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
$prop_no                    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
$userID                     =   $current_user->ID;
$user_option                =   'favorites'.intval($userID);
$curent_fav                 =   get_option($user_option);
$icons                      =   array();
$taxonomy                   =   'property_action_category';
$tax_terms                  =   get_terms($taxonomy);
$taxonomy_cat               =   'property_category';
$categories                 =   get_terms($taxonomy_cat);
$show_compare=1;
$wpestate_prop_unit          =   esc_html ( wpresidence_get_option('wp_estate_prop_unit','') );
$prop_unit_class    =   '';
if($wpestate_prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}
global $current_adv_filter_search_action;
global $current_adv_filter_search_category;
global $current_adv_filter_area;
global $current_adv_filter_city;
global $current_adv_filter_county_state;


$current_adv_filter_search_action       = get_post_meta ( $post->ID, 'adv_filter_search_action', true);
$current_adv_filter_search_category     = get_post_meta ( $post->ID, 'adv_filter_search_category', true);
$current_adv_filter_area                = get_post_meta ( $post->ID, 'current_adv_filter_area', true);
$current_adv_filter_city                = get_post_meta ( $post->ID, 'current_adv_filter_city', true);
$current_adv_filter_county_state        = get_post_meta ( $post->ID, 'current_adv_filter_county', true);

$show_featured_only                     = get_post_meta($post->ID, 'show_featured_only', true);
$show_filter_area                       = get_post_meta($post->ID, 'show_filter_area', true);



$area_array =   $city_array =   $action_array   =   $categ_array    ='';
$transient_appendix='';
/////////////////////////////////////////////////////////////////////////action


if (!empty($current_adv_filter_search_action) && $current_adv_filter_search_action[0]!='all'){
    $taxcateg_include   =   array();
    $tax_action_picked='';
    foreach($current_adv_filter_search_action as $key=>$value){
        $taxcateg_include[]=sanitize_title($value);
        $transient_appendix.='_'.sanitize_title($value);
           
        if($tax_action_picked==''){
            $tax_action_picked=$value;
        }else{
            $tax_action_picked=$tax_action_picked.','.$value;
        }
    }

    $categ_array=array(
         'taxonomy' => 'property_action_category',
         'field' => 'slug',
         'terms' => $taxcateg_include
    );
    
    $current_adv_filter_search_label= $current_adv_filter_search_action[0];
}else{
     $current_adv_filter_search_label=esc_html__('Types','wpresidence');
}
      


/////////////////////////////////////////////////////////////////////////category

if ( !empty($current_adv_filter_search_category) && $current_adv_filter_search_category[0]!='all' ){
    $taxaction_include   =   array();   
    $tax_categ_picked='';
    foreach( $current_adv_filter_search_category as $key=>$value){
        $taxaction_include[]=sanitize_title($value);
        $transient_appendix.='_'.sanitize_title($value);
        
        if($tax_categ_picked==''){
            $tax_categ_picked=$value;
        }else{
            $tax_categ_picked=$tax_categ_picked.','.$value;
        }
    }

    $action_array=array(
         'taxonomy' => 'property_category',
         'field' => 'slug',
         'terms' => $taxaction_include
    );
     $current_adv_filter_category_label=$current_adv_filter_search_category[0];
}else{
    $current_adv_filter_category_label=esc_html__('Categories','wpresidence');
}
/////////////////////////////////////////////////////////////////////////////

if ( !empty( $current_adv_filter_city ) && $current_adv_filter_city[0]!='all' ) {
    $taxaction_include   =   array();   
    $tax_city_picked='';
    foreach( $current_adv_filter_city as $key=>$value){
        $taxaction_include[]=sanitize_title($value);
        $transient_appendix.='_'.sanitize_title($value);
        if($tax_city_picked==''){
            $tax_city_picked=$value;
        }else{
            $tax_city_picked=$tax_city_picked.','.$value;
        }
    }
    
    $city_array = array(
        'taxonomy' => 'property_city',
        'field' => 'slug',
        'terms' => $taxaction_include
    );
    
    $current_adv_filter_city_label=$current_adv_filter_city[0];
}else{
    $current_adv_filter_city_label=esc_html__('Cities','wpresidence');
}
/////////////////////////////////////////////////////////////////////////////

if ( !empty( $current_adv_filter_area ) && $current_adv_filter_area[0]!='all' ) {
    $taxaction_include   =   array();   
    $taxa_area_picked='';
    foreach( $current_adv_filter_area as $key=>$value){
        $taxaction_include[]=sanitize_title($value);
        $transient_appendix.='_'.sanitize_title($value);
        if($taxa_area_picked==''){
            $taxa_area_picked=$value;
        }else{
            $taxa_area_picked=$taxa_area_picked.','.$value;
        }
    }
    
    $area_array = array(
        'taxonomy' => 'property_area',
        'field' => 'slug',
        'terms' => $taxaction_include
    );
    
    $current_adv_filter_area_label=$current_adv_filter_area[0];
}else{
     $current_adv_filter_area_label=esc_html__('Areas','wpresidence');
}
  
 /////////////////////////////////////////////////////////////////////////////

if ( !empty( $current_adv_filter_county_state ) && $current_adv_filter_county_state[0]!='all' ) {
    $taxaction_include   =   array();   
    $tax_city_picked='';
    foreach( $current_adv_filter_county_state as $key=>$value){
        $taxaction_include[]=sanitize_title($value);
        $transient_appendix.='_'.sanitize_title($value);
        if($tax_city_picked==''){
            $tax_city_picked=$value;
        }else{
            $tax_city_picked=$tax_city_picked.','.$value;
        }
    }
    
    $city_array = array(
        'taxonomy' => 'property_county_state',
        'field' => 'slug',
        'terms' => $taxaction_include
    );
    
    $current_adv_filter_county_state_label=$current_adv_filter_county_state[0];
}else{
    $current_adv_filter_county_state_label=esc_html__('States','wpresidence');
}

/////////////////////////////////////////////////////////////////////////////

$meta_query=array();                
if($show_featured_only=='yes'){
    $compare_array=array();
    $compare_array['key']        = 'prop_featured';
    $compare_array['value']      = 1;
    $compare_array['type']       = 'numeric';
    $compare_array['compare']    = '=';
    $meta_query[]                = $compare_array;
    $transient_appendix         .='_show_featured';
}
     
$order              =   get_post_meta($post->ID, 'listing_filter',true );
$meta_directions    =   'DESC';
$meta_order         =   'prop_featured';
$order_by           =   'meta_value_num';
switch ($order){
            case 1:
                $meta_order='property_price';
                $meta_directions='DESC';
                $order_by='meta_value_num';
                break;
            case 2:
                $meta_order='property_price';
                $meta_directions='ASC';
                $order_by='meta_value_num';
                break;
            case 3:
                $meta_order='';
                $meta_directions='DESC';
                $order_by='ID';
                break;
            case 4:
                $meta_order='';
                $meta_directions='ASC';
                $order_by='ID';
                break;
            case 5:
                $meta_order='property_bedrooms';
                $meta_directions='DESC';
                $order_by='meta_value_num';
                break;
            case 6:
                $meta_order='property_bedrooms';
                $meta_directions='ASC';
                $order_by='meta_value_num';
                break;
            case 7:
                $meta_order='property_bathrooms';
                $meta_directions='DESC';
                $order_by='meta_value_num';
                break;
            case 8:
                $meta_order='property_bathrooms';
                $meta_directions='ASC';
                $order_by='meta_value_num';
                break;
        }

$transient_appendix.='_'.$meta_order.'_'.$meta_directions;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if( is_front_page() ){
    $paged= (get_query_var('page')) ? get_query_var('page') : 1;
}
$transient_appendix.='_paged_'.$paged;             
if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
    $transient_appendix.='_'. ICL_LANGUAGE_CODE;
}
    
$args = array(
    'post_type'         => 'estate_property',
    'post_status'       => 'publish',
    'paged'             => $paged,
    'posts_per_page'    => $prop_no,
    'orderby'           => $order_by,
    'meta_key'          => $meta_order,
    'order'             => $meta_directions,
    'meta_query'        => $meta_query,
    'tax_query'         => array(
                               'relation' => 'AND',
                                $categ_array,
                                $action_array,
                                $city_array,
                                $area_array
                            )
);

if( $order==0 ){
    $transient_appendix.='_myorder';
}
$prop_selection=wpestate_request_transient_cache( 'wpestate_prop_list'.$transient_appendix);

if($prop_selection==false){
    if( $order==0 ){
       $prop_selection = wpestate_return_filtered_by_order($args);
    }else{
        $prop_selection = new WP_Query($args);
    }
    wpestate_set_transient_cache(  'wpestate_prop_list'.$transient_appendix, $prop_selection, 60*60*4 );
}             
                                
include( locate_template('templates/half_map_core.php') );

$skip_file=0;

if( (isset($current_adv_filter_search_action[0]) && $current_adv_filter_search_action[0]!='all' ) ||
    (isset($current_adv_filter_search_category[0]) && $current_adv_filter_search_category[0]!='all') ||
    (isset($current_adv_filter_area[0]) && $current_adv_filter_area[0]!='all') || 
    (isset($current_adv_filter_city[0]) && $current_adv_filter_city[0]!='all') ||
    (isset($current_adv_filter_county_state[0]) && $current_adv_filter_county_state[0]!='all')){
    $skip_file=1;
}


if (wp_script_is( 'googlecode_regular', 'enqueued' )) {
    
    $mapargs                    =   $args;   
    $max_pins                   =   intval( wpresidence_get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*$prop_no;
    $mapargs['fields']          =   'ids';
       
    $transient_appendix.='_half_map_maxpins_'.$max_pins.'_offset_'.($paged-1)*$prop_no;
    $selected_pins  =   wpestate_listing_pins($transient_appendix,1,$mapargs,1);//call the new pins  
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
                array('markers2'          =>  $selected_pins));
}
get_footer(); ?>